<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('parse')->create('attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pagination_id')->unsigned();
            $table->string('attribute', 255);
            $table->integer('parsed')->default(0);
            $table->timestamps();
            $table->foreign('pagination_id')
                ->references('id')
                ->on('pagination');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributes');
    }
}
