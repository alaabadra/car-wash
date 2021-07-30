<?php

namespace App\Models\ManageEmployees;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable=['name','name_ar','abbreviation','status','description','employee_id','month','day'];

}
