<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrProductMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('str_product_materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('str_product_id');
            $table->foreign('str_product_id')->references('id')->on('str_products')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('str_material_id');
            $table->decimal('ammount');
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
        Schema::dropIfExists('str_product_materials');
    }
}
