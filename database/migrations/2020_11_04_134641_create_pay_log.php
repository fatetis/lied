<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePayLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_pay_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `reqno` varchar(64) DEFAULT NULL COMMENT '请求流水号',
  `resno` varchar(64) DEFAULT NULL COMMENT '响应流水号',
  `orderno` varchar(64) NOT NULL COMMENT '订单流水号',
  `outside_orderno` varchar(64) DEFAULT NULL COMMENT '外部订单流水号',
  `pay_price` decimal(8,2) unsigned NOT NULL COMMENT '支付金额',
  `pay_id` int(11) unsigned NOT NULL COMMENT '支付id',
  `pay_name` varchar(16) NOT NULL COMMENT '支付名称',
  `is_pay` tinyint(1) unsigned DEFAULT '0' COMMENT '是否支付',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单支付记录表';

");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pay_log');
    }
}
