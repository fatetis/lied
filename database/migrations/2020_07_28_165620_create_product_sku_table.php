<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductSkuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_product_sku` (
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`product_id` int(11) unsigned NOT NULL COMMENT '产品id',
`attr_key` varchar(64) NOT NULL COMMENT '销售属性标识 - 链接，按小到大排序, attr_values表的id',
`media_id` int(11) unsigned NOT NULL COMMENT '缩略图',
`price` decimal(8,2) unsigned NOT NULL COMMENT '价格',
`cost_price` decimal(8,2) unsigned NOT NULL COMMENT '成本价格',
`sold_num` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '销量',
`code` varchar(64) DEFAULT '' COMMENT '编码',
`created_at` datetime DEFAULT NULL,
`updated_at` datetime DEFAULT NULL,
`deleted_at` datetime DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `product_sku-product_id` (`product_id`),
CONSTRAINT `product_sku-product_id` FOREIGN KEY (`product_id`) REFERENCES `lied_product` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='产品sku表';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_sku');
    }
}
