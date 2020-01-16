<?php

namespace App\Services;

use App\Models\ProductAttr;

class ProductAttrService extends BaseService {

    protected $table = ProductAttr::class;

    public function getProductAttrByLikeName($name)
    {
        return ProductAttr::query()->where("name", "like", "%{$name}%")->orderBy('sort', 'desc')->get();
    }

    public function createProductAttr($insert)
    {
        return ProductAttr::query()->create($insert);
    }

}
