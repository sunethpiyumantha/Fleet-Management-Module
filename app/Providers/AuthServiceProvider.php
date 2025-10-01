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
            // User Management
            'Role Create', 'Role List', 'User Edit', 'Logindetail List', 'Role Delete', 'User Create', 'User List','Role Update','Role Edit',
            // Requests
            'Request Create', 'Request Edit (own)', 'Request List (all / own)', 'Request Delete (own, before approval)',
            'Approve Request', 'Reject Request', 'Forward Request', 'Add Forward Reason',
            // Establishment Management
            'Establishment Create', 'Establishment Edit', 'Establishment Delete', 'Establishment List',
            // System
            'Manage Notifications',
        ];

        foreach ($permissions as $permission) {
            Gate::define($permission, function (User $user) use ($permission) {
                return $user->hasPermission($permission);
            });
        }
    }
}