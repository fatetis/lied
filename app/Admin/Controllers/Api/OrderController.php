<?php
namespace App\Admin\Controllers\Api;

use App\Exceptions\SelfException;
use App\Models\Order;
use App\Models\ProductOrder;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends BaseController
{

    protected $order_service;

    public function __construct(OrderService $orderService)
    {
        $this->order_service = $orderService;
    }

    public function firstOrderById(Request $request)
    {
        $orderno        = $request->input('orderno');
        $orderbase_info = $this->order_service->firstOrderById($orderno);
        $view           = view('admin.order.info_body', [
            'data' => $orderbase_info
        ]);
        $data           = response($view)->getContent();
        return $this->success($data);
    }

    public function orderDelivery(Request $request)
    {
        $request_data = $request->only('order_child_ids', 'delino', 'orderno');
        $rules        = [
            'order_child_ids' => 'required|exists:product_order_child,id,deleted_at,NULL,delivery_id,NULL',
            'delino'          => 'required|unique:order_delivery,delino,deleted_at',
            'orderno'         => 'required|exists:order,orderno,deleted_at,NULL',
        ];

        $messages  = [
            'order_child_ids.required' => '缺少必要参数【order_child_ids】，请刷新页面重试',
            'order_child_ids.exists'   => '数据不存在【order_child_ids】，请退出重试',
            'delino.required'          => '缺少必要参数【delino】，请刷新页面重试',
            'orderno.required'         => '缺少必要参数【orderno】，请刷新页面重试',
            'orderno.exists'           => '数据不存在【orderno】，请退出重试',
        ];
        $validator = Validator::make($request_data, $rules, $messages);
        if ($validator->fails()) throw new SelfException($validator->errors()->first());

        $result = $this->order_service->orderDelivery($request_data);
        return $this->success($result);
    }

    public function updateOrderAddress(Request $request)
    {
        $request_data = $request->only('orderno', 'name', 'mobile', 'input_area', 'address_detail');
        $rules        = [
            'orderno'        => 'required|exists:order,orderno,order_status,' . Order::ORDER_STATUS_TRADING . ',deleted_at,NULL',
            'name'           => 'required|min:2|max:15|regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9]{2,16}$/u',
            'mobile'         => 'required|mobile',
            'input_area'     => 'required|exists:regions,region_id,deleted_at,NULL',
            'address_detail' => 'required',
        ];
        $messages     = [
            'orderno.required'        => '缺少必要参数【orderno】，请刷新页面重试',
            'orderno.exists'          => '数据不存在【orderno】，请退出重试',
            'name.required'           => '收货人姓名不能为空',
            'name.min'                => '收货人姓名至少为2个字符',
            'name.max'                => '收货人姓名最多为15个字符',
            'name.regex'              => '收货人姓名，不允许包含特殊字符',
            'mobile.required'         => '收货人手机号不能为空',
            'mobile.mobile'           => '收货人手机号不合法',
            'input_area.required'     => '收货人省市区不能为空',
            'input_area.exists'       => '收货人省市区数据不合法',
            'address_detail.required' => '收货人地址不能为空',
        ];
        $validator    = Validator::make($request_data, $rules, $messages);
        if ($validator->fails()) throw new SelfException($validator->errors()->first());
        $result = $this->order_service->updateOrderAddress($request_data);
        return $this->success($result);
    }

    public function updateOrderPrice(Request $request)
    {
        $request_data = $request->only('orderno', 'price');
        $rules        = [
            'orderno' => 'required|exists:order,orderno,pay_status,' . Order::PAY_STATUS_PAY . ',deleted_at,NULL',
            'price'   => 'required',
        ];
        $messages     = [
            'orderno.required' => '缺少必要参数【orderno】，请刷新页面重试',
            'orderno.exists'   => '数据不存在【orderno】，请退出重试',
            'price.required'   => '缺少必要参数【price】，请刷新页面重试',
        ];
        $validator    = Validator::make($request_data, $rules, $messages);
        if ($validator->fails()) throw new SelfException($validator->errors()->first());
        $result = $this->order_service->updateOrderPrice($request_data);
        return $this->success($result);
    }




}
