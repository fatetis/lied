<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVerifyCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_verify_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(32) NOT NULL COMMENT '账户',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型 0-手机 1-邮箱',
  `code` char(6) NOT NULL COMMENT '验证码',
  `using_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '使用类型 0-登录 1-注册',
  `repeat_num` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '重复次数',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `verify_code-mobile-normal` (`account`) USING BTREE
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
        Schema::dropIfExists('verify_code');
    }
}
