<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDatacoins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datacoins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coin_id');
            $table->decimal('block_time', 50, 25);
            $table->decimal('block_reward', 50, 25);
            $table->decimal('nethash', 50, 25);
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
        //
    }
}
