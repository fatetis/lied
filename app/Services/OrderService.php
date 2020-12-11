<?php

namespace App\Services;


use App\Models\Order;
use App\Models\OrderBase;

class OrderService extends BaseService
{

    protected $table = OrderBase::class;

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
        $result['order_status'] = OrderBase::ORDER_STATUS[$base_info['order_status']];
        $result['pay_status'] = OrderBase::PAY_STATUS[$base_info['pay_status']];
        $result['source'] = OrderBase::SOURCE[$base_info['source']];
        $result['order_type'] = Order::ORDER_TYPE[$base_info['order']['order_type']];
        $result['message'] = $base_info['message'];
        $result['order_time'] = $base_info['created_at'];
        $result['product'] = [];
        foreach ($base_info['order']['orderchild'] as $value) {
            $result['product'][$value['sku_id']]['product_price'] = $value['product_price'];
            $result['product'][$value['sku_id']]['number'] = $value['number'];
        }
        // 若没有快照记录, 则没有产品详情
        if(empty($base_info['snapshot'])) return $result;
        $snapshots = jd($base_info['snapshot']['value']);
        foreach ($snapshots['sku_info'] as $value) {
            $result['product'][$value['id']]['sku'] = '';
            $result['product'][$value['id']]['product_name'] = $value['product']['name'];
            $result['product'][$value['id']]['product_id'] = $value['product']['id'];
            $result['product'][$value['id']]['sku_media'] = $value['media']['link'];
            foreach ($value['attr_values'] as $v) {
                $result['product'][$value['id']]['sku'] .= $v['attr']['name'].'：'.$v['name'].'，';
            }
            $result['product'][$value['id']]['sku'] = mb_substr($result['product'][$value['id']]['sku'], 0, -1);
        }
        // 支付数据
        if(!empty($base_info['paylog'])) {
            $result['pay_log']['pay_price'] = $base_info['paylog']['pay_price'];
            $result['pay_log']['pay_name'] = $base_info['paylog']['pay_name'];
            $result['pay_log']['is_pay'] = $base_info['paylog']['is_pay'];
            $result['pay_log']['outside_orderno'] = $base_info['paylog']['outside_orderno'];
            $result['pay_log']['created_at'] = $base_info['paylog']['created_at'];
        }
        return $result;

    }

}
