<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();

        $permissionsAdmin = [
            'use-crud',
            'use-admin-panel',
            'use-sto-panel',
        ];

        $permissionsManager = [
            'use-sto-panel',
        ];

        $permissionsByRole = [
            'admin' => $permissionsAdmin,
            'manager' => $permissionsManager,
        ];

        $allPermissions = array_unique(array_merge($permissionsAdmin, $permissionsManager));

        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin->syncPermissions($permissionsAdmin);

        foreach ($permissionsByRole as $role => $permissions) {
            $model = Role::firstOrCreate(['name' => $role]);
            $model->syncPermissions($permissions);
        }

        if (! $admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        $manager = User::query()->where('email', 'manager@example.com')->first();
        if ($manager) {
            $manager->syncPermissions($permissionsManager);
            if (! $manager->hasRole('manager')) {
                $manager->assignRole('manager');
            }
        }
    }
}
