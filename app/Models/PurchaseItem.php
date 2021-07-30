<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
  //  use HasFactory;

    protected $guarded = [];

    public function payment()
    {
        return $this->belongsTo('App\Models\Payment');
    }
    public function material()
    {
        return $this->belongsTo('App\Models\StrProduct', 'str_material_id');
    }

    /**
     * Get the 
     *
     * @param  string  $value
     * @return string
     */
    public function getMaterialNameAttribute($value)
    {
        return $this->material->name;
    }
}
