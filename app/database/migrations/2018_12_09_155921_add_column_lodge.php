<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnLodge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lodges', function (Blueprint $table) {
            $table->integer('city_id')->unsigned()->after('organization_id');
            $table->string('opening_hours')->after('address');
            $table->json('schema_org')->after('opening_hours');
            $table->foreign('city_id')->references('id')->on('cities');
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
            $table->dropForeign('lodges_city_id_foreign');
            $table->dropColumn('city_id');
            $table->dropColumn('opening_hours');
            $table->dropColumn('schema_org');
        });
    }
}
