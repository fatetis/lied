<?php

namespace App\Models;

class UsersOauth extends BaseModel
{
    protected $table = 'users_oauth';
    protected $primaryKey = 'id';

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [];

}
