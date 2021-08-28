<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
 //   use HasFactory;

    protected $guarded = [];

    public function account()
    {
        return $this->morphOne('App\Models\Account', 'accountable')->withDefault();
    }

    public function person()
    {
        return $this->belongsTo('App\Models\Person', 'people_id')->withDefault();
    }

    public function activities()
    {
        return $this->morphMany('App\Models\Activity', 'activable')->orderBy('created_at', 'desc');
    }

    public function accounts()
    {
        return $this->morphMany('App\Models\Account', 'accountable');
    }

    public function h_account()
    {
        return $this->morphOne('App\Models\Account', 'accountable')->where('parent_id', 123);
    }

    public function z_account()
    {
        return $this->morphOne('App\Models\Account', 'accountable')->where('parent_id', 124);
    }

    public function t_account()
    {
        return $this->morphOne('App\Models\Account', 'accountable')->where('parent_id', 2125);
    }

    /**
     * Get the 
     *
     * @param  string  $value
     * @return string
     */
    public function getBalanceAttribute()
    {
        return $this->account->balance;
    }
}
