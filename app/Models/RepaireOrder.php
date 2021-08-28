<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepaireOrder extends Model
{
  //  use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function Main()
    {
        return $this->belongsTo('App\Models\Main');
    }

    public function driver()
    {
        return $this->belongsTo('App\Models\Employee', 'driver_id');
    }

    public function equipment()
    {
        return $this->belongsTo('App\Models\Equipment', 'equipment_id')->withDefault(['id' => -1, 'name' => 'غير محدد']);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function corrector()
    {
        return $this->belongsTo('App\Models\Employee', 'repaire_person_id');
    }

    public function parts()
    {
        return $this->hasMany('App\Models\RepaireOrderParts');
    }
    public function products()
    {
        return $this->belongsToMany('App\Models\StrProduct', 'repaire_order_parts')->withPivot('quantity');
    }
}
