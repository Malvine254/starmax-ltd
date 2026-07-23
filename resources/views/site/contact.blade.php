@extends('site.layout')

@section('title', 'Contact — Starmax Ltd')

@section('content')
<style>
/* ── CONTACT PAGE ── */
.contact-pg-hero {
    background: linear-gradient(150deg,#0f172a 0%,#1e293b 55%,#111827 100%);
    padding: 60px 0 48px; position: relative; overflow: hidden;
}
.contact-pg-hero::after {
    content:''; position:absolute; inset:0;
    background-image: radial-gradient(rgba(255,255,255,0.035) 1px,transparent 1px);
    background-size: 30px 30px; pointer-events:none;
}
/* Layout */
.contact-layout-grid {
    display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 32px; align-items: start;
}
/* Form */
.contact-form-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 20px;
    overflow: hidden; box-shadow: 0 4px 24px rgba(15,23,42,0.07);
}
.contact-form-card-header {
    background: linear-gradient(135deg,#0f172a 0%,#1e293b 100%);
    padding: 24px 32px;
    position: relative; overflow: hidden;
}
.contact-form-card-header::after {
    content:''; position:absolute; inset:0;
    background-image: radial-gradient(rgba(255,255,255,0.04) 1px,transparent 1px);
    background-size: 22px 22px; pointer-events:none;
}
.contact-form-card-header h3 { font-size: 20px; font-weight: 850; color: #fff; margin: 0; position:relative;z-index:1; }
.contact-form-card-header p { font-size: 13px; color: rgba(255,255,255,0.5); margin: 4px 0 0; position:relative;z-index:1; }
.contact-form-body { padding: 28px 32px; }
/* Info cards */
.contact-info-stack { display: flex; flex-direction: column; gap: 14px; }
.info-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 16px;
    padding: 20px 22px; display: flex; align-items: flex-start; gap: 14px;
    box-shadow: 0 1px 4px rgba(15,23,42,0.05); transition: all 0.28s ease;
}
.info-card:hover { border-color: #cbd5e1; box-shadow: 0 8px 28px rgba(15,23,42,0.09); transform: translateY(-2px); }
.info-card-icon {
    width: 40px; height: 40px; border-radius: 10px; background: #f3f4f6;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.info-card-icon svg { width: 18px; height: 18px; color: #111827; }
.info-card-label { font-size: 11px; font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase; color: #94a3b8; margin-bottom: 4px; }
.info-card-value { font-size: 14px; font-weight: 600; color: #0f172a; margin: 0; line-height: 1.5; }
.info-card-value a { color: #0f172a; text-decoration: none; transition: color 0.2s; }
.info-card-value a:hover { color: #6366f1; }
/* Quick services strip */
.quick-services { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 20px; }
.quick-svc {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 12px; font-weight: 600; color: #475569;
    background: #f8fafc; border: 1px solid #e2e8f0; padding: 5px 12px; border-radius: 999px;
    text-decoration: none; transition: all 0.2s ease;
}
.quick-svc:hover { background: #111827; color: #fff; border-color: #111827; }
.quick-svc svg { width: 12px; height: 12px; }
/* What to expect */
.expect-list { display: flex; flex-direction: column; gap: 12px; margin-top: 20px; }
.expect-item { display: flex; align-items: flex-start; gap: 10px; font-size: 13px; color: #374151; line-height: 1.6; }
.expect-num { width: 22px; height: 22px; border-radius: 50%; background: #0f172a; color: #fff; font-size: 11px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }
@media (max-width: 900px) { .contact-layout-grid { grid-template-columns: 1fr; } }
</style>

<!-- Hero -->
<section class="contact-pg-hero">
    <div class="container contact-hero-inner">
        <p class="contact-hero-kicker">Contact us</p>
        <h1 class="contact-hero-title">Let’s build something together.</h1>
        <p class="contact-hero-copy">Whether you’re starting a new project, need consulting, or want to discuss a partnership — we’re ready to listen.</p>
    </div>
</section>

<!-- Main Content -->
<div class="section">
    <div class="contact-layout-grid">

        <!-- Contact Form -->
        <div>
            @if(session('success'))
            <div style="display:flex;align-items:center;gap:10px;background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:14px 18px;border-radius:12px;margin-bottom:20px;font-size:14px;font-weight:600;">
                <i data-lucide="check-circle" style="width:18px;height:18px;flex-shrink:0;"></i>
                {{ session('success') }}
            </div>
            @endif

            @if(session('warning'))
            <div style="display:flex;align-items:center;gap:10px;background:#fffbeb;border:1px solid #fcd34d;color:#92400e;padding:14px 18px;border-radius:12px;margin-bottom:20px;font-size:14px;font-weight:600;">
                <i data-lucide="clock" style="width:18px;height:18px;flex-shrink:0;"></i>
                {{ session('warning') }}
            </div>
            @endif

            <article class="contact-form-card">
                <div class="contact-form-card-header">
                    <h3>Send us a message</h3>
                    <p>We typically respond within one business day.</p>
                </div>
                <div class="contact-form-body">
                    <form method="POST" action="/contact">
                        @csrf
                        <div class="form-row">
                            <div class="form-group" style="margin-bottom:0;">
                                <label>Name <span style="color:#ef4444;">*</span></label>
                                <input type="text" name="name" required value="{{ old('name') }}" placeholder="Your full name">
                                @error('name')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label>Email <span style="color:#ef4444;">*</span></label>
                                <input type="email" name="email" required value="{{ old('email') }}" placeholder="you@company.com">
                                @error('email')<p class="error-text">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:18px;">
                            <label>Service Interest</label>
                            <select name="service">
                                <option value="">Select a service (optional)</option>
                                <option value="web"        @selected(old('service', request('service')) === 'web')>Web Application Development</option>
                                <option value="android"    @selected(old('service', request('service')) === 'android')>Android App Development</option>
                                <option value="ai"         @selected(old('service', request('service')) === 'ai')>AI Agents & Automation</option>
                                <option value="consulting" @selected(old('service', request('service')) === 'consulting')>IT Consulting & Strategy</option>
                                <option value="tenant"     @selected(old('service', request('service')) === 'tenant')>Tenant & Property Management</option>
                                <option value="custom"     @selected(old('service', request('service')) === 'custom')>Custom Business Software</option>
                                <option value="other"      @selected(old('service', request('service')) === 'other')>Other / Not sure yet</option>
                            </select>
                            @error('service')<p class="error-text">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label>Message <span style="color:#ef4444;">*</span></label>
                            <textarea name="message" rows="5" required placeholder="Tell us about your project — what you're building, your timeline, and any key requirements...">{{ old('message') }}</textarea>
                            @error('message')<p class="error-text">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:14px 24px;">
                            <i data-lucide="send"></i> Send Message
                        </button>
                    </form>
                </div>
            </article>
        </div>

        <!-- Info Panel -->
        <div>
            <div class="contact-info-stack">
                <article class="info-card">
                    <div class="info-card-icon"><i data-lucide="mail"></i></div>
                    <div>
                        <p class="info-card-label">Email</p>
                        <p class="info-card-value"><a href="mailto:info@starmaxltd.com">info@starmaxltd.com</a></p>
                    </div>
                </article>
                <article class="info-card">
                    <div class="info-card-icon"><i data-lucide="phone"></i></div>
                    <div>
                        <p class="info-card-label">Phone</p>
                        <p class="info-card-value"><a href="tel:+254700123456">+254 700 123 456</a></p>
                    </div>
                </article>
                <article class="info-card">
                    <div class="info-card-icon"><i data-lucide="map-pin"></i></div>
                    <div>
                        <p class="info-card-label">Location</p>
                        <p class="info-card-value">Nairobi, Kenya</p>
                    </div>
                </article>
                <article class="info-card">
                    <div class="info-card-icon"><i data-lucide="clock"></i></div>
                    <div>
                        <p class="info-card-label">Working Hours</p>
                        <p class="info-card-value">Mon – Fri: 8 AM – 6 PM (EAT)<br><span style="font-size:12px;color:#94a3b8;font-weight:500;">Weekend: By appointment</span></p>
                    </div>
                </article>
            </div>

            <!-- What to expect -->
            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:16px;padding:24px;margin-top:20px;">
                <p style="font-size:13px;font-weight:800;letter-spacing:0.07em;text-transform:uppercase;color:#94a3b8;margin-bottom:6px;">What happens next</p>
                <div class="expect-list">
                    <div class="expect-item"><div class="expect-num">1</div><span>We read your message carefully and review your requirements.</span></div>
                    <div class="expect-item"><div class="expect-num">2</div><span>We reply within 1 business day with questions or a proposal outline.</span></div>
                    <div class="expect-item"><div class="expect-num">3</div><span>We schedule a short discovery call to align on scope and timeline.</span></div>
                    <div class="expect-item"><div class="expect-num">4</div><span>We send a formal proposal with pricing and a project plan.</span></div>
                </div>
            </div>

            <!-- Quick service links -->
            <div style="margin-top:20px;">
                <p style="font-size:12px;font-weight:700;color:#94a3b8;margin-bottom:10px;text-transform:uppercase;letter-spacing:0.07em;">Explore services</p>
                <div class="quick-services">
                    <a href="/services/web-development"    class="quick-svc"><i data-lucide="globe"></i> Web Dev</a>
                    <a href="/services/android-apps"       class="quick-svc"><i data-lucide="smartphone"></i> Android</a>
                    <a href="/services/ai-automation"      class="quick-svc"><i data-lucide="bot"></i> AI Agents</a>
                    <a href="/services/tenant-management"  class="quick-svc"><i data-lucide="building-2"></i> Tenant Mgmt</a>
                    <a href="/services/it-consulting"      class="quick-svc"><i data-lucide="briefcase"></i> Consulting</a>
                    <a href="/services/custom-software"    class="quick-svc"><i data-lucide="zap"></i> Custom Software</a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
