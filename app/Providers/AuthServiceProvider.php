<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Define Gates for each permission, using the User's hasPermission method
        $permissions = [
            'Role Create', 'Role List', 'User Edit', 'Logindetail List', 'Role Delete', 'User Create', 'User List',
            'Request Create', 'Request Edit (own)', 'Request List (all / own)', 'Request Delete (own, before approval)',
            'Approve Request', 'Reject Request', 'Forward Request', 'Add Forward Reason',
            'Establishment Create', 'Establishment Edit', 'Establishment Delete', 'Establishment List',
            'Manage Notifications'
            // Add more as needed from your seeder, e.g., 'Request Create', etc.
        ];

        foreach ($permissions as $permission) {
            Gate::define($permission, function (User $user) use ($permission) {
                return $user->hasPermission($permission);
            });
        }
    }
}