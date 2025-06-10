<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleSubCategory extends Model
{
    protected $table = 'vehicle_sub_categories';
    protected $primaryKey = 'id';
    protected $fillable = ['cat_id', 'sub_category'];

    public function category()
    {
        return $this->belongsTo(VehicleCategory::class, 'cat_id');
    }
}