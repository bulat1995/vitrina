<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopProductPhotosTable extends Migration
{
    /**
     * Run the migrations.
     * Фотографии товара
     * @return void
     */
    public function up()
    {
        Schema::create('shop_product_photos', function (Blueprint $table) {
            $table->id();
            //Указатель на товар
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('shop_products');
            //Путь до фотографии
            $table->string('path');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_product_photos');
    }
}
