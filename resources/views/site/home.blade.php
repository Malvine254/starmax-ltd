@extends('site.layout')

@section('title', 'Starmax Ltd - Digital Product Studio')

@section('content')
<style>
/* Landing page redesign scoped to this file */
.nx-landing {
    --nx-ink: #0b1220;
    --nx-muted: #4b5563;
    --nx-soft: #f3f7fb;
    --nx-line: #dbe5f0;
    --nx-card: #ffffff;
    --nx-brand: #0f2a44;
    --nx-brand-2: #12476f;
    --nx-gold: #ca9358;
    --nx-teal: #0e8a7f;
}

.nx-hero {
    position: relative;
    isolation: isolate;
    overflow: hidden;
    min-height: min(86vh, 860px);
    background: linear-gradient(125deg, #061525 0%, #0d2c45 52%, #124f69 100%);
}
.nx-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 18% 18%, rgba(255,255,255,0.14), transparent 34%), radial-gradient(circle at 84% 22%, rgba(202,147,88,0.23), transparent 32%);
}
.nx-hero-grid {
    position: relative;
    z-index: 2;
    width: min(calc(100% - (var(--page-gutter) * 2)), var(--max-w));
    margin: 0 auto;
    padding: 84px 0 76px;
    display: grid;
    grid-template-columns: 1.04fr 0.96fr;
    gap: 36px;
    align-items: center;
}
.nx-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #ecf4ff;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    margin-bottom: 16px;
}
.nx-hero h1 {
    font-size: clamp(38px, 6.2vw, 70px);
    line-height: 0.98;
    letter-spacing: -0.02em;
    color: #f8fbff;
    margin-bottom: 16px;
}
.nx-hero p {
    color: rgba(235,245,255,0.82);
    font-size: 18px;
    max-width: 620px;
}
.nx-hero-actions {
    margin-top: 30px;
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}
.nx-hero-actions .btn-primary {
    background: #f8fbff;
    color: #0f2a44;
    border: 1px solid #f8fbff;
}
.nx-hero-actions .btn-secondary {
    background: transparent;
    border: 1px solid rgba(248,251,255,0.55);
    color: #f8fbff;
}

.nx-hero-media {
    position: relative;
    border-radius: 28px;
    overflow: hidden;
    min-height: 420px;
    border: 1px solid rgba(255,255,255,0.2);
    box-shadow: 0 24px 60px rgba(4,12,20,0.35);
}
.nx-hero-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.nx-hero-media::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(6,16,25,0.62) 0%, rgba(6,16,25,0.04) 58%);
}
.nx-metric-cards {
    position: absolute;
    left: 18px;
    right: 18px;
    bottom: 18px;
    z-index: 2;
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 10px;
}
.nx-metric {
    background: rgba(6,19,30,0.78);
    border: 1px solid rgba(248,251,255,0.2);
    border-radius: 12px;
    padding: 10px;
}
.nx-metric strong {
    display: block;
    color: #fff;
    font-size: 19px;
    line-height: 1;
}
.nx-metric span {
    display: block;
    margin-top: 4px;
    color: rgba(236,245,255,0.82);
    font-size: 11px;
    line-height: 1.3;
}

.nx-proof {
    background: #fff;
    border-bottom: 1px solid var(--nx-line);
}
.nx-proof-inner {
    width: min(calc(100% - (var(--page-gutter) * 2)), var(--max-w));
    margin: 0 auto;
    padding: 18px 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    flex-wrap: wrap;
}
.nx-proof b {
    color: var(--nx-ink);
}
.nx-proof span {
    color: var(--nx-muted);
    font-size: 14px;
}

.nx-section {
    width: min(calc(100% - (var(--page-gutter) * 2)), var(--max-w));
    margin: 0 auto;
    padding: 72px 0;
}
.nx-head {
    margin-bottom: 30px;
}
.nx-kicker {
    color: var(--nx-teal);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.11em;
    text-transform: uppercase;
    margin-bottom: 8px;
}
.nx-title {
    font-size: clamp(28px, 4vw, 46px);
    line-height: 1.08;
    letter-spacing: -0.02em;
    color: var(--nx-ink);
    margin-bottom: 10px;
}
.nx-desc {
    color: var(--nx-muted);
    max-width: 700px;
}

