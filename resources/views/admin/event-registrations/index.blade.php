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
                <textarea id="message" name="message" rows="7" required placeholder="Add arrival instructions, what to bring, or any schedule updates…">{{ old('message', $defaultReminder) }}</textarea>
                @error('message')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="merge-fields" aria-label="Available personalization fields">
                <strong>Personalization fields</strong>
                <span>Use these in the subject or message. They are replaced separately for every attendee.</span>
                <div>
                    @foreach($personalizationFields as $field)
                        <code>{{ $field }}</code>
                    @endforeach
                </div>
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
        <form method="POST" action="{{ route('admin.events.certificates.issue',$selectedEvent) }}" style="margin-top:10px" onsubmit="return confirm('Issue and email certificates to every attendee marked Attended?')">
            @csrf <button class="btn btn-primary">Issue certificates to attended</button>
        </form>
    </section>
</div>
<section class="card" style="display:flex;align-items:center;gap:28px;margin-bottom:18px;border-left:4px solid #d97706;flex-wrap:wrap">
    <div style="flex:1;min-width:260px">
        <span class="eyebrow">Mass certificate delivery</span>
        <h2 style="margin:6px 0;font-size:19px">Send completion certificates</h2>
        <p style="color:#64748b;font-size:11px;line-height:1.6">Generate an authentic PDF for every attendee marked <strong>Attended</strong>. Each PDF includes a unique certificate ID and QR code linked to online verification.</p>
    </div>
    <div><strong style="font-size:24px">{{ $selectedEvent->attended_count }}</strong> <small>eligible</small><br><strong>{{ $selectedEvent->certificate_count }}</strong> <small>already issued</small></div>
    <form method="POST" action="{{ route('admin.events.certificates.issue',$selectedEvent) }}" onsubmit="return confirm('Generate and email PDF certificate links to all attended participants?')">
        @csrf <button class="btn btn-primary" @disabled($selectedEvent->attended_count === 0)>Send certificates to all attended</button>
    </form>
</section>
<section class="card" style="display:flex;align-items:center;gap:24px;margin-bottom:18px;flex-wrap:wrap">
    <div style="flex:1;min-width:260px"><span class="eyebrow">Bulk attendance</span><h2 style="margin:6px 0;font-size:19px">Confirm event attendance</h2><p style="color:#64748b;font-size:11px;line-height:1.6">Mark every new or confirmed registration as attended. Cancelled registrations are excluded.</p></div>
    <form method="POST" action="{{ route('admin.events.attendance.confirm',$selectedEvent) }}" onsubmit="return confirm('Mark all non-cancelled registrations for this event as attended?')">@csrf<button class="btn btn-primary">Confirm attendance for all</button></form>
</section>
@endif

@if(!$selectedEvent)
<div style="display:grid;gap:12px">
@forelse($events->filter(fn($event) => $event->registrations_count > 0) as $event)
    <details class="card" style="padding:0;overflow:hidden">
        <summary style="display:flex;align-items:center;justify-content:space-between;gap:16px;padding:18px 20px;cursor:pointer">
            <span><strong style="display:block">{{ $event->title }}</strong><small style="display:block;margin-top:4px;color:#94a3b8">{{ $event->starts_at?->format('d M Y, g:i A') ?? 'Date unavailable' }}</small></span>
            <span class="badge badge-yellow">{{ $event->registrations_count }} attendee{{ $event->registrations_count === 1 ? '' : 's' }}</span>
        </summary>
        <div style="overflow-x:auto;border-top:1px solid #e2e8f0"><table><thead><tr><th>Attendee</th><th>Status</th><th>Contact</th><th>Company</th><th>Registered</th><th></th></tr></thead><tbody>
        @foreach($event->registrations as $registration)
            <tr><td><strong>{{ $registration->name }}</strong></td><td><span class="badge {{ in_array($registration->status,['confirmed','attended']) ? 'badge-green' : ($registration->status === 'cancelled' ? 'badge-red' : 'badge-blue') }}">{{ str($registration->status)->headline() }}</span></td><td><a href="mailto:{{ $registration->email }}">{{ $registration->email }}</a><small style="display:block;color:#94a3b8">{{ $registration->phone ?: 'No phone' }}</small></td><td>{{ $registration->company ?: '—' }}</td><td>{{ $registration->created_at->format('d M Y, g:i A') }}</td><td><a href="{{ route('admin.event-registrations.show',$registration) }}" class="btn btn-secondary">View details</a></td></tr>
        @endforeach
        </tbody></table></div>
    </details>
@empty
    <div class="card" style="padding:32px;color:#94a3b8;text-align:center">No registrations yet.</div>
@endforelse
</div>
@else
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
@endif
@if($registrations->hasPages())<div class="pagination">{{ $registrations->links() }}</div>@endif
<style>
.reminder-grid{display:grid;grid-template-columns:minmax(0,1.3fr) minmax(280px,.7fr);gap:18px;margin-bottom:18px}.roster-card{display:flex;align-items:flex-start;flex-direction:column}.roster-count{display:flex;align-items:baseline;gap:8px;margin:25px 0}.roster-count b{font-size:34px;letter-spacing:-.05em}.roster-count span{color:#64748b;font-size:10px}.merge-fields{margin:-4px 0 18px;padding:12px;border:1px solid #e2e8f0;border-radius:8px;background:#f8fafc;color:#64748b;font-size:11px;line-height:1.5}.merge-fields strong,.merge-fields span{display:block}.merge-fields strong{color:#334155}.merge-fields div{display:flex;flex-wrap:wrap;gap:6px;margin-top:8px}.merge-fields code{padding:3px 6px;border:1px solid #cbd5e1;border-radius:5px;background:#fff;color:#7c3aed;font-size:10px}@media(max-width:800px){.reminder-grid{grid-template-columns:1fr}}
</style>
@endsection
