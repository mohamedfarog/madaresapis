<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunicateMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communicate_methods', function (Blueprint $table) {
            $table->id();
            $table->tinyText('type');    //['email' , 'walk-in' , 'phone']
            $table->tinyText('contact'); //['info@madares.ae' , 'street location' , '0502971184 ]
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
        Schema::dropIfExists('communicate_methods');
    }
}
