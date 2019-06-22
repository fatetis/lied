<?php

namespace App\Models;

class Order extends BaseModel
{
    protected $table = 'order';
    protected $primaryKey = 'id';
    protected $guarded  = ['id'];
}
