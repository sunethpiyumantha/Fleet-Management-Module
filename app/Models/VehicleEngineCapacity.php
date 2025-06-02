<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleEngineCapacity extends Model
{
    use SoftDeletes;

    protected $fillable = ['engine_capacity'];
}

