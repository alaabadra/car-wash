<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepaireOrderPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repaire_order_parts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('repaire_order_id');
            $table->foreign('repaire_order_id')->references('id')->on('repaire_orders')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('str_product_id');
            $table->foreign('str_product_id')->references('id')->on('str_products')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('quantity');
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
        Schema::dropIfExists('repaire_order_parts');
    }
}
