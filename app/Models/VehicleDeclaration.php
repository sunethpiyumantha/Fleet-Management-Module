<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Add this import

class VehicleDeclaration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'serial_number', // Add to allow mass assignment
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
        'owner_next_of_kin',
        'driver_full_name',
        'driver_address',
        'driver_license_number',
        'driver_nic_number',
        'driver_next_of_kin',
        'civil_number',
        'product_classification',
        'engine_no',
        'chassis_number',
        'year_of_manufacture',
        'date_of_original_registration',
        'engine_capacity',
        'section_4_w_2w',
        'speedometer_hours',
        'code_no',
        'color',
        'pay_per_day',
        'type_of_fuel',
        'tar_weight_capacity',
        'amount_of_fuel',
        'reason_for_taking_over',
        'other_matters',
        'registration_certificate_path',
        'insurance_certificate_path',
        'revenue_license_certificate_path',
        'owners_certified_nic_path',
        'owners_certified_bank_passbook_path',
        'suppliers_scanned_sign_document_path',
        'affidavit_non_joint_account_path',
        'affidavit_army_driver_path',
    ];

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function vehicleModel()
    {
        return $this->belongsTo(VehicleModel::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->serial_number) {
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