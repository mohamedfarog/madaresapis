<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersExperincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers_experinces', function (Blueprint $table) {
            $table->id();
            $table->integer('teacher_id')->unsigned()->nullable();
            $table->boolean('is_cureent_work')->default(0);
            $table->timestamp('sart_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('job_title');
            $table->string('academy_name');
            $table->integer('academy_id')->unsigned()->nullable();
            $table->integer('location_id')->unsigned()->nullable();
            $table->string('job_desc');
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
        Schema::dropIfExists('teachers_experinces');
    }
}
