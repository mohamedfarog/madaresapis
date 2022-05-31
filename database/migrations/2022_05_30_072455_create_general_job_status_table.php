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
            $table->string('en_applicant_name');
            $table->string('ar_applicant_name');
            $table->string('en_viwed');
            $table->string('ar_viwed');
            $table->string('en_interview');
            $table->string('ar_interview');
            $table->string('en_rejected');
            $table->string('ar_rejected');
            $table->string('en_accepted');
            $table->string('ar_accepted');
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
