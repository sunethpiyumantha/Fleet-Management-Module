<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleTireSize extends Model
{
    //use HasFactory;
    protected $table = 'vehicle_tire_sizes';
    protected $fillable = ['front_tire_size', 'rear_tire_size'];
}