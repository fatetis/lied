<?php

namespace App\Services;

use App\Models\ProductAttrValues;

class ProductAttrValuesService extends BaseService {

    protected $table = ProductAttrValues::class;

    public function getProductAttrValueByLikeNameAndAttrId($attr_id, $name = '')
    {
        $sql = ProductAttrValues::query()->where('product_attr_id', $attr_id);
        if (!empty($name)) {
            $sql->where('name', 'like', "%{$name}%");
        }
        return $sql->orderBy('sort', 'desc')->get();
    }

    public function createProductAttrValue($insert)
    {
        return ProductAttrValues::query()->create($insert);
    }

}
