<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_media` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`type` tinyint(1) unsigned DEFAULT '1' COMMENT '媒体类型 1-图片 2-文件 3-多媒体',
`link` varchar(255) DEFAULT '0',
`rlink` varchar(255) DEFAULT '0' COMMENT '原件地址',
`size` smallint(6) unsigned DEFAULT '0' COMMENT '文件大小 以kb为单位',
`file_ext` char(16) DEFAULT '0' COMMENT '文件后缀',
`file_name` varchar(128) DEFAULT '0' COMMENT '文件名称',
`is_lock` tinyint(1) unsigned DEFAULT '0' COMMENT '是否上锁 0-否 1-是',
`is_show` tinyint(1) unsigned DEFAULT '1' COMMENT '显示',
`created_at` datetime DEFAULT NULL,
`updated_at` datetime DEFAULT NULL,
`deleted_at` datetime DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
