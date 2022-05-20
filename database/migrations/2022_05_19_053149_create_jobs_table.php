<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academy_id');
            $table->foreignId('job_type_id');
            $table->foreignId('job_level_id');
            $table->foreignId('gender_id');
            $table->string('title' ,50);
            $table->string('advertise_area' ,100); # in future we need to it from  separate  Table for now i make it static
            $table->json('hiring_budget')->nullable();
            $table->unsignedBigInteger('job_vacancy')->default(1);
            $table->text('job_description');
            $table->date('expected_start_date');
            $table->date('job_deadline');
            $table->text('job_responsibilities');
            $table->text('job_benefits');
            $table->text('job_experience');
            // $table->boolean('status');
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
