<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;

class Users extends User
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['name','password','mobile','register_ip'];

}
