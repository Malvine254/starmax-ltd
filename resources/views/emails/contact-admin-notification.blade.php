<!DOCTYPE html>
<html lang="en">
<body style="margin:0;background:#f3f4f6;font-family:Arial,sans-serif;color:#111827;">
    <div style="max-width:640px;margin:0 auto;padding:32px 20px;">
        <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:8px;padding:28px;">
            <p style="margin:0 0 8px;font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;">New Website Enquiry</p>
            <h1 style="margin:0 0 20px;font-size:24px;line-height:1.25;">{{ $contactMessage->name }} sent a message</h1>

            <p style="margin:0 0 10px;"><strong>Email:</strong> <a href="mailto:{{ $contactMessage->email }}" style="color:#111827;">{{ $contactMessage->email }}</a></p>
            <p style="margin:0 0 20px;"><strong>Service:</strong> {{ $contactMessage->service ? str($contactMessage->service)->headline() : 'General' }}</p>

            <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:18px;line-height:1.6;white-space:pre-line;">{{ $contactMessage->message }}</div>

            <p style="margin:22px 0 0;color:#64748b;font-size:13px;">Received {{ $contactMessage->created_at->format('M d, Y H:i') }}.</p>
        </div>
    </div>
</body>
</html>
