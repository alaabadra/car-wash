<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWashingMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('washing_machines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('model');
            $table->string('brand');
            $table->date('purchase_date');
            $table->date('residual_date');
            $table->string('store_management');
            $table->string('cash_value');
            $table->string('paid_up');
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
        Schema::dropIfExists('washing_machines');
    }
}
