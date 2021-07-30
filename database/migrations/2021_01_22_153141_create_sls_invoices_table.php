<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlsInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sls_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('num');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('sls_invoices')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->string('mode');
            $table->string('type');
            $table->string('invoicable_type');
            $table->integer('invoicable_id');
            $table->date('date');
            $table->string('payment_type');
            $table->string('payment_method');
            $table->string('payment_state');
            $table->decimal('payment_value');
            $table->decimal('payment_cash_value');
            $table->decimal('payment_bank_value');
            $table->decimal('descount_value');
            $table->decimal('taxes_value');
            $table->decimal('total_before_taxes');
            $table->decimal('total_price');
            $table->decimal('source_balance');
            $table->decimal('state');
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
        Schema::dropIfExists('sls_invoices');
    }
}
