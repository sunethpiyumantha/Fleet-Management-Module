<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleCategory extends Model
{
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