<?php

namespace App\Models;

class OrderDelivery extends BaseModel
{
    protected $table = 'order_delivery';
    protected $primaryKey = 'id';
    protected $guarded  = ['id'];

    const STATUS_WAIT_RECEIPT = 0;

    const STATUS = [
        0 => '待揽件'
    ];

}
