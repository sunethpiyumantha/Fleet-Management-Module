<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleRequest extends Model
{
    protected $table = 'vehicle_requests';
    protected $fillable = ['cat_id', 'sub_cat_id', 'required_quantity', 'date_submit'];

    public function category()
    {
        return $this->belongsTo(VehicleCategory::class, 'cat_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(VehicleSubCategory::class, 'sub_cat_id');
    }
}