<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleType;
use App\Models\VehicleAllocationType;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Models\VehicleCategory;
use App\Models\VehicleSubCategory;
use App\Models\VehicleColor;
use App\Models\VehicleTireSize;
use App\Models\VehicleEngineCapacity;
use App\Models\FuelType;
use App\Models\Workshop;
use App\Models\Status;
use App\Models\Location;
use App\Models\Driver;
use App\Models\Fault;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Vehicle Types
        VehicleType::create(['type' => 'Truck']);
        VehicleType::create(['type' => 'Car']);
        VehicleType::create(['type' => 'Bus']);

        // Vehicle Allocation Types
        VehicleAllocationType::create(['type' => 'Permanent']);
        VehicleAllocationType::create(['type' => 'Temporary']);

        // Vehicle Makes
        $toyota = VehicleMake::create(['make' => 'Toyota']);
        $ford = VehicleMake::create(['make' => 'Ford']);

        // Vehicle Models
        VehicleModel::create(['make_id' => $toyota->id, 'model' => 'Camry']);
        VehicleModel::create(['make_id' => $toyota->id, 'model' => 'Corolla']);
        VehicleModel::create(['make_id' => $ford->id, 'model' => 'F-150']);

        // Vehicle Categories
        $cat1 = VehicleCategory::create(['category' => 'Passenger']);
        $cat2 = VehicleCategory::create(['category' => 'Commercial']);

        // Vehicle Sub Categories
        VehicleSubCategory::create(['cat_id' => $cat1->id, 'sub_category' => 'Sedan']);
        VehicleSubCategory::create(['cat_id' => $cat1->id, 'sub_category' => 'SUV']);
        VehicleSubCategory::create(['cat_id' => $cat2->id, 'sub_category' => 'Truck']);

        // Vehicle Colors
        VehicleColor::create(['color' => 'Red']);
        VehicleColor::create(['color' => 'Blue']);
        VehicleColor::create(['color' => 'White']);

        // Vehicle Tire Sizes
        VehicleTireSize::create(['front_tire_size' => '205/55R16', 'rear_tire_size' => '205/55R16']);
        VehicleTireSize::create(['front_tire_size' => '225/65R17', 'rear_tire_size' => '225/65R17']);

        // Vehicle Engine Capacities
        VehicleEngineCapacity::create(['engine_capacity' => '2.0L']);
        VehicleEngineCapacity::create(['engine_capacity' => '3.5L']);

        // Fuel Types
        FuelType::create(['fuel_type' => 'Petrol']);
        FuelType::create(['fuel_type' => 'Diesel']);

        // Workshops
        Workshop::create(['workshop_type' => 'Main Workshop']);
        Workshop::create(['workshop_type' => 'Service Center']);

        // Statuses
        Status::create(['name' => 'Approved']);
        Status::create(['name' => 'Pending']);
        Status::create(['name' => 'Rejected']);

        // Locations
        Location::create(['name' => 'Base A']);
        Location::create(['name' => 'Base B']);

        // Drivers
        Driver::create(['driver_name' => 'John Doe', 'reg_nic' => '123456789V', 'rank' => 'Sergeant', 'unit' => 'Unit 1', 'code_no_driver' => 'D001', 'army_license_no' => 'L123', 'license_issued_date' => '2023-01-01', 'license_expire_date' => '2026-01-01']);
        Driver::create(['driver_name' => 'Jane Smith', 'reg_nic' => '987654321V', 'rank' => 'Corporal', 'unit' => 'Unit 2', 'code_no_driver' => 'D002', 'army_license_no' => 'L124', 'license_issued_date' => '2023-02-01', 'license_expire_date' => '2026-02-01']);

        // Faults
        Fault::create(['name' => 'Engine Failure']);
        Fault::create(['name' => 'Brake Issue']);

        $this->call(EstablishmentsSeeder::class);
    }
}