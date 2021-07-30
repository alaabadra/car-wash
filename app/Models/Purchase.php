<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
  //  use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function showFormat()
    {
        $this->items = $this->items->map->only('id', 'material_name', 'unite', 'quantity', 'unite_price', 'final_price');
        return $this->only('id', 'date', 'payment_type', 'payment_method', 'delivery_state', 'store', 'supplier', 'taxes_value',  'descount', 'total_price', 'total_price_after_descount', 'final_price', 'items');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function items()
    {
        return $this->hasMany('App\Models\PurchaseItem');
    }

    public function activities()
    {
        return $this->morphTo('App\Models\Activity', 'activable');
    }

    public function transaction()
    {
        return $this->morphOne('App\Models\AccTransaction', 'transactionable');
    }

    public function store_transaction()
    {
        return $this->morphMany('App\Models\StrTransaction', 'transactionable');
    }

    public function balance()
    {
        return $this->hasMany('App\Models\strBalance');
    }


    public function getSatetAttribute()
    {
        return $this->item_balance->sum('balance');
    }

    public function getTotalPriceAttribute() //total befor taxes and  general descount
    {
        return $this->items->sum('final_price');
    }

    public function getTotalPriceAfterDescountAttribute() //total befor taxes and  general descount
    {
        return $this->TotalPrice - $this->descount;
    }

    public function getTaxesValueAttribute() //total befor taxes
    {
        return  \round($this->total_price_after_descount * $this->taxes_percent, 2);
    }

    public function getFinalPriceAttribute() //total befor taxes
    {
        return  \round($this->total_price_after_descount + $this->taxes_value, 2);
    }
}
