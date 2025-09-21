<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number', 'request_type', 'vehicle_type', 'vehicle_allocation_type', 'vehicle_army_no',
        'civil_no', 'chassis_no', 'engine_no', 'vehicle_make', 'vehicle_model', 'vehicle_category',
        'vehicle_sub_category', 'color', 'status', 'current_vehicle_status', 't5_location',
        'parking_place', 'front_tire_size', 'rear_tire_size', 'engine_capacity', 'fuel_type',
        'seating_capacity', 'gross_weight', 'tare_weight', 'load_capacity', 'acquired_date',
        'handover_date', 'part_x_no', 'part_x_location', 'part_x_date', 'insurance_period_from',
        'insurance_period_to', 'emission_test_status', 'emission_test_year', 'workshop',
        'admitted_workshop', 'workshop_admitted_date', 'service_date', 'next_service_date',
        'driver', 'fault', 'remarks', 'image_front', 'image_rear', 'image_side'
    ];

    protected $table = 'vehicles'; // Explicitly set if table name differs

    // Relationships (adjust based on your foreign keys)
    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type', 'id');
    }

    public function make()
    {
        return $this->belongsTo(Make::class, 'vehicle_make', 'id');
    }

    public function model()
    {
        return $this->belongsTo(Model::class, 'vehicle_model', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'vehicle_category', 'id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'vehicle_sub_category', 'id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status', 'id');
    }

    public function locationT5()
    {
        return $this->belongsTo(Location::class, 't5_location', 'id');
    }

    public function locationPartX()
    {
        return $this->belongsTo(Location::class, 'part_x_location', 'id');
    }

    public function tireSizeFront()
    {
        return $this->belongsTo(TireSize::class, 'front_tire_size', 'id');
    }

    public function tireSizeRear()
    {
        return $this->belongsTo(TireSize::class, 'rear_tire_size', 'id');
    }

    public function engineCapacity()
    {
        return $this->belongsTo(EngineCapacity::class, 'engine_capacity', 'id');
    }

    public function fuelType()
    {
        return $this->belongsTo(FuelType::class, 'fuel_type', 'id');
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class, 'workshop', 'id');
    }

    public function admittedWorkshop()
    {
        return $this->belongsTo(Workshop::class, 'admitted_workshop', 'id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver', 'id');
    }

    public function fault()
    {
        return $this->belongsTo(Fault::class, 'fault', 'id');
    }
}