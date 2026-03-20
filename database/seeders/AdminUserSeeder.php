<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Create Role
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // 3. Assign Permissions to Role
        $adminRole->syncPermissions($permissions);

        // 4. Create Admin User
        $user = User::updateOrCreate(
            ['email' => 'admin@tmartf.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admintmf123'),
                'email_verified_at' => now(),
            ]
        );

        // 5. Assign Role to User
        $user->assignRole($adminRole);
    }
}
