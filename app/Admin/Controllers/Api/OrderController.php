<?php
namespace App\Admin\Controllers\Api;

use App\Exceptions\SelfException;
use App\Models\OrderBase;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends BaseController {

    protected $order_service;

    public function __construct(OrderService $orderService)
    {
        $this->order_service = $orderService;
    }

    public function firstOrderBaseById(Request $request)
    {
        try{
            $orderno = $request->input('orderno');
            $orderbase_info = $this->order_service->firstOrderBaseById($orderno);
//            dd($orderbase_info);
            $view = view('admin.order.info_body', [
                'data' => $orderbase_info
            ]);
            $data = response($view)->getContent();

            return $this->success($data);
        }catch (\Throwable $throwable) {
            dd($throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
        }

    }

    public function orderDelivery(Request $request)
    {
        $request_data = $request->only('order_child_ids', 'delino', 'orderno');
        try{
            $rules = [
                'order_child_ids' => 'required|exists:order_child,id,deleted_at,NULL,delivery_id,NULL',
                'delino' => 'required|unique:order_delivery,delino,deleted_at',
                'orderno' => 'required|exists:order_base,orderno,deleted_at,NULL',
            ];

            $messages = [
                'order_child_ids.required' => '缺少必要参数【order_child_ids】，请刷新页面重试',
                'order_child_ids.exists' => '数据不存在【order_child_ids】，请退出重试',
                'delino.required' => '缺少必要参数【delino】，请刷新页面重试',
                'orderno.required' => '缺少必要参数【orderno】，请刷新页面重试',
                'orderno.exists' => '数据不存在【orderno】，请退出重试',
            ];

            $validator = Validator::make($request_data, $rules, $messages);
            if ($validator->fails()) throw new SelfException($validator->errors()->first());

            $result = $this->order_service->orderDelivery($request_data);
            return $this->success($result);
        }catch (SelfException $selfException) {
            return $this->failed($selfException->getMessage());
        }catch (\Throwable $throwable) {
            elog('订单发货信息抛出异常', $throwable, $request_data);
            return $this->failed('系统异常，请刷新重试');
        }
    }

    public function updateOrderAddress(Request $request)
    {
        $request_data = $request->only('orderno', 'name', 'mobile', 'input_area', 'address_detail');
        try{
            $rules = [
                'orderno' => 'required|exists:order_base,orderno,order_status,'.OrderBase::ORDER_STATUS_WAIT_DELIVERY.',deleted_at,NULL',
                'name' => 'required|min:2|max:15|regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9]{2,16}$/u',
                'mobile' => 'required|mobile',
                'input_area' => 'required|exists:regions,region_id,deleted_at,NULL',
                'address_detail' => 'required',
            ];
            $messages = [
                'orderno.required' => '缺少必要参数【orderno】，请刷新页面重试',
                'orderno.exists' => '数据不存在【orderno】，请退出重试',
                'name.required' => '收货人姓名不能为空',
                'name.min' => '收货人姓名至少为2个字符',
                'name.max' => '收货人姓名最多为15个字符',
                'name.regex' => '收货人姓名，不允许包含特殊字符',
                'mobile.required' => '收货人手机号不能为空',
                'mobile.mobile' => '收货人手机号不合法',
                'input_area.required' => '收货人省市区不能为空',
                'input_area.exists' => '收货人省市区数据不合法',
                'address_detail.required' => '收货人地址不能为空',
            ];
            $validator = Validator::make($request_data, $rules, $messages);
            if ($validator->fails()) throw new SelfException($validator->errors()->first());
            $result = $this->order_service->updateOrderAddress($request_data);
            return $this->success($result);
        }catch (SelfException $selfException) {
            return $this->failed($selfException->getMessage());
        }catch (\Throwable $throwable) {
            dd($throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
            elog('修改订单配送信息抛出异常', $throwable, $request_data);
            return $this->failed('系统异常，请刷新重试');
        }
    }




}
