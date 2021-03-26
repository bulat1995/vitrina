<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopParametersTable extends Migration
{
    /**
     * Run the migrations.
     * Параметры товара
     * @return void
     */
    public function up()
    {
        Schema::create('shop_parameters', function (Blueprint $table) {
            $table->id();
            //Наименование товара
            $table->string('name');
            //Тип параметра
            $table->string('inputType');
            //Регулярное выражение || Список параметров доступных для выбора  
            $table->string('regular');
            //Рейтинг параметра (Нужен при выводе фильтра поиска)
            $table->integer('rating')->default(0);
            //Обязательность заполнения параметра
            $table->boolean('required')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_parameters');
    }
}
