<?php

namespace App\Models\ManageEmployees;

use Illuminate\Database\Eloquent\Model;

class Role_has_permission extends Model
{
    protected $table='role_has_permissions';
    protected $fillable=['screen_route','operation_id','role_id'];
    protected $primarKey='screen_route';
    public $timestamps = false;
}
