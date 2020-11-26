<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLightdeviationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lightdeviations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('projectid')->nullable();
            $table->string('overlitdeviation')->nullable();
            $table->string('overlitdatapoints')->nullable();
            $table->string('wellitdeviation')->nullable();
            $table->string('wellitdatapoints')->nullable();
            $table->string('underlitdeviation')->nullable();
            $table->string('underlitdatapoints')->nullable();
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
        Schema::dropIfExists('lightdeviations');
    }
}
