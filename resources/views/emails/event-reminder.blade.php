<!DOCTYPE html>
<html lang="en">
<body style="margin:0;background:#f3f4f6;font-family:Arial,sans-serif;color:#111827;">
<div style="max-width:640px;margin:0 auto;padding:32px 20px;">
    <div style="padding:28px;border:1px solid #e5e7eb;border-radius:10px;background:#fff;">
        <p style="margin:0 0 8px;color:#a5680b;font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;">Starmax event reminder</p>
        <h1 style="margin:0 0 14px;font-size:24px;">Hello {{ $registration->name }},</h1>
        <div style="color:#475569;font-size:14px;line-height:1.7;white-space:pre-line;">{{ $reminderMessage }}</div>

        <div style="margin:22px 0;padding:16px;border-radius:8px;background:#f9fafb;">
            <p style="margin:0 0 7px;"><strong>Event:</strong> {{ $registration->event?->title ?? 'Starmax Event' }}</p>
            <p style="margin:0 0 7px;"><strong>Date:</strong> {{ $registration->event?->starts_at?->format('D, d M Y · g:i A') ?? 'To be confirmed' }}</p>
            <p style="margin:0;"><strong>Location:</strong> {{ $registration->event?->location ?? 'To be confirmed' }}</p>
        </div>

        <a href="{{ $eventUrl }}" style="display:inline-block;padding:12px 18px;border-radius:8px;color:#fff;background:#111827;font-weight:700;text-decoration:none;">Open event link</a>
        <p style="margin:12px 0 0;color:#64748b;font-size:12px;word-break:break-all;">{{ $eventUrl }}</p>

        <div style="margin-top:20px;padding:13px 15px;border:1px solid #f3d28c;border-radius:8px;color:#76500f;background:#fff8e8;font-size:12px;line-height:1.6;">
            If future reminders are missing, please check Spam or Junk and mark <strong>{{ config('mail.from.address') }}</strong> as safe.
        </div>
    </div>
</div>
</body>
</html>
