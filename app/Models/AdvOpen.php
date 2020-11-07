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
    protected $fillable = [
       'adv_id',
       'region_open_id',
       'start_time',
       'end_time'
    ];

    public function adv()
    {
        return $this->belongsTo(Adv::class, 'adv_id', 'id');
    }

    public function regionopen()
    {
        return $this->belongsTo(RegionsOpen::class, 'region_open_id')->with('regions');
    }


}
