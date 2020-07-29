<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCouponsPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_coupons_price` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_id` int(10) unsigned NOT NULL COMMENT '优惠券id',
  `stock_number` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '库存数量',
  `price` decimal(8,2) unsigned NOT NULL COMMENT '优惠金额',
  `min_consume_price` decimal(8,2) unsigned DEFAULT '0.00' COMMENT '最低消费金额',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `coupons_price-coupon_id` (`coupon_id`),
  CONSTRAINT `coupons_price-coupon_id` FOREIGN KEY (`coupon_id`) REFERENCES `lied_coupons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='优惠券满减表';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons_price');
    }
}
