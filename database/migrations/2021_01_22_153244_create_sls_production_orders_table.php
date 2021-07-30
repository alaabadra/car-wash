<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlsProductionOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sls_production_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('str_product_id');
            $table->foreign('str_product_id')->references('id')->on('str_products')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('sls_invoice_item')->nullable();
            $table->foreign('sls_invoice_item')->references('id')->on('sls_invoice_items')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('quantity');
            $table->integer('destroyed_quantity');
            $table->integer('final_quantity');
            $table->decimal('unite_price');
            $table->date('start_time');
            $table->date('end_time');
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
        Schema::dropIfExists('sls_production_orders');
    }
}
