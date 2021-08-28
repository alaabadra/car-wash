<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlsProductionOrderMaterials extends Model
{
    //use HasFactory;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function str_transaction()
    {
        return $this->morphOne('App\Models\StrTransaction', 'transactionable')->withDefault(['details' => []]);
    }

    public function materials()
    {
        return $this->belongsTo('App\Models\StrProduct');
    }

    public function productio_order()
    {
        return $this->belongsTo('App\Models\ProductionOrder');
    }
}
