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

        // Fetch ALL permission IDs for full super admin access
        $allPermissionIds = Permission::pluck('id');

        // Attach all permissions to the Super Admin role
        $superAdminRole->permissions()->sync($allPermissionIds);

        // Add Fleet Operator role (unchanged)
        $fleetRole = Role::firstOrCreate(['name' => 'Fleet Operator']);
        $fleetPermissions = [
            'Request Create',
            'Request Edit (own)',
            'Request Delete (own, before approval)',
            'Forward Request',
            'Reject Request',
            'Request List (all / own)',
        ];
        $fleetPermissionIds = Permission::whereIn('name', $fleetPermissions)->pluck('id');
        $fleetRole->permissions()->sync($fleetPermissionIds);

        // Add Request Handler role (unchanged)
        $handlerRole = Role::firstOrCreate(['name' => 'Request Handler']);
        $handlerPermissions = [
            'Forward Request',
            'Reject Request',
            'Approve Request',
            'Request List (all / own)',
        ];
        $handlerPermissionIds = Permission::whereIn('name', $handlerPermissions)->pluck('id');
        $handlerRole->permissions()->sync($handlerPermissionIds);

        // Add Establishment Head role (unchanged)
        $headRole = Role::firstOrCreate(['name' => 'Establishment Head']);
        $headPermissions = [
            'Forward Request',
            'Reject Request',
            'Approve Request',
            'Request List (all / own)',
        ];
        $headPermissionIds = Permission::whereIn('name', $headPermissions)->pluck('id');
        $headRole->permissions()->sync($headPermissionIds);

        // Add Establishment Admin role (unchanged)
        $adminRole = Role::firstOrCreate(['name' => 'Establishment Admin']);
        $adminPermissions = [
            'Forward Request',
            'Reject Request',
            'Approve Request',
            'Request List (all / own)',
        ];
        $adminPermissionIds = Permission::whereIn('name', $adminPermissions)->pluck('id');
        $adminRole->permissions()->sync($adminPermissionIds);
    }
}