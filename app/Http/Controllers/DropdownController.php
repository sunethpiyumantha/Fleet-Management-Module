<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleType;
use App\Models\AllocationType;
use App\Models\Make;
use App\Models\Model;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Color;
use App\Models\Status;
use App\Models\Location;
use App\Models\TireSize;
use App\Models\EngineCapacity;
use App\Models\FuelType;
use App\Models\Workshop;
use App\Models\Driver;
use App\Models\Fault;

class DropdownController extends Controller
{
    public function getVehicleTypes()
    {
        return VehicleType::all(['id', 'type as text']);
    }

    public function getAllocationTypes()
    {
        return AllocationType::all(['id', 'name as text']);
    }

    public function getMakes()
    {
        return Make::all(['id', 'name as text']);
    }

    public function getModels($makeId)
    {
        return Model::where('make_id', $makeId)->get(['id', 'name as text']);
    }

    public function getCategories()
    {
        return Category::all(['id', 'category as text']);
    }

    public function getSubCategories($categoryId)
    {
        return SubCategory::where('category_id', $categoryId)->get(['id', 'sub_category as text']);
    }

    public function getColors()
    {
        return Color::all(['id', 'name as text']);
    }

    public function getStatuses()
    {
        return Status::all(['id', 'name as text']);
    }

    public function getLocations()
    {
        return Location::all(['id', 'name as text']);
    }

    public function getTireSizes()
    {
        return TireSize::all(['id', 'name as text']);
    }

    public function getEngineCapacities()
    {
        return EngineCapacity::all(['id', 'name as text']);
    }

    public function getFuelTypes()
    {
        return FuelType::all(['id', 'name as text']);
    }

    public function getWorkshops()
    {
        return Workshop::all(['id', 'name as text']);
    }

    public function getDrivers()
    {
        return Driver::all(['id', 'name as text']);
    }

    public function getFaults()
    {
        return Fault::all(['id', 'name as text']);
    }
}