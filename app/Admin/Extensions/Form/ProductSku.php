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
        'vendor/store/self.js'
    ];

    public function render()
    {
//        $name = $this->formatName($this->column);
//        $attrData = ProductAttr::get([],['created_at' => 'desc'],[],['id','name']);

//        属性选择数据
        $attr_data = ProductAttr::query()->orderBy('sort', 'desc')->orderBy('created_at', 'desc')->select('id', 'name')->get();
//        获取产品数据
        $product_id = request()->route()->product;
        if (!empty($product_id)) {

            $product_service = new ProductService();
            $product_attr_data = $product_service->getProductById($product_id, ['attrs', 'skus']);
            if (!empty($product_attr_data)) {
                $media_id_arr = array_values(array_unique(array_column($product_attr_data['skus']->toArray(), 'media_id')));
            }
            $this->script = <<<EOT
        
        $(function(){
            addSkuDetail();
        })


EOT;
        }

        $this->variables = ['attrData' => $attr_data, 'product_attr_data' => $product_attr_data ?? [], 'media_id_arr' => $media_id_arr ?? [],];




        return parent::render();
    }
}
