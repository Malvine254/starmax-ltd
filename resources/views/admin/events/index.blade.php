@extends('admin.layout')

@section('page-title', 'Events')

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
    <h2 class="page-title" style="margin:0;">Events</h2>
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">+ New Event</a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Format</th>
                <th>Date</th>
                <th>Status</th>
                <th>Featured</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td>
                    <strong style="display:block;color:#0f172a;">{{ $event->title }}</strong>
                    <span style="font-size:12px;color:#94a3b8;">{{ Str::limit($event->excerpt, 60) }}</span>
                </td>
                <td>
                    <span class="badge badge-blue">{{ $event->category }}</span>
                </td>
                <td>
                    {{ $event->format ?? '—' }}
                </td>
                <td>
                    @if($event->starts_at)
                        <strong style="display:block;">{{ $event->starts_at->format('d M Y') }}</strong>
                        <span style="font-size:12px;color:#94a3b8;">{{ $event->starts_at->format('g:i A') }} EAT</span>
                    @else
                        <span class="badge badge-red">Date missing</span>
                    @endif
                </td>
                <td>
                    @if($event->status === 'upcoming')
                        <span class="badge badge-green">Upcoming</span>
                    @elseif($event->status === 'past')
                        <span class="badge badge-gray">Past</span>
                    @else
                        <span class="badge badge-red">Cancelled</span>
                    @endif
                </td>
                <td>
                    @if($event->is_featured)
                        <span class="badge badge-yellow">Featured</span>
                    @else
                        <span style="color:#94a3b8;font-size:13px;">—</span>
                    @endif
                </td>
                <td style="white-space:nowrap;">
                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-secondary" style="margin-right:6px;">Edit</a>
                    <form method="POST" action="{{ route('admin.events.destroy', $event) }}" style="display:inline;" onsubmit="return confirm('Delete this event?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;color:#94a3b8;padding:32px;">No events found. <a href="{{ route('admin.events.create') }}">Create the first one →</a></td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($events->hasPages())
<div class="pagination" style="margin-top:16px;">
    {{ $events->links() }}
</div>
@endif

@endsection
