<?php

namespace App\Models;

class Adv extends BaseModel
{
    protected $table = 'adv';
    protected $primaryKey = 'id';
    protected $softCascade = ['advopen@restrict'];//级联软删除

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [];


    public function advposition()
    {
        return $this->belongsTo(AdvPosition::class, 'position_id', 'id');
    }

    public function advopen()
    {
        return $this->hasMany(AdvOpen::class, 'adv_id', 'id');
    }

}
