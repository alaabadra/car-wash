<?php

namespace App\Models;

use App\Casts\json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrProduct extends Model
{
  //  use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'custom_unites' => json::class
    ];
    protected $appends = [
        'balance'
    ];

    public function showFormat()
    {

        $this->materials = $this->materials->map(function ($m) {
            return [
                'name' => $m->name,
                'ammount' => $m->pivot->ammount,
                'str_material_id' => $m->id
            ];
        });

        return $this->only('id', 'name', 'materials', 'catigory', 'type', 'unite',  'unite_parts', 'part_unite', 'unite_price', 'custom_unites', 'description');
    }

    public function materials() //belongs to same table
    {
        return $this->belongsToMany('App\Models\StrProduct', 'str_product_materials', 'str_product_id', 'str_material_id')->withPivot('ammount');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\StrTransactionDetail', 'str_material_id');
    }

    public function productions()
    {
        return $this->hasMany('App\Models\SlsProductionOrder');
    }

    public function productions_materials()
    {
        return $this->belongsToMany('App\Models\SlsProductionOrder', 'sls_production_order_materials')->withPivot('quantity');
    }

    public function getNameWithPriceAttribute()
    {
        return $this->name . ' |  ' . $this->unite_price;
    }

    public function getFullNameAttribute()
    {
        return $this->id . ' ' . $this->name;
    }

    public function getBalanceAttribute()
    {
        return $this->debtor - $this->creditor;
    }
}
