<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductParameters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_parameters', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('parameter_id');
            $table->text('value');

            $table->foreign('product_id')->references('id')->on('shop_products')->onDelete('cascade');
            $table->foreign('parameter_id')->references('id')->on('shop_parameters')->onDelete('cascade');

            $table->primary(['product_id','parameter_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_parameters');
    }
}
