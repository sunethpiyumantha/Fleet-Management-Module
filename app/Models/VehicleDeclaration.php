<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleDeclaration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
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
        'registration_certificate',
        'insurance_certificate',
        'loan_tax_details',
        'daily_rent',
        'induction_date',
        'owner_next_of_kin',
        'driver_full_name',
        'driver_address',
        'driver_license_number',
        'driver_nic_number',
        'driver_next_of_kin',
        'document_1',
        'document_2',
        'document_3',
        'document_4',
    ];

    protected $casts = [
        'induction_date' => 'date',
        'daily_rent' => 'decimal:2',
        'seats_registered' => 'integer',
        'seats_current' => 'integer',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get the vehicle type that owns the declaration.
     */
    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

    /**
     * Get the vehicle model that owns the declaration.
     */
    public function vehicleModel()
    {
        return $this->belongsTo(VehicleModel::class);
    }

    /**
     * Get the full file path for registration certificate
     */
    public function getRegistrationCertificateUrlAttribute()
    {
        return $this->registration_certificate ? asset('storage/' . $this->registration_certificate) : null;
    }

    /**
     * Get the full file path for insurance certificate
     */
    public function getInsuranceCertificateUrlAttribute()
    {
        return $this->insurance_certificate ? asset('storage/' . $this->insurance_certificate) : null;
    }

    /**
     * Get the full file path for additional documents
     */
    public function getDocument1UrlAttribute()
    {
        return $this->document_1 ? asset('storage/' . $this->document_1) : null;
    }

    public function getDocument2UrlAttribute()
    {
        return $this->document_2 ? asset('storage/' . $this->document_2) : null;
    }

    public function getDocument3UrlAttribute()
    {
        return $this->document_3 ? asset('storage/' . $this->document_3) : null;
    }

    public function getDocument4UrlAttribute()
    {
        return $this->document_4 ? asset('storage/' . $this->document_4) : null;
    }
}