<?php

namespace App\Models;

class AdvOpen extends BaseModel
{
    protected $table = 'adv_open';
    protected $primaryKey = 'id';

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [];

    public function adv()
    {
        return $this->belongsTo(Adv::class, 'adv_id', 'id');
    }


}
