<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Establishment extends Model
{
    use HasFactory;

    protected $table = 'establishments';
    protected $primaryKey = 'e_id'; // Match the database primary key
    protected $fillable = ['e_name', 'abb_name', 'type_code', 'serial_number']; // Use e_name to match database
    public $incrementing = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->serial_number) {
                $date = Carbon::now()->format('Ymd'); // e.g., 20250930
                // Use e_id instead of id for the latest record, assuming e_id is sequential
                $lastRecord = static::whereDate('created_at', Carbon::today())->latest('e_id')->first();
                $sequence = $lastRecord ? (int)substr($lastRecord->serial_number, -4) + 1 : 1;
                $sequence = str_pad($sequence, 4, '0', STR_PAD_LEFT); // e.g., 0001
                $model->serial_number = "{$date}-{$sequence}";
            }
        });
    }

    // Optional: Accessor to map e_name to name for consistency with Blade/controller
    public function getNameAttribute()
    {
        return $this->attributes['e_name'];
    }

    // Optional: Mutator to set e_name from name input
    public function setNameAttribute($value)
    {
        $this->attributes['e_name'] = $value;
    }
}