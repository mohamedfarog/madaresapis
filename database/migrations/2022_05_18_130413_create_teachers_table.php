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
            $table->foreignId('user_id')->constrained('users');
            // $table->dropForeign('teachers_user_id_foreign');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('mobile');
            $table->date('date_of_birth');
            $table->string('avatar', 50)->nullable();
            $table->string('academic_major', 100)->nullable();
            $table->longText('bio')->nullable();
            $table->enum('gender', ['male', 'female']);
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
