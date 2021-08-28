<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccMainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acc_mains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('account_number');
            $table->string('name');
            $table->string('type');
            $table->string('km');
            $table->string('model');
            $table->decimal('Balance')->default(0.00);
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
        Schema::dropIfExists('acc_bonds');
    }
}
