<?php

namespace App\Models;

class OrderChild extends BaseModel
{
    protected $table = 'order_child';
    protected $primaryKey = 'id';
    protected $guarded  = ['id'];

    public function product()
    {
        return $this->belongsTo(Users::class, 'user_id', 'id');
    }

}
