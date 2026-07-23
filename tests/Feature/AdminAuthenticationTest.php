<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_sign_in_and_reach_dashboard(): void
    {
        $admin = $this->makeUser('ADMIN');

        $response = $this->post(route('admin.login.post'), [
            'email' => $admin->email,
            'password' => 'correct-password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_non_admin_cannot_sign_in_to_admin_portal(): void
    {
        $user = $this->makeUser('TENANT');

        $response = $this->from(route('login'))->post(route('admin.login.post'), [
            'email' => $user->email,
            'password' => 'correct-password',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_inactive_admin_cannot_sign_in(): void
    {
        $admin = $this->makeUser('ADMIN', false);

        $this->post(route('admin.login.post'), [
            'email' => $admin->email,
            'password' => 'correct-password',
        ]);

        $this->assertGuest();
    }

    public function test_authenticated_non_admin_is_removed_from_admin_area(): void
    {
        $user = $this->makeUser('TENANT');

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_repeated_failed_attempts_are_rate_limited(): void
    {
        $admin = $this->makeUser('ADMIN');

        foreach (range(1, 5) as $attempt) {
            $this->post(route('admin.login.post'), [
                'email' => $admin->email,
                'password' => 'wrong-password',
            ]);
        }

        $response = $this->post(route('admin.login.post'), [
            'email' => $admin->email,
            'password' => 'correct-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    private function makeUser(string $roleName, bool $active = true): User
    {
        $role = Role::create([
            'name' => $roleName,
            'description' => "{$roleName} test role",
        ]);

        return User::factory()->create([
            'password' => Hash::make('correct-password'),
            'role_id' => $role->id,
            'is_active' => $active,
        ]);
    }
}
