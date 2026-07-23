<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'ADMIN')->first();
        $adminEmail = env('ADMIN_LOGIN_EMAIL');
        $adminPassword = env('ADMIN_LOGIN_PASSWORD');

        if (! $adminEmail || ! $adminPassword) {
            $this->command?->warn('Admin user was not seeded. Set ADMIN_LOGIN_EMAIL and ADMIN_LOGIN_PASSWORD first.');

            return;
        }

        if (strlen($adminPassword) < 12) {
            throw new \RuntimeException('ADMIN_LOGIN_PASSWORD must contain at least 12 characters.');
        }

        User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'System Admin',
                'first_name' => 'System',
                'last_name' => 'Admin',
                'password' => Hash::make($adminPassword),
                'role_id' => $adminRole?->id,
                'is_active' => true,
            ]
        );
    }
}
