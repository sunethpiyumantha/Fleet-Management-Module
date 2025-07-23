<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleTechnicalDescription extends Model
{
    use SoftDeletes;
    protected $fillable = ['serial_number', 'gross_weight', 'seats_sleme', 'comparable', 'seats_mvr'];

    protected $dates = ['deleted_at'];

    public function vehicleDeclaration()
    {
        return $this->belongsTo(VehicleDeclaration::class, 'serial_number', 'serial_number');
    }
}