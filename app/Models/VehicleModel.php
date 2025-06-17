<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'vehicle_models';
    protected $fillable = ['model'];

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

    /**
     * Get the vehicle declarations for the vehicle model.
     */
    public function vehicleDeclarations()
    {
        return $this->hasMany(VehicleDeclaration::class);
    }
}