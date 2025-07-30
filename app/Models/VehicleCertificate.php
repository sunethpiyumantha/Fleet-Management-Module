<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleCertificate extends Model
{
    protected $fillable = [
        'vehicle_request_id',
        'engine_number',
        'chassis_number',
        'engine_performance',
        'electrical_system',
        'transmission_system',
        'tires',
        'brake_system',
        'suspension_system',
        'air_conditioning',
        'seats_condition',
        'fuel_efficiency',
        'speedometer_reading',
        'speedometer_operation',
        'running_distance_function',
        'improvements',
        'transmission_operation',
        'battery_type',
        'battery_capacity',
        'battery_number',
        'water_capacity',
        'cover_outer',
        'certificate_validity',
        'seats_mvr',
        'seats_installed',
        'other_matters',
        'vehicle_picture',
    ];
}
