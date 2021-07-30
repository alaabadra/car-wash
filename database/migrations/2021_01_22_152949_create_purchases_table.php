<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('supplier_invoice_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')->on('stores')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('purchases');
            $table->decimal('purchase_price');
            $table->string('purchase_returns');
            $table->decimal('current_value');
            $table->decimal('return_value');
            $table->decimal('destruction_value');
            $table->integer('destruction_duration');
            $table->string('destruction_duration_type');
            $table->date('destruction_end_date');
            $table->date('last_destruction_date');
            $table->date('date');
            $table->string('type');
            $table->string('payment_type');
            $table->string('payment_method');
            $table->string('payment_state');
            $table->string('payment_value');
            $table->string('delivery_state');
            $table->float('taxes_percent');
            $table->decimal('descount');
            $table->decimal('taxes_value');
            $table->decimal('total_price_before_taxes');
            $table->decimal('final_price');
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
        Schema::dropIfExists('purchases');
    }
}
