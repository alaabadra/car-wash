<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepaireOrderParts extends Model
{
 //   use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();
        //check if store include quantity
        static::created(function ($entry) {
            $str_product = StrProduct::find($entry->str_product_id);
            if ($str_product->balance < $entry->quantity) return \response()->json(['error' => 'الرصيد لا يسمح'], 404);
            // $entry->account->update(['creditor' =>   $entry->account->creditor + $entry->creditor, 'debtor' =>   $entry->account->debtor + $entry->debtor]);
            // $entry->update(['balance' => $entry->account->balance]);
        });

        static::deleting(function ($entry) {
        });
    }

    public function repaire()
    {
        return $this->belongsTo('App\Models\RepaireOrder');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\StrProduct');
    }
}
