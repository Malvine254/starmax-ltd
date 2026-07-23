<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SampleLoginSeeder extends Seeder
{
    public function run(): void
    {
        $password = 'DemoAccess2026!';

        $accounts = [
            [
                'role' => 'ADMIN',
                'name' => 'Demo Administrator',
                'first_name' => 'Demo',
                'last_name' => 'Administrator',
                'email' => 'demo.admin@starmaxltd.com',
            ],
            [
                'role' => 'LANDLORD',
                'name' => 'Demo Landlord',
                'first_name' => 'Demo',
                'last_name' => 'Landlord',
                'email' => 'demo.landlord@starmaxltd.com',
            ],
            [
                'role' => 'TENANT',
                'name' => 'Demo Tenant',
                'first_name' => 'Demo',
                'last_name' => 'Tenant',
                'email' => 'demo.tenant@starmaxltd.com',
            ],
            [
                'role' => 'CARETAKER',
                'name' => 'Demo Caretaker',
                'first_name' => 'Demo',
                'last_name' => 'Caretaker',
                'email' => 'demo.caretaker@starmaxltd.com',
            ],
        ];

        foreach ($accounts as $account) {
            $role = Role::where('name', $account['role'])->firstOrFail();

            User::updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'first_name' => $account['first_name'],
                    'last_name' => $account['last_name'],
                    'password' => Hash::make($password),
                    'email_verified_at' => now(),
                    'role_id' => $role->id,
                    'is_active' => true,
                ]
            );
        }

        $this->command?->info('Four sample login accounts were created or updated.');
    }
}
