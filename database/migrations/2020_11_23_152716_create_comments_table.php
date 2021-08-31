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
  `type` tinyint(1) unsigned NOT NULL COMMENT '类型 0-订单',
  `id_value` int(11) unsigned NOT NULL COMMENT '对应类型type的唯一标识',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论父节点',
  `user_id` int(11) unsigned DEFAULT '0',
  `user_name` varchar(64) DEFAULT NULL COMMENT '名称',
  `user_media_id` int(11) unsigned DEFAULT '0' COMMENT '图像id',
  `content` varchar(255) DEFAULT NULL COMMENT '内容',
  `content_rank` decimal(4,1) unsigned DEFAULT NULL COMMENT '分数 满分5分',
  `like_num` int(4) unsigned DEFAULT '0' COMMENT '点赞数量',
  `is_quality` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否优质评论',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `is_follow` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否追评 1-是 0-否',
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
