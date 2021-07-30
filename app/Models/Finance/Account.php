<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Account extends Model
{
    use NodeTrait;
    protected $primaryKey='id';
    protected $table='accounts';
}
