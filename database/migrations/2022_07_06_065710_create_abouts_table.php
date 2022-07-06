<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('abouts');
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('en_title');
            $table->string('ar_title');
            $table->string('en_name');
            $table->string('ar_name');
            $table->longText('en_body');
            $table->longText('ar_body');
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
        Schema::dropIfExists('abouts');
    }
}
