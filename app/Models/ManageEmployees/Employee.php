<?php

namespace App\Models\ManageEmployees;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable=[
        'first_name',
        'sir_name',
        'last_name',
        'name',
        'emp_picture',
        'notes',
        'email',
        'status',
        'send_credentials',
        'allow_access',
        'language',
        'role',
        'date_of_birth',
        'gender',
        'country',
        'mobile_number',
        'present_address',
        'present_city',
        'present_state',
        'perm_address',
        'perm_city',
        'perm_state',
        'designation',
        'department',
        'emp_level',
        'join_date',
        'branch',
        'attendance_shift',
        'leave_policy',
        'holiday_lists',
    ];
}
