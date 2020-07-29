<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_regions` (
  `region_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `region_path` varchar(20) DEFAULT NULL,
  `region_grade` mediumint(8) unsigned DEFAULT NULL,
  `e_name` varchar(64) NOT NULL COMMENT '名称拼音',
  `region_name` varchar(50) NOT NULL,
  `letter_id` int(11) unsigned NOT NULL COMMENT '字母表主键id',
  `region_code` varchar(10) DEFAULT NULL,
  `code_path` varchar(50) DEFAULT NULL,
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`region_id`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk ROW_FORMAT=DYNAMIC;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }
}
