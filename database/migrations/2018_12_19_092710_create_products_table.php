<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE TABLE `lied_products` (
  `id` int(16) NOT NULL AUTO_INCREMENT COMMENT '商品ID',
  `name` varchar(64) DEFAULT '' COMMENT '商品名称',
  `category_id` int(16) DEFAULT NULL COMMENT '商品类别ID',
  `brand_id` int(16) DEFAULT NULL COMMENT '商品品牌ID',
  `product_number` int(8) DEFAULT '0' COMMENT '库存数量',
  `sale_quantity` int(8) DEFAULT '0' COMMENT '销售量',
  `virtual_quantity` int(8) DEFAULT '0' COMMENT '虚拟购买量',
  `market_price` decimal(8,2) DEFAULT '0.00' COMMENT '市场价格',
  `shop_price` decimal(8,2) DEFAULT '0.00' COMMENT '销售价格',
  `freight` decimal(8,2) DEFAULT '0.00' COMMENT '运费',
  `brief` varchar(255) DEFAULT NULL COMMENT '简要描述',
  `description` text COMMENT '商品描述',
  `thumb` int(16) DEFAULT NULL COMMENT '商品缩略图',
  `photo_ids` varchar(128) DEFAULT NULL COMMENT '图库ID',
  `seller_id` int(16) DEFAULT NULL COMMENT '商家ID',
  `is_hot` tinyint(1) DEFAULT '0' COMMENT '是否热卖，1为是',
  `sort_order` int(4) DEFAULT NULL COMMENT '排序',
  `is_audit` tinyint(1) DEFAULT '0' COMMENT '审核，1为审核',
  `is_show` tinyint(1) DEFAULT '1' COMMENT '是否显示，1为显示',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品基本表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

