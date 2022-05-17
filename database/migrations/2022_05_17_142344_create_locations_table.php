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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->integer('country_id')->unsigned()->nullable();
            $table->string('ar_city_name');
            $table->string('en_city_name');
            $table->string('ar_street');
            $table->string('en_street');
            $table->integer('ar_building_no')->unsigned()->nullable();
            $table->integer('en_building_no')->unsigned()->nullable();
            $table->string('location_code');
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
