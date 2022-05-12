<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AcademyRating extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academy_rating', function (Blueprint $table) {
            $table->id();
            $table->integer('rating_id')->unsigned()->nullable();
            $table->integer('rating_num')->unsigned()->nullable();
            $table->integer('academy_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academy_rating');
    }
}
