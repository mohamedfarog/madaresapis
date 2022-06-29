<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralJobStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('general_job_status');

        Schema::create('general_job_status', function (Blueprint $table) {
            $table->id();
            $table->string('applicant_name');
            $table->string('viwed');
            $table->string('interview');
            $table->string('rejected');
            $table->string('accepted');
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
        Schema::dropIfExists('general_job_status');
    }
}
