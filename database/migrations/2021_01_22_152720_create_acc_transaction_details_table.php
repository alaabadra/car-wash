<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_transaction_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('acc_transaction_id');
            $table->foreign('acc_transaction_id')->references('id')->on('acc_transactions')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->date('date');
            $table->string('description');
            $table->integer('creditor');
            $table->integer('debtor');
            $table->decimal('balance')->default(0.00);
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
        Schema::dropIfExists('acc_transaction_details');
    }
}
