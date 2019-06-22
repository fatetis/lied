<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService extends BaseService {

    protected $table = Order::class;
    const TEMPIDPREFIX      = 'P';//同一订单唯一标识前缀
    const TEMPSIDPREFIX     = 'S';//订单商家唯一标识前缀
    const ORDERIDPREFIX     = 'O';//订单产品唯一标识前缀
    const ORDERCLOSE        = 0;//关闭订单
    const ORDERNORMAL       = 1;//正常订单
    const ORDERFINISH       = 2;//完成订单
    const NOTSHIPPING       = 0;//未发货
    const SHIPPED           = 1;//已发货
    const SHIPPERECEIVED    = 2;//已收货
    const SHIPPEREFUND      = 3;//退货订单
    const NOPAY             = 0;//未付款
    const PAY               = 1;//已付款

    public function createOrder($orderArr){
        try{
            DB::beginTransaction();//事务开启
            $insertArr = $resultArr = [];
            $insertArr['temp_id'] = $this -> orderRandNum(static::TEMPIDPREFIX);
            $user_id = UsersService::user()->id;
            $type = ['mall','collage','intergral'];
            foreach ($orderArr as $key => $value){
                $brandList = BrandService::checkModelDataById($key,true);
                if(!$brandList) throw new \Exception('无此商家');

                $insertArr['temp_sid'] = $this -> orderRandNum(static::TEMPSIDPREFIX);
                foreach ($value as $k => $val){
                    if(!in_array($val['type'],$type)) throw new \Exception('异常错误');
                    if(!is_numeric($val['product_id']) || (!empty($val['attr_id']) && !is_numeric($val['attr_id'])) || !is_numeric($val['product_num'])){
                        throw new \Exception('请正确选择商品规格或数量');
                    }

                    $productList = ProductService::checkModelDataById($val['product_id'],true);
                    if(!$productList) throw new \Exception('无此产品');

                    if(!empty($val['attr_id'])){
                        $productAttr = ProductAttrService::first(['product_id'=>$productList->id,'id' => $val['attr_id']]);
                        if(!$productAttr) throw new \Exception('无此产品属性');
                        $productList -> price = $productAttr->attr_price;
                        //商品扣库存
                        $storeNum = $productAttr->product_number -= $val['product_num'];
                        $storeUpdate = &$productAttr;
                    }else{
                        $storeNum = $productList->number -= $val['product_num'];
                        $storeUpdate = &$productList;
                    }
                    if($storeNum < 0) throw new \Exception('库存不足');
                    $insertArr = array_merge($insertArr,[
                        'order_id'          => $this -> orderRandNum(static::ORDERIDPREFIX),
                        'user_id'           => $user_id,
                        'order_status'      => static::ORDERNORMAL,
                        'shipping_status'   => static::NOTSHIPPING,
                        'pay_status'        => static::NOPAY,
                        'brand_id'          => $productList->brand_id,
                        'product_id'        => $val['product_id'],
                        'attr_id'           => $val['attr_id'],
                        'product_num'       => $val['product_num'],
                        'product_price'     => $productList -> price,
                        'product_intergral' => $productList->intergral,
                        'total_price'       => sprintf("%.2f", $val['product_num']*$productList -> price),
                        'total_intergral'   => sprintf("%.2f", $val['product_num']*$productList -> intergral),
                        'pay_price'         => 0,
                        'pay_intergral'     => 0,
                        'discount_price'    => 0,
                        'shipping_fee'      => 0,
                        'region_proviceId'  => '3284',//收货地址省市区region表id
                        'region_cityId'     => '3284',//收货地址省市区region表id
                        'region_areaId'     => '3284',//收货地址省市区region表id
                        'address'           => '东纵路111号',
                        'mobile'            => '18825099087',
                        'type'              => $val['type'],
                    ]);

                    //插入order表
                    $result = $this -> firstOrCreate([
                        'user_id'               => $user_id,
                        'product_id'            => $val['product_id'],
                        'pay_status'            => static::NOPAY,
                        'order_status'          => static::ORDERNORMAL,
                        'shipping_status'       => static::NOTSHIPPING,
                    ],$insertArr);
                    //判断是否为新增，是则扣库存
                    if($result->wasRecentlyCreated){
                        $storeUpdate->save();
                        if(!in_array($result->id,$resultArr)){
                            array_push($resultArr,$result->id);
                        }
                    };

                }
            }
            DB::commit();//事务提交
            return $resultArr;
        }catch (\Exception $exception){
            DB::rollBack();//事务回滚
            return $exception->getMessage();
        }

    }

    public function orderRandNum($type){
        switch ($type) {
            case static::TEMPIDPREFIX:
                $column = 'temp_id';
                break;
            case static::TEMPSIDPREFIX:
                $column = 'temp_sid';
                break;
            case static::ORDERIDPREFIX:
                $column = 'order_id';
                break;
        }
        $type .= date('YmdHis',time());
        $randNum = randNum($type);
        if($this->first([$column=>$randNum])){
            return $this->orderRandNum($type);
        }
        return $randNum;
    }

}
