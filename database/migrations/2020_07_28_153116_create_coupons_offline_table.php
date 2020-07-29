<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCouponsOfflineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_coupons_offline` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_batch_id` int(10) unsigned NOT NULL COMMENT '优惠券线下券生成批次设置表id',
  `code` varchar(16) NOT NULL COMMENT '券码',
  `is_use` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否使用 1-使用 0-未使用',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `coupons_offline-coupon_batch_id` (`coupon_batch_id`),
  CONSTRAINT `coupons_offline-coupon_batch_id` FOREIGN KEY (`coupon_batch_id`) REFERENCES `lied_coupons_batch` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券线下券生成码记录表';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons_offline');
    }
}
