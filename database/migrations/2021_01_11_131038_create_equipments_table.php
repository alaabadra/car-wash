<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('purchase_date');
            $table->date('service_start_date');
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->decimal('purchase_price');
            $table->decimal('current_value');
            $table->decimal('return_value');
            $table->decimal('destruction_value');
            $table->integer('destruction_duration');
            $table->string('destruction_duration_type');
            $table->string('mode');
            $table->string('value');
            $table->date('destruction_end_date');
            $table->date('last_destruction_date');
            $table->string('name');
            $table->string('type');
            $table->string('card_num');
            $table->string('model');
            $table->string('details');
            $table->date('last_repaire_date');
            $table->integer('default_driver_id');
            $table->integer('km');
            $table->integer('color');
            $table->integer('client_id')->nullable();
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
        Schema::dropIfExists('equipments');
    }
}
