<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlsInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sls_invoice_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sls_invoice_id');
            $table->foreign('sls_invoice_id')->references('id')->on('sls_invoices')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('str_product_id');
            $table->foreign('str_product_id')->references('id')->on('str_products')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('sls_invoice_items')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->string('unite');
            $table->decimal('unite_price');
            $table->decimal('unite_price_descount');
            $table->decimal('unite_final_price');
            $table->integer('quantity');
            $table->decimal('total_descount');
            $table->decimal('taxes_value');
            $table->decimal('total_before_taxes');
            $table->decimal('total_price');
            $table->tinyInteger('state');
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
        Schema::dropIfExists('sls_invoice_items');
    }
}
