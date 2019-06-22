<?php

namespace App\Http\Controllers\Order;


use App\Http\Controllers\Controller;
use App\Models\ProductSeckill;
use App\Services\BrandService;
use App\Services\OrderService;
use App\Services\ProductAttrService;
use App\Services\ProductService;
use App\Services\UsersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{

    protected $productService;

    protected $orderService;

    protected $productAttrService;

    protected $usersService;

    protected $brandService;

    public function __construct(ProductService $productService,
                                OrderService $orderService,
                                ProductAttrService $productAttrService,
                                UsersService $usersService,
                                BrandService $brandService)
    {
        $this -> productService = $productService;

        $this -> orderService = $orderService;

        $this -> productAttrService = $productAttrService;

        $this -> usersService = $usersService;

        $this -> brandService = $brandService;

    }

    public function index(Request $request){

        return view('m.order.index');

    }

    public function createOrder(Request $request){
        try{
            $parameter = $request->only('product_id','attr_id','address_id','product_num','type');
            $brandId = $request->input('brand_id','0');
            $orderArr[$brandId][] = $parameter;
//            传输数据
            $result = $this->orderService->createOrder($orderArr);
            return !empty($result)?$this->successJson('订单提交成功'):$this->errorJson('订单提交失败');
        }catch (\Exception $exception){
            return $this->errorJson($exception->getMessage());
        }
    }

    //购物车首页
    public function cart(){

    }

    //加入购物车
    public function createCart (){

    }

    //秒杀首页
    public function seckillIndex(){
        return view('m.order.seckillIndex');
    }

    public function createOrderByRedis(Request $request){
        try{
//            $parameter = $request->only('product_id','attr_id','address_id','product_num','type');
//            $brandId = $request->input('brand_id','0');
//            $orderArr[$brandId][] = $parameter;
            $seckillId = $request->input('seckill_id','0');

            $user_id = $this->usersService->user()->id;
            $jsonStr = json_encode($orderArr);
            $result = Redis::lpush('seckill:mall:'.$user_id,$jsonStr);
            if($result){
                return $this->successJson('成功抢到名额');
            }
            return $this->errorJson('名额失败');
        }catch (\Exception $exception){
            return $this->errorJson($exception->getMessage());
        }
    }

}
