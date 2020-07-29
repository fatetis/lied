<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_users_coupon` (
`id` int(10) unsigned NOT NULL,
`coupon_id` int(10) unsigned NOT NULL COMMENT '优惠券id',
`coupon_limit_id` int(10) unsigned NOT NULL COMMENT '优惠券限领取表id',
`user_id` int(10) unsigned NOT NULL COMMENT '用户id',
`use_time` datetime COMMENT '使用时间',
`created_at` datetime DEFAULT NULL,
`updated_at` datetime DEFAULT NULL,
`deleted_at` datetime DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `users_coupon-coupon_id` (`coupon_id`),
CONSTRAINT `users_coupon-coupon_id` FOREIGN KEY (`coupon_id`) REFERENCES `lied_coupons` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户优惠券表';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_coupon');
    }
}
