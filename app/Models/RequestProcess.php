<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestProcess extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'processed_at' => 'datetime',
    ];

    /**
     * Possible status values for the request process.
     *
     * @var array
     */
    const STATUSES = [
        'pending' => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
        'forwarded' => 'Forwarded',
        'reforwarded' => 'Reforwarded', // Added to track reforwarding after rejection
    ];

    /**
     * Get the user who initiated this process action.
     */
    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    /**
     * Get the user to whom this process action is directed.
     */
    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    /**
     * Get the establishment from which this process action originated.
     */
    public function fromEstablishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'from_establishment_id', 'e_id');
    }

    /**
     * Get the establishment to which this process action is directed.
     */
    public function toEstablishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'to_establishment_id', 'e_id');
    }

    /**
     * Get the vehicle request approval associated with this process.
     */
    public function vehicleRequestApproval(): BelongsTo
    {
        return $this->belongsTo(VehicleRequestApproval::class, 'req_id', 'serial_number');
    }
}