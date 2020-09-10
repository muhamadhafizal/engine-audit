<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSumplyinformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sumplyinformations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('projectid');
            $table->string('energysourceone');
            $table->string('energysourcetwo');
            $table->string('energysourcethree');
            $table->string('energycategoryone');
            $table->string('energycategorytwo');
            $table->string('energycategorythree');
            $table->string('providercompanyone');
            $table->string('providercompanytwo');
            $table->string('providercompanythree');
            $table->string('applicabletariffone');
            $table->string('applicabletarifftwo');
            $table->string('applicabletariffthree');
            $table->string('tariffvalidtyone');
            $table->string('tariffvalidtytwo');
            $table->string('tariffvalditythree');
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
        Schema::dropIfExists('sumplyinformations');
    }
}
