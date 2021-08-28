<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
           
            $table->string('name');
            $table->string('cascade_name');
            $table->string('name_ar');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('accounts')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->tinyInteger('cost_center');
            $table->string('account_type')->nullable();
            $table->string('balance_type')->nullable();
            $table->string('final_account')->nullable();
            $table->integer('value_in')->nullable();
            $table->integer('value_out')->nullable();
            $table->integer('balance')->nullable();
            $table->decimal('creditor')->default(0.00);
            $table->decimal('debtor')->default(0.00);
            $table->string('accountable_type')->nullable();
            $table->integer('accountable_id')->nullable();
            $table->integer('store')->nullable();
            $table->integer('Column10')->nullable();
            $table->string('account_path')->default('0');
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
        Schema::dropIfExists('accounts');
    }
}
