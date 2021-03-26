<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *  Слайдер 
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            //Категория
            $table->string('category')->nullable();
            //Заголовок
            $table->string('title');
            //Описание
            $table->string('describe');
            //Надпись на кнопке
            $table->string('buttonText');
            //Путь до изображения 
            $table->string('image');
            //Ссылка на кнопке
            $table->string('href');
            //Отображать или нет
            $table->boolean('show');
            //Открывать ссылку в новой вкладке
            $table->boolean('blank');
            //Рейтинг 
            $table->integer('rating')->default(0);
            //Срок отображения слайдера
            $table->datetime('show_until')->nullable();
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
        Schema::dropIfExists('sliders');
    }
}
