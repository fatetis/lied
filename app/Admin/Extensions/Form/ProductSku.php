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
        $name = $this->formatName($this->column);
//        $attrData = ProductAttr::get([],['created_at' => 'desc'],[],['id','name']);
        $attrData = ProductAttr::query()->orderBy('created_at', 'desc')->select('id', 'name')->get();
        $this->variables = ['attrData' => $attrData];

        $this->script = <<<EOT


EOT;
        return parent::render();
    }
}
