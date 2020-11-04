<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
  `sku_id` int(11) unsigned NOT NULL COMMENT 'sku表主键id',
  `brand_id` int(11) unsigned NOT NULL COMMENT '品牌id',
  `number` int(4) unsigned NOT NULL COMMENT '产品书数量',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart-usre_id` (`user_id`),
  KEY `cart-product_id` (`sku_id`),
  KEY `cart-brand_id` (`brand_id`),
  CONSTRAINT `cart-user_id` FOREIGN KEY (`user_id`) REFERENCES `lied_users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购物车';

");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart');
    }
}
