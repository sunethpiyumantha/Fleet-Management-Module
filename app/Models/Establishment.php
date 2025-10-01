<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    use HasFactory;

    protected $table = 'establishments';
    protected $primaryKey = 'e_id'; // Matches SQL: e_id (int(11))
    public $incrementing = true;
    protected $keyType = 'int'; // Matches int(11), not bigint

    protected $fillable = [
        'e_name',
        'abb_name',
        'type_code',
    ];

    // No timestamps (SQL dump has none)
    public $timestamps = false;

    // Accessor for 'name' (for consistency in views/controllers)
    public function getNameAttribute()
    {
        return $this->e_name;
    }

    // Mutator to set e_name from 'name' input
    public function setNameAttribute($value)
    {
        $this->attributes['e_name'] = $value;
    }

    // Optional: Accessor for display (e_name + abb_name)
    public function getDisplayNameAttribute()
    {
        return $this->e_name . ' (' . $this->abb_name . ')';
    }
}