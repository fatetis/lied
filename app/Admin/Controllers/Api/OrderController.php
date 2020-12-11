<?php
namespace App\Admin\Controllers\Api;

use App\Exceptions\SelfException;
use App\Services\OrderService;
use Illuminate\Http\Request;

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



}
