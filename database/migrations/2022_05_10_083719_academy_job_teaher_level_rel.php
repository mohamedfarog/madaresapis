<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AcademyJobTeaherLevelRel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_teaher_level_rel', function (Blueprint $table) {
            $table->id();
            $table->integer('teacher_id')->unsigned()->nullable();
            $table->integer('job_id')->unsigned()->nullable();
            $table->integer('skill_id')->unsigned()->nullable();
            $table->integer('skill_level')->unsigned()->nullable();
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
        Schema::dropIfExists('job_teaher_level_rel');
    }
}
