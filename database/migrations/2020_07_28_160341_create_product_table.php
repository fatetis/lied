<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品ID',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '商品名称',
  `brand_id` int(10) NOT NULL COMMENT '商家品牌ID',
  `category_id` int(10) unsigned DEFAULT NULL COMMENT '商品类别ID',
  `virtual_quantity` int(8) DEFAULT '0' COMMENT '虚拟购买量',
  `line_price` decimal(8,2) unsigned DEFAULT '0.00' COMMENT '市场价格',
  `price` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '销售价格',
  `description` text COMMENT '商品描述',
  `content` text COMMENT '内容',
  `is_real` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否实物，1为是',
  `is_audit` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核，1为审核',
  `is_on_sale` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示，1为显示',
  `created_id` int(11) unsigned NOT NULL COMMENT '创建者id',
  `sort` int(4) unsigned DEFAULT '0' COMMENT '排序',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product-category_id` (`category_id`),
  CONSTRAINT `product-category_id` FOREIGN KEY (`category_id`) REFERENCES `lied_product_category` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商品基本表';



");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
