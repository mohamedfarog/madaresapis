<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AcademyInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('academy_info', function (Blueprint $table) {
            $table->id();
            $table->integer('academy_id')->unsigned()->nullable();
            $table->integer('sets')->unsigned()->nullable();
            $table->timestamp('stablish_date')->nullable();
            $table->string('website');
            $table->string('website_url');
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
        Schema::dropIfExists('academy_info');
    }
}
