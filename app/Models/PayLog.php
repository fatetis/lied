<?php

namespace App\Models;


class PayLog extends BaseModel
{
    protected $table = 'pay_log';
    protected $primaryKey = 'id';

    protected $guarded  = ['id'];

}
