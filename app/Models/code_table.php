<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class code_table extends Model
{
    protected $table='code_tables';
    protected $fillable=['sys_code_type','sys_code','name','name_ar'];
}
