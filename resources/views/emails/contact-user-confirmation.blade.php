<!DOCTYPE html>
<html lang="en">
<body style="margin:0;background:#f3f4f6;font-family:Arial,sans-serif;color:#111827;">
    <div style="max-width:640px;margin:0 auto;padding:32px 20px;">
        <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:8px;padding:28px;">
            <p style="margin:0 0 8px;font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;">Starmax Ltd</p>
            <h1 style="margin:0 0 16px;font-size:24px;line-height:1.25;">Thanks, {{ $contactMessage->name }}.</h1>
            <p style="margin:0 0 18px;line-height:1.65;color:#475569;">We received your message and our team will review it shortly. Here is a copy of what you sent.</p>

            <p style="margin:0 0 12px;"><strong>Service:</strong> {{ $contactMessage->service ? str($contactMessage->service)->headline() : 'General' }}</p>
            <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:18px;line-height:1.6;white-space:pre-line;">{{ $contactMessage->message }}</div>

            <div style="margin-top:20px;padding:14px 16px;border:1px solid #f3d28c;border-radius:8px;background:#fff8e8;color:#76500f;font-size:13px;line-height:1.6;">
                <strong style="display:block;margin-bottom:3px;">Keep an eye on your inbox</strong>
                If you don’t see our follow-up, please check your Spam or Junk folder and mark emails from <strong>{{ config('mail.from.address') }}</strong> as safe.
            </div>

            <p style="margin:22px 0 0;color:#64748b;font-size:13px;">If you need to add more details, reply to this email or send us another note through the website.</p>
        </div>
    </div>
</body>
</html>
