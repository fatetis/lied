<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_brand` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL COMMENT '品牌名称',
  `category_id` int(10) unsigned DEFAULT '0' COMMENT '品牌分类id',
  `media_id` int(10) unsigned NOT NULL COMMENT '品牌logo',
  `description` text NOT NULL COMMENT '品牌描述',
  `site_url` varchar(255) NOT NULL COMMENT '品牌的网址',
  `sort` tinyint(4) unsigned NOT NULL COMMENT '排序',
  `is_audit` tinyint(1) NOT NULL,
  `is_show` tinyint(1) NOT NULL COMMENT '是否显示',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `brand-category_id` (`category_id`),
  KEY `brand-thumb` (`media_id`),
  CONSTRAINT `brand-category_id` FOREIGN KEY (`category_id`) REFERENCES `lied_brand_category` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `brand-thumb` FOREIGN KEY (`media_id`) REFERENCES `lied_media` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brand');
    }
}
