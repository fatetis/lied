<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class ProductCategory extends BaseModel
{

    use ModelTree, AdminBuilder;

    protected $table = 'product_category';
    protected $primaryKey = 'id';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setParentColumn('pid');
        $this->setOrderColumn('sort');
        $this->setTitleColumn('name');
    }

    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [];


}
