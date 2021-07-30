<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
  //  use HasFactory;


    protected $guarded = []; //

    protected $appends = ['full_name'];

    public $timestamps = false;


    public function children()
    {
        return $this->hasMany('App\Models\Department', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Department', 'parent_id')->withDefault();
    }

    public function getFullNameAttribute()
    {
        return $this->id . ' ' . $this->name;
    }
}
