<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticPagesTable extends Migration
{
    /**
     * Run the migrations.
     * Статические страницы сайта витрины
     * @return void
     */
    public function up()
    {
        Schema::create('static_pages', function (Blueprint $table) {
            $table->id();
            //Заголовок
            $table->string('title');
            //Указатель статьи
            $table->string('slug')->unique();
            //Содержимое
            $table->text('content');
            //Краткое описание
            $table->text('describe');
            //Дата публикации
            $table->datetime('datePublished')->nullable();
            //Категория
            $table->unsignedBigInteger('category')->nullable();
            $table->foreign('category')->references('id')->on('shop_categories');
            //Автор статьи
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            //Рейтинг (при выводе в меню шаблона shop.main)
            $table->integer('rating')->default(0);
            //Отображать в меню
            $table->boolean('in_menu')->default(0);
            //Отображать автора
            $table->boolean('show_user')->default(0);
            //Возможность комментирования(пока не реализовано)
            $table->boolean('can_comment')->default(0);
            //Возможность индексации страницы поисковым ботов
            $table->boolean('can_index')->default(0);
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
        Schema::dropIfExists('static_pages');
    }
}
