<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

   // use HasApiTokens;
   // use HasFactory;
   // use HasProfilePhoto;
    use Notifiable;
 //   use TwoFactorAuthenticatable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $fillable = [
        'name', 'email', 'password', 'company_id','employee_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'roles_var' => 'array',
        'perms' => 'array'
    ];


    protected $appends = [
        'profile_photo_url',
    ];
    public function getPermissionsAttribute()
    {
        //  return $this->role->pluck('permissions');
        return Arr::flatten($this->roles->pluck('permissions'));
    }

    public function employee()
    {
        return  $this->belongsTo('App\Models\Employee');
    }

    public function role()
    {
        return  $this->belongsTo('App\Models\Role', 'role_id');
    }

    public function roles()
    {
        return  $this->belongsToMany('App\Models\Role', 'user_role');
    }

    public function accounts()
    {
        return $this->morphMany('App\Models\Account', 'accountable');
    }

    public function cash_account()
    {
        return  $this->belongsTo('App\Models\Account', 'cash_account_id');
    }


    public function bank_account()
    {
        return  $this->belongsTo('App\Models\Account', 'bank_account_id');
    }


    public function check($var)
    {
        if (!is_array($var)) $var = [$var];
        if (!empty(array_intersect(['admin'],  $this->permissions))) return 1;
        return   !empty(array_intersect($var,  $this->permissions));
    }
}
