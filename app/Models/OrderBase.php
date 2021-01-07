<?php

namespace App\Models;

class OrderBase extends BaseModel
{
    protected $table = 'order_base';
    protected $primaryKey = 'id';
    protected $guarded  = ['id'];

    const ORDER_STATUS = [
        0 => '待付款',
        1 => '待发货',
        2 => '部分发货',
        3 => '待收货',
        4 => '待评价',
        5 => '交易成功',
        6 => '交易关闭',
        7 => '退款中',
        8 => '退款完成',
    ];

    /**
     * 订单状态
     */
    const ORDER_STATUS_WAIT_PAY = 0; // 待付款
    const ORDER_STATUS_WAIT_DELIVERY = 1; // 待发货
    const ORDER_STATUS_WAIT_PART_DELIVERY = 2; // 部分发货
    const ORDER_STATUS_WAIT_TAKE = 3; // 待收货
    const ORDER_STATUS_WAIT_APPRAISE = 4; // 待评价
    const ORDER_STATUS_SUCCESS = 5; // 交易成功
    const ORDER_STATUS_CLOSE = 6; // 交易关闭
    const ORDER_STATUS_REFUNDING = 7; // 退款中
    const ORDER_STATUS_REFUNDED = 8; // 退款完成

    const PAY_STATUS = [
        0 => '待支付',
        1 => '已支付',
    ];
    /**
     * 支付状态
     */
    const PAY_STATUS_PAY = 0; // 待付款
    const PAY_STATUS_PAID = 1; // 已付款

    const SOURCE = [
        0 => '普通订单'
    ];
    /**
     * 来源订单
     */
    const SOURCE_ORDINARY = 0; // 普通订单

    public function order()
    {
        return $this->hasOne(Order::class, 'base_id', 'id')->with('orderchild', 'orderchild.orderdelivery', 'brand', 'shippingaddress');
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id', 'id');
    }



    public function snapshot()
    {
        return $this->belongsTo(Snapshots::class, 'id', 'id_value')->where('type', Snapshots::TYPE_ORDER);
    }

    public function paylog()
    {
        return $this->hasOne(PayLog::class, 'orderno', 'orderno');
    }

}
