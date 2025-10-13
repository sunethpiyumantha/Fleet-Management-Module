<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create or find the Super Administrator role
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'Super Administrator']
        );

        // List of permissions for Super Admin (focusing on role and user management as requested)
        $superAdminPermissions = [
            // Role management
            'Role Create',
            'Role List',
            'Role Update',
            'Role Edit',
            'Role Delete',
            // User management
            'User Create',
            'User List',
            'User Edit',
            'User Delete',
            // Optional: Include others if needed for full access
            'Logindetail List',
        ];

        // Fetch permission IDs
        $permissionIds = Permission::whereIn('name', $superAdminPermissions)->pluck('id');

        // Attach permissions to the Super Admin role
        $superAdminRole->permissions()->sync($permissionIds);
    }
}