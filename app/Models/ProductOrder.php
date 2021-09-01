<?php

namespace App\Models;

class ProductOrder extends BaseModel
{
    protected $table = 'product_order';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    const SHOW_STATUS = [
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
    const SHOW_STATUS_WAIT_PAY = 0; // 待付款
    const SHOW_STATUS_WAIT_DELIVERY = 1; // 待发货
    const SHOW_STATUS_WAIT_PART_DELIVERY = 2; // 部分发货
    const SHOW_STATUS_WAIT_TAKE = 3; // 待收货
    const SHOW_STATUS_WAIT_APPRAISE = 4; // 待评价
    const SHOW_STATUS_SUCCESS = 5; // 交易成功
    const SHOW_STATUS_CLOSE = 6; // 交易关闭
    const SHOW_STATUS_REFUNDING = 7; // 退款中
    const SHOW_STATUS_PART_REFUNDING = 8; // 部分退款中
    const SHOW_STATUS_REFUNDED = 9; // 退款完成

    const ORDER_TYPE_ORDINARY = 0; // 普通订单类型

    const ORDER_TYPE = [
        0 => '普通订单'
    ];

    public function productOrderChild()
    {
        return $this->hasMany(ProductOrderChild::class, 'product_order_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function shippingaddress()
    {
        return $this->hasOne(ShippingAddress::class, 'id', 'shipping_address_id');
    }

}
