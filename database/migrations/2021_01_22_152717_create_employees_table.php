<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->string('emp_picture')->nullable();
            $table->string('notes')->nullable();
            $table->string('email');
            $table->string('status');
            $table->integer('send_credentials')->nullable();
            $table->integer('allow_access')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->date('date_of_birth');
            $table->string('gender')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('mobile_number')->nullable();
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->onUpdate('CASCADE')->onDelete('CASCADE');
            // $table->unsignedBigInteger('employee_level_id');
            // $table->foreign('employee_level_id')->references('id')->on('employees_levels')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('designation_id');
            $table->foreign('designation_id')->references('id')->on('designations')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->date('join_date');
            $table->date('job_date');
            $table->string('target');
            $table->string('branch');
            $table->string('salary');
            $table->string('position');
            $table->string('signature');

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
        Schema::dropIfExists('employees');
    }
}
