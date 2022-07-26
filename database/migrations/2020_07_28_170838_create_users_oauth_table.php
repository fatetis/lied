<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersOauthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_user_oauth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT '0',
  `unionid` varchar(128) DEFAULT '0' COMMENT '多公众号下联合id',
  `openid` varchar(128) NOT NULL COMMENT '唯一授权id',
  `sex` tinyint(1) unsigned DEFAULT '0' COMMENT '性别1-男 2-女',
  `name` varchar(64) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '姓名',
  `thumb` int(10) unsigned DEFAULT '0' COMMENT '图片id',
  `type` tinyint(1) unsigned NOT NULL COMMENT '授权类型1-wechat',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
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
        Schema::dropIfExists('user_oauth');
    }
}
