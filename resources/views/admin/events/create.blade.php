@extends('admin.layout')

@section('page-title', 'New Event')

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
    <h2 class="page-title" style="margin:0;">Create Event</h2>
    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">← Back to Events</a>
</div>

<div class="card" style="max-width:800px;">
    <form method="POST" action="{{ route('admin.events.store') }}">
        @csrf

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group" style="grid-column:1/-1;">
                <label>Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. TenantPro Live Walkthrough" required>
                @error('title')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label>Category *</label>
                <select name="category" required>
                    <option value="">Select category</option>
                    @foreach(['Product Demo','Workshop','Clinic','Strategy Session','Webinar','Conference','Meetup'] as $cat)
                        <option value="{{ $cat }}" @selected(old('category') === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label>Format</label>
                <select name="format">
                    <option value="">Select format</option>
                    @foreach(['Online','In-Person','Hybrid'] as $fmt)
                        <option value="{{ $fmt }}" @selected(old('format') === $fmt)>{{ $fmt }}</option>
                    @endforeach
                </select>
                @error('format')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group" style="grid-column:1/-1;">
                <label>Location *</label>
                <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g. Nairobi, Kenya or Online — Zoom link sent on registration" required>
                @error('location')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label>Start Date & Time *</label>
                <input type="datetime-local" name="starts_at" value="{{ old('starts_at') }}" required>
                @error('starts_at')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label>End Date & Time</label>
                <input type="datetime-local" name="ends_at" value="{{ old('ends_at') }}">
                @error('ends_at')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group" style="grid-column:1/-1;">
                <label>Excerpt * <span style="font-weight:400;color:#94a3b8;">(short summary shown in cards, max 500 chars)</span></label>
                <textarea name="excerpt" rows="2" placeholder="One or two sentences describing what attendees will gain..." required>{{ old('excerpt') }}</textarea>
                @error('excerpt')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group" style="grid-column:1/-1;">
                <label>Full Description *</label>
                <textarea name="description" rows="5" placeholder="Detailed event description shown on the featured card..." required>{{ old('description') }}</textarea>
                @error('description')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label>CTA Button Label *</label>
                <input type="text" name="cta_label" value="{{ old('cta_label', 'Request Invite') }}" placeholder="e.g. Reserve a Seat" required>
                @error('cta_label')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label>Public CTA URL *</label>
                <input type="text" name="cta_url" value="{{ old('cta_url', '/contact') }}" placeholder="e.g. /contact?service=tenant" required>
                <div class="gs-hint">Public marketing link. This is not the private meeting/access link.</div>
                @error('cta_url')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group" style="grid-column:1/-1;">
                <label>Event / Meeting Link</label>
                <input type="url" name="event_url" value="{{ old('event_url') }}" placeholder="https://zoom.us/j/... or https://meet.google.com/...">
                <div style="margin-top:5px;color:#64748b;font-size:11px;">Optional. This exact link is included in the attendee confirmation email after registration.</div>
                @error('event_url')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label>Certificate signer name</label>
                <input name="certificate_signer_name" value="{{ old('certificate_signer_name') }}" placeholder="e.g. Grace Sellah">
            </div>
            <div class="form-group">
                <label>Signer title</label>
                <input name="certificate_signer_title" value="{{ old('certificate_signer_title') }}" placeholder="e.g. Program Director">
            </div>
            <div class="form-group" style="grid-column:1/-1;">
                <label>Certificate message</label>
                <textarea name="certificate_message" rows="4" maxlength="1000">{{ old('certificate_message', \App\Models\SiteEvent::defaultCertificateMessage()) }}</textarea>
                <div style="margin-top:5px;color:#64748b;font-size:11px;">Use <strong>:event</strong> for the event title and <strong>:company</strong> for “, representing Company Name” when provided. This message appears identically online and in the PDF.</div>
                @error('certificate_message')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="upcoming" @selected(old('status','upcoming') === 'upcoming')>Upcoming</option>
                    <option value="past"     @selected(old('status') === 'past')>Past</option>
                    <option value="cancelled" @selected(old('status') === 'cancelled')>Cancelled</option>
                </select>
                @error('status')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" placeholder="0">
                @error('sort_order')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="form-group" style="grid-column:1/-1;display:flex;align-items:center;gap:10px;">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" style="width:auto;" @checked(old('is_featured'))>
                <label for="is_featured" style="margin:0;font-size:14px;cursor:pointer;">Mark as featured (appears in the "Featured" section on the events page)</label>
            </div>
        </div>

        <div style="display:flex;gap:10px;margin-top:8px;">
            <button type="submit" class="btn btn-primary">Create Event</button>
            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
