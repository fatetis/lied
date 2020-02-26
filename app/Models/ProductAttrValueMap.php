<?php

namespace App\Models;

class ProductAttrValueMap extends BaseModel
{
    protected $table = 'product_attr_value_map';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];


    public function value()
    {
        return $this->belongsTo(ProductAttrValues::class, 'product_attr_value_id');
    }

}
