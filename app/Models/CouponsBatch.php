<?php

namespace App\Models;

class CouponsBatch extends BaseModel
{
    protected $table = 'coupons_batch';
    protected $primaryKey = 'id';
    protected $guarded  = ['id'];

    public function relcoupon()
    {
        return $this->belongsTo(Coupons::class,'coupon_id','id');
    }

    public function relcouponlimit()
    {
        return $this->belongsTo(CouponsLimit::class,'coupon_limit_id','id');
    }

}
