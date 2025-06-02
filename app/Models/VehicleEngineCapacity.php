<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleEngineCapacity extends Model
{
    // SoftDeletes;

    protected $table = 'vehicle_engine_capacities';

    protected $fillable = ['engine_capacity'];
}

