<?php
namespace App\Admin\Controllers\Api;

use App\Exceptions\SelfException;
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

    public function updateOrCreateOrderDelivery(Request $request)
    {
        try{
            $request_data = $request->only('order_child_ids', 'delino', 'orderno');
            $rules = [
                'order_child_ids' => 'required|exists:order_child,id,deleted_at,NULL,delivery_id,NULL',
                'delino' => 'required|unique:order_delivery,delino,deleted_at',
                'orderno' => 'required|exists:order_base,orderno,deleted_at,NULL',
            ];

            $messages = [
                'order_child_ids.required' => '缺少必要参数1，请刷新页面重试',
                'order_child_ids.exists' => '数据不存在，请退出重试',
                'delino.required' => '缺少必要参数2，请刷新页面重试',
                'orderno.required' => '缺少必要参数3，请刷新页面重试',
                'orderno.exists' => '数据不存在，请退出重试',
            ];

            $validator = Validator::make($request_data, $rules, $messages);
            if ($validator->fails()) throw new SelfException($validator->errors()->first());

            $result = $this->order_service->updateOrCreateOrderDelivery($request_data);
            return $this->success($result);
        }catch (SelfException $selfException) {
            return $this->failed($selfException->getMessage());
        }catch (\Throwable $throwable) {
            dd($throwable->getMessage(), $throwable->getFile(), $throwable->getLine());
        }

    }




}
