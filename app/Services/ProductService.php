<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductAttr;
use App\Models\ProductAttrMap;
use App\Models\ProductAttrValueMap;
use App\Models\ProductAttrValues;
use Encore\Admin\Facades\Admin;

class ProductService extends BaseService {

    protected $table = Product::class;

    protected $createdId;

    public function saveProduct()
    {
        $sku_data = jd('{"8-13":{"price":"1","stock_num":"2","code":null,"cost_price":"3","sold_num":"0","attr_key":"13-8","media_id":null},"2-13":{"price":"1","stock_num":"2","code":null,"cost_price":"3","sold_num":"0","attr_key":"13-2","media_id":null},"8-11":{"price":"1","stock_num":"2","code":null,"cost_price":"3","sold_num":"0","attr_key":"11-8","media_id":null},"2-11":{"price":"1","stock_num":"2","code":null,"cost_price":"3","sold_num":"0","attr_key":"11-2","media_id":null}}');
        $product_id = 6;
        dd($sku_data);
        empty($sku_data) ?: $this->saveProductAttr($sku_data, $product_id);

    }

    public function saveProductSku()
    {

    }

    public function saveProductAttr($sku_data, $product_id)
    {
        $created_id = Admin::user()->id;
        $this->dealAttrValueData();
        collect($sku_data)->map(function ($value, $key) use ($created_id, $product_id) {
            $product_attr_val_arr = explode('-', $key);
            $product_attr_id_arr = ProductAttrValues::query()->whereIn('id', $product_attr_val_arr)->pluck('product_attr_id', 'id')->toArray();
            $index = 0;
            collect($product_attr_val_arr)->map(function ($val) use ($product_attr_id_arr, $created_id, $product_id, &$index, $value) {
                $insert = [
                    'product_id' => $product_id,
                    'product_attr_id' => $product_attr_id_arr[$val],
                    'sort_order' => $index,
                ];
                $attr_map = ProductAttrMap::query()->updateOrCreate($insert, $insert);
                $insertVal = array_merge($insert, [
                    'product_attr_map_id' => $attr_map['id'],
                    'product_attr_value_id' => $val,
                ]);
                ProductAttrValueMap::query()->updateOrCreate($insertVal, $insertVal);
                $index++;
            });
        });
    }

    public function dealAttrValueData()
    {

    }



}
