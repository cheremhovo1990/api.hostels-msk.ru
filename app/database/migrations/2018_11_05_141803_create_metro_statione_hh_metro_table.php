<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetroStationeHhMetroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metro_station_hh_metro', function (Blueprint $table) {
            $table->integer('metro_station_id')->unsigned();
            $table->float('hh_metro_id', 5, 3);
            $table->foreign('metro_station_id')->references('id')->on('metro_stations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metro_station_hh_metro');
    }
}
