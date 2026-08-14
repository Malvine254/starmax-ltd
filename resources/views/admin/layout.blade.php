<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page-title', 'Portfolio') — Starmax Studio</title>
    <style>
        * { box-sizing:border-box; margin:0; padding:0; }
        html,body { height:100%; }
        body { min-height:100vh; display:flex; overflow:hidden; color:#111827; background:#f6f7f9; font-family:Inter,ui-sans-serif,system-ui,sans-serif; }
        .sidebar { position:sticky; top:0; width:248px; height:100vh; flex:0 0 auto; display:flex; flex-direction:column; overflow:hidden; color:#cbd5e1; background:#070b12; }
        .sidebar-logo { display:flex; align-items:center; gap:11px; padding:25px 22px; color:#fff; border-bottom:1px solid rgba(255,255,255,.08); }
        .sidebar-logo-mark { width:34px; height:34px; display:grid; place-items:center; border-radius:9px; color:#111827; background:#f59e0b; font-weight:800; }
        .sidebar-logo-copy strong { display:block; font-size:14px; }
        .sidebar-logo-copy small { display:block; margin-top:2px; color:#64748b; font-size:10px; font-weight:600; letter-spacing:.08em; text-transform:uppercase; }
        .nav-label { padding:24px 22px 8px; color:#64748b; font-size:10px; font-weight:700; letter-spacing:.12em; text-transform:uppercase; }
        .sidebar nav { min-height:0; flex:1; overflow-y:auto; overscroll-behavior:contain; scrollbar-width:thin; scrollbar-color:#334155 transparent; }
        .sidebar nav a { display:flex; align-items:center; gap:10px; margin:3px 12px; padding:11px 12px; border-radius:8px; color:#94a3b8; text-decoration:none; font-size:13px; font-weight:600; transition:.15s; }
        .sidebar nav a:hover,.sidebar nav a.active { color:#fff; background:#171d28; }
        .sidebar nav a.active { box-shadow:inset 3px 0 #f59e0b; }
        .sidebar-bottom { margin-top:auto; padding:18px 22px; border-top:1px solid rgba(255,255,255,.08); }
        .main { min-width:0; height:100vh; flex:1; display:flex; flex-direction:column; overflow:hidden; }
        .topbar { min-height:62px; flex:0 0 auto; display:flex; align-items:center; justify-content:space-between; gap:20px; padding:14px 28px; background:#fff; border-bottom:1px solid #e5e7eb; }
        .content { min-height:0; flex:1; padding:30px; overflow-y:auto; overscroll-behavior:contain; }
        .card,.stat { color:inherit; background:#fff; border:1px solid #e2e8f0; border-radius:12px; }
        .card { padding:20px; }
        .stat-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(165px,1fr)); gap:14px; margin-bottom:20px; }
        .stat { padding:18px; text-decoration:none; transition:.18s; }
        .stat:hover { transform:translateY(-2px); box-shadow:0 10px 24px rgba(15,23,42,.07); }
        .stat-label { margin-bottom:5px; color:#64748b; font-size:11px; font-weight:700; }
        .stat-value { color:#111827; font-size:28px; font-weight:800; letter-spacing:-.04em; }
        .stat-meta { margin-top:5px; color:#94a3b8; font-size:10px; }
        .status-value { color:#15803d; font-size:22px; }
        .welcome-panel { display:flex; align-items:flex-end; justify-content:space-between; gap:28px; margin-bottom:20px; padding:30px; border-radius:16px; color:#fff; background:linear-gradient(135deg,#090d15,#1d2635); box-shadow:0 16px 40px rgba(15,23,42,.12); }
        .welcome-panel h1 { margin:7px 0 8px; font-size:30px; letter-spacing:-.04em; }
        .welcome-panel p { max-width:650px; color:#aeb8c8; font-size:13px; line-height:1.65; }
        .eyebrow { color:#d97706; font-size:10px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; }
        .welcome-panel .eyebrow { color:#fbbf24; }
        .dashboard-grid { display:grid; grid-template-columns:minmax(0,1.25fr) minmax(280px,.75fr); gap:18px; }
        .section-heading { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; padding-bottom:16px; border-bottom:1px solid #edf0f3; }
        .section-heading h2 { margin:5px 0 0; font-size:17px; }
        .section-heading a { color:#475569; font-size:12px; font-weight:700; text-decoration:none; }
        .activity-row { display:flex; align-items:center; gap:12px; padding:14px 0; border-bottom:1px solid #f1f5f9; color:inherit; text-decoration:none; }
        .activity-row:last-child { border-bottom:0; }
        .activity-avatar { width:36px; height:36px; display:grid; place-items:center; flex:0 0 auto; border-radius:10px; color:#92400e; background:#fef3c7; font-size:12px; font-weight:800; }
        .activity-copy { min-width:0; display:flex; flex:1; flex-direction:column; gap:3px; }
        .activity-copy strong { font-size:12px; }
        .activity-copy small { overflow:hidden; color:#64748b; font-size:11px; text-overflow:ellipsis; white-space:nowrap; }
        .activity-row time { color:#94a3b8; font-size:10px; white-space:nowrap; }
        .event-date { width:40px; height:42px; display:grid; place-items:center; flex:0 0 auto; padding:4px; border-radius:8px; color:#fff; background:#111827; line-height:1; }
        .event-date b { font-size:14px; }
        .event-date small { color:#fbbf24; font-size:8px; text-transform:uppercase; }
        .empty-state { padding:30px 5px 12px; color:#94a3b8; font-size:12px; text-align:center; }
        table { width:100%; border-collapse:collapse; font-size:13px; }
        th { padding:10px 12px; color:#64748b; border-bottom:2px solid #e2e8f0; font-size:11px; text-align:left; text-transform:uppercase; }
        td { padding:10px 12px; border-bottom:1px solid #f1f5f9; }
        .badge { display:inline-block; padding:2px 8px; border-radius:99px; font-size:11px; font-weight:600; }
        .badge-green { color:#16a34a; background:#dcfce7; }.badge-yellow { color:#ca8a04; background:#fef9c3; }.badge-red { color:#dc2626; background:#fee2e2; }.badge-blue { color:#1d4ed8; background:#dbeafe; }.badge-gray { color:#64748b; background:#f1f5f9; }
        .btn { display:inline-block; padding:8px 14px; border:0; border-radius:7px; cursor:pointer; font-size:12px; text-decoration:none; }
        .btn-primary { color:#fff; background:#111827; }.welcome-panel .btn-primary { flex:0 0 auto; color:#111827; background:#f59e0b; font-weight:800; }
        .btn-danger { color:#fff; background:#dc2626; }.btn-secondary { color:#1e293b; background:#e2e8f0; }
        .alert-success,.alert-error { padding:10px 14px; margin-bottom:16px; border-radius:7px; font-size:13px; }
        .alert-success { color:#166534; background:#dcfce7; border:1px solid #86efac; }.alert-error { color:#991b1b; background:#fee2e2; border:1px solid #fca5a5; }
        .form-group { margin-bottom:16px; }.form-group label { display:block; margin-bottom:5px; font-size:12px; font-weight:700; }
        .form-group input,.form-group select,.form-group textarea { width:100%; padding:9px 12px; border:1px solid #cbd5e1; border-radius:6px; font:inherit; font-size:13px; }
        .form-error { margin-top:3px; color:#dc2626; font-size:11px; }
        .pagination { display:flex; flex-wrap:wrap; gap:6px; margin-top:16px; }.pagination a,.pagination span { padding:6px 12px; color:#374151; border:1px solid #e2e8f0; border-radius:6px; font-size:12px; text-decoration:none; }
        @media(max-width:900px){.sidebar{width:82px}.sidebar-logo-copy,.nav-label,.sidebar nav a span,.sidebar-bottom .user-name{display:none}.sidebar nav a{justify-content:center}.dashboard-grid{grid-template-columns:1fr}}
        @media(max-width:640px){html,body{height:auto}body{min-height:100vh;display:block;overflow:auto}.sidebar{position:sticky;z-index:20;top:0;width:100%;height:auto;overflow:visible}.sidebar-logo{padding:14px 18px}.sidebar-logo-copy{display:block}.sidebar nav{display:flex;overflow-x:auto;overflow-y:hidden;padding:6px}.sidebar nav a{min-width:max-content;margin:2px}.sidebar nav a span{display:inline}.nav-label,.sidebar-bottom{display:none}.main{height:auto;min-height:calc(100vh - 118px);overflow:visible}.topbar{position:sticky;z-index:15;top:0;padding:12px 18px}.content{min-height:0;padding:18px;overflow:visible}.welcome-panel{align-items:flex-start;flex-direction:column;padding:22px}.stat-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
    </style>
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-logo">
        <span class="sidebar-logo-mark">S</span>
        <span class="sidebar-logo-copy"><strong>Starmax Studio</strong><small>Portfolio workspace</small></span>
    </div>
    <nav>
        <div class="nav-label">Workspace</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">◫ <span>Overview</span></a>
        <a href="{{ route('grace-sellah.admin.home') }}" class="{{ request()->routeIs('grace-sellah.admin*') ? 'active' : '' }}">✦ <span>Portfolio</span></a>
        <a href="{{ route('admin.contact-messages.index') }}" class="{{ request()->routeIs('admin.contact-messages*') ? 'active' : '' }}">✉ <span>Enquiries</span></a>
        <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.events*') ? 'active' : '' }}">◇ <span>Events</span></a>
        <a href="{{ route('admin.event-registrations.index') }}" class="{{ request()->routeIs('admin.event-registrations*') ? 'active' : '' }}">✓ <span>Registrations</span></a>
        <a href="{{ route('admin.server-tools.index') }}" class="{{ request()->routeIs('admin.server-tools*') ? 'active' : '' }}">⌘ <span>Server tools</span></a>
    </nav>
    <div class="sidebar-bottom">
        @auth
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" style="padding:0;color:#94a3b8;background:none;border:0;cursor:pointer;font-size:12px;">Sign out <span class="user-name">· {{ auth()->user()->name }}</span></button>
            </form>
        @endauth
    </div>
</aside>
<div class="main">
    <header class="topbar">
        <span style="font-size:14px;font-weight:700;">@yield('page-title', 'Portfolio')</span>
        <a href="{{ url('/grace-sellah') }}" target="_blank" rel="noopener" style="color:#475569;font-size:12px;font-weight:600;text-decoration:none;">View portfolio ↗</a>
    </header>
    <main class="content">
        @if(session('success'))<div class="alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert-error">{{ session('error') }}</div>@endif
        @yield('content')
    </main>
</div>
</body>
</html>
