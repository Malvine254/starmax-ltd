@extends('admin.layout')

@section('page-title', 'Event Registrations')

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
    <h2 class="page-title" style="margin:0;">Event Registrations</h2>
    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Manage Events</a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Attendee</th>
                <th>Event</th>
                <th>Contact</th>
                <th>Company</th>
                <th>Registered At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $registration)
            <tr>
                <td>
                    <strong style="display:block;color:#0f172a;">{{ $registration->name }}</strong>
                    @if($registration->message)
                    <span style="font-size:12px;color:#64748b;">{{ Str::limit($registration->message, 70) }}</span>
                    @endif
                </td>
                <td>
                    <strong style="display:block;color:#0f172a;">{{ $registration->event?->title ?? 'Event removed' }}</strong>
                    <span style="font-size:12px;color:#94a3b8;">
                        {{ $registration->event?->starts_at?->format('d M Y, g:i A') ?? 'N/A' }}
                    </span>
                </td>
                <td>
                    <div style="font-size:13px;color:#0f172a;">{{ $registration->email }}</div>
                    <div style="font-size:12px;color:#94a3b8;">{{ $registration->phone ?: 'No phone' }}</div>
                </td>
                <td>
                    {{ $registration->company ?: '—' }}
                </td>
                <td>
                    {{ $registration->created_at->format('d M Y, g:i A') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;color:#94a3b8;padding:32px;">No registrations yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($registrations->hasPages())
<div class="pagination" style="margin-top:16px;">
    {{ $registrations->links() }}
</div>
@endif
@endsection
