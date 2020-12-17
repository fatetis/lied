<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrderDeliveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("

CREATE TABLE `lied_order_delivery` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `delino` varchar(64) NOT NULL COMMENT '发货单号',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '物流状态',
  `created_id` int(11) unsigned NOT NULL COMMENT '创建者id',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发货订单';




");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_delivery');
    }
}
