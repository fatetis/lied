<?php

namespace App\Admin\Controllers\Product;

use App\Models\ProductAttr;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class ProductAttrController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '产品规格';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ProductAttr());

        $grid->column('id', __('Id'));
        $grid->column('name', '名称')->modal('产品属性', function ($model) {
            $comments = $model->values()
                ->select(['id', 'name', 'sort', 'created_at', 'updated_at'])
                ->orderBy('sort', 'desc')
                ->get()
                ->toArray();
            return new Table(['ID', '名称', '排序', '创建时间', '更新时间'], $comments);
        });
        $grid->column('sort', '排序');
        $grid->column('created_at', '创建时间');
        $grid->column('updated_at', '更新时间');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(ProductAttr::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', '名称');
        $show->field('sort', '排序');
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '更新时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ProductAttr());

        $form->text('name', '名称');
        $form->number('sort', '排序');
        $form->hasMany('values', '产品规格值', function (Form\NestedForm $form) {
            $form->text('name', '名称');
            $form->number('sort', '排序');
        });
        return $form;
    }
}
