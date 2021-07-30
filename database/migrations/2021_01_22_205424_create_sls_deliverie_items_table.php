<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlsDeliverieItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sls_deliverie_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sls_delivery_id');
            $table->foreign('sls_delivery_id')->references('id')->on('sls_deliveries')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('sls_invoice_item_id');
            $table->foreign('sls_invoice_item_id')->references('id')->on('sls_invoice_items')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('str_product_id');
            $table->foreign('str_product_id')->references('id')->on('str_products')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->float('quantity');
            $table->float('delivered');
            $table->float('remain');
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
        Schema::dropIfExists('sls_deliverie_items');
    }
}
