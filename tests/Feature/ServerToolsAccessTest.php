<?php

namespace Tests\Feature;

use Tests\TestCase;

class ServerToolsAccessTest extends TestCase
{
    public function test_public_server_tools_page_is_available_without_login(): void
    {
        $this->get('/server-tools')
            ->assertOk()
            ->assertSee('Laravel server tools')
            ->assertSee('Allowlisted commands')
            ->assertSee('Open bootstrap mode is active')
            ->assertDontSee('Deployment token');
    }

    public function test_arbitrary_commands_are_rejected(): void
    {
        $this->post('/server-tools/run', [
            'action' => 'some:arbitrary-command',
        ])->assertSessionHas('error', 'Unsupported action requested.');
    }
}
