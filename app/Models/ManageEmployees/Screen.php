<?php

namespace App\Models\ManageEmployees;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    protected $fillable=['screen_route','operation_type','module_id','module_name','screen_name','sort'];
    protected $primaryKey='module_id';
    public $timestamps = false;
}
