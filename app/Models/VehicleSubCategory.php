<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleSubCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'vehicle_sub_categories';
    protected $primaryKey = 'id';
    protected $fillable = ['cat_id', 'sub_category'];

    public function category()
    {
        return $this->belongsTo(VehicleCategory::class, 'cat_id');
    }

    public function vehicleRequests()
    {
        return $this->hasMany(VehicleRequest::class, 'sub_cat_id');
    }
}