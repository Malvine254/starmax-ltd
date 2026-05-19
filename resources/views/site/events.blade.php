@extends('site.layout')

@section('title', 'Events — Starmax Ltd')

@section('content')
<style>
/* ── EVENTS PAGE ── */
.ev-hero {
    background: linear-gradient(150deg,#0f172a 0%,#1e293b 55%,#111827 100%);
    padding: 68px 0 52px; position: relative; overflow: hidden;
}
.ev-hero::after {
    content:''; position:absolute; inset:0;
    background-image: radial-gradient(rgba(255,255,255,0.035) 1px,transparent 1px);
    background-size: 30px 30px; pointer-events:none;
}
.ev-hero-stats {
    display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; margin-top: 40px;
}
.ev-stat {
    background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
    border-radius: 14px; padding: 20px 22px;
}
.ev-stat-num { font-size: 34px; font-weight: 850; color: #fff; line-height: 1; }
.ev-stat-label { font-size: 12px; color: rgba(255,255,255,0.45); margin-top: 5px; line-height: 1.4; }

/* Format badge */
.ev-format {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 999px;
}
.ev-format-online   { background:#dbeafe; color:#1d4ed8; }
.ev-format-inperson { background:#d1fae5; color:#065f46; }
.ev-format-hybrid   { background:#f3e8ff; color:#7e22ce; }
.ev-format-default  { background:#f1f5f9; color:#475569; }

/* Category badge */
.ev-cat {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 11px; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase;
    padding: 3px 10px; border-radius: 999px; background:#f3f4f6; color:#374151;
}

/* Featured event card */
.ev-featured-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 24px; }
.ev-featured-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 20px;
    overflow: hidden; box-shadow: 0 4px 24px rgba(15,23,42,0.08);
    display: flex; flex-direction: column; transition: all 0.3s ease;
}
.ev-featured-card:hover { box-shadow: 0 16px 52px rgba(15,23,42,0.13); transform: translateY(-4px); }
.ev-featured-card-header {
    background: linear-gradient(135deg,#0f172a 0%,#1e293b 100%);
    padding: 28px 28px 24px; position: relative; overflow: hidden;
    display: flex; gap: 20px; align-items: flex-start;
}
.ev-featured-card-header::after {
    content:''; position:absolute; inset:0;
    background-image: radial-gradient(rgba(255,255,255,0.04) 1px,transparent 1px);
    background-size: 20px 20px; pointer-events:none;
}
.ev-date-box {
    flex-shrink: 0; width: 64px; height: 64px; border-radius: 12px;
    background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.18);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    position: relative; z-index: 1;
}
.ev-date-box .day  { font-size: 26px; font-weight: 850; color: #fff; line-height: 1; }
.ev-date-box .mon  { font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-top: 2px; }
.ev-featured-header-meta { position: relative; z-index: 1; flex: 1; }
.ev-featured-header-meta h3 { font-size: 20px; font-weight: 850; color: #fff; margin: 10px 0 8px; line-height: 1.25; }
.ev-featured-header-meta p { font-size: 13px; color: rgba(255,255,255,0.55); line-height: 1.65; margin: 0; }
.ev-featured-card-body { padding: 22px 28px 28px; flex: 1; display: flex; flex-direction: column; gap: 16px; }
.ev-detail-row { display: flex; flex-wrap: wrap; gap: 14px; }
.ev-detail-item { display: flex; align-items: center; gap: 6px; font-size: 13px; color: #64748b; font-weight: 500; }
.ev-detail-item svg { width: 14px; height: 14px; color: #94a3b8; flex-shrink: 0; }

/* Schedule card grid */
.ev-schedule-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; }
.ev-schedule-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 16px;
    overflow: hidden; box-shadow: 0 1px 4px rgba(15,23,42,0.05);
    display: flex; flex-direction: column; transition: all 0.28s ease;
}
.ev-schedule-card:hover { border-color: #cbd5e1; box-shadow: 0 10px 36px rgba(15,23,42,0.1); transform: translateY(-3px); }
.ev-schedule-card-top {
    display: flex; gap: 16px; align-items: flex-start; padding: 20px 20px 16px;
}
.ev-small-date {
    flex-shrink: 0; width: 52px; height: 52px; border-radius: 10px;
    background: #0f172a; display: flex; flex-direction: column;
    align-items: center; justify-content: center;
}
.ev-small-date .day  { font-size: 20px; font-weight: 850; color: #fff; line-height: 1; }
.ev-small-date .mon  { font-size: 10px; font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase; color: rgba(255,255,255,0.55); }
.ev-schedule-card-info { flex: 1; min-width: 0; }
.ev-schedule-card-info h4 { font-size: 15px; font-weight: 750; color: #0f172a; margin-bottom: 6px; line-height: 1.3; }
.ev-schedule-card-info p { font-size: 13px; color: #64748b; line-height: 1.6; margin: 0; }
.ev-schedule-card-bottom {
    padding: 12px 20px 18px; border-top: 1px solid #f1f5f9;
    background: #fafbff; display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap;
}
.ev-schedule-detail { display: flex; align-items: center; gap: 5px; font-size: 12px; color: #94a3b8; font-weight: 500; }
.ev-schedule-detail svg { width: 12px; height: 12px; }
.ev-cta-pill {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 12px; font-weight: 700; color: #111827; text-decoration: none;
    background: #f1f5f9; border: 1px solid #e2e8f0; padding: 6px 12px; border-radius: 999px;
    transition: all 0.2s ease; white-space: nowrap;
}
.ev-cta-pill:hover { background: #111827; color: #fff; border-color: #111827; }
.ev-cta-pill svg { width: 12px; height: 12px; }

/* Format cards */
.ev-formats-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; }
.ev-format-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px;
    box-shadow: 0 1px 4px rgba(15,23,42,0.05); transition: all 0.28s ease;
    display: flex; align-items: flex-start; gap: 16px;
}
.ev-format-card:hover { border-color: #cbd5e1; box-shadow: 0 8px 28px rgba(15,23,42,0.08); transform: translateY(-3px); }
.ev-format-icon { width: 44px; height: 44px; border-radius: 10px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.ev-format-icon svg { width: 20px; height: 20px; color: #111827; }
.ev-format-card h4 { font-size: 15px; font-weight: 750; color: #0f172a; margin-bottom: 6px; }
.ev-format-card p { font-size: 13px; color: #64748b; line-height: 1.65; margin: 0; }

/* Empty state */
.ev-empty {
    text-align: center; padding: 60px 24px;
    background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 16px;
}
.ev-empty svg { width: 48px; height: 48px; color: #cbd5e1; margin: 0 auto 16px; display: block; }
.ev-empty h3 { font-size: 18px; color: #374151; margin-bottom: 8px; }
.ev-empty p { font-size: 14px; color: #94a3b8; }

@media (max-width: 1024px) { .ev-schedule-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 900px)  { .ev-featured-grid { grid-template-columns: 1fr; } .ev-formats-grid { grid-template-columns: 1fr; } }
@media (max-width: 640px)  { .ev-schedule-grid { grid-template-columns: 1fr; } .ev-hero-stats { grid-template-columns: 1fr; } }
</style>

@php
function evFormatClass(string $fmt): string {
    return match(strtolower($fmt)) {
        'online'             => 'ev-format-online',
        'in-person','in person' => 'ev-format-inperson',
        'hybrid'             => 'ev-format-hybrid',
        default              => 'ev-format-default',
    };
}
@endphp

<!-- Hero -->
<section class="ev-hero">
    <div class="container" style="position:relative;z-index:1;">
        <p class="eyebrow" style="color:#94a3b8;margin-bottom:14px;">Events</p>
        <h2 style="color:#fff;max-width:680px;margin-bottom:16px;font-size:clamp(34px,5vw,56px);">
            Workshops, launches, and technology sessions.
        </h2>
        <p style="color:rgba(255,255,255,0.58);max-width:560px;font-size:17px;margin-bottom:36px;line-height:1.75;">
            Meet the Starmax team at product demos, developer workshops, and business technology sessions focused on practical digital transformation.
        </p>
        <div style="display:flex;flex-wrap:wrap;gap:12px;margin-bottom:44px;">
            <a href="#schedule" class="btn btn-white"><i data-lucide="calendar"></i> View Schedule</a>
            <a href="/contact" class="btn btn-ghost">Request Private Demo</a>
        </div>
        <div class="ev-hero-stats">
            <div class="ev-stat">
                <div class="ev-stat-num">{{ $eventStats['upcoming'] }}</div>
                <div class="ev-stat-label">Upcoming events</div>
            </div>
            <div class="ev-stat">
                <div class="ev-stat-num">{{ $eventStats['formats'] }}</div>
                <div class="ev-stat-label">Event formats</div>
            </div>
            <div class="ev-stat">
                <div class="ev-stat-num">{{ $eventStats['next_month'] }}</div>
                <div class="ev-stat-label">Next available session</div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Events -->
@if($featuredEvents->isNotEmpty())
<div class="section" style="padding-bottom:0;">
    <div class="section-header left" style="text-align:left;margin:0 0 28px;">
        <p class="eyebrow">Featured</p>
        <h2 style="margin-bottom:8px;">Start with these sessions.</h2>
        <p style="max-width:540px;">High-value events for teams planning property platforms, AI workflows, and modern operational systems.</p>
    </div>
    <div class="ev-featured-grid">
        @foreach($featuredEvents as $event)
        <article class="ev-featured-card reveal">
            <div class="ev-featured-card-header">
                <div class="ev-date-box">
                    <span class="day">{{ $event->starts_at->format('d') }}</span>
                    <span class="mon">{{ $event->starts_at->format('M') }}</span>
                </div>
                <div class="ev-featured-header-meta">
                    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:2px;">
                        <span class="ev-cat">{{ $event->category }}</span>
                        @if($event->format)
                            <span class="ev-format {{ evFormatClass($event->format) }}">{{ $event->format }}</span>
                        @endif
                    </div>
                    <h3>{{ $event->title }}</h3>
                    <p>{{ $event->excerpt }}</p>
                </div>
            </div>
            <div class="ev-featured-card-body">
                <div class="ev-detail-row">
                    <span class="ev-detail-item"><i data-lucide="map-pin"></i>{{ $event->location }}</span>
                    <span class="ev-detail-item"><i data-lucide="clock"></i>{{ $event->starts_at->format('g:i A') }} EAT</span>
                    @if($event->ends_at)
                    <span class="ev-detail-item"><i data-lucide="timer"></i>{{ $event->starts_at->diffInMinutes($event->ends_at) }} min</span>
                    @endif
                </div>
                <p style="font-size:14px;color:#374151;line-height:1.7;margin:0;">{{ $event->description }}</p>
                <div>
                    <a href="{{ $event->cta_url }}" class="btn btn-primary">{{ $event->cta_label }} <i data-lucide="arrow-right"></i></a>
                </div>
            </div>
        </article>
        @endforeach
    </div>
</div>
@endif

<!-- Full Schedule -->
<div class="section" id="schedule">
    <div class="section-header left" style="text-align:left;margin:0 0 28px;">
        <p class="eyebrow">Schedule</p>
        <h2 style="margin-bottom:8px;">All upcoming events.</h2>
        <p style="max-width:540px;">A database-backed calendar of demos, workshops, clinics, and strategy sessions — updated regularly.</p>
    </div>

    @if($events->isEmpty())
    <div class="ev-empty">
        <i data-lucide="calendar-off"></i>
        <h3>No upcoming events</h3>
        <p>New sessions will appear here as soon as they are published.</p>
    </div>
    @else
    <div class="ev-schedule-grid">
        @foreach($events as $event)
        <article class="ev-schedule-card reveal">
            <div class="ev-schedule-card-top">
                <div class="ev-small-date">
                    <span class="day">{{ $event->starts_at->format('d') }}</span>
                    <span class="mon">{{ $event->starts_at->format('M') }}</span>
                </div>
                <div class="ev-schedule-card-info">
                    <div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:8px;">
                        <span class="ev-cat" style="font-size:10px;">{{ $event->category }}</span>
                        @if($event->format)
                            <span class="ev-format {{ evFormatClass($event->format) }}">{{ $event->format }}</span>
                        @endif
                    </div>
                    <h4>{{ $event->title }}</h4>
                    <p>{{ $event->excerpt }}</p>
                </div>
            </div>
            <div class="ev-schedule-card-bottom">
                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <span class="ev-schedule-detail"><i data-lucide="clock"></i>{{ $event->starts_at->format('g:i A') }}</span>
                    <span class="ev-schedule-detail"><i data-lucide="map-pin"></i>{{ Str::limit($event->location, 28) }}</span>
                </div>
                <a href="{{ $event->cta_url }}" class="ev-cta-pill">
                    {{ $event->cta_label }} <i data-lucide="arrow-right"></i>
                </a>
            </div>
        </article>
        @endforeach
    </div>
    @endif
</div>

<!-- Dark strip: format types -->
<div style="background:#0f172a;padding:52px 0;">
    <div class="container">
        <div class="section-header" style="text-align:left;margin:0 0 32px;">
            <p class="eyebrow" style="color:#475569;">Event Formats</p>
            <h2 style="color:#fff;margin-bottom:8px;">What we host.</h2>
            <p style="color:#64748b;max-width:500px;">
                @if($categories->isNotEmpty())
                    Currently hosting: {{ $categories->join(', ', ' and ') }}.
                @else
                    Sessions for every stage — from idea to production.
                @endif
            </p>
        </div>
        <div class="ev-formats-grid">
            <div class="ev-format-card">
                <div class="ev-format-icon"><i data-lucide="monitor-play"></i></div>
                <div>
                    <h4>Product Demos</h4>
                    <p>Live walkthroughs of Starmax products with time for implementation planning and operational questions.</p>
                </div>
            </div>
            <div class="ev-format-card">
                <div class="ev-format-icon"><i data-lucide="graduation-cap"></i></div>
                <div>
                    <h4>Workshops</h4>
                    <p>Hands-on sessions covering web platforms, Android development, AI automation, and deployment practices.</p>
                </div>
            </div>
            <div class="ev-format-card">
                <div class="ev-format-icon"><i data-lucide="users"></i></div>
                <div>
                    <h4>Strategy Sessions</h4>
                    <p>Small-group sessions for teams planning new systems, migrations, technology evaluations, or product launches.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA -->
<div class="cta-banner reveal">
    <h2>Want an invite or a private demo?</h2>
    <p>Tell us what you want to explore and we'll share the right event or schedule a focused one-on-one session.</p>
    <div class="cta-actions">
        <a href="/contact" class="btn btn-primary">Request an Invite →</a>
        <a href="/services" class="btn btn-secondary">Explore our services</a>
    </div>
</div>

@endsection