.nx-solutions {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 18px;
}
.nx-card {
    background: var(--nx-card);
    border: 1px solid var(--nx-line);
    border-radius: 18px;
    padding: 22px;
    box-shadow: 0 6px 20px rgba(11, 18, 32, 0.05);
    transition: transform .25s ease, box-shadow .25s ease;
}
.nx-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 32px rgba(11, 18, 32, 0.1);
}
.nx-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #edf4fb;
    color: var(--nx-brand-2);
    margin-bottom: 14px;
}
.nx-icon svg { width: 20px; height: 20px; }
.nx-card h3 {
    color: var(--nx-ink);
    font-size: 19px;
    margin-bottom: 8px;
}
.nx-card p {
    color: var(--nx-muted);
    font-size: 14px;
}
.nx-card ul {
    margin-top: 12px;
    display: grid;
    gap: 7px;
}
.nx-card li {
    color: var(--nx-muted);
    font-size: 13px;
    padding-left: 14px;
    position: relative;
}
.nx-card li::before {
    content: '';
    position: absolute;
    left: 0;
    top: 8px;
    width: 5px;
    height: 5px;
    border-radius: 999px;
    background: var(--nx-gold);
}

.nx-process {
    background: linear-gradient(180deg, #f4f9ff 0%, #ffffff 100%);
    border-top: 1px solid var(--nx-line);
    border-bottom: 1px solid var(--nx-line);
}
.nx-steps {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 14px;
}
.nx-step {
    background: #fff;
    border: 1px solid var(--nx-line);
    border-radius: 14px;
    padding: 16px;
}
.nx-step .num {
    width: 26px;
    height: 26px;
    border-radius: 999px;
    background: var(--nx-brand);
    color: #fff;
    font-size: 12px;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 8px;
}
.nx-step h4 { margin-bottom: 5px; color: var(--nx-ink); font-size: 15px; }
.nx-step p { color: var(--nx-muted); font-size: 13px; }

.nx-feature {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    align-items: center;
}
.nx-feature-media {
    border-radius: 22px;
    overflow: hidden;
    border: 1px solid var(--nx-line);
    min-height: 360px;
    box-shadow: 0 14px 36px rgba(15, 42, 68, 0.12);
}
.nx-feature-media img { width: 100%; height: 100%; object-fit: cover; }
.nx-feature-copy .pill {
    display: inline-flex;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.09em;
    text-transform: uppercase;
    color: var(--nx-brand-2);
    background: #e8f1fb;
    padding: 5px 10px;
    border-radius: 999px;
    margin-bottom: 12px;
}
.nx-feature-copy h3 {
    font-size: clamp(24px, 3vw, 34px);
    color: var(--nx-ink);
    line-height: 1.13;
    margin-bottom: 12px;
}
.nx-feature-copy p { color: var(--nx-muted); margin-bottom: 14px; }

.nx-cta {
    border-radius: 24px;
    padding: 44px;
    background: linear-gradient(130deg, #0d2b42 0%, #0f4f63 56%, #12756f 100%);
    color: #eef7ff;
    text-align: center;
    border: 1px solid rgba(255,255,255,0.18);
    box-shadow: 0 20px 54px rgba(6, 18, 30, 0.28);
}
.nx-cta h3 {
    font-size: clamp(28px, 4vw, 46px);
    line-height: 1.06;
    margin-bottom: 10px;
    color: #fff;
}
.nx-cta p { color: rgba(235,245,255,0.86); max-width: 680px; margin: 0 auto 20px; }
.nx-cta .btn {
    background: #fff;
    color: #0f2a44;
    border: 1px solid #fff;
}

@media (max-width: 980px) {
    .nx-hero-grid,
    .nx-feature {
        grid-template-columns: 1fr;
    }
    .nx-solutions {
        grid-template-columns: 1fr 1fr;
    }
    .nx-steps {
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 680px) {
    .nx-solutions,
    .nx-steps {
        grid-template-columns: 1fr;
    }
    .nx-hero-grid {
        padding: 66px 0 54px;
    }
    .nx-hero p {
        font-size: 16px;
    }
    .nx-hero-media {
        min-height: 330px;
    }
    .nx-metric-cards {
        grid-template-columns: 1fr;
        left: 14px;
        right: 14px;
    }
    .nx-cta {
        padding: 30px 20px;
    }
}
</style>

<div class="nx-landing">
    <section class="nx-hero">
        <div class="nx-hero-grid">
            <div>
                <span class="nx-chip"><i data-lucide="sparkles"></i> Digital Product Studio</span>
                <h1>From concept to launch-ready software without the chaos.</h1>
                <p>Starmax helps ambitious teams build web platforms, Android apps, and AI-assisted workflows with clear scope, rapid delivery, and production-grade engineering.</p>
                <div class="nx-hero-actions">
                    <a href="/contact" class="btn btn-primary">Start Your Project <i data-lucide="arrow-right"></i></a>
                    <a href="/portfolio" class="btn btn-secondary">See Recent Work</a>
                </div>
            </div>
            <div class="nx-hero-media">
                <img src="{{ asset('images/landing-hero-team.png') }}" alt="Starmax team collaborating on product strategy">
                <div class="nx-metric-cards">
                    <div class="nx-metric">
                        <strong>50+</strong>
                        <span>Projects shipped</span>
                    </div>
                    <div class="nx-metric">
                        <strong>6</strong>
                        <span>Core service tracks</span>
                    </div>
                    <div class="nx-metric">
                        <strong>24/7</strong>
                        <span>Post-launch support</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="nx-proof">
        <div class="nx-proof-inner">
            <span><b>Trusted by:</b> founders, property teams, and operations leaders</span>
            <span>Web platforms</span>
            <span>Android delivery</span>
            <span>AI automation</span>
            <span>Long-term support</span>
        </div>
    </section>

    <section class="nx-section">
        <div class="nx-head">
            <p class="nx-kicker">What We Build</p>
            <h2 class="nx-title">High-impact digital systems that teams can actually use every day.</h2>
            <p class="nx-desc">We focus on practical outcomes: faster operations, cleaner user journeys, and software that scales as your business grows.</p>
        </div>
        <div class="nx-solutions">
            <article class="nx-card reveal">
                <div class="nx-icon"><i data-lucide="layout-dashboard"></i></div>
                <h3>Web Platforms</h3>
                <p>Custom systems for operations, dashboards, and customer workflows.</p>
                <ul>
                    <li>Admin portals and internal tools</li>
                    <li>Secure API architecture</li>
                    <li>Analytics and workflow automation</li>
                </ul>
            </article>
            <article class="nx-card reveal">
                <div class="nx-icon"><i data-lucide="smartphone"></i></div>
                <h3>Android Apps</h3>
                <p>Native Kotlin apps designed for reliability and smooth performance.</p>
                <ul>
                    <li>Offline-first behavior</li>
                    <li>Push notifications and real-time sync</li>
                    <li>Production-ready release pipeline</li>
                </ul>
            </article>
            <article class="nx-card reveal">
                <div class="nx-icon"><i data-lucide="bot"></i></div>
                <h3>AI Workflow Automation</h3>
                <p>AI assistants that reduce repetitive work and speed up decisions.</p>
                <ul>
                    <li>Knowledge-aware assistants</li>
                    <li>Document extraction and routing</li>
                    <li>Human-in-the-loop controls</li>
                </ul>
            </article>
        </div>
    </section>

    <section class="nx-process">
        <div class="nx-section" style="padding-top:58px;padding-bottom:58px;">
            <div class="nx-head" style="margin-bottom:22px;">
                <p class="nx-kicker">How We Work</p>
                <h2 class="nx-title">A clear process from first call to stable launch.</h2>
            </div>
            <div class="nx-steps">
                <article class="nx-step reveal">
                    <span class="num">1</span>
                    <h4>Discovery</h4>
                    <p>We align on goals, users, scope, timeline, and measurable outcomes.</p>
                </article>
                <article class="nx-step reveal">
                    <span class="num">2</span>
                    <h4>Blueprint</h4>
                    <p>Architecture, UX direction, milestones, and implementation plan.</p>
                </article>
                <article class="nx-step reveal">
                    <span class="num">3</span>
                    <h4>Build</h4>
                    <p>Agile delivery with frequent demos, testing, and quality checkpoints.</p>
                </article>
                <article class="nx-step reveal">
                    <span class="num">4</span>
                    <h4>Launch + Support</h4>
                    <p>Deployment, monitoring, iteration, and post-launch improvements.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="nx-section">
        <div class="nx-feature">
            <div class="nx-feature-media reveal">
                <img src="{{ asset('images/landing-web-platform.png') }}" alt="Modern product dashboard built by Starmax">
            </div>
            <div class="nx-feature-copy reveal">
                <span class="pill">Flagship Product</span>
                <h3>TenantPro streamlines property operations end to end.</h3>
                <p>From invoice generation and maintenance requests to tenant communication and analytics, TenantPro helps teams run portfolios with less manual overhead.</p>
                <div class="stack">
                    <a href="/products" class="btn btn-primary">Explore TenantPro <i data-lucide="arrow-up-right"></i></a>
                    <a href="/events" class="btn btn-secondary">Book a Live Demo</a>
                </div>
            </div>
        </div>
    </section>

    <section class="nx-section" style="padding-top:8px;">
        <div class="nx-cta reveal">
            <h3>Need to launch quickly without cutting quality?</h3>
            <p>Share your goal and constraints. We will map the fastest realistic path to production and help your team execute with confidence.</p>
            <a href="/contact" class="btn">Talk to Starmax</a>
        </div>
    </section>
</div>
@endsection
