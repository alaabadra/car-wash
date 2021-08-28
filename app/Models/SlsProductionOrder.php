<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlsProductionOrder extends Model
{
   // use HasFactory;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $appends = ['date'];

    public function showFormat()
    {
        $this->user = $this->user->only('id', 'name');
        $this->mixer = $this->mixer->only('id', 'name');
        $this->product = $this->product->only('id', 'name');
        $this->activities = $this->activities->map->only('id', 'user_id', 'type', 'user_name', 'date', 'state', 'description');
        $this->details =  $this->str_transaction->details;

        return $this->only('id', 'date', 'state', 'quantity', 'destroyed_quantity', 'final_quantity', 'mixer', 'type', 'user', 'product', 'details', 'start_time', 'end_time', 'activities');
    }

    public function reportFormat()
    {
        $this->user = $this->user->only('id', 'name');
        $this->mixer = $this->mixer->only('id', 'name');
        $this->product = $this->product->only('id', 'name');
        $this->activities = $this->activities->map->only('id', 'user_id', 'type', 'user_name', 'date', 'state', 'description');
        $this->details =  $this->str_transaction->details;
        return $this->only('id', 'date', 'state', 'quantity', 'mixer', 'type', 'user', 'product', 'details', 'start_time', 'end_time', 'activities');
    }

    public function str_transaction()
    {
        return $this->morphOne('App\Models\StrTransaction', 'transactionable')->withDefault(['details' => []]);
    }



    public function product()
    {
        return $this->belongsTo('App\Models\StrProduct', 'str_product_id');
    }

    public function materials()
    {
        return $this->belongsToMany('App\Models\StrProduct', 'sls_production_order_materials');
    }


    public function mixer()
    {
        return $this->belongsTo('App\Models\Equipment', 'mixer_id')->withDefault(['id' => -1, 'name' => 'غير محدد']);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function activities()
    {
        return $this->morphMany('App\Models\Activity', 'activable')->orderBy('created_at', 'desc');
    }

    public function getDateAttribute()
    {
        return date('Y-m-d h:i a', strtotime($this->created_at));
    }

    public function getProductNameAttribute()
    {
        return $this->product->name;
    }
}
