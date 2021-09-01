<?php

namespace App\Models;

class Order extends BaseModel
{
    protected $table = 'order';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    const ORDER_STATUS = [
        0 => '交易中',
        1 => '交易成功',
        2 => '交易关闭',
    ];

    /**
     * 订单状态
     */
    const ORDER_STATUS_TRADING = 0;
    const ORDER_STATUS_SUCCESS = 1;
    const ORDER_STATUS_CLOSE = 2;

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

    public function productOrder()
    {
        return $this->hasOne(ProductOrder::class, 'order_id', 'id')->with('productOrderChild', 'productOrderChild.orderdelivery', 'brand', 'shippingaddress');
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
