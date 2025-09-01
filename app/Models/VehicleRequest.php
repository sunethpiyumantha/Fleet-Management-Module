<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\VehicleCategory;
use App\Models\VehicleSubCategory;
use App\Models\VehicleDeclaration;
use App\Models\VehicleCertificate;

class VehicleRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vehicle_requests';
    protected $fillable = [
        'serial_number',
        'request_type',
        'cat_id',
        'sub_cat_id',
        'qty',
        'date_submit',
        'status',
        'vehicle_book_path',
        'image_01_path',
        'image_02_path',
        'image_03_path',
        'image_04_path',
    ];

    public function category()
    {
        return $this->belongsTo(VehicleCategory::class, 'cat_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(VehicleSubCategory::class, 'sub_cat_id');
    }

    public function declarations()
    {
        return $this->hasMany(VehicleDeclaration::class, 'serial_number', 'serial_number');
    }

    public function certificates()
    {
        return $this->hasMany(VehicleCertificate::class, 'vehicle_request_id');
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