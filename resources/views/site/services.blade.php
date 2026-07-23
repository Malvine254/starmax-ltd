@extends('site.layout')

@section('title', 'Services — Starmax Ltd')

@section('content')
<style>
.services-shell {
    background:
        radial-gradient(circle at top right, rgba(17,24,39,0.08), transparent 30%),
        radial-gradient(circle at bottom left, rgba(15,23,42,0.06), transparent 28%),
        linear-gradient(180deg, #f8fafc 0%, #ffffff 38%, #ffffff 100%);
}
.services-hero {
    padding: 74px 0 50px;
}
.services-hero-title {
    margin-bottom: 14px;
    max-width: 760px;
    font-size: clamp(32px, 5vw, 58px);
    line-height: 1.04;
}
.services-hero-sub {
    max-width: 620px;
    font-size: 17px;
    line-height: 1.72;
    color: #475569;
    margin-bottom: 30px;
}
.services-stats {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}
.services-stat {
    min-width: 170px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 14px 16px;
    box-shadow: 0 10px 28px rgba(15,23,42,0.05);
}
.services-stat strong {
    display: block;
    font-size: 24px;
    font-weight: 850;
    line-height: 1;
    color: #0f172a;
}
.services-stat span {
    display: block;
    margin-top: 5px;
    font-size: 12px;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #64748b;
    font-weight: 700;
}
.services-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px;
}
.service-tile {
    display: flex;
    flex-direction: column;
    gap: 14px;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 14px 40px rgba(15,23,42,0.06);
    transition: transform 0.24s ease, box-shadow 0.24s ease, border-color 0.24s ease;
}
.service-tile:hover {
    transform: translateY(-4px);
    border-color: #cbd5e1;
    box-shadow: 0 22px 56px rgba(15,23,42,0.12);
}
.service-tile-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}
.service-pill {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    border-radius: 999px;
    padding: 4px 10px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #64748b;
}
.service-pill.flagship {
    background: #fef3c7;
    color: #92400e;
    border-color: #fcd34d;
}
.service-title {
    font-size: 22px;
    line-height: 1.24;
    margin: 0;
}
.service-copy {
    margin: 0;
    font-size: 14px;
    line-height: 1.72;
    color: #475569;
}
.service-points {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.service-points li {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #334155;
}
.service-points li::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 999px;
    background: #111827;
}
.service-tech {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    padding-top: 4px;
}
.service-tech span {
    display: inline-flex;
    align-items: center;
    border-radius: 999px;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    color: #64748b;
    padding: 4px 10px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.02em;
}
.service-action {
    margin-top: auto;
    padding-top: 12px;
    border-top: 1px solid #eef2f7;
}
.service-action a {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 750;
    color: #111827;
    text-decoration: none;
}
.service-action a:hover {
    gap: 10px;
}
.services-cta {
    margin: 52px auto 0;
    max-width: 880px;
    padding: 28px;
    background: #111827;
    color: #fff;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    box-shadow: 0 22px 54px rgba(15,23,42,0.24);
}
.services-cta h3 {
    color: #fff;
    margin: 0;
    font-size: 24px;
}
.services-cta p {
    margin: 6px 0 0;
    color: rgba(255,255,255,0.7);
}
@media (max-width: 980px) {
    .services-grid { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
    .services-hero {
        padding-top: 62px;
    }
    .services-cta {
        padding: 22px;
    }
}
</style>

<div class="services-shell">
    <section class="services-hero">
        <div class="container">
            <p class="eyebrow">Our Services</p>
            <h1 class="services-hero-title">Simple packages. Serious engineering.</h1>
            <p class="services-hero-sub">Choose the capability you need now, and expand when your operations grow. Every service is built for reliability, clean delivery, and measurable business impact.</p>
            <div class="services-stats">
                <div class="services-stat">
                    <strong>{{ $serviceStats['total'] }}</strong>
                    <span>Core Services</span>
                </div>
                <div class="services-stat">
                    <strong>{{ $serviceStats['categories'] }}</strong>
                    <span>Service Tracks</span>
                </div>
                <div class="services-stat">
                    <strong>{{ $serviceStats['stacks'] }}</strong>
                    <span>Tech Components</span>
                </div>
            </div>
        </div>
    </section>

    <section class="section" style="padding-top:26px; padding-bottom:68px;">
        <div class="services-grid">
            @foreach($services as $service)
                <article class="service-tile reveal">
                    <div class="service-tile-head">
                        <div class="card-icon {{ $service['color'] }}"><i data-lucide="{{ $service['icon'] }}"></i></div>
                        <span class="service-pill {{ $service['badge'] ? 'flagship' : '' }}">{{ $service['badge'] ?? $service['category'] }}</span>
                    </div>
                    <h3 class="service-title">{{ $service['title'] }}</h3>
                    <p class="service-copy">{{ $service['tagline'] }}</p>
                    <ul class="service-points">
                        @foreach($service['features'] as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                    <div class="service-tech">
                        @foreach($service['tech'] as $tech)
                            <span>{{ $tech }}</span>
                        @endforeach
                    </div>
                    <div class="service-action">
                        <a href="{{ route('services.show', $service['slug']) }}">
                            View details
                            <i data-lucide="arrow-right"></i>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="services-cta reveal">
            <div>
                <h3>Need help picking the right service?</h3>
                <p>Share your goals and we will recommend the fastest path to launch.</p>
            </div>
            <a href="/contact" class="btn btn-white">Talk to our team</a>
        </div>
    </div>
    </section>
</div>

@endsection
