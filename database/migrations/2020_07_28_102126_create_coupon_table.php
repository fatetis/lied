<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_coupons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL COMMENT '优惠券名称',
  `reveive_limit` int(4) unsigned NOT NULL COMMENT '限领取数量',
  `use_start_time` datetime NOT NULL COMMENT '使用开始时间',
  `use_end_time` datetime NOT NULL COMMENT '使用结束时间',
  `receive_start_time` datetime NOT NULL COMMENT '领取开始时间',
  `receive_end_time` datetime NOT NULL COMMENT '领取结束时间',
  `thumb` int(10) unsigned NOT NULL COMMENT '缩略图',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `is_online` tinyint(1) unsigned NOT NULL COMMENT '核销方式 1-线上 0-线下',
  `is_show` tinyint(1) unsigned DEFAULT '0' COMMENT '显示 1-是 0-否',
  `sort_order` int(4) unsigned DEFAULT '0' COMMENT '排序',
  `created_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券基本表';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon');
    }
}
