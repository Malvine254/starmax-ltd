<!DOCTYPE html>
<html lang="en">
<body style="margin:0;background:#f3f4f6;font-family:Arial,sans-serif;color:#111827;">
    <div style="max-width:640px;margin:0 auto;padding:32px 20px;">
        <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:10px;padding:28px;">
            <p style="margin:0 0 8px;font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;">Starmax Ltd</p>
            <h1 style="margin:0 0 14px;font-size:24px;line-height:1.25;">Registration confirmed, {{ $registration->name }}.</h1>
            <p style="margin:0 0 20px;line-height:1.65;color:#475569;">Thanks for registering. Your seat is now reserved and the event access link is ready below.</p>

            <div style="border:1px solid #e5e7eb;border-radius:8px;padding:16px;background:#f9fafb;margin-bottom:18px;">
                <p style="margin:0 0 8px;"><strong>Event:</strong> {{ $registration->event?->title ?? 'Starmax Event' }}</p>
                <p style="margin:0 0 8px;"><strong>Date:</strong> {{ $registration->event?->starts_at?->format('d M Y, g:i A') ?? 'To be confirmed' }}</p>
                <p style="margin:0;"><strong>Location:</strong> {{ $registration->event?->location ?? 'Online / To be shared' }}</p>
            </div>

            <p style="margin:0 0 12px;font-size:13px;color:#64748b;">Event URL</p>
            <a href="{{ $eventUrl }}" style="display:inline-block;background:#111827;color:#fff;text-decoration:none;padding:12px 18px;border-radius:8px;font-weight:700;">Open Event Link</a>
            <p style="margin:14px 0 0;font-size:13px;color:#64748b;word-break:break-all;">{{ $eventUrl }}</p>

            <div style="margin-top:20px;padding:14px 16px;border:1px solid #f3d28c;border-radius:8px;background:#fff8e8;color:#76500f;font-size:13px;line-height:1.6;">
                <strong style="display:block;margin-bottom:3px;">Don’t miss event updates</strong>
                Please check your Spam or Junk folder if future event reminders are not in your inbox, and mark emails from <strong>{{ config('mail.from.address') }}</strong> as safe.
            </div>

            <p style="margin:22px 0 0;color:#64748b;font-size:13px;line-height:1.6;">If you need to update your details, reply to this email and our team will help.</p>
        </div>
    </div>
</body>
</html>
