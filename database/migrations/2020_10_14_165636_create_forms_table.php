<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('roomid')->nullable();
            $table->integer('equipmentid')->nullable();
            $table->string('roomname')->nullable();
            $table->string('roomfunction')->nullable();
            $table->string('roomarea')->nullable();
            $table->string('generalobservation')->nullable();
            $table->string('potentialfornaturallighting')->nullable();
            $table->string('windowsorientation')->nullable();
            $table->string('recommendedlux')->nullable();
            $table->string('samplingpoints')->nullable();
            $table->string('average')->nullable();
            $table->string('category')->nullable();
            $table->string('masterid')->nullable();
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
        Schema::dropIfExists('forms');
    }
}
