<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlsDelivery extends Model
{
 //   use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $appends = ['quantity', 'products_count'];

    public function format()
    {
        $this->car = $this->car->only('id', 'name');
        $this->driver = $this->driver->only('id', 'name');
        return $this->only('id', 'sales_reseravtion_order_id', 'state', 'ammount', 'car', 'driver', 'out_time', 'return_time', 'location');
    }

    public function showFormat()
    {
        $this->target = $this->invoice->customer->only('id', 'name');
        $this->invoice = $this->invoice->only('id', 'num', 'type');
        $this->car = $this->car->only('id', 'name');
        $this->driver = $this->driver->only('id', 'name');
        $this->items = $this->items->map->only('id', 'name', 'quantity');
        $this->activities = $this->activities->map->only('id', 'user_id', 'type', 'user_name', 'date', 'state', 'description');
        return $this->only('id', 'sales_reseravtion_order_id', 'state', 'ammount', 'car', 'driver', 'pump', 'location', 'activities', 'items', 'target', 'invoice');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\SalesReservationOrder');
    }
    public function car()
    {
        return $this->belongsTo('App\Models\Equipment', 'car_id')->withDefault(['id' => -1, 'name' => 'غير محدد']);
    }

    public function pump()
    {
        return $this->belongsTo('App\Models\Equipment', 'pump_id')->withDefault(['id' => -1, 'name' => 'غير محدد']);
    }


    public function driver()
    {
        return $this->belongsTo('App\Models\Employee', 'driver_id')->withDefault(['id' => -1, 'name' => 'غير محدد']);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->withDefault();
    }

    public function items()
    {
        return $this->hasMany('App\Models\SlsDeliveryItem');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Models\SlsInvoice', 'sls_invoice_id');
    }

    public function deliverable()
    {
        return $this->morphTo();
    }

    public function activities()
    {
        return $this->morphMany('App\Models\Activity', 'activable')->orderBy('created_at', 'desc');
    }

    public function str_transaction()
    {
        return $this->morphOne('App\Models\StrTransaction', 'transactionable');
    }

    public function getQuantityAttribute()
    {
        return $this->items->sum('quantity');
    }


    public function getProductsCountAttribute()
    {
        return $this->items->count();
    }
}
