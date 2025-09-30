<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'Role Create', 'Role List', 'User Edit', 'Logindetail List', 'Role Delete', 'User Create', 'User List',
            'Request Create', 'Request Edit (own)', 'Request List (all / own)', 'Request Delete (own, before approval)',
            'Approve Request', 'Reject Request', 'Forward Request', 'Add Forward Reason',
            'Establishment Create', 'Establishment Edit', 'Establishment Delete', 'Establishment List',
            'Manage Notifications'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}