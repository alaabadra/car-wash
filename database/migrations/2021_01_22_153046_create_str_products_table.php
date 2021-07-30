<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('str_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('catigory');
            $table->string('type');
            $table->string('description');
            $table->string('custom_unites');
            $table->string('unite');
            $table->integer('parts');
            $table->string('part_unite');
            $table->decimal('unite_price');
            $table->float('balance2');
            $table->float('creditor');
            $table->float('debtor');
            $table->integer('alert_limit');
            $table->decimal('default_order_ammount');
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
        Schema::dropIfExists('str_products');
    }
}
