<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin sign in — Starmax Ltd</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        :root {
            --ink: #111827;
            --muted: #64748b;
            --line: #e2e8f0;
            --amber: #f59e0b;
            --danger: #b91c1c;
        }
        body { margin: 0; min-height: 100vh; font-family: Inter, system-ui, sans-serif; color: var(--ink); background: #f8fafc; -webkit-font-smoothing: antialiased; }
        .shell { min-height: 100vh; display: grid; grid-template-columns: minmax(360px, .92fr) minmax(520px, 1.08fr); }
        .story { position: relative; overflow: hidden; padding: clamp(36px, 6vw, 82px); background: #070b12; color: white; display: flex; flex-direction: column; justify-content: space-between; }
        .story::before { content: ""; position: absolute; width: 520px; height: 520px; border-radius: 50%; right: -240px; top: -190px; border: 1px solid rgba(255,255,255,.12); box-shadow: 0 0 0 80px rgba(255,255,255,.025), 0 0 0 160px rgba(255,255,255,.018); }
        .story::after { content: ""; position: absolute; inset: auto -18% -40% 20%; height: 65%; background: radial-gradient(circle, rgba(245,158,11,.22), transparent 66%); }
        .brand, .story-copy, .trust { position: relative; z-index: 1; }
        .brand { display: inline-flex; align-items: center; gap: 12px; width: fit-content; color: white; text-decoration: none; font-size: 18px; font-weight: 800; letter-spacing: -.02em; }
        .brand-mark { width: 38px; height: 38px; border-radius: 10px; display: grid; place-items: center; background: var(--amber); color: #111; font-size: 18px; }
        .eyebrow { margin: 0 0 18px; color: #fbbf24; font-size: 12px; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; }
        h1 { max-width: 580px; margin: 0; font-size: clamp(42px, 5vw, 70px); line-height: 1.02; letter-spacing: -.055em; }
        .story-copy > p:last-child { max-width: 540px; margin: 24px 0 0; color: #aeb8c8; line-height: 1.75; font-size: 15px; }
        .trust { display: flex; flex-wrap: wrap; gap: 22px; color: #cbd5e1; font-size: 12px; }
        .trust span { display: flex; align-items: center; gap: 8px; }
        .trust svg { color: #fbbf24; }
        .panel { display: grid; place-items: center; padding: 38px; background: #fff; }
        .form-wrap { width: min(100%, 430px); }
        .back { display: inline-flex; align-items: center; gap: 8px; color: var(--muted); text-decoration: none; font-size: 13px; font-weight: 600; margin-bottom: clamp(42px, 8vh, 82px); }
        .back:hover { color: var(--ink); }
        .kicker { margin: 0 0 10px; color: var(--amber); font-size: 12px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
        h2 { margin: 0; font-size: 32px; letter-spacing: -.04em; }
        .intro { margin: 12px 0 32px; color: var(--muted); font-size: 14px; line-height: 1.6; }
        .alert { margin-bottom: 20px; padding: 12px 14px; border: 1px solid #fecaca; border-radius: 9px; background: #fef2f2; color: #991b1b; font-size: 13px; line-height: 1.5; }
        .field { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 700; }
        .input-wrap { position: relative; }
        input[type="email"], input[type="password"], input[type="text"] { width: 100%; height: 50px; border: 1px solid #cbd5e1; border-radius: 9px; padding: 0 46px 0 14px; color: var(--ink); background: white; font: inherit; font-size: 14px; outline: none; transition: border .18s, box-shadow .18s; }
        input:focus { border-color: #111827; box-shadow: 0 0 0 3px rgba(15,23,42,.09); }
        .input-icon { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; }
        .toggle-password { position: absolute; right: 8px; top: 50%; transform: translateY(-50%); border: 0; background: transparent; color: #64748b; padding: 7px; cursor: pointer; }
        .error { margin-top: 7px; color: var(--danger); font-size: 12px; }
        .options { display: flex; justify-content: space-between; align-items: center; gap: 18px; margin: 4px 0 24px; }
        .remember { display: flex; align-items: center; gap: 9px; color: #475569; font-size: 13px; cursor: pointer; }
        .remember input { width: 16px; height: 16px; accent-color: #111827; }
        .support { color: #475569; font-size: 12px; text-decoration: none; font-weight: 600; }
        .support:hover { color: #111827; }
        .submit { width: 100%; height: 50px; border: 0; border-radius: 9px; background: #111827; color: white; font: inherit; font-size: 14px; font-weight: 700; cursor: pointer; transition: transform .18s, background .18s; }
        .submit:hover { background: #030712; transform: translateY(-1px); }
        .submit:focus-visible { outline: 3px solid rgba(245,158,11,.35); outline-offset: 2px; }
        .security-note { display: flex; gap: 10px; margin: 24px 0 0; padding-top: 22px; border-top: 1px solid var(--line); color: #64748b; font-size: 11px; line-height: 1.55; }
        .security-note svg { flex: 0 0 auto; margin-top: 1px; }
        @media (max-width: 880px) {
            .shell { grid-template-columns: 1fr; }
            .story { min-height: 260px; gap: 52px; padding: 32px; }
            .story h1 { font-size: clamp(34px, 9vw, 48px); max-width: 600px; }
            .story-copy > p:last-child, .trust { display: none; }
            .panel { padding: 34px 24px 52px; }
            .back { margin-bottom: 44px; }
        }
        @media (max-width: 480px) {
            .story { min-height: 220px; }
            .options { align-items: flex-start; }
        }
    </style>
</head>
<body>
<main class="shell">
    <section class="story" aria-label="Starmax admin portal">
        <a class="brand" href="/" aria-label="Starmax home">
            <span class="brand-mark">S</span>
            <span>STARMAX</span>
        </a>
        <div class="story-copy">
            <p class="eyebrow">Operations portal</p>
            <h1>Run every detail with confidence.</h1>
            <p>A focused workspace for Starmax teams to manage properties, customers, events, and the work that keeps everything moving.</p>
        </div>
        <div class="trust">
            <span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
                Protected admin access
            </span>
            <span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
                Secure session handling
            </span>
        </div>
    </section>

    <section class="panel">
        <div class="form-wrap">
            <a class="back" href="/">
                <span aria-hidden="true">←</span> Back to website
            </a>
            <p class="kicker">Authorized access only</p>
            <h2>Welcome back</h2>
            <p class="intro">Sign in with your Starmax administrator account to continue.</p>

            @if(session('error'))
                <div class="alert" role="alert">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf
                <div class="field">
                    <label for="email">Email address</label>
                    <div class="input-wrap">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" inputmode="email" required autofocus aria-describedby="@error('email') email-error @enderror">
                        <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-10 6L2 7"/></svg>
                    </div>
                    @error('email')<div class="error" id="email-error" role="alert">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <input id="password" type="password" name="password" autocomplete="current-password" required aria-describedby="@error('password') password-error @enderror">
                        <button class="toggle-password" type="button" aria-label="Show password" aria-pressed="false">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    @error('password')<div class="error" id="password-error" role="alert">{{ $message }}</div>@enderror
                </div>

                <div class="options">
                    <label class="remember" for="remember">
                        <input type="checkbox" name="remember" id="remember" value="1">
                        Keep me signed in
                    </label>
                    <a class="support" href="mailto:info@starmaxltd.com?subject=Admin%20access%20help">Need access help?</a>
                </div>

                <button class="submit" type="submit">Sign in securely</button>
            </form>

            <p class="security-note">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Your sign-in is protected by request verification, rate limiting, role-based access, and secure session renewal.
            </p>
        </div>
    </section>
</main>
<script>
    const toggle = document.querySelector('.toggle-password');
    const password = document.getElementById('password');
    toggle?.addEventListener('click', () => {
        const showing = password.type === 'text';
        password.type = showing ? 'password' : 'text';
        toggle.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
        toggle.setAttribute('aria-pressed', String(!showing));
        password.focus();
    });
</script>
</body>
</html>
