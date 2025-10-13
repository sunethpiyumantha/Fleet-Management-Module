<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestProcess extends Model
{
    use HasFactory;

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

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function fromEstablishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'from_establishment_id', 'e_id');
    }

    public function toEstablishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'to_establishment_id', 'e_id');
    }

    public function vehicleRequestApproval()
    {
        return $this->belongsTo(VehicleRequestApproval::class, 'req_id', 'serial_number');
    }
}