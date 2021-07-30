<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlsDeliveryItem extends Model
{
  //  use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    public $timestamps = false;
    public static function boot()
    {
        parent::boot();
        static::created(function ($entry) {

            // $entry->item()->increment(['balance' =>  $updated_balance]);
        });
    }

    public function delivery()
    {
        return $this->belongsTo('App\Models\SlsDelivery');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\SlsInvoiceItem');
    }

    public function str_transaction()
    {
        return $this->morphOne('App\Models\StrTransaction', 'transactionable');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\StrProduct', 'str_product_id');
    }

    public function getNameAttribute()
    {
        return $this->product ? $this->product->name : '';
    }
}
