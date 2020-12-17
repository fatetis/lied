<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrder extends Migration
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
  `base_id` int(11) unsigned NOT NULL COMMENT '订单基础表id',
  `brand_id` int(11) unsigned NOT NULL COMMENT '商家id',
  `shipping_address_id` int(11) unsigned DEFAULT NULL COMMENT '配送地址表id',
  `message` varchar(255) DEFAULT NULL COMMENT '用户留言',
  `order_type` tinyint(1) unsigned NOT NULL COMMENT '订单类型',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order-base_id` (`base_id`),
  CONSTRAINT `order-base_id` FOREIGN KEY (`base_id`) REFERENCES `lied_order_base` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='单商家订单表';





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
