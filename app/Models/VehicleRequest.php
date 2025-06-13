<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleRequest extends Model
{

    use HasFactory, SoftDeletes;
    protected $table = 'vehicle_requests';
    protected $fillable = ['cat_id', 'sub_cat_id', 'qty', 'date_submit', 'status','request_type',];

    public function category()
    {
        return $this->belongsTo(VehicleCategory::class, 'cat_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(VehicleSubCategory::class, 'sub_cat_id');
    }
}