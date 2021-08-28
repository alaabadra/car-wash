<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarpetWashingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carpet_washings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('ticket_date');
            $table->string('serial_number');
            $table->integer('wash')->default(-1);
            $table->integer('ticket_status')->default(-1);
            $table->integer('client_id')->default(1);
            $table->integer('carpet_size')->default(-1);
            $table->integer('wash_type')->default(-1);
            $table->dateTime('receipt_date');
            $table->dateTime('expected_exit_date');
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
        Schema::dropIfExists('carpet_washings');
    }
}
