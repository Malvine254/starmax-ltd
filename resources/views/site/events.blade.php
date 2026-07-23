@extends('site.layout')

@section('title', 'Events — Starmax Ltd')

@section('content')
<style>
.events-shell {
    background:
        radial-gradient(circle at top right, rgba(17,24,39,0.07), transparent 30%),
        radial-gradient(circle at bottom left, rgba(17,24,39,0.05), transparent 28%),
        linear-gradient(180deg, #f8fafc 0%, #ffffff 42%, #ffffff 100%);
}
.ev2-hero { padding: 74px 0 46px; }
.ev2-title {
    font-size: clamp(34px, 5vw, 58px);
    line-height: 1.05;
    margin-bottom: 14px;
    max-width: 760px;
}
.ev2-sub {
    max-width: 640px;
    color: #475569;
    line-height: 1.72;
    font-size: 17px;
    margin-bottom: 28px;
}
.ev2-stats {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
}
.ev2-stat {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 14px 16px;
    box-shadow: 0 12px 30px rgba(15,23,42,0.05);
}
.ev2-stat strong {
    display: block;
    font-size: 25px;
    line-height: 1;
    color: #0f172a;
}
.ev2-stat span {
    display: block;
    margin-top: 5px;
    font-size: 12px;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #64748b;
    font-weight: 700;
}
.ev2-grid {
    display: grid;
    grid-template-columns: 1.25fr 1fr;
    gap: 18px;
    align-items: start;
}
.ev2-list {
    display: grid;
    gap: 14px;
}
.ev2-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 18px;
    box-shadow: 0 14px 36px rgba(15,23,42,0.06);
}
.ev2-card:hover {
    border-color: #cbd5e1;
    box-shadow: 0 20px 50px rgba(15,23,42,0.11);
}
.ev2-card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 10px;
}
.ev2-pill {
    display: inline-flex;
    align-items: center;
    padding: 3px 9px;
    font-size: 10px;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    font-weight: 750;
    border-radius: 999px;
    background: #f3f4f6;
    color: #374151;
}
.ev2-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin: 10px 0;
    color: #64748b;
    font-size: 12px;
    font-weight: 600;
}
.ev2-meta span {
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.ev2-meta svg {
    width: 14px;
    height: 14px;
}
.ev2-card h3 {
    margin: 8px 0 6px;
    font-size: 20px;
    line-height: 1.25;
}
.ev2-card p {
    margin: 0;
    color: #475569;
    line-height: 1.65;
    font-size: 14px;
}
.ev2-actions {
    margin-top: 12px;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.ev2-register {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 14px 36px rgba(15,23,42,0.08);
    position: sticky;
    top: 94px;
}
.ev2-register-head {
    margin-bottom: 12px;
}
.ev2-register-head h3 {
    margin: 5px 0 4px;
    font-size: 22px;
}
.ev2-selected {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px;
    margin-bottom: 12px;
}
.ev2-selected p {
    margin: 0;
    font-size: 12px;
    color: #64748b;
}
.ev2-selected strong {
    display: block;
    margin: 4px 0;
    color: #0f172a;
    font-size: 15px;
}
.ev2-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    font-weight: 700;
    color: #111827;
    text-decoration: none;
    margin-top: 8px;
}
.ev2-link svg { width: 14px; height: 14px; }
.ev2-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
.ev2-empty {
    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 14px;
    padding: 30px 20px;
    text-align: center;
    color: #64748b;
}
@media (max-width: 980px) {
    .ev2-grid { grid-template-columns: 1fr; }
    .ev2-register { position: static; }
}
@media (max-width: 640px) {
    .ev2-stats { grid-template-columns: 1fr; }
    .ev2-form-grid { grid-template-columns: 1fr; }
}
</style>

@php
    $activeEvent = old('event_slug')
        ? $events->firstWhere('slug', old('event_slug'))
        : ($selectedEvent ?? $events->first());
    $formEvent = $activeEvent ?? $events->first();
    $selectedEventUrl = $formEvent
        ? (filled($formEvent->cta_url) ? $formEvent->cta_url : route('events.index', ['event' => $formEvent->slug]) . '#schedule')
        : null;
@endphp

<div class="events-shell">
<section class="ev2-hero">
    <div class="container">
        @if(session('success'))
        <div style="display:flex;align-items:center;gap:10px;background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:10px;margin-bottom:20px;font-size:14px;font-weight:600;">
            <i data-lucide="check-circle" style="width:18px;height:18px;flex-shrink:0;"></i>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div style="display:flex;align-items:center;gap:10px;background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:10px;margin-bottom:20px;font-size:14px;font-weight:600;">
            <i data-lucide="alert-circle" style="width:18px;height:18px;flex-shrink:0;"></i>
            {{ session('error') }}
        </div>
        @endif

        <p class="eyebrow">Events</p>
        <h1 class="ev2-title">Modern events with direct registration.</h1>
        <p class="ev2-sub">
            Browse upcoming sessions powered from the database, pick the event that matches your goal, and get your confirmation email with the event URL right away.
        </p>
        <div style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:24px;">
            <a href="#register" class="btn btn-primary"><i data-lucide="ticket"></i> Register now</a>
            <a href="/contact" class="btn btn-secondary">Request private session</a>
        </div>
        <div class="ev2-stats">
            <div class="ev2-stat">
                <strong>{{ $eventStats['upcoming'] }}</strong>
                <span>Upcoming Events</span>
            </div>
            <div class="ev2-stat">
                <strong>{{ $eventStats['formats'] }}</strong>
                <span>Formats</span>
            </div>
            <div class="ev2-stat">
                <strong>{{ $eventStats['next_month'] }}</strong>
                <span>Next Session Window</span>
            </div>
        </div>
    </div>
</section>
<section class="section" id="schedule" style="padding-top:8px; padding-bottom:66px;">
    <div class="ev2-grid">
        <div>
            <div class="section-header left" style="text-align:left;margin:0 0 20px;">
                <p class="eyebrow">Schedule</p>
                <h2 style="margin-bottom:8px;">Upcoming sessions.</h2>
                <p style="max-width:620px;">All events are loaded from the database and stay in sync with your admin updates.</p>
            </div>

            @if($events->isEmpty())
                <div class="ev2-empty">
                    <h3 style="margin:0 0 8px;">No upcoming events</h3>
                    <p style="margin:0;">New sessions will appear here once published.</p>
                </div>
            @else
                <div class="ev2-list">
                    @foreach($events as $event)
                        <article class="ev2-card reveal">
                            <div class="ev2-card-top">
                                <div>
                                    <span class="ev2-pill">{{ $event->category }}</span>
                                    <h3>{{ $event->title }}</h3>
                                </div>
                                @if($event->is_featured)
                                    <span class="ev2-pill" style="background:#fef3c7;color:#92400e;">Featured</span>
                                @endif
                            </div>

                            <div class="ev2-meta">
                                <span><i data-lucide="calendar-days"></i>{{ $event->starts_at->format('d M Y') }}</span>
                                <span><i data-lucide="clock-3"></i>{{ $event->starts_at->format('g:i A') }} EAT</span>
                                <span><i data-lucide="map-pin"></i>{{ $event->location }}</span>
                                @if($event->format)
                                    <span><i data-lucide="monitor"></i>{{ $event->format }}</span>
                                @endif
                            </div>

                            <p>{{ $event->excerpt }}</p>

                            <div class="ev2-actions">
                                <a href="{{ route('events.index', ['event' => $event->slug]) }}#register" class="btn btn-sm btn-primary">Register</a>
                                @if(filled($event->cta_url))
                                    <a href="{{ $event->cta_url }}" class="btn btn-sm btn-secondary" target="_blank" rel="noopener">{{ $event->cta_label ?: 'Event URL' }}</a>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>

        <aside class="ev2-register" id="register">
            <div class="ev2-register-head">
                <p class="eyebrow" style="margin-bottom:4px;">Register</p>
                <h3>Reserve your spot</h3>
                <p style="margin:0;color:#64748b;font-size:14px;line-height:1.6;">After submitting, you will receive an email with the event URL.</p>
            </div>

            @if($events->isEmpty())
                <div class="ev2-empty" style="padding:20px 14px;">
                    <p style="margin:0;">Registration is currently closed.</p>
                </div>
            @else
                <div class="ev2-selected">
                    <p>Selected event</p>
                    <strong>{{ $formEvent?->title }}</strong>
                    <p>{{ $formEvent?->starts_at?->format('d M Y, g:i A') }} @if($formEvent?->location) • {{ $formEvent->location }} @endif</p>
                    @if($selectedEventUrl)
                        <a href="{{ $selectedEventUrl }}" target="_blank" rel="noopener" class="ev2-link">
                            <i data-lucide="link-2"></i>
                            Event URL
                        </a>
                    @endif
                </div>

                <form method="POST" action="{{ route('events.register', ['event' => $formEvent]) }}">
                    @csrf

                    <div class="form-group">
                        <label style="display:block;font-size:13px;font-weight:700;color:#334155;margin-bottom:6px;">Event *</label>
                        <select name="event_slug" id="event_slug" style="width:100%;padding:10px 12px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;" onchange="if(this.value){ window.location='{{ route('events.index') }}?event=' + encodeURIComponent(this.value) + '#register'; }" required>
                            @foreach($events as $event)
                                <option value="{{ $event->slug }}" @selected(($formEvent?->slug ?? null) === $event->slug)>
                                    {{ $event->title }} - {{ $event->starts_at->format('d M Y, g:i A') }}
                                </option>
                            @endforeach
                        </select>
                        @error('event_slug')<p style="margin-top:6px;font-size:12px;color:#dc2626;">{{ $message }}</p>@enderror
                    </div>

                    <div class="ev2-form-grid">
                        <div class="form-group" style="margin-bottom:0;">
                            <label style="display:block;font-size:13px;font-weight:700;color:#334155;margin-bottom:6px;">Full Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required style="width:100%;padding:10px 12px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;" placeholder="Your full name">
                            @error('name')<p style="margin-top:6px;font-size:12px;color:#dc2626;">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group" style="margin-bottom:0;">
                            <label style="display:block;font-size:13px;font-weight:700;color:#334155;margin-bottom:6px;">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required style="width:100%;padding:10px 12px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;" placeholder="you@company.com">
                            @error('email')<p style="margin-top:6px;font-size:12px;color:#dc2626;">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group" style="margin-bottom:0;">
                            <label style="display:block;font-size:13px;font-weight:700;color:#334155;margin-bottom:6px;">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" style="width:100%;padding:10px 12px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;" placeholder="Optional">
                            @error('phone')<p style="margin-top:6px;font-size:12px;color:#dc2626;">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group" style="margin-bottom:0;">
                            <label style="display:block;font-size:13px;font-weight:700;color:#334155;margin-bottom:6px;">Company</label>
                            <input type="text" name="company" value="{{ old('company') }}" style="width:100%;padding:10px 12px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;" placeholder="Optional">
                            @error('company')<p style="margin-top:6px;font-size:12px;color:#dc2626;">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="form-group" style="margin-top:10px;">
                        <label style="display:block;font-size:13px;font-weight:700;color:#334155;margin-bottom:6px;">Message</label>
                        <textarea name="message" rows="4" style="width:100%;padding:10px 12px;border:1px solid #cbd5e1;border-radius:8px;font-size:14px;resize:vertical;" placeholder="Share anything we should know before the session...">{{ old('message') }}</textarea>
                        @error('message')<p style="margin-top:6px;font-size:12px;color:#dc2626;">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary" style="margin-top:8px;width:100%;justify-content:center;">Submit registration</button>
                </form>
            @endif
        </aside>
    </div>
</section>
</div>

@endsection
