<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('user_id');
            $table->foreignId('gender_id');
            $table->foreignId('job_level_id'); // [preschool , early childhood ,permanent ,...  ]
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('mobile');
            $table->date('date_of_birth');
            $table->string('avatar', 50)->nullable();
            $table->string('academic_major', 100)->nullable();
            $table->text('bio')->nullable();
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
        Schema::dropIfExists('teachers');
    }
}
