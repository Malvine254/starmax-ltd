<?php

namespace App\Http\Controllers;

use App\Mail\ContactAdminNotification;
use App\Mail\ContactUserConfirmation;
use App\Models\ContactMessage;
use App\Models\EventRegistration;
use App\Models\SiteEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SiteController extends Controller
{
    public function home()
    {
        return view('site.home');
    }

    public function about()
    {
        return view('site.about');
    }

    public function services()
    {
        $services = collect($this->serviceData())
            ->values()
            ->map(function (array $service): array {
                return [
                    'slug' => $service['slug'],
                    'title' => $service['title'],
                    'tagline' => $service['tagline'],
                    'description' => $service['description'],
                    'icon' => $service['icon'],
                    'color' => $service['color'],
                    'category' => $service['category'],
                    'badge' => $service['badge'] ?? null,
                    'features' => collect($service['features'])->pluck('title')->take(3)->values()->all(),
                    'tech' => collect($service['tech'])->take(4)->values()->all(),
                ];
            });

        $serviceStats = [
            'total' => $services->count(),
            'categories' => $services->pluck('category')->unique()->count(),
            'stacks' => $services->flatMap(fn(array $service) => $service['tech'])->unique()->count(),
        ];

        return view('site.services', compact('services', 'serviceStats'));
    }

    public function serviceDetail(string $service)
    {
        $services = $this->serviceData();
        if (!isset($services[$service])) {
            abort(404);
        }
        $current = $services[$service];
        $others = collect($services)->filter(fn($s) => $s['slug'] !== $service)->take(3)->values()->all();
        return view('site.service-detail', compact('current', 'others'));
    }

    private function serviceData(): array
    {
        return [
            'web-development' => [
                'slug' => 'web-development',
                'title' => 'Web Application Development',
                'tagline' => 'Full-stack web platforms built for performance, security, and scale.',
                'description' => 'We build responsive, performant, and secure web applications using modern frameworks. Whether you need an internal tool, a public platform, or a real-time dashboard — we handle the full stack from database to deployment.',
                'icon' => 'globe',
                'color' => 'purple',
                'gradient' => 'linear-gradient(150deg,#312e81 0%,#1e1b4b 50%,#0f172a 100%)',
                'category' => 'Platform',
                'features' => [
                    ['icon' => 'layout-dashboard', 'title' => 'Admin Panels & Internal Tools', 'desc' => 'Custom dashboards, CMS, and back-office systems tailored to your exact workflows.'],
                    ['icon' => 'zap', 'title' => 'Real-time Features', 'desc' => 'WebSocket integrations, live notifications, and real-time data streaming.'],
                    ['icon' => 'shield', 'title' => 'Secure by Default', 'desc' => 'Authentication, RBAC, input validation, and OWASP-compliant security practices.'],
                    ['icon' => 'git-branch', 'title' => 'CI/CD & Cloud Deployment', 'desc' => 'Automated pipelines, Docker containerization, and scalable cloud deployments.'],
                    ['icon' => 'bar-chart-2', 'title' => 'Performance Optimization', 'desc' => 'Caching strategies, query optimization, CDN integration, and load testing.'],
                    ['icon' => 'code-2', 'title' => 'REST & GraphQL APIs', 'desc' => 'Well-documented, versioned APIs designed for frontend and third-party integration.'],
                ],
                'tech' => ['Laravel', 'NestJS', 'Next.js', 'React', 'PostgreSQL', 'Redis', 'Docker', 'Nginx'],
                'deliverables' => [
                    'Fully deployed, production-ready application',
                    'Source code with full documentation',
                    'Admin panel or management dashboard',
                    'API documentation (OpenAPI/Swagger)',
                    'CI/CD pipeline & deployment setup',
                    '30-day post-launch support',
                ],
            ],
            'android-apps' => [
                'slug' => 'android-apps',
                'title' => 'Android App Development',
                'tagline' => 'Native Kotlin apps with modern architecture and seamless backend integration.',
                'description' => 'We build native Android applications that feel smooth, work offline, and integrate deeply with your backend systems. Our apps follow Clean Architecture patterns and use the latest Jetpack libraries.',
                'icon' => 'smartphone',
                'color' => 'blue',
                'gradient' => 'linear-gradient(150deg,#1e3a5f 0%,#0c4a6e 50%,#0f172a 100%)',
                'category' => 'Mobile',
                'features' => [
                    ['icon' => 'layers', 'title' => 'Clean Architecture & MVVM', 'desc' => 'Scalable, testable code structure following Google\'s recommended patterns.'],
                    ['icon' => 'paintbrush', 'title' => 'Jetpack Compose UI', 'desc' => 'Modern declarative UI with Material 3 design system for beautiful, consistent interfaces.'],
                    ['icon' => 'wifi-off', 'title' => 'Offline-First Design', 'desc' => 'Room database, sync strategies, and seamless offline experience for all users.'],
                    ['icon' => 'bell', 'title' => 'Push Notifications', 'desc' => 'Firebase Cloud Messaging integration with deep linking and notification channels.'],
                    ['icon' => 'cpu', 'title' => 'Dependency Injection', 'desc' => 'Hilt-powered DI for clean, modular, and testable application architecture.'],
                    ['icon' => 'upload-cloud', 'title' => 'Play Store Publishing', 'desc' => 'End-to-end publishing, signing, release tracks, and store listing optimization.'],
                ],
                'tech' => ['Kotlin', 'Jetpack Compose', 'Material 3', 'Hilt', 'Retrofit', 'Room', 'Firebase', 'Coroutines'],
                'deliverables' => [
                    'Signed APK/AAB ready for Play Store',
                    'Source code with full documentation',
                    'Play Store listing setup & assets',
                    'Push notification integration',
                    'Backend API integration & testing',
                    '30-day post-launch support',
                ],
            ],
            'ai-automation' => [
                'slug' => 'ai-automation',
                'title' => 'AI Agents & Automation',
                'tagline' => 'Intelligent agents that automate workflows, analyze data, and assist your team.',
                'description' => 'We build practical AI that solves real business problems — not demos. From document processing to customer support bots, our agents integrate with your existing systems and deliver measurable ROI.',
                'icon' => 'bot',
                'color' => 'teal',
                'gradient' => 'linear-gradient(150deg,#134e4a 0%,#0f766e 40%,#0f172a 100%)',
                'category' => 'Intelligence',
                'features' => [
                    ['icon' => 'brain', 'title' => 'Custom LLM Integrations', 'desc' => 'GPT-4, Claude, Gemini — integrated with your data, systems, and workflows.'],
                    ['icon' => 'workflow', 'title' => 'Multi-step Agent Workflows', 'desc' => 'Tool-using agents that reason, plan, and execute complex multi-step tasks autonomously.'],
                    ['icon' => 'file-text', 'title' => 'Document Processing', 'desc' => 'Extraction, classification, and summarization from PDFs, emails, contracts, and more.'],
                    ['icon' => 'message-circle', 'title' => 'Domain-Specific Chatbots', 'desc' => 'Customer support and internal knowledge assistants trained on your proprietary data.'],
                    ['icon' => 'database', 'title' => 'RAG Pipelines', 'desc' => 'Retrieval-Augmented Generation for accurate, cited AI responses from your knowledge base.'],
                    ['icon' => 'trending-up', 'title' => 'Analytics & Reporting', 'desc' => 'AI-powered business insights, anomaly detection, and automated report generation.'],
                ],
                'tech' => ['OpenAI GPT-4', 'Claude (Anthropic)', 'Python', 'LangChain', 'FastAPI', 'Pinecone', 'PostgreSQL', 'Redis'],
                'deliverables' => [
                    'Production-ready AI agent or pipeline',
                    'Integration with your existing systems',
                    'Knowledge base & vector store setup',
                    'Monitoring & evaluation framework',
                    'Documentation & training guide',
                    'Ongoing model maintenance support',
                ],
            ],
            'it-consulting' => [
                'slug' => 'it-consulting',
                'title' => 'IT Consulting & Strategy',
                'tagline' => 'Strategic guidance for technology decisions and digital transformation.',
                'description' => 'We help teams choose the right architecture, evaluate vendors, and build roadmaps for digital transformation. Our consultants bring hands-on engineering experience to every recommendation.',
                'icon' => 'briefcase',
                'color' => 'orange',
                'gradient' => 'linear-gradient(150deg,#7c2d12 0%,#c2410c 40%,#0f172a 100%)',
                'category' => 'Strategy',
                'features' => [
                    ['icon' => 'network', 'title' => 'Architecture Design', 'desc' => 'System design, microservices, monolith-to-distributed, and scalable architecture reviews.'],
                    ['icon' => 'cloud', 'title' => 'Cloud Strategy', 'desc' => 'Cloud migration planning, cost optimization, and multi-cloud provider evaluation.'],
                    ['icon' => 'shield-check', 'title' => 'Security Audits', 'desc' => 'Vulnerability assessments, penetration testing guidance, and compliance reviews.'],
                    ['icon' => 'map', 'title' => 'Digital Transformation Roadmaps', 'desc' => 'Phased, realistic plans for modernizing legacy systems and business processes.'],
                    ['icon' => 'users', 'title' => 'Team Augmentation', 'desc' => 'Senior engineers embedded in your team for knowledge transfer and mentoring.'],
                    ['icon' => 'bar-chart', 'title' => 'Technology Stack Evaluation', 'desc' => 'Unbiased assessment of tools, frameworks, and vendors for your specific context.'],
                ],
                'tech' => ['Architecture Design', 'Cloud Platforms', 'Security Frameworks', 'Agile / Scrum', 'DevOps / CI-CD', 'System Design'],
                'deliverables' => [
                    'Written architecture or strategy report',
                    'Technology evaluation matrix',
                    'Security audit findings & recommendations',
                    'Digital transformation roadmap',
                    'Team workshops & knowledge transfer sessions',
                    'Follow-up implementation guidance',
                ],
            ],
            'tenant-management' => [
                'slug' => 'tenant-management',
                'title' => 'Tenant & Property Management',
                'tagline' => 'Complete operational platform for landlords, property managers, and tenants.',
                'description' => 'Our flagship domain. We\'ve built a production-grade platform covering billing, maintenance, tenant communication, and portfolio analytics — with a web dashboard and native Android app.',
                'icon' => 'building-2',
                'color' => 'emerald',
                'gradient' => 'linear-gradient(150deg,#064e3b 0%,#065f46 40%,#0f172a 100%)',
                'category' => 'Flagship',
                'badge' => 'Our Flagship Product',
                'features' => [
                    ['icon' => 'home', 'title' => 'Property & Unit Lifecycle', 'desc' => 'Manage properties, units, occupancy, and lease agreements from a single dashboard.'],
                    ['icon' => 'receipt', 'title' => 'Automated Invoicing', 'desc' => 'Recurring rent invoices, payment tracking, overdue alerts, and receipt generation.'],
                    ['icon' => 'wrench', 'title' => 'Maintenance Workflows', 'desc' => 'Request submission, technician assignment, SLA tracking, and resolution reporting.'],
                    ['icon' => 'user-plus', 'title' => 'Tenant Self-Service Portal', 'desc' => 'Tenant onboarding via invitation, profile management, and document access.'],
                    ['icon' => 'pie-chart', 'title' => 'Portfolio Analytics', 'desc' => 'Revenue trends, occupancy rates, maintenance cost insights, and exportable reports.'],
                    ['icon' => 'smartphone', 'title' => 'Native Android App', 'desc' => 'Full-featured mobile app for tenants to pay rent, log requests, and message management.'],
                ],
                'tech' => ['NestJS', 'Next.js', 'Kotlin', 'Jetpack Compose', 'PostgreSQL', 'Prisma', 'Firebase', 'Docker'],
                'deliverables' => [
                    'Custom-branded web portal for your business',
                    'Native Android app for your tenants',
                    'Automated billing & payment tracking system',
                    'Maintenance request workflow',
                    'Analytics & reporting dashboard',
                    'Training, onboarding & ongoing support',
                ],
            ],
            'custom-software' => [
                'slug' => 'custom-software',
                'title' => 'Custom Business Software',
                'tagline' => 'Bespoke solutions when off-the-shelf doesn\'t fit your workflows.',
                'description' => 'We build systems tailored to your exact workflows — from inventory management to booking engines. If existing tools don\'t cover your use case, we design and build a custom solution that does.',
                'icon' => 'zap',
                'color' => 'rose',
                'gradient' => 'linear-gradient(150deg,#881337 0%,#be123c 40%,#0f172a 100%)',
                'category' => 'Bespoke',
                'features' => [
                    ['icon' => 'users-round', 'title' => 'CRM & Customer Management', 'desc' => 'Customer lifecycle tracking, sales pipelines, and full communication history.'],
                    ['icon' => 'calendar-check', 'title' => 'Booking & Scheduling', 'desc' => 'Appointment systems, resource booking, availability management, and calendar integrations.'],
                    ['icon' => 'package', 'title' => 'Inventory & Logistics', 'desc' => 'Stock tracking, supplier management, purchase orders, and fulfillment workflows.'],
                    ['icon' => 'plug', 'title' => 'Third-party Integrations', 'desc' => 'Payment gateways, shipping APIs, accounting tools, ERP systems, and more.'],
                    ['icon' => 'table-2', 'title' => 'Reporting Dashboards', 'desc' => 'Custom analytics views, KPI tracking, and exportable business intelligence reports.'],
                    ['icon' => 'workflow', 'title' => 'Data Pipelines', 'desc' => 'ETL pipelines, data transformation, aggregation, and automated reporting flows.'],
                ],
                'tech' => ['Laravel', 'NestJS', 'React', 'Next.js', 'PostgreSQL', 'MySQL', 'Redis', 'Docker'],
                'deliverables' => [
                    'Fully custom, branded application',
                    'Third-party API integrations',
                    'Admin panel & user management',
                    'Reporting & analytics module',
                    'User training & full documentation',
                    '90-day post-launch support',
                ],
            ],
        ];
    }

    public function products()
    {
        return view('site.products');
    }

    public function portfolio()
    {
        return view('site.portfolio');
    }

    public function events()
    {
        $events = SiteEvent::where('status', 'upcoming')
            ->orderBy('starts_at')
            ->orderBy('sort_order')
            ->get();

        $selectedEvent = $events->firstWhere('slug', request('event'));

        $featuredEvents = $events->where('is_featured', true)->take(2);

        $categories = $events->pluck('category')->filter()->unique()->values();

        $eventStats = [
            'upcoming'   => $events->count(),
            'formats'    => $events->pluck('format')->filter()->unique()->count(),
            'next_month' => optional($events->first()?->starts_at)->format('M Y') ?? 'Soon',
        ];

        return view('site.events', compact('events', 'featuredEvents', 'eventStats', 'categories', 'selectedEvent'));
    }

    public function registerEvent(Request $request, SiteEvent $event)
    {
        if ($event->status !== 'upcoming') {
            return redirect()->route('events.index')->with('error', 'This event is not open for registration.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:40',
            'company' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:2000',
        ]);

        $data['site_event_id'] = $event->id;

        EventRegistration::create($data);

        return redirect()
            ->route('events.index', ['event' => $event->slug])
            ->with('success', 'Registration received. We will contact you with event details shortly.');
    }

    public function contact()
    {
        return view('site.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'service' => 'nullable|string|in:web,android,ai,consulting,tenant,custom,other',
            'message' => 'required|string|max:3000',
        ]);

        $contactMessage = ContactMessage::create($request->only([
            'name',
            'email',
            'service',
            'message',
        ]));

        Mail::to(config('app.contact_admin_email'))
            ->send(new ContactAdminNotification($contactMessage));

        Mail::to($contactMessage->email)
            ->send(new ContactUserConfirmation($contactMessage));

        return back()->with('success', 'Thank you! Your message has been received.');
    }

    public function dashboard()
    {
        return redirect()->route('admin.login');
    }
}
