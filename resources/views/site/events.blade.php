@extends('site.layout')

@section('content')
<!-- Hero -->
<div class="hero-section events-hero">
    <div class="hero-content">
        <p class="eyebrow">Events</p>
        <h2>Workshops, launches, and technology sessions.</h2>
        <p>Meet the Starmax team at product demos, developer workshops, and business technology sessions focused on practical digital transformation.</p>
        <div class="stack">
            <a href="#schedule" class="btn btn-primary">View Schedule</a>
            <a href="/contact" class="btn btn-secondary">Request Private Demo</a>
        </div>
    </div>
    <div class="hero-stats">
        <div class="hero-stat reveal">
            <p class="kpi">{{ $eventStats['upcoming'] }}</p>
            <p class="kpi-label">Upcoming events loaded from database</p>
        </div>
        <div class="hero-stat reveal">
            <p class="kpi">{{ $eventStats['formats'] }}</p>
            <p class="kpi-label">Event formats across online, hybrid, and in-person sessions</p>
        </div>
        <div class="hero-stat reveal">
            <p class="kpi">{{ $eventStats['next_month'] }}</p>
            <p class="kpi-label">Next available session</p>
        </div>
    </div>
</div>

<!-- Featured Events -->
<div class="section">
    <div class="section-header">
        <p class="eyebrow">Featured</p>
        <h2>Start with these sessions.</h2>
        <p>High-value events for teams planning property platforms, AI workflows, and modern operational systems.</p>
    </div>

    <div class="grid grid-2">
        @forelse($featuredEvents as $event)
            <article class="event-feature-card reveal">
                <div class="event-feature-date">
                    <span>{{ $event->starts_at->format('d') }}</span>
                    <small>{{ $event->starts_at->format('M') }}</small>
                </div>
                <div class="event-feature-body">
                    <div class="event-feature-meta">
                        <span>{{ $event->category }}</span>
                        <span>{{ $event->format }}</span>
                    </div>
                    <h3>{{ $event->title }}</h3>
                    <p>{{ $event->description }}</p>
                    <div class="event-detail-row">
                        <span><i data-lucide="map-pin"></i>{{ $event->location }}</span>
                        <span><i data-lucide="clock"></i>{{ $event->starts_at->format('g:i A') }} EAT</span>
                    </div>
                    <a href="{{ $event->cta_url }}" class="btn btn-primary">{{ $event->cta_label }}</a>
                </div>
            </article>
        @empty
            <article class="card">
                <h3>No featured events yet</h3>
                <p>New sessions will appear here when they are added in the database.</p>
            </article>
        @endforelse
    </div>
</div>

<div class="divider"></div>

<!-- Schedule Table -->
<div class="section" id="schedule">
    <div class="section-header">
        <p class="eyebrow">Schedule</p>
        <h2>Events calendar.</h2>
        <p>A database-backed schedule of Starmax demos, workshops, clinics, and strategy sessions.</p>
    </div>

    <div class="event-table-wrap reveal">
        <table class="event-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Event</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Time</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr>
                        <td>
                            <strong>{{ $event->starts_at->format('M d') }}</strong>
                            <span>{{ $event->starts_at->format('Y') }}</span>
                        </td>
                        <td>
                            <strong>{{ $event->title }}</strong>
                            <span>{{ $event->excerpt }}</span>
                        </td>
                        <td><span class="event-tag">{{ $event->category }}</span></td>
                        <td>{{ $event->location }}</td>
                        <td>{{ $event->starts_at->format('g:i A') }}</td>
                        <td><a href="{{ $event->cta_url }}" class="event-table-link">{{ $event->cta_label }}</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No upcoming events are currently published.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="divider"></div>

<!-- Event Types -->
<div class="section">
    <div class="section-header">
        <p class="eyebrow">Formats</p>
        <h2>What we host.</h2>
    </div>
    <div class="grid grid-3">
        <article class="card reveal">
            <div class="card-icon purple"><i data-lucide="monitor-play"></i></div>
            <h3>Product Demos</h3>
            <p>Live walkthroughs of Starmax products with time for implementation planning and operational questions.</p>
        </article>
        <article class="card reveal">
            <div class="card-icon teal"><i data-lucide="graduation-cap"></i></div>
            <h3>Workshops</h3>
            <p>Hands-on sessions covering web platforms, Android experiences, AI automation, and deployment practices.</p>
        </article>
        <article class="card reveal">
            <div class="card-icon orange"><i data-lucide="users"></i></div>
            <h3>Partner Sessions</h3>
            <p>Small-group strategy sessions for teams planning new systems, migrations, or product launches.</p>
        </article>
    </div>
</div>

<!-- CTA -->
<div class="cta-banner reveal">
    <h2>Want an invite or private demo?</h2>
    <p>Tell us what you want to explore and we'll share the right event or schedule a focused session.</p>
    <a href="/contact" class="btn" style="background:#fff;color:#18181b;font-weight:700;">Request an Invite</a>
</div>
@endsection
