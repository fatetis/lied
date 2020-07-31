<?php

namespace App\Models;


class RegionsOpen extends BaseModel
{
    protected $table = 'regions_open';
    protected $primaryKey = 'id';

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [
    ];

    public function regions()
    {
        return $this->belongsTo(Regions::class, 'region_id', 'region_id');
    }

}
