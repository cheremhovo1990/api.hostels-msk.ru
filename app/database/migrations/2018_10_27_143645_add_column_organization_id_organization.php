<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOrganizationIdOrganization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('parse')
            ->table('detail_organizations', function (Blueprint $table) {
                $table->integer('organization_id')->after('id');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('parse')
            ->table('detail_organizations', function (Blueprint $table) {
                $table->dropColumn('organization_id');
            });
    }
}
