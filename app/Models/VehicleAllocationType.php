<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class VehicleAllocationType extends Model
{
    protected $table = 'vehicle_allocation_types';
    protected $fillable = ['type'];
}