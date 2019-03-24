<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLodgePropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lodge_property', function (Blueprint $table) {
            $table->integer('lodge_id')->unsigned();
            $table->integer('property_id')->unsigned();

            $table->unique(['lodge_id', 'property_id']);

            $table->foreign('lodge_id')->references('id')->on('lodges');
            $table->foreign('property_id')->references('id')->on('properties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lodge_property');
    }
}
