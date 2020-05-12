<?php

namespace App\Admin\Controllers\Coupon;

use App\Models\Brand;
use App\Models\Coupons;
use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;
use Illuminate\Support\Facades\DB;

class CouponController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '优惠券';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Coupons);
        $grid->model()->orderBy('updated_at', 'desc');
        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('Id'));
        $grid->column('name', '名称')->modal('券的类型', function ($model) {
            $couponsDiscountData = $model->reldiscount()
                ->select(['coupons_discount.id', DB::raw('"折扣券" as type'),'coupons_discount.min_product_number', 'coupons_discount.discount','coupons_discount.stock_number'])
                ->orderBy('coupons_discount.updated_at','desc')
                ->get()
                ->toArray();
            $couponsPriceData = $model->relprice()
                ->select(['coupons_price.id', DB::raw('"满减券" as type'),'coupons_price.min_consume_price', 'coupons_price.price','coupons_price.stock_number'])
                ->orderBy('coupons_price.updated_at','desc')
                ->get()
                ->toArray();
            $commonData = array_merge($couponsPriceData,$couponsDiscountData);
            return new Table(['ID','类型','达标条件（最小消费/最小数量）', '优惠力度（金额/折扣）', '库存数量'], $commonData);
        });
        $grid->column('reveive_limit', '限领取数量')->editable();

        $grid->column('use_time', '使用时间')->display(function(){
            return $this->use_start_time.'~'.$this->use_end_time;
        });
        $grid->column('receive_time', '领取时间')->display(function(){
            return $this->receive_start_time.'~'.$this->receive_end_time;
        });
        $grid->column('description', '描述')->limit(120);
        $grid->column('is_online', __('线上'))->switch();
        $grid->column('is_show', __('显示'))->switch();
        $grid->column('sort_order', __('排序'))->editable();
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('编辑时间'));
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
        $show = new Show(Coupons::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('名称'));
        $show->thumb('缩略图')->image();
        $show->field('use_time', '使用时间')->as(function(){
            return $this->use_start_time.'~'.$this->use_end_time;
        });
        $show->field('receive_time', '领取时间')->as(function(){
            return $this->receive_start_time.'~'.$this->receive_end_time;
        });
        $show->field('description', __('描述'));
        $show->field('reveive_limit', __('限领取数量'));
        $show->field('is_online', __('线上'))->using(['0'=>'否','1'=>'是']);
        $show->field('is_show', __('显示'))->using(['0'=>'否','1'=>'是']);
        $show->field('sort_order', __('排序'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Coupons);
        $form->tab('基础信息', function ($form) {

            $form->text('name', '优惠券名称')->rules('required');
            $form->number('reveive_limit', '限领取数量')->rules('required');
            $form->image('thumb', '缩略图')->move(urlStandard('coupon_thumb'))->uniqueName()->removable()->help('上传图片宽*高为750*750');
            $form->wangeditor('description', '描述');
            $form->datetimeRange('use_start_time','use_end_time','使用时间')->rules('required');
            $form->datetimeRange('receive_start_time','receive_end_time','领取时间')->rules('required');
            $form->switch('is_online', '线上');
            $form->switch('is_show', '显示');
            $form->number('sort_order', '排序')->value(99);
            $form->hidden('created_id')->value(Admin::user()->id);

        })->tab('限领取设置',function($form){

            $form->hasMany('rellimit', '限领取', function (Form\NestedForm $form) {

                $form->select('brand_id','参与品牌')->options(function ($id) {
                    $brand = Brand::find($id);
                    if ($brand) {
                        return [$brand->id => $brand->name];
                    }
                })->ajax(route('selectBrand'))->load('product_id', route('loadPro'));

                $form->select('product_id','参与产品')->options(function ($id) {
                    $brand = Product::find($id);
                    if ($brand) {
                        return [$brand->id => $brand->name];
                    }
                });

            });

        })->tab('满减券设置', function($form){

            $form->hasMany('relprice','满减券', function (Form\NestedForm $form) {
                $form->currency('min_consume_price','最低消费金额')->symbol('￥')->help('为空，则表示无门槛优惠');
                $form->currency('price','优惠金额')->symbol('￥');
                $form->number('stock_number', '库存数量');
            });

        })->tab('折扣券设置', function($form){

            $form->hasMany('reldiscount', '折扣券', function (Form\NestedForm $form) {
                $form->number('discount', '优惠折扣')->help('打7.5折填写75即可，其他折扣以此类推')->max(100);
                $form->number('min_product_number', '产品达标数量');
                $form->currency('max_discount_price', '最大折扣金额')->symbol('￥')->help('为空，则表示无上限优惠');
                $form->number('stock_number', '库存数量');
            });

        });

        return $form;
    }
}
