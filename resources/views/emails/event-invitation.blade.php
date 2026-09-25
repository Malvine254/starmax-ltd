<!DOCTYPE html>
<html lang="en"><head>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>@media only screen and (max-width:600px){.email-shell{padding:8px 6px!important}.email-card{padding:18px 14px!important;border-radius:8px!important}}</style>
</head><body style="margin:0;font-family:Arial,sans-serif;color:#111827;background:#f3f4f6">
<div class="email-shell" style="max-width:600px;margin:auto;padding:24px">
<div class="email-card" style="background:white;padding:28px;border-radius:10px;border:1px solid #e5e7eb">
    <p>Starmax event invitation</p>
    <h1>Hello {{ $recipient['name'] }},</h1>
    <div style="line-height:1.7">{!! $invitationMessage !!}</div>
    <p><strong>{{ $event->title }}</strong><br>{{ $event->starts_at?->format('D, d M Y, g:i A') }}<br>{{ $event->location }}</p>
    @if($eventUrl)<p><a href="{{ $eventUrl }}">Open event link</a></p>@endif
</div>
</div>
</body></html>
