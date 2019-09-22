<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAdministrativeMunicipalityLodgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lodges', function (Blueprint $table) {
            $table->integer('administrative_district_id')->nullable()->unsigned()->change();
            $table->integer('municipality_id')->nullable()->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lodges', function (Blueprint $table) {
            $table->integer('administrative_district_id')->unsigned()->after('city_id')->change();
            $table->integer('municipality_id')->unsigned()->change();
        });
    }
}
