<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("

CREATE TABLE `lied_comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
  `base_id` int(11) unsigned NOT NULL COMMENT '订单基础表id',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论父节点',
  `content` varchar(255) DEFAULT NULL COMMENT '内容',
  `content_rank` decimal(1,1) unsigned DEFAULT NULL COMMENT '分数 满分5分',
  `is_quality` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否优质评论',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `is_brand` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否商家评论',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户评论表';




        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
