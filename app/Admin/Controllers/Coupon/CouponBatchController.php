<?php

namespace App\Admin\Controllers\Coupon;

use App\Models\Coupons;
use App\Models\CouponsBatch;
use App\Models\CouponsLimit;
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
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CouponsBatch);

        $grid->actions(function ($actions) {
            $actions->disableView();
            $route = route('downLoadExcel',1);
            $actions->prepend('<a href="'.$route.'"><i class="fa fa-download"></i></a>');
        });

        $grid->column('id', __('Id'));
        $grid->column('name', __('名称'))->editable();
        $grid->column('relcoupon.name', __('优惠券名称'));
        $grid->column('coupon_limit_id', __('限领信息(商家名称-产品名称)'))->display(function ($id){
            $couponsLimit = CouponsLimit::with('relbrand')->with('relproduct')->find($id);
            if ($couponsLimit) {
                return $couponsLimit->relbrand['name'].'-'.$couponsLimit->relproduct['name'];
            }
        })->limit(146);
        $grid->column('num', __('数量'))->editable();
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));

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

        $form->text('name', '批次名称');
        $form->number('num', '数量');

        $form->select('coupon_id','优惠券名称')->options(function ($id) {
            $coupons = Coupons::find($id);
            if ($coupons) {
                return [$coupons->id => $coupons->name];
            }
        })->ajax(route('selectCoupon'))->load('coupon_limit_id', route('loadCouponLimit'))->rules('required');

        $form->select('coupon_limit_id','限领券名称')->options(function ($id) {
            $couponsLimit = CouponsLimit::with('relbrand')->with('relproduct')->find($id);
            if ($couponsLimit) {
                return [$couponsLimit->id => $couponsLimit->relbrand['name'].'-'.$couponsLimit->relproduct['name']];
            }
        })->rules('required');

        $form->hidden('created_id')->value(getAdminUserId());

        return $form;
    }
}
