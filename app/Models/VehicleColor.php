<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleColor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vehicle_colors';
    protected $fillable = ['color'];
}