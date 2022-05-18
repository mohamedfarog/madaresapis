<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobActAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('job_act_applies');  
        Schema::create('job_act_applies', function (Blueprint $table) {
            $table->id();
            $table->integer('teacher_id')->unsigned()->nullable();
            $table->integer('job_id')->unsigned()->nullable();
            $table->timestamp('apply_date')->nullable();
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
        Schema::dropIfExists('job_act_applies');
    }
}
