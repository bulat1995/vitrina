<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     * Отзывы о товаре
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            //Содержимое отзыва
            $table->string('review');
            //Оценка товара
            $table->integer('estimate');
            //Товар
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('shop_products');
            //Пользователь
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            //Отзыв проверен
            $table->boolean('checked');
            
            $table->index('product_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
