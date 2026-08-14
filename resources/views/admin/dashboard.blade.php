@extends('admin.layout')
@section('page-title', 'Portfolio overview')

@section('content')
<div class="welcome-panel">
    <div>
        <span class="eyebrow">Starmax content workspace</span>
        <h1>Keep the portfolio current.</h1>
        <p>Manage the public portfolio, website enquiries, events, and registrations from one focused workspace.</p>
    </div>
    <a href="{{ route('grace-sellah.admin.page.edit') }}" class="btn btn-primary">Edit Vlog page</a>
</div>

<div class="stat-grid">
    <a class="stat" href="{{ route('admin.contact-messages.index') }}">
        <div class="stat-label">Unread enquiries</div>
        <div class="stat-value">{{ $stats['unread_messages'] }}</div>
        <div class="stat-meta">{{ $stats['total_messages'] }} total messages</div>
    </a>
    <a class="stat" href="{{ route('admin.events.index') }}">
        <div class="stat-label">Upcoming events</div>
        <div class="stat-value">{{ $stats['upcoming_events'] }}</div>
        <div class="stat-meta">Published opportunities</div>
    </a>
    <a class="stat" href="{{ route('admin.event-registrations.index') }}">
        <div class="stat-label">Event registrations</div>
        <div class="stat-value">{{ $stats['event_registrations'] }}</div>
        <div class="stat-meta">{{ $stats['unread_registrations'] }} awaiting review</div>
    </a>
    <a class="stat" href="{{ route('grace-sellah.admin.page.edit') }}">
        <div class="stat-label">Portfolio</div>
        <div class="stat-value status-value">{{ $stats['portfolio_ready'] ? 'Live' : 'Draft' }}</div>
        <div class="stat-meta">Public page status</div>
    </a>
</div>

<div class="dashboard-grid">
    <section class="card">
        <div class="section-heading">
            <div>
                <span class="eyebrow">Inbox</span>
                <h2>Recent enquiries</h2>
            </div>
            <a href="{{ route('admin.contact-messages.index') }}">View all</a>
        </div>
        @forelse($recentMessages as $message)
            <a class="activity-row" href="{{ route('admin.contact-messages.show', $message) }}">
                <span class="activity-avatar">{{ strtoupper(substr($message->name, 0, 1)) }}</span>
                <span class="activity-copy">
                    <strong>{{ $message->name }}</strong>
                    <small>{{ \Illuminate\Support\Str::limit($message->message, 72) }}</small>
                </span>
                <time>{{ $message->created_at->diffForHumans() }}</time>
            </a>
        @empty
            <div class="empty-state">No website enquiries yet.</div>
        @endforelse
    </section>

    <section class="card">
        <div class="section-heading">
            <div>
                <span class="eyebrow">Schedule</span>
                <h2>Upcoming events</h2>
            </div>
            <a href="{{ route('admin.events.create') }}">Add event</a>
        </div>
        @forelse($upcomingEvents as $event)
            <a class="activity-row" href="{{ route('admin.events.edit', $event) }}">
                <span class="event-date">
                    <b>{{ optional($event->starts_at)->format('d') }}</b>
                    <small>{{ optional($event->starts_at)->format('M') }}</small>
                </span>
                <span class="activity-copy">
                    <strong>{{ $event->title }}</strong>
                    <small>{{ $event->format ?: 'Portfolio event' }}</small>
                </span>
            </a>
        @empty
            <div class="empty-state">No upcoming events. Add one when you are ready.</div>
        @endforelse
    </section>
</div>
@endsection
