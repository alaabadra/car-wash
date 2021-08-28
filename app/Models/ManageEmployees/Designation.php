<?php

namespace App\Models\ManageEmployees;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $fillable=['name','name_ar','status','description','type'];
}
