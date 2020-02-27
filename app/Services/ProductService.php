<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductAttr;
use App\Models\ProductAttrMap;
use App\Models\ProductAttrValueMap;
use App\Models\ProductAttrValues;
use App\Models\ProductSku;
use App\Models\ProductSkuStock;
use Encore\Admin\Facades\Admin;
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

            if (empty($sku_data) || empty($product_id)) throw new \Exception('参数错误');

            $attr_key = array_column($sku_data, 'attr_key');
            if (count($attr_key) != count(array_filter($attr_key))) throw new \Exception('sku属性错误');

            DB::beginTransaction();

            $attr_result = $this->saveProductAttr($attr_key, $product_id);
            $sku_result = $this->saveProductSku($sku_data, $product_id);

            if ($attr_result !== true || $sku_result !== true) throw new \Exception($attr_result);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            elog("商品规格上传失败，产品id：{$product_id},商品规格数据：{$sku_data},第" . $exception->getLine() . '行:' . $exception->getMessage());
            DB::rollBack();
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
                $attr_map = ProductAttrMap::query()->updateOrCreate($insert_attr_map, $insert_attr_map);
                $index = count($value) - 1;
                collect($value)->map(function ($val) use ($attr_map, &$index, $product_id, $key) {
                    $insert_attr_map = [
                        'product_id' => $product_id,
                        'product_attr_map_id' => $attr_map['id'],
                        'product_attr_id' => $key,
                        'product_attr_value_id' => $val,
                        'sort' => $index,
                    ];
                    ProductAttrValueMap::query()->updateOrCreate($insert_attr_map, $insert_attr_map);
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
                    $product_attr_id_arr += ProductAttrValues::query()->whereIn('id', $product_attr_val_arr)->pluck('product_attr_id', 'id')->toArray();
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
                ->updateOrCreate([], [
                    'product_id' => $product_id,
                    'attr_key' => $key,
                    'media_id' => $sku['media_id'],
                    'price' => $sku['price'],
                    'cost_price' => $sku['cost_price'],
                    'code' => $sku['code'],
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
     * @param int $products_sku 产品skuid
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
            ->updateOrCreate([], [
                'sku_id' => $products_sku->id,
                'product_id' => $product_id,
                'quantity' => $sku['stock_num'],
                'warn_number' => $sku['warn_number'],
            ]);

    }

    public function getProductById($id, $with = [])
    {
        try {
            return Product::query()->with($with)->findOrFail($id);
        } catch (\Exception $exception) {
            abort(400, '产品不存在');
        }
//        $aa = ProductAttr::query()->where('product_id', $product_id)->with('values')->get();
//        dd($aa);
    }


}
