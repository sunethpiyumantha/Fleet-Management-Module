<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArmyVehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number',
        'vehicle_type_id',
        'vehicle_allocation_type_id',
        'vehicle_army_no',
        'civil_no',
        'chassis_no',
        'engine_no',
        'vehicle_make_id',
        'vehicle_model_id',
        'vehicle_category_id',
        'vehicle_sub_category_id',
        'color_id',
        'status_id',
        'current_vehicle_status',
        't5_location',
        'parking_place',
        'front_tire_size_id',
        'rear_tire_size_id',
        'engine_capacity_id',
        'fuel_type_id',
        'seating_capacity',
        'gross_weight',
        'tare_weight',
        'load_capacity',
        'acquired_date',
        'handover_date',
        'part_x_no',
        'part_x_location',
        'part_x_date',
        'insurance_period_from',
        'insurance_period_to',
        'emission_test_status',
        'emission_test_year',
        'workshop_id',
        'admitted_workshop_id',
        'workshop_admitted_date',
        'service_date',
        'next_service_date',
        'driver_id',
        'fault',
        'remarks',
        'image_front',
        'image_rear',
        'image_side',
    ];

    // Relationships (mirror Vehicle.php)
    public function vehicleType() { return $this->belongsTo(VehicleType::class, 'vehicle_type_id'); }
    public function vehicleAllocationType() { return $this->belongsTo(VehicleAllocationType::class, 'vehicle_allocation_type_id'); }
    public function vehicleMake() { return $this->belongsTo(VehicleMake::class, 'vehicle_make_id'); }
    public function vehicleModel() { return $this->belongsTo(VehicleModel::class, 'vehicle_model_id'); }
    public function category() { return $this->belongsTo(VehicleCategory::class, 'vehicle_category_id'); }
    public function subCategory() { return $this->belongsTo(VehicleSubCategory::class, 'vehicle_sub_category_id'); }
    public function color() { return $this->belongsTo(VehicleColor::class, 'color_id'); }
    public function status() { return $this->belongsTo(VehicleStatus::class, 'status_id'); }
    public function frontTireSize() { return $this->belongsTo(VehicleTireSize::class, 'front_tire_size_id'); }
    public function rearTireSize() { return $this->belongsTo(VehicleTireSize::class, 'rear_tire_size_id'); }
    public function engineCapacity() { return $this->belongsTo(VehicleEngineCapacity::class, 'engine_capacity_id'); }
    public function fuelType() { return $this->belongsTo(FuelType::class, 'fuel_type_id'); }
    public function workshop() { return $this->belongsTo(Workshop::class, 'workshop_id'); }
    public function admittedWorkshop() { return $this->belongsTo(Workshop::class, 'admitted_workshop_id'); }
    public function driver() { return $this->belongsTo(Driver::class, 'driver_id'); }
}