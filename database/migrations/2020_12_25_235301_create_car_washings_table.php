<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarWashingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_washings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('serial_number');
            $table->date('ticket_date');
            $table->integer('wash');
            $table->integer('ticket_status');
            $table->integer('car_id');
            $table->integer('client_id')->default(1);
            $table->time('receipt_time');
            $table->time('exit_time');
            $table->integer('total_price')->default(0);
            $table->integer('num_of_materials')->default(0);
            $table->integer('total_discount')->default(0);
            $table->boolean('pended')->default(false);
            $table->boolean('completed')->default(false);
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
        Schema::dropIfExists('car_washings');
    }
}
