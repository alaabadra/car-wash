<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccCostCenter extends Model
{
  //  use HasFactory;

    protected $table="acc_cost_centers";
    protected $guarded = []; //

    public function showFormat()
    {
        $this->accounts = $this->accounts->map(function ($s) {
            return [
                'id' => $s->id,
                'balance_type' => $s->balance_type,
                'name' => $s->name,
                'cascade_name' => $s->cascade_name,
                'balance' => $s->balance,
                'percent' => $s->pivot->percent,
                'creditor' => $s->balance_type == 'creditor' ? $s->balance * ($s->pivot->percent / 100) : 0,
                'debtor' => $s->balance_type == 'debtor' ? $s->balance * ($s->pivot->percent / 100) : 0,
                'auto' => $s->pivot->auto,
            ];
        });
        $this->balance = round($this->accounts->sum('debtor') - $this->accounts->sum('creditor'), 2);

        return $this->only('id', 'name', 'type', 'accounts', 'balance');
    }

    # code...


    // public static function boot()
    // {
    //     parent::boot();
    //     static::created(function ($entry) {
    //         $value = $entry->debtor - $entry->creditor;
    //         if ($entry->account->balance_type == 'creditor')  $value = $entry->creditor - $entry->debtor;
    //         $current_balance = $entry->account->balance;
    //         $updated_balance = 0;
    //         $updated_balance = $current_balance + $value;
    //         // $balance = $entry->account->details->sum('creditor') - $entry->account->details->sum('debtor');
    //         $entry->update(['balance' =>  $updated_balance]);
    //         $entry->account->update(['balance' =>  $updated_balance]);
    //     });

    //     static::deleting(function ($entry) {
    //         $value = $entry->debtor - $entry->creditor;
    //         if ($entry->account->balance_type == 'creditor')  $value = $entry->creditor - $entry->debtor;
    //         $current_balance = $entry->account->balance;
    //         $updated_balance = 0;
    //         $updated_balance = $current_balance - $value;
    //         // $balance = $entry->account->details->sum('creditor') - $entry->account->details->sum('debtor');
    //         // $entry->update(['balance' =>  $updated_balance]);
    //         $entry->account->update(['balance' =>  $updated_balance]);
    //     });
    // }



    public function accounts()
    {
        return $this->belongsToMany('App\Models\Account', 'account_cost_centers')->withPivot(['percent',  'auto']);
    }
}
