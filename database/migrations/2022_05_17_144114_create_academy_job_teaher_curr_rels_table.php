<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademyJobTeaherCurrRelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('academy_job_teaher_curr_rels'); 
        Schema::create('academy_job_teaher_curr_rels', function (Blueprint $table) {
            $table->id();
            $table->integer('academy_id')->unsigned()->nullable();
            $table->integer('job_type_id')->unsigned()->nullable();
            $table->integer('location_id')->unsigned()->nullable();
            $table->timestamp('created_date')->nullable();
            $table->string('job_desc');
            $table->boolean('is_active')->default(0);
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
        Schema::dropIfExists('academy_job_teaher_curr_rels');
    }
}
