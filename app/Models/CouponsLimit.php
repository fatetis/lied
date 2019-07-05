<?php

namespace App\Models;

class CouponsLimit extends BaseModel
{
    protected $table = 'coupons_limit';
    protected $primaryKey = 'id';
    protected $guarded  = ['id'];

    public function relbrand()
    {
        return $this->belongsTo(Brand::class,'brand_id','id');
    }

    public function relproduct()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }


}
