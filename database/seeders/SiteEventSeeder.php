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
                'title'       => 'TenantPro Live Walkthrough',
                'slug'        => 'tenantpro-live-walkthrough',
                'category'    => 'Product Demo',
                'format'      => 'Online',
                'location'    => 'Online — Zoom link sent on registration',
                'starts_at'   => '2026-07-09 11:00:00',
                'ends_at'     => '2026-07-09 12:00:00',
                'excerpt'     => 'See the landlord dashboard and tenant mobile workflow from onboarding through maintenance.',
                'description' => 'A guided product session for landlords and property managers who want to understand how TenantPro handles units, invoices, payments, tenant communication, and support requests. Includes live Q&A.',
                'cta_label'   => 'Request Demo Invite',
                'cta_url'     => '/contact?service=tenant',
                'is_featured' => true,
                'status'      => 'upcoming',
                'sort_order'  => 1,
            ],
            [
                'title'       => 'AI Automation For Operations Teams',
                'slug'        => 'ai-automation-for-operations',
                'category'    => 'Workshop',
                'format'      => 'In-Person',
                'location'    => 'Nairobi, Kenya — Venue confirmed on registration',
                'starts_at'   => '2026-07-23 14:00:00',
                'ends_at'     => '2026-07-23 16:30:00',
                'excerpt'     => 'Identify repetitive workflows and turn them into measurable automation wins using AI agents.',
                'description' => 'A practical workshop for operations teams exploring AI assistants, document workflows, support automation, and internal process optimization. Hands-on exercises included. Bring your laptop.',
                'cta_label'   => 'Reserve a Seat',
                'cta_url'     => '/contact?service=ai',
                'is_featured' => true,
                'status'      => 'upcoming',
                'sort_order'  => 2,
            ],
            [
                'title'       => 'Modern Web Platform Clinic',
                'slug'        => 'modern-web-platform-clinic',
                'category'    => 'Clinic',
                'format'      => 'Hybrid',
                'location'    => 'Nairobi + Online — Hybrid session',
                'starts_at'   => '2026-08-12 10:00:00',
                'ends_at'     => '2026-08-12 12:30:00',
                'excerpt'     => 'Bring a product idea or existing platform for architecture, UX, and deployment guidance.',
                'description' => 'A focused review session for founders and technical teams planning web platforms, dashboards, APIs, migrations, or launch-ready product builds. Each attendee gets 20 minutes of dedicated review time.',
                'cta_label'   => 'Book Review Slot',
                'cta_url'     => '/contact?service=web',
                'is_featured' => false,
                'status'      => 'upcoming',
                'sort_order'  => 3,
            ],
            [
                'title'       => 'Android App Readiness Session',
                'slug'        => 'mobile-product-readiness-session',
                'category'    => 'Strategy Session',
                'format'      => 'Online',
                'location'    => 'Online — Zoom link sent on registration',
                'starts_at'   => '2026-08-27 15:00:00',
                'ends_at'     => '2026-08-27 16:30:00',
                'excerpt'     => 'Plan a production-ready Android app with the right architecture, API design, and Play Store release workflow.',
                'description' => 'A session for teams moving from idea to Android build, covering architecture choices, offline behavior, push notifications, analytics, and Play Store launch preparation. Ideal for founders and product managers.',
                'cta_label'   => 'Join Session',
                'cta_url'     => '/contact?service=android',
                'is_featured' => false,
                'status'      => 'upcoming',
                'sort_order'  => 4,
            ],
            [
                'title'       => 'Digital Transformation Strategy Day',
                'slug'        => 'digital-transformation-strategy-day',
                'category'    => 'Workshop',
                'format'      => 'In-Person',
                'location'    => 'Nairobi, Kenya — Venue confirmed on registration',
                'starts_at'   => '2026-09-18 09:00:00',
                'ends_at'     => '2026-09-18 17:00:00',
                'excerpt'     => 'A full-day workshop for leadership teams mapping out their technology modernisation roadmap.',
                'description' => 'A structured full-day session for executives and operations leaders. Morning covers current-state assessment and technology audits. Afternoon covers roadmap design, vendor evaluation, and prioritised action planning. Lunch included.',
                'cta_label'   => 'Register Interest',
                'cta_url'     => '/contact?service=consulting',
                'is_featured' => false,
                'status'      => 'upcoming',
                'sort_order'  => 5,
            ],
            [
                'title'       => 'TenantPro Q4 Feature Preview',
                'slug'        => 'tenantpro-q4-feature-preview',
                'category'    => 'Product Demo',
                'format'      => 'Online',
                'location'    => 'Online — Zoom link sent on registration',
                'starts_at'   => '2026-10-07 11:00:00',
                'ends_at'     => '2026-10-07 12:00:00',
                'excerpt'     => 'Preview the M-Pesa integration, AI support agent, and portfolio analytics module shipping in Q4.',
                'description' => 'Existing TenantPro clients and prospects get an exclusive first look at Q4 features: native M-Pesa STK push payments, the AI tenant support agent, and the new investor-ready portfolio analytics dashboard. Feedback session included.',
                'cta_label'   => 'Request Preview Access',
                'cta_url'     => '/contact?service=tenant',
                'is_featured' => false,
                'status'      => 'upcoming',
                'sort_order'  => 6,
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
