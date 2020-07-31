<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class Regions extends BaseModel
{
    use ModelTree, AdminBuilder;
    protected $table = 'regions';
    protected $primaryKey = 'region_id';

    /**
     * 省份等级
     */
    const GRADE_PROVINCE = 1;
    /**
     * 城市等级
     */
    const GRADE_CITY = 2;
    /**
     * 区等级
     */
    const GRADE_AREA = 3;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setParentColumn('parent_id');
        $this->setOrderColumn('sort');
        $this->setTitleColumn('region_name');
    }

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [];

    public function getRegionNameAttribute($value)
    {
        $val = mb_substr($value,-1,1,'utf8');
        if($val == '市') return mb_substr($value,0,-1,'utf8');
        return $value;
    }




}
