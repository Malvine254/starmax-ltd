@extends('site.layout')

@section('title', $current['title'] . ' — Starmax Ltd')

@section('content')
<style>
.sd-hero {
    padding: 72px 0 56px;
    position: relative;
    overflow: hidden;
    color: #fff;
}
.sd-hero::after {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(255,255,255,0.04) 1px, transparent 1px);
    background-size: 28px 28px;
    pointer-events: none;
}
.sd-hero-inner { position: relative; z-index: 1; }
.sd-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22);
    color: rgba(255,255,255,0.85); font-size: 11px; font-weight: 700;
    letter-spacing: 0.08em; text-transform: uppercase;
    padding: 5px 14px; border-radius: 999px; margin-bottom: 22px;
}
.sd-badge svg { width: 13px; height: 13px; }
.sd-hero h1 {
    font-size: clamp(34px, 5vw, 58px); font-weight: 850; color: #fff;
    line-height: 1.08; margin-bottom: 18px; max-width: 720px;
}
.sd-hero-desc {
    font-size: 17px; color: rgba(255,255,255,0.65); line-height: 1.75;
    max-width: 600px; margin-bottom: 36px;
}
.sd-hero-actions { display: flex; flex-wrap: wrap; gap: 12px; }
.sd-breadcrumb {
    display: flex; align-items: center; gap: 8px;
    font-size: 13px; color: rgba(255,255,255,0.45); margin-bottom: 28px;
}
.sd-breadcrumb a { color: rgba(255,255,255,0.45); text-decoration: none; transition: color 0.2s; }
.sd-breadcrumb a:hover { color: rgba(255,255,255,0.8); }
.sd-breadcrumb svg { width: 14px; height: 14px; }

