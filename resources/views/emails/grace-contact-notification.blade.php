<!DOCTYPE html>
<html lang="en">
<body style="margin:0;background:#f0ece4;font-family:Arial,sans-serif;color:#1c1c1c;">
<div style="max-width:600px;margin:0 auto;padding:32px 20px;">

    <div style="background:#2d4a3e;border-radius:12px 12px 0 0;padding:28px 32px;">
        <p style="margin:0;font-size:13px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#c8a97e;">
            Grace Sellah Atemo — Virtual Assistant
        </p>
        <h1 style="margin:8px 0 0;font-size:22px;color:#ffffff;line-height:1.3;">
            New enquiry from {{ $data['name'] }}
        </h1>
    </div>

    <div style="background:#ffffff;border-radius:0 0 12px 12px;padding:32px;border:1px solid #e0d9cf;border-top:none;">

        <table style="width:100%;border-collapse:collapse;margin-bottom:24px;">
            <tr>
                <td style="padding:10px 0;border-bottom:1px solid #f0ece4;width:110px;">
                    <span style="font-size:12px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#6b6b6b;">Name</span>
                </td>
                <td style="padding:10px 0;border-bottom:1px solid #f0ece4;">
                    <strong>{{ $data['name'] }}</strong>
                </td>
            </tr>
            <tr>
                <td style="padding:10px 0;border-bottom:1px solid #f0ece4;">
                    <span style="font-size:12px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#6b6b6b;">Email</span>
                </td>
                <td style="padding:10px 0;border-bottom:1px solid #f0ece4;">
                    <a href="mailto:{{ $data['email'] }}" style="color:#2d4a3e;font-weight:600;">{{ $data['email'] }}</a>
                </td>
            </tr>
            @if(!empty($data['service']))
            <tr>
                <td style="padding:10px 0;border-bottom:1px solid #f0ece4;">
                    <span style="font-size:12px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#6b6b6b;">Service</span>
                </td>
                <td style="padding:10px 0;border-bottom:1px solid #f0ece4;">
                    {{ $data['service'] }}
                </td>
            </tr>
            @endif
        </table>

        <p style="margin:0 0 10px;font-size:12px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#6b6b6b;">Message</p>
        <div style="background:#f9f7f4;border-left:4px solid #c8a97e;border-radius:4px;padding:18px 20px;line-height:1.7;white-space:pre-line;color:#1c1c1c;">{{ $data['message'] }}</div>

        <div style="margin-top:28px;padding-top:20px;border-top:1px solid #f0ece4;">
            <a href="mailto:{{ $data['email'] }}"
               style="display:inline-block;background:#2d4a3e;color:#ffffff;text-decoration:none;padding:12px 24px;border-radius:50px;font-size:14px;font-weight:700;">
                Reply to {{ $data['name'] }}
            </a>
        </div>

        <p style="margin:24px 0 0;color:#6b6b6b;font-size:12px;">
            Received {{ now()->format('D, d M Y \a\t H:i') }} · Sent via your portfolio at grace-sellah
        </p>
    </div>

</div>
</body>
</html>
