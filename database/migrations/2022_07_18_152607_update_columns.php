<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('jobs');
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->tinyInteger('gender');
            $table->foreignId('academy_id');
            $table->foreignId('job_subject_id');
            $table->foreignId('edu_level_id');
            $table->char('job_type_id')->nullable();
            $table->string('country')->default('Saudi Arabia');
            $table->string('state')->default('Al Riyadh');
            $table->tinyInteger('language')->nullable();
            $table->text('desc')->nullable();
            $table->unsignedBigInteger('job_vacancy')->default(1);
            $table->date('post_date');
            $table->date('close_date');
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('min_exp_id')->default(0);
            $table->double('salary_from')->nullable();
            $table->double('salary_to')->nullable();
            $table->foreignId('salary_rate_id')->nullable();
            $table->string('comunication_email')->nullable();
            $table->text('custom_questions')->nullable();
            
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
        Schema::dropIfExists('jobs');
    }
}
