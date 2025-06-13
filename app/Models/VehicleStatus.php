<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleStatus extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'vehicle_statuses';
    protected $fillable = ['status'];
}