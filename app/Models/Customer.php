<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
   // use HasFactory;
    protected $guarded = [];

    public function account()
    {
        return $this->morphOne('App\Models\Account', 'accountable')->withDefault();
    }

    public function person()
    {
        return $this->belongsTo('App\Models\Person', 'people_id')->withDefault();
    }

    public function invoices()
    {
        return $this->hasMany('App\Models\SlsInvoice');
    }

    public function getBalanceAttribute()
    {
        return $this->account->balance;
    }
}
