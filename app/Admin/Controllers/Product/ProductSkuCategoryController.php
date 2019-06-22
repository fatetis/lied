<?php

namespace App\Admin\Controllers\Product;

use App\Models\ProductSkuCategory;
use App\Http\Controllers\Controller;
use Encore\Admin\Form;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\ModelForm;

class ProductSkuCategoryController extends Controller
{

    use ModelForm;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return Admin::content(function (Content $content) {
            $content->header('产品规格分类');
            $content->body(ProductSkuCategory::tree());
        });
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ProductSkuCategory);
        $form->select('pid', trans('admin.parent_id'))->options(ProductSkuCategory::selectOptions());
        $form->text('name', '规格名称')->rules('required')->rules('max:5',[
            'max' => '最多只能输入5个字'
        ]);
        $form->number('sort_order', '产品排序')->value(99);
        return $form;
    }
}
