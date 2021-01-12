<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('projectid')->nullable();
            $table->integer('formid')->nullable();
            $table->integer('subequipmentid')->nullable();
            $table->string('status')->nullable();
            $table->string('luxstandard')->nullable();
            $table->string('effieciency')->nullable();
            $table->string('currentinstallation')->nullable();
            $table->string('correctivemeasure')->nullalble();
            $table->string('effieciencyresult')->nullable();
            $table->string('controlsystem')->nullable();
            $table->string('controlsystemsresult')->nullable();
            $table->string('lampcheck')->nullable();
            $table->string('lampcheckresult')->nullable();
            $table->string('daylightavailability')->nullable();
            $table->string('daylightavailabilityresult')->nullable();
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
        Schema::dropIfExists('ecm');
    }
}
