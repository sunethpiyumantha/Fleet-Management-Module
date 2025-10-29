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
        'establishment_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'establishment_id', 'e_id');
    }

    public function hasPermission($permission)
    {
        return $this->role && $this->role->permissions()->where('name', $permission)->exists();
    }

    // Optional: Add this for checking multiple permissions at once
    public function hasAnyPermission(array $permissions)
    {
        return $this->role && $this->role->permissions()->whereIn('name', $permissions)->exists();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}