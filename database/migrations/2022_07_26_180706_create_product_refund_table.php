<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductRefundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_product_refund` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_order_child_id` int(11) unsigned NOT NULL COMMENT '产品子订单表ID',
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `price` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '退款金额',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '退款类型 1-仅退款 2-退款退货',
  `reason` tinyint(1) unsigned NOT NULL COMMENT '退款理由1-不喜欢',
  `desc` varchar(128) DEFAULT NULL COMMENT '退款描述',
  `is_agree` tinyint(1) unsigned DEFAULT NULL COMMENT '是否统一 1-是 0-否',
  `memo` varchar(128) DEFAULT NULL COMMENT '退款备注',
  `operate_id` int(11) unsigned DEFAULT NULL COMMENT '操作人id',
  `operate_time` datetime DEFAULT NULL COMMENT '操作时间',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_refund-product_order_child_id` (`product_order_child_id`),
  KEY `product_refund-user_id` (`user_id`),
  CONSTRAINT `product_refund-product_order_child_id` FOREIGN KEY (`product_order_child_id`) REFERENCES `lied_product_order_child` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `product_refund-user_id` FOREIGN KEY (`user_id`) REFERENCES `lied_users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品订单退款表';


        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_refund');
    }
}
