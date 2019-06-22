<?php

namespace App\Models;

class Brand extends BaseModel
{
    protected $table = 'brand';
    protected $primaryKey = 'id';

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [];

}
