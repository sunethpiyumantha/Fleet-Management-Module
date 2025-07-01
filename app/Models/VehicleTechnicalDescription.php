<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleTechnicalDescription extends Model
{
    protected $fillable = ['serial_number', 'gross_weight', 'seats_sleme', 'comparable', 'seats_mvr'];
}