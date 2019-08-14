<?php

namespace App\Models;

class ProductAttrValues extends BaseModel
{
    protected $table = 'product_attr_values';
    protected $primaryKey = 'id';

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['name', 'product_attr_id', 'sort'];

}
