<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('people_id');
            $table->foreign('people_id')->references('id')->on('peoples')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('name');
            $table->string('type');
            $table->string('payment_method');
            $table->string('taxes_num');
            $table->string('trade_num');
            $table->string('company_name');
            $table->string('vice');
            $table->string('start_balance');
            $table->decimal('limit_balance');
            $table->string('limit_state');
            $table->integer('limit_time');
            $table->string('notes');
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
        Schema::dropIfExists('customers');
    }
}
