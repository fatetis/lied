<?php

namespace App\Models;

class Article extends BaseModel
{
    protected $table = 'article';
    protected $primaryKey = 'id';
    /**
     * bu可以被批量赋值的属性.
     * @var array
     */
    protected $guarded  = ['id'];

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class,'category_id','id');
    }

}
