<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::dropIfExists('teacher_experiences');
        Schema::create('teacher_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id');
            $table->string('titel', 50);
            $table->tinyText('place_of_assuarance');
            $table->boolean('current_work')->nullable();
            $table->date('start_day');
            $table->date('end_day');
            $table->tinyText('description')->nullable();
            $table->json('certificates')->nullable();
            // $table->foreignId('academy_info_id'); # in future we need to fetch academies from our table //name , country , city , logo ,lat ,lng
            // $table->foreignId('certificate_id'); # in future we need to store in separate  Table // name , issuer , date , link
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
        Schema::dropIfExists('teacher_experiences');
    }
}
