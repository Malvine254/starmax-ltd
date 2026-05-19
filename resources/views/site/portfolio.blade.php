@extends('site.layout')

@section('title', 'Portfolio — Starmax Ltd')

@section('content')
<style>
/* ── PORTFOLIO PAGE ── */
.port-hero {
    background: linear-gradient(150deg,#0f172a 0%,#1e293b 55%,#111827 100%);
    padding: 68px 0 52px; position: relative; overflow: hidden;
}
.port-hero::after {
    content:''; position:absolute; inset:0;
    background-image: radial-gradient(rgba(255,255,255,0.035) 1px,transparent 1px);
    background-size: 30px 30px; pointer-events:none;
}
.port-stats {
    display: flex; gap: 48px; flex-wrap: wrap; margin-top: 40px;
}
.port-stat-num { font-size: 34px; font-weight: 850; color: #fff; line-height: 1; }
.port-stat-label { font-size: 12px; color: rgba(255,255,255,0.45); margin-top: 4px; }
/* Category label */
.cat-label {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: 11px; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase;
    color: #94a3b8; padding: 0 0 14px; border-bottom: 2px solid #e2e8f0;
    margin-bottom: 24px; width: 100%;
}
.cat-label svg { width: 14px; height: 14px; }
/* Project card */
.proj-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.proj-grid-2 { grid-template-columns: repeat(2, 1fr); }
.proj-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 16px;
    padding: 0; overflow: hidden; display: flex; flex-direction: column;
    box-shadow: 0 1px 4px rgba(15,23,42,0.05); transition: all 0.3s ease;
}
.proj-card:hover { border-color: #cbd5e1; box-shadow: 0 12px 40px rgba(15,23,42,0.1); transform: translateY(-4px); }
.proj-card-top {
    padding: 24px 24px 18px;
    flex: 1;
}
.proj-card-meta {
    display: flex; align-items: center; gap: 8px; margin-bottom: 14px; flex-wrap: wrap;
}
.proj-type {
    font-size: 11px; font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase;
    padding: 3px 10px; border-radius: 999px;
}
.proj-type-web   { background: #ede9fe; color: #6d28d9; }
.proj-type-mobile { background: #dbeafe; color: #1d4ed8; }
.proj-type-ai    { background: #ccfbf1; color: #0f766e; }
.proj-type-prop  { background: #d1fae5; color: #065f46; }
.proj-industry {
    font-size: 11px; font-weight: 600; color: #94a3b8;
}
.proj-card h3 { font-size: 17px; font-weight: 800; color: #0f172a; margin-bottom: 10px; }
.proj-card p { font-size: 13px; color: #475569; line-height: 1.7; margin: 0; }
.proj-card-bottom {
    padding: 14px 24px 18px; border-top: 1px solid #f1f5f9;
    background: #fafbff;
}
.proj-tech-row { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 12px; }
.proj-tech { font-size: 11px; font-weight: 600; color: #64748b; background: #f1f5f9; border: 1px solid #e2e8f0; padding: 2px 8px; border-radius: 999px; }
.proj-outcome {
    display: flex; align-items: center; gap: 7px;
    font-size: 12px; font-weight: 700; color: #059669;
}
.proj-outcome svg { width: 13px; height: 13px; flex-shrink: 0; }
/* Property cards */
.prop-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.prop-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 26px;
    box-shadow: 0 1px 4px rgba(15,23,42,0.05); transition: all 0.28s ease;
}
.prop-card:hover { border-color: #cbd5e1; box-shadow: 0 10px 34px rgba(15,23,42,0.09); transform: translateY(-3px); }
.prop-location { font-size: 12px; font-weight: 600; color: #94a3b8; margin-top: 4px; margin-bottom: 10px; display: flex; align-items: center; gap: 5px; }
.prop-location svg { width: 12px; height: 12px; }
.prop-stat { display: flex; gap: 16px; margin-top: 14px; padding-top: 14px; border-top: 1px solid #f1f5f9; }
.prop-stat-item { display: flex; flex-direction: column; gap: 2px; }
.prop-stat-item span:first-child { font-size: 18px; font-weight: 850; color: #0f172a; line-height: 1; }
.prop-stat-item span:last-child { font-size: 11px; color: #94a3b8; }
@media (max-width: 1024px) {
    .proj-grid { grid-template-columns: repeat(2, 1fr); }
    .proj-grid-2 { grid-template-columns: 1fr; }
    .prop-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .proj-grid { grid-template-columns: 1fr; }
    .prop-grid { grid-template-columns: 1fr; }
    .port-stats { gap: 28px; }
}
</style>

<!-- Hero -->
<section class="port-hero">
    <div class="container" style="position:relative;z-index:1;">
        <p class="eyebrow" style="color:#94a3b8;margin-bottom:14px;">Our Work</p>
        <h2 style="color:#fff;max-width:680px;margin-bottom:16px;font-size:clamp(34px,5vw,56px);">
            Projects that speak for themselves.
        </h2>
        <p style="color:rgba(255,255,255,0.58);max-width:580px;font-size:17px;line-height:1.75;">
            A selection of web platforms, mobile apps, AI solutions, and property systems we've designed and delivered for clients across East Africa.
        </p>
        <div class="port-stats">
            <div><div class="port-stat-num">50+</div><div class="port-stat-label">Projects delivered</div></div>
            <div><div class="port-stat-num">4</div><div class="port-stat-label">Disciplines</div></div>
            <div><div class="port-stat-num">3+</div><div class="port-stat-label">Countries served</div></div>
        </div>
    </div>
</section>

<!-- Web Development -->
<div class="section" style="padding-bottom:0;">
    <div style="display:flex;align-items:center;gap:10px;font-size:11px;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#94a3b8;padding-bottom:14px;border-bottom:2px solid #e2e8f0;margin-bottom:24px;">
        <i data-lucide="globe" style="width:14px;height:14px;"></i> Web Development
    </div>
    <div class="proj-grid">
        <article class="proj-card reveal">
            <div class="proj-card-top">
                <div class="proj-card-meta">
                    <span class="proj-type proj-type-web">Web App</span>
                    <span class="proj-industry">Property Management</span>
                </div>
                <h3>TenantPro Admin Dashboard</h3>
                <p>Full-featured admin console for landlords — property management, invoicing, maintenance tracking, tenant onboarding, and analytics. Built with Next.js server components and a NestJS API.</p>
            </div>
            <div class="proj-card-bottom">
                <div class="proj-tech-row">
                    <span class="proj-tech">Next.js</span>
                    <span class="proj-tech">NestJS</span>
                    <span class="proj-tech">PostgreSQL</span>
                    <span class="proj-tech">Prisma</span>
                </div>
                <div class="proj-outcome"><i data-lucide="trending-up"></i> Live in production — active daily users</div>
            </div>
        </article>
        <article class="proj-card reveal">
            <div class="proj-card-top">
                <div class="proj-card-meta">
                    <span class="proj-type proj-type-web">Web App</span>
                    <span class="proj-industry">Retail</span>
                </div>
                <h3>E-Commerce Platform</h3>
                <p>Multi-vendor marketplace with inventory management, order processing, M-Pesa payment integration, and real-time delivery tracking for a Nairobi-based retailer.</p>
            </div>
            <div class="proj-card-bottom">
                <div class="proj-tech-row">
                    <span class="proj-tech">Laravel</span>
                    <span class="proj-tech">Vue.js</span>
                    <span class="proj-tech">M-Pesa API</span>
                    <span class="proj-tech">MySQL</span>
                </div>
                <div class="proj-outcome"><i data-lucide="trending-up"></i> 3× order volume in 6 months post-launch</div>
            </div>
        </article>
        <article class="proj-card reveal">
            <div class="proj-card-top">
                <div class="proj-card-meta">
                    <span class="proj-type proj-type-web">Web App</span>
                    <span class="proj-industry">Enterprise</span>
                </div>
                <h3>Corporate Operations Portal</h3>
                <p>Internal portal for a logistics company. HR management, fleet tracking, document workflows, and custom reporting dashboards serving 120+ staff members.</p>
            </div>
            <div class="proj-card-bottom">
                <div class="proj-tech-row">
                    <span class="proj-tech">React</span>
                    <span class="proj-tech">Node.js</span>
                    <span class="proj-tech">PostgreSQL</span>
                    <span class="proj-tech">Redis</span>
                </div>
                <div class="proj-outcome"><i data-lucide="trending-up"></i> 40% reduction in manual reporting time</div>
            </div>
        </article>
    </div>
</div>

<!-- Android -->
<div class="section" style="padding-bottom:0;">
    <div style="display:flex;align-items:center;gap:10px;font-size:11px;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#94a3b8;padding-bottom:14px;border-bottom:2px solid #e2e8f0;margin-bottom:24px;">
        <i data-lucide="smartphone" style="width:14px;height:14px;"></i> Android Development
    </div>
    <div class="proj-grid">
        <article class="proj-card reveal">
            <div class="proj-card-top">
                <div class="proj-card-meta">
                    <span class="proj-type proj-type-mobile">Android</span>
                    <span class="proj-industry">Property</span>
                </div>
                <h3>TenantPro Mobile</h3>
                <p>Tenant self-service app with invoice viewing, payment tracking, maintenance requests, and direct messaging. Clean MVVM architecture with Hilt DI and offline support.</p>
            </div>
            <div class="proj-card-bottom">
                <div class="proj-tech-row">
                    <span class="proj-tech">Kotlin</span>
                    <span class="proj-tech">Jetpack Compose</span>
                    <span class="proj-tech">Hilt</span>
                    <span class="proj-tech">Retrofit</span>
                </div>
                <div class="proj-outcome"><i data-lucide="trending-up"></i> Material 3 — works offline</div>
            </div>
        </article>
        <article class="proj-card reveal">
            <div class="proj-card-top">
                <div class="proj-card-meta">
                    <span class="proj-type proj-type-mobile">Android</span>
                    <span class="proj-industry">Utilities</span>
                </div>
                <h3>Field Service App</h3>
                <p>GPS-enabled field worker app for a utility company. Job assignment, route optimization, photo documentation, and offline task completion with background sync.</p>
            </div>
            <div class="proj-card-bottom">
                <div class="proj-tech-row">
                    <span class="proj-tech">Kotlin</span>
                    <span class="proj-tech">Maps SDK</span>
                    <span class="proj-tech">WorkManager</span>
                    <span class="proj-tech">Room</span>
                </div>
                <div class="proj-outcome"><i data-lucide="trending-up"></i> 60% faster job dispatch vs. paper process</div>
            </div>
        </article>
        <article class="proj-card reveal">
            <div class="proj-card-top">
                <div class="proj-card-meta">
                    <span class="proj-type proj-type-mobile">Android</span>
                    <span class="proj-industry">Healthcare</span>
                </div>
                <h3>Health Check-In App</h3>
                <p>Patient intake and appointment management for a clinic chain. Biometric auth, appointment scheduling, and health record access with HIPAA-aligned data handling.</p>
            </div>
            <div class="proj-card-bottom">
                <div class="proj-tech-row">
                    <span class="proj-tech">Kotlin</span>
                    <span class="proj-tech">Jetpack Compose</span>
                    <span class="proj-tech">Biometric API</span>
                    <span class="proj-tech">Firebase</span>
                </div>
                <div class="proj-outcome"><i data-lucide="trending-up"></i> 85% reduction in front-desk wait time</div>
            </div>
        </article>
    </div>
</div>

<!-- AI & Automation -->
<div class="section" style="padding-bottom:0;">
    <div style="display:flex;align-items:center;gap:10px;font-size:11px;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#94a3b8;padding-bottom:14px;border-bottom:2px solid #e2e8f0;margin-bottom:24px;">
        <i data-lucide="bot" style="width:14px;height:14px;"></i> AI & Automation
    </div>
    <div class="proj-grid proj-grid-2">
        <article class="proj-card reveal">
            <div class="proj-card-top">
                <div class="proj-card-meta">
                    <span class="proj-type proj-type-ai">AI Agent</span>
                    <span class="proj-industry">Finance</span>
                </div>
                <h3>Document Processing Agent</h3>
                <p>Automated extraction of data from scanned invoices, receipts, and contracts. Multi-step agent with tool-use capabilities, validation checks, and integration with accounting systems.</p>
            </div>
            <div class="proj-card-bottom">
                <div class="proj-tech-row">
                    <span class="proj-tech">Python</span>
                    <span class="proj-tech">Claude API</span>
                    <span class="proj-tech">LangChain</span>
                    <span class="proj-tech">FastAPI</span>
                </div>
                <div class="proj-outcome"><i data-lucide="trending-up"></i> 80% reduction in manual data entry</div>
            </div>
        </article>
        <article class="proj-card reveal">
            <div class="proj-card-top">
                <div class="proj-card-meta">
                    <span class="proj-type proj-type-ai">AI Agent</span>
                    <span class="proj-industry">Telecom</span>
                </div>
                <h3>Customer Support Bot</h3>
                <p>Knowledge-base powered chatbot for a telecom provider. RAG pipeline with custom embeddings, escalation routing, and sentiment analysis integrated with existing CRM systems.</p>
            </div>
            <div class="proj-card-bottom">
                <div class="proj-tech-row">
                    <span class="proj-tech">RAG</span>
                    <span class="proj-tech">Claude API</span>
                    <span class="proj-tech">Pinecone</span>
                    <span class="proj-tech">FastAPI</span>
                </div>
                <div class="proj-outcome"><i data-lucide="trending-up"></i> Handles 60% of tier-1 tickets autonomously</div>
            </div>
        </article>
    </div>
</div>

<!-- Property Management -->
<div class="section">
    <div style="display:flex;align-items:center;gap:10px;font-size:11px;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#94a3b8;padding-bottom:14px;border-bottom:2px solid #e2e8f0;margin-bottom:24px;">
        <i data-lucide="building-2" style="width:14px;height:14px;"></i> Properties Under Management
    </div>
    <div class="prop-grid">
        <article class="prop-card reveal">
            <div class="card-icon emerald" style="margin-bottom:14px;"><i data-lucide="building-2"></i></div>
            <h3 style="margin-bottom:4px;">Westlands Apartments</h3>
            <div class="prop-location"><i data-lucide="map-pin"></i> Nairobi, Kenya</div>
            <p style="font-size:13px;color:#475569;line-height:1.65;">Residential complex with monthly rent dashboards, automated invoice generation, and maintenance SLA tracking.</p>
            <div class="prop-stat">
                <div class="prop-stat-item"><span>12</span><span>Units</span></div>
                <div class="prop-stat-item"><span>99%</span><span>On-time collections</span></div>
            </div>
        </article>
        <article class="prop-card reveal">
            <div class="card-icon emerald" style="margin-bottom:14px;"><i data-lucide="home"></i></div>
            <h3 style="margin-bottom:4px;">Kileleshwa Residences</h3>
            <div class="prop-location"><i data-lucide="map-pin"></i> Nairobi, Kenya</div>
            <p style="font-size:13px;color:#475569;line-height:1.65;">Premium residential property with centralized tenant communication, digital onboarding, and recurring invoice automation.</p>
            <div class="prop-stat">
                <div class="prop-stat-item"><span>8</span><span>Units</span></div>
                <div class="prop-stat-item"><span>100%</span><span>Digital onboarding</span></div>
            </div>
        </article>
        <article class="prop-card reveal">
            <div class="card-icon emerald" style="margin-bottom:14px;"><i data-lucide="store"></i></div>
            <h3 style="margin-bottom:4px;">Mombasa Commercial Plaza</h3>
            <div class="prop-location"><i data-lucide="map-pin"></i> Mombasa, Kenya</div>
            <p style="font-size:13px;color:#475569;line-height:1.65;">Mixed-use commercial property with occupancy trend analytics, coordinated support operations, and investor reporting.</p>
            <div class="prop-stat">
                <div class="prop-stat-item"><span>20</span><span>Units</span></div>
                <div class="prop-stat-item"><span>Auto</span><span>Investor reports</span></div>
            </div>
        </article>
    </div>
</div>

<!-- CTA -->
<div class="cta-banner reveal">
    <h2>Let's add your project to this list.</h2>
    <p>We'd love to hear about your idea and show you what we can build together.</p>
    <div class="cta-actions">
        <a href="/contact" class="btn btn-primary">Start a Conversation →</a>
        <a href="/services" class="btn btn-secondary">Explore services</a>
    </div>
</div>

@endsection
