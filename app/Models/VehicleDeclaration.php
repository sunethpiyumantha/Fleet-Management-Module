<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VehicleDeclaration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'serial_number',
        'registration_number',
        'owner_full_name',
        'owner_initials_name',
        'owner_permanent_address',
        'owner_temporary_address',
        'owner_phone_number',
        'owner_bank_details',
        'vehicle_type_id',
        'vehicle_model_id',
        'seats_registered',
        'seats_current',
        'loan_tax_details',
        'daily_rent',
        'induction_date',
        'reg_nic',
        'rank',
        'driver_name',
        'unit',
        'code_no_driver',
        'army_license_no',
        'license_issued_date',
        'license_expire_date',
        'civil_number',
        'product_classification',
        'engine_no',
        'chassis_number',
        'year_of_manufacture',
        'date_of_original_registration',
        'engine_capacity_id',
        'section_4_w_2w',
        'speedometer_hours',
        'code_no_vehicle',
        'color_id',
        'pay_per_day',
        'fuel_type_id',
        'tar_weight_capacity',
        'amount_of_fuel',
        'reason_for_taking_over',
        'other_matters',
        'registration_certificate',
        'insurance_certificate',
        'revenue_license_certificate',
        'owners_certified_nic',
        'owners_certified_bank_passbook',
        'suppliers_scanned_sign_document',
        'affidavit_non_joint_account',
        'affidavit_army_driver',
    ];

    /**
     * Relationships
     */
    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function vehicleModel()
    {
        return $this->belongsTo(VehicleModel::class);
    }

    public function engineCapacity()
    {
        return $this->belongsTo(VehicleEngineCapacity::class, 'engine_capacity_id');
    }

    public function color()
    {
        return $this->belongsTo(VehicleColor::class, 'color_id');
    }

    public function fuelType()
    {
        return $this->belongsTo(FuelType::class);
    }

    /**
     * Boot method for auto-generating serial_number if not provided
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->serial_number)) {
                $date = Carbon::now()->format('Ymd');
                $lastRecord = static::whereDate('created_at', Carbon::today())
                    ->latest('id')
                    ->lockForUpdate()
                    ->first();
                $sequence = $lastRecord ? (int)substr($lastRecord->serial_number, -4) + 1 : 1;
                $sequence = str_pad($sequence, 4, '0', STR_PAD_LEFT);
                $model->serial_number = "{$date}-{$sequence}";
            }
        });
    }
}