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
        'skus',
        'order@restrict',
        'seckill@restrict',
        'productAttr@restrict',
        'productAttrValueMap@restrict'
    ];

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

    public function attrs()
    {
        return $this->hasMany(ProductAttrMap::class, 'product_id')
            ->with([
                'values',
                'values.value',
                'attr'
            ])->orderByDesc('sort');
    }

    public function skus()
    {
        return $this->hasMany(ProductSku::class, 'product_id')->with(['stock', 'media']);
    }


}
