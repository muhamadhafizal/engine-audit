<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('projectid');
            $table->string('category')->nullable();
            $table->string('acceptpotentailScore')->nullable();
            $table->string('acceptpotentialRemarks')->nullable();
            $table->string('managementCommScore')->nullable();
            $table->string('managementCommRemarks')->nullable();
            $table->string('rolesScore')->nullable();
            $table->string('rolesRemarks')->nullable();
            $table->string('seusScore')->nullable();
            $table->string('seusRemarks')->nullable();
            $table->string('baselineScore')->nullable();
            $table->string('baselineRemarks')->nullable();
            $table->string('enpiScore')->nullable();
            $table->string('enpiRemarks')->nullable();
            $table->string('objectiveScore')->nullable();
            $table->string('objectiveRemakrs')->nullable();
            $table->string('actionScore')->nullable();
            $table->string('actionRemarks')->nullable();
            $table->string('internalScore')->nullable();
            $table->string('internalRemarks')->nullable();
            $table->string('energyScore')->nullable();
            $table->string('energyRemarks')->nullable();
            $table->string('organizationScore')->nullable();
            $table->string('organizationRemarks')->nullable();
            $table->string('motivationScore')->nullable();
            $table->string('motivationRemarks')->nullable();
            $table->string('informationScore')->nullable();
            $table->string('informationRemarks')->nullable();
            $table->string('marketingScore')->nullable();
            $table->string('marketingRemarks')->nullable();
            $table->string('investmentScore')->nullable();
            $table->string('investmentRemarks')->nullable();


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
        Schema::dropIfExists('reviews');
    }
}
