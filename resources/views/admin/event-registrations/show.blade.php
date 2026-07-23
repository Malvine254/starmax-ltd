@extends('admin.layout')
@section('page-title', 'Registration details')

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:20px;">
    <div><p class="eyebrow">Event registration</p><h1 style="margin-top:5px;font-size:26px;">{{ $eventRegistration->name }}</h1></div>
    <a href="{{ route('admin.event-registrations.index') }}" class="btn btn-secondary">Back</a>
</div>
<div class="dashboard-grid">
    <section class="card">
        <div class="section-heading">
            <div><span class="eyebrow">Attendee</span><h2>Contact details</h2></div>
            <span class="badge {{ $eventRegistration->status === 'cancelled' ? 'badge-red' : ($eventRegistration->status === 'new' ? 'badge-blue' : 'badge-green') }}">{{ str($eventRegistration->status)->headline() }}</span>
        </div>
        <dl class="detail-list">
            <div><dt>Full name</dt><dd>{{ $eventRegistration->name }}</dd></div>
            <div><dt>Email</dt><dd><a href="mailto:{{ $eventRegistration->email }}">{{ $eventRegistration->email }}</a></dd></div>
            <div><dt>Phone</dt><dd>{{ $eventRegistration->phone ?: 'Not provided' }}</dd></div>
            <div><dt>Company</dt><dd>{{ $eventRegistration->company ?: 'Not provided' }}</dd></div>
            <div><dt>Registered</dt><dd>{{ $eventRegistration->created_at->format('D, d M Y · g:i A') }}</dd></div>
        </dl>
        <div class="message-block"><span>Attendee message</span><p>{{ $eventRegistration->message ?: 'No additional message was provided.' }}</p></div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:20px;">
            <a href="mailto:{{ $eventRegistration->email }}" class="btn btn-primary">Email attendee</a>
            @if($eventRegistration->phone)<a href="tel:{{ $eventRegistration->phone }}" class="btn btn-secondary">Call attendee</a>@endif
        </div>
    </section>
    <div style="display:grid;gap:18px;">
        <section class="card">
            <span class="eyebrow">Selected event</span>
            <h2 style="margin:7px 0 8px;font-size:18px;">{{ $eventRegistration->event?->title ?? 'Event removed' }}</h2>
            @if($eventRegistration->event)
                <p style="color:#64748b;font-size:12px;line-height:1.65;">{{ $eventRegistration->event->starts_at?->format('D, d M Y · g:i A') }}<br>{{ $eventRegistration->event->location }}</p>
                @if($eventRegistration->event->event_url)
                    <a href="{{ $eventRegistration->event->event_url }}" target="_blank" rel="noopener" style="display:block;margin-top:10px;color:#8a5a12;font-size:11px;font-weight:700;word-break:break-all;">Open event link ↗</a>
                @endif
                <a href="{{ route('admin.events.edit', $eventRegistration->event) }}" class="btn btn-secondary" style="margin-top:14px;">Edit event</a>
            @endif
        </section>
        <section class="card">
            <span class="eyebrow">Internal workflow</span><h2 style="margin:7px 0 16px;font-size:18px;">Update registration</h2>
            <form method="POST" action="{{ route('admin.event-registrations.update', $eventRegistration) }}">
                @csrf @method('PATCH')
                <div class="form-group"><label for="status">Status</label><select id="status" name="status">@foreach(['new'=>'New','confirmed'=>'Confirmed','attended'=>'Attended','cancelled'=>'Cancelled'] as $value=>$label)<option value="{{ $value }}" @selected(old('status',$eventRegistration->status)===$value)>{{ $label }}</option>@endforeach</select></div>
                <div class="form-group"><label for="admin_notes">Private admin notes</label><textarea id="admin_notes" name="admin_notes" rows="6">{{ old('admin_notes',$eventRegistration->admin_notes) }}</textarea>@error('admin_notes')<div class="form-error">{{ $message }}</div>@enderror</div>
                <button class="btn btn-primary" type="submit">Save changes</button>
            </form>
        </section>
    </div>
</div>
<style>
.detail-list{display:grid;margin-top:8px}.detail-list div{display:grid;grid-template-columns:120px 1fr;gap:20px;padding:13px 0;border-bottom:1px solid #f1f5f9}.detail-list dt{color:#94a3b8;font-size:10px;font-weight:800;text-transform:uppercase}.detail-list dd{font-size:12px;font-weight:600}.message-block{margin-top:20px;padding:18px;border-radius:10px;background:#f8f6f1}.message-block span{color:#8a5a12;font-size:9px;font-weight:800;letter-spacing:.1em;text-transform:uppercase}.message-block p{margin-top:8px;font-size:13px;line-height:1.7;white-space:pre-line}@media(max-width:600px){.detail-list div{grid-template-columns:1fr;gap:4px}}
</style>
@endsection
