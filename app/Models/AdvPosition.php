<?php

namespace App\Models;

class AdvPosition extends BaseModel
{
    protected $table = 'adv_position';
    protected $primaryKey = 'id';
    protected $softCascade = ['adv@restrict'];//级联软删除
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [];



    public function adv()
    {
        return $this->hasMany(Adv::class, 'position_id', 'id');
    }

}
