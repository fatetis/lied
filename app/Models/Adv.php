<?php

namespace App\Models;

class Adv extends BaseModel
{
    protected $table = 'adv';
    protected $primaryKey = 'id';

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [];


    public function setRegionCityIdAttribute($value)
    {
        $this->attributes['region_city_id'] = implode(',', $value);
    }

    public function getRegionCityIdAttribute($value)
    {
        if(!empty($value)){
            return array_filter(explode(',', $value));
        }
    }

    public function advPosition()
    {
        return $this->belongsTo(AdvPosition::class,'position_id','id');
    }

//    public function regions()
//    {
//        return $this->hasMany(Regions::class,'region_id','region_city_id');
//    }

}
