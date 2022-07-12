<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->text('job_responsibilities')->nullable()->change();
            $table->text('job_benefits')->nullable()->change();
            $table->text('job_experience')->nullable()->change();
            $table->boolean('status')->default(true)->change();
            $table->date('expected_start_date')->default(Carbon::now())->change();
            $table->date('job_deadline')->default(Carbon::now())->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            //
        });
    }
}
