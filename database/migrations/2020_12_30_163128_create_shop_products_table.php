<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopProductsTable extends Migration
{
    /**
     * Run the migrations.
     * Товар 
     * @return void
     */
    public function up()
    {
        Schema::create('shop_products', function (Blueprint $table) {
            $table->id();
            //Наименование товара
            $table->string('name');
            //Стоимость
            $table->integer('price');
            //Категория товара
            $table->unsignedBigInteger('category_id');
            //Пользователь создавший товар
            $table->unsignedBigInteger('user');

            $table->foreign('category_id')->references('id')->on('shop_categories');
            $table->foreign('user')->references('id')->on('users');
            $table->timestamps();
            $table->index(['name','price']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_products');
    }
}
