<?php

namespace App\Models;

class Media extends BaseModel
{
    protected $table = 'media';
    protected $primaryKey = 'id';

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['link', 'size', 'file_ext', 'file_name', 'is_show', 'type'];
}
