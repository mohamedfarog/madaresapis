<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStateToJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn('advertise_area');
            $table->string('country')->default('Saudi Arabia');
            $table->string('state')->default('Al Riyadh');
            $table->tinyInteger('language')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->string('advertise_area');
            $table->dropColumn('country');
            $table->dropColumn('state');
            $table->dropColumn('language');

        });
    }
}
