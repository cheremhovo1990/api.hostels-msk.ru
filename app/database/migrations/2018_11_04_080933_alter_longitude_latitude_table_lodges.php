<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLongitudeLatitudeTableLodges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lodges', function (Blueprint $table) {
            $table->dropColumn('longitude');
            $table->dropColumn('latitude');
        });
        Schema::table('lodges', function (Blueprint $table) {
            $table->double('longitude', 18, 16)->after('phone');
            $table->double('latitude', 18, 16)->after('phone');
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
            $table->dropColumn('longitude');
            $table->dropColumn('latitude');
        });
        Schema::table('lodges', function (Blueprint $table) {
            $table->double('longitude', 12, 10)->after('phone');
            $table->double('latitude', 12, 10)->after('phone');
        });
    }
}
