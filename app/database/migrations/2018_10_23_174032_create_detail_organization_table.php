<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('parse')->create('detail_organization', function (Blueprint $table) {
            $table->integer('detail_id')->unsigned();
            $table->integer('organization_id')->unsigned();
            $table->primary(['detail_id', 'organization_id']);
            $table->foreign('detail_id')->references('id')->on('details');
            $table->foreign('organization_id')->references('id')->on('detail_organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_organization');
    }
}
