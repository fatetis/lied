<?php
namespace App\Admin\Controllers\Api;

use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends BaseController {

    protected $order_service;

    public function __construct(OrderService $orderService)
    {
        $this->order_service = $orderService;
    }

    public function getOrderInfo(Request $request)
    {

    }



}
