<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('str_transaction_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('str_product_id');
            $table->foreign('str_product_id')->references('id')->on('str_products')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('purchase_id');
            $table->foreign('purchase_id')->references('id')->on('purchases')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('str_transaction_id');
            $table->foreign('str_transaction_id')->references('id')->on('str_transactions')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')->on('stores')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('balance');
            $table->integer('in');
            $table->integer('out');
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
        Schema::dropIfExists('str_transaction_details');
    }
}
