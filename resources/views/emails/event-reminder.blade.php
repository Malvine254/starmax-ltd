<!DOCTYPE html>
<html lang="en"><head>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>@media only screen and (max-width:600px){.email-shell{padding:8px 6px!important}.email-card{padding:18px 14px!important;border-radius:8px!important}.agenda-time{width:118px!important;padding:11px 10px!important}.agenda-session{padding:11px 10px!important}}</style>
</head>
<body style="margin:0;background:#f3f4f6;font-family:Arial,sans-serif;color:#111827;">
<div class="email-shell" style="max-width:640px;margin:0 auto;padding:32px 20px;">
    <div class="email-card" style="padding:28px;border:1px solid #e5e7eb;border-radius:10px;background:#fff;">
        <p style="margin:0 0 8px;color:#a5680b;font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;">Starmax event reminder</p>
        <h1 style="margin:0 0 14px;font-size:24px;">Hello {{ $registration->name }},</h1>
        <div style="color:#475569;font-size:14px;line-height:1.7;">{!! $reminderMessage !!}</div>

        @if($programItems)
            <div style="margin:24px 0;border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;">
                <div style="padding:13px 16px;background:#111827;color:#fff;">
                    <p style="margin:0;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;">Event program</p>
                </div>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;background:#fff;">
                    @foreach($programItems as $item)
                        <tr>
                            <td class="agenda-time" style="width:165px;padding:13px 16px;border-bottom:1px solid #e5e7eb;color:#a5680b;font-size:12px;font-weight:700;vertical-align:top;">{{ $item['time'] ?: 'Session' }}</td>
                            <td class="agenda-session" style="padding:13px 16px;border-bottom:1px solid #e5e7eb;color:#334155;font-size:13px;line-height:1.5;vertical-align:top;">{{ $item['session'] }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif

        <div style="margin:22px 0;padding:16px;border-radius:8px;background:#f9fafb;">
            <p style="margin:0 0 7px;"><strong>Event:</strong> {{ $registration->event?->title ?? 'Starmax Event' }}</p>
            <p style="margin:0 0 7px;"><strong>Date:</strong> {{ $registration->event?->starts_at?->format('D, d M Y · g:i A') ?? 'To be confirmed' }}</p>
            <p style="margin:0;"><strong>Location:</strong> {{ $registration->event?->location ?? 'To be confirmed' }}</p>
        </div>

        @if($eventUrl)
            <a href="{{ $eventUrl }}" style="display:inline-block;padding:12px 18px;border-radius:8px;color:#fff;background:#111827;font-weight:700;text-decoration:none;">Open event link</a>
            <p style="margin:12px 0 0;color:#64748b;font-size:12px;word-break:break-all;">{{ $eventUrl }}</p>
        @endif

        <div style="margin-top:20px;padding:13px 15px;border:1px solid #f3d28c;border-radius:8px;color:#76500f;background:#fff8e8;font-size:12px;line-height:1.6;">
            If future reminders are missing, please check Spam or Junk and mark <strong>{{ config('mail.from.address') }}</strong> as safe.
        </div>
    </div>
</div>
</body>
</html>
