<?php

namespace App\Models;

class ProductSku extends BaseModel
{
    protected $table = 'product_sku';
    protected $primaryKey = 'id';

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'attr_key', 'media_id', 'price', 'cost_price', 'code'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
