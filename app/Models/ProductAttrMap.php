<?php

namespace App\Models;

class ProductAttrMap extends BaseModel
{
    protected $table = 'product_attr_map';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $softCascade = [
//        'productAttrValueMap@restrict'
    ];


}
