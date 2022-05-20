<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobAppSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_app_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('communicate_method_id');
            $table->boolean('submit_resume')->default(true);
            $table->enum('receive_by' , ['email' , 'walk-in'])->default('email');
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
        Schema::dropIfExists('job_app_settings');
    }
}
