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
//            $sku_data = jd('{"8-13":{"price":"1","stock_num":"2","code":null,"cost_price":"3","sold_num":"0","attr_key":"13-8","media_id":275},"2-13":{"price":"1","stock_num":"2","code":null,"cost_price":"3","sold_num":"0","attr_key":"13-2","media_id":275},"8-11":{"price":"1","stock_num":"2","code":null,"cost_price":"3","sold_num":"0","attr_key":"11-8","media_id":275},"2-11":{"price":"1","stock_num":"2","code":null,"cost_price":"3","sold_num":"0","attr_key":"11-2","media_id":275}}');
//            $product_id = 6;

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
            dd($exception->getFile(), $exception->getLine(), $exception->getMessage());
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
                    'sort_order' => $loop,
                ];
                $attr_map = ProductAttrMap::query()->updateOrCreate($insert_attr_map, $insert_attr_map);
                $index = count($value) - 1;
                collect($value)->map(function ($val) use ($attr_map, &$index, $product_id, $key) {
                    $insert_attr_map = [
                        'product_id' => $product_id,
                        'product_attr_map_id' => $attr_map['id'],
                        'product_attr_id' => $key,
                        'product_attr_value_id' => $val,
                        'sort_order' => $index,
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
     * @param int $product_id
     * @param array $products_sku
     * @param array $sku
     * Author: fatetis
     * Date:2020/1/15 001518:01
     */
    public function setSkuStock($product_id, $products_sku, $sku)
    {

        ProductSkuStock::query()
            ->where('product_id', $product_id)
            ->where('sku_id', $products_sku->id)
            ->updateOrCreate([], [
                'sku_id' => $products_sku->id,
                'product_id' => $product_id,
                'quantity' => $sku['stock_num'],
            ]);

    }


}
