<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductSkuStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_product_sku_stock` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`product_id` int(11) unsigned NOT NULL COMMENT '产品id',
`sku_id` int(11) unsigned NOT NULL COMMENT '产品sku表id',
`quantity` int(11) unsigned NOT NULL COMMENT '数量',
`warn_number` int(11) unsigned DEFAULT NULL COMMENT '报警数量',
`created_at` datetime DEFAULT NULL,
`updated_at` datetime DEFAULT NULL,
`deleted_at` datetime DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `product_sku_stock-product_id` (`product_id`),
KEY `product_sku_stock-product_sku_id` (`sku_id`),
CONSTRAINT `product_sku_stock-product_id` FOREIGN KEY (`product_id`) REFERENCES `lied_product` (`id`) ON UPDATE CASCADE,
CONSTRAINT `product_sku_stock-product_sku_id` FOREIGN KEY (`sku_id`) REFERENCES `lied_product_sku` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品sku库存表';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_sku_stock');
    }
}
