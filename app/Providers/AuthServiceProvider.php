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
            'Role Create', 'Role List', 'User Edit', 'Logindetail List', 'Role Delete', 'User Create', 'User List','Role Update','Role Edit', 'User Delete',
            // Requests
            'Request Create', 'Request Edit (own)', 'Request List (all / own)', 'Request Delete (own, before approval)',
            'Approve Request', 'Reject Request', 'Forward Request', 'Add Forward Reason',
            // Establishment Management
            'Establishment Create', 'Establishment Edit', 'Establishment Delete', 'Establishment List',
            // System
            'Manage Notifications',
        ];

        foreach ($permissions as $permission) {
            Gate::define($permission, function (User $user, $model = null) use ($permission) {
                // Base permission check
                if (!$user->hasPermission($permission)) {
                    return false;
                }

                // FIXED: For Approve Request and Reject Request, restrict to requests in the user's CURRENT establishment
                // (allows inter-establishment actions on 'sent'/'forwarded' requests where current_establishment_id matches)
                if (in_array($permission, ['Approve Request', 'Reject Request']) && $model && $model->current_establishment_id != $user->establishment_id) {
                    return false;
                }

                return true;
            });
        }
    }
}