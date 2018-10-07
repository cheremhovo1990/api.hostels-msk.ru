<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagenationPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagination', function (Blueprint $table) {
            $table->increments('id');
            $table->string('href', 255)->unique();
            $table->string('title', 255);
            $table->string('adv', 255);
            $table->string('address', 255);
            $table->string('branch_href', 255)->nullable()->unique();
            $table->integer('rating');
            $table->string('brand_img_href', 255)->nullable()->unique();
            $table->integer('parsed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pagination');
    }
}
