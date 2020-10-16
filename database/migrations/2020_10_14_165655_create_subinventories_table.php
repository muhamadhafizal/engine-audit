<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubinventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subinventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('formid')->nullable();
            $table->integer('subequipmentid')->nullable();
            $table->string('lightingidentification')->nullable();
            $table->string('typeoflighting')->nullable();
            $table->string('powerrating')->nullable();
            $table->string('frominventory')->nullable();
            $table->string('actual')->nullable();
            $table->string('loadfactory')->nullalbe();
            $table->string('totalnumberoffixtures')->nullable();
            $table->string('numberoflightbulbperfixtures')->nullable();
            $table->string('totalnumberoflightbulb')->nullable();
            $table->string('lightingreflector')->nullable();
            $table->string('controlsystem')->nullable();
            $table->string('switchontime')->nullable();
            $table->string('switchofftime')->nullable();
            $table->string('consumptionduration')->nullable();
            $table->string('peakdurationcostoperation')->nullable();
            $table->string('offpeakduration')->nullable();
            $table->string('annualoperationdays')->nullable();
            $table->string('lighting')->nullable();
            $table->string('powerratingperfixture')->nullable();
            $table->string('dailyenergyconsumtion')->nullable();
            $table->string('dailyenergycost')->nullable();
            $table->string('peakdurationcostenergy')->nullable();
            $table->string('offpeakdurationcost')->nullable();
            $table->string('annualenergycost')->nullable();
            $table->string('grandtotalannualenergyconsumption')->nullable();
            $table->string('grandtotalannualenergycost')->nullable();
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
        Schema::dropIfExists('subinventories');
    }
}
