<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'username',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
    ];

    // Relationship with roles table
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}