<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

class DropdownController extends Controller
{
    public function getVehicleTypes()
    {
        $data = VehicleType::whereNull('deleted_at')->get(['id', 'type as text']);
        \Log::info('Vehicle Types Query Result: Count=' . $data->count() . ', Data=' . json_encode($data->toArray()));
        return response()->json($data);
    }

    public function getAllocationTypes()
    {
        $data = VehicleAllocationType::whereNull('deleted_at')->get(['id', 'type as text']);
        \Log::info('Allocation Types Query Result: Count=' . $data->count() . ', Data=' . json_encode($data->toArray()));
        return response()->json($data);
    }

    public function getMakes()
    {
        $data = VehicleMake::whereNull('deleted_at')->get(['id', 'make as text']);
        \Log::info('Makes Query Result: Count=' . $data->count() . ', Data=' . json_encode($data->toArray()));
        return response()->json($data);
    }

    public function getModels($makeId)
    {
        $data = VehicleModel::where('make_id', $makeId)->whereNull('deleted_at')->get(['id', 'model as text']);
        \Log::info('Models Query Result for Make ID ' . $makeId . ': Count=' . $data->count() . ', Data=' . json_encode($data->toArray()));
        return response()->json($data);
    }

    public function getCategories()
    {
        $data = VehicleCategory::whereNull('deleted_at')->get(['id', 'category as text']);
        \Log::info('Categories Query Result: Count=' . $data->count() . ', Data=' . json_encode($data->toArray()));
        return response()->json($data);
    }

    public function getSubCategories($categoryId)
    {
        $data = VehicleSubCategory::where('cat_id', $categoryId)->whereNull('deleted_at')->get(['id', 'sub_category as text']);
        \Log::info('SubCategories Query Result for Category ID ' . $categoryId . ': Count=' . $data->count() . ', Data=' . json_encode($data->toArray()));
        return response()->json($data);
    }

    public function getColors()
    {
        $data = VehicleColor::whereNull('deleted_at')->get(['id', 'color as text']);
        \Log::info('Colors Query Result: Count=' . $data->count() . ', Data=' . json_encode($data->toArray()));
        return response()->json($data);
    }

    public function getTireSizes()
    {
        $data = VehicleTireSize::whereNull('deleted_at')->get(['id', 'front_tire_size as text', 'rear_tire_size as rear_text']);
        \Log::info('Tire Sizes Query Result: Count=' . $data->count() . ', Data=' . json_encode($data->toArray()));
        return response()->json($data);
    }

    public function getEngineCapacities()
    {
        $data = VehicleEngineCapacity::whereNull('deleted_at')->get(['id', 'engine_capacity as text']);
        \Log::info('Engine Capacities Query Result: Count=' . $data->count() . ', Data=' . json_encode($data->toArray()));
        return response()->json($data);
    }

    public function getFuelTypes()
    {
        $data = FuelType::whereNull('deleted_at')->get(['id', 'fuel_type as text']);
        \Log::info('Fuel Types Query Result: Count=' . $data->count() . ', Data=' . json_encode($data->toArray()));
        return response()->json($data);
    }

    public function getWorkshops()
    {
        $data = Workshop::whereNull('deleted_at')->get(['id', 'workshop_type as text']);
        \Log::info('Workshops Query Result: Count=' . $data->count() . ', Data=' . json_encode($data->toArray()));
        return response()->json($data);
    }

    public function getStatuses()
    {
        $data = Status::whereNull('deleted_at')->get(['id', 'name as text']);
        \Log::info('Statuses Query Result: Count=' . $data->count() . ', Data=' . json_encode($data->toArray()));
        return response()->json($data);
    }

    public function getLocations()
    {
        $data = Location::whereNull('deleted_at')->get(['id', 'name as text']);
        \Log::info('Locations Query Result: Count=' . $data->count() . ', Data=' . json_encode($data->toArray()));
        return response()->json($data);
    }

    public function getDrivers()
    {
        $data = Driver::whereNull('deleted_at')->get(['id', 'driver_name as text']);
        \Log::info('Drivers Query Result: Count=' . $data->count() . ', Data=' . json_encode($data->toArray()));
        return response()->json($data);
    }

    public function getFaults()
    {
        $data = Fault::whereNull('deleted_at')->get(['id', 'name as text']);
        \Log::info('Faults Query Result: Count=' . $data->count() . ', Data=' . json_encode($data->toArray()));
        return response()->json($data);
    }
}