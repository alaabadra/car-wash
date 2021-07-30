<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJornalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jornal_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('jornal_id');
            $table->foreign('jornal_id')->references('id')->on('jornals')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('acc_name');
            $table->string('description');
            $table->integer('depit');
            $table->integer('credit');
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
        Schema::dropIfExists('jornal_details');
    }
}
