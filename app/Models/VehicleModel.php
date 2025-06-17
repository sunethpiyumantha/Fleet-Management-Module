<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\VehicleType;
use App\Models\VehicleDeclaration;

class VehicleModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vehicle_models';
    protected $fillable = ['model', 'serial_number'];

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

    /**
     * Get the vehicle declarations for the vehicle model.
     */
    public function vehicleDeclarations()
    {
        return $this->hasMany(VehicleDeclaration::class);
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