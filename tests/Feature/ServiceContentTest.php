<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ServiceContentTest extends TestCase
{
    use RefreshDatabase;

    private const SERVICES = [
        'web-development' => 'web',
        'e-commerce' => 'e-commerce',
        'android-apps' => 'android',
        'cross-platform-mobile' => 'cross-platform-mobile',
        'real-estate-technology' => 'real-estate-technology',
        'api-integration' => 'api-integration',
        'cloud-maintenance' => 'cloud-maintenance',
        'ui-ux-design' => 'ui-ux-design',
        'ai-automation' => 'ai',
        'it-consulting' => 'consulting',
        'custom-software' => 'custom',
    ];

    public function test_each_service_has_substantive_content_metadata_and_a_working_enquiry_path(): void
    {
        foreach (self::SERVICES as $slug => $enquiry) {
            $response = $this->get('/services/'.$slug)
                ->assertOk()
                ->assertSee('Who this helps')
                ->assertSee('How we approach your project')
                ->assertSee('What you get')
                ->assertSee('name="description"', false)
                ->assertSee('rel="canonical"', false)
                ->assertSee('property="og:title"', false)
                ->assertSee('/contact?service='.$enquiry, false);

            $this->assertSame(1, preg_match_all('/<h1(?:\s[^>]*)?>/i', $response->getContent()));
            $this->assertStringNotContainsString('30-day post-launch support', $response->getContent());
            $contact = $this->get('/contact?service='.$enquiry)->assertOk();
            $this->assertMatchesRegularExpression(
                '/<option\s+value="'.preg_quote($enquiry, '/').'"\s+selected>/',
                $contact->getContent()
            );
        }
    }

    public function test_each_service_can_be_submitted_through_the_existing_contact_flow(): void
    {
        Mail::fake();

        foreach (self::SERVICES as $service) {
            $this->post('/contact', [
                'name' => 'Service Prospect',
                'email' => 'prospect@example.com',
                'service' => $service,
                'message' => 'Please help us scope this service.',
            ])->assertSessionHasNoErrors()->assertSessionHas('success');

            $this->assertDatabaseHas('contact_messages', ['service' => $service]);
        }
    }

    public function test_retired_and_unknown_service_enquiries_are_rejected(): void
    {
        Mail::fake();

        foreach (['tenant', 'not-a-service'] as $service) {
            $this->post('/contact', [
                'name' => 'Service Prospect',
                'email' => 'prospect@example.com',
                'service' => $service,
                'message' => 'Please help us scope this service.',
            ])->assertSessionHasErrors('service');
        }

        $this->assertDatabaseCount('contact_messages', 0);
        Mail::assertNothingSent();
    }

    public function test_product_content_distinguishes_custom_work_and_team_attribution(): void
    {
        $this->get('/products')->assertOk()
            ->assertSee('not off-the-shelf products')
            ->assertSee('not claims that Starmax Ltd was the contracted development company')
            ->assertSee('https://armely.com/', false)
            ->assertSee('https://armely.com/store/products', false)
            ->assertSee('rel="noopener noreferrer"', false)
            ->assertSee('/grace-sellah', false)
            ->assertDontSee('TenantPro');
    }

    public function test_mega_menus_have_disclosure_controls_grouped_links_and_valid_product_anchors(): void
    {
        $response = $this->get('/products')->assertOk();
        $html = $response->getContent();
        $document = new \DOMDocument;
        $document->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
        $xpath = new \DOMXPath($document);

        foreach (['services-menu', 'products-menu'] as $id) {
            $this->assertSame(1, $xpath->query('//button[@aria-controls="'.$id.'" and @aria-expanded="false"]')->length);
            $this->assertSame(3, $xpath->query('//div[@id="'.$id.'"]//div[@class="mega-menu-group"]')->length);
        }

        $this->assertSame(11, $xpath->query('//div[@id="services-menu"]//a[starts-with(@href, "/services/")]')->length);

        foreach ($xpath->query('//div[@id="products-menu"]//a[starts-with(@href, "/products#")]') as $link) {
            $id = parse_url($link->getAttribute('href'), PHP_URL_FRAGMENT);
            $this->assertSame(1, $xpath->query('//*[@id="'.$id.'"]')->length, 'Missing product anchor: '.$id);
        }
    }
}
