<?php

namespace App\Services;


use App\Exceptions\SelfException;
use App\Models\Order;
use App\Models\OrderBase;
use App\Models\OrderChild;
use App\Models\OrderDelivery;
use App\Models\Regions;
use App\Models\ShippingAddress;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\DB;

class OrderService extends BaseService
{

    protected $table = OrderBase::class;

    /**
     * 获取订单信息
     * @param string $orderno 订单编号
     * @return array
     * Author: fatetis
     * Date:2020/12/17 001716:30
     */
    public function firstOrderBaseById($orderno)
    {
        // 产品数据
        $base_info = OrderBase::query()
            ->where(['orderno' => $orderno])
            ->with('order', 'snapshot', 'paylog')
            ->first();
        $result = [];
        $result['id'] = $base_info['id'];
        $result['orderno'] = $base_info['orderno'];
        $result['brand_name'] = $base_info['order']['brand']['name'];
        $result['price'] = $base_info['price'];
        $result['shipping_price'] = $base_info['shipping_price'];
        $result['order_status_num'] = $base_info['order_status'];
        $result['pay_status_num'] = $base_info['pay_status'];
        $result['order_status'] = OrderBase::ORDER_STATUS[$base_info['order_status']];
        $result['pay_status'] = OrderBase::PAY_STATUS[$base_info['pay_status']];
        $result['source'] = OrderBase::SOURCE[$base_info['source']];
        $result['order_type'] = Order::ORDER_TYPE[$base_info['order']['order_type']];
        $result['message'] = $base_info['message'];
        $result['order_time'] = $base_info['created_at'];
        $result['product'] = [];
        // 是否展示配送信息保存按钮
        $result['show_delivery_save'] = in_array($base_info['order_status'], [OrderBase::ORDER_STATUS_WAIT_DELIVERY, OrderBase::ORDER_STATUS_WAIT_PART_DELIVERY]) && OrderBase::PAY_STATUS_PAID;
        // 是否展示配送信息tab 默认不展示
        $result['show_delivery'] = $result['show_delivery_save'];
        foreach ($base_info['order']['orderchild'] as $value) {
            $result['product'][$value['sku_id']]['id'] = $value['id'];
            $result['product'][$value['sku_id']]['product_price'] = $value['product_price'];
            $result['product'][$value['sku_id']]['number'] = $value['number'];
            // 物流信息
            if($value['orderdelivery']) {
                $result['product'][$value['sku_id']]['delino'] = $value['orderdelivery']['delino'];
                $result['product'][$value['sku_id']]['status'] = OrderDelivery::STATUS[$value['orderdelivery']['status']];
                $result['show_delivery'] = true;
            }
        }

        // 收货人数据
        if($base_info['order']['shippingaddress']) {
            $result['shipping_address']['name'] = $base_info['order']['shippingaddress']['name'];
            $region_data = Regions::query()->whereIn('region_id', [$base_info['order']['shippingaddress']['region_pid'], $base_info['order']['shippingaddress']['region_cid'], $base_info['order']['shippingaddress']['region_aid']])->pluck('region_name', 'region_id');
            $result['shipping_address']['address'] = $region_data[$base_info['order']['shippingaddress']['region_pid']]." ".$region_data[$base_info['order']['shippingaddress']['region_cid']]." ".$region_data[$base_info['order']['shippingaddress']['region_aid']]." ".$base_info['order']['shippingaddress']['address'];
            $result['shipping_address']['address_detail'] = $base_info['order']['shippingaddress']['address'];
            $result['shipping_address']['mobile'] = $base_info['order']['shippingaddress']['mobile'];
            $result['shipping_address']['region_pid'] = $base_info['order']['shippingaddress']['region_pid'];
            $result['shipping_address']['region_cid'] = $base_info['order']['shippingaddress']['region_cid'];
            $result['shipping_address']['region_aid'] = $base_info['order']['shippingaddress']['region_aid'];
            // 收货人数据
            if($base_info['order_status'] == OrderBase::ORDER_STATUS_WAIT_DELIVERY){
                $region_service = new RegionsService();
                $result['province_data'] = RegionsService::getAllProvince();
                $result['city_data'] = $region_service->getCityByProvinceId($result['shipping_address']['region_pid']);
                $result['area_data'] = $region_service->getAreaByProvinceId($result['shipping_address']['region_cid']);
            }
        }
        // 支付数据
        if($base_info['paylog']) {
            $result['pay_log']['pay_price'] = $base_info['paylog']['pay_price'];
            $result['pay_log']['pay_name'] = $base_info['paylog']['pay_name'];
            $result['pay_log']['is_pay'] = $base_info['paylog']['is_pay'];
            $result['pay_log']['outside_orderno'] = $base_info['paylog']['outside_orderno'];
            $result['pay_log']['created_at'] = $base_info['paylog']['created_at'];
        }
        // 若没有快照记录, 则没有产品详情
        if(empty($base_info['snapshot'])) return $result;
        $snapshots = jd($base_info['snapshot']['value']);
        foreach ($snapshots['sku_info'] as $value) {
            $result['product'][$value['id']]['sku'] = '';
            $result['product'][$value['id']]['product_name'] = $value['product']['name'];
            $result['product'][$value['id']]['product_id'] = $value['product']['id'];
            $result['product'][$value['id']]['sku_media'] = $value['media']['link'];
            // sku名称信息
            foreach ($value['attr_values'] as $v) {
                $result['product'][$value['id']]['sku'] .= $v['attr']['name'].'：'.$v['name'].'，';
            }
            $result['product'][$value['id']]['sku'] = mb_substr($result['product'][$value['id']]['sku'], 0, -1);
        }

        return $result;
    }


