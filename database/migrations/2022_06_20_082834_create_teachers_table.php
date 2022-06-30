<?php

use App\Models\Teachers\Teacher;
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('teachers');
        Schema::enableForeignKeyConstraints();
        Schema::create('teachers', function (Blueprint $table) {
           $table->id();    
           $table->foreignId('user_id');
           $table->foreignId('gender_id');
           $table->foreignId('job_level_id');
           $table->foreignId('availability_id');
           $table->integer('contact_number');
           $table->date('date_of_birth');
           $table->string('first_name', 50);
           $table->string('last_name', 50);
           $table->boolean('willing_to_travel')->default(0);
           $table->text('bio')->nullable();
           $table->string('avatar', 250)->nullable();
           $table->string('academic_major', 100)->nullable();
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
        Schema::disableForeignKeyConstraints();
        Schema::table('teachers', function(Blueprint $table){
             Schema::dropIfExists('teachers');

        });

}
}
