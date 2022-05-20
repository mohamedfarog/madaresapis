<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherResumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('curriculum_vitae')->nullable();
            $table->string('cover_litter')->nullable();
            $table->json('extra_skills')->nullable();
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
        Schema::dropIfExists('teacher_resumes');
    }
}
