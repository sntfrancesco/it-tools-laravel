<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $admin = Role::create(['name' => 'admin']);
        $support = Role::create(['name' => 'user_backend']);

        foreach (__('permissions_list') as $permission => $translate) {
            Permission::create(
                ['guard_name' => 'web', 'name' => $permission]
            );
            $admin->givePermissionTo($permission);
        }

        $adminUser = User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('SecurePassword')
        ]);
        $adminUser->assignRole('admin');
    }
}
