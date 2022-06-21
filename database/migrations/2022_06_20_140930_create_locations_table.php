<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('locations');

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->integer('country_id')->nullable();
            $table->string('ar_country')->nullable();;
            $table->string('en_country');
            $table->string('ar_city_name');
            $table->string('en_city_name');
            $table->string('ar_street');
            $table->string('en_street');
            $table->string('building_no')->nullable();;
            $table->string('location_code')->nullable();;
            $table->foreignId('teacher_id');
            $table->foreignId('academy_id');
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
        Schema::dropIfExists('locations');
    }
}
