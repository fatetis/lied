<?php

namespace App\Models;

class CouponsDiscount extends BaseModel
{
    protected $table = 'coupons_discount';
    protected $primaryKey = 'id';
    protected $guarded  = ['id'];

    public function coupons()
    {
        return $this->belongsTo(Coupons::class,'coupon_id','id');
    }
}
