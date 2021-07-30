<?php

namespace App\Models\ManageEmployees;

use Illuminate\Database\Eloquent\Model;

class Holiday_list extends Model
{
    protected $fillable=['id','name','name_ar','start_date','end_date'];
}
