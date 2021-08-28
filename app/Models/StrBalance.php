<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrBalance extends Model
{
  //  use HasFactory;
    protected $guarded = [];

    /**
     * Get the 
     *
     * @param  string  $value
     * @return string
     */
    public function purchase()
    {
        return $this->belongsTo('App\Models\Purchase');
    }
    public function getMinUnitePriceAttribute()
    {
        $item = $this->purchase->items->where('str_material_id', $this->str_material_id)->first();
        if (!$item) return 0;
        return $item->min_unite_price;
    }
}
