<?php

namespace App\Models;


class LogError extends BaseModel
{
    protected $table = 'log_error';
    protected $primaryKey = 'id';

    protected $guarded  = ['id'];

}
