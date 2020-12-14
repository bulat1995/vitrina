<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); //Наименование Подмножества
            $table->integer('_lft')->default(0); //Левая граница
            $table->integer('_rgt')->default(0); //Правая граница
            $table->integer('_lvl')->default(0); //Уровень
            $table->boolean('is_public')->default(0);///Опубликована ли статья
            $table->integer('parent_id')->nullable(); //для модели родитель-потомок
            $table->timestamp('published_date')->nullable(); //Дата публикации
            $table->string('logoPath')->nullable(); // Путь до папки с изображением
            $table->timestamps();
            $table->softDeletes();
            $table->index('_lft');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_categories');
    }
}
