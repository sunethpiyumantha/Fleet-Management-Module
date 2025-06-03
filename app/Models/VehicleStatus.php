<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VehicleStatus extends Model
{
    protected $table = 'vehicle_statuses';
    protected $fillable = ['status'];
}