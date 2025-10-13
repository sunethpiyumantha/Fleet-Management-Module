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

        // Add Fleet Operator role
        $fleetRole = Role::firstOrCreate(['name' => 'Fleet Operator']);
        $fleetPermissions = [
            'Request Create',
            'Request Edit (own)',
            'Request Delete (own, before approval)',
            'Forward Request',
            'Reject Request',
        ];
        $fleetPermissionIds = Permission::whereIn('name', $fleetPermissions)->pluck('id');
        $fleetRole->permissions()->sync($fleetPermissionIds);

        // Add Request Handler role
        $handlerRole = Role::firstOrCreate(['name' => 'Request Handler']);
        $handlerPermissions = [
            'Forward Request',
            'Reject Request',
            'Approve Request',
        ];
        $handlerPermissionIds = Permission::whereIn('name', $handlerPermissions)->pluck('id');
        $handlerRole->permissions()->sync($handlerPermissionIds);

        // Add Establishment Head role
        $headRole = Role::firstOrCreate(['name' => 'Establishment Head']);
        $headPermissions = [
            'Forward Request',
            'Reject Request',
            'Approve Request',
        ];
        $headPermissionIds = Permission::whereIn('name', $headPermissions)->pluck('id');
        $headRole->permissions()->sync($headPermissionIds);

        // Add Establishment Admin role
        $adminRole = Role::firstOrCreate(['name' => 'Establishment Admin']);
        $adminPermissions = [
            'Forward Request',
            'Reject Request',
            'Approve Request',
        ];
        $adminPermissionIds = Permission::whereIn('name', $adminPermissions)->pluck('id');
        $adminRole->permissions()->sync($adminPermissionIds);
    }
}