<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
   // use HasFactory;
   public $table='equipments';
    protected $guarded = [];
    protected $appends = ['state', 'next_destruction_date'];

    public function account()
    {
        return $this->morphOne('App\Models\Account', 'accountable')->withDefault(['id' => -1, 'name' => 'غير محدد']);
    }

    public function driver()
    {
        return $this->belongsTo('App\Models\Employee', 'default_driver_id')->withDefault(['id' => -1, 'name' => 'غير محدد']);
    }

    public function repaire_orders()
    {
        return $this->hasMany('App\Models\RepaireOrder', 'equipment_id');
    }

    public function activities()
    {
        return $this->morphTo('App\Models\Actitvity', 'activable');
    }

    public function getStateAttribute()
    {
        if (date('Y-m-d') >= date('Y-m-d', strtotime($this->service_start_date)) && date('Y-m-d') <= date('Y-m-d', strtotime($this->destruction_end_date))) return 'active';
        return 'destructed';
    }

    public function getNextDestructionDateAttribute()
    {

        $date = $this->start_service_date;
        if ($this->last_destruction_date) $date = $this->last_destruction_date;

        return  date('Y-m-d', strtotime($date . ' + ' . $this->destruction_duration . ' ' . $this->destruction_duration_type));
    }
}
