<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VehicleColor extends Model
{
    protected $table = 'vehicle_colors';
    protected $fillable = ['color'];
}