<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUserCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_user_comment` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`pid` int(10) unsigned NOT NULL COMMENT '评论的父节点',
`type` tinyint(3) unsigned NOT NULL COMMENT '类型 0-产品 1-文章',
`id_value` int(10) unsigned NOT NULL COMMENT '所属类型表的id',
`user_id` int(10) unsigned NOT NULL COMMENT '用户id',
`content` text NOT NULL COMMENT '评论内容',
`rank` tinyint(1) unsigned NOT NULL COMMENT '评论的星星数 1~5星',
`is_show` tinyint(1) unsigned NOT NULL COMMENT '是否显示',
`created_at` datetime DEFAULT NULL,
`updated_at` datetime DEFAULT NULL,
`deleted_at` datetime DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户评论表';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_comment');
    }
}
