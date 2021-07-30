<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrTransactionDetail extends Model
{
//    use HasFactory;
    protected $guarded = []; //

    public $timestamps = false;


    public static function boot()
    {
        parent::boot();

        static::created(function ($entry) {
            //update balance
            $entry->material->update(['creditor' =>   $entry->material->creditor + $entry->out, 'debtor' =>   $entry->material->debtor + $entry->in]);
            $entry->update(['balance' => $entry->material->balance]);


            // $value = $entry->in - $entry->out;
            // $current = $entry->material->balance;
            // $updated_balance = $current + $value;
            // $entry->update(['balance' =>  $updated_balance]);
            // $entry->material->update(['balance' =>  $updated_balance]);
        });

        static::deleting(function ($entry) {
            //restore balance
            $entry->material->update(['creditor' =>   $entry->material->creditor - $entry->out, 'debtor' =>   $entry->material->debtor - $entry->in]);
            //  $entry->update(['balance' => $entry->material->balance]);

            // $value = $entry->out - $entry->in;
            // $current = $entry->material->balance;
            // $updated_balance = $current + $value;
            // $entry->update(['balance' =>  $updated_balance]);
        });
    }



    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }

    public function material()
    {
        return $this->belongsTo('App\Models\StrProduct', 'str_product_id');
    }

    public function transaction()
    {
        return $this->belongsTo('App\Models\StrTransaction');
    }




    // public function getAccountBalanceAttribute($value)
    // {
    //     return $this->account->balance;
    // }
}
