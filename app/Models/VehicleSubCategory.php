<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleSubCategory extends Model
{
    use HasFactory;
    protected $table = 'vehicle_sub_categories';
    protected $fillable = ['category', 'sub_category'];
}