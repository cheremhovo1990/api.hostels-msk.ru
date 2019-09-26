<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLodgePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lodge_properties', function (Blueprint $table) {
            $table->integer('form_id')->refenrences('id')->on('id')->onDelete('CASCADE');
            $table->integer('wi_fi')->default(0)->comment('Wi-Fi');
            $table->integer('24_hour_reception')->default(0)->comment('Круглосуточная стойка регистрации');
            $table->integer('fridge')->default(0)->comment('Холодильник');
            $table->integer('television')->default(0)->comment('Телевизор');
            $table->integer('bunk_bed')->default(0)->comment('Двухъярусные кровати');
            $table->integer('single_beds')->default(0)->comment('Одноярусные кровати');
            $table->integer('orthopedic_mattress')->default(0)->comment('Ортопедические матрасы');
            $table->integer('daily_cleaning')->default(0)->comment('Ежедневная уборка');
            $table->integer('24_hour_security')->default(0)->comment('Круглосуточная охрана');
            $table->integer('conditioner')->default(0)->comment('Кондиционер');
            $table->integer('soundproofing')->default(0)->comment('Шумоизоляция');
            $table->integer('kitchen')->default(0)->comment('Кухня');
            $table->integer('bath')->default(0)->comment('Ванна');
            $table->integer('shower')->default(0)->comment('Душ');
            $table->integer('washer')->default(0)->comment('Стиральная машина');
            $table->integer('drying_machine')->default(0)->comment('Сушильная машина');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lodge_properties');
    }
}
