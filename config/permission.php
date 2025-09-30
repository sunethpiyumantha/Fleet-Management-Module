<?php

return [

    'models' => [
        'permission' => Spatie\Permission\Models\Permission::class,
        'role' => Spatie\Permission\Models\Role::class,
    ],

    'table_names' => [
        'roles' => 'roles',
        'permissions' => 'permissions',
        'model_has_permissions' => 'model_has_permissions',
        'model_has_roles' => 'model_has_roles',
        'role_has_permissions' => 'role_permission', // Match your custom pivot
    ],

    'column_names' => [
        'model_morph_key' => 'id',
        'team_foreign_key' => 'team_id',
        'role_pivot_key' => null,
        'permission_pivot_key' => null,
    ],

    'teams' => [
        'enabled' => false,
        'model' => null,
    ],

    'cache' => [
        'expiration_time' => \DateInterval::createFromDateString('24 hours'),
        'key' => 'spatie.permission.cache',
        'store' => 'default',
    ],

];