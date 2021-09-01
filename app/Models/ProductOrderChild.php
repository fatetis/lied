<?php

namespace App\Models;

class ProductOrderChild extends BaseModel
{
    protected $table = 'product_order_child';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Users::class, 'user_id', 'id');
    }

    public function orderdelivery()
    {
        return $this->hasOne(OrderDelivery::class, 'id', 'delivery_id');
    }

}
