<?php

namespace App\Models\ManageEmployees;

use Illuminate\Database\Eloquent\Model;

class Leave_policy extends Model
{
    protected $fillable=['id','name','name_ar','colour','description','max_days','max_applicable_days','applicable_after'];
}
