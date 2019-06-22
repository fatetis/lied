<?php

namespace App\Models;

class Artical extends BaseModel
{
    protected $table = 'artical';
    protected $primaryKey = 'id';
    /**
     * bu可以被批量赋值的属性.
     * @var array
     */
    protected $guarded  = ['id'];

    public function category()
    {
        return $this->belongsTo(ArticalCategory::class,'category_id','id');
    }

}
