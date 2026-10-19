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
            '/services/custom-software',
            '/services/e-commerce',
            '/services/cross-platform-mobile',
            '/services/real-estate-technology',
            '/services/api-integration',
            '/services/cloud-maintenance',
            '/services/ui-ux-design',
            '/products',
            '/portfolio',
            '/events',
            '/contact',
        ];

        foreach ($pages as $page) {
            $this->get($page)
                ->assertOk()
                ->assertSee('css/starmax-unified.css', false)
                ->assertDontSee('TenantPro')
                ->assertDontSee('app.starmaxltd.com')
                ->assertSee('tel:+254790925248', false)
                ->assertDontSee('tel:+254700123456', false)
                ->assertDontSee('audiences across East Africa')
                ->assertDontSee('/services/tenant-management', false);
        }
    }
}
