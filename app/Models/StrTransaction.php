<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrTransaction extends Model
{
  //  use HasFactory;


    protected $guarded = [];

    public function showFormat()
    {
        $this->details = $this->details->map->only('id', 'account_id', 'account_name', 'account_balance', 'creditor', 'debtor');
        $this->user = $this->user->only('id', 'name');
        return $this->only('id', 'date', 'type', 'details', 'user', 'activities');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function details()
    {
        return $this->hasMany('App\Models\StrTransactionDetail');
    }

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function activities()
    {
        return $this->morphMany('App\Models\Activity', 'activable');
    }
}
