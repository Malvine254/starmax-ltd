<?php

namespace Tests\Feature;

use Tests\TestCase;

class ServerToolsAccessTest extends TestCase
{
    protected function tearDown(): void
    {
        config()->set('services.deployment.tool_token', '');
        parent::tearDown();
    }

    public function test_public_server_tools_page_is_available_without_login(): void
    {
        config()->set('services.deployment.tool_token', '123456789');

        $this->get('/admin/server-tools')
            ->assertOk()
            ->assertSee('Public Deployment Tools')
            ->assertSee('Deployment Token')
            ->assertSee('Token configured in .env')
            ->assertSee('Yes');
    }

    public function test_commands_require_the_configured_token(): void
    {
        config()->set('services.deployment.tool_token', '123456789');

        $this->post('/admin/server-tools/run', [
            'action' => 'clear_cache',
        ])->assertSessionHasErrors('token');

        $this->post('/admin/server-tools/run', [
            'action' => 'clear_cache',
            'token' => 'wrong-key',
        ])->assertSessionHas('error', 'Invalid deployment token.');
    }

    public function test_valid_token_can_run_only_allowlisted_commands(): void
    {
        config()->set('services.deployment.tool_token', '123456789');

        $this->post('/admin/server-tools/run', [
            'action' => 'clear_views',
            'token' => '123456789',
        ])->assertSessionHas('success', 'Clear compiled views completed successfully.');

        $this->post('/admin/server-tools/run', [
            'action' => 'some:arbitrary-command',
            'token' => '123456789',
        ])->assertSessionHas('error', 'Unsupported action requested.');
    }
}
