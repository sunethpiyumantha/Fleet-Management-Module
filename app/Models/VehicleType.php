<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{

    use HasFactory, SoftDeletes;
    protected $table = 'vehicle_types';
    protected $fillable = ['type'];
}