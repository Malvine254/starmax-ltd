@extends('site.layout')

@section('title', 'About — Starmax Ltd')

@section('content')
<style>
/* ── ABOUT PAGE ── */
.about-hero {
    background: linear-gradient(150deg,#0f172a 0%,#1e293b 55%,#111827 100%);
    padding: 68px 0 52px; position: relative; overflow: hidden;
}
.about-hero::after {
    content:''; position:absolute; inset:0;
    background-image: radial-gradient(rgba(255,255,255,0.035) 1px,transparent 1px);
    background-size: 30px 30px; pointer-events:none;
}
.about-stats-row {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 40px;
}
.about-stat {
    background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
    border-radius: 14px; padding: 20px 22px;
}
.about-stat-num { font-size: 34px; font-weight: 850; color: #fff; line-height: 1; }
.about-stat-label { font-size: 12px; color: rgba(255,255,255,0.45); margin-top: 5px; }
/* Mission / Vision */
.mv-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.mv-card {
    border-radius: 18px; padding: 32px; position: relative; overflow: hidden;
    transition: all 0.3s ease;
}
.mv-card-mission {
    background: linear-gradient(135deg,#312e81 0%,#1e1b4b 100%);
    border: 1px solid rgba(255,255,255,0.1);
}
.mv-card-vision {
    background: linear-gradient(135deg,#065f46 0%,#0f172a 100%);
    border: 1px solid rgba(255,255,255,0.1);
}
.mv-card::after {
    content:''; position:absolute; inset:0;
    background-image: radial-gradient(rgba(255,255,255,0.03) 1px,transparent 1px);
    background-size: 22px 22px; pointer-events:none;
}
.mv-card-inner { position: relative; z-index: 1; }
.mv-icon { width:48px; height:48px; border-radius:12px; background:rgba(255,255,255,0.12); display:flex; align-items:center; justify-content:center; margin-bottom:20px; }
.mv-icon svg { width:22px; height:22px; color:#fff; }
.mv-card h3 { font-size:22px; font-weight:850; color:#fff; margin-bottom:14px; }
.mv-card p { font-size:15px; color:rgba(255,255,255,0.65); line-height:1.8; margin:0; }
/* Services preview */
.about-svc-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
.about-svc-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 14px;
    padding: 24px; text-decoration: none; color: inherit;
    display: flex; flex-direction: column; gap: 10px;
    transition: all 0.28s ease; box-shadow: 0 1px 4px rgba(15,23,42,0.05);
    position: relative; overflow: hidden;
}
.about-svc-card::before {
    content:''; position:absolute; top:0; left:0; right:0; height:2px;
    background:linear-gradient(90deg,#111827,#64748b); opacity:0; transition:opacity 0.28s;
}
.about-svc-card:hover { border-color:#cbd5e1; box-shadow:0 10px 34px rgba(15,23,42,0.1); transform:translateY(-3px); }
.about-svc-card:hover::before { opacity:1; }
.about-svc-card h4 { font-size:15px; font-weight:750; color:#0f172a; margin:0; }
.about-svc-card p { font-size:13px; color:#64748b; margin:0; line-height:1.6; flex-grow:1; }
.about-svc-link { display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; color:#111827; }
.about-svc-link svg { width:13px; height:13px; }
/* Values */
.values-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
.value-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px;
    box-shadow: 0 1px 4px rgba(15,23,42,0.05); transition: all 0.28s ease;
    display: flex; gap: 18px; align-items: flex-start;
}
.value-card:hover { border-color: #cbd5e1; box-shadow: 0 8px 28px rgba(15,23,42,0.08); transform: translateY(-2px); }
.value-icon { width:44px; height:44px; border-radius:10px; background:#f3f4f6; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.value-icon svg { width:20px; height:20px; color:#111827; }
.value-card h4 { font-size:16px; font-weight:750; color:#0f172a; margin-bottom:6px; }
.value-card p { font-size:14px; color:#475569; line-height:1.7; margin:0; }
@media (max-width: 900px) {
    .mv-grid { grid-template-columns: 1fr; }
    .about-svc-grid { grid-template-columns: repeat(2, 1fr); }
    .values-grid { grid-template-columns: 1fr; }
    .about-stats-row { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 600px) {
    .about-svc-grid { grid-template-columns: 1fr; }
    .about-stats-row { grid-template-columns: 1fr; }
}
</style>

<!-- Hero -->
<section class="about-hero">
    <div class="container" style="position:relative;z-index:1;">
        <p class="eyebrow" style="color:#94a3b8;margin-bottom:14px;">About Starmax</p>
        <h2 style="color:#fff;max-width:700px;margin-bottom:16px;font-size:clamp(34px,5vw,56px);">
            A digital-first company building for East Africa.
        </h2>
        <p style="color:rgba(255,255,255,0.58);max-width:580px;font-size:17px;line-height:1.75;">
            We design and deliver web platforms, mobile apps, AI agents, and business software. Based in Nairobi, we turn ideas into production systems for startups, enterprises, and property teams.
        </p>
        <div class="about-stats-row">
            <div class="about-stat"><div class="about-stat-num">2024</div><div class="about-stat-label">Founded in Nairobi</div></div>
            <div class="about-stat"><div class="about-stat-num">50+</div><div class="about-stat-label">Projects delivered</div></div>
            <div class="about-stat"><div class="about-stat-num">6</div><div class="about-stat-label">Service verticals</div></div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<div class="section" style="padding-bottom:0;">
    <div class="mv-grid">
        <article class="mv-card mv-card-mission reveal">
            <div class="mv-card-inner">
                <div class="mv-icon"><i data-lucide="target"></i></div>
                <h3>Our Mission</h3>
                <p>To deliver practical, high-quality digital solutions that help businesses operate more efficiently. We believe great software should be accessible to companies of every size — not just those with Silicon Valley budgets.</p>
            </div>
        </article>
        <article class="mv-card mv-card-vision reveal">
            <div class="mv-card-inner">
                <div class="mv-icon"><i data-lucide="telescope"></i></div>
                <h3>Our Vision</h3>
                <p>To become East Africa's most trusted technology partner — known for clean architecture, honest timelines, and software that actually works in production. We measure success by long-term client relationships, not short-term contracts.</p>
            </div>
        </article>
    </div>
</div>

<!-- What We Do -->
<div class="section">
    <div class="section-header">
        <p class="eyebrow">What We Do</p>
        <h2>Multiple disciplines, one team.</h2>
        <p>We don't just write code — we solve problems. Our services span the full digital product lifecycle.</p>
    </div>
    <div class="about-svc-grid">
        <a href="/services/web-development" class="about-svc-card reveal">
            <div class="card-icon purple"><i data-lucide="globe"></i></div>
            <h4>Web Development</h4>
            <p>Full-stack web applications with Laravel, NestJS, Next.js, and React.</p>
            <span class="about-svc-link">Explore <i data-lucide="arrow-right"></i></span>
        </a>
        <a href="/services/android-apps" class="about-svc-card reveal">
            <div class="card-icon blue"><i data-lucide="smartphone"></i></div>
            <h4>Android Development</h4>
            <p>Native Kotlin applications with Jetpack Compose, Hilt, and Material 3.</p>
            <span class="about-svc-link">Explore <i data-lucide="arrow-right"></i></span>
        </a>
        <a href="/services/ai-automation" class="about-svc-card reveal">
            <div class="card-icon teal"><i data-lucide="bot"></i></div>
            <h4>AI Agents</h4>
            <p>LLM-powered automation, document processing, and intelligent workflow agents.</p>
            <span class="about-svc-link">Explore <i data-lucide="arrow-right"></i></span>
        </a>
        <a href="/services/it-consulting" class="about-svc-card reveal">
            <div class="card-icon orange"><i data-lucide="briefcase"></i></div>
            <h4>IT Consulting</h4>
            <p>Architecture reviews, technology strategy, and transformation guidance.</p>
            <span class="about-svc-link">Explore <i data-lucide="arrow-right"></i></span>
        </a>
        <a href="/services/tenant-management" class="about-svc-card reveal">
            <div class="card-icon emerald"><i data-lucide="building-2"></i></div>
            <h4>Tenant Management</h4>
            <p>Property operations platform with invoicing, maintenance, and self-service.</p>
            <span class="about-svc-link">Explore <i data-lucide="arrow-right"></i></span>
        </a>
        <a href="/services/custom-software" class="about-svc-card reveal">
            <div class="card-icon rose"><i data-lucide="zap"></i></div>
            <h4>Custom Software</h4>
            <p>Bespoke business systems — CRM, booking engines, and integrations.</p>
            <span class="about-svc-link">Explore <i data-lucide="arrow-right"></i></span>
        </a>
    </div>
</div>

<!-- Core Values -->
<div style="background:#f8fafc;border-top:1px solid #e2e8f0;padding:56px 0;">
    <div class="container">
        <div class="section-header" style="margin-bottom:36px;">
            <p class="eyebrow">What Drives Us</p>
            <h2>Core values.</h2>
            <p>The principles behind every decision we make — from architecture choices to client communication.</p>
        </div>
        <div class="values-grid">
            <article class="value-card reveal">
                <div class="value-icon"><i data-lucide="eye"></i></div>
                <div>
                    <h4>Transparency</h4>
                    <p>Clear communication, honest estimates, and auditable deliverables. No black boxes. You always know where your project stands and why.</p>
                </div>
            </article>
            <article class="value-card reveal">
                <div class="value-icon"><i data-lucide="shield-check"></i></div>
                <div>
                    <h4>Reliability</h4>
                    <p>Disciplined timelines, accountable follow-through, and battle-tested deployment practices. We set realistic expectations and meet them.</p>
                </div>
            </article>
            <article class="value-card reveal">
                <div class="value-icon"><i data-lucide="rocket"></i></div>
                <div>
                    <h4>Innovation</h4>
                    <p>We stay current with modern frameworks, AI capabilities, and DevOps practices — then apply them pragmatically where they genuinely help.</p>
                </div>
            </article>
            <article class="value-card reveal">
                <div class="value-icon"><i data-lucide="handshake"></i></div>
                <div>
                    <h4>Integrity</h4>
                    <p>Consistent, fair processes throughout. We recommend what's right for your business, not what's easiest or most profitable for us to build.</p>
                </div>
            </article>
        </div>
    </div>
</div>

<!-- CTA -->
<div class="cta-banner reveal">
    <h2>Want to work with us?</h2>
    <p>We'd love to hear about your project and explore how we can help turn your idea into a production system.</p>
    <div class="cta-actions">
        <a href="/contact" class="btn btn-primary">Get in Touch →</a>
        <a href="/portfolio" class="btn btn-secondary">View our work</a>
    </div>
</div>

@endsection
