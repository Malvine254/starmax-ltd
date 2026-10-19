@extends('site.layout')

@section('title', 'Products - Starmax Ltd')
@section('description', 'Explore custom digital product development, business platforms, mobile applications, and automation with Starmax Ltd in Nairobi, Kenya.')

@section('content')
<style>
.product-page h1 { color:var(--text); }
.product-page .card { display:flex; flex-direction:column; gap:14px; }
.product-page .card ul { padding-left:20px; }
.product-page .card .btn { margin-top:auto; align-self:flex-start; white-space:normal; }
</style>
<div class="product-page">
<section class="section">
    <div class="section-header">
        <p class="eyebrow">Digital Product Development</p>
        <h1>From a business problem to a useful digital product.</h1>
        <p>We design and develop software around your users, operations, and budget. The solutions below describe custom development options, not off-the-shelf products available for purchase or a claim that every feature has already been delivered.</p>
    </div>
    <div class="grid grid-3">
        <article class="card reveal" id="web-platforms">
            <div class="card-icon purple"><i data-lucide="globe"></i></div>
            <h2>Web Platforms</h2>
            <p>Customer portals, business websites, and internal tools that bring content, enquiries, and operations together.</p>
            <ul>
                <li>CMS publishing and role-based administration</li>
                <li>Booking, registration, and customer workflows</li>
                <li>Accessible, responsive interfaces and maintainable integrations</li>
            </ul>
            <a href="/services/web-development" class="btn btn-secondary">Explore Web Development</a>
        </article>
        <article class="card reveal" id="mobile-applications">
            <div class="card-icon blue"><i data-lucide="smartphone"></i></div>
            <h2>Mobile Applications</h2>
            <p>Native Android apps for device-focused workflows, or a separately assessed cross-platform approach for Android and iOS.</p>
            <ul>
                <li>Account management and backend connectivity</li>
                <li>Offline tasks and synchronization where required</li>
                <li>Device testing, release preparation, and maintenance planning</li>
            </ul>
            <a href="/services/android-apps" class="btn btn-secondary">Explore Android Development</a>
        </article>
        <article class="card reveal" id="automation-tools">
            <div class="card-icon teal"><i data-lucide="bot"></i></div>
            <h2>Automation Tools</h2>
            <p>Start with a narrow, testable use case instead of an open-ended promise of autonomous AI.</p>
            <ul>
                <li>Knowledge search grounded in approved sources</li>
                <li>Document extraction and workflow routing</li>
                <li>Human approvals, evaluations, and cost visibility</li>
            </ul>
            <a href="/services/ai-automation" class="btn btn-secondary">Explore AI &amp; Automation</a>
        </article>
    </div>
</section>
<section class="section" id="business-solutions">
    <div class="section-header left">
        <p class="eyebrow">Commerce &amp; Business Operations</p>
        <h2>Choose the workflow before choosing the technology.</h2>
        <p>A retail checkout, a B2B quote request, and a private business portal solve different problems. We define the user journey, data, permissions, integrations, and acceptance criteria before development.</p>
    </div>
    <div class="grid grid-3">
        <article class="card">
            <h3>Retail &amp; B2B Commerce</h3>
            <p>Product discovery and administration with either payment checkout or quotation workflows, based on how your customers buy.</p>
            <a href="/services/e-commerce" class="btn btn-secondary">Explore Commerce</a>
        </article>
        <article class="card">
            <h3>Property Websites</h3>
            <p>Listings, search, and enquiry workflows. Private rental operations are optional custom work, not an application embedded in this site.</p>
            <a href="/services/real-estate-technology" class="btn btn-secondary">Explore Property Technology</a>
        </article>
        <article class="card">
            <h3>Internal Business Tools</h3>
            <p>Inventory, approvals, scheduling, and reporting connected to the systems your team already uses.</p>
            <a href="/services/custom-software" class="btn btn-secondary">Explore Custom Software</a>
        </article>
    </div>
</section>
<section class="section" id="implementation-examples">
    <div class="section-header left">
        <p class="eyebrow">Implementation Examples</p>
        <h2>Explore what this website supports.</h2>
        <p>The Starmax website includes event registration and certificate workflows, while Grace Sellah's portfolio has editable content and a contact form. These are site implementations, not separately licensed products.</p>
    </div>
    <div class="stack">
        <a href="{{ route('events.index') }}" class="btn btn-secondary">View Events</a>
        <a href="/grace-sellah" class="btn btn-secondary">View Grace Sellah's Portfolio</a>
    </div>
</section>
<section class="section" id="team-experience">
    @include('site.partials.team-experience')
</section>
<section class="section">
    <div class="section-header">
        <h2>Have a product in mind?</h2>
        <p>Bring your priorities, current tools, and budget constraints. We will agree the scope, delivery stages, handover, and any ongoing support before implementation. Hosting and third-party subscriptions are identified separately.</p>
        <div class="stack">
            <a href="/portfolio" class="btn btn-secondary">View Our Portfolio</a>
            <a href="/contact" class="btn btn-primary">Discuss Your Project</a>
        </div>
    </div>
</section>
</div>
@endsection
