<?php

namespace App\Admin\Controllers\Coupon;

use App\Models\CouponsOffline;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CouponOfflineController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '券码列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CouponsOffline);
        $grid->model()->orderBy('updated_at', 'desc');
        $grid->model()->orderBy('id', 'desc');
        $grid->disableCreateButton();//禁用创建按钮
        $grid->disableActions();//禁用禁用行操作列
        $grid->disableRowSelector();//禁用行选择checkbox
        $grid->disableColumnSelector();//禁用行选择器
        $grid->column('id', __('Id'));
        $grid->column('relcoubat.name', __('批次名称'));
        $grid->column('code', __('券码'));
        $grid->column('is_use', __('使用状态'))->switch();
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));
        $grid->filter(function($filter){
            $filter->where(function ($query) {

                $query->whereHas('relcoubat', function ($query) {
                    $query->where('name', 'like', "%{$this->input}%");
                });

            }, '批次名称');
        });
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
        $show = new Show(CouponsOffline::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('coupon_batch_id', __('Coupon batch id'));
        $show->field('code', __('Code'));
        $show->field('is_use', __('Is use'));
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
        $form = new Form(new CouponsOffline);

        $form->number('coupon_batch_id', __('Coupon batch id'));
        $form->text('code', __('Code'));
        $form->switch('is_use', __('Is use'));

        return $form;
    }
}
