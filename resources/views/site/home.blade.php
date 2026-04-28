@extends('site.layout')

@section('content')
<!-- Hero -->
<div class="hero-section landing-hero">
    <div class="hero-content hero-slider landing-hero-slider js-hero-slider" data-autoplay="true" data-interval="6200">
        <div class="hero-slider-track">
            <div class="hero-slide landing-slide">
                <img src="{{ asset('images/landing-hero-team.png') }}" alt="Starmax software team planning a digital platform" class="landing-slide-image">
                <div class="landing-slide-shade"></div>
                <div class="landing-slide-copy">
                    <p class="eyebrow">Digital Product Partner</p>
                    <h2>Build the software your business has been waiting for.</h2>
                    <p>Starmax designs and ships modern web platforms, Android apps, AI workflows, and property operations tools for teams that need reliable software in production.</p>
                    <div class="stack">
                        <a href="/contact" class="btn btn-primary">Start a Project</a>
                        <a href="/portfolio" class="btn btn-secondary">View Work</a>
                    </div>
                </div>
            </div>

            <div class="hero-slide landing-slide">
                <img src="{{ asset('images/landing-web-platform.png') }}" alt="Modern dashboard and web platform product mockup" class="landing-slide-image">
                <div class="landing-slide-shade"></div>
                <div class="landing-slide-copy">
                    <p class="eyebrow">Web Platforms</p>
                    <h2>Dashboards, portals, and APIs built to scale cleanly.</h2>
                    <p>From admin consoles to customer-facing SaaS, we create secure platforms with polished UX, clear data flows, and maintainable architecture.</p>
                    <div class="stack">
                        <a href="/services#web" class="btn btn-primary">Explore Web Services</a>
                        <a href="/products" class="btn btn-secondary">See Products</a>
                    </div>
                </div>
            </div>

            <div class="hero-slide landing-slide">
                <img src="{{ asset('images/landing-mobile-ai.png') }}" alt="Mobile app and AI automation product scene" class="landing-slide-image">
                <div class="landing-slide-shade"></div>
                <div class="landing-slide-copy">
                    <p class="eyebrow">Mobile + AI</p>
                    <h2>Mobile-first systems with automation where it matters.</h2>
                    <p>We combine native Android experiences with practical AI agents that reduce repetitive work, speed up support, and keep operations moving.</p>
                    <div class="stack">
                        <a href="/services#android" class="btn btn-primary">Plan Mobile App</a>
                        <a href="/services#ai" class="btn btn-secondary">Explore AI</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-slider-controls">
            <div class="hero-slider-nav">
                <button type="button" class="hero-slider-btn js-hero-prev" aria-label="Previous hero slide"><i data-lucide="arrow-left"></i></button>
                <button type="button" class="hero-slider-btn js-hero-next" aria-label="Next hero slide"><i data-lucide="arrow-right"></i></button>
            </div>
            <div class="hero-slider-dots">
                <button type="button" class="hero-slider-dot active" aria-label="Go to hero slide 1"></button>
                <button type="button" class="hero-slider-dot" aria-label="Go to hero slide 2"></button>
                <button type="button" class="hero-slider-dot" aria-label="Go to hero slide 3"></button>
            </div>
        </div>
    </div>

    <div class="hero-stats landing-stats">
        <div class="hero-stat reveal">
            <p class="kpi">50+</p>
            <p class="kpi-label">Projects delivered across web, mobile, and AI</p>
        </div>
        <div class="hero-stat reveal">
            <p class="kpi">6</p>
            <p class="kpi-label">Core service verticals for product and operations teams</p>
        </div>
        <div class="hero-stat reveal">
            <p class="kpi">24/7</p>
            <p class="kpi-label">Launch support, monitoring, and improvement cycles</p>
        </div>
    </div>
</div>

