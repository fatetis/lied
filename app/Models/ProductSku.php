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
    protected $fillable = ['sku_category_id','thumb','attr_price','product_number'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
