<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class ProductSkuCategory extends BaseModel
{
    use ModelTree, AdminBuilder;

    protected $table = 'product_sku_category';
    protected $primaryKey = 'id';
    protected $softCascade = ['productSku@restrict'];//级联软删除
    protected $fillable = [];//准予ORM赋值的字段

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setParentColumn('pid');
        $this->setOrderColumn('sort_order');
        $this->setTitleColumn('name');
    }

    public function productSku()
    {
        return $this->hasMany(ProductSku::class,'sku_id');
    }


}
