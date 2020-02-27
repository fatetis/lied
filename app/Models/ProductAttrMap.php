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

    public function attr()
    {
        return $this->belongsTo(ProductAttr::class, 'product_attr_id');
    }

    public function values()
    {
        return $this->hasMany(ProductAttrValueMap::class, 'product_attr_map_id', 'id')
            ->orderByDesc('sort');
    }

}
