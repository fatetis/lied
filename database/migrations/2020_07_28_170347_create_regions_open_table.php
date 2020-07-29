<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRegionsOpenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_regions_open` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`region_id` int(10) unsigned NOT NULL COMMENT '开通城市regions表id',
`is_show` tinyint(1) unsigned DEFAULT '0' COMMENT '显示',
`sort_order` int(4) unsigned DEFAULT NULL COMMENT '排序',
`created_at` datetime DEFAULT NULL,
`updated_at` datetime DEFAULT NULL,
`deleted_at` datetime DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='城市开通表';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions_open');
    }
}
