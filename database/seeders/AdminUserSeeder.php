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
        $adminEmail = env('ADMIN_LOGIN_EMAIL', 'admin@starmaxltd.com');
        $adminPassword = env('ADMIN_LOGIN_PASSWORD', 'ChangeMe123!');

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
