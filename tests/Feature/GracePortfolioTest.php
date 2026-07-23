<?php

namespace Tests\Feature;

use App\Models\GraceSellahPage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GracePortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_saved_dynamic_copy_is_rendered_on_the_public_portfolio(): void
    {
        GraceSellahPage::create([
            'slug' => 'grace-sellah',
            'content' => [
                'labels' => [
                    'services_title' => 'Support shaped around your workflow',
                    'form_submit_label' => 'Start a conversation',
                ],
                'hero' => [
                    'subtitle' => 'A custom portfolio introduction.',
                ],
            ],
        ]);

        $this->get('/grace-sellah')
            ->assertOk()
            ->assertSee('Support shaped around your workflow')
            ->assertSee('Start a conversation')
            ->assertSee('A custom portfolio introduction.');
    }

    public function test_portfolio_uses_safe_defaults_when_no_saved_page_exists(): void
    {
        $this->get('/grace-sellah')
            ->assertOk()
            ->assertSee('Support designed around your day')
            ->assertSee('Tell me what you need');
    }
}
