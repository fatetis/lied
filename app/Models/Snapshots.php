<?php

namespace App\Models;

class Snapshots extends BaseModel
{
    protected $table = 'snapshots';
    protected $primaryKey = 'id';
    protected $guarded  = ['id'];

    /**
     * 订单类型
     */
    const TYPE_ORDER = 0;
}
