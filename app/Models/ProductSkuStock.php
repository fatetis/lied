<?php

namespace App\Models;

class ProductSkuStock extends BaseModel
{
    protected $table = 'product_sku_stock';
    protected $primaryKey = 'id';

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'sku_id', 'quantity', 'warn_number'];

}
