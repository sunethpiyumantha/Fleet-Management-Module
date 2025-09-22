<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'notes',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    // Relationships - Updated to match your existing models
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

    // Accessors - Updated to use your field names
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
}