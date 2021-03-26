<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteParametersTable extends Migration
{
    /**
     * Run the migrations.
     *  Параметры сайта отображаемые в шаблоне
     * @return void
     */
    public function up()
    {
        Schema::create('site_parameters', function (Blueprint $table) {
            $table->id();
            //Указатель параметра
            $table->string('slug')->unique();
            //Наименование параметра
            $table->string('name');
            //Значение
            $table->string('value')->nullable();
            $table->timestamps();
            $table->index(['slug']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_parameters');
    }
}
