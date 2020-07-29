<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCouponsBatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_coupons_batch` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(64) NOT NULL COMMENT '批次名称',
`num` int(4) unsigned NOT NULL COMMENT '生成数量',
`coupon_id` int(10) unsigned NOT NULL COMMENT '优惠券id',
`coupon_limit_id` int(10) unsigned NOT NULL COMMENT '优惠券限领表id',
`created_id` int(10) unsigned NOT NULL COMMENT '创建者id',
`created_at` datetime DEFAULT NULL,
`updated_at` datetime DEFAULT NULL,
`deleted_at` datetime DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `coupons_batch-coupon_limit_id` (`coupon_limit_id`),
KEY `coupons_batch-coupon_id` (`coupon_id`),
CONSTRAINT `coupons_batch-coupon_id` FOREIGN KEY (`coupon_id`) REFERENCES `lied_coupons` (`id`) ON UPDATE CASCADE,
CONSTRAINT `coupons_batch-coupon_limit_id` FOREIGN KEY (`coupon_limit_id`) REFERENCES `lied_coupons_limit` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券线下券生成批次设置表';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons_batch');
    }
}
