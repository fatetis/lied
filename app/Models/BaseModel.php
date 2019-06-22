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
     * 获取单图上传的数据
     * @param $value
     * @return mixed
     */
    public function getThumbAttribute($value)
    {
        if(!empty($value)){
            $result = Picture::find($value);
            return $result['link'];
        }
    }

    /**
     * 设置单图上传的保存数据
     * @param $value
     * @return mixed
     */
    public function setThumbAttribute($value)
    {
        if(!empty($value)){
            $result = Picture::create(['link' => $value]);
            $this->attributes['thumb'] = $result->id;
        }else{
            Picture::destroy($this->original['thumb']);
            $this->attributes['thumb'] = $value ?? 0;
        }
    }

    /**
     * 获取多图上传的数据
     * @param $value
     * @return mixed
     */
    public function getPictureAttribute($value)
    {
        if(!empty($value)){
            $pictureIdArr = array_filter(explode(',',$value));
            return Picture::whereIn('id',$pictureIdArr)->orderBy('created_at','asc')->pluck('link');
        }
    }

    /**
     * 设置多图上传的保存数据
     * @param $value
     * @return mixed
     */
    public function setPictureAttribute($value)
    {
        if(is_array($value)){
            if (request()->has('_file_del_')) {
                $arr = Picture::whereIn('link',$value)->pluck('id')->toArray();
                $result = explode(',',$this->original['picture']);
                $result = array_diff($result,$arr);
                Picture::destroy($result);
            }else{
                foreach ($value as $picture){
                    $result = Picture::firstOrCreate(['link' => $picture]);
                    $arr[] = $result->id;
                }
            }
            $this->attributes['picture'] = implode(',',$arr);
        }
    }

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
