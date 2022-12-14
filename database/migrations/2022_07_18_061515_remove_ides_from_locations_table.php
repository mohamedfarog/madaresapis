<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveIdesFromLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locations', function (Blueprint $table) {
            //
            $table->dropColumn('building_no');
            $table->dropColumn('location_code');
            $table->dropColumn('country_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
            //
        });
    }
}
