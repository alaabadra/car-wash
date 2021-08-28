<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesReservationOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_reservation_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('sales_reservation_id')->nullable();
            $table->foreign('sales_reservation_id')->references('id')->on('sales_reservations')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('sales_reservation_product_id')->nullable();
            $table->foreign('sales_reservation_product_id')->references('id')->on('sales_reservation_products')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('ammount');
            $table->integer('care_id');
            $table->integer('mixer_id');
            $table->integer('pump_id');
            $table->integer('driver_id');
            $table->tinyInteger('payed');
            $table->date('delivery_time');
            $table->date('return_time');
            $table->string('location');
            $table->date('date');
            $table->string('state');
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
        Schema::dropIfExists('sales_reservation_orders');
    }
}
