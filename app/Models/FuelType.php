<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class FuelType extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'fuel_types';
    protected $fillable = ['fuel_type'];
}

