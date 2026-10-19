<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SiteScopeTest extends TestCase
{
    use RefreshDatabase;

    public function test_retired_application_endpoints_are_not_available(): void
    {
        foreach (['auth/register', 'auth/login', 'auth/me', 'auth/logout', 'properties', 'units', 'tenants', 'invoices', 'payments', 'maintenance', 'invitations', 'support/conversations', 'support/messages', 'notifications'] as $path) {
            $this->getJson('/api/'.$path)->assertNotFound();
            $this->postJson('/api/'.$path, [])->assertNotFound();
        }

        foreach (['/dashboard', '/admin/properties', '/admin/tenants', '/admin/invoices', '/admin/maintenance', '/services/tenant-management'] as $path) {
            $this->get($path)->assertNotFound();
        }

        foreach (Route::getRoutes() as $route) {
            $this->assertFalse(str_starts_with($route->uri(), 'api/'));
        }
    }

    public function test_admin_only_seeding_preserves_historical_schema_and_existing_roles(): void
    {
        $legacyRole = Role::create(['name' => 'TENANT', 'description' => 'Legacy role']);

        $this->seed(RoleSeeder::class);

        $this->assertDatabaseHas('roles', ['name' => 'ADMIN']);
        $this->assertDatabaseHas('roles', ['id' => $legacyRole->id]);
        $this->assertDatabaseMissing('roles', ['name' => 'LANDLORD']);
        $this->assertDatabaseMissing('roles', ['name' => 'CARETAKER']);
        $this->assertTrue(Schema::hasTable('properties'));
        $this->assertTrue(Schema::hasTable('tenants'));
    }

    public function test_retained_admin_pages_render_for_an_admin(): void
    {
        $this->seed(RoleSeeder::class);
        $admin = User::factory()->create([
            'role_id' => Role::where('name', 'ADMIN')->firstOrFail()->id,
            'is_active' => true,
        ]);

        foreach (['/admin/dashboard', '/admin/contact-messages', '/admin/events', '/admin/event-registrations', '/grace-sellah/admin/page'] as $path) {
            $this->actingAs($admin)->get($path)->assertOk();
        }
    }
}
