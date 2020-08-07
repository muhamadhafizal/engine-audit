<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('productid');
            $table->string('operationhours')->nullable();
            $table->string('averageoperations')->nullable();
            $table->string('operationMon')->nullable();
            $table->string('startMon')->nullable();
            $table->string('endMon')->nullable();
            $table->string('timeMon')->nullable();
            $table->string('operationTues')->nullable();
            $table->string('startTues')->nullable();
            $table->string('endTues')->nullable();
            $table->string('timeTues')->nullable();
            $table->string('operationWed')->nullable();
            $table->string('startWed')->nullable();
            $table->string('endWed')->nullable();
            $table->string('timeWed')->nullable();
            $table->string('operationThurs')->nullable();
            $table->string('startThurs')->nullable();
            $table->string('endThurs')->nullable();
            $table->string('timeThurs')->nullable();
            $table->string('operationFri')->nullable();
            $table->string('startFri')->nullable();
            $table->string('endFri')->nullable();
            $table->string('timeFri')->nullable();
            $table->string('operationSat')->nullable();
            $table->string('startSat')->nullable();
            $table->string('endSat')->nullable();
            $table->string('timeSat')->nullable();
            $table->string('operationSun')->nullable();
            $table->string('startSun')->nullable();
            $table->string('endSun')->nullable();
            $table->string('timeSun')->nullable();
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
        Schema::dropIfExists('operations');
    }
}
