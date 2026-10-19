<?php

namespace App\Http\Controllers;

use App\Mail\ContactAdminNotification;
use App\Mail\ContactUserConfirmation;
use App\Mail\EventRegistrationConfirmation;
use App\Models\ContactMessage;
use App\Models\EventRegistration;
use App\Models\SiteEvent;
use App\Support\SafeMailDelivery;
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
        $current['enquiry'] = match ($service) {
            'web-development' => 'web',
            'android-apps' => 'android',
            'ai-automation' => 'ai',
            'it-consulting' => 'consulting',
            'custom-software' => 'custom',
            default => $service,
        };
        $others = collect($services)->filter(fn($s) => $s['slug'] !== $service)->take(3)->values()->all();
        return view('site.service-detail', compact('current', 'others'));
    }

    private function serviceData(): array
    {
        return [
            'web-development' => [
                'slug' => 'web-development',
                'title' => 'Website Design & Web Development',
                'tagline' => 'Help customers find you, understand your offer, and take the next step.',
                'description' => 'For businesses, professional practices, and growing teams in Nairobi and beyond, we build corporate websites, landing pages, customer portals, and custom web applications. We plan content and user journeys before choosing a CMS or framework, so your website supports enquiries, bookings, and day-to-day administration rather than becoming another tool to maintain.',
                'audience' => 'Businesses launching a website, replacing an outdated site, or moving customer services online.',
                'approach' => 'We agree goals and content, prototype key journeys, build responsive pages and administration tools, then test forms, accessibility, and deployment before handing over editor guidance.',
                'icon' => 'globe',
                'color' => 'purple',
                'gradient' => 'linear-gradient(150deg,#312e81 0%,#1e1b4b 50%,#0f172a 100%)',
                'category' => 'Platform',
                'features' => [
                    ['icon' => 'layout-dashboard', 'title' => 'Business Websites & CMS', 'desc' => 'Corporate pages, service directories, multilingual content, and manageable publishing workflows.'],
                    ['icon' => 'calendar-check', 'title' => 'Enquiries, Bookings & Portals', 'desc' => 'Lead forms, appointment requests, customer accounts, and admin dashboards with clear validation and feedback.'],
                    ['icon' => 'search', 'title' => 'Search & Content Foundations', 'desc' => 'Descriptive URLs, page metadata, structured content, and analytics integration with consent requirements considered. No ranking guarantees.'],
                    ['icon' => 'accessibility', 'title' => 'Accessible Experiences', 'desc' => 'Keyboard navigation, visible focus, labeled controls, and contrast checks guided by WCAG 2.2.'],
                    ['icon' => 'gauge', 'title' => 'Performance That Can Be Measured', 'desc' => 'Image optimization, caching, and Core Web Vitals checks covering loading, interaction responsiveness, and layout stability.'],
                    ['icon' => 'shield', 'title' => 'Launch & Maintenance', 'desc' => 'HTTPS, domain and hosting configuration, tested forms, backups, and a separately agreed maintenance plan.'],
                ],
                'tech' => ['Laravel', 'NestJS', 'Next.js', 'React', 'PostgreSQL', 'Redis', 'Docker', 'Nginx'],
                'deliverables' => [
                    'Fully deployed, production-ready application',
                    'Source code with full documentation',
                    'Admin panel or management dashboard',
                    'API documentation (OpenAPI/Swagger)',
                    'CI/CD pipeline & deployment setup',
                    'Handover and an agreed post-launch support scope',
                ],
            ],
            'e-commerce' => [
                'slug' => 'e-commerce',
                'title' => 'E-Commerce & B2B Store Development',
                'tagline' => 'Make product discovery, purchasing, and quotation requests easier.',
                'description' => 'We scope online stores around how your customers buy. A retail store may need a cart and payment checkout; a B2B procurement site may instead need detailed specifications, quote requests, and approval workflows. We connect the catalog, customer experience, and administration tools without implying that every store needs the same transaction model.',
                'audience' => 'Retailers, distributors, and business suppliers moving product discovery and purchasing online.',
                'approach' => 'We agree the catalog structure and buying journey, prototype search and product pages, integrate the selected payment or quotation workflow, and test order notifications and admin operations.',
                'icon' => 'shopping-cart',
                'color' => 'emerald',
                'gradient' => 'linear-gradient(150deg,#064e3b 0%,#0f172a 100%)',
                'category' => 'Commerce',
                'features' => [
                    ['icon' => 'search', 'title' => 'Catalog & Discovery', 'desc' => 'Categories, filters, product search, image galleries, specifications, and mobile-friendly product pages.'],
                    ['icon' => 'shopping-cart', 'title' => 'Retail Checkout', 'desc' => 'Carts, customer accounts, secure gateway handoff, and clearly defined payment and order states where checkout is required.'],
                    ['icon' => 'file-text', 'title' => 'B2B Quote Workflows', 'desc' => 'Request-for-quotation forms, business requirements, and staff follow-up rather than a misleading buy-now flow.'],
                    ['icon' => 'package', 'title' => 'Order & Inventory Operations', 'desc' => 'Admin tools for stock, orders, status updates, and integrations with your existing operational systems.'],
                    ['icon' => 'mail', 'title' => 'Transactional Notifications', 'desc' => 'Order or enquiry confirmations with delivery monitoring, retries, and understandable customer feedback.'],
                    ['icon' => 'shield-check', 'title' => 'Trust & Usability', 'desc' => 'Accessible forms, clear pricing rules, privacy-aware analytics, and payment-provider verification.'],
                ],
                'tech' => ['Laravel', 'React', 'SQL Databases', 'Payment APIs', 'Email & Webhooks'],
                'deliverables' => ['Agreed retail or quote-led buying journey', 'Catalog and product administration', 'Scoped checkout or quotation workflow', 'Tested notifications and integration handover', 'Editor guidance and support scope'],
            ],
            'android-apps' => [
                'slug' => 'android-apps',
                'title' => 'Android App Development',
                'tagline' => 'Native Kotlin apps with modern architecture and seamless backend integration.',
                'description' => 'We build native Android applications for business operations, field work, inventory, and customer self-service. Kotlin and Jetpack Compose support responsive interfaces, while API integration, local storage, and carefully scoped background work keep core tasks usable on unreliable connections. Device access and data collection are designed around explicit permissions.',
                'audience' => 'Teams that need Android-specific device features, offline workflows, or a focused native experience.',
                'approach' => 'We map user tasks and connectivity needs, prototype screens, build the app and API contracts, test across agreed devices, and prepare signing, privacy disclosures, and release materials.',
                'icon' => 'smartphone',
                'color' => 'blue',
                'gradient' => 'linear-gradient(150deg,#1e3a5f 0%,#0c4a6e 50%,#0f172a 100%)',
                'category' => 'Mobile',
                'features' => [
                    ['icon' => 'layers', 'title' => 'Clean Architecture & MVVM', 'desc' => 'Scalable, testable code structure following Google\'s recommended patterns.'],
                    ['icon' => 'paintbrush', 'title' => 'Adaptive Compose Interfaces', 'desc' => 'Material 3 layouts that adapt to phones, tablets, larger text, and different window sizes.'],
                    ['icon' => 'wifi-off', 'title' => 'Offline Work & Synchronization', 'desc' => 'Room storage, queued changes, retry behavior, and conflict handling defined for the workflows that need them.'],
                    ['icon' => 'bell', 'title' => 'Push Notifications', 'desc' => 'Firebase Cloud Messaging integration with deep linking and notification channels.'],
                    ['icon' => 'camera', 'title' => 'Device & Business Integrations', 'desc' => 'Camera capture, QR scanning, location, file uploads, secure accounts, and payment-provider connections where required.'],
                    ['icon' => 'upload-cloud', 'title' => 'Play Store Publishing', 'desc' => 'End-to-end publishing, signing, release tracks, and store listing optimization.'],
                ],
                'tech' => ['Kotlin', 'Jetpack Compose', 'Material 3', 'Hilt', 'Retrofit', 'Room', 'Firebase', 'Coroutines'],
                'deliverables' => [
                    'Signed APK/AAB ready for Play Store',
                    'Source code with full documentation',
                    'Play Store listing setup & assets',
                    'Push notification integration',
                    'Backend API integration & testing',
                    'Release handover and an agreed maintenance plan',
                ],
            ],
            'cross-platform-mobile' => [
                'slug' => 'cross-platform-mobile',
                'title' => 'Cross-Platform Mobile Development',
                'tagline' => 'Plan a shared mobile experience for Android and iOS.',
                'description' => 'Where shared development suits your product, we can scope mobile applications using React Native and Expo. A common application layer can reduce duplicated interface work, but device capabilities, permissions, accessibility, and store requirements still need platform-specific testing. We assess these trade-offs against native Android before recommending an approach.',
                'audience' => 'Teams exploring an Android and iOS product with a shared feature set and a defined release budget.',
                'approach' => 'We check required native integrations first, prototype critical journeys, agree shared and platform-specific work, then test builds and prepare separate store submissions.',
                'icon' => 'tablet-smartphone',
                'color' => 'blue',
                'gradient' => 'linear-gradient(150deg,#1e3a5f 0%,#0f172a 100%)',
                'category' => 'Mobile',
                'features' => [
                    ['icon' => 'layers', 'title' => 'Shared Application Structure', 'desc' => 'Reusable screens and business logic with platform-specific behavior where it improves usability.'],
                    ['icon' => 'lock', 'title' => 'Accounts & API Connectivity', 'desc' => 'Authentication, profile flows, secure credential storage, and backend integration.'],
                    ['icon' => 'camera', 'title' => 'Device Features', 'desc' => 'Camera, media, and location integrations assessed for library support and permission requirements.'],
                    ['icon' => 'refresh-cw', 'title' => 'Data & Notifications', 'desc' => 'Local persistence, synchronization, and push-notification flows scoped to the product.'],
                    ['icon' => 'accessibility', 'title' => 'Mobile-First Interfaces', 'desc' => 'Accessible controls, clear loading and error states, and layouts tested across agreed screen sizes.'],
                    ['icon' => 'upload-cloud', 'title' => 'Platform Release Support', 'desc' => 'Build configuration, device testing, signing, and submission preparation for each store.'],
                ],
                'tech' => ['React Native', 'Expo', 'TypeScript', 'REST APIs', 'Platform Build Tools'],
                'deliverables' => ['Platform feasibility review', 'Shared app and scoped native integrations', 'Android and iOS test plan', 'Release preparation and handover', 'Agreed maintenance and update plan'],
            ],
            'real-estate-technology' => [
                'slug' => 'real-estate-technology',
                'title' => 'Real Estate Websites & Property Technology',
                'tagline' => 'Turn property information into clear listings, enquiries, and operational workflows.',
                'description' => 'We can develop listing websites and tailored property technology for agencies, developers, and property teams. Public listing and lead-management tools are distinct from private rental operations: either can be scoped independently. This is a custom development service, not an embedded rental application or a ready-to-use product on this website.',
                'audience' => 'Real estate agencies, developers, and property businesses that need better listing administration or custom operational tools.',
                'approach' => 'We define listing fields, search filters, languages, and enquiry routing first. Private portals, rental invoicing, and maintenance workflows are separately scoped with their own permissions and data requirements.',
                'icon' => 'building-2',
                'color' => 'emerald',
                'gradient' => 'linear-gradient(150deg,#064e3b 0%,#0f172a 100%)',
                'category' => 'Industry Solutions',
                'features' => [
                    ['icon' => 'house', 'title' => 'Listing Administration', 'desc' => 'Rental and sale listings with availability, property details, agent profiles, and publishing controls.'],
                    ['icon' => 'search', 'title' => 'Search & Location', 'desc' => 'Filters for location, price, property type, and size, plus map integration where required.'],
                    ['icon' => 'images', 'title' => 'Property Presentation', 'desc' => 'Photo and video galleries, external virtual tours, and downloadable brochures.'],
                    ['icon' => 'calendar-check', 'title' => 'Viewing & Enquiry Workflows', 'desc' => 'Viewing requests, buyer enquiries, and email or WhatsApp contact paths with clear lead ownership.'],
                    ['icon' => 'languages', 'title' => 'Multilingual Content', 'desc' => 'English and French publishing structures with client-approved translations and language navigation.'],
                    ['icon' => 'key-round', 'title' => 'Optional Private Operations', 'desc' => 'Custom owner or tenant portals, rental invoicing, maintenance tracking, and reporting as separately agreed development work.'],
                ],
                'tech' => ['Laravel', 'React', 'SQL Databases', 'Maps APIs', 'CMS & Localization'],
                'deliverables' => ['Property content and search specification', 'Responsive listing website', 'Listing and lead administration', 'Scoped integrations and optional portals', 'Content handover and support plan'],
            ],
            'api-integration' => [
                'slug' => 'api-integration',
                'title' => 'API Development & Systems Integration',
                'tagline' => 'Connect business systems without creating fragile manual workarounds.',
                'description' => 'We design backend services and integrations that move data between websites, mobile apps, payment providers, email services, and internal systems. Reliable integration means more than connecting endpoints: we define ownership, authorization, validation, retries, duplicate handling, and visibility when something fails.',
                'audience' => 'Teams connecting existing tools, building a mobile backend, or replacing repeated exports and data entry.',
                'approach' => 'We review provider documentation and data contracts, prototype high-risk connections in a test environment, implement failure handling, and hand over documentation and operational checks.',
                'icon' => 'plug',
                'color' => 'purple',
                'gradient' => 'linear-gradient(150deg,#312e81 0%,#0f172a 100%)',
                'category' => 'Integration',
                'features' => [
                    ['icon' => 'code-2', 'title' => 'REST APIs & Backends', 'desc' => 'Versioned endpoints, validation, pagination, and documented request and response contracts.'],
                    ['icon' => 'lock', 'title' => 'Authentication & Authorization', 'desc' => 'Service credentials, user permissions, rate limits, and secret management appropriate to the integration.'],
                    ['icon' => 'webhook', 'title' => 'Webhooks & Event Processing', 'desc' => 'Signature verification, duplicate-event handling, queues, retries, and failure visibility.'],
                    ['icon' => 'credit-card', 'title' => 'Payment & Notification Providers', 'desc' => 'Payment status verification, reconciliation workflows, and transactional email integration.'],
                    ['icon' => 'database', 'title' => 'Data Synchronization', 'desc' => 'Validated imports, field mapping, conflict rules, and traceable changes across connected systems.'],
                    ['icon' => 'file-check', 'title' => 'Documentation & Tests', 'desc' => 'API examples, integration tests, operational logs, and a clear recovery process.'],
                ],
                'tech' => ['REST', 'OpenAPI', 'Laravel', 'Webhooks', 'Queues', 'SQL'],
                'deliverables' => ['Integration and data-flow specification', 'Implemented endpoints or connectors', 'Authorization and failure-handling rules', 'Test coverage and API documentation', 'Operational handover'],
            ],
            'cloud-maintenance' => [
                'slug' => 'cloud-maintenance',
                'title' => 'Cloud Deployment, Maintenance & Support',
                'tagline' => 'Keep your application deployable, observable, and maintainable after launch.',
                'description' => 'We help teams prepare hosting, deploy applications, and maintain websites and business systems. The work can include production configuration, DNS and TLS, deployment pipelines, backups, dependency updates, and incident triage. Response times, support hours, recovery objectives, and ongoing costs are agreed in a support contract, not implied by this page.',
                'audience' => 'Organizations launching an application or needing a clear maintenance owner for an existing website.',
                'approach' => 'We assess the current environment, establish backups and a rollback path, test deployment and restoration, then agree monitoring, update cadence, and escalation responsibilities.',
                'icon' => 'cloud',
                'color' => 'orange',
                'gradient' => 'linear-gradient(150deg,#7c2d12 0%,#0f172a 100%)',
                'category' => 'Operations',
                'features' => [
                    ['icon' => 'server', 'title' => 'Hosting & Production Setup', 'desc' => 'Environment configuration, DNS, TLS certificates, access controls, and hosting choices matched to requirements.'],
                    ['icon' => 'git-branch', 'title' => 'Repeatable Deployments', 'desc' => 'CI/CD checks, staging environments, migration planning, and rollback procedures.'],
                    ['icon' => 'database-backup', 'title' => 'Backups & Recovery', 'desc' => 'Application and database backup schedules, retention, and tested restore procedures.'],
                    ['icon' => 'activity', 'title' => 'Monitoring & Triage', 'desc' => 'Availability checks, error reporting, performance monitoring, and an agreed escalation process.'],
                    ['icon' => 'wrench', 'title' => 'Website Care', 'desc' => 'Content updates, bug fixes, compatibility checks, and dependency or security patches within the support scope.'],
                    ['icon' => 'receipt', 'title' => 'Cost & Ownership Clarity', 'desc' => 'Documented provider costs, account ownership, administrator guidance, and explicitly agreed service levels.'],
                ],
                'tech' => ['Linux Hosting', 'CI/CD', 'TLS & DNS', 'Application Logs', 'Backup & Restore'],
                'deliverables' => ['Environment and deployment runbook', 'Backup and restore plan', 'Monitoring and escalation setup', 'Administrator handover', 'Written maintenance scope and service terms'],
            ],
            'ui-ux-design' => [
                'slug' => 'ui-ux-design',
                'title' => 'UI/UX Design & Prototyping',
                'tagline' => 'Make complex tasks easier before investing in the full build.',
                'description' => 'We help teams turn requirements into usable websites, mobile interfaces, and dashboards. Research, content structure, wireframes, and interactive prototypes expose confusing steps early. Accessibility and responsive behavior are part of the design process, with usability checks focused on the tasks customers and staff actually need to complete.',
                'audience' => 'Teams validating a product idea, redesigning a difficult interface, or preparing a development-ready specification.',
                'approach' => 'We review user tasks, map journeys, test low-fidelity wireframes, refine key screens, and document reusable components and interaction states for development.',
                'icon' => 'pen-tool',
                'color' => 'rose',
                'gradient' => 'linear-gradient(150deg,#881337 0%,#0f172a 100%)',
                'category' => 'Design',
                'features' => [
                    ['icon' => 'users', 'title' => 'Discovery & User Journeys', 'desc' => 'Stakeholder requirements, user tasks, content hierarchy, and practical research within the project scope.'],
                    ['icon' => 'layout-template', 'title' => 'Wireframes & Prototypes', 'desc' => 'Clickable flows that validate navigation and key actions before full implementation.'],
                    ['icon' => 'monitor-smartphone', 'title' => 'Responsive Interface Design', 'desc' => 'Website, mobile, and dashboard layouts with appropriate content density at different screen sizes.'],
                    ['icon' => 'component', 'title' => 'Reusable Design Systems', 'desc' => 'Typography, spacing, controls, and loading, empty, error, and success states for consistent delivery.'],
                    ['icon' => 'accessibility', 'title' => 'Accessibility Review', 'desc' => 'Contrast, readable content, target sizes, keyboard behavior, and focus requirements guided by WCAG 2.2.'],
                    ['icon' => 'mouse-pointer-click', 'title' => 'Usability & Handover', 'desc' => 'Task-based testing, prioritized improvements, and annotated designs for the implementation team.'],
                ],
                'tech' => ['Wireframes', 'Interactive Prototypes', 'Design Systems', 'WCAG 2.2', 'Usability Testing'],
                'deliverables' => ['User journeys and content structure', 'Agreed screen designs and prototype', 'Reusable component guidance', 'Accessibility and usability findings', 'Development handover'],
            ],
            'ai-automation' => [
                'slug' => 'ai-automation',
                'title' => 'AI Agents & Automation',
                'tagline' => 'Intelligent agents that automate workflows, analyze data, and assist your team.',
                'description' => 'We help teams assess and build AI assistants for knowledge search, document processing, customer support, and workflow routing. Retrieval-augmented generation (RAG) connects responses to approved information; controlled tools connect an assistant to business systems. We evaluate quality, privacy, cost, and failure cases before expanding automation, with human approval for consequential actions.',
                'audience' => 'Teams with repetitive document or support workflows and an approved source of business information.',
                'approach' => 'We select a narrow use case, agree evaluation examples and access rules, build a pilot, test unsupported answers and unsafe actions, then review monitoring and operating costs before production.',
                'icon' => 'bot',
                'color' => 'teal',
                'gradient' => 'linear-gradient(150deg,#134e4a 0%,#0f766e 40%,#0f172a 100%)',
                'category' => 'Intelligence',
                'features' => [
                    ['icon' => 'search', 'title' => 'Knowledge Assistants & RAG', 'desc' => 'Search approved documents with source references, access-aware retrieval, and a clear response when evidence is missing.'],
                    ['icon' => 'workflow', 'title' => 'Controlled Agent Workflows', 'desc' => 'Task extraction and routing with restricted tools, human approvals, and activity logs rather than unrestricted autonomy.'],
                    ['icon' => 'file-text', 'title' => 'Document Processing', 'desc' => 'Extract and classify information from files, validate required fields, and route uncertain results for review.'],
                    ['icon' => 'message-circle', 'title' => 'Customer Support Assistance', 'desc' => 'Draft replies grounded in your knowledge base, with escalation and a clear distinction between AI and human support.'],
                    ['icon' => 'shield-check', 'title' => 'Privacy & Safety Controls', 'desc' => 'Data minimization, permissions, retention decisions, and tests for prompt injection and unintended tool use.'],
                    ['icon' => 'chart-no-axes-combined', 'title' => 'Evaluation & Observability', 'desc' => 'Representative evaluation sets, trace review, latency and cost tracking, and regression checks as prompts or models change.'],
                ],
                'tech' => ['Model APIs', 'Python', 'FastAPI', 'Retrieval & Vector Search', 'PostgreSQL', 'Evaluation & Tracing'],
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
                'description' => 'We help business owners and technical teams decide what to build, buy, integrate, or modernize. Architecture reviews, vendor comparisons, and phased roadmaps connect technology choices to budget, operational risk, and the skills available to run the system. We favor maintainable solutions over unnecessary complexity.',
                'audience' => 'Organizations planning a new platform, replacing legacy systems, or seeking an independent technical review.',
                'approach' => 'We review your current workflows and systems, document constraints, compare realistic options, and prioritize a roadmap with dependencies and decision points.',
                'icon' => 'briefcase',
                'color' => 'orange',
                'gradient' => 'linear-gradient(150deg,#7c2d12 0%,#c2410c 40%,#0f172a 100%)',
                'category' => 'Strategy',
                'features' => [
                    ['icon' => 'network', 'title' => 'Architecture Design', 'desc' => 'System design, microservices, monolith-to-distributed, and scalable architecture reviews.'],
                    ['icon' => 'cloud', 'title' => 'Cloud Strategy', 'desc' => 'Cloud migration planning, cost optimization, and multi-cloud provider evaluation.'],
                    ['icon' => 'shield-check', 'title' => 'Risk & Data Governance', 'desc' => 'Identify access, data-handling, and continuity requirements, with specialist assessments scoped separately when needed.'],
                    ['icon' => 'map', 'title' => 'Digital Transformation Roadmaps', 'desc' => 'Phased, realistic plans for modernizing legacy systems and business processes.'],
                    ['icon' => 'users', 'title' => 'Team Augmentation', 'desc' => 'Senior engineers embedded in your team for knowledge transfer and mentoring.'],
                    ['icon' => 'bar-chart', 'title' => 'Technology Stack Evaluation', 'desc' => 'Unbiased assessment of tools, frameworks, and vendors for your specific context.'],
                ],
                'tech' => ['Architecture Design', 'Cloud Platforms', 'Security Frameworks', 'Agile / Scrum', 'DevOps / CI-CD', 'System Design'],
                'deliverables' => [
                    'Written architecture or strategy report',
                    'Technology evaluation matrix',
                    'Documented risks and implementation recommendations',
                    'Digital transformation roadmap',
                    'Team workshops & knowledge transfer sessions',
                    'Follow-up implementation guidance',
                ],
            ],
            'custom-software' => [
                'slug' => 'custom-software',
                'title' => 'Custom Business Software',
                'tagline' => 'Bespoke solutions when off-the-shelf doesn\'t fit your workflows.',
                'description' => 'We develop internal business applications when spreadsheets and disconnected tools create duplicate work or limited visibility. CRM, inventory, scheduling, document management, HR workflows, and ERP integrations can be scoped around your actual processes. Permissions, audit history, and useful reporting help teams operate confidently as the system grows.',
                'audience' => 'Businesses that need a shared source of operational information and workflows their existing tools cannot support.',
                'approach' => 'We map the current process, agree data ownership and roles, deliver a small working release, validate migrations and integrations, then expand in prioritized stages.',
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
                    ['icon' => 'workflow', 'title' => 'Approvals, Roles & Audit History', 'desc' => 'Document workflows, role-based access, approval steps, and traceable business activity alongside validated data imports.'],
                ],
                'tech' => ['Laravel', 'NestJS', 'React', 'Next.js', 'PostgreSQL', 'MySQL', 'Redis', 'Docker'],
                'deliverables' => [
                    'Fully custom, branded application',
                    'Third-party API integrations',
                    'Admin panel & user management',
                    'Reporting & analytics module',
                    'User training & full documentation',
                    'Handover and support terms agreed before launch',
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

        $registration = EventRegistration::create($data);

        $eventUrl = filled($event->event_url)
            ? $event->event_url
            : route('events.index', ['event' => $event->slug]) . '#schedule';

        $emailSent = SafeMailDelivery::attempt(
            fn () => Mail::to($registration->email)
                ->send(new EventRegistrationConfirmation($registration, $eventUrl)),
            [
                'flow' => 'event-registration-confirmation',
                'registration_id' => $registration->id,
                'event_id' => $event->id,
            ],
        );

        return redirect()
            ->route('events.index', ['event' => $event->slug])
            ->with(
                $emailSent ? 'success' : 'warning',
                $emailSent
                    ? 'Registration received. We sent a confirmation email with your event URL.'
                    : 'Registration received. Your place is saved, but the confirmation email is temporarily delayed.'
            );
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
            'service' => 'nullable|string|in:web,android,ai,consulting,custom,e-commerce,cross-platform-mobile,real-estate-technology,api-integration,cloud-maintenance,ui-ux-design,other',
            'message' => 'required|string|max:3000',
        ]);

        $contactMessage = ContactMessage::create([
            ...$request->only(['name', 'email', 'service', 'message']),
            'source' => 'starmax-website',
        ]);

        $emailSent = SafeMailDelivery::attempt(function () use ($contactMessage): void {
            Mail::to(config('app.contact_admin_email'))
                ->send(new ContactAdminNotification($contactMessage));
            Mail::to($contactMessage->email)
                ->send(new ContactUserConfirmation($contactMessage));
        }, [
            'flow' => 'site-contact',
            'contact_message_id' => $contactMessage->id,
        ]);

        return back()->with(
            $emailSent ? 'success' : 'warning',
            $emailSent
                ? 'Thank you! Your message has been received.'
                : 'Thank you! Your message was saved. Email delivery is temporarily delayed.'
        );
    }

}
