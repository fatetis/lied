<?php

namespace App\Models;

class Order extends BaseModel
{
    protected $table = 'order';
    protected $primaryKey = 'id';
    protected $guarded  = ['id'];

    const ORDER_TYPE_ORDINARY = 0; // 普通订单类型

    const ORDER_TYPE = [
        0 => '普通订单'
    ];

    public function orderchild()
    {
        return $this->hasMany(OrderChild::class, 'order_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
}
