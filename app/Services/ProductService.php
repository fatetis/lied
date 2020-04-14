<?php

namespace App\Services;

use App\Exceptions\SelfException;
use App\Models\Product;
use App\Models\ProductAttrMap;
use App\Models\ProductAttrValueMap;
use App\Models\ProductAttrValues;
use App\Models\ProductMedias;
use App\Models\ProductSku;
use App\Models\ProductSkuStock;
use Illuminate\Support\Facades\DB;

class ProductService extends BaseService {

    protected $table = Product::class;

    protected $createdId;

    /**
     * 保存产品数据
     * @param array $sku_data
     * @param int $product_id
     * @return boolean bool|string
     * Author: fatetis
     * Date:2020/1/15 001518:04
     */
    public function saveProduct($sku_data, $product_id)
    {
        try {
//            $sku_data = jd('{"8-13":{"price":"1","stock_num":"2","code":null,"cost_price":"3","sold_num":"0","attr_key":"13-8","media_id":null},"2-13":{"price":"1","stock_num":"2","code":null,"cost_price":"3","sold_num":"0","attr_key":"13-2","media_id":null},"8-11":{"price":"1","stock_num":"2","code":null,"cost_price":"3","sold_num":"0","attr_key":"11-8","media_id":null},"2-11":{"price":"1","stock_num":"2","code":null,"cost_price":"3","sold_num":"0","attr_key":"11-2","media_id":null}}');
//            $product_id = 6;

            if (empty($product_id)) throw new SelfException('参数错误');
            if (empty($sku_data)) return true;
            $attr_key = array_column($sku_data, 'attr_key');
            if (count($attr_key) != count(array_filter($attr_key))) throw new SelfException('sku属性错误');

            // 重置商品信息
            $del_result = $this->delProInfo($product_id);
            if ($del_result !== true) throw new SelfException('商品信息重置失败');

            DB::beginTransaction();
            $attr_result = $this->saveProductAttr($attr_key, $product_id);
            $sku_result = $this->saveProductSku($sku_data, $product_id);
            if ($attr_result !== true || $sku_result !== true) throw new SelfException($attr_result . ',after:' . $sku_result);
            DB::commit();

            return true;
        } catch (SelfException $selfException) {
            DB::rollBack();
            return $selfException->getMessage();
        } catch (\Exception $exception) {
            DB::rollBack();
            elog("商品规格上传失败，产品id：{$product_id},商品规格数据：" . je($sku_data) . ",第" . $exception->getLine() . '行:' . $exception->getMessage());
            return $exception->getMessage();
        }

    }


