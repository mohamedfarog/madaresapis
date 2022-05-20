<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppInteractionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id');
            $table->foreignId('teacher_id');
            $table->unsignedBigInteger('applied_count')->nullable()->default(0);
            $table->unsignedBigInteger('view_count')->nullable()->default(0);
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
        Schema::dropIfExists('app_interactions');
    }
}
