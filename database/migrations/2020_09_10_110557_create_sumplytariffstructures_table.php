<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSumplytariffstructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sumplytariffstructures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('projectid');
            $table->string('structurepeak');
            $table->string('structureoffpeak');
            $table->string('maxdemand');
            $table->string('mincharge');
            $table->string('timezonepeak');
            $table->string('timezoneoffpeak');
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
        Schema::dropIfExists('sumplytariffstructures');
    }
}
