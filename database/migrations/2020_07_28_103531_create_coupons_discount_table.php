<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCouponsDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_coupons_discount` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_id` int(10) unsigned NOT NULL COMMENT '优惠券id',
  `discount` int(8) unsigned NOT NULL COMMENT '折扣',
  `stock_number` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '库存数量',
  `min_product_number` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '最小购买产品数量',
  `max_discount_price` decimal(8,2) unsigned DEFAULT '0.00' COMMENT '最大优惠金额',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `coupons_discount-coupon_id` (`coupon_id`),
  CONSTRAINT `coupons_discount-coupon_id` FOREIGN KEY (`coupon_id`) REFERENCES `lied_coupons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优惠券折扣表';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons_discount');
    }
}
