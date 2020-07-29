<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLogErrorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_log_error` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `input` text NOT NULL COMMENT '请求参数',
  `ip` varchar(64) NOT NULL COMMENT '请求ip',
  `path` varchar(255) DEFAULT NULL COMMENT '请求路径',
  `method` varchar(16) DEFAULT NULL COMMENT '请求方法',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='错误日志';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_error');
    }
}
