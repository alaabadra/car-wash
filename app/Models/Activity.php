<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
   // use HasFactory;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    //protected $dateFormat = 'Y-m-d H:i:s';

    public function activable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the 
     *
     * @param  string  $value
     * @return string
     */
    public function getUserNameAttribute()
    {
        return $this->user->name;
    }
    public function getDateAttribute()
    {
        return date($this->created_at, strtotime('d-m-Y h:i a'));
    }

    public function getDescriptionAttribute()
    {
        return $this->type . ' بتاريخ  '  . date('d-m-Y', strtotime($this->created_at)) . '  بواسطة المستخدم  ' . $this->user->name;
    }
}
