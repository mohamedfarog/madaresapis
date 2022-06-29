<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('job_posts');
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academy_id');
            $table->foreignId('job_type_id');
            $table->foreignId('location_id');
            $table->timestamp('created_date');
            $table->string('job_desc');
            $table->boolean('is_active');
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
        Schema::dropIfExists('job_posts');
    }
}