    /**
     * 保存属性数据
     * @param array $attr_key
     * @param int $product_id
     * @return boolean bool|string
     * Author: fatetis
     * Date:2020/1/15 001518:02
     */
    public function saveProductAttr($attr_key, $product_id)
    {
        try {
            $product_attr_id_arr = $this->dealAttrValueData($attr_key);
            $loop = count($product_attr_id_arr) - 1;

            collect($product_attr_id_arr)->map(function ($value, $key) use ($product_attr_id_arr, $product_id, &$loop) {
                $insert_attr_map = [
                    'product_id' => $product_id,
                    'product_attr_id' => $key,
                    'sort' => $loop,
                ];
                $attr_map = ProductAttrMap::query()->withTrashed()->updateOrCreate($insert_attr_map, array_merge($insert_attr_map, [
                    'deleted_at' => null,
                ]));
                $index = count($value) - 1;
                collect($value)->map(function ($val) use ($attr_map, &$index, $product_id, $key) {
                    $insert_attr_map = [
                        'product_id' => $product_id,
                        'product_attr_map_id' => $attr_map['id'],
                        'product_attr_id' => $key,
                        'product_attr_value_id' => $val,
                        'sort' => $index,
                    ];
                    ProductAttrValueMap::query()->withTrashed()->updateOrCreate($insert_attr_map, array_merge($insert_attr_map, [
                        'deleted_at' => null,
                    ]));
                    $index--;
                });
                $loop--;
            });
            return true;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

    }

    /**
     * 处理attr_key数据
     * @param array $attr_key
     * @return array
     * Author: fatetis
     * Date:2020/1/15 001518:02
     */
    public function dealAttrValueData($attr_key)
    {
        $arr = [];
        $product_attr_id_arr = [];
        foreach ($attr_key as $key => $value) {
            $product_attr_val_arr = explode('-', $value);
            foreach ($product_attr_val_arr as $k => $val) {
                if (!isset($product_attr_id_arr[$val])) {
                    $result = ProductAttrValues::query()->whereIn('id', $product_attr_val_arr)->pluck('product_attr_id', 'id')->toArray();
                    $product_attr_id_arr += $result;

                }
                if (!isset($arr[$product_attr_id_arr[$val]]) || !in_array($val, $arr[$product_attr_id_arr[$val]])) {
                    $arr[$product_attr_id_arr[$val]][] = $val;
                }
            }
        }

        return $arr;
    }

    /**
     * 保存sku数据
     * @param array $sku_data
     * @param int $product_id
     * @return boolean bool
     * Author: fatetis
     * Date:2020/1/15 001518:01
     */
    public function saveProductSku($sku_data, $product_id)
    {
        collect($sku_data)->filter(function ($item) {
            return is_array($item);
        })->map(function ($sku, $key) use ($product_id) {
            //更新或创建
            $products_sku = ProductSku::query()
                ->where('product_id', $product_id)
                ->where('attr_key', $key)
                ->withTrashed()
                ->updateOrCreate([
                    'product_id' => $product_id,
                    'attr_key' => $key,
                ], [
                    'product_id' => $product_id,
                    'attr_key' => $key,
                    'media_id' => $sku['media_id'],
                    'price' => $sku['price'],
                    'cost_price' => $sku['cost_price'],
                    'code' => $sku['code'],
                    'deleted_at' => null,
                ]);
            //更新库存
            $this->setSkuStock($product_id, $products_sku, $sku);

            //TODO 根据订单关联，更新销量
        });
        return true;
    }


    /**
     * 保存sku库存
     * @param int $product_id 产品id
     * @param object $products_sku 产品skuid
     * @param array $sku sku基础数据
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * Author: fatetis
     * Date:2020/2/26 002616:13
     */
    public function setSkuStock($product_id, $products_sku, $sku)
    {
        return ProductSkuStock::query()
            ->where('product_id', $product_id)
            ->where('sku_id', $products_sku->id)
            ->withTrashed()
            ->updateOrCreate([
                'product_id' => $product_id,
                'sku_id' => $products_sku->id,
            ], [
                'sku_id' => $products_sku->id,
                'product_id' => $product_id,
                'quantity' => $sku['stock_num'],
                'warn_number' => $sku['warn_number'],
                'deleted_at' => null
            ]);

    }

    /**
     * 获取一条商品信息
     * @param int $id 主键id
     * @param array $with 关联的model表
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     * Author: fatetis
     * Date:2020/2/28 002816:02
     */
    public function getProductById($id, $with = [])
    {
        try {
            return Product::query()->with($with)->findOrFail($id);
        } catch (\Exception $exception) {
            return abort(400, '产品不存在');
        }
    }

    /**
     * 处理商品图片的数据
     * @param int $product_id 产品id
     * @param array $data 图片media表主键id数据
     * @return bool|string
     * Author: fatetis
     * Date:2020/2/28 002816:03
     */
    public function dealProductMediaData($product_id, $data)
    {
        try {
            $index = count($data) - 1;
            collect($data)->map(function ($value) use ($product_id, &$index) {
                $this->saveProductMedia($product_id, $value, $index);
                $index--;
            });
            return true;
        } catch (\Exception $exception) {
            elog("商品sku缩略图上传失败，产品id：{$product_id},商品规格数据：" . je($data) . ",第" . $exception->getLine() . '行:' . $exception->getMessage());
            return $exception->getMessage();
        }

    }

    /**
     * 保存product_media表数据
     * @param int $product_id 产品id
     * @param int $media_id media表id
     * @param int $sort 排序值
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * Author: fatetis
     * Date:2020/2/28 002816:04
     */
    public function saveProductMedia($product_id, $media_id, $sort)
    {
        ProductMedias::query()->where('product_id', $product_id)->delete();
        return ProductMedias::query()->updateOrCreate([
            'product_id' => $product_id,
            'media_id' => $media_id,
        ], [
            'product_id' => $product_id,
            'media_id' => $media_id,
            'sort' => $sort,
        ]);
    }

    /**
     * 获取productMedia表数据
     * @param int $product_id 产品id
     * @return array|null
     * Author: fatetis
     * Date:2020/2/28 002816:05
     */
    public function getProductMedia($product_id)
    {
        if (empty($product_id)) {
            return null;
        }
        return ProductMedias::query()->where('product_id', $product_id)->orderByDesc('sort')->pluck('media_id')->toArray();
    }

    /**
     * 删除原来sku和sku_stock数据
     * @param int $product_id 产品id
     * Author: fatetis
     * Date:2020/2/28 002817:09
     */
    public function delSkuAndSkuStock($product_id)
    {
        //删除sku表
        ProductSku::query()->where('product_id', $product_id)->delete();
        //修改库存表
        ProductSkuStock::query()->where('product_id', $product_id)->delete();

    }

    public function delProInfo($product_id)
    {
        DB::transaction(function () use ($product_id) {
            // 产品与规格关系表
            ProductAttrMap::query()->where('product_id', $product_id)->delete();
            // 产品与产品规格值关系表
            ProductAttrValueMap::query()->where('product_id', $product_id)->delete();
            // 删除sku表
            ProductSku::query()->where('product_id', $product_id)->delete();
            // 修改库存表
            ProductSkuStock::query()->where('product_id', $product_id)->delete();
        });
        return true;
    }

}
