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
        Schema::create('academy_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_type_id')->unsigned()->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('location_id')->unsigned()->nullable();
            $table->string('profile_pic');
            $table->string('cover_image');
            $table->string('gender');
            $table->string('email')->unique();
            $table->timestamp('date_of_birth')->nullable();
            $table->integer('phone_number');
            $table->boolean('is_active')->default(0);
            $table->timestamp('reg_date')->nullable();
            $table->string('twitter_profile'); 
            $table->string('facebook_profile'); 
            $table->string('linkend_profile'); 
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
