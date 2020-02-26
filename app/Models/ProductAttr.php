<?php

namespace App\Models;

class ProductAttr extends BaseModel
{
    protected $table = 'product_attr';
    protected $primaryKey = 'id';
    protected $softCascade = [
//        'productAttrMap@restrict',
//        'productAttrValueMap@restrict'
    ];

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['name', 'sort'];

    public function values()
    {
        return $this->hasMany(ProductAttrValues::class, 'product_attr_id');
    }

}
