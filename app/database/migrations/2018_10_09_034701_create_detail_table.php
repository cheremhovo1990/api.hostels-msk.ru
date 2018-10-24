<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pagination_id')->unsigned();
            $table->string('name', 255);
            $table->string('title', 255)->nullable();
            $table->integer('rating')->nullable();
            $table->string('description_href', 255)->nullable();
            $table->string('text', 255)->nullable();
            $table->string('brand_img_href', 255)->nullable();
            $table->double('latitude', 12, 10);
            $table->double('longitude', 12, 10);
            $table->string('address', 255);
            $table->string('branch_href', 255)->nullable();
            $table->string('work_hour', 255)->nullable();
            $table->string('img_href', 255)->nullable();
            $table->string('site', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('comment_href', 255)->nullable();
            $table->integer('parsed')->default(0);
            $table->timestamps();

            $table->foreign('pagination_id')->references('id')->on('pagination');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('details');
    }
}
