@extends('admin.layout')
@section('page-title', 'Server tools')

@section('content')
<div class="server-hero">
    <div>
        <span class="eyebrow">Production maintenance</span>
        <h1>Laravel server tools</h1>
        <p>Run a limited set of approved Artisan operations when terminal access is unavailable.</p>
    </div>
    <span class="environment-badge">{{ strtoupper($status['environment']) }}</span>
</div>

@if($openBootstrapMode)
    <div class="bootstrap-warning">
        <strong>Open bootstrap mode is active.</strong>
        Commands can run without login or a deployment token. Set <code>DEPLOYMENT_PUBLIC_NO_TOKEN=false</code> immediately after setup.
    </div>
@endif

<div class="dashboard-grid">
    <section class="card">
        <div class="section-heading"><div><span class="eyebrow">Environment</span><h2>Server status</h2></div></div>
        <div class="status-grid">
            @foreach([
                'PHP version' => $status['php_version'],
                'Laravel version' => $status['laravel_version'],
                'Application URL' => $status['app_url'],
                '.env file' => $status['env_file_exists'],
                'Application key' => $status['app_key_set'],
                'Vendor autoload' => $status['vendor_autoload'],
                'Storage writable' => $status['storage_writable'],
                'Cache writable' => $status['bootstrap_cache_writable'],
            ] as $label => $value)
                <div>
                    <span>{{ $label }}</span>
                    @if(is_bool($value))
                        <strong class="{{ $value ? 'is-ok' : 'is-bad' }}">{{ $value ? 'Ready' : 'Needs attention' }}</strong>
                    @else
                        <strong>{{ $value }}</strong>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    <section class="card">
        <div class="section-heading"><div><span class="eyebrow">Allowlisted commands</span><h2>Run maintenance</h2></div></div>
        <p class="tool-note">Only the operations shown below can run. Arbitrary shell or Artisan input is not accepted.</p>
        <form method="POST" action="{{ route($runRoute) }}">
            @csrf
            @if($toolTokenRequired)
                <div class="form-group">
                    <label for="tool_token">Deployment token</label>
                    <input id="tool_token" type="password" name="tool_token" required autocomplete="off" placeholder="DEPLOYMENT_TOOL_TOKEN">
                </div>
            @endif
            <div class="form-group">
                <label for="confirmation">Migration confirmation</label>
                <input id="confirmation" type="text" name="confirmation" autocomplete="off" placeholder="Type MIGRATE only when running migrations">
            </div>
            <div class="command-grid">
                @foreach($availableActions as $action => $label)
                    <button type="submit" name="action" value="{{ $action }}" class="command-button {{ $action === 'migrate_force' ? 'command-warning' : '' }}">
                        <span>{{ $label }}</span>
                        <small>{{ match($action) {
                            'clear_cache' => 'php artisan optimize:clear',
                            'clear_config' => 'php artisan config:clear',
                            'cache_config' => 'php artisan config:cache',
                            'clear_routes' => 'php artisan route:clear',
                            'cache_routes' => 'php artisan route:cache',
                            'clear_views' => 'php artisan view:clear',
                            'cache_views' => 'php artisan view:cache',
                            'storage_link' => 'php artisan storage:link',
                            'migrate_force' => 'php artisan migrate --force',
                            default => '',
                        } }}</small>
                    </button>
                @endforeach
            </div>
        </form>
    </section>
</div>

@if(session('command_output'))
    <section class="card output-card">
        <div class="section-heading"><div><span class="eyebrow">Command result</span><h2>Last output</h2></div></div>
        <pre>{{ session('command_output') }}</pre>
    </section>
@endif

<style>
.server-hero{display:flex;align-items:flex-end;justify-content:space-between;gap:24px;margin-bottom:20px;padding:28px;border-radius:15px;color:#fff;background:#101318}.server-hero h1{margin:6px 0 7px;font-size:28px}.server-hero p{max-width:610px;color:#aeb6c2;font-size:12px}.environment-badge{padding:7px 11px;border:1px solid #39404b;border-radius:99px;color:#f0b95d;font-size:9px;font-weight:800;letter-spacing:.12em}.status-grid{display:grid}.status-grid>div{display:flex;align-items:center;justify-content:space-between;gap:15px;padding:12px 0;border-bottom:1px solid #f1f5f9}.status-grid span{color:#64748b;font-size:10px}.status-grid strong{font-size:11px}.is-ok{color:#16834f}.is-bad{color:#b42318}.tool-note{margin:16px 0;color:#64748b;font-size:11px;line-height:1.6}.command-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:9px}.command-button{display:flex;align-items:flex-start;flex-direction:column;gap:4px;padding:12px;border:1px solid #dedbd4;border-radius:9px;color:#111827;background:#faf9f6;text-align:left;cursor:pointer}.command-button:hover{border-color:#c18a32;background:#fff8eb}.command-button span{font-size:11px;font-weight:800}.command-button small{color:#7b8492;font:9px ui-monospace,monospace}.command-warning{border-color:#e7c989;background:#fff9e9}.output-card{margin-top:18px}.output-card pre{margin-top:15px;padding:16px;overflow:auto;border-radius:9px;color:#d7dde7;background:#0d1118;font:11px/1.65 ui-monospace,monospace;white-space:pre-wrap}@media(max-width:700px){.server-hero{align-items:flex-start;flex-direction:column}.command-grid{grid-template-columns:1fr}}
.bootstrap-warning{margin-bottom:18px;padding:14px 16px;border:1px solid #efc66f;border-radius:10px;color:#7a4b05;background:#fff6df;font-size:11px;line-height:1.6}.bootstrap-warning strong{display:block;font-size:12px}.bootstrap-warning code{font-family:ui-monospace,monospace}
</style>
@endsection
