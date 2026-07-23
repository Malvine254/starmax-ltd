<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance — {{ $event->title }}</title>
    <style>
        *{box-sizing:border-box}body{margin:0;padding:32px;color:#111827;background:#fff;font-family:Arial,sans-serif}.toolbar{display:flex;justify-content:flex-end;gap:8px;margin-bottom:24px}.toolbar button{padding:9px 14px;border:0;border-radius:6px;color:#fff;background:#111827;cursor:pointer}.sheet{max-width:1100px;margin:auto}.brand{font-size:14px;font-weight:800;letter-spacing:.12em}.brand span{color:#b7791f}.header{display:flex;justify-content:space-between;gap:30px;margin:18px 0 26px;padding-bottom:18px;border-bottom:2px solid #111827}.header h1{margin:0 0 7px;font-size:25px}.header p{margin:3px 0;color:#4b5563;font-size:11px}.total{min-width:110px;text-align:right}.total b{display:block;font-size:30px}.total span{font-size:9px;text-transform:uppercase}table{width:100%;border-collapse:collapse;font-size:10px}th,td{padding:10px 8px;border:1px solid #cbd5e1;text-align:left;vertical-align:middle}th{background:#f3f4f6;font-size:8px;letter-spacing:.06em;text-transform:uppercase}.check-cell{width:46px}.signature{width:145px;height:38px}.notes{margin-top:25px;padding-top:15px;border-top:1px solid #d1d5db;font-size:9px;color:#6b7280}@media print{body{padding:0}.toolbar{display:none}.sheet{max-width:none}@page{size:landscape;margin:12mm}}
    </style>
</head>
<body>
<div class="toolbar"><button type="button" onclick="window.print()">Print attendance register</button></div>
<main class="sheet">
    <div class="brand">STARMAX<span>.</span></div>
    <header class="header">
        <div>
            <h1>{{ $event->title }}</h1>
            <p>{{ $event->starts_at?->format('D, d M Y · g:i A') }}@if($event->ends_at) – {{ $event->ends_at->format('g:i A') }}@endif</p>
            <p>{{ $event->location }} · {{ $event->format ?: 'Event' }}</p>
        </div>
        <div class="total"><b>{{ $event->registrations->count() }}</b><span>Registered</span></div>
    </header>
    <table>
        <thead><tr><th>#</th><th>Attendee</th><th>Email</th><th>Phone</th><th>Company</th><th>Status</th><th class="check-cell">Present</th><th class="signature">Signature</th></tr></thead>
        <tbody>
        @forelse($event->registrations as $registration)
            <tr>
                <td>{{ $loop->iteration }}</td><td><strong>{{ $registration->name }}</strong></td><td>{{ $registration->email }}</td><td>{{ $registration->phone ?: '—' }}</td><td>{{ $registration->company ?: '—' }}</td><td>{{ str($registration->status)->headline() }}</td><td></td><td></td>
            </tr>
        @empty
            <tr><td colspan="8" style="padding:30px;text-align:center;">No attendees registered.</td></tr>
        @endforelse
        </tbody>
    </table>
    <p class="notes">Generated {{ now()->format('D, d M Y · g:i A') }} · Starmax event attendance register</p>
</main>
</body>
</html>
