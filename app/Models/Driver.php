<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'vehicle_declaration_id', 'reg_nic', 'rank', 'driver_name', 'unit',
        'code_no_driver', 'army_license_no', 'license_issued_date', 'license_expire_date',
    ];

    public function vehicleDeclaration()
    {
        return $this->belongsTo(VehicleDeclaration::class);
    }
}