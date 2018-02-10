<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceBittrexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_bittrex', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coin_id');
            $table->decimal('High', 50, 25);
            $table->decimal('Low', 50, 25);
            $table->decimal('Last', 50, 25);
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
        Schema::dropIfExists('price_bittrex');
    }
}
