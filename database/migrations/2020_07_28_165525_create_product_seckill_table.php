<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductSeckillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_product_seckill` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`product_id` int(10) unsigned NOT NULL COMMENT '产品id',
`stock_number` int(4) unsigned NOT NULL COMMENT '秒杀库存',
`limit_user` varchar(128) DEFAULT '0' COMMENT '限定用户',
`limit_buy_num` int(4) unsigned DEFAULT '0' COMMENT '限定用户购买次数',
`start_time` datetime NOT NULL COMMENT '开始时间',
`end_time` datetime NOT NULL  COMMENT '结束时间',
`is_show` tinyint(1) NOT NULL COMMENT '是否显示 1为显示',
`created_at` datetime DEFAULT NULL,
`updated_at` datetime DEFAULT NULL,
`deleted_at` datetime DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `seckill-product_id` (`product_id`),
CONSTRAINT `seckill-product_id` FOREIGN KEY (`product_id`) REFERENCES `lied_product` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='秒杀产品管理';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_seckill');
    }
}
