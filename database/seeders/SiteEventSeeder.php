<?php

namespace Database\Seeders;

use App\Models\SiteEvent;
use Illuminate\Database\Seeder;

class SiteEventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'TenantPro Live Walkthrough',
                'slug' => 'tenantpro-live-walkthrough',
                'category' => 'Product Demo',
                'format' => 'Online',
                'location' => 'Online session',
                'starts_at' => '2026-05-14 11:00:00',
                'ends_at' => '2026-05-14 12:00:00',
                'excerpt' => 'See the landlord dashboard and tenant mobile workflow from onboarding through maintenance.',
                'description' => 'A guided product session for landlords and property managers who want to understand how TenantPro handles units, invoices, payments, tenant communication, and support requests.',
                'cta_label' => 'Request Demo Invite',
                'cta_url' => '/contact?service=tenant',
                'is_featured' => true,
                'status' => 'upcoming',
                'sort_order' => 1,
            ],
            [
                'title' => 'AI Automation For Operations',
                'slug' => 'ai-automation-for-operations',
                'category' => 'Workshop',
                'format' => 'In person',
                'location' => 'Nairobi, Kenya',
                'starts_at' => '2026-05-28 14:00:00',
                'ends_at' => '2026-05-28 16:00:00',
                'excerpt' => 'Identify repetitive workflows and turn them into measurable automation wins.',
                'description' => 'A practical workshop for operations teams exploring AI assistants, document workflows, support automation, and internal process optimization.',
                'cta_label' => 'Reserve a Seat',
                'cta_url' => '/contact?service=ai',
                'is_featured' => true,
                'status' => 'upcoming',
                'sort_order' => 2,
            ],
            [
                'title' => 'Modern Web Platform Clinic',
                'slug' => 'modern-web-platform-clinic',
                'category' => 'Clinic',
                'format' => 'Hybrid',
                'location' => 'Hybrid',
                'starts_at' => '2026-06-11 10:00:00',
                'ends_at' => '2026-06-11 12:30:00',
                'excerpt' => 'Bring a product idea or existing platform for architecture, UX, and deployment guidance.',
                'description' => 'A focused review session for founders and technical teams planning web platforms, dashboards, APIs, migrations, or launch-ready product builds.',
                'cta_label' => 'Book Review Slot',
                'cta_url' => '/contact?service=web',
                'is_featured' => false,
                'status' => 'upcoming',
                'sort_order' => 3,
            ],
            [
                'title' => 'Mobile Product Readiness Session',
                'slug' => 'mobile-product-readiness-session',
                'category' => 'Strategy Session',
                'format' => 'Online',
                'location' => 'Online session',
                'starts_at' => '2026-06-25 15:00:00',
                'ends_at' => '2026-06-25 16:30:00',
                'excerpt' => 'Plan a production-ready Android app with the right UX, API, analytics, and release workflow.',
                'description' => 'A session for teams moving from idea to Android build, covering architecture, offline behavior, notifications, analytics, and Play Store launch preparation.',
                'cta_label' => 'Join Session',
                'cta_url' => '/contact?service=android',
                'is_featured' => false,
                'status' => 'upcoming',
                'sort_order' => 4,
            ],
        ];

        foreach ($events as $event) {
            SiteEvent::updateOrCreate(
                ['slug' => $event['slug']],
                $event
            );
        }
    }
}
