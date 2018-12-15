<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLodgeMetroStation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lodge_metro_station', function (Blueprint $table) {
            $table->integer('lodge_id')->unsigned();
            $table->integer('metro_station_id')->unsigned();
            $table->integer('distance');
            $table->timestamps();

            $table->primary(['lodge_id', 'metro_station_id']);

            $table->foreign('lodge_id')
                ->references('id')
                ->on('lodges')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('metro_station_id')
                ->references('id')
                ->on('metro_stations')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_lodge_station');
    }
}
