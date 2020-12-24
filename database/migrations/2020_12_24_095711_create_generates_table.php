<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('projectid')->nullable();
            $table->string('name')->nullable();
            $table->string('level')->nullable();
            $table->integer('levelone')->nullable();
            $table->integer('leveltwo')->nullable();
            $table->integer('levelthree')->nullable();
            $table->integer('levelfour')->nullable();
            $table->integer('levelfive')->nullable();
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
        Schema::dropIfExists('generates');
    }
}
