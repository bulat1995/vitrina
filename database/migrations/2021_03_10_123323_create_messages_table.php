<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *  Сообщения пользователей
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            //Содержимое сообщения
            $table->string('message');
            //Отправитель
            $table->unsignedBigInteger('sender');
            $table->foreign('sender')->references('id')->on('users');
            //Получатель
            $table->unsignedBigInteger('recepient');
            $table->foreign('recepient')->references('id')->on('users');
            //Статус сообщения (прочитано|| непрочитано )
            $table->boolean('readed');

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
        Schema::dropIfExists('messages');
    }
}
