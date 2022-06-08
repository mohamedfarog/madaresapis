<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionedAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('questioned_answers');
        Schema::create('questioned_answers', function (Blueprint $table) {
            $table->id();
            $table->text('en_title');
            $table->text('ar_title');
            $table->text('en_body');
            $table->text('ar_body');
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
        Schema::dropIfExists('questioned_answers');
    }
}
