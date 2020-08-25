<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class BaseModel extends Model
{
    use SoftDeletes,SoftCascadeTrait;

//    protected $dateFormat = 'U';

}
