@extends('admin.layout')
@section('page-title', 'Contact Message')

@section('content')
<div class="card" style="max-width:820px;">
    <div style="display:flex;justify-content:space-between;gap:16px;margin-bottom:18px;align-items:flex-start;">
        <div>
            <h2 style="font-size:20px;margin-bottom:4px;">{{ $contactMessage->name }}</h2>
            <p style="color:#64748b;font-size:14px;">
                <a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a>
                · {{ $contactMessage->created_at->format('M d, Y H:i') }}
            </p>
        </div>
        <span class="badge {{ $contactMessage->read_at ? 'badge-gray' : 'badge-blue' }}">
            {{ $contactMessage->read_at ? 'Read' : 'New' }}
        </span>
    </div>

    <div style="margin-bottom:18px;">
        <div style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;margin-bottom:6px;">Service Interest</div>
        <div>{{ $contactMessage->service ? str($contactMessage->service)->headline() : 'General' }}</div>
    </div>

    <div style="margin-bottom:22px;">
        <div style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;margin-bottom:6px;">Message</div>
        <div style="white-space:pre-line;line-height:1.65;">{{ $contactMessage->message }}</div>
    </div>

    <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-secondary">Back</a>
        <a href="mailto:{{ $contactMessage->email }}" class="btn btn-primary">Reply by Email</a>
    </div>
</div>
@endsection
