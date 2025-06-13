<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleCategory extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'vehicle_categories';
    protected $fillable = ['category'];


    public function subCategories()
    {
        return $this->hasMany(VehicleSubCategory::class, 'cat_id');
    }

    public function vehicleRequests()
    {
        return $this->hasMany(VehicleRequest::class, 'cat_id');
    }
}