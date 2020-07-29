<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_order` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`temp_id` varchar(32) NOT NULL COMMENT '区别订单多商家产生的唯一标识',
`temp_sid` varchar(32) NOT NULL COMMENT '区别订单单一商家多产品的唯一标识',
`order_id` varchar(32) NOT NULL COMMENT '订单生成唯一编号',
`order_num` varchar(64) DEFAULT NULL COMMENT '订单流水支付号',
`user_id` int(10) unsigned NOT NULL,
`order_status` tinyint(1) NOT NULL COMMENT '订单的状态;,0关闭,1正常,2完成,',
`shipping_status` tinyint(1) NOT NULL COMMENT '商品配送情况;0未发货,1已发货,2已收货,3退货',
`pay_status` tinyint(1) NOT NULL COMMENT '支付状态;0未付款;1已付款',
`brand_id` int(10) unsigned NOT NULL COMMENT '商家id',
`product_id` int(10) unsigned NOT NULL COMMENT '产品id',
`attr_id` int(10) NOT NULL,
`product_num` int(4) NOT NULL COMMENT '产品数量',
`product_price` decimal(8,2) NOT NULL COMMENT '产品价格',
`product_intergral` decimal(8,2) NOT NULL COMMENT '产品积分',
`total_price` decimal(8,2) unsigned NOT NULL COMMENT '订单总金额',
`total_intergral` decimal(8,2) unsigned NOT NULL COMMENT '订单总积分',
`pay_price` decimal(8,2) NOT NULL COMMENT '已支付价格',
`pay_intergral` decimal(8,2) NOT NULL COMMENT '已支付的积分',
`discount_price` decimal(8,2) NOT NULL COMMENT '优惠价格',
`shipping_fee` decimal(8,2) NOT NULL COMMENT '配送费用',
`region_province_id` int(10) unsigned NOT NULL COMMENT '第一级省id',
`region_city_id` int(10) unsigned NOT NULL COMMENT '第二级市id',
`region_area_id` int(10) unsigned NOT NULL COMMENT '第三级区id',
`address` varchar(255) NOT NULL COMMENT '收货地址',
`mobile` varchar(32) NOT NULL COMMENT '收货人手机号',
`postscript` varchar(255) DEFAULT NULL COMMENT '订单留言，由用户提交填写',
`pay_id` int(10) DEFAULT NULL,
`pay_time` datetime DEFAULT NULL,
`to_buyer` varchar(255) DEFAULT NULL COMMENT '商家给用户留言',
`type` varchar(16) NOT NULL,
`created_at` datetime DEFAULT NULL,
`updated_at` datetime DEFAULT NULL,
`deleted_at` datetime DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `order-product_id` (`product_id`),
KEY `order-user_id` (`user_id`),
CONSTRAINT `order-product_id` FOREIGN KEY (`product_id`) REFERENCES `lied_product` (`id`) ON UPDATE CASCADE,
CONSTRAINT `order-user_id` FOREIGN KEY (`user_id`) REFERENCES `lied_users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
