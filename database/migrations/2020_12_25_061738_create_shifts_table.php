<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('name_ar');
            $table->time('on_duty_time1');
            $table->time('off_duty_time1');
            $table->time('begin1');
            $table->time('end1');
            $table->time('on_duty_time2')->nullable();
            $table->time('off_duty_time2')->nullable();
            $table->time('begin2')->nullable();
            $table->time('end2')->nullable();
            $table->boolean('assign_another_shift')->default(false);
            $table->string('week_days');
            $table->boolean('start_late')->default(false);
            $table->integer('late_minutes')->default(0);
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
        Schema::dropIfExists('shifts');
    }
}
