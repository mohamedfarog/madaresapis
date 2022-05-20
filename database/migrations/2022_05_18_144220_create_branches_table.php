<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academy_id');
            $table->tinyText('country')->nullable();
            // $table->foreignId('country_id'); # in future we need to it from  separate  Table for now i make it static
            $table->tinyText('state')->nullable();
            $table->string('street')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();

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
        Schema::dropIfExists('branches');
    }
}