<!-- Featured Solutions -->
<div class="section landing-section">
    <div class="section-header">
        <p class="eyebrow">Featured Solutions</p>
        <h2>One team for strategy, build, launch, and support.</h2>
        <p>We pair sharp product thinking with practical engineering so every build has a clear path from idea to daily use.</p>
    </div>

    <div class="modern-slider landing-solution-slider js-modern-slider reveal" data-autoplay="true" data-interval="5200">
        <div class="modern-slider-track">
            <article class="modern-slide">
                <div class="modern-slide-content">
                    <span class="tag">Web Platforms</span>
                    <h3>Operational dashboards that make work easier to run.</h3>
                    <p>Custom Laravel, Next.js, and NestJS platforms for internal teams, customers, and business workflows.</p>
                    <ul class="list">
                        <li>Admin portals, CRMs, and SaaS products</li>
                        <li>Secure API-first architecture</li>
                        <li>Analytics, roles, notifications, and audit trails</li>
                    </ul>
                    <div class="stack"><a href="/services#web" class="btn btn-primary">See Web Services</a></div>
                </div>
                <div class="modern-slide-media">
                    <img src="{{ asset('images/landing-web-platform.png') }}" alt="Dashboard product mockup" class="modern-slide-image">
                    <div class="modern-slide-overlay">
                        <p class="media-kpi">99.9%</p>
                        <p class="media-label">Uptime-minded platform architecture</p>
                    </div>
                </div>
            </article>

            <article class="modern-slide">
                <div class="modern-slide-content">
                    <span class="tag">Android Apps</span>
                    <h3>Native mobile apps people can rely on every day.</h3>
                    <p>We build Kotlin apps with clean architecture, smooth UX, and backend integrations that hold up in real use.</p>
                    <ul class="list">
                        <li>Tenant self-service and field operations apps</li>
                        <li>Offline-first flows and push notifications</li>
                        <li>Material 3 interfaces with analytics built in</li>
                    </ul>
                    <div class="stack"><a href="/services#android" class="btn btn-primary">See Mobile Services</a></div>
                </div>
                <div class="modern-slide-media">
                    <img src="{{ asset('images/landing-mobile-ai.png') }}" alt="Mobile app product mockup" class="modern-slide-image">
                    <div class="modern-slide-overlay">
                        <p class="media-kpi">4.8</p>
                        <p class="media-label">Target quality for app experience and usability</p>
                    </div>
                </div>
            </article>

            <article class="modern-slide">
                <div class="modern-slide-content">
                    <span class="tag">AI Automation</span>
                    <h3>Useful AI workflows, not gimmicks.</h3>
                    <p>We design assistants and automations that handle repetitive tasks, route work, and support teams with traceable outputs.</p>
                    <ul class="list">
                        <li>Support assistants and knowledge chat</li>
                        <li>Document extraction and workflow routing</li>
                        <li>RAG pipelines, agent tools, and review loops</li>
                    </ul>
                    <div class="stack"><a href="/services#ai" class="btn btn-primary">See AI Services</a></div>
                </div>
                <div class="modern-slide-media">
                    <img src="{{ asset('images/landing-hero-team.png') }}" alt="Team planning AI automation workflow" class="modern-slide-image">
                    <div class="modern-slide-overlay">
                        <p class="media-kpi">60%</p>
                        <p class="media-label">Potential reduction in repetitive operations work</p>
                    </div>
                </div>
            </article>
        </div>

        <div class="modern-slider-controls">
            <div class="modern-slider-nav">
                <button type="button" class="modern-slider-btn js-slider-prev" aria-label="Previous slide"><i data-lucide="arrow-left"></i></button>
                <button type="button" class="modern-slider-btn js-slider-next" aria-label="Next slide"><i data-lucide="arrow-right"></i></button>
            </div>
            <div class="modern-slider-dots">
                <button type="button" class="modern-slider-dot active" aria-label="Go to slide 1"></button>
                <button type="button" class="modern-slider-dot" aria-label="Go to slide 2"></button>
                <button type="button" class="modern-slider-dot" aria-label="Go to slide 3"></button>
            </div>
        </div>
    </div>
</div>

