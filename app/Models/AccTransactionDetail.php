<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccTransactionDetail extends Model
{
 //   use HasFactory;

    protected $guarded = []; //



    public static function boot()
    {
        parent::boot();
        static::created(function ($entry) {
            $entry->account->update(['creditor' =>   $entry->account->creditor + $entry->creditor, 'debtor' =>   $entry->account->debtor + $entry->debtor]);
            $entry->update(['balance' => $entry->account->balance]);

            // $value = $entry->debtor - $entry->creditor;
            // if ($entry->account->balance_type == 'creditor')  $value = $entry->creditor - $entry->debtor;
            // $current_balance = $entry->account->balance;
            // $updated_balance = 0;
            // $updated_balance = $current_balance + $value;
            // // $balance = $entry->account->details->sum('creditor') - $entry->account->details->sum('debtor');
            // $entry->update(['balance' =>  $updated_balance]);
            // $entry->account->update(['balance' =>  $updated_balance]);
        });

        static::deleting(function ($entry) {
            $value = $entry->debtor - $entry->creditor;
            if ($entry->account->balance_type == 'creditor')  $value = $entry->creditor - $entry->debtor;
            $current_balance = $entry->account->balance;
            $updated_balance = 0;
            $updated_balance = $current_balance - $value;
            // $balance = $entry->account->details->sum('creditor') - $entry->account->details->sum('debtor');
            // $entry->update(['balance' =>  $updated_balance]);
            $entry->account->update(['balance' =>  $updated_balance]);
        });
    }



    public function account()
    {
        return $this->belongsTo('App\Models\Account', 'account_id');
    }

    public function transaction()
    {
        return $this->belongsTo('App\Models\AccTransaction', 'acc_transaction_id');
    }



    public function getAccountNameAttribute($value)
    {
        return $this->account->name;
    }

    public function getAccountBalanceAttribute($value)
    {
        return $this->account->balance;
    }
}
