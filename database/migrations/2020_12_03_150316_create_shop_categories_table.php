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
            //Наименование Подмножества Категории
            $table->string('name'); 
            //Левая граница
            $table->integer('_lft')->default(0); 
            //Правая граница
            $table->integer('_rgt')->default(0); 
            //Уровень
            $table->integer('_lvl')->default(0); 
            //Опубликована ли статья
            $table->boolean('is_public')->default(0);
            //для модели родитель-потомок
            $table->integer('parent_id')->nullable(); 
            //Дата публикации
            $table->timestamp('published_date')->nullable(); 
            // Путь до папки с изображением
            $table->string('logoPath')->nullable(); 
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
