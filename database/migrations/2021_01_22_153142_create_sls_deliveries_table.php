<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlsDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sls_deliveries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('car_id');
            $table->foreign('car_id')->references('id')->on('cars')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('type');
            $table->integer('pump_id');
            $table->integer('driver_id');
            $table->unsignedBigInteger('sls_invoice_id');
            $table->foreign('sls_invoice_id')->references('id')->on('sls_invoices')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('deliverable_type');
            $table->integer('deliverable_id');
            $table->float('ammount');
            $table->unsignedBigInteger('sales_reservation_order_id');
            $table->foreign('sales_reservation_order_id')->references('id')->on('sales_reservation_orders')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('location');
            $table->float('distance');
            $table->date('out_time');
            $table->date('return_time');
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
        Schema::dropIfExists('sls_deliveries');
    }
}
