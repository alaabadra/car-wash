<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlsInvoice extends Model
{
   // use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    public function showFormat()
    {

        $this->itemes = $this->items->load(['product:id,name']);
        $this->customer = $this->customer->only('id', 'name');
        $this->deliveries = $this->deliveries->load(['car:id,name', 'driver:id,name']);
        $this->activities = $this->activities->map->only('id', 'user_id', 'type', 'user_name', 'date', 'state', 'description');
        return $this->only('id', 'num', 'state', 'productions', 'mode', 'type', 'date', 'created_at', 'items', 'customer', 'deliveries', 'activities', 'total_before_taxes', 'taxes_value', 'total_price', 'payment_value', 'source_balance');
    }
    public function reportFormat()
    {
        $this->customer_name = $this->customer->name;
        $this->user_name = $this->user->name;
        return $this->only('id', 'state', 'mode', 'type', 'date',  'customer_name', 'user_name', 'total_before_taxes', 'taxes_value', 'total_price', 'payment_value', 'source_balance');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function items()
    {
        return $this->hasMany('App\Models\SlsInvoiceItem');
    }

    public function productions()
    {
        return $this->hasManyThrough('App\Models\SlsProductionOrder', 'App\Models\SlsInvoiceItem');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function activities()
    {
        return $this->morphMany('App\Models\Activity', 'activable')->orderBy('created_at', 'desc');
    }

    public function transactions()
    {
        return $this->morphMany('App\Models\AccTransaction', 'transactionable');
    }



    public function deliveries()
    {
        return $this->hasMany('App\Models\SlsDelivery');
    }



    public function str_transaction()
    {
        return $this->morphMany('App\Models\StrTransaction', 'transactionable');
    }

    public function getDeliveryStateAttribute()
    {
    }
    public function getDateAttribute()
    {
        return date('Y-d-m h:i a', \strtotime($this->created_at));
    }
}