<!-- Services Preview -->
<div class="section">
    <div class="section-header">
        <p class="eyebrow">Capabilities</p>
        <h2>Everything needed to ship modern digital products.</h2>
        <p>Choose a single service or bring us in for the full lifecycle from discovery to long-term support.</p>
    </div>
    <div class="grid grid-3">
        <a href="/services#web" class="service-preview-card reveal">
            <div class="service-preview-top">
                <div class="card-icon purple"><i data-lucide="globe"></i></div>
                <h3>Web Development</h3>
                <p>Responsive platforms, dashboards, APIs, and business systems built with modern frameworks.</p>
            </div>
            <div class="service-preview-bottom"><span>Learn more</span><i data-lucide="arrow-right"></i></div>
        </a>
        <a href="/services#android" class="service-preview-card reveal">
            <div class="service-preview-top">
                <div class="card-icon blue"><i data-lucide="smartphone"></i></div>
                <h3>Android Apps</h3>
                <p>Native Kotlin experiences with clean architecture, offline support, and reliable integrations.</p>
            </div>
            <div class="service-preview-bottom"><span>Learn more</span><i data-lucide="arrow-right"></i></div>
        </a>
        <a href="/services#ai" class="service-preview-card reveal">
            <div class="service-preview-top">
                <div class="card-icon teal"><i data-lucide="bot"></i></div>
                <h3>AI Agents</h3>
                <p>Practical assistants, document workflows, and knowledge-aware automation for busy teams.</p>
            </div>
            <div class="service-preview-bottom"><span>Learn more</span><i data-lucide="arrow-right"></i></div>
        </a>
        <a href="/services#consulting" class="service-preview-card reveal">
            <div class="service-preview-top">
                <div class="card-icon orange"><i data-lucide="briefcase"></i></div>
                <h3>IT Consulting</h3>
                <p>Architecture reviews, product planning, migration strategy, and technology roadmaps.</p>
            </div>
            <div class="service-preview-bottom"><span>Learn more</span><i data-lucide="arrow-right"></i></div>
        </a>
        <a href="/services#tenant" class="service-preview-card reveal">
            <div class="service-preview-top">
                <div class="card-icon emerald"><i data-lucide="building-2"></i></div>
                <h3>Tenant Management</h3>
                <p>Property operations software with invoicing, maintenance, tenant portals, and analytics.</p>
            </div>
            <div class="service-preview-bottom"><span>Learn more</span><i data-lucide="arrow-right"></i></div>
        </a>
        <a href="/services#custom" class="service-preview-card reveal">
            <div class="service-preview-top">
                <div class="card-icon rose"><i data-lucide="zap"></i></div>
                <h3>Custom Software</h3>
                <p>Business systems for inventory, CRM, booking, reporting, integrations, and operations.</p>
            </div>
            <div class="service-preview-bottom"><span>Learn more</span><i data-lucide="arrow-right"></i></div>
        </a>
    </div>
</div>

<div class="divider"></div>

<!-- Product Highlight -->
<div class="section product-highlight">
    <div class="section-header">
        <p class="eyebrow">Flagship Product</p>
        <h2>TenantPro keeps property operations moving.</h2>
        <p>A complete tenant management ecosystem with a web dashboard for landlords and a native Android app for tenants.</p>
    </div>
    <div class="grid grid-2">
        <article class="card reveal">
            <span class="tag">Web Dashboard</span>
            <h3 style="margin-top:14px;">TenantPro Admin</h3>
            <p>Manage properties, units, tenants, invoices, maintenance, and analytics from a single modern interface.</p>
            <ul class="list">
                <li>Occupancy and revenue dashboards</li>
                <li>Automated invoices and reminders</li>
                <li>Maintenance request tracking</li>
            </ul>
            <div class="stack"><a href="/products" class="btn btn-secondary">Learn More</a></div>
        </article>
        <article class="card reveal">
            <span class="tag">Android App</span>
            <h3 style="margin-top:14px;">TenantPro Mobile</h3>
            <p>Tenants view invoices, make payments, submit maintenance requests, and message management from their phone.</p>
            <ul class="list">
                <li>Native Kotlin app</li>
                <li>Offline-capable flows</li>
                <li>Push notifications for updates</li>
            </ul>
            <div class="stack"><a href="/products" class="btn btn-secondary">Explore Product</a></div>
        </article>
    </div>
</div>

<div class="divider"></div>

<!-- Why Starmax -->
<div class="section">
    <div class="section-header">
        <p class="eyebrow">Why Starmax</p>
        <h2>Clear thinking, clean builds, dependable delivery.</h2>
    </div>
    <div class="grid grid-3">
        <article class="card reveal">
            <div class="card-icon emerald"><i data-lucide="map-pin"></i></div>
            <h3>East Africa Focus</h3>
            <p>We understand local operations, payment realities, infrastructure constraints, and fast-moving business needs.</p>
        </article>
        <article class="card reveal">
            <div class="card-icon blue"><i data-lucide="workflow"></i></div>
            <h3>Full Lifecycle</h3>
            <p>Strategy, design, build, deploy, and support from one accountable team that stays close to outcomes.</p>
        </article>
        <article class="card reveal">
            <div class="card-icon purple"><i data-lucide="shield-check"></i></div>
            <h3>Production Mindset</h3>
            <p>Security, performance, maintainability, and supportability are considered from the first planning session.</p>
        </article>
    </div>
</div>

<!-- CTA -->
<div class="cta-banner reveal">
    <h2>Ready to turn the idea into a working product?</h2>
    <p>Tell us what you want to build and we will help shape the path from concept to launch.</p>
    <a href="/contact" class="btn">Start the Conversation</a>
</div>
@endsection
