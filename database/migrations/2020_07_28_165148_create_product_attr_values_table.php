<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductAttrValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_product_attr_values` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`product_attr_id` int(11) unsigned NOT NULL COMMENT '产品规格表id',
`name` varchar(64) NOT NULL COMMENT '规格名称',
`sort` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
`created_at` datetime DEFAULT NULL,
`updated_at` datetime DEFAULT NULL,
`deleted_at` datetime DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `product_attr_values-product_attr_id` (`product_attr_id`),
CONSTRAINT `product_attr_values-product_attr_id` FOREIGN KEY (`product_attr_id`) REFERENCES `lied_product_attr` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='产品规格值表';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_attr_values');
    }
}
