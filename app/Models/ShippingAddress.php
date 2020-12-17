<?php

namespace App\Models;

class ShippingAddress extends BaseModel
{
    protected $table = 'shipping_address';
    protected $primaryKey = 'id';
    protected $guarded  = ['id'];

}
