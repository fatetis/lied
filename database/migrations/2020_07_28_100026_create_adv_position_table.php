<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAdvPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_adv_position` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(32) NOT NULL COMMENT '名称',
 `width` int(8) NOT NULL COMMENT '宽度',
 `height` int(8) NOT NULL COMMENT '高度',
 `is_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示 1-显示 0-不显示',
 `sort_order` int(4) DEFAULT NULL COMMENT '排序',
 `created_at` datetime DEFAULT NULL,
 `updated_at` datetime DEFAULT NULL,
 `deleted_at` datetime DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告位置表';
");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adv_position');
    }
}
