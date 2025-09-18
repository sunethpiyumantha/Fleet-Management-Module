<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class VehicleType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'serial_number',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->serial_number) {
                $date = Carbon::now()->format('Ymd'); // e.g. 20250918

                // Find the latest serial number for today
                $lastRecord = static::where('serial_number', 'like', "{$date}-%")
                    ->orderBy('serial_number', 'desc')
                    ->lockForUpdate()
                    ->first();

                // Increment sequence
                $sequence = $lastRecord
                    ? (int) substr($lastRecord->serial_number, -4) + 1
                    : 1;

                $sequence = str_pad($sequence, 4, '0', STR_PAD_LEFT);

                $model->serial_number = "{$date}-{$sequence}";
            }
        });
    }
}
