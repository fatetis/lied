<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE TABLE `lied_user_address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `name` varchar(16) NOT NULL COMMENT '收货人姓名',
  `region_pid` int(11) unsigned NOT NULL COMMENT '省id',
  `region_cid` int(11) unsigned NOT NULL COMMENT '市id',
  `region_aid` int(11) unsigned NOT NULL COMMENT '区id',
  `address` varchar(255) NOT NULL COMMENT '收货人地址',
  `mobile` char(11) NOT NULL COMMENT '收货人手机号',
  `code` char(6) DEFAULT NULL COMMENT '邮政编码',
  `is_default` tinyint(1) unsigned DEFAULT '0' COMMENT '是否为默认',
  `sort` int(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户地址表';

");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_address');
    }
}
