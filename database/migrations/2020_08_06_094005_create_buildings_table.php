<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('projectid');
            $table->string('companyname')->nullable();
            $table->string('companyaddress')->nullable();
            $table->string('companyfaxnum')->nullable();
            $table->string('companyemail')->nullable();
            $table->string('designation')->nullable();
            $table->string('picname')->nullable();
            $table->string('picphone')->nullable();
            $table->string('picfaxnum')->nullable();
            $table->string('picemail')->nullable();
            $table->string('electricalenergymanage')->nullable();
            $table->string('noofstaff')->nullable();
            $table->string('electricaltariffcategory')->nullable();
            $table->string('buildingage')->nullable();
            $table->string('buildingfunction')->nullable();
            $table->string('noofblock')->nullable();
            $table->string('grossfloorarea')->nullable();
            $table->string('percentofgross')->nullable();
            $table->string('serverarea')->nullable();
            $table->string('parkingarea')->nullable();
            $table->string('designedoccupant')->nullable();
            $table->string('actualoccupant')->nullable();
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
        Schema::dropIfExists('buildings');
    }
}
