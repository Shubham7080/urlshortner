<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class RoleSeeder extends Seeder
{
     public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles.
        foreach (['SuperAdmin', 'Admin', 'Member'] as $roleName) {
            Role::findOrCreate($roleName, 'web');
        }

        // Create the SuperAdmin user.
        $user = User::firstOrCreate(
            ['email' => 'shubham@gmail.com'],
            [
                'name' => 'Shubham',
                'password' => Hash::make('Admin@123'),
                'email_verified_at' => now(),
            ]
        );

        // Assign the SuperAdmin role.
        $user->assignRole('SuperAdmin');

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}