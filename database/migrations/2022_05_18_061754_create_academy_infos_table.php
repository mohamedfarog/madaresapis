<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademyInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('academy_infos');
        Schema::create('academy_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('sets')->unsigned()->nullable();
            $table->string('academy_ar_name');
            $table->string('academy_en_name');
            $table->timestamp('stablish_date')->nullable();
            $table->string('website_url');
            $table->string('image');
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
        Schema::dropIfExists('academy_infos');
    }
}
