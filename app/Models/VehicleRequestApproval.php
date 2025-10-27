<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

// Add this import for the requestProcesses relationship
use App\Models\RequestProcess;

// Existing imports (keep these)
use App\Models\VehicleCategory;
use App\Models\VehicleSubCategory;
use App\Models\Establishment;
use App\Models\User;
use App\Models\Vehicle;

class VehicleRequestApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number',
        'request_type',
        'category_id',
        'sub_category_id',
        'quantity',
        'status',
        'vehicle_letter',
        'approved_at',
        'approved_by',
        'current_user_id', // Renamed from user_id
        'initiated_by',
        'initiate_establishment_id',
        'current_establishment_id', // New column
        'forward_reason',
        'forwarded_at',
        'forwarded_by',
        'vehicle_type',
        'assigned_vehicle_id',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'forwarded_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(VehicleCategory::class, 'category_id', 'id');
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(VehicleSubCategory::class, 'sub_category_id', 'id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Renamed relationship to currentUser
    public function currentUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'current_user_id');
    }

    public function initiateEstablishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'initiate_establishment_id', 'e_id');
    }

    public function currentEstablishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'current_establishment_id', 'e_id');
    }

    public function forwarder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'forwarded_by');
    }

    public function initiator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'initiated_by');
    }

    public function requestProcesses(): HasMany
    {
        return $this->hasMany(RequestProcess::class, 'req_id', 'serial_number');
    }

    public function latestForwardProcess(): HasOne
    {
        return $this->hasOne(RequestProcess::class, 'req_id', 'serial_number')
            ->latestOfMany('processed_at', 'max');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Accessors
    public function getRequestTypeDisplayAttribute(): string
    {
        return match($this->request_type) {
            'replacement' => 'Vehicle Replacement',
            'new_approval' => 'New Approval Takeover',
            default => ucfirst($this->request_type)
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        $status = strtoupper($this->status);
        return match($this->status) {
            'pending' => '<span class="badge bg-warning text-dark">PENDING</span>',
            'approved' => '<span class="badge bg-success">APPROVED</span>',
            'rejected' => '<span class="badge bg-danger">REJECTED</span>',
            'forwarded' => '<span class="badge bg-info">FORWARDED</span>',
            default => '<span class="badge bg-secondary">' . $status . '</span>'
        };
    }

    // Helper to get category name
    public function getCategoryNameAttribute(): string
    {
        return $this->category ? $this->category->category : 'N/A';
    }

    // Helper to get sub category name
    public function getSubCategoryNameAttribute(): string
    {
        return $this->subCategory ? $this->subCategory->sub_category : 'N/A';
    }

    // Helper to get initiated establishment name
    public function getInitiateEstablishmentNameAttribute(): string
    {
        return $this->initiateEstablishment ? $this->initiateEstablishment->name . ' (' . $this->initiateEstablishment->abb_name . ')' : 'N/A';
    }

    // Helper to get current establishment name
    public function getCurrentEstablishmentNameAttribute(): string
    {
        return $this->currentEstablishment ? $this->currentEstablishment->name . ' (' . $this->currentEstablishment->abb_name . ')' : 'N/A';
    }

    // Helper to get initiated user name
    public function getInitiatedUserNameAttribute(): string
    {
        return $this->initiator ? $this->initiator->name : 'N/A';
    }

    // Helper to get current user name
    public function getCurrentUserNameAttribute(): string
    {
        return $this->currentUser ? $this->currentUser->name : 'N/A';
    }

    public function assignedVehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'assigned_vehicle_id');
    }
}