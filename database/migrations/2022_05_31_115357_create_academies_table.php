<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('ar_name');
            $table->string('en_name');
            $table->string('website');
            $table->string('contact_number')->nullable();
            $table->string('contact_email' , 50)->nullable();
            $table->string('avatar')->nullable();
            $table->string('banner')->nullable();
            $table->longText('ar_bio')->nullable();
            $table->longText('en_bio')->nullable();
            $table->string('ar_city');
            $table->string('en_city');
            $table->string('en_country');
            $table->string('ar_country');
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
        Schema::dropIfExists('academies');
    }
}
