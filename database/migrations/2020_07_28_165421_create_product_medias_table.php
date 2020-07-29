<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
CREATE TABLE `lied_product_medias` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `product_id` int(11) unsigned NOT NULL COMMENT '产品id',
 `media_id` int(11) unsigned NOT NULL COMMENT '媒体id',
 `sort` int(4) NOT NULL COMMENT '排序',
 `created_at` datetime DEFAULT NULL,
 `updated_at` datetime DEFAULT NULL,
 `deleted_at` datetime DEFAULT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `product_media-product_id_media_id_sort` (`product_id`,`media_id`,`sort`) USING BTREE,
 KEY `product_media-product_id` (`product_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_medias');
    }
}
