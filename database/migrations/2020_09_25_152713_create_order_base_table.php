<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrderBase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_order_base` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `orderno` varchar(64) NOT NULL COMMENT '订单流水号',
  `paidno` varchar(64) DEFAULT NULL COMMENT '支付流水号',
  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
  `price` decimal(8,2) unsigned NOT NULL COMMENT '订单价格',
  `pay_price` decimal(8,2) unsigned DEFAULT NULL COMMENT '实际支付价格',
  `order_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '订单状态',
  `pay_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态',
  `source` tinyint(1) unsigned DEFAULT NULL COMMENT '订单来源',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单基础表';


");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_base');
    }
}
