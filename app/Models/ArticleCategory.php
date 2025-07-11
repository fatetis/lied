<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class ArticleCategory extends BaseModel
{

    use ModelTree, AdminBuilder;

    protected $table = 'article_category';
    protected $primaryKey = 'id';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setParentColumn('pid');
        $this->setOrderColumn('sort_order');
        $this->setTitleColumn('name');
    }

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [];

}
