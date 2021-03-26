<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesParameters extends Migration
{
    /**
     * Run the migrations.
     * Сводная таблица Категория -< Параметр товара
     * @return void
     */
    public function up()
    {
        Schema::create('shop_category_shop_parameter', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('parameter_id');

            $table->foreign('category_id')->references('id')->on('shop_categories')->onDelete('cascade');
            $table->foreign('parameter_id')->references('id')->on('shop_parameters')->onDelete('cascade');
            $table->primary(['category_id','parameter_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_category_shop_parameter');
    }
}
