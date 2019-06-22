<?php

namespace App\Models;

class Coupons extends BaseModel
{
    protected $table = 'coupons';
    protected $primaryKey = 'id';
    protected $softCascade = ['couponsDiscount','couponsPrice'];//级联软删除

    public function reldiscount()
    {
        return $this->hasMany(CouponsDiscount::class, 'coupon_id', 'id');
    }

    public function relprice()
    {
        return $this->hasMany(CouponsPrice::class, 'coupon_id', 'id');
    }

    public function rellimit()
    {
        return $this->hasMany(CouponsLimit::class, 'coupon_id', 'id');
    }

}
