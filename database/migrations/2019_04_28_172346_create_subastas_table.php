<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubastasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subastas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->Date('begin_date');
            $table->Date('end_date');
            $table->Date('open_date');
            $table->integer('initial_value');
            $table->bigInteger('property_id')->references('id')->on('properties');
            $table->boolean('open')->default(true); //Verdadero si esta abierta o no
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subastas');
    }
}
