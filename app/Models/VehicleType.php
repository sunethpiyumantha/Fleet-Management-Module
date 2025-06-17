<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{

    use HasFactory, SoftDeletes;
    protected $table = 'vehicle_types';
    protected $fillable = ['type'];

    public function vehicleModels()
    {
        return $this->hasMany(VehicleModel::class);
    }

    /**
     * Get the vehicle declarations for the vehicle type.
     */
    public function vehicleDeclarations()
    {
        return $this->hasMany(VehicleDeclaration::class);
    }
}