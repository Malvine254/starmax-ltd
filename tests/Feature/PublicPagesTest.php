<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_every_public_portfolio_page_renders_with_the_shared_theme(): void
    {
        $pages = [
            '/',
            '/about',
            '/services',
            '/services/web-development',
            '/services/android-apps',
            '/services/ai-automation',
            '/services/it-consulting',
            '/services/tenant-management',
            '/services/custom-software',
            '/products',
            '/portfolio',
            '/events',
            '/contact',
        ];

        foreach ($pages as $page) {
            $this->get($page)
                ->assertOk()
                ->assertSee('css/starmax-unified.css', false);
        }
    }
}
