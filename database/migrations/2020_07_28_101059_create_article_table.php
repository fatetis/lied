<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章自增id',
  `category_id` int(10) unsigned NOT NULL COMMENT '分类id',
  `user_id` int(32) unsigned NOT NULL COMMENT '创建者id',
  `title` varchar(128) NOT NULL COMMENT '文章标题',
  `thumb` int(10) NOT NULL COMMENT '文章缩略图',
  `description` text COMMENT '简介',
  `content` text NOT NULL COMMENT '内容',
  `is_hot` tinyint(1) unsigned DEFAULT NULL COMMENT '热门文章',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `sort_order` int(4) unsigned DEFAULT NULL COMMENT '排序',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章表';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article');
    }
}
