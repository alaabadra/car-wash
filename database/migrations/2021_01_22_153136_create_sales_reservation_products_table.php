<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesReservationProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_reservation_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sales_reservation_id')->nullable();
            $table->foreign('sales_reservation_id')->references('id')->on('sales_reservations')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('str_product_id')->nullable();
            $table->foreign('str_product_id')->references('id')->on('str_products')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('product_name');
            $table->integer('ammount');
            $table->decimal('unite_price');
            $table->decimal('unite_price_descount');
            $table->decimal('unite_final_price');
            $table->decimal('total_price');
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
        Schema::dropIfExists('sales_reservation_products');
    }
}
