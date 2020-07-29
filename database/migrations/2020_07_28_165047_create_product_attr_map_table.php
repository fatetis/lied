<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductAttrMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_product_attr_map` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`product_id` int(11) unsigned NOT NULL COMMENT '产品id',
`product_attr_id` int(11) unsigned NOT NULL COMMENT '产品规格id',
`sort` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
`created_at` datetime DEFAULT NULL,
`updated_at` datetime DEFAULT NULL,
`deleted_at` datetime DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `product_attr_map-product_id` (`product_id`),
KEY `product_attr_map_product_attr_id` (`product_attr_id`),
CONSTRAINT `product_attr_map-product_id` FOREIGN KEY (`product_id`) REFERENCES `lied_product` (`id`) ON UPDATE CASCADE,
CONSTRAINT `product_attr_map_product_attr_id` FOREIGN KEY (`product_attr_id`) REFERENCES `lied_product_attr` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品与规格关系表';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_attr_map');
    }
}