/* Features grid */
.sd-features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}
.sd-feature {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 24px;
    transition: all 0.28s ease;
    box-shadow: 0 1px 4px rgba(15,23,42,0.06);
}
.sd-feature:hover {
    border-color: #cbd5e1;
    box-shadow: 0 8px 28px rgba(15,23,42,0.08);
    transform: translateY(-3px);
}
.sd-feature-icon {
    width: 42px; height: 42px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    background: #f3f4f6; color: #111827; margin-bottom: 14px;
}
.sd-feature-icon svg { width: 20px; height: 20px; }
.sd-feature h4 { font-size: 15px; font-weight: 750; color: #0f172a; margin-bottom: 6px; }
.sd-feature p { font-size: 13px; color: #64748b; line-height: 1.65; margin: 0; }

/* Tech stack */
.sd-tech-cloud { display: flex; flex-wrap: wrap; gap: 10px; }
.sd-tech-badge {
    display: inline-flex; align-items: center; gap: 7px;
    background: #f8fafc; border: 1px solid #e2e8f0;
    color: #374151; font-size: 13px; font-weight: 600;
    padding: 8px 16px; border-radius: 999px;
    transition: all 0.2s ease;
}
.sd-tech-badge:hover { background: #111827; color: #fff; border-color: #111827; }

/* Deliverables */
.sd-deliverables {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}
.sd-deliverable {
    display: flex; align-items: center; gap: 10px;
    font-size: 14px; font-weight: 500; color: #374151;
    background: #f9fafb; border: 1px solid #e5e7eb;
    border-radius: 10px; padding: 13px 16px;
    transition: all 0.2s ease;
}
.sd-deliverable:hover { background: #fff; border-color: #cbd5e1; box-shadow: 0 2px 12px rgba(15,23,42,0.06); }
.sd-deliverable svg { width: 16px; height: 16px; color: #10b981; flex-shrink: 0; }

/* Other services */
.sd-other-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}
.sd-other-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 14px;
    padding: 24px; text-decoration: none; color: inherit;
    display: flex; flex-direction: column; gap: 10px;
    transition: all 0.28s ease; box-shadow: 0 1px 4px rgba(15,23,42,0.06);
    position: relative; overflow: hidden;
}
.sd-other-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, #111827, #64748b); opacity: 0; transition: opacity 0.28s;
}
.sd-other-card:hover { border-color: #cbd5e1; box-shadow: 0 8px 28px rgba(15,23,42,0.1); transform: translateY(-3px); }
.sd-other-card:hover::before { opacity: 1; }
.sd-other-card h4 { font-size: 15px; font-weight: 750; color: #0f172a; margin: 0; }
.sd-other-card p { font-size: 13px; color: #64748b; margin: 0; line-height: 1.6; flex-grow: 1; }
.sd-other-link { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 700; color: #111827; margin-top: 4px; }
.sd-other-link svg { width: 13px; height: 13px; }

.sd-section { width: min(calc(100% - (var(--page-gutter) * 2)), var(--max-w)); margin: 0 auto; padding: 48px 0; }
.sd-section-label { font-size: 11px; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; color: #94a3b8; margin-bottom: 10px; }
.sd-section-title { font-size: clamp(24px, 3vw, 36px); font-weight: 850; color: #0f172a; margin-bottom: 8px; }
.sd-section-desc { font-size: 15px; color: #64748b; max-width: 560px; margin-bottom: 32px; line-height: 1.7; }

@media (max-width: 1024px) {
    .sd-features-grid { grid-template-columns: repeat(2, 1fr); }
    .sd-other-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .sd-features-grid { grid-template-columns: 1fr; }
    .sd-deliverables { grid-template-columns: 1fr; }
    .sd-other-grid { grid-template-columns: 1fr; }
    .sd-hero { padding: 52px 0 40px; }
}
</style>

<!-- Hero -->
<section class="sd-hero" style="background: {{ $current['gradient'] }}">
    <div class="container sd-hero-inner">
        <div class="sd-breadcrumb">
            <a href="/services">Services</a>
            <i data-lucide="chevron-right"></i>
            <span>{{ $current['title'] }}</span>
        </div>
        @if(isset($current['badge']))
            <div class="sd-badge"><i data-lucide="star"></i> {{ $current['badge'] }}</div>
        @else
            <div class="sd-badge"><i data-lucide="{{ $current['icon'] }}"></i> {{ $current['category'] }}</div>
        @endif
        <h1>{{ $current['title'] }}</h1>
        <p class="sd-hero-desc">{{ $current['tagline'] }}</p>
        <div class="sd-hero-actions">
            <a href="/contact" class="btn btn-white">Get a Quote <i data-lucide="arrow-right"></i></a>
            <a href="/portfolio" class="btn btn-ghost">See our work</a>
        </div>
    </div>
</section>

<!-- Overview -->
<div class="sd-section" style="padding-bottom:0;">
    <div style="display:grid;grid-template-columns:1.3fr 1fr;gap:56px;align-items:start;">
        <div>
            <p class="sd-section-label">Overview</p>
            <h2 class="sd-section-title">What we do</h2>
            <p style="font-size:16px;color:#374151;line-height:1.8;margin-bottom:24px;">{{ $current['description'] }}</p>
            <a href="/contact" class="btn btn-primary">Start a project →</a>
        </div>
        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:16px;padding:28px;">
            <p style="font-size:11px;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#94a3b8;margin-bottom:16px;">What you get</p>
            <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;">
                @foreach($current['deliverables'] as $item)
                <li style="display:flex;align-items:center;gap:10px;font-size:14px;font-weight:500;color:#374151;">
                    <span style="width:20px;height:20px;border-radius:50%;background:#d1fae5;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i data-lucide="check" style="width:11px;height:11px;color:#059669;"></i>
                    </span>
                    {{ $item }}
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<!-- Features -->
<div class="sd-section">
    <p class="sd-section-label">Capabilities</p>
    <h2 class="sd-section-title">What we deliver</h2>
    <p class="sd-section-desc">Every engagement includes these core capabilities tailored to your context and requirements.</p>
    <div class="sd-features-grid">
        @foreach($current['features'] as $feature)
        <div class="sd-feature reveal">
            <div class="sd-feature-icon"><i data-lucide="{{ $feature['icon'] }}"></i></div>
            <h4>{{ $feature['title'] }}</h4>
            <p>{{ $feature['desc'] }}</p>
        </div>
        @endforeach
    </div>
</div>

<!-- Tech Stack -->
<div style="background:#0f172a;padding:52px 0;">
    <div class="container">
        <p style="font-size:11px;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#475569;margin-bottom:10px;">Technologies</p>
        <h2 style="font-size:clamp(22px,3vw,32px);font-weight:850;color:#fff;margin-bottom:8px;">Built with proven tools</h2>
        <p style="font-size:15px;color:#64748b;margin-bottom:32px;max-width:500px;line-height:1.7;">We use battle-tested technologies chosen for reliability, performance, and long-term maintainability.</p>
        <div class="sd-tech-cloud">
            @foreach($current['tech'] as $tech)
            <span class="sd-tech-badge">{{ $tech }}</span>
            @endforeach
        </div>
    </div>
</div>

<!-- Process -->
<div class="sd-section">
    <p class="sd-section-label">Our Approach</p>
    <h2 class="sd-section-title">How we work</h2>
    <p class="sd-section-desc">A structured, transparent process from first call to production deployment.</p>
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
        @php
        $steps = [
            ['num'=>'01','icon'=>'search','title'=>'Discovery','desc'=>'We understand your goals, users, and constraints before proposing any solution.'],
            ['num'=>'02','icon'=>'pen-tool','title'=>'Design','desc'=>'Architecture, wireframes, and a clear plan — reviewed and signed off before we build.'],
            ['num'=>'03','icon'=>'code-2','title'=>'Build','desc'=>'Iterative development with demos and feedback at every milestone.'],
            ['num'=>'04','icon'=>'rocket','title'=>'Launch','desc'=>'Production deployment, monitoring, and post-launch support included.'],
        ];
        @endphp
        @foreach($steps as $step)
        <div class="reveal" style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:24px 20px;text-align:center;box-shadow:0 1px 4px rgba(15,23,42,0.06);">
            <div style="font-size:11px;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#94a3b8;margin-bottom:16px;">{{ $step['num'] }}</div>
            <div class="card-icon purple" style="margin:0 auto 14px;"><i data-lucide="{{ $step['icon'] }}"></i></div>
            <h4 style="margin-bottom:6px;font-size:15px;">{{ $step['title'] }}</h4>
            <p style="font-size:13px;color:#64748b;margin:0;line-height:1.65;">{{ $step['desc'] }}</p>
        </div>
        @endforeach
    </div>
</div>

<!-- Other Services -->
@if(count($others) > 0)
<div style="background:#f8fafc;border-top:1px solid #e2e8f0;padding:52px 0;">
    <div class="container">
        <p style="font-size:11px;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;color:#94a3b8;margin-bottom:10px;">Explore more</p>
        <h2 style="font-size:clamp(22px,3vw,32px);font-weight:850;color:#0f172a;margin-bottom:32px;">Other services</h2>
        <div class="sd-other-grid">
            @foreach($others as $other)
            <a href="/services/{{ $other['slug'] }}" class="sd-other-card">
                <div class="card-icon {{ $other['color'] }}"><i data-lucide="{{ $other['icon'] }}"></i></div>
                <h4>{{ $other['title'] }}</h4>
                <p>{{ $other['tagline'] }}</p>
                <span class="sd-other-link">Explore <i data-lucide="arrow-right"></i></span>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- CTA -->
<div class="cta-banner reveal">
    <h2>Ready to get started?</h2>
    <p>Tell us about your project and we'll put together a plan that works for your team and budget.</p>
    <div class="cta-actions">
        <a href="/contact" class="btn btn-primary">Get a Free Consultation →</a>
        <a href="/services" class="btn btn-secondary">Browse all services</a>
    </div>
</div>

@endsection
