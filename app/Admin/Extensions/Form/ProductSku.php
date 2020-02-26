<?php
/**
 * Created by PhpStorm.
 * User: Windows7
 * Date: 2019/7/22 0022
 * Time: 17:10
 */

namespace App\Admin\Extensions\Form;

use App\Models\ProductAttr;
use App\Services\ProductAttrService;
use App\Services\ProductService;
use Encore\Admin\Form\Field;

class ProductSku extends Field
{
    protected $view = 'admin.form.prosku';
    protected $variables = [];

    protected static $css = [
    ];

    protected static $js = [
    ];

    public function render()
    {
//        $name = $this->formatName($this->column);
//        $attrData = ProductAttr::get([],['created_at' => 'desc'],[],['id','name']);

//        获取产品数据
        $product_id = request()->route()->product;
        $product_service = new ProductService();
        $product_attr_data = $product_service->getProduct($product_id, ['attrs', 'skus']);
        dd($product_attr_data);
//        属性选择数据
        $attr_data = ProductAttr::query()->orderBy('created_at', 'desc')->select('id', 'name')->get();
        $this->variables = ['attrData' => $attr_data, 'product_attr_data' => $product_attr_data];

        $this->script = <<<EOT


EOT;
        return parent::render();
    }
}
