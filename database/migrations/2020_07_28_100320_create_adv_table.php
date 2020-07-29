<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAdvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_adv` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT '名称',
  `url` varchar(255) DEFAULT NULL COMMENT '广告链接',
  `thumb` int(10) NOT NULL COMMENT '广告图片',
  `position_id` int(10) unsigned NOT NULL COMMENT '广告位置ID',
  `region_city_id` varchar(64) NOT NULL COMMENT '展示城市ID',
  `start_time` datetime NOT NULL  COMMENT '开始时间',
  `end_time` datetime NOT NULL COMMENT '结束时间',
  `click_num` int(10) DEFAULT '0' COMMENT '点击数量',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示 1-显示 0-不显示',
  `sort_order` int(4) DEFAULT NULL COMMENT '排序',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `position_id` (`position_id`),
  CONSTRAINT `adv-position_id` FOREIGN KEY (`position_id`) REFERENCES `lied_adv_position` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告展示表';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adv');
    }
}
