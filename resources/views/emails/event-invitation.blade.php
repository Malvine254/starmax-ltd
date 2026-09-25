<!DOCTYPE html>
<html lang="en"><body style="font-family:Arial,sans-serif;color:#111827;background:#f3f4f6;padding:24px">
<div style="max-width:600px;margin:auto;background:white;padding:28px;border-radius:10px">
    <p>Starmax event invitation</p>
    <h1>Hello {{ $recipient['name'] }},</h1>
    <div style="white-space:pre-line;line-height:1.7">{{ $invitationMessage }}</div>
    <p><strong>{{ $event->title }}</strong><br>{{ $event->starts_at?->format('D, d M Y, g:i A') }}<br>{{ $event->location }}</p>
    @if($eventUrl)<p><a href="{{ $eventUrl }}">Open event link</a></p>@endif
</div>
</body></html>
