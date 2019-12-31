<?php

namespace App\Services;

use App\Models\Product;

class ProductService extends BaseService {

    protected $table = Product::class;

    protected $createdId;

    public function __construct()
    {
        $this->createdId = getAdminUserId();
    }

    public function saveProduct()
    {
        $skuData = jd('{"8-13":{"price":"1","stock_num":"2","code":null,"cost_price":"3","sold_num":"0","attr_key":"13-8","media_id":null},"2-13":{"price":"1","stock_num":"2","code":null,"cost_price":"3","sold_num":"0","attr_key":"13-2","media_id":null},"8-11":{"price":"1","stock_num":"2","code":null,"cost_price":"3","sold_num":"0","attr_key":"11-8","media_id":null},"2-11":{"price":"1","stock_num":"2","code":null,"cost_price":"3","sold_num":"0","attr_key":"11-2","media_id":null}}');
        $productId = 6;
        $this->saveProductAttr($skuData, $productId);

    }

    public function saveProductSku()
    {

    }

    public function saveProductAttr($skuData, $productId)
    {

        collect($skuData)->map(function ($value, $key) {
            $aa = ProductAttrValuesService::query()->whereIn('id', explode('-', $key))->pluck('product_attr_id', 'id')->toArray();
        });

    }



}
