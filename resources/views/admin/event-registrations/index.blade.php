@extends('admin.layout')
@section('page-title', 'Event registrations')

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px;">
    <div><p class="eyebrow">Audience</p><h1 style="margin-top:5px;font-size:25px;">Event registrations</h1></div>
    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Manage events</a>
</div>
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
@endsection
