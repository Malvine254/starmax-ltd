@extends('admin.layout')
@section('page-title', 'Event registrations')

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px;">
    <div><p class="eyebrow">Audience</p><h1 style="margin-top:5px;font-size:25px;">Event registrations</h1></div>
    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Manage events</a>
</div>

<div class="card" style="margin-bottom:18px;">
    <form method="GET" action="{{ route('admin.event-registrations.index') }}" style="display:flex;align-items:flex-end;gap:12px;flex-wrap:wrap;">
        <div class="form-group" style="margin:0;min-width:280px;flex:1;">
            <label for="event-filter">Filter by event</label>
            <select id="event-filter" name="event">
                <option value="">All registrations</option>
                @foreach($events as $event)
                    <option value="{{ $event->id }}" @selected(request('event') === $event->id)>{{ $event->title }} ({{ $event->registrations_count }})</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Apply filter</button>
        @if(request('event'))<a class="btn btn-secondary" href="{{ route('admin.event-registrations.index') }}">Clear</a>@endif
    </form>
</div>

@if($selectedEvent)
<div class="reminder-grid">
    <section class="card">
        <span class="eyebrow">Bulk communication</span>
        <h2 style="margin:6px 0 7px;font-size:19px;">Email all {{ $selectedEvent->registrations_count }} attendees</h2>
        <p style="margin-bottom:17px;color:#64748b;font-size:11px;line-height:1.6;">Each attendee receives an individual email. Recipient addresses are never shared with other attendees.</p>
        <form method="POST" action="{{ route('admin.event-registrations.reminders.send') }}" onsubmit="return confirm('Send this reminder to every attendee registered for this event?')">
            @csrf
            <input type="hidden" name="site_event_id" value="{{ $selectedEvent->id }}">
            <div class="form-group">
                <label for="subject">Email subject</label>
                <input id="subject" name="subject" value="{{ old('subject', 'Reminder: '.$selectedEvent->title) }}" required maxlength="180">
                @error('subject')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="message">Reminder message</label>
                <textarea id="message" name="message" rows="5" required placeholder="Add arrival instructions, what to bring, or any schedule updates…">{{ old('message', "This is a friendly reminder about your upcoming Starmax event. We look forward to seeing you there.") }}</textarea>
                @error('message')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <button class="btn btn-primary" type="submit">Send reminder to all</button>
        </form>
    </section>
    <section class="card roster-card">
        <span class="eyebrow">Attendance</span>
        <h2 style="margin:6px 0 7px;font-size:19px;">Printable attendance register</h2>
        <p style="color:#64748b;font-size:11px;line-height:1.6;">Generate a clean roster with attendee details, status, check-in, and signature columns.</p>
        <div class="roster-count"><b>{{ $selectedEvent->registrations_count }}</b><span>registered attendees</span></div>
        <a href="{{ route('admin.events.attendance', $selectedEvent) }}" target="_blank" rel="noopener" class="btn btn-secondary">Open printable register ↗</a>
    </section>
</div>
@endif

<div class="card" style="overflow-x:auto;">
    <table>
        <thead><tr><th>Attendee</th><th>Status</th><th>Event</th><th>Contact</th><th>Company</th><th>Registered</th><th></th></tr></thead>
        <tbody>
        @forelse($registrations as $registration)
            <tr>
                <td><strong>{{ $registration->name }}</strong>@if($registration->message)<small style="display:block;margin-top:3px;color:#64748b;">{{ Str::limit($registration->message, 55) }}</small>@endif</td>
                <td>
                    @php($statusClass = match($registration->status) {'confirmed','attended'=>'badge-green','cancelled'=>'badge-red',default=>'badge-blue'})
                    <span class="badge {{ $statusClass }}">{{ str($registration->status)->headline() }}</span>
                    @if(!$registration->read_at)<span class="badge badge-yellow">Unread</span>@endif
                </td>
                <td><strong>{{ $registration->event?->title ?? 'Event removed' }}</strong><small style="display:block;margin-top:3px;color:#94a3b8;">{{ $registration->event?->starts_at?->format('d M Y, g:i A') ?? 'N/A' }}</small></td>
                <td><a href="mailto:{{ $registration->email }}">{{ $registration->email }}</a><small style="display:block;color:#94a3b8;">{{ $registration->phone ?: 'No phone' }}</small></td>
                <td>{{ $registration->company ?: '—' }}</td>
                <td>{{ $registration->created_at->format('d M Y, g:i A') }}</td>
                <td><a href="{{ route('admin.event-registrations.show', $registration) }}" class="btn btn-secondary">View details</a></td>
            </tr>
        @empty
            <tr><td colspan="7" style="padding:32px;color:#94a3b8;text-align:center;">No registrations yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@if($registrations->hasPages())<div class="pagination">{{ $registrations->links() }}</div>@endif
<style>
.reminder-grid{display:grid;grid-template-columns:minmax(0,1.3fr) minmax(280px,.7fr);gap:18px;margin-bottom:18px}.roster-card{display:flex;align-items:flex-start;flex-direction:column}.roster-count{display:flex;align-items:baseline;gap:8px;margin:25px 0}.roster-count b{font-size:34px;letter-spacing:-.05em}.roster-count span{color:#64748b;font-size:10px}@media(max-width:800px){.reminder-grid{grid-template-columns:1fr}}
</style>
@endsection
