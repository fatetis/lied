<?php

namespace App\Models;

class CouponsOffline extends BaseModel
{
    protected $table = 'coupons_offline';
    protected $primaryKey = 'id';
    protected $guarded  = ['id'];

    public function relcoubat()
    {
        return $this->belongsTo(CouponsBatch::class, 'coupon_batch_id', 'id');
    }
}
