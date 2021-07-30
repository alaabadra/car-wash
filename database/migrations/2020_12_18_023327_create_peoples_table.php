<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeoplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peoples', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('national_id');
            $table->foreign('national_id')->references('id')->on('nationalities')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('name');
            $table->string('arabic_name');
            $table->string('nationality');
            $table->string('gender');
            $table->string('telephone');
            $table->date('birth_date');
            $table->string('address');
            $table->string('email');
            $table->string('img');
            $table->string('job');
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
        Schema::dropIfExists('peoples');
    }
}
