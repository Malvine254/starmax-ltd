@extends('site.layout')

@section('title', 'Products — Starmax Ltd')

@section('content')
<style>
/* ── PRODUCTS PAGE ── */
.prod-hero {
    background: linear-gradient(150deg,#0f172a 0%,#1e293b 55%,#111827 100%);
    padding: 68px 0 52px; position: relative; overflow: hidden;
}
.prod-hero::after {
    content:''; position:absolute; inset:0;
    background-image: radial-gradient(rgba(255,255,255,0.035) 1px,transparent 1px);
    background-size: 30px 30px; pointer-events:none;
}
/* Product showcase */
.prod-showcase {
    display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 48px;
}
.prod-panel {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 20px;
    overflow: hidden; box-shadow: 0 4px 24px rgba(15,23,42,0.08);
    display: flex; flex-direction: column;
    transition: all 0.3s ease;
}
.prod-panel:hover { box-shadow: 0 16px 52px rgba(15,23,42,0.13); transform: translateY(-4px); }
.prod-panel-header {
    padding: 32px 32px 24px;
    background: linear-gradient(135deg,#0f172a 0%,#1e293b 100%);
    color: #fff; position: relative; overflow: hidden;
}
.prod-panel-header::after {
    content:''; position:absolute; inset:0;
    background-image: radial-gradient(rgba(255,255,255,0.04) 1px,transparent 1px);
    background-size: 22px 22px;
}
.prod-panel-header-inner { position:relative; z-index:1; }
.prod-tag {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 11px; font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase;
    background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2);
    color: rgba(255,255,255,0.8); padding: 4px 12px; border-radius: 999px;
    margin-bottom: 16px;
}
.prod-tag svg { width:12px; height:12px; }
.prod-panel-header h3 { font-size: 24px; font-weight: 850; color: #fff; margin-bottom: 8px; }
.prod-panel-header p { font-size: 14px; color: rgba(255,255,255,0.6); line-height: 1.7; }
.prod-panel-body { padding: 28px 32px 32px; flex: 1; display: flex; flex-direction: column; }
.prod-features { list-style: none; padding: 0; margin: 0 0 24px; display: flex; flex-direction: column; gap: 10px; }
.prod-features li {
    display: flex; align-items: flex-start; gap: 10px;
    font-size: 14px; color: #374151; line-height: 1.55;
}
.prod-features li span.check {
    width: 20px; height: 20px; border-radius: 50%; background: #d1fae5;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px;
}
.prod-features li span.check svg { width: 11px; height: 11px; color: #059669; }
.prod-actions { display: flex; gap: 10px; flex-wrap: wrap; margin-top: auto; }
/* Tech stack */
.tech-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;
}
.tech-item {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 24px 20px;
    text-align: center; box-shadow: 0 1px 4px rgba(15,23,42,0.05);
    transition: all 0.28s ease;
}
.tech-item:hover { border-color: #cbd5e1; box-shadow: 0 8px 28px rgba(15,23,42,0.08); transform: translateY(-3px); }
.tech-item h4 { font-size: 15px; font-weight: 750; color: #0f172a; margin-bottom: 4px; }
.tech-item p { font-size: 12px; color: #94a3b8; margin: 0; }
/* Roadmap */
.roadmap-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.roadmap-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px;
    position: relative; overflow: hidden;
    box-shadow: 0 1px 4px rgba(15,23,42,0.05); transition: all 0.28s ease;
}
.roadmap-card:hover { border-color: #cbd5e1; box-shadow: 0 10px 36px rgba(15,23,42,0.09); transform: translateY(-3px); }
.roadmap-status {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 11px; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase;
    padding: 4px 10px; border-radius: 999px; margin-bottom: 16px;
}
.status-soon { background: #fef3c7; color: #92400e; }
.status-dev { background: #dbeafe; color: #1e40af; }
.status-planned { background: #f3f4f6; color: #6b7280; }
/* Platform badge */
.platform-badges { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 20px; }
.platform-badge {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 11px; font-weight: 600; color: #475569;
    background: #f8fafc; border: 1px solid #e2e8f0; padding: 4px 10px; border-radius: 999px;
}
.platform-badge svg { width: 12px; height: 12px; }
/* Stats row */
.prod-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 32px; }
.prod-stat {
    background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);
    border-radius: 12px; padding: 20px; text-align: center;
}
.prod-stat-num { font-size: 32px; font-weight: 850; color: #fff; line-height: 1; }
.prod-stat-label { font-size: 12px; color: rgba(255,255,255,0.45); margin-top: 5px; }
@media (max-width: 900px) {
    .prod-showcase { grid-template-columns: 1fr; }
    .tech-grid { grid-template-columns: repeat(2, 1fr); }
    .roadmap-grid { grid-template-columns: 1fr; }
    .prod-stats { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 600px) {
    .tech-grid { grid-template-columns: repeat(2, 1fr); }
    .prod-stats { grid-template-columns: 1fr; }
}
</style>

<!-- Hero -->
<section class="prod-hero">
    <div class="container" style="position:relative;z-index:1;">
        <p class="eyebrow" style="color:#94a3b8;margin-bottom:14px;">Our Products</p>
        <h2 style="color:#fff;max-width:680px;margin-bottom:16px;font-size:clamp(34px,5vw,56px);">
            Software products built by Starmax.
        </h2>
        <p style="color:rgba(255,255,255,0.58);max-width:560px;font-size:17px;margin-bottom:44px;line-height:1.75;">
            Production-grade platforms designed for real users, shipped with modern architecture, and supported long-term.
        </p>
        <div class="prod-stats">
            <div class="prod-stat"><div class="prod-stat-num">2</div><div class="prod-stat-label">Active products</div></div>
            <div class="prod-stat"><div class="prod-stat-num">3+</div><div class="prod-stat-label">In development</div></div>
            <div class="prod-stat"><div class="prod-stat-num">Live</div><div class="prod-stat-label">In production</div></div>
        </div>
    </div>
</section>

<!-- TenantPro product -->
<div class="section" style="padding-bottom:0;">
    <div class="section-header left" style="text-align:left;margin:0 0 12px;">
        <p class="eyebrow">Starmax Portfolio Product</p>
        <h2 style="margin-bottom:8px;">TenantPro — Property Management Platform</h2>
        <p style="max-width:620px;">A complete ecosystem for property operations: a powerful web dashboard for landlords and an intuitive Android app for tenants — all backed by one robust API.</p>
    </div>
    <div class="prod-showcase">

        <!-- Web Dashboard -->
        <article class="prod-panel reveal" id="tenantpro">
            <div class="prod-panel-header">
                <div class="prod-panel-header-inner">
                    <div class="prod-tag"><i data-lucide="monitor"></i> Web Platform</div>
                    <h3>TenantPro Admin Console</h3>
                    <p>The command center for landlords, property managers, and operations teams — built for speed and clarity.</p>
                </div>
            </div>
            <div class="prod-panel-body">
                <ul class="prod-features">
                    <li><span class="check"><i data-lucide="check"></i></span>Property & unit lifecycle management</li>
                    <li><span class="check"><i data-lucide="check"></i></span>Tenant onboarding with digital invitations</li>
                    <li><span class="check"><i data-lucide="check"></i></span>Automated invoicing & payment reconciliation</li>
                    <li><span class="check"><i data-lucide="check"></i></span>Maintenance workflow with SLA tracking</li>
                    <li><span class="check"><i data-lucide="check"></i></span>Revenue, occupancy & analytics dashboards</li>
                    <li><span class="check"><i data-lucide="check"></i></span>Role-based access — admin, manager, caretaker</li>
                </ul>
                <div class="platform-badges">
                    <span class="platform-badge"><i data-lucide="layers"></i> NestJS API</span>
                    <span class="platform-badge"><i data-lucide="monitor"></i> Next.js</span>
                    <span class="platform-badge"><i data-lucide="database"></i> PostgreSQL</span>
                    <span class="platform-badge"><i data-lucide="lock"></i> Role-Based Access</span>
                </div>
                <div class="prod-actions" style="margin-top:24px;">
                    <a href="/admin/login" class="btn btn-primary"><i data-lucide="log-in"></i> Access Dashboard</a>
                    <a href="/services/tenant-management" class="btn btn-secondary">Learn more</a>
                </div>
            </div>
        </article>

        <!-- Mobile App -->
        <article class="prod-panel reveal" id="mobile">
            <div class="prod-panel-header" style="background:linear-gradient(135deg,#065f46 0%,#0f172a 100%);">
                <div class="prod-panel-header-inner">
                    <div class="prod-tag"><i data-lucide="smartphone"></i> Android App</div>
                    <h3>TenantPro Mobile</h3>
                    <p>A self-service app for tenants — view invoices, pay rent, report issues, and communicate with management from anywhere.</p>
                </div>
            </div>
            <div class="prod-panel-body">
                <ul class="prod-features">
                    <li><span class="check"><i data-lucide="check"></i></span>Invoice viewing & payment status tracking</li>
                    <li><span class="check"><i data-lucide="check"></i></span>Maintenance request submission & updates</li>
                    <li><span class="check"><i data-lucide="check"></i></span>Direct messaging with property management</li>
                    <li><span class="check"><i data-lucide="check"></i></span>Push notifications for all important updates</li>
                    <li><span class="check"><i data-lucide="check"></i></span>Material 3 design with system dark mode</li>
                    <li><span class="check"><i data-lucide="check"></i></span>Works on Android 8.0+ (API 26+)</li>
                </ul>
                <div class="platform-badges">
                    <span class="platform-badge"><i data-lucide="smartphone"></i> Kotlin</span>
                    <span class="platform-badge"><i data-lucide="paintbrush"></i> Jetpack Compose</span>
                    <span class="platform-badge"><i data-lucide="bell"></i> Firebase FCM</span>
                    <span class="platform-badge"><i data-lucide="wifi-off"></i> Offline-first</span>
                </div>
                <div class="prod-actions" style="margin-top:24px;">
                    <a href="{{ config('app.tenant_demo_url') }}" class="btn btn-primary" target="_blank" rel="noopener"><i data-lucide="external-link"></i> Try Live Demo</a>
                    <a href="/contact" class="btn btn-secondary">Request APK</a>
                </div>
            </div>
        </article>

    </div>
</div>

<!-- Tech Stack -->
<div class="divider"></div>
<div class="section" style="padding-top:0;">
    <div class="section-header">
        <p class="eyebrow">Under the Hood</p>
        <h2>Built with proven technology.</h2>
        <p>Every component chosen for reliability, developer experience, and long-term maintainability.</p>
    </div>
    <div class="tech-grid">
        <article class="tech-item reveal">
            <div class="card-icon blue" style="margin:0 auto 14px;"><i data-lucide="settings-2"></i></div>
            <h4>NestJS</h4>
            <p>Backend API layer</p>
        </article>
        <article class="tech-item reveal">
            <div class="card-icon purple" style="margin:0 auto 14px;"><i data-lucide="monitor"></i></div>
            <h4>Next.js</h4>
            <p>Admin dashboard frontend</p>
        </article>
        <article class="tech-item reveal">
            <div class="card-icon teal" style="margin:0 auto 14px;"><i data-lucide="smartphone"></i></div>
            <h4>Kotlin + Compose</h4>
            <p>Native Android app</p>
        </article>
        <article class="tech-item reveal">
            <div class="card-icon emerald" style="margin:0 auto 14px;"><i data-lucide="database"></i></div>
            <h4>PostgreSQL</h4>
            <p>Primary data store</p>
        </article>
        <article class="tech-item reveal">
            <div class="card-icon orange" style="margin:0 auto 14px;"><i data-lucide="zap"></i></div>
            <h4>Prisma ORM</h4>
            <p>Type-safe database access</p>
        </article>
        <article class="tech-item reveal">
            <div class="card-icon rose" style="margin:0 auto 14px;"><i data-lucide="layers"></i></div>
            <h4>Docker</h4>
            <p>Containerised deployment</p>
        </article>
        <article class="tech-item reveal">
            <div class="card-icon sky" style="margin:0 auto 14px;"><i data-lucide="bell"></i></div>
            <h4>Firebase FCM</h4>
            <p>Push notifications</p>
        </article>
        <article class="tech-item reveal">
            <div class="card-icon purple" style="margin:0 auto 14px;"><i data-lucide="shield"></i></div>
            <h4>JWT + Guards</h4>
            <p>Authentication & RBAC</p>
        </article>
    </div>
</div>

<!-- Dark strip: Architecture overview -->
<div style="background:#0f172a;padding:52px 0;">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:center;">
            <div>
                <p style="font-size:11px;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#475569;margin-bottom:10px;">Architecture</p>
                <h2 style="font-size:clamp(24px,3.2vw,38px);font-weight:850;color:#fff;margin-bottom:16px;">
                    One API. Two interfaces.
                </h2>
                <p style="font-size:15px;color:#64748b;line-height:1.8;margin-bottom:28px;">
                    TenantPro is built around a single NestJS API that powers both the web admin console and the native Android app. This means features ship once and work everywhere.
                </p>
                <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:12px;">
                    <li style="display:flex;align-items:center;gap:10px;font-size:14px;color:#94a3b8;">
                        <span style="width:8px;height:8px;border-radius:50%;background:#10b981;flex-shrink:0;"></span>
                        Shared business logic — no duplication
                    </li>
                    <li style="display:flex;align-items:center;gap:10px;font-size:14px;color:#94a3b8;">
                        <span style="width:8px;height:8px;border-radius:50%;background:#10b981;flex-shrink:0;"></span>
                        Role-aware API — same endpoint, scoped data
                    </li>
                    <li style="display:flex;align-items:center;gap:10px;font-size:14px;color:#94a3b8;">
                        <span style="width:8px;height:8px;border-radius:50%;background:#10b981;flex-shrink:0;"></span>
                        Real-time events via WebSockets
                    </li>
                    <li style="display:flex;align-items:center;gap:10px;font-size:14px;color:#94a3b8;">
                        <span style="width:8px;height:8px;border-radius:50%;background:#10b981;flex-shrink:0;"></span>
                        Containerised & production-deployed
                    </li>
                </ul>
            </div>
            <div style="display:grid;grid-template-columns:1fr;gap:12px;">
                @php
                $layers = [
                    ['icon'=>'smartphone','label'=>'TenantPro Mobile','sub'=>'Kotlin · Jetpack Compose','color'=>'#10b981'],
                    ['icon'=>'monitor','label'=>'Admin Console','sub'=>'Next.js · React','color'=>'#6366f1'],
                    ['icon'=>'server','label'=>'NestJS REST API','sub'=>'Core business logic','color'=>'#f59e0b'],
                    ['icon'=>'database','label'=>'PostgreSQL + Redis','sub'=>'Data layer','color'=>'#0ea5e9'],
                ];
                @endphp
                @foreach($layers as $layer)
                <div style="display:flex;align-items:center;gap:14px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:16px 20px;">
                    <div style="width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,0.06);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:{{ $layer['color'] }};">
                        <i data-lucide="{{ $layer['icon'] }}" style="width:18px;height:18px;"></i>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:700;color:#e2e8f0;">{{ $layer['label'] }}</div>
                        <div style="font-size:12px;color:#475569;margin-top:2px;">{{ $layer['sub'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Roadmap -->
<div class="section">
    <div class="section-header">
        <p class="eyebrow">On The Roadmap</p>
        <h2>More products in development.</h2>
        <p>We're continuously expanding the TenantPro ecosystem and building new standalone products.</p>
    </div>
    <div class="roadmap-grid">
        <article class="roadmap-card reveal">
            <span class="roadmap-status status-soon"><i data-lucide="clock" style="width:11px;height:11px;"></i> Coming Soon</span>
            <div class="card-icon orange" style="margin-bottom:14px;"><i data-lucide="bot"></i></div>
            <h3 style="margin-bottom:8px;">AI Support Agent</h3>
            <p style="font-size:14px;color:#475569;line-height:1.7;margin-bottom:0;">An intelligent assistant that handles tenant queries, triages maintenance requests, and surfaces insights from property data — integrated directly into TenantPro.</p>
        </article>
        <article class="roadmap-card reveal">
            <span class="roadmap-status status-dev"><i data-lucide="code-2" style="width:11px;height:11px;"></i> In Development</span>
            <div class="card-icon rose" style="margin-bottom:14px;"><i data-lucide="bar-chart-3"></i></div>
            <h3 style="margin-bottom:8px;">Portfolio Analytics</h3>
            <p style="font-size:14px;color:#475569;line-height:1.7;margin-bottom:0;">Advanced reporting with revenue trend forecasting, property benchmarking, and automated investor-ready PDF reports with one click.</p>
        </article>
        <article class="roadmap-card reveal">
            <span class="roadmap-status status-planned"><i data-lucide="map" style="width:11px;height:11px;"></i> Planned</span>
            <div class="card-icon sky" style="margin-bottom:14px;"><i data-lucide="credit-card"></i></div>
            <h3 style="margin-bottom:8px;">M-Pesa Integration</h3>
            <p style="font-size:14px;color:#475569;line-height:1.7;margin-bottom:0;">Native mobile money payments with automatic reconciliation, real-time push confirmation, and STK push support for Kenyan tenants.</p>
        </article>
    </div>
</div>

<!-- CTA -->
<div class="cta-banner reveal">
    <h2>Want a custom product built?</h2>
    <p>We build bespoke software products for businesses of all sizes. Let's discuss your idea.</p>
    <div class="cta-actions">
        <a href="/contact" class="btn btn-primary">Talk to Us →</a>
        <a href="/services" class="btn btn-secondary">Explore services</a>
    </div>
</div>

@endsection
