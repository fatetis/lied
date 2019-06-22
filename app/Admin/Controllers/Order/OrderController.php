<?php

namespace App\Admin\Controllers\Order;

use App\Models\Brand;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAttr;
use App\Models\ProductSku;
use App\Models\Regions;
use App\Models\Users;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;
use Illuminate\Support\Facades\Storage;
use \Encore\Admin\Grid\Filter\Between;

class OrderController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
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
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);

        $grid->id('订单Id');
        $grid->order_id('订单编号');
        $grid->user_id('用户名称')->display(function($id){
            $userList = Users::find($id);
            return $userList->name;
        });

        $grid->total_price('订单总金额');
        $grid->total_intgeral('订单总积分');
        $grid->pay_price('已支付价格');
        $grid->pay_intergral('已支付积分');
        $grid->order_status('订单状态')->display(function($time){
            switch ($time) {
                case 0:
                    $str = '关闭';
                    break;
                case 1:
                    $str = '正常';
                    break;
                case 2:
                    $str = '完成';
                    break;
            }
            return $str;
        });
        $grid->shipping_status('配送状态')->display(function($time){
            switch ($time) {
                case 0:
                    $str = '未发货';
                    break;
                case 1:
                    $str = '已发货';
                    break;
                case 2:
                    $str = '已收货';
                    break;
                case 3:
                    $str = '退货';
                    break;
            }
            return $str;
        });
        $grid->pay_status('支付状态')->display(function($time){
            switch ($time) {
                case 0:
                    $str = '未付款';
                    break;
                case 1:
                    $str = '已付款';
                    break;
            }
            return $str;
        });
        $grid->type('订单类型');
        $grid->created_at('购买时间');

//        $grid->column('second_table')->display(function () {
////            $brandList = Brand::find($this->brand_id);
//            $productList = Product::find($this->product_id);
//            $productAttrList = ProductAttr::find($this->attr_id);
//            $productSkuList = ProductSku::find($productAttrList->sku_id);
//
//            $table = '<table class="table table-hover">';
//
//            $table .= '<thead><tr>
//                    <th style="text-align:center;">产品</th>
//                    <th style="text-align:center;"></th>
//                    <th style="text-align:center;">购买单价</th>
//                    <th style="text-align:center;">购买数量</th>
//                    <th style="text-align:center;">SKU</th>
//                </tr></thead><tbody>';
//
//                $table .= '<tr>
//                        <td style="text-align:center;width:10%;">'.$productList->name.'</td>
//                        <td style="text-align:center;width:10%;"><img src="'.Storage::disk(config('admin.upload.disk'))->url($productAttrList->thumb).'" style="max-height:100px;max-width:100px;" class="img img-thumbnail"></td>
//                        <td style="text-align:center;width:5%;">'.$this->product_price.'</td>
//                        <td style="text-align:center;width:5%;">'.$this->product_number.'</td>
//                        <td style="text-align:center;width:10%;">'.$productSkuList->name.'</td>
//                    </tr>';
//
//            $table .= '</tbody></table>';
//
//            $box = new Box('订单'.$this->order_id, $table);
//            $box->default_show(false);
//            $box->collapsable();
//            $box->solid();
//            return $box->render();
//
//        })->setAttributes(['style'=>'display:block']);

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
        $show = new Show(Order::findOrFail($id));
        $show->id('Id');
        $show->temp_id('Temp id');
        $show->temp_sid('Temp sid');
        $show->order_id('Order id');
        $show->order_num('Order num');
        $show->user_id('User id');
        $show->order_status('Order status');
        $show->shipping_status('Shipping status');
        $show->pay_status('Pay status');
        $show->brand_id('Brand id');
        $show->product_id('Product id');
        $show->product_num('Product num');
        $show->product_price('Product price');
        $show->product_intergral('Product intergral');
        $show->pay_price('Pay price');
        $show->pay_intergral('Pay intergral');
        $show->discount_price('Discount price');
        $show->shipping_fee('Shipping fee');
        $show->region_id('Region id');
        $show->address('Address');
        $show->mobile('Mobile');
        $show->postscript('Postscript');
        $show->pay_id('Pay id');
        $show->pay_time('Pay time');
        $show->to_buyer('To buyer');
        $show->type('Type');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->deleted_at('Deleted at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order);
        $form->display('order_id', 'Order id');
        $form->display('user_id', '用户名称')->with(function($id){
            $userList = Users::find($id);
            return $userList->name;
        });
        $form->currency('total_price','订单金额')->symbol('￥');
        $form->mobile('mobile', '手机号');

        $form->select('region_province_id','省')->options(Regions::getProvice())->load('region_city_id', '/admin/api/city');

        $form->select('region_city_id','市')->options(function($id){
            $regionList = Regions::find($id);
            if ($regionList) {
                return [$regionList->region_id => $regionList->region_name];
            }
        })->load('region_area_id', '/admin/api/area');

        $form->select('region_area_id','区')->options(function($id){
            $regionList = Regions::find($id);
            if ($regionList) {
                return [$regionList->region_id => $regionList->region_name];
            }
        });

        $form->text('address','详细地址')->rules('required');
        $form->display('postscript','买家留言');
        $form->textarea('to_buyer','卖家留言');
        return $form;
    }
}
