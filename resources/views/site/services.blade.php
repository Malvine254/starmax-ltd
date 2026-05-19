@extends('site.layout')

@section('title', 'Services — Starmax Ltd')

@section('content')
<style>
.svc-page-hero {
    background: linear-gradient(150deg, #0f172a 0%, #1e293b 60%, #111827 100%);
    padding: 68px 0 52px;
    position: relative;
    overflow: hidden;
}
.svc-page-hero::after {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(255,255,255,0.035) 1px, transparent 1px);
    background-size: 30px 30px;
    pointer-events: none;
}
.svc-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}
.svc-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 28px;
    display: flex;
    flex-direction: column;
    gap: 14px;
    transition: all 0.28s ease;
    box-shadow: 0 1px 4px rgba(15,23,42,0.06);
    position: relative;
    overflow: hidden;
}
.svc-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #111827, #64748b);
    opacity: 0;
    transition: opacity 0.28s ease;
}
.svc-card:hover { border-color: #cbd5e1; box-shadow: 0 12px 40px rgba(15,23,42,0.1); transform: translateY(-4px); }
.svc-card:hover::before { opacity: 1; }
.svc-card-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
.svc-cat {
    font-size: 11px; font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase;
    color: #94a3b8; background: #f8fafc; border: 1px solid #e2e8f0;
    padding: 3px 10px; border-radius: 999px; white-space: nowrap; flex-shrink: 0;
}
.svc-cat.featured { background: #fef3c7; border-color: #fcd34d; color: #92400e; }
.svc-h3 { font-size: 20px; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.25; }
.svc-p { font-size: 14px; color: #475569; line-height: 1.7; margin: 0; flex-grow: 1; }
.svc-bullets { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 7px; }
.svc-bullets li { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #374151; }
.svc-bullets li::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: #111827; flex-shrink: 0; }
.svc-tags { display: flex; flex-wrap: wrap; gap: 6px; border-top: 1px solid #f1f5f9; padding-top: 12px; }
.svc-tags span { font-size: 11px; font-weight: 600; color: #64748b; background: #f8fafc; border: 1px solid #e2e8f0; padding: 3px 9px; border-radius: 999px; }
.svc-link {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 13px; font-weight: 700; color: #111827; text-decoration: none;
    border-top: 1px solid #f1f5f9; padding-top: 12px; margin-top: auto;
    transition: gap 0.2s ease;
}
.svc-link:hover { gap: 10px; }
.svc-link svg { width: 15px; height: 15px; }
.hero-metric-num { font-size: 34px; font-weight: 850; color: #fff; line-height: 1; }
.hero-metric-label { font-size: 12px; color: rgba(255,255,255,0.45); margin-top: 4px; }
.process-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
.process-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 14px;
    padding: 28px 20px; text-align: center;
    transition: all 0.28s ease; box-shadow: 0 1px 4px rgba(15,23,42,0.06);
}
.process-card:hover { border-color: #cbd5e1; box-shadow: 0 8px 28px rgba(15,23,42,0.08); transform: translateY(-3px); }
.process-step { font-size: 11px; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; color: #94a3b8; margin-bottom: 16px; }
@media (max-width: 900px) { .svc-grid { grid-template-columns: 1fr; } .process-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px) { .process-grid { grid-template-columns: 1fr; } }
</style>

<!-- Hero -->
<section class="svc-page-hero">
    <div class="container" style="position:relative;z-index:1;">
        <p class="eyebrow" style="color:#94a3b8;margin-bottom:14px;">Our Services</p>
        <h2 style="color:#fff;max-width:660px;margin-bottom:16px;font-size:clamp(34px,5vw,56px);">
            End-to-end digital services<br>for ambitious teams.
        </h2>
        <p style="color:rgba(255,255,255,0.58);max-width:560px;font-size:17px;margin-bottom:44px;line-height:1.75;">
            Whether you need a web platform, a mobile app, AI automation, or strategic consulting — we design, build, and support production-grade solutions.
        </p>
        <div style="display:flex;gap:48px;flex-wrap:wrap;align-items:flex-start;">
            <div><div class="hero-metric-num">6</div><div class="hero-metric-label">Core services</div></div>
            <div><div class="hero-metric-num">15+</div><div class="hero-metric-label">Technologies</div></div>
            <div><div class="hero-metric-num">100%</div><div class="hero-metric-label">Production-grade</div></div>
        </div>
    </div>
</section>

<!-- Services Grid -->
<div class="section" style="padding-top:48px;padding-bottom:48px;">
    <div class="svc-grid">

        <!-- Web Development -->
        <article class="svc-card reveal" id="web">
            <div class="svc-card-top">
                <div class="card-icon purple"><i data-lucide="globe"></i></div>
                <span class="svc-cat">Platform</span>
            </div>
            <h3 class="svc-h3">Web Application Development</h3>
            <p class="svc-p">Full-stack web platforms — from admin dashboards to customer-facing SaaS products built for performance, security, and scale.</p>
            <ul class="svc-bullets">
                <li>REST & GraphQL API development</li>
                <li>Admin panels & internal dashboards</li>
                <li>Real-time features & WebSockets</li>
                <li>CI/CD pipelines & cloud deployment</li>
            </ul>
            <div class="svc-tags">
                <span>Laravel</span><span>NestJS</span><span>Next.js</span><span>React</span><span>PostgreSQL</span><span>Redis</span>
            </div>
            <a href="/services/web-development" class="svc-link">
                Explore service <i data-lucide="arrow-right"></i>
            </a>
        </article>

        <!-- Android Development -->
        <article class="svc-card reveal" id="android">
            <div class="svc-card-top">
                <div class="card-icon blue"><i data-lucide="smartphone"></i></div>
                <span class="svc-cat">Mobile</span>
            </div>
            <h3 class="svc-h3">Android App Development</h3>
            <p class="svc-p">Native Kotlin apps with modern architecture and seamless backend integration that feel smooth, work offline, and scale gracefully.</p>
            <ul class="svc-bullets">
                <li>MVVM & Clean Architecture</li>
                <li>Jetpack Compose UI development</li>
                <li>Push notifications & background sync</li>
                <li>Play Store publishing & updates</li>
            </ul>
            <div class="svc-tags">
                <span>Kotlin</span><span>Jetpack Compose</span><span>Material 3</span><span>Hilt</span><span>Firebase</span>
            </div>
            <a href="/services/android-apps" class="svc-link">
                Explore service <i data-lucide="arrow-right"></i>
            </a>
        </article>

        <!-- AI Agents -->
        <article class="svc-card reveal" id="ai">
            <div class="svc-card-top">
                <div class="card-icon teal"><i data-lucide="bot"></i></div>
                <span class="svc-cat">Intelligence</span>
            </div>
            <h3 class="svc-h3">AI Agents & Automation</h3>
            <p class="svc-p">Practical AI that solves real business problems — from document processing to multi-step agent workflows with measurable ROI.</p>
            <ul class="svc-bullets">
                <li>Custom LLM integrations (GPT-4, Claude)</li>
                <li>Tool-using agents & multi-step workflows</li>
                <li>Document processing & extraction</li>
                <li>RAG pipelines for internal knowledge bases</li>
            </ul>
            <div class="svc-tags">
                <span>OpenAI</span><span>Claude</span><span>Python</span><span>LangChain</span><span>RAG</span>
            </div>
            <a href="/services/ai-automation" class="svc-link">
                Explore service <i data-lucide="arrow-right"></i>
            </a>
        </article>

        <!-- IT Consulting -->
        <article class="svc-card reveal" id="consulting">
            <div class="svc-card-top">
                <div class="card-icon orange"><i data-lucide="briefcase"></i></div>
                <span class="svc-cat">Strategy</span>
            </div>
            <h3 class="svc-h3">IT Consulting & Strategy</h3>
            <p class="svc-p">Strategic guidance for technology decisions and digital transformation — backed by hands-on engineering experience and real-world deployments.</p>
            <ul class="svc-bullets">
                <li>Architecture design & system reviews</li>
                <li>Technology stack evaluation</li>
                <li>Digital transformation roadmaps</li>
                <li>Security audits & best-practice reviews</li>
            </ul>
            <div class="svc-tags">
                <span>Architecture</span><span>Cloud Strategy</span><span>Security Audits</span><span>DevOps</span>
            </div>
            <a href="/services/it-consulting" class="svc-link">
                Explore service <i data-lucide="arrow-right"></i>
            </a>
        </article>

        <!-- Tenant Management -->
        <article class="svc-card reveal" id="tenant">
            <div class="svc-card-top">
                <div class="card-icon emerald"><i data-lucide="building-2"></i></div>
                <span class="svc-cat featured">Flagship</span>
            </div>
            <h3 class="svc-h3">Tenant & Property Management</h3>
            <p class="svc-p">Complete operational platform for landlords and property managers — billing, maintenance, communication, and analytics in one production-grade system.</p>
            <ul class="svc-bullets">
                <li>Property & unit lifecycle management</li>
                <li>Automated invoicing & payment tracking</li>
                <li>Maintenance request workflows & SLA</li>
                <li>Native Android app for tenants</li>
            </ul>
            <div class="svc-tags">
                <span>NestJS</span><span>Next.js</span><span>Kotlin</span><span>PostgreSQL</span><span>Prisma</span>
            </div>
            <a href="/services/tenant-management" class="svc-link">
                Explore service <i data-lucide="arrow-right"></i>
            </a>
        </article>

        <!-- Custom Software -->
        <article class="svc-card reveal" id="custom">
            <div class="svc-card-top">
                <div class="card-icon rose"><i data-lucide="zap"></i></div>
                <span class="svc-cat">Bespoke</span>
            </div>
            <h3 class="svc-h3">Custom Business Software</h3>
            <p class="svc-p">Bespoke solutions when off-the-shelf doesn't fit — from CRM and inventory systems to booking engines and data pipelines tailored to your workflows.</p>
            <ul class="svc-bullets">
                <li>CRM & customer management systems</li>
                <li>Booking & scheduling platforms</li>
                <li>Inventory & logistics tracking</li>
                <li>Third-party API integrations</li>
            </ul>
            <div class="svc-tags">
                <span>CRM</span><span>Booking Systems</span><span>API Integrations</span><span>Data Pipelines</span>
            </div>
            <a href="/services/custom-software" class="svc-link">
                Explore service <i data-lucide="arrow-right"></i>
            </a>
        </article>

    </div>
</div>

<!-- Process -->
<div class="divider"></div>
<div class="section" style="padding-top:0;">
    <div class="section-header">
        <p class="eyebrow">How We Work</p>
        <h2>A process you can trust.</h2>
        <p>Every engagement follows a structured approach that keeps you informed and in control from kickoff to launch.</p>
    </div>
    <div class="process-grid">
        <article class="process-card reveal">
            <div class="process-step">01 — Discovery</div>
            <div class="card-icon purple" style="margin:0 auto 16px;"><i data-lucide="search"></i></div>
            <h3 style="margin-bottom:8px;">Discovery</h3>
            <p class="text-muted" style="font-size:13px;">Understand your goals, constraints, and users before writing a single line of code.</p>
        </article>
        <article class="process-card reveal">
            <div class="process-step">02 — Design</div>
            <div class="card-icon blue" style="margin:0 auto 16px;"><i data-lucide="pen-tool"></i></div>
            <h3 style="margin-bottom:8px;">Design</h3>
            <p class="text-muted" style="font-size:13px;">Architecture diagrams and wireframes reviewed and approved before development begins.</p>
        </article>
        <article class="process-card reveal">
            <div class="process-step">03 — Build</div>
            <div class="card-icon teal" style="margin:0 auto 16px;"><i data-lucide="code-2"></i></div>
            <h3 style="margin-bottom:8px;">Build</h3>
            <p class="text-muted" style="font-size:13px;">Iterative development with regular check-ins, demos, and code reviews at every milestone.</p>
        </article>
        <article class="process-card reveal">
            <div class="process-step">04 — Launch</div>
            <div class="card-icon emerald" style="margin:0 auto 16px;"><i data-lucide="rocket"></i></div>
            <h3 style="margin-bottom:8px;">Launch & Support</h3>
            <p class="text-muted" style="font-size:13px;">Deploy to production, monitor for issues, and evolve together as your needs grow.</p>
        </article>
    </div>
</div>

<!-- CTA -->
<div class="cta-banner reveal">
    <h2>Have a project in mind?</h2>
    <p>Let's discuss the scope and build something that works for your team.</p>
    <div class="cta-actions">
        <a href="/contact" class="btn btn-primary">Get a Free Consultation →</a>
        <a href="/portfolio" class="btn btn-secondary">View our work</a>
    </div>
</div>

@endsection
