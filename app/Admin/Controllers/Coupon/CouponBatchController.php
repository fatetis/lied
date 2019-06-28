<?php

namespace App\Admin\Controllers\Coupon;

use App\Models\CouponsBatch;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CouponBatchController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '线下券';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CouponsBatch);

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('num', __('Num'));
        $grid->column('coupon_limit_id', __('Coupon limit id'));
        $grid->column('created_id', __('Created id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));

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
        $show = new Show(CouponsBatch::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('num', __('Num'));
        $show->field('coupon_limit_id', __('Coupon limit id'));
        $show->field('created_id', __('Created id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CouponsBatch);

        $form->text('name', __('Name'));
        $form->number('num', __('Num'));
        $form->number('coupon_limit_id', __('Coupon limit id'));
        $form->number('created_id', __('Created id'));

        return $form;
    }
}
