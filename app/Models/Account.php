<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
 //   use HasFactory;


    protected $guarded = []; //

    protected $appends = ['full_name', 'balance'];

    // protected $with= ['children'];

    public static function boot()
    {
        parent::boot();
        static::created(function ($ac) {
            //generate cascade name
            $name = $ac->name;
            $d = $ac;
            redo:
            if ($d && $d->parent_id > 0) {
                $name = $d->parent->name . ' > ' . $name;
                $d = Account::find($d->parent_id);
                goto redo;
            }

            $name = $ac->id . ' : ' . $name;
            $ac->update(['cascade_name' => $name]);
        });
    }




    public function children()
    {
        return $this->hasMany('App\Models\Account', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Account', 'parent_id')->withDefault(['id' => -1, 'name' => 'غير محدد']);
    }

    public function details()
    {
        return $this->hasMany('App\Models\AccTransactionDetail');
    }

    public function accountable()
    {
        return $this->morphTo()->withDefault(['id' => '-1', 'name' => '']);
    }


    public function accounts() //from cost center to accounts
    {
        return $this->belongsToMany('App\Models\Account', 'account_cost_centers', 'account_id', 'cost_center_id')->withPivot('percent', 'auto');
    }


    public function cost_centers() //from cost center to accounts
    {
        return $this->belongsToMany('App\Models\Account', 'account_cost_centers', 'cost_center_id', 'account_id')->withPivot('percent', 'auto');
    }


    // public function cost_centers()
    // {
    //     return $this->belongsToMany('App\Models\AccCostCenter', 'account_cost_centers');
    // }

    public function getFullNameAttribute()
    {
        return $this->id . ' ' . $this->name;
    }

    public function getBalanceAttribute()
    {
        try {
            if ($this->account_type == 'main') {
                return $this->children->sum('balance');
            } else {
                return $this->balance_type == 'debtor' ? $this->debtor - $this->creditor : $this->creditor - $this->debtor;
            }
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public function getCreditor2Attribute()
    {
        if ($this->account_type == 'main') {
            return  $this->children->sum('creditor2');
        } else {
            return  $this->creditor;
        }
    }
    public function getDebtor2Attribute()
    {
        if ($this->account_type == 'main') {
            return $this->children->sum('debtor2');
        } else {
            return  $this->debtor;
        }
    }

    public function getTextAttribute()
    {
        return $this->id . ' ' . $this->name;
    }
}
