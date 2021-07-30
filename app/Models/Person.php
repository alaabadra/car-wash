<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
 //   use HasFactory;

    protected $guarded = [];
    protected $tabel = 'people';
 
    //protected $appends = ['full_name'];


    public function getFullNameAttribute()
    {
        return $this->name . ' | ' . $this->national_id . ' | ' . $this->telephone;
    }
}
