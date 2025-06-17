<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\VehicleSubCategory;
use App\Models\VehicleRequest;

class VehicleCategory extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'vehicle_categories';
    protected $fillable = ['category', 'serial_number'];

    public function subCategories()
    {
        return $this->hasMany(VehicleSubCategory::class, 'cat_id');
    }

    public function vehicleRequests()
    {
        return $this->hasMany(VehicleRequest::class, 'cat_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->serial_number) {
                $date = Carbon::now()->format('Ymd'); // e.g., 20250617
                $lastRecord = static::whereDate('created_at', Carbon::today())
                    ->latest('id')
                    ->lockForUpdate() // Prevents race conditions
                    ->first();
                $sequence = $lastRecord ? (int)substr($lastRecord->serial_number, -4) + 1 : 1;
                $sequence = str_pad($sequence, 4, '0', STR_PAD_LEFT); // e.g., 0001
                $model->serial_number = "{$date}-{$sequence}";
            }
        });
    }
}