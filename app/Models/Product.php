<?php

namespace App\Models;

class Product extends BaseModel
{
    protected $table = 'product';
    protected $primaryKey = 'id';
    /**
     * 级联软删除
     * @var array
     */
    protected $softCascade = [
        'sku',
        'order@restrict',
        'seckill@restrict',
//        'productAttr@restrict',
//        'productAttrValueMap@restrict'
    ];

    public function sku()
    {
        return $this->hasMany(ProductSku::class, 'product_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'id', 'product_id');
    }

    public function seckill()
    {
        return $this->belongsTo(ProductSeckill::class, 'id', 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id','id');
    }

}
