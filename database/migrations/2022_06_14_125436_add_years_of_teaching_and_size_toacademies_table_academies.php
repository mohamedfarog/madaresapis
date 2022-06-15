<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddYearsOfTeachingAndSizeToacademiesTableAcademies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('academies', function (Blueprint $table) {
            $table->integer('years_of_teaching')->nullable();
            $table->integer('size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('academies', function (Blueprint $table) {
            //
        });
    }
}
