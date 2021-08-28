<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    protected $fillable = ['dic_id','name', 'name_ar'];
    protected $primaryKey='dic_id';
}
