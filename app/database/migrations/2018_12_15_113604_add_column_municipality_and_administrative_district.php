<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMunicipalityAndAdministrativeDistrict extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lodges', function (Blueprint $table) {
            $table->integer('administrative_district_id')->unsigned()->after('city_id');
            $table->integer('municipality_id')->unsigned()->after('administrative_district_id');

            $table->foreign('administrative_district_id')
                ->references('id')
                ->on('administrative_districts');

            $table->foreign('municipality_id')
                ->references('id')
                ->on('municipalities');
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
            $table->dropForeign('lodges_municipality_id_foreign');
            $table->dropForeign('lodges_administrative_district_id_foreign');
            $table->dropColumn('municipality_id');
            $table->dropColumn('administrative_district_id');
        });
    }
}
