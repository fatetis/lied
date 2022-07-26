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
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `orderno` varchar(64) NOT NULL COMMENT '订单流水号',
  `paidno` varchar(64) DEFAULT NULL COMMENT '支付流水号',
  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
  `origin_price` decimal(8,2) unsigned NOT NULL COMMENT '商品总价格',
  `price` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单总价格',
  `pay_price` decimal(8,2) unsigned DEFAULT '0.00' COMMENT '实际支付价格',
  `shipping_price` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '配送总价格',
  `discount_price` decimal(8,2) unsigned DEFAULT '0.00' COMMENT '优惠总价格',
  `order_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态 0-交易中 1-交易完成 2-交易失败',
  `pay_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态 0-待付款 1-已付款 2-退款中 3-已退款',
  `source` tinyint(1) unsigned DEFAULT '0' COMMENT '订单来源',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表';




");
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
