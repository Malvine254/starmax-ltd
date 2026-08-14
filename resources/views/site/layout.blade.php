<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Starmax Ltd — Innovative Digital Solutions')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@0.460.0/dist/umd/lucide.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #f8fafc;
            --surface: #ffffff;
            --text: #0f172a;
            --text-muted: #64748b;
            --brand: #111827;
            --brand-dark: #030712;
            --brand-light: #f3f4f6;
            --cyan: #475569;
            --amber: #f59e0b;
            --emerald: #10b981;
            --rose: #f43f5e;
            --border: #e2e8f0;
            --radius: 8px;
            --radius-sm: 10px;
            --radius-xs: 6px;
            --max-w: 1200px;
            --slider-w: 1280px;
            --page-gutter: clamp(18px, 5vw, 48px);
            --tr: 0.22s ease;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
            --shadow-lg: 0 16px 48px rgba(0,0,0,0.12);
            --shadow-xl: 0 32px 80px rgba(0,0,0,0.14);
        }

        html { scroll-behavior: smooth; font-size: 15px; }
        body { font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; color: var(--text); background: var(--bg); line-height: 1.6; -webkit-font-smoothing: antialiased; text-rendering: optimizeLegibility; overflow-x: hidden; }
        body.menu-open { overflow: hidden; }
        ::-webkit-scrollbar { width: 6px; } ::-webkit-scrollbar-track { background: #f1f5f9; } ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 6px; }

        /* ── HEADER ──────────────────────────────────── */
        .site-header {
            position: fixed; top: 0; left: 0; right: 0; z-index: 999;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(226,232,240,0.8);
            box-shadow: 0 1px 0 rgba(0,0,0,0.04);
            transition: background var(--tr), box-shadow var(--tr);
        }
        .site-header.scrolled { background: rgba(255,255,255,0.98); box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header-inner { width: min(calc(100% - (var(--page-gutter) * 2)), var(--max-w)); margin: 0 auto; height: 68px; display: flex; align-items: center; justify-content: space-between; gap: 32px; }
        .brand { display: flex; align-items: center; gap: 10px; text-decoration: none; flex-shrink: 0; }
        .brand-wordmark {
            display: inline-flex; align-items: baseline; color: #111827;
            font-family: 'Manrope', sans-serif; font-size: 21px; font-weight: 800;
            letter-spacing: -0.055em; line-height: 1; text-transform: uppercase;
        }
        .brand-wordmark span { color: #d99a31; }
        /* nav */
        .main-nav { display: flex; align-items: center; gap: 2px; }
        .nav-item { position: relative; }
        .nav-item::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            top: 100%;
            height: 12px;
        }
        .nav-link {
            display: flex; align-items: center; gap: 4px; padding: 8px 14px; border-radius: 8px;
            font-size: 14px; font-weight: 500; color: var(--text-muted); text-decoration: none;
            transition: all var(--tr); white-space: nowrap; cursor: pointer; border: none; background: none; font-family: inherit;
        }
        .nav-link svg { width: 14px; height: 14px; flex-shrink: 0; transition: transform var(--tr); }
        .nav-link:hover, .nav-link.active { color: var(--text); background: #f1f5f9; }
        .nav-link.active { color: var(--brand); background: var(--brand-light); font-weight: 600; }
        .nav-item:hover .nav-link svg, .nav-item.open .nav-link svg { transform: rotate(180deg); }

        /* dropdown */
        .nav-dropdown {
            position: absolute; top: calc(100% + 2px); left: 50%; transform: translateX(-50%) translateY(-4px);
            min-width: 240px; background: #fff; border: 1px solid var(--border); border-radius: 16px;
            padding: 8px; box-shadow: var(--shadow-xl); z-index: 1000;
            opacity: 0; visibility: hidden; transition: opacity 0.18s ease, transform 0.18s ease, visibility 0.18s;
            pointer-events: none;
        }
        .nav-item:hover .nav-dropdown,
        .nav-item:focus-within .nav-dropdown,
        .nav-item.open .nav-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
            pointer-events: auto;
        }
        .dropdown-item {
            display: flex; align-items: center; gap: 12px; padding: 10px 12px;
            border-radius: 10px; text-decoration: none; color: var(--text);
            font-size: 14px; transition: background var(--tr); white-space: nowrap;
        }
        .dropdown-item:hover { background: #f8fafc; }
        .dropdown-icon {
            width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .dropdown-icon svg { width: 16px; height: 16px; }
        .dropdown-icon.purple,
        .dropdown-icon.blue,
        .dropdown-icon.cyan,
        .dropdown-icon.teal,
        .dropdown-icon.orange,
        .dropdown-icon.emerald,
        .dropdown-icon.rose,
        .dropdown-icon.amber {
            background: #f3f4f6;
            color: #111827;
        }
        .dropdown-text strong { display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 1px; }
        .dropdown-text span { font-size: 12px; color: var(--text-muted); }
        .dropdown-divider { height: 1px; background: var(--border); margin: 6px 4px; }

        /* header CTA */
        .header-cta { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
        .btn-cta {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 20px; border-radius: 999px; font-size: 14px; font-weight: 600;
            text-decoration: none; transition: all var(--tr); white-space: nowrap; cursor: pointer; border: none; font-family: inherit;
        }
        .btn-cta svg { width: 14px; height: 14px; }
        .btn-cta-ghost { background: transparent; color: var(--text); }
        .btn-cta-ghost:hover { background: #f1f5f9; }
        .btn-cta-primary {
            background: #111827; color: #fff;
            box-shadow: 0 4px 14px rgba(17,24,39,0.24);
        }
        .btn-cta-primary:hover { transform: translateY(-1px); background: #030712; box-shadow: 0 6px 20px rgba(17,24,39,0.32); }

        /* mobile toggle */
        .menu-toggle {
            display: none; width: 40px; height: 40px; border-radius: 10px;
            border: 1.5px solid var(--border); background: var(--surface); color: var(--text);
            cursor: pointer; align-items: center; justify-content: center; transition: all var(--tr);
        }
        .menu-toggle svg { width: 20px; height: 20px; }
        .menu-toggle:hover { border-color: var(--brand); color: var(--brand); }

        /* mobile drawer */
        .mobile-nav {
            position: fixed; top: 68px; left: 0; right: 0; bottom: 0; z-index: 998;
            background: rgba(255,255,255,0.98); backdrop-filter: blur(20px);
            padding: 16px 20px 32px; overflow-y: auto;
            opacity: 0; visibility: hidden; transform: translateX(8px);
            transition: opacity 0.25s ease, visibility 0.25s ease, transform 0.25s ease;
            display: flex; flex-direction: column; gap: 4px;
        }
        .mobile-nav.open { opacity: 1; visibility: visible; transform: translateX(0); }
        .mobile-nav-link {
            display: flex; align-items: center; gap: 12px; padding: 12px 14px;
            border-radius: 12px; text-decoration: none; color: var(--text); font-size: 15px; font-weight: 500;
            transition: background var(--tr);
        }
        .mobile-nav-link:hover { background: #f1f5f9; }
        .mobile-nav-link.active { color: var(--brand); background: var(--brand-light); }
        .mobile-nav-link svg { width: 18px; height: 18px; color: var(--text-muted); }
        .mobile-section-label { font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--text-muted); padding: 14px 14px 6px; }
        .mobile-sub-link { display: flex; align-items: center; gap: 10px; padding: 10px 14px 10px 20px; border-radius: 10px; text-decoration: none; color: var(--text-muted); font-size: 14px; transition: background var(--tr); }
        .mobile-sub-link:hover { background: #f1f5f9; color: var(--text); }
        .mobile-divider { height: 1px; background: var(--border); margin: 8px 0; }
        .mobile-cta { display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 16px; padding: 14px; border-radius: 8px; background: #111827; color: #fff; font-size: 15px; font-weight: 600; text-decoration: none; }
        .header-spacer { height: 68px; }

        /* ── LAYOUT ──────────────────────────────────── */
        .container { width: min(calc(100% - (var(--page-gutter) * 2)), var(--max-w)); margin: 0 auto; }
        .section { width: min(calc(100% - (var(--page-gutter) * 2)), var(--max-w)); margin: 0 auto; padding: 56px 0; }
        .section-sm { width: min(calc(100% - (var(--page-gutter) * 2)), var(--max-w)); margin: 0 auto; padding: 40px 0; }
        .section-header { text-align: center; max-width: 600px; margin: 0 auto 36px; }
        .section-header.left { text-align: left; margin-left: 0; }

        /* ── TYPOGRAPHY ──────────────────────────────── */
        .eyebrow { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--brand); margin-bottom: 12px; }
        .eyebrow::before { content: ''; width: 20px; height: 2px; background: linear-gradient(90deg, var(--brand), var(--cyan)); border-radius: 2px; }
        h1 { font-size: clamp(38px, 6vw, 64px); font-weight: 850; letter-spacing: 0; line-height: 1.05; color: #fff; }
        h2 { font-size: clamp(28px, 4vw, 46px); font-weight: 850; letter-spacing: 0; line-height: 1.1; color: var(--text); margin-bottom: 14px; }
        h3 { font-size: 18px; font-weight: 760; letter-spacing: 0; color: var(--text); margin-bottom: 8px; }
        h4 { font-size: 15px; font-weight: 600; color: var(--text); }
        p { color: var(--text-muted); line-height: 1.75; }
        .lead { font-size: 17px; line-height: 1.7; color: #475569; }
        .gradient-text { background: linear-gradient(135deg, var(--brand) 0%, var(--cyan) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        /* ── BUTTONS ──────────────────────────────────── */
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 999px; font-size: 14px; font-weight: 600; text-decoration: none; cursor: pointer; border: none; font-family: inherit; transition: all var(--tr); }
        .btn svg { width: 16px; height: 16px; }
        .btn:hover { transform: translateY(-1px); }
        .btn-primary { background: #111827; color: #fff; box-shadow: 0 4px 14px rgba(17,24,39,0.24); }
        .btn-primary:hover { background: #030712; box-shadow: 0 6px 20px rgba(17,24,39,0.32); }
        .btn-secondary { background: #fff; color: var(--text); border: 1.5px solid var(--border); box-shadow: var(--shadow-sm); }
        .btn-secondary:hover { border-color: #111827; color: #111827; }
        .btn-white { background: #fff; color: #111827; box-shadow: 0 4px 14px rgba(0,0,0,0.12); }
        .btn-white:hover { box-shadow: 0 6px 24px rgba(0,0,0,0.18); }
        .btn-ghost { background: rgba(255,255,255,0.12); color: #fff; border: 1.5px solid rgba(255,255,255,0.25); }
        .btn-ghost:hover { background: rgba(255,255,255,0.2); }
        .btn-sm { padding: 8px 18px; font-size: 13px; }
        .btn-lg { padding: 15px 32px; font-size: 16px; }

        /* ── CARDS ──────────────────────────────────── */
        .card {
            background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius);
            padding: 28px; transition: all 0.3s ease; box-shadow: var(--shadow-sm); position: relative; overflow: hidden; height: 100%;
        }
        .card:hover { border-color: #cbd5e1; box-shadow: 0 8px 32px rgba(15,23,42,0.1); transform: translateY(-3px); }
        .card-icon { width: 48px; height: 48px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 18px; }
        .card-icon svg { width: 22px; height: 22px; }
        .ci-purple, .ci-blue, .ci-cyan, .ci-teal, .ci-orange, .ci-rose, .ci-emerald, .ci-amber, .ci-indigo, .ci-sky,
        .card-icon.purple, .card-icon.blue, .card-icon.teal, .card-icon.orange, .card-icon.emerald, .card-icon.rose, .card-icon.sky {
            background: #f3f4f6;
            color: #111827;
        }

        /* service card */
        .service-card {
            background: #fff; border: 1px solid var(--border); border-radius: 20px; overflow: hidden;
            display: flex; flex-direction: column; transition: all 0.3s ease; box-shadow: var(--shadow-sm); text-decoration: none; color: inherit;
        }
        .service-card:hover { transform: translateY(-5px); box-shadow: 0 16px 48px rgba(15,23,42,0.12); border-color: #cbd5e1; }
        .service-card-top { padding: 28px 24px 20px; flex: 1; }
        .service-card-top p { font-size: 13px; color: var(--text-muted); line-height: 1.65; margin-top: 8px; }
        .service-card-bottom { padding: 16px 24px; border-top: 1px solid #f1f5f9; background: #fafbff; display: flex; align-items: center; justify-content: space-between; }
        .service-card-bottom span { font-size: 13px; font-weight: 600; color: var(--brand); }
        .service-card-bottom svg { width: 16px; height: 16px; color: var(--brand); transition: transform var(--tr); }
        .service-card:hover .service-card-bottom svg { transform: translateX(4px); }

        /* event card */
        .event-card {
            background: #fff; border: 1px solid var(--border); border-radius: 20px; overflow: hidden;
            transition: all 0.3s ease; box-shadow: var(--shadow-sm);
        }
        .event-card:hover { transform: translateY(-4px); box-shadow: 0 16px 48px rgba(0,0,0,0.1); border-color: #cbd5e1; }
        .event-card-img { height: 200px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; }
        .event-card-body { padding: 24px; }
        .event-date-badge { display: inline-flex; flex-direction: column; align-items: center; background: var(--brand); color: #fff; border-radius: 8px; padding: 10px 16px; min-width: 60px; }
        .event-date-badge .day { font-size: 26px; font-weight: 800; line-height: 1; }
        .event-date-badge .month { font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; opacity: 0.85; }
        .event-meta { display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text-muted); margin-top: 6px; }
        .event-meta svg { width: 13px; height: 13px; }
        .event-tag { display: inline-block; font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 999px; background: var(--brand-light); color: var(--brand); }

        /* ── GRIDS ──────────────────────────────────── */
        .grid { display: grid; gap: 24px; align-items: stretch; }
        .grid-2 { grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); }
        .grid-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-4 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        body > .grid {
            width: min(calc(100% - (var(--page-gutter) * 2)), var(--max-w));
            margin: 0 auto;
            padding: 56px 0;
        }

        /* ── HERO CAROUSEL ──────────────────────────── */
        .hero-carousel { position: relative; overflow: hidden; height: 88vh; min-height: 580px; max-height: 820px; }
        .hero-track { display: flex; height: 100%; transition: transform 0.75s cubic-bezier(0.25, 1, 0.5, 1); will-change: transform; }
        .hero-slide { flex: 0 0 100%; height: 100%; position: relative; display: flex; align-items: center; }
        .hero-slide-1 { background: linear-gradient(135deg, #0f0c29 0%, #1e1b4b 50%, #0a0a2e 100%); }
        .hero-slide-2 { background: linear-gradient(135deg, #0c4a6e 0%, #0f172a 55%, #312e81 100%); }
        .hero-slide-3 { background: linear-gradient(135deg, #064e3b 0%, #0f172a 55%, #1e1b4b 100%); }
        /* mesh gradient overlay */
        .hero-slide::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse 80% 60% at 80% 40%, rgba(17,24,39,0.2), transparent 70%),
                        radial-gradient(ellipse 60% 50% at 20% 80%, rgba(71,85,105,0.14), transparent 70%);
            pointer-events: none;
        }
        /* animated particles */
        .hero-slide::after {
            content: ''; position: absolute; inset: 0; pointer-events: none;
            background-image: radial-gradient(circle, rgba(255,255,255,0.08) 1px, transparent 1px);
            background-size: 40px 40px;
            animation: gridShift 20s linear infinite;
        }
        @keyframes gridShift { from { background-position: 0 0; } to { background-position: 40px 40px; } }
        .hero-content-wrap { position: relative; z-index: 2; max-width: var(--max-w); margin: 0 auto; padding: 0 28px; width: 100%; }
        .hero-content { max-width: 680px; }
        .hero-eyebrow { display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.24); color: #e5e7eb; font-size: 12px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; padding: 5px 14px; border-radius: 999px; margin-bottom: 24px; }
        .hero-eyebrow svg { width: 13px; height: 13px; }
        /* slide text animation */
        .hero-slide .hero-content h1,
        .hero-slide .hero-content p,
        .hero-slide .hero-content .hero-actions,
        .hero-slide .hero-eyebrow { opacity: 0; transform: translateY(28px); }
        .hero-slide.active .hero-eyebrow { animation: heroIn 0.7s 0.05s ease both; }
        .hero-slide.active .hero-content h1 { animation: heroIn 0.7s 0.15s ease both; }
        .hero-slide.active .hero-content p { animation: heroIn 0.7s 0.28s ease both; }
        .hero-slide.active .hero-content .hero-actions { animation: heroIn 0.7s 0.4s ease both; }
        @keyframes heroIn { to { opacity: 1; transform: translateY(0); } }
        .hero-lead { font-size: 17px; color: rgba(255,255,255,0.7); max-width: 520px; margin-bottom: 36px; }
        .hero-actions { display: flex; flex-wrap: wrap; gap: 12px; }
        /* nav arrows */
        .hero-arrow {
            position: absolute; top: 50%; transform: translateY(-50%); z-index: 10;
            width: 48px; height: 48px; border-radius: 50%; border: 1.5px solid rgba(255,255,255,0.25);
            background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); color: #fff;
            display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all var(--tr);
        }
        .hero-arrow svg { width: 20px; height: 20px; }
        .hero-arrow:hover { background: rgba(255,255,255,0.22); border-color: rgba(255,255,255,0.5); }
        .hero-arrow-prev { left: 24px; }
        .hero-arrow-next { right: 24px; }
        /* dots */
        .hero-dots { position: absolute; bottom: 32px; left: 50%; transform: translateX(-50%); display: flex; gap: 8px; z-index: 10; }
        .hero-dot { width: 8px; height: 8px; border-radius: 999px; background: rgba(255,255,255,0.35); border: none; cursor: pointer; padding: 0; transition: all 0.25s ease; }
        .hero-dot.active { width: 28px; background: #fff; }
        /* stats strip */
        .hero-stats-strip { position: absolute; bottom: 0; left: 0; right: 0; z-index: 5; background: rgba(15,23,42,0.65); backdrop-filter: blur(12px); border-top: 1px solid rgba(255,255,255,0.08); }
        .stats-strip-inner { max-width: var(--max-w); margin: 0 auto; padding: 0 28px; display: grid; grid-template-columns: repeat(4, 1fr); }
        .stat-item { padding: 20px 0; text-align: center; border-right: 1px solid rgba(255,255,255,0.08); }
        .stat-item:last-child { border-right: none; }
        .stat-num { font-size: 28px; font-weight: 850; color: #fff; letter-spacing: 0; line-height: 1; }
        .stat-label { font-size: 12px; color: rgba(255,255,255,0.5); margin-top: 4px; }

        /* ── STATS BAR (standalone) ─────────────────── */
        .stats-bar { background: #0f172a; padding: 0; }
        .stats-bar .stats-strip-inner { grid-template-columns: repeat(4, 1fr); }

        /* ── HOME PAGE ──────────────────────────────── */
        .hero-section {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            min-height: calc(100vh - 68px);
            padding: 86px var(--page-gutter) 40px;
            background:
                linear-gradient(120deg, rgba(239,246,255,0.95) 0%, rgba(255,255,255,0.96) 48%, rgba(238,242,255,0.95) 100%),
                radial-gradient(circle at 12% 28%, rgba(6,182,212,0.18), transparent 34%),
                radial-gradient(circle at 78% 16%, rgba(17,24,39,0.08), transparent 30%);
        }
        .hero-section::before {
            content: '';
            position: absolute;
            inset: auto -12% -42% 48%;
            height: 520px;
            background: linear-gradient(135deg, rgba(79,70,229,0.12), rgba(6,182,212,0.1));
            transform: rotate(-8deg);
            z-index: -1;
        }
        .hero-section .hero-content {
            width: min(100%, var(--max-w));
            margin: 0 auto;
        }
        .hero-slider {
            position: relative;
            overflow: hidden;
            width: min(100%, var(--slider-w));
            margin: 0 auto;
            border: 1px solid rgba(226,232,240,0.9);
            border-radius: 8px;
            background: rgba(255,255,255,0.9);
            box-shadow: 0 24px 80px rgba(15,23,42,0.08);
            backdrop-filter: blur(14px);
        }
        .hero-slider-track,
        .modern-slider-track {
            display: flex;
            transition: transform 0.65s cubic-bezier(0.22, 1, 0.36, 1);
            will-change: transform;
        }
        .hero-section .hero-slide {
            flex: 0 0 100%;
            min-height: 520px;
            height: auto;
            display: grid;
            align-content: center;
            gap: 22px;
            padding: clamp(42px, 7vw, 84px);
            background: transparent;
        }
        .hero-section .hero-slide::before,
        .hero-section .hero-slide::after {
            display: none;
        }
        .hero-section .eyebrow {
            margin-bottom: 0;
        }
        .hero-section h2 {
            max-width: 820px;
            font-size: clamp(42px, 6.8vw, 78px);
            line-height: 0.98;
            color: #0f172a;
            text-wrap: balance;
        }
        .hero-section .hero-slide > p:not(.eyebrow) {
            max-width: 660px;
            font-size: 18px;
            color: #475569;
        }
        .hero-section .btn-secondary {
            background: #fff !important;
            border-color: #d1d5db !important;
            color: #111827 !important;
        }
        .landing-hero {
            padding: 0 0 40px;
            margin-top: 0;
            background:
                linear-gradient(180deg, #f8fafc 0%, #ffffff 72%),
                radial-gradient(circle at 8% 20%, rgba(17,24,39,0.08), transparent 34%);
        }
        .header-spacer + .landing-hero {
            margin-top: 0;
        }
        .landing-hero-slider {
            width: 100vw;
            max-width: none;
            margin-left: 50%;
            transform: translateX(-50%);
            border: 1px solid rgba(17,24,39,0.12);
            border-left: 0;
            border-right: 0;
            border-radius: 0;
            background: #111827;
            box-shadow: 0 28px 90px rgba(15,23,42,0.18);
        }
        .landing-slide {
            position: relative;
            overflow: hidden;
            min-height: min(72vh, 720px);
            padding: clamp(34px, 6vw, 78px);
        }
        .landing-slide-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.02);
            transition: transform 7s ease;
        }
        .hero-slide.active .landing-slide-image {
            transform: scale(1.08);
        }
        .landing-slide-shade {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(3,7,18,0.92) 0%, rgba(3,7,18,0.74) 42%, rgba(3,7,18,0.26) 78%, rgba(3,7,18,0.2) 100%),
                linear-gradient(180deg, rgba(3,7,18,0.15), rgba(3,7,18,0.48));
        }
        .landing-slide-copy {
            position: relative;
            z-index: 2;
            width: min(calc(100vw - (var(--page-gutter) * 2)), var(--max-w));
            margin: 0 auto;
            max-width: 680px;
            display: grid;
            gap: 18px;
            justify-self: stretch;
        }
        .landing-slide-copy .eyebrow {
            color: #e5e7eb;
            margin: 0;
        }
        .landing-slide-copy .eyebrow::before {
            background: #fff;
        }
        .landing-slide-copy h2 {
            color: #fff;
            font-size: clamp(42px, 6.8vw, 78px);
            line-height: 0.98;
            margin: 0;
            text-wrap: balance;
        }
        .landing-slide-copy p:not(.eyebrow) {
            max-width: 620px;
            color: rgba(255,255,255,0.78);
            font-size: 18px;
            line-height: 1.75;
        }
        .landing-slide-copy .btn-secondary {
            background: rgba(255,255,255,0.12) !important;
            border-color: rgba(255,255,255,0.26) !important;
            color: #fff !important;
            box-shadow: none;
            backdrop-filter: blur(8px);
        }
        .landing-stats {
            margin-top: 26px;
        }
        .landing-stats .hero-stat {
            background: #fff;
            border-color: #e5e7eb;
            box-shadow: 0 12px 38px rgba(15,23,42,0.07);
        }
        .landing-solution-slider {
            width: 100vw;
            max-width: none;
            margin-left: 50%;
            transform: translateX(-50%);
            border-left: 0;
            border-right: 0;
            border-radius: 0;
            background: #fff;
            box-shadow: 0 22px 70px rgba(15,23,42,0.09);
        }
        .landing-solution-slider .modern-slide {
            min-height: 620px;
            width: 100vw;
            grid-template-columns: minmax(360px, 0.82fr) minmax(0, 1.18fr);
            padding-left: max(var(--page-gutter), calc((100vw - var(--max-w)) / 2));
            padding-right: max(var(--page-gutter), calc((100vw - var(--max-w)) / 2));
            background:
                linear-gradient(120deg, #ffffff 0%, #f8fafc 48%, #eef2f7 100%);
        }
        .landing-solution-slider .modern-slide-content {
            align-self: center;
            max-width: 560px;
        }
        .landing-solution-slider .modern-slide-content h3 {
            font-size: clamp(34px, 4.8vw, 64px);
            line-height: 1;
            margin: 18px 0 16px;
        }
        .landing-solution-slider .modern-slide-content p {
            font-size: 17px;
            color: #475569;
        }
        .landing-solution-slider .modern-slide-media {
            background: #111827;
            min-height: 500px;
            box-shadow: 0 24px 70px rgba(15,23,42,0.18);
        }
        .landing-solution-slider .modern-slide-image {
            min-height: 500px;
            filter: saturate(0.94) contrast(1.02);
        }
        .contact-hero {
            min-height: auto;
            padding-top: 64px;
            padding-bottom: 18px;
        }
        .contact-hero .hero-content {
            max-width: 780px;
            text-align: center;
        }
        .contact-hero h2 {
            font-size: clamp(34px, 5vw, 58px);
            margin-bottom: 14px;
        }
        .contact-layout {
            padding-top: 34px;
            align-items: start;
        }
        .contact-layout > div {
            min-width: 0;
        }
        .contact-layout .card {
            animation: contactCardIn 0.55s ease both;
        }
        .contact-layout > div:nth-child(2) .card:nth-child(2) { animation-delay: 0.06s; }
        .contact-layout > div:nth-child(2) .card:nth-child(3) { animation-delay: 0.12s; }
        .contact-layout > div:nth-child(2) .card:nth-child(4) { animation-delay: 0.18s; }
        @keyframes contactCardIn {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .stack {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
        }
        .hero-slider-controls,
        .modern-slider-controls {
            position: absolute;
            right: 24px;
            bottom: 24px;
            left: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            pointer-events: none;
        }
        .hero-slider-nav,
        .modern-slider-nav,
        .hero-slider-dots,
        .modern-slider-dots {
            display: flex;
            align-items: center;
            gap: 8px;
            pointer-events: auto;
        }
        .hero-slider-btn,
        .modern-slider-btn {
            width: 42px;
            height: 42px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: rgba(255,255,255,0.88);
            color: #0f172a;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--shadow-sm);
            transition: transform var(--tr), border-color var(--tr), color var(--tr);
        }
        .hero-slider-btn:hover,
        .modern-slider-btn:hover {
            transform: translateY(-1px);
            border-color: #111827;
            color: #111827;
        }
        .hero-slider-btn svg,
        .modern-slider-btn svg {
            width: 18px;
            height: 18px;
        }
        .hero-slider-dot,
        .modern-slider-dot {
            width: 8px;
            height: 8px;
            border: 0;
            border-radius: 999px;
            background: #cbd5e1;
            padding: 0;
            cursor: pointer;
            transition: width var(--tr), background var(--tr);
        }
        .hero-slider-dot.active,
        .modern-slider-dot.active {
            width: 28px;
            background: #111827;
        }
        .hero-stats {
            width: min(100%, var(--max-w));
            margin: 22px auto 0;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
        .hero-stat {
            min-height: 132px;
            padding: 22px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fff;
            box-shadow: var(--shadow-sm);
        }
        .kpi {
            font-size: 34px;
            font-weight: 850;
            line-height: 1;
            color: #0f172a;
        }
        .hero-stat .kpi-label {
            margin-top: 10px;
            font-size: 14px;
            color: #64748b;
            line-height: 1.55;
        }
        .modern-slider {
            position: relative;
            overflow: hidden;
            width: min(calc(100% + 48px), var(--slider-w));
            margin-left: 50%;
            transform: translateX(-50%);
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fff;
            box-shadow: var(--shadow-md);
        }
        .modern-slide {
            flex: 0 0 100%;
            display: grid;
            grid-template-columns: minmax(0, 0.95fr) minmax(360px, 1.05fr);
            gap: 34px;
            align-items: center;
            padding: clamp(28px, 5vw, 54px);
        }
        .modern-slide-content h3 {
            margin-top: 16px;
            font-size: clamp(26px, 3.4vw, 42px);
            line-height: 1.1;
        }
        .modern-slide-media {
            position: relative;
            min-height: 380px;
            border-radius: 8px;
            overflow: hidden;
            background: linear-gradient(135deg, #eef2ff, #ecfeff);
            border: 1px solid #dbeafe;
        }
        .modern-slide-image {
            width: 100%;
            height: 100%;
            min-height: 380px;
            object-fit: cover;
            display: block;
        }
        .modern-slide-overlay {
            position: absolute;
            right: 18px;
            bottom: 18px;
            left: 18px;
            padding: 18px;
            border-radius: 8px;
            background: rgba(15,23,42,0.88);
            color: #fff;
            backdrop-filter: blur(10px);
        }
        .media-kpi {
            color: #fff;
            font-size: 32px;
            font-weight: 850;
            line-height: 1;
        }
        .media-label {
            color: #cbd5e1;
            font-size: 13px;
            margin-top: 6px;
        }
        .modern-slide-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 14px;
        }
        .modern-slide-badges span {
            font-size: 12px;
            font-weight: 650;
            color: #e0f2fe;
            border: 1px solid rgba(224,242,254,0.25);
            border-radius: 999px;
            padding: 4px 10px;
        }
        .hero-section .landing-hero-slider,
        .section .landing-solution-slider {
            width: 100vw;
            inline-size: 100vw;
            min-width: 100vw;
            max-width: none;
            margin-left: calc(50% - 50vw);
            margin-right: 0;
            transform: none;
            border-left: 0;
            border-right: 0;
            border-radius: 0;
        }
        .hero-section .landing-hero-slider {
            margin-top: 0;
        }
        .section .landing-solution-slider {
            left: auto;
        }
        .landing-hero-slider .hero-slider-controls,
        .landing-solution-slider .modern-slider-controls {
            width: min(calc(100% - (var(--page-gutter) * 2)), var(--max-w));
            left: 50%;
            right: auto;
            transform: translateX(-50%);
        }
        .list {
            margin: 18px 0 0;
            padding-left: 18px;
            color: #475569;
        }
        .list li {
            margin: 8px 0;
        }
        .service-preview-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 252px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fff;
            color: inherit;
            text-decoration: none;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: transform var(--tr), box-shadow var(--tr), border-color var(--tr);
        }
        .service-preview-card:hover {
            transform: translateY(-4px);
            border-color: #cbd5e1;
            box-shadow: 0 14px 40px rgba(15,23,42,0.1);
        }
        .service-preview-top {
            padding: 24px;
        }
        .service-preview-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 24px;
            border-top: 1px solid #eef2f7;
            color: #111827;
            font-size: 13px;
            font-weight: 700;
            background: #fafbff;
        }
        .events-hero .hero-content {
            display: grid;
            gap: 18px;
        }
        .event-feature-card {
            display: grid;
            grid-template-columns: 96px minmax(0, 1fr);
            gap: 24px;
            padding: 26px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background:
                linear-gradient(135deg, rgba(255,255,255,0.94), rgba(248,250,252,0.96)),
                radial-gradient(circle at top right, rgba(17,24,39,0.08), transparent 34%);
            box-shadow: var(--shadow-sm);
            transition: transform var(--tr), box-shadow var(--tr), border-color var(--tr);
        }
        .event-feature-card:hover {
            transform: translateY(-4px);
            border-color: #cbd5e1;
            box-shadow: 0 18px 52px rgba(15,23,42,0.1);
        }
        .event-feature-date {
            width: 82px;
            height: 82px;
            border-radius: 8px;
            display: grid;
            place-items: center;
            align-content: center;
            background: #0f172a;
            color: #fff;
            box-shadow: 0 12px 28px rgba(15,23,42,0.18);
        }
        .event-feature-date span {
            font-size: 32px;
            font-weight: 850;
            line-height: 1;
        }
        .event-feature-date small {
            margin-top: 5px;
            font-size: 12px;
            font-weight: 750;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #cbd5e1;
        }
        .event-feature-body h3 {
            font-size: 24px;
            line-height: 1.15;
            margin: 10px 0;
        }
        .event-feature-body p {
            margin-bottom: 18px;
        }
        .event-feature-meta,
        .event-detail-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }
        .event-feature-meta span {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            background: #f3f4f6;
            color: #111827;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 700;
        }
        .event-detail-row {
            margin-bottom: 18px;
            color: #475569;
            font-size: 13px;
            font-weight: 650;
        }
        .event-detail-row span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .event-detail-row svg {
            width: 15px;
            height: 15px;
            color: #111827;
        }
        .event-table-wrap {
            overflow-x: auto;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 18px 54px rgba(15,23,42,0.08);
        }
        .event-table {
            width: 100%;
            min-width: 860px;
            border-collapse: collapse;
            font-size: 14px;
        }
        .event-table th {
            padding: 15px 18px;
            text-align: left;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #64748b;
            background: #f8fafc;
            border-bottom: 1px solid var(--border);
        }
        .event-table td {
            padding: 18px;
            border-bottom: 1px solid #eef2f7;
            vertical-align: middle;
            color: #475569;
            transition: background var(--tr), color var(--tr);
        }
        .event-table tbody tr {
            transition: transform var(--tr), box-shadow var(--tr);
        }
        .event-table tbody tr:hover {
            transform: translateY(-1px);
            box-shadow: inset 4px 0 0 #111827;
        }
        .event-table tbody tr:hover td {
            background: #fafafa;
        }
        .event-table tr:last-child td {
            border-bottom: 0;
        }
        .event-table td strong {
            display: block;
            color: #0f172a;
            font-weight: 780;
        }
        .event-table td span {
            display: block;
            margin-top: 4px;
            color: #64748b;
            font-size: 13px;
            line-height: 1.5;
        }
        .event-table .event-tag {
            display: inline-flex;
            margin: 0;
            white-space: nowrap;
        }
        .event-table-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 36px;
            padding: 8px 12px;
            border-radius: 8px;
            background: #eef2ff;
            color: #111827;
            text-decoration: none;
            font-size: 13px;
            font-weight: 750;
            white-space: nowrap;
        }
        .event-table-link:hover {
            background: #111827;
            color: #fff;
        }

        /* ── FEATURE STRIP ──────────────────────────── */
        .feature-strip { display: flex; flex-wrap: wrap; gap: 16px; }
        .feature-pill { display: inline-flex; align-items: center; gap: 8px; background: #fff; border: 1px solid var(--border); border-radius: 999px; padding: 8px 16px; font-size: 13px; font-weight: 500; color: var(--text); box-shadow: var(--shadow-sm); }
        .feature-pill svg { width: 15px; height: 15px; color: var(--brand); }

        /* ── TAGS / BADGES ──────────────────────────── */
        .tag,
        .tag.teal,
        .tag.orange,
        .tag-indigo,
        .tag-cyan,
        .tag-emerald,
        .tag-amber,
        .tag-rose,
        .tag-sky,
        .tag-gray {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 999px;
            background: #f3f4f6;
            color: #111827;
        }

        /* ── FORMS ──────────────────────────────────── */
        .form-card, .form-wrap .card { background: #fff; border: 1px solid var(--border); border-radius: 8px; padding: 40px; box-shadow: 0 18px 54px rgba(15,23,42,0.08); }
        .form-wrap .card::before {
            content: '';
            position: absolute;
            inset: 0 0 auto;
            height: 3px;
            background: linear-gradient(90deg, #111827, #64748b);
        }
        .form-group { margin-bottom: 20px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }
        .form-label, .form-group label { display: block; font-size: 13px; font-weight: 750; color: #111827; margin-bottom: 8px; }
        .form-label span { color: #ef4444; margin-left: 2px; }
        .form-input,
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            min-height: 48px;
            padding: 12px 15px;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            background: #fff;
            color: #111827;
            font-family: inherit;
            font-size: 15px;
            line-height: 1.5;
            transition: border-color var(--tr), box-shadow var(--tr), background var(--tr), transform var(--tr);
            outline: none;
            box-shadow: 0 1px 0 rgba(15,23,42,0.03);
            appearance: none;
        }
        .form-group select {
            padding-right: 42px;
            background-image: linear-gradient(45deg, transparent 50%, #111827 50%), linear-gradient(135deg, #111827 50%, transparent 50%);
            background-position: calc(100% - 20px) 20px, calc(100% - 15px) 20px;
            background-size: 5px 5px, 5px 5px;
            background-repeat: no-repeat;
        }
        .form-input:hover,
        .form-group input:hover,
        .form-group select:hover,
        .form-group textarea:hover {
            border-color: #9ca3af;
        }
        .form-input:focus,
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #111827;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(17,24,39,0.1);
            transform: translateY(-1px);
        }
        .form-input::placeholder,
        .form-group input::placeholder,
        .form-group textarea::placeholder { color: #9ca3af; }
        .form-input.error { border-color: #ef4444; }
        textarea.form-input,
        .form-group textarea { resize: vertical; min-height: 150px; }
        .error-text {
            margin-top: 6px;
            color: #b91c1c;
            font-size: 12px;
            font-weight: 650;
        }
        .success-box {
            margin-bottom: 18px;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            background: #f0fdf4;
            color: #166534;
            padding: 14px 16px;
            font-size: 14px;
            font-weight: 650;
            box-shadow: var(--shadow-sm);
        }
        .form-icon-wrap { position: relative; }
        .form-icon-wrap .form-input { padding-left: 42px; }
        .form-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; width: 16px; height: 16px; pointer-events: none; }
        .error-msg { color: #ef4444; font-size: 12px; margin-top: 5px; display: flex; align-items: center; gap: 4px; }
        .error-msg svg { width: 13px; height: 13px; flex-shrink: 0; }
        .success-banner { background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; padding: 14px 18px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px; }
        .success-banner svg { width: 18px; height: 18px; flex-shrink: 0; }

        /* ── ACCORDION (services) ───────────────────── */
        .accordion-item { background: #fff; border: 1px solid var(--border); border-radius: 16px; overflow: hidden; margin-bottom: 12px; transition: all 0.3s ease; box-shadow: var(--shadow-sm); }
        .accordion-item.open { border-color: #111827; box-shadow: 0 4px 24px rgba(17,24,39,0.1); }
        .accordion-trigger { width: 100%; display: flex; align-items: center; gap: 16px; padding: 20px 24px; cursor: pointer; border: none; background: none; text-align: left; font-family: inherit; }
        .accordion-trigger:hover { background: #fafbff; }
        .accordion-trigger .card-icon { margin: 0; flex-shrink: 0; }
        .accordion-info { flex: 1; }
        .accordion-info h3 { font-size: 16px; margin-bottom: 2px; }
        .accordion-info p { font-size: 13px; color: var(--text-muted); margin: 0; }
        .accordion-chevron { width: 32px; height: 32px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: all 0.3s ease; }
        .accordion-chevron svg { width: 16px; height: 16px; color: var(--text-muted); transition: transform 0.3s ease; }
        .accordion-item.open .accordion-chevron { background: #111827; }
        .accordion-item.open .accordion-chevron svg { color: #fff; transform: rotate(180deg); }
        .accordion-body { max-height: 0; overflow: hidden; transition: max-height 0.4s ease; }
        .accordion-item.open .accordion-body { max-height: 500px; }
        .accordion-body-inner { padding: 0 24px 24px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px; border-top: 1px solid #f1f5f9; padding-top: 20px; }
        .accordion-body-inner p { font-size: 14px; }
        .list { list-style: none; padding: 0; margin-top: 10px; }
        .list li { position: relative; padding-left: 18px; margin-bottom: 7px; color: #475569; font-size: 13px; }
        .list li::before { content: ''; position: absolute; left: 0; top: 7px; width: 6px; height: 6px; border-radius: 50%; background: #111827; }
        @media (max-width: 640px) { .accordion-body-inner { grid-template-columns: 1fr; } }

        /* ── CTA BANNER ──────────────────────────────── */
        .cta-banner { width: min(calc(100% - (var(--page-gutter) * 2)), var(--max-w)); margin: 0 auto 56px; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 8px; padding: 56px 48px; text-align: center; position: relative; overflow: hidden; }
        .cta-banner::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse 80% 80% at 50% 0%, rgba(17,24,39,0.05), transparent 70%); }
        .cta-banner h2 { color: #111827; position: relative; z-index: 1; }
        .cta-banner p { color: #475569; max-width: 480px; margin: 12px auto 32px; position: relative; z-index: 1; font-size: 16px; }
        .cta-banner .btn {
            position: relative;
            z-index: 1;
            background: #111827 !important;
            color: #fff !important;
            border: 1px solid #111827 !important;
            box-shadow: 0 4px 14px rgba(17,24,39,0.18);
        }
        .cta-banner .btn + .btn {
            background: #fff !important;
            color: #111827 !important;
            border-color: #d1d5db !important;
        }
        .cta-actions { display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; position: relative; z-index: 1; }

        /* ── FOOTER ──────────────────────────────────── */
        .site-footer {
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(circle at 12% 0%, rgba(255,255,255,0.08), transparent 28%),
                linear-gradient(180deg, #111827 0%, #030712 100%);
            color: #9ca3af;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .site-footer::before {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background-image: linear-gradient(rgba(255,255,255,0.035) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.035) 1px, transparent 1px);
            background-size: 44px 44px;
            mask-image: linear-gradient(180deg, rgba(0,0,0,0.9), transparent 78%);
        }
        .footer-top { position: relative; width: min(calc(100% - (var(--page-gutter) * 2)), var(--max-w)); margin: 0 auto; padding: 72px 0 52px; display: grid; grid-template-columns: 1.45fr repeat(3, 1fr); gap: 48px; }
        .footer-brand-name { color: #fff; font-size: 25px; font-weight: 850; letter-spacing: 0; margin-bottom: 12px; }
        .footer-tagline { font-size: 14px; color: #9ca3af; line-height: 1.75; margin-bottom: 24px; max-width: 360px; }
        .footer-socials { display: flex; gap: 10px; }
        .social-btn { width: 40px; height: 40px; border-radius: 8px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.11); display: flex; align-items: center; justify-content: center; text-decoration: none; color: #d1d5db; transition: all var(--tr); }
        .social-btn svg { width: 16px; height: 16px; }
        .social-btn:hover { background: #fff; border-color: #fff; color: #030712; transform: translateY(-2px); }
        .footer-heading { font-size: 11px; font-weight: 800; letter-spacing: 0.12em; text-transform: uppercase; color: #f9fafb; margin-bottom: 18px; }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 11px; color: #9ca3af; font-size: 14px; }
        .footer-links a { color: #9ca3af; text-decoration: none; font-size: 14px; transition: color var(--tr), transform var(--tr); display: inline-flex; align-items: center; gap: 6px; }
        .footer-links a svg { width: 14px; height: 14px; }
        .footer-links a:hover { color: #fff; transform: translateX(3px); }
        .footer-primary-link { color: #fff !important; font-weight: 750; }
        .footer-bottom { position: relative; width: min(calc(100% - (var(--page-gutter) * 2)), var(--max-w)); margin: 0 auto; padding: 22px 0; border-top: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: space-between; font-size: 13px; color: #6b7280; }
        .footer-badge { display: inline-flex; align-items: center; gap: 7px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); border-radius: 999px; padding: 6px 12px; font-size: 12px; color: #d1d5db; }
        .footer-badge svg { width: 13px; height: 13px; color: #fff; }

        /* ── KPI / STATS ──────────────────────────────── */
        .kpi-num { font-size: 40px; font-weight: 850; letter-spacing: 0; color: var(--text); line-height: 1; }
        .kpi-label { font-size: 13px; color: var(--text-muted); margin-top: 4px; }

        /* ── DIVIDER ──────────────────────────────────── */
        .divider { width: min(calc(100% - (var(--page-gutter) * 2)), var(--max-w)); height: 1px; background: var(--border); margin: 40px auto; }

        /* ── ANIMATIONS ──────────────────────────────── */
        .fade-up { opacity: 0; transform: translateY(24px); }
        .fade-up.in { animation: fadeUp 0.6s ease both; }
        .fade-up:nth-child(2).in { animation-delay: 0.08s; }
        .fade-up:nth-child(3).in { animation-delay: 0.16s; }
        .fade-up:nth-child(4).in { animation-delay: 0.24s; }
        .fade-up:nth-child(5).in { animation-delay: 0.32s; }
        .fade-up:nth-child(6).in { animation-delay: 0.40s; }
        @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
        .fade-in { animation: fadein 0.5s ease both; }
        @keyframes fadein { from { opacity: 0; } to { opacity: 1; } }
        .reveal {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .reveal.in {
            opacity: 1;
            transform: translateY(0);
        }
        .grid > .reveal:nth-child(2).in { transition-delay: 0.06s; }
        .grid > .reveal:nth-child(3).in { transition-delay: 0.12s; }
        .grid > .reveal:nth-child(4).in { transition-delay: 0.18s; }
        .grid > .reveal:nth-child(5).in { transition-delay: 0.24s; }
        .grid > .reveal:nth-child(6).in { transition-delay: 0.30s; }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: 0.01ms !important;
            }
            .reveal, .fade-up {
                opacity: 1;
                transform: none;
            }
        }

        /* ── RESPONSIVE ──────────────────────────────── */
        @media (max-width: 1024px) {
            .footer-top { grid-template-columns: 1fr 1fr; gap: 36px; }
            .grid-3, .grid-4 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .modern-slide { grid-template-columns: 1fr; }
            .landing-solution-slider .modern-slide {
                grid-template-columns: 1fr;
                padding-left: var(--page-gutter);
                padding-right: var(--page-gutter);
            }
            .modern-slide-media { min-height: 320px; }
            .modern-slide-image { min-height: 320px; }
        }
        @media (max-width: 768px) {
            .main-nav, .header-cta { display: none; }
            .menu-toggle { display: flex; }
            .section { padding: 40px 0; }
            .section-sm { padding: 30px 0; }
            .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
            .cta-banner { margin-bottom: 56px; padding: 48px 28px; }
            .hero-arrow { display: none; }
            .stats-strip-inner { grid-template-columns: repeat(2,1fr); }
            .stat-item:nth-child(2) { border-right: none; }
            .form-row { grid-template-columns: 1fr; }
            .hero-section { padding-top: 48px; padding-bottom: 28px; min-height: auto; }
            .hero-section .hero-slide { min-height: 500px; padding: 34px 24px 88px; }
            .hero-section h2 { font-size: clamp(36px, 12vw, 56px); }
            .hero-stats { grid-template-columns: 1fr; }
            .hero-slider-controls, .modern-slider-controls { right: 18px; bottom: 18px; left: 18px; }
            .modern-slide { padding: 24px 20px 88px; }
            .event-feature-card { grid-template-columns: 1fr; }
            .event-feature-date { width: 74px; height: 74px; }
        }
        @media (max-width: 640px) {
            .footer-top { grid-template-columns: 1fr; }
            .footer-bottom { flex-direction: column; gap: 10px; text-align: center; }
            .stats-strip-inner { grid-template-columns: 1fr 1fr; }
            .hero-carousel { height: 70vh; min-height: 520px; }
            h1 { font-size: clamp(32px, 8vw, 48px); }
            .hero-section .hero-slide > p:not(.eyebrow) { font-size: 16px; }
            .hero-slider-btn, .modern-slider-btn { width: 38px; height: 38px; }
            .modern-slide-media, .modern-slide-image { min-height: 280px; }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/starmax-unified.css') }}?v={{ filemtime(public_path('css/starmax-unified.css')) }}">
</head>
<body>
@php($tenantDemoUrl = url('/contact').'?service=tenant&request=demo')

<header class="site-header" id="site-header">
    <div class="header-inner">
        <a href="/" class="brand" aria-label="Starmax home">
            <span class="brand-wordmark">Starmax<span>.</span></span>
        </a>

        <nav class="main-nav">
            <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="/about" class="nav-link {{ request()->is('about') ? 'active' : '' }}">About</a>

            {{-- Services dropdown --}}
            <div class="nav-item">
                <button class="nav-link {{ request()->is('services') ? 'active' : '' }}" type="button">
                    Services <i data-lucide="chevron-down"></i>
                </button>
                <div class="nav-dropdown">
                    <a href="/services/web-development" class="dropdown-item">
                        <div class="dropdown-icon purple"><i data-lucide="globe"></i></div>
                        <div class="dropdown-text"><strong>Web Development</strong><span>Laravel, Next.js, NestJS</span></div>
                    </a>
                    <a href="/services/android-apps" class="dropdown-item">
                        <div class="dropdown-icon blue"><i data-lucide="smartphone"></i></div>
                        <div class="dropdown-text"><strong>Android Apps</strong><span>Kotlin & Jetpack Compose</span></div>
                    </a>
                    <a href="/services/ai-automation" class="dropdown-item">
                        <div class="dropdown-icon cyan"><i data-lucide="bot"></i></div>
                        <div class="dropdown-text"><strong>AI & Automation</strong><span>LLMs, RAG, Agents</span></div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="/services/it-consulting" class="dropdown-item">
                        <div class="dropdown-icon amber"><i data-lucide="briefcase"></i></div>
                        <div class="dropdown-text"><strong>IT Consulting</strong><span>Strategy & architecture</span></div>
                    </a>
                    <a href="/services/tenant-management" class="dropdown-item">
                        <div class="dropdown-icon emerald"><i data-lucide="building-2"></i></div>
                        <div class="dropdown-text"><strong>Tenant Management</strong><span>Property ops platform</span></div>
                    </a>
                    <a href="/services/custom-software" class="dropdown-item">
                        <div class="dropdown-icon rose"><i data-lucide="zap"></i></div>
                        <div class="dropdown-text"><strong>Custom Software</strong><span>CRM, ERP, integrations</span></div>
                    </a>
                </div>
            </div>

            {{-- Products dropdown --}}
            <div class="nav-item">
                <button class="nav-link {{ request()->is('products') ? 'active' : '' }}" type="button">
                    Products <i data-lucide="chevron-down"></i>
                </button>
                <div class="nav-dropdown" style="min-width:220px;">
                    <a href="/products#tenantpro" class="dropdown-item">
                        <div class="dropdown-icon emerald"><i data-lucide="layout-dashboard"></i></div>
                        <div class="dropdown-text"><strong>TenantPro Dashboard</strong><span>Web admin portal</span></div>
                    </a>
                    <a href="/products#mobile" class="dropdown-item">
                        <div class="dropdown-icon blue"><i data-lucide="smartphone"></i></div>
                        <div class="dropdown-text"><strong>TenantPro Mobile</strong><span>Android tenant app</span></div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ $tenantDemoUrl }}" class="dropdown-item">
                        <div class="dropdown-icon indigo"><i data-lucide="external-link"></i></div>
                        <div class="dropdown-text"><strong>Live Demo</strong><span>Try it now →</span></div>
                    </a>
                </div>
            </div>

            <a href="/portfolio" class="nav-link {{ request()->is('portfolio') ? 'active' : '' }}">Portfolio</a>
            <a href="/events" class="nav-link {{ request()->is('events') ? 'active' : '' }}">Events</a>
            <a href="/contact" class="nav-link {{ request()->is('contact') ? 'active' : '' }}">Contact</a>
        </nav>

        <div class="header-cta">
            <a href="{{ $tenantDemoUrl }}" class="btn-cta btn-cta-ghost">Live Demo ↗</a>
            <a href="/contact" class="btn-cta btn-cta-primary">
                <i data-lucide="rocket"></i> Get Started
            </a>
        </div>

        <button class="menu-toggle" type="button" id="menu-toggle" aria-label="Menu" aria-expanded="false">
            <i data-lucide="menu" id="menu-icon-open"></i>
            <i data-lucide="x" id="menu-icon-close" style="display:none;"></i>
        </button>
    </div>
</header>

<div class="mobile-nav" id="mobile-nav">
    <a href="/" class="mobile-nav-link {{ request()->is('/') ? 'active' : '' }}"><i data-lucide="home"></i> Home</a>
    <a href="/about" class="mobile-nav-link {{ request()->is('about') ? 'active' : '' }}"><i data-lucide="info"></i> About</a>
    <div class="mobile-section-label">Services</div>
    <a href="/services/web-development" class="mobile-sub-link"><i data-lucide="globe"></i> Web Development</a>
    <a href="/services/android-apps" class="mobile-sub-link"><i data-lucide="smartphone"></i> Android Apps</a>
    <a href="/services/ai-automation" class="mobile-sub-link"><i data-lucide="bot"></i> AI & Automation</a>
    <a href="/services/it-consulting" class="mobile-sub-link"><i data-lucide="briefcase"></i> IT Consulting</a>
    <a href="/services/tenant-management" class="mobile-sub-link"><i data-lucide="building-2"></i> Tenant Management</a>
    <a href="/services" class="mobile-nav-link"><i data-lucide="layers"></i> All Services</a>
    <div class="mobile-divider"></div>
    <a href="/products" class="mobile-nav-link {{ request()->is('products') ? 'active' : '' }}"><i data-lucide="package"></i> Products</a>
    <a href="/portfolio" class="mobile-nav-link {{ request()->is('portfolio') ? 'active' : '' }}"><i data-lucide="briefcase"></i> Portfolio</a>
    <a href="/events" class="mobile-nav-link {{ request()->is('events') ? 'active' : '' }}"><i data-lucide="calendar"></i> Events</a>
    <a href="/contact" class="mobile-nav-link {{ request()->is('contact') ? 'active' : '' }}"><i data-lucide="mail"></i> Contact</a>
    <a href="/contact" class="mobile-cta"><i data-lucide="rocket"></i> Get Started</a>
</div>

<div class="header-spacer"></div>

@yield('content')

<footer class="site-footer">
    <div class="footer-top">
        <div>
            <p class="footer-brand-name">Starmax</p>
            <p class="footer-tagline">Building modern digital experiences for property teams, enterprises, and mobile-first audiences across East Africa.</p>
            <div class="footer-socials">
                <a href="#" class="social-btn" aria-label="Twitter/X"><i data-lucide="twitter"></i></a>
                <a href="#" class="social-btn" aria-label="LinkedIn"><i data-lucide="linkedin"></i></a>
                <a href="#" class="social-btn" aria-label="GitHub"><i data-lucide="github"></i></a>
                <a href="#" class="social-btn" aria-label="Instagram"><i data-lucide="instagram"></i></a>
            </div>
        </div>
        <div>
            <p class="footer-heading">Company</p>
            <ul class="footer-links">
                <li><a href="/about">About Us</a></li>
                <li><a href="/portfolio">Portfolio</a></li>
                <li><a href="/events">Events</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>
        </div>
        <div>
            <p class="footer-heading">Solutions</p>
            <ul class="footer-links">
                <li><a href="/services/web-development">Web Development</a></li>
                <li><a href="/services/android-apps">Android Apps</a></li>
                <li><a href="/services/ai-automation">AI Agents</a></li>
                <li><a href="/services/tenant-management">Tenant Management</a></li>
                <li><a href="/services/it-consulting">IT Consulting</a></li>
            </ul>
        </div>
        <div>
            <p class="footer-heading">Get In Touch</p>
            <ul class="footer-links">
                <li><a href="mailto:info@starmaxltd.com">info@starmaxltd.com</a></li>
                <li><a href="tel:+254700123456">+254 700 123 456</a></li>
                <li>Nairobi, Kenya</li>
                <li style="margin-top:16px;"><a href="/contact" class="footer-primary-link">Start a project <i data-lucide="arrow-right"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Starmax Ltd. All rights reserved.</p>
        <span class="footer-badge"><i data-lucide="zap"></i> Innovative Digital Solutions</span>
    </div>
</footer>

<script>
(function () {
    // Header scroll effect
    const header = document.getElementById('site-header');
    window.addEventListener('scroll', function() {
        header.classList.toggle('scrolled', window.scrollY > 24);
    }, { passive: true });

    // Mobile menu
    const toggle = document.getElementById('menu-toggle');
    const mobileNav = document.getElementById('mobile-nav');
    const iconOpen = document.getElementById('menu-icon-open');
    const iconClose = document.getElementById('menu-icon-close');
    if (toggle && mobileNav) {
        const close = () => {
            mobileNav.classList.remove('open');
            toggle.setAttribute('aria-expanded', 'false');
            iconOpen.style.display = '';
            iconClose.style.display = 'none';
            document.body.classList.remove('menu-open');
        };
        const open = () => {
            mobileNav.classList.add('open');
            toggle.setAttribute('aria-expanded', 'true');
            iconOpen.style.display = 'none';
            iconClose.style.display = '';
            document.body.classList.add('menu-open');
        };
        toggle.addEventListener('click', () => mobileNav.classList.contains('open') ? close() : open());
        mobileNav.querySelectorAll('a').forEach(a => a.addEventListener('click', close));
        window.addEventListener('keydown', e => { if (e.key === 'Escape') close(); });
    }

    // Accordion / service items
    document.querySelectorAll('.accordion-trigger').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var item = this.closest('.accordion-item');
            var isOpen = item.classList.contains('open');
            document.querySelectorAll('.accordion-item.open').forEach(el => el.classList.remove('open'));
            if (!isOpen) item.classList.add('open');
        });
    });

    // Scroll reveal
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(e) {
            if (e.isIntersecting) { e.target.classList.add('in'); observer.unobserve(e.target); }
        });
    }, { threshold: 0.12 });
    document.querySelectorAll('.fade-up, .reveal').forEach(el => observer.observe(el));
})();
</script>

<script>
// Hero carousel
(function() {
    var carousel = document.querySelector('.hero-carousel');
    if (!carousel) return;
    var track = carousel.querySelector('.hero-track');
    var slides = carousel.querySelectorAll('.hero-slide');
    var dots = carousel.querySelectorAll('.hero-dot');
    var prev = carousel.querySelector('.hero-arrow-prev');
    var next = carousel.querySelector('.hero-arrow-next');
    var cur = 0, timer = null;

    function go(n) {
        slides[cur].classList.remove('active');
        cur = (n + slides.length) % slides.length;
        track.style.transform = 'translateX(' + (cur * -100) + '%)';
        slides[cur].classList.add('active');
        dots.forEach((d, i) => d.classList.toggle('active', i === cur));
    }

    function play() {
        stop();
        timer = setInterval(function() { go(cur + 1); }, 5500);
    }
    function stop() { if (timer) clearInterval(timer); }

    if (prev) prev.addEventListener('click', function() { go(cur - 1); play(); });
    if (next) next.addEventListener('click', function() { go(cur + 1); play(); });
    dots.forEach((d, i) => d.addEventListener('click', function() { go(i); play(); }));
    carousel.addEventListener('mouseenter', stop);
    carousel.addEventListener('mouseleave', play);
    go(0); play();
})();
</script>

<script>
// Home page sliders
(function() {
    function mountSlider(root, options) {
        if (!root) return;
        var track = root.querySelector(options.track);
        var slides = root.querySelectorAll(options.slide);
        var dots = root.querySelectorAll(options.dot);
        var prev = root.querySelector(options.prev);
        var next = root.querySelector(options.next);
        if (!track || slides.length < 1) return;

        var cur = 0;
        var timer = null;
        var interval = parseInt(root.dataset.interval || '5200', 10);
        var autoplay = root.dataset.autoplay === 'true';

        function go(n) {
            cur = (n + slides.length) % slides.length;
            track.style.transform = 'translateX(' + (cur * -100) + '%)';
            slides.forEach(function(slide, i) {
                slide.classList.toggle('active', i === cur);
            });
            dots.forEach(function(dot, i) {
                dot.classList.toggle('active', i === cur);
            });
        }

        function stop() {
            if (timer) clearInterval(timer);
            timer = null;
        }

        function play() {
            stop();
            if (autoplay && slides.length > 1) {
                timer = setInterval(function() { go(cur + 1); }, interval);
            }
        }

        if (prev) prev.addEventListener('click', function() { go(cur - 1); play(); });
        if (next) next.addEventListener('click', function() { go(cur + 1); play(); });
        dots.forEach(function(dot, i) {
            dot.addEventListener('click', function() { go(i); play(); });
        });
        root.addEventListener('mouseenter', stop);
        root.addEventListener('mouseleave', play);
        go(0);
        play();
    }

    mountSlider(document.querySelector('.js-hero-slider'), {
        track: '.hero-slider-track',
        slide: '.hero-slide',
        dot: '.hero-slider-dot',
        prev: '.js-hero-prev',
        next: '.js-hero-next'
    });

    mountSlider(document.querySelector('.js-modern-slider'), {
        track: '.modern-slider-track',
        slide: '.modern-slide',
        dot: '.modern-slider-dot',
        prev: '.js-slider-prev',
        next: '.js-slider-next'
    });
})();
</script>

<script>
// General image slider (reusable)
(function() {
    document.querySelectorAll('.js-slider').forEach(function(slider) {
        var track = slider.querySelector('[data-track]');
        var slides = slider.querySelectorAll('[data-slide]');
        var dots = slider.querySelectorAll('[data-dot]');
        var prev = slider.querySelector('[data-prev]');
        var next = slider.querySelector('[data-next]');
        if (!track || !slides.length) return;
        var cur = 0, timer = null, auto = slider.dataset.auto === 'true', interval = parseInt(slider.dataset.interval || '5000');
        function go(n) {
            cur = (n + slides.length) % slides.length;
            track.style.transform = 'translateX(' + (cur * -100) + '%)';
            dots.forEach((d, i) => d.classList.toggle('active', i === cur));
        }
        function play() { if (auto && slides.length > 1) { stop(); timer = setInterval(() => go(cur + 1), interval); } }
        function stop() { if (timer) clearInterval(timer); }
        if (prev) prev.addEventListener('click', () => { go(cur - 1); play(); });
        if (next) next.addEventListener('click', () => { go(cur + 1); play(); });
        dots.forEach((d, i) => d.addEventListener('click', () => { go(i); play(); }));
        slider.addEventListener('mouseenter', stop);
        slider.addEventListener('mouseleave', play);
        go(0); play();
    });
})();
</script>

<script>lucide.createIcons();</script>
</body>
</html>