    /**
     * 订单发货
     * @param $data
     * @return array
     * Author: fatetis
     * Date:2020/12/17 001716:30
     */
    public function orderDelivery($data)
    {
        $delivery_data = [];
        DB::transaction(function () use($data, &$delivery_data){
            $order_child_ids = $data['order_child_ids'];
            #TODO 物流单号需查找校验
            $delivery_data = OrderDelivery::query()->create([
                'delino' => $data['delino'],
                'created_id' => Admin::user()->id,
            ]);
            // 写入订单发货id
            $order_child_sql = OrderChild::query();
            is_array($order_child_ids)
                ? $order_child_sql->whereIn('id', $order_child_ids)
                : $order_child_sql->where('id', $order_child_ids);
            $order_child_sql->where('delivery_id')->update([
                'delivery_id' => $delivery_data['id']
            ]);
            // 修改订单状态
            $order_base = $this->firstOrderBaseWithOrderByOrderno($data['orderno']);
            // 校验订单状态
            if(!in_array($order_base['order_status'], [
                OrderBase::ORDER_STATUS_WAIT_DELIVERY,
                OrderBase::ORDER_STATUS_WAIT_PART_DELIVERY
            ]) || $order_base['pay_status'] != OrderBase::PAY_STATUS_PAID)
                throw new SelfException('修改失败，订单不在发货阶段');
            $base_id = $order_base['id'];
            $not_delivery_count = OrderChild::query()->where('base_id', $base_id)->where('delivery_id')->count();
            $order_status = empty($not_delivery_count)
                ? OrderBase::ORDER_STATUS_WAIT_DELIVERED
                : OrderBase::ORDER_STATUS_WAIT_PART_DELIVERY;
            OrderBase::query()->where('id', $base_id)->update([
                'order_status' => $order_status
            ]);
        });
        return $delivery_data;
    }


    public function updateOrderAddress($data)
    {
        $order_base = $this->firstOrderBaseWithOrderByOrderno($data['orderno']);
        $region_data = Regions::query()->where('region_id', $data['input_area'])->first();
        // 判断订单状态
//        if($order_base['order_status'] !== OrderBase::ORDER_STATUS_WAIT_DELIVERY)
//            throw new SelfException('修改失败，订单不在发货阶段');
        $arr['name'] = $data['name'];
        list($arr['region_pid'], $arr['region_cid'], $arr['region_aid']) = array_values(array_filter(explode(',', $region_data['region_path'])));
        $arr['mobile'] = $data['mobile'];
        $arr['address'] = $data['address_detail'];
        return ShippingAddress::query()->where('id', $order_base['order']['shipping_address_id'])->update($arr);

    }

    /**
     * 获取订单基础信息与关联的order表信息-orderno
     * @param $orderno
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     * Author: fatetis
     * Date:2020/12/18 001816:05
     */
    public function firstOrderBaseWithOrderByOrderno($orderno)
    {
        return OrderBase::query()->with('order')->where('orderno', $orderno)->first();
    }


}
