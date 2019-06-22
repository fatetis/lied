<?php

namespace App\Models;

class Picture extends BaseModel
{
    protected $table = 'picture';
    protected $primaryKey = 'id';

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['link'];
}
