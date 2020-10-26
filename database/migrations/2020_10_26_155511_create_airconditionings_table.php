<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirconditioningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airconditionings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('actype')->nullable();
            $table->string('refrigerant')->nullable();
            $table->string('inverter')->nullable();
            $table->string('rating')->nullable();
            $table->string('controlsystem')->nullable();
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
        Schema::dropIfExists('airconditionings');
    }
}
