<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrderChildTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("

CREATE TABLE `lied_product_order_child` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL COMMENT '订单基础表id',
  `product_order_id` int(11) unsigned NOT NULL COMMENT '订单id',
  `product_id` int(11) unsigned NOT NULL COMMENT '产品id',
  `sku_id` int(11) unsigned NOT NULL COMMENT 'sku表id',
  `product_price` decimal(8,2) unsigned NOT NULL COMMENT '产品价格',
  `shipping_fee` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '配送费用',
  `number` int(4) unsigned NOT NULL COMMENT '购买数量',
  `delivery_id` int(11) unsigned DEFAULT '0' COMMENT '发货表id',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_child-base_id` (`order_id`),
  KEY `order_child-order_id` (`product_order_id`),
  CONSTRAINT `product_order_child-order_id` FOREIGN KEY (`order_id`) REFERENCES `lied_order` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `product_order_child-product_order_id` FOREIGN KEY (`product_order_id`) REFERENCES `lied_product_order` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品订单子表';





");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_child');
    }
}
