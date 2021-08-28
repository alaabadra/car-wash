<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccBond extends Model
{
    // use HasFactory;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $appends = ['full_name'];
    public function creditor_account()
    {
        return $this->belongsTo('App\Models\Account', 'creditor_account_id')->withDefault(['id' => -1, 'name' => 'غير محدد']);
    }

    public function debtor_account()
    {
        return $this->belongsTo('App\Models\Account', 'debtor_account_id')->withDefault(['id' => -1, 'name' => 'غير محدد']);
    }

    public function getFullNameAttribute()
    {
        return $this->id . ' ' . $this->name;
    }
}
