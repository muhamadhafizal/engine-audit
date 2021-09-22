<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcmresultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecmresults', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('project_id');
            $table->string('equipment');
            $table->string('total_annual_energy_saving')->nullable();
            $table->string('total_annual_cost_saving')->nullable();
            $table->string('total_investment_cost')->nullable();
            $table->string('total_payback_period')->nullable();
            $table->string('annual_energy_consumption_after_ecm')->nullable();
            $table->string('annual_cost_after_ecm')->nullable();
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
        Schema::dropIfExists('ecmresults');
    }
}
