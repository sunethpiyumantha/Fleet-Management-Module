<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestProcess extends Model
{
    use HasFactory;

    protected $table = 'request_processes';

    protected $fillable = [
        'req_id',
        'from_user_id',
        'from_establishment_id',
        'to_user_id',
        'to_establishment_id',
        'remark',
        'status',
        'processed_at',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    // Relationships
    public function request(): BelongsTo // Assuming links to VehicleRequestApproval via serial_number
    {
        return $this->belongsTo(VehicleRequestApproval::class, 'req_id', 'serial_number');
    }

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function fromEstablishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'from_establishment_id', 'e_id');
    }

    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function toEstablishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'to_establishment_id', 'e_id');
    }

    // Scopes for easy querying
    public function scopeForRequest($query, string $reqId)
    {
        return $query->where('req_id', $reqId)->orderBy('processed_at', 'asc');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Accessor for status badge (similar to your VehicleRequestApproval)
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

    // Helper to get full step description
    public function getStepDescriptionAttribute(): string
    {
        $from = $this->fromUser?->name . ' (' . $this->fromEstablishment?->display_name . ')';
        $to = $this->toUser?->name . ' (' . $this->toEstablishment?->display_name . ')';
        return "From: {$from} | To: {$to} | Remark: {$this->remark} | Status: {$this->status}";
    }
}