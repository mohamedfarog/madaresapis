<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class JobPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_post', function (Blueprint $table) {
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
        Schema::dropIfExists('job_post');
    }
}
