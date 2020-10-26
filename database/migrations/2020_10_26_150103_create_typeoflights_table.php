<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeoflightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('typeoflights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('typeoflight')->nullable();
            $table->string('averageefficacy')->nullable();
            $table->string('colourrenderingindex')->nullable();
            $table->string('typicalapplication')->nullable();
            $table->string('typicallifespan')->nullable();
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
        Schema::dropIfExists('typeoflights');
    }
}
