<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Deployment Tools</title>
    <style>
        body { font-family: Arial, sans-serif; background:#0f172a; color:#e2e8f0; margin:0; padding:20px; }
        .wrap { max-width:980px; margin:0 auto; }
        .card { background:#111827; border:1px solid #334155; border-radius:12px; padding:18px; margin-bottom:14px; }
        h1 { margin:0 0 10px; font-size:24px; }
        h2 { margin:0 0 10px; font-size:18px; }
        table { width:100%; border-collapse:collapse; font-size:14px; }
        th, td { border-bottom:1px solid #1f2937; text-align:left; padding:8px; }
        th { color:#94a3b8; width:280px; }
        .ok { color:#22c55e; font-weight:700; }
        .bad { color:#f87171; font-weight:700; }
        .note { color:#93c5fd; font-size:13px; }
        .error { background:#7f1d1d; border:1px solid #dc2626; color:#fecaca; padding:10px; border-radius:8px; margin-bottom:12px; }
        .success { background:#14532d; border:1px solid #22c55e; color:#bbf7d0; padding:10px; border-radius:8px; margin-bottom:12px; }
        .actions { display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:10px; }
        .btn { background:#22c55e; border:none; color:#052e16; padding:12px 14px; border-radius:8px; font-weight:700; cursor:pointer; text-align:left; }
        .btn:hover { opacity:0.95; }
        pre { white-space:pre-wrap; background:#020617; border:1px solid #1e293b; padding:12px; border-radius:8px; font-size:12px; }
        input[type="password"] { width:100%; max-width:520px; background:#020617; color:#e2e8f0; border:1px solid #334155; border-radius:8px; padding:10px; }
        label { display:block; font-weight:700; margin:0 0 8px; }
        .field { margin-bottom:14px; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="card">
        <h1>Public Deployment Tools</h1>
        <p class="note">Use this page when host terminal access is unavailable. Keep the token private.</p>
    </div>

    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <h2>Access Check</h2>
        <table>
            <tr><th>Token configured in .env</th><td>{!! $isConfigured ? '<span class="ok">Yes</span>' : '<span class="bad">No</span>' !!}</td></tr>
            <tr><th>Token valid in request</th><td>{!! $isValidToken ? '<span class="ok">Yes</span>' : '<span class="bad">No</span>' !!}</td></tr>
        </table>
    </div>

    <div class="card">
        <h2>Server Status</h2>
        <table>
            <tr><th>PHP Version</th><td>{{ $status['php_version'] }}</td></tr>
            <tr><th>Laravel Version</th><td>{{ $status['laravel_version'] }}</td></tr>
            <tr><th>Environment</th><td>{{ $status['environment'] }}</td></tr>
            <tr><th>APP_URL</th><td>{{ $status['app_url'] }}</td></tr>
            <tr><th>APP_KEY set</th><td>{!! $status['app_key_set'] ? '<span class="ok">Yes</span>' : '<span class="bad">No</span>' !!}</td></tr>
            <tr><th>vendor/autoload.php</th><td>{!! $status['vendor_autoload'] ? '<span class="ok">Present</span>' : '<span class="bad">Missing</span>' !!}</td></tr>
            <tr><th>storage writable</th><td>{!! $status['storage_writable'] ? '<span class="ok">Yes</span>' : '<span class="bad">No</span>' !!}</td></tr>
            <tr><th>bootstrap/cache writable</th><td>{!! $status['bootstrap_cache_writable'] ? '<span class="ok">Yes</span>' : '<span class="bad">No</span>' !!}</td></tr>
        </table>
    </div>

    <div class="card">
        <h2>Run Commands</h2>
        <form method="POST" action="{{ route('deployment-tools.public.run') }}">
            @csrf
            <div class="field">
                <label for="token">Deployment Token</label>
                <input id="token" type="password" name="token" value="{{ $token }}" required placeholder="DEPLOYMENT_PUBLIC_TOKEN">
            </div>

            <div class="actions">
                @foreach($availableActions as $action => $label)
                    <button type="submit" name="action" value="{{ $action }}" class="btn">{{ $label }}</button>
                @endforeach
            </div>
        </form>
    </div>

    @if(session('command_output'))
        <div class="card">
            <h2>Last Output</h2>
            <pre>{{ session('command_output') }}</pre>
        </div>
    @endif
</div>
</body>
</html>
