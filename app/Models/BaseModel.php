<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class BaseModel extends Model
{
    use SoftDeletes,SoftCascadeTrait;

//    protected $dateFormat = 'U';


    /**
     * 反转义字段输出
     * @param $value
     * @return string
     */
    public function getDescriptionAttribute($value)
    {
        if(!empty($value)){
            $result = htmlspecialchars_decode($value);
            return $result;
        }
    }

    /**
     * 转义字段保存
     * @param $value
     */
    public function setDescriptionAttribute($value)
    {
        if(!empty($value)){
            $result = htmlspecialchars($value);
            $this->attributes['description'] = $result;
        }
    }

    /**
     * 反转义字段输出
     * @param $value
     * @return string
     */
    public function getContentAttribute($value)
    {
        if(!empty($value)){
            $result = htmlspecialchars_decode($value);
            return $result;
        }
    }

    /**
     * 转义字段保存
     * @param $value
     */
    public function setContentAttribute($value)
    {
        if(!empty($value)){
            $result = htmlspecialchars($value);
            $this->attributes['content'] = $result;
        }
    }

}
