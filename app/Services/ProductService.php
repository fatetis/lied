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

    protected $created_id;

    protected $created_arr;

    /**
     * 保存产品数据
     * @param int $product_id
     * @param array $sku_data
     * @param array $picture
     * @return bool|string
     * Author: fatetis
     * Date:2020/1/15 001518:04
     */
    public function saveProduct($product_id, $sku_data, $picture)
    {
        try {

            if (empty($product_id)) throw new SelfException('参数错误');
            if (empty($picture)) throw new SelfException('商品图片不能为空');
            $this->created_arr = [];

            DB::transaction(function () use ($product_id, $sku_data, $picture) {

                $media_result = $this->dealProductMediaData($product_id, $picture);
                if ($media_result !== true)
                    throw new SelfException('banner图片上传失败' . $media_result);
                if (!empty($sku_data)) {
                    $attr_key = array_column($sku_data, 'attr_key');
                    if (count($attr_key) != count(array_filter($attr_key))) throw new SelfException('sku属性错误');
                    $attr_result = $this->saveProductAttr($attr_key, $product_id);
                    $sku_result = $this->saveProductSku($sku_data, $product_id);
                    $del_result = $this->delProInfo($product_id);
                    if ($attr_result !== true || $sku_result !== true || $del_result !== true)
                        throw new SelfException('产品SKU上传失败' . $media_result);
                }

            });

            return true;
        } catch (SelfException $selfException) {
            elog("商品规格上传失败" . $selfException->getMessage());
            return $selfException->getMessage();
        } catch (\Exception $exception) {
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
                ];
                $attr_map = ProductAttrMap::query()->updateOrCreate($insert_attr_map, array_merge($insert_attr_map, [
                    'sort' => $loop,
                ]));
                $this->created_arr['product_attr_map'][] = $attr_map['id'];
                $index = count($value) - 1;
                collect($value)->map(function ($val) use ($attr_map, &$index, $product_id, $key) {
                    $insert_attr_map = [
                        'product_id' => $product_id,
                        'product_attr_map_id' => $attr_map['id'],
                        'product_attr_id' => $key,
                        'product_attr_value_id' => $val,
                    ];
                    $attr_value_map = ProductAttrValueMap::query()->updateOrCreate($insert_attr_map, array_merge($insert_attr_map, [
                        'sort' => $index,
                    ]));
                    $this->created_arr['product_attr_value_map'][] = $attr_value_map['id'];
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
                ->where([
                    'product_id' => $product_id,
                    'attr_key' => (string)$key,
                ])
                ->updateOrCreate([
                    'product_id' => $product_id,
                    'attr_key' => $key,
                    'media_id' => $sku['media_id'],
                    'price' => $sku['price'],
                    'cost_price' => $sku['cost_price'],
                    'code' => $sku['code'],
                ]);
            $this->created_arr['product_sku'][] = $products_sku['id'];
            //更新库存
            $this->setSkuStock($product_id, $products_sku, $sku);

            #TODO 根据订单关联，更新销量
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
        $product_sku_stock = ProductSkuStock::query()
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
        $this->created_arr['product_sku_stock'][] = $product_sku_stock['id'];
        return $product_sku_stock;
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
        $index = count($data) - 1;
        collect($data)->map(function ($value) use ($product_id, &$index) {
            $this->saveProductMedia($product_id, $value, $index);
            $index--;
        });
        return true;
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
        $product_medias = ProductMedias::query()->updateOrCreate([
            'product_id' => $product_id,
            'media_id' => $media_id,
        ], [
            'product_id' => $product_id,
            'media_id' => $media_id,
            'sort' => $sort,
        ]);
        $this->created_arr['product_medias'][] = $product_medias['id'];
        return $product_medias;
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
        // 产品与规格关系表
        ProductAttrMap::query()
            ->where('product_id', $product_id)
            ->whereNotIn('id', $this->created_arr['product_attr_map'] ?? [])
            ->where('deleted_at')
            ->delete();
        // 产品与产品规格值关系表
        ProductAttrValueMap::query()
            ->where('product_id', $product_id)
            ->whereNotIn('id', $this->created_arr['product_attr_value_map'] ?? [])
            ->where('deleted_at')
            ->delete();
        // 删除sku表
        ProductSku::query()
            ->where('product_id', $product_id)
            ->whereNotIn('id', $this->created_arr['product_sku'] ?? [])
            ->where('deleted_at')
            ->delete();
        // 删除库存表
        ProductSkuStock::query()
            ->where('product_id', $product_id)
            ->whereNotIn('id', $this->created_arr['product_sku_stock'] ?? [])
            ->where('deleted_at')
            ->delete();
        // 删除产品banner图
        ProductMedias::query()
            ->where('product_id', $product_id)
            ->whereNotIn('id', $this->created_arr['product_medias'] ?? [])
            ->where('deleted_at')
            ->delete();
        return true;
    }

    public function restoreProInfo($product_id, $time)
    {
        DB::transaction(function () use ($product_id, $time) {
            // 产品与规格关系表
            ProductAttrMap::query()->where('product_id', $product_id)->where('deleted_at', '>=', $time)->restore();
            // 产品与产品规格值关系表
            ProductAttrValueMap::query()->where('product_id', $product_id)->where('deleted_at', '>=', $time)->restore();
            // 删除sku表
            ProductSku::query()->where([['product_id', '=', $product_id], ['deleted_at', '>=', $time]])->restore();
            // 修改库存表
            ProductSkuStock::query()->where('product_id', $product_id)->where('deleted_at', '>=', $time)->restore();
        });
        return true;
    }



}
