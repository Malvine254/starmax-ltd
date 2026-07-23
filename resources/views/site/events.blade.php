@extends('site.layout')

@section('title', 'Events — Starmax Ltd')

@section('content')
@php
    $formEvent = old('event_slug')
        ? $events->firstWhere('slug', old('event_slug'))
        : ($selectedEvent ?? $events->first());
@endphp

<style>
    .events-page{--ev-ink:#101318;--ev-soft:#f4f1ea;--ev-gold:#d99a31;background:#fbfaf7;color:var(--ev-ink)}
    .events-hero{position:relative;overflow:hidden;padding:clamp(48px,6vw,76px) 0 clamp(44px,5vw,62px);color:#fff;background:#0d1118}
    .events-hero:after{content:"";position:absolute;width:680px;height:680px;right:-280px;top:-360px;border:1px solid rgba(255,255,255,.09);border-radius:50%;box-shadow:0 0 0 100px rgba(255,255,255,.018),0 0 0 200px rgba(255,255,255,.012)}
    .events-hero .container{position:relative;z-index:1}.events-kicker{margin:0 0 18px;color:#f0b95d;font-size:11px;font-weight:800;letter-spacing:.16em;text-transform:uppercase}
    .events-title{max-width:820px;margin:0;font-size:clamp(42px,5.8vw,72px);line-height:1;letter-spacing:-.06em}.events-intro{max-width:600px;margin:20px 0 0;color:#abb4c2;font-size:15px;line-height:1.7}
    .events-summary{display:flex;flex-wrap:wrap;gap:10px;margin-top:26px}.summary-chip{padding:8px 12px;border:1px solid rgba(255,255,255,.15);border-radius:999px;color:#c8ced7;font-size:10px}.summary-chip b{margin-right:5px;color:#fff}
    .flash{display:flex;align-items:flex-start;gap:10px;padding:13px 15px;margin-bottom:18px;border-radius:10px;font-size:13px;font-weight:600}.flash-success{color:#166534;background:#dcfce7}.flash-warning{color:#92400e;background:#fef3c7}.flash-error{color:#991b1b;background:#fee2e2}
    .events-main{padding:76px 0 110px}.events-layout{display:grid;grid-template-columns:minmax(0,1.25fr) minmax(340px,.75fr);gap:clamp(36px,6vw,82px);align-items:start}
    .section-kicker{margin:0 0 10px;color:#a5680b;font-size:10px;font-weight:800;letter-spacing:.14em;text-transform:uppercase}.section-title-clean{margin:0 0 14px;font-size:clamp(30px,4vw,48px);letter-spacing:-.045em}.section-copy{max-width:560px;margin:0 0 35px;color:#667085;font-size:14px;line-height:1.7}
    .event-list{display:grid;gap:18px}.event-card{display:grid;grid-template-columns:82px minmax(0,1fr);gap:24px;padding:26px;border:1px solid #dedbd4;border-radius:16px;background:#fff;box-shadow:0 8px 24px rgba(15,23,42,.045);transition:transform .2s,border-color .2s,box-shadow .2s}.event-card:hover{transform:translateY(-2px);border-color:#c7c1b6;box-shadow:0 16px 34px rgba(15,23,42,.075)}.event-date{width:72px;height:80px;display:flex;align-items:center;justify-content:center;flex-direction:column;padding:12px 8px;border-radius:12px;color:#fff;background:#111827}.event-date b{font-size:24px;line-height:1}.event-date span{margin-top:7px;color:#f0b95d;font-size:9px;font-weight:800;letter-spacing:.1em;text-transform:uppercase}
    .event-topline{display:flex;align-items:center;justify-content:space-between;gap:16px}.event-category{color:#a5680b;font-size:9px;font-weight:800;letter-spacing:.12em;text-transform:uppercase}.event-featured{padding:3px 8px;border-radius:99px;color:#7c4a03;background:#fef3c7;font-size:9px;font-weight:800}
    .event-card h3{margin:7px 0 9px;font-size:21px;letter-spacing:-.03em}.event-card p{margin:0;color:#667085;font-size:13px;line-height:1.65}.event-meta{display:flex;flex-wrap:wrap;gap:7px 16px;margin:13px 0;color:#475467;font-size:10px;font-weight:700}.event-action{display:inline-flex;min-height:42px;align-items:center;justify-content:center;gap:9px;margin-top:20px;padding:0 18px;border-radius:8px;color:#fff;background:#111827;font-size:11px;font-weight:800;text-decoration:none;transition:background .18s,transform .18s}.event-action span{transition:.18s}.event-action:hover{background:#000;transform:translateY(-1px)}.event-action:hover span{transform:translateX(3px)}
    .registration-card{position:sticky;top:92px;padding:27px;border:1px solid #dedbd4;border-radius:16px;background:#fff;box-shadow:0 24px 60px rgba(15,23,42,.08)}.registration-card h2{margin:5px 0 8px;font-size:26px;letter-spacing:-.04em}.registration-card>p{margin:0 0 22px;color:#667085;font-size:12px;line-height:1.6}
    .selected-event{padding:13px;margin-bottom:19px;border-radius:10px;background:#f5f2eb}.selected-event span{display:block;color:#8b6a34;font-size:9px;font-weight:800;letter-spacing:.1em;text-transform:uppercase}.selected-event strong{display:block;margin:4px 0 3px;font-size:12px}.selected-event small{color:#667085;font-size:10px}
    .event-form{display:grid;gap:13px}.field label{display:block;margin-bottom:6px;color:#475467;font-size:10px;font-weight:800}.field input,.field select,.field textarea{width:100%;padding:11px 12px;border:1px solid #d0d5dd;border-radius:8px;background:#fff;color:#101828;font:12px Inter,sans-serif;outline:none}.field input:focus,.field select:focus,.field textarea:focus{border-color:#b7791f;box-shadow:0 0 0 3px rgba(217,154,49,.12)}.field-error{margin-top:5px;color:#b42318;font-size:10px}.form-two{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .register-button{width:100%;min-height:50px;margin-top:6px;padding:0 20px;border:0;border-radius:9px;color:#fff;background:#111827;font:800 12px Inter,sans-serif;cursor:pointer}.register-button:hover{background:#000}
    .empty-events{padding:35px;border:1px dashed #c9c5bc;border-radius:12px;color:#667085;text-align:center}
    @media(max-width:900px){.events-layout{grid-template-columns:1fr}.registration-card{position:static}.events-title{max-width:700px}}
    @media(max-width:600px){.events-hero{padding:42px 0 46px}.events-title{font-size:clamp(38px,11vw,52px)}.events-intro{margin-top:16px}.events-summary{margin-top:22px}.events-main{padding:58px 0 80px}.event-list{gap:14px}.event-card{grid-template-columns:62px minmax(0,1fr);gap:15px;padding:18px 16px}.event-date{width:58px;height:68px;padding:9px 6px}.event-date b{font-size:20px}.event-action{width:100%;margin-top:18px}.form-two{grid-template-columns:1fr}.registration-card{padding:22px 18px}.event-topline{align-items:flex-start;flex-direction:column;gap:5px}}
</style>

<div class="events-page">
    <section class="events-hero">
        <div class="container">
            @if(session('success'))<div class="flash flash-success">{{ session('success') }}</div>@endif
            @if(session('warning'))<div class="flash flash-warning">{{ session('warning') }}</div>@endif
            @if(session('error'))<div class="flash flash-error">{{ session('error') }}</div>@endif
            <p class="events-kicker">Starmax events</p>
            <h1 class="events-title">Learn, connect, and build what comes next.</h1>
            <p class="events-intro">Focused workshops and conversations for teams turning good ideas into useful digital products.</p>
            <div class="events-summary">
                <span class="summary-chip"><b>{{ $eventStats['upcoming'] }}</b> upcoming</span>
                <span class="summary-chip"><b>{{ $eventStats['formats'] }}</b> formats</span>
                <span class="summary-chip">Next: <b>{{ $eventStats['next_month'] }}</b></span>
            </div>
        </div>
    </section>

    <section class="events-main" id="schedule">
        <div class="container events-layout">
            <div>
                <p class="section-kicker">Upcoming schedule</p>
                <h2 class="section-title-clean">Choose your session.</h2>
                <p class="section-copy">Practical events with clear outcomes, limited noise, and room for useful questions.</p>

                @if($events->isEmpty())
                    <div class="empty-events">There are no published events right now. Please check back soon.</div>
                @else
                    <div class="event-list">
                        @foreach($events as $event)
                            <article class="event-card">
                                <time class="event-date" datetime="{{ $event->starts_at->toIso8601String() }}">
                                    <b>{{ $event->starts_at->format('d') }}</b><span>{{ $event->starts_at->format('M') }}</span>
                                </time>
                                <div>
                                    <div class="event-topline">
                                        <span class="event-category">{{ $event->category }} · {{ $event->format ?: 'Session' }}</span>
                                        @if($event->is_featured)<span class="event-featured">Featured</span>@endif
                                    </div>
                                    <h3>{{ $event->title }}</h3>
                                    <p>{{ $event->excerpt }}</p>
                                    <div class="event-meta">
                                        <span>{{ $event->starts_at->format('D, d M Y · g:i A') }}</span>
                                        <span>{{ $event->location }}</span>
                                    </div>
                                    <a class="event-action" href="{{ route('events.index', ['event' => $event->slug]) }}#register">Reserve a place <span>→</span></a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>

            <aside class="registration-card" id="register">
                <p class="section-kicker">Registration</p>
                <h2>Reserve your place.</h2>
                <p>Select an event and leave your details. Your registration is saved immediately.</p>

                @if($formEvent)
                    <div class="selected-event">
                        <span>Selected session</span>
                        <strong>{{ $formEvent->title }}</strong>
                        <small>{{ $formEvent->starts_at->format('d M Y · g:i A') }} · {{ $formEvent->location }}</small>
                    </div>

                    <form class="event-form" method="POST" action="{{ route('events.register', $formEvent) }}">
                        @csrf
                        <div class="field">
                            <label for="event_slug">Event</label>
                            <select name="event_slug" id="event_slug" onchange="if(this.value){location='{{ route('events.index') }}?event='+encodeURIComponent(this.value)+'#register'}">
                                @foreach($events as $event)
                                    <option value="{{ $event->slug }}" @selected($event->is($formEvent))>{{ $event->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-two">
                            <div class="field"><label for="reg-name">Full name *</label><input id="reg-name" name="name" value="{{ old('name') }}" autocomplete="name" required>@error('name')<div class="field-error">{{ $message }}</div>@enderror</div>
                            <div class="field"><label for="reg-email">Email *</label><input id="reg-email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>@error('email')<div class="field-error">{{ $message }}</div>@enderror</div>
                        </div>
                        <div class="form-two">
                            <div class="field"><label for="reg-phone">Phone</label><input id="reg-phone" name="phone" value="{{ old('phone') }}" autocomplete="tel"></div>
                            <div class="field"><label for="reg-company">Company</label><input id="reg-company" name="company" value="{{ old('company') }}" autocomplete="organization"></div>
                        </div>
                        <div class="field"><label for="reg-message">Anything we should know?</label><textarea id="reg-message" name="message" rows="3">{{ old('message') }}</textarea>@error('message')<div class="field-error">{{ $message }}</div>@enderror</div>
                        <button class="register-button" type="submit">Complete registration</button>
                    </form>
                @else
                    <div class="empty-events">Registration will open with the next published event.</div>
                @endif
            </aside>
        </div>
    </section>
</div>
@endsection
