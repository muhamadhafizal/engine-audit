<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSinglelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('singlelines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('projectid');
            $table->string('name');
            $table->string('level');
            $table->string('levelone');
            $table->string('leveltwo');
            $table->string('levelthree');
            $table->string('levelfour');
            $table->string('levelfive');
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
        Schema::dropIfExists('singlelines');
    }
}
