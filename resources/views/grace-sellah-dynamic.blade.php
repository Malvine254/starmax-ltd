<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $content['meta']['title'] ?? 'Grace Sellah Atemo - Virtual Assistant' }}</title>
  <meta name="description" content="{{ $content['meta']['description'] ?? '' }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="stylesheet" href="{{ asset('grace-assets/style.css') }}" />
</head>
<body>
@php
    $hero = $content['hero'] ?? [];
    $about = $content['about'] ?? [];
    $contact = $content['contact'] ?? [];
  $profileImageUrl = '';
  $profileImagePath = trim((string) ($about['profile_image_path'] ?? ''));
  $profileImageFallbackUrl = trim((string) ($about['profile_image_url'] ?? ''));

  if ($profileImagePath !== '' && \Illuminate\Support\Facades\Storage::disk('public')->exists($profileImagePath)) {
    $profileImageUrl = asset('storage/' . $profileImagePath);
  } elseif ($profileImageFallbackUrl !== '' && filter_var($profileImageFallbackUrl, FILTER_VALIDATE_URL)) {
    $profileImageUrl = $profileImageFallbackUrl;
  }
@endphp

  <nav id="navbar">
    <div class="nav-container">
      <a href="#home" class="logo">{{ $content['brand']['label'] ?? 'Grace' }}<span>.</span></a>
      <ul class="nav-links">
        <li><a href="#home">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#portfolio">Portfolio</a></li>
        <li><a href="#tools">Tools</a></li>
        <li><a href="#contact" class="nav-cta">Contact Me</a></li>
      </ul>
      <button class="hamburger" id="hamburger" aria-label="Toggle menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </nav>

  <section id="home" class="hero">
    <div class="hero-bg" style="background-image:url('{{ $hero['background_image'] ?? '' }}')"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <p class="hero-eyebrow">{{ $hero['eyebrow'] ?? '' }}</p>
      <h1 class="hero-title">
        @foreach(($hero['title_lines'] ?? []) as $line)
          {{ $line }}@if(! $loop->last)<br />@endif
        @endforeach
        @if(!empty($hero['highlight']))<span>{{ $hero['highlight'] }}</span>@endif
      </h1>
      <p class="hero-subtitle">{{ $hero['subtitle'] ?? '' }}</p>
      <div class="hero-actions">
        @foreach(($hero['actions'] ?? []) as $action)
          <a href="{{ $action['href'] ?? '#' }}" class="btn {{ $action['variant'] ?? 'btn-primary' }}">{{ $action['label'] ?? 'Learn More' }}</a>
        @endforeach
      </div>
    </div>
    <div class="hero-scroll-hint">
      <span>Scroll</span>
      <div class="scroll-line"></div>
    </div>
  </section>

  <section class="services-strip">
    <div class="container">
      <div class="strip-grid">
        @foreach(($content['strip_cards'] ?? []) as $card)
          <div class="strip-card">
            <div class="strip-icon">
              <svg viewBox="0 0 48 48" fill="none"><rect x="6" y="10" width="36" height="28" rx="3" stroke="currentColor" stroke-width="2.5"/><path d="M6 18h36" stroke="currentColor" stroke-width="2.5"/><path d="M16 10V6M32 10V6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
            </div>
            <h3>{{ $card['title'] ?? '' }}</h3>
            <p>{{ $card['description'] ?? '' }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <section id="about" class="about">
    <div class="container about-grid">
      <div class="about-image-wrap">
        <div class="about-image-frame">
          @if(!empty($profileImageUrl))
            <img class="about-profile-image" src="{{ $profileImageUrl }}" alt="{{ $about['profile_image_alt'] ?? 'Profile image' }}" />
          @else
            <div class="about-image-placeholder">
              <svg viewBox="0 0 120 160" fill="none"><rect width="120" height="160" rx="12" fill="#e8e0d8"/><circle cx="60" cy="55" r="28" fill="#c4b8a8"/><ellipse cx="60" cy="145" rx="48" ry="32" fill="#c4b8a8"/></svg>
              <p class="placeholder-note">{{ $about['photo_note'] ?? 'Add your photo here' }}</p>
            </div>
          @endif
        </div>
        <div class="about-badge">
          <span class="badge-number">{{ $about['badge_number'] ?? '' }}</span>
          <span class="badge-text">{{ $about['badge_text'] ?? '' }}</span>
        </div>
      </div>
      <div class="about-content">
        <p class="section-eyebrow">{{ $about['eyebrow'] ?? '' }}</p>
        <h2 class="section-title">{{ $about['title'] ?? '' }}</h2>
        <div class="title-accent"></div>
        @foreach(($about['description'] ?? []) as $paragraph)
          <p class="about-body">{{ $paragraph }}</p>
        @endforeach
        <div class="about-highlights">
          @foreach(($about['highlights'] ?? []) as $highlight)
            <div class="highlight-item">
              <div class="highlight-icon">✓</div>
              <span>{{ is_array($highlight) ? ($highlight['title'] ?? '') : $highlight }}</span>
            </div>
          @endforeach
        </div>
        <a href="#contact" class="btn btn-primary">{{ $about['cta_label'] ?? 'Work With Me' }}</a>
      </div>
    </div>
  </section>

  <section id="services" class="services">
    <div class="container">
      <div class="section-header">
        <p class="section-eyebrow">What I Offer</p>
        <h2 class="section-title">My Services</h2>
        <div class="title-accent centered"></div>
        <p class="section-subtitle">Comprehensive virtual support tailored to your business needs</p>
      </div>
      <div class="services-grid">
        @foreach(($content['services'] ?? []) as $service)
          <div class="service-card">
            <div class="service-card-top" style="background: {{ $service['gradient'] ?? 'linear-gradient(135deg,#2d4a3e,#4a7c5f)' }}">
              <div class="service-icon">
                <svg viewBox="0 0 48 48" fill="none"><rect x="6" y="10" width="36" height="28" rx="3" stroke="white" stroke-width="2.5"/><path d="M6 18h36M14 26h10M14 32h6" stroke="white" stroke-width="2.5" stroke-linecap="round"/></svg>
              </div>
              <h3>{{ $service['title'] ?? '' }}</h3>
            </div>
            <ul class="service-list">
              @foreach(($service['items'] ?? []) as $item)
                <li>{{ $item }}</li>
              @endforeach
            </ul>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <section id="portfolio" class="portfolio">
    <div class="container">
      <div class="section-header">
        <p class="section-eyebrow">My Work</p>
        <h2 class="section-title">Work Samples &amp; Projects</h2>
        <div class="title-accent centered"></div>
        <p class="section-subtitle">A selection of real deliverables from my virtual assistant practice</p>
      </div>
      <div class="portfolio-grid">
        @foreach(($content['portfolio'] ?? []) as $item)
          <div class="portfolio-item">
            <div class="portfolio-icon" style="background:{{ $item['background'] ?? '#f1f5f9' }}">
              <svg viewBox="0 0 48 48" fill="none"><rect x="6" y="8" width="36" height="32" rx="3" stroke="{{ $item['accent'] ?? '#64748b' }}" stroke-width="2.5"/><path d="M6 16h36M14 22h10M14 28h6M14 34h14" stroke="{{ $item['accent'] ?? '#64748b' }}" stroke-width="2" stroke-linecap="round"/></svg>
            </div>
            <h4>{{ $item['title'] ?? '' }}</h4>
            <p>{{ $item['description'] ?? '' }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <section id="tools" class="tools">
    <div class="container">
      <div class="section-header">
        <p class="section-eyebrow">Tech Stack</p>
        <h2 class="section-title">Tools &amp; Software</h2>
        <div class="title-accent centered"></div>
        <p class="section-subtitle">Industry-standard tools I use to deliver excellent results</p>
      </div>
      <div class="tools-grid">
        @foreach(($content['tools'] ?? []) as $tool)
          <div class="tool-pill"><span class="tool-dot" style="background:{{ $tool['color'] ?? '#64748b' }}"></span>{{ $tool['name'] ?? '' }}</div>
        @endforeach
      </div>
    </div>
  </section>

  <section id="contact" class="contact">
    <div class="container contact-grid">
      <div class="contact-info">
        <p class="section-eyebrow light">{{ $contact['eyebrow'] ?? '' }}</p>
        <h2 class="section-title light">{{ $contact['title'] ?? '' }}</h2>
        <div class="title-accent"></div>
        <p class="contact-body">{{ $contact['description'] ?? '' }}</p>
        <div class="contact-details">
          <a href="mailto:{{ $contact['email'] ?? '' }}" class="contact-item">
            <div class="contact-icon-wrap">
              <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="4" width="20" height="16" rx="2" stroke="currentColor" stroke-width="2"/><path d="M2 8l10 7 10-7" stroke="currentColor" stroke-width="2"/></svg>
            </div>
            <div>
              <span class="contact-label">Email</span>
              <span class="contact-value">{{ $contact['email'] ?? '' }}</span>
            </div>
          </a>
          <a href="tel:{{ $contact['phone_tel'] ?? '' }}" class="contact-item">
            <div class="contact-icon-wrap">
              <svg viewBox="0 0 24 24" fill="none"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
              <span class="contact-label">Phone</span>
              <span class="contact-value">{{ $contact['phone'] ?? '' }}</span>
            </div>
          </a>
          <a href="{{ $contact['linkedin_url'] ?? '#' }}" target="_blank" rel="noopener" class="contact-item">
            <div class="contact-icon-wrap">
              <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="2" width="20" height="20" rx="4" stroke="currentColor" stroke-width="2"/><path d="M7 10v7M7 7v.01M11 17v-4a2 2 0 0 1 4 0v4M11 10v7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            </div>
            <div>
              <span class="contact-label">LinkedIn</span>
              <span class="contact-value">{{ $contact['linkedin_label'] ?? '' }}</span>
            </div>
          </a>
        </div>
      </div>

      <div class="contact-form-wrap">
        <form class="contact-form" id="graceContactForm">
          <h3>Send Me a Message</h3>
          <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" placeholder="Your full name" required />
          </div>
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" placeholder="your@email.com" required />
          </div>
          <div class="form-group">
            <label for="service">Service Interested In</label>
            <select id="service">
              <option value="">Select a service...</option>
              @foreach(($contact['service_options'] ?? []) as $serviceOption)
                <option>{{ $serviceOption }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" rows="4" placeholder="Tell me about your project or needs..." required></textarea>
          </div>
          <button type="submit" class="btn btn-primary full-width">Send Message</button>
          <p class="form-note" id="form-msg"></p>
        </form>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="container footer-inner">
      <a href="#home" class="logo footer-logo">{{ $content['brand']['footer_label'] ?? ($content['brand']['label'] ?? 'Grace') }}<span>.</span></a>
      <p class="footer-copy">{!! $content['footer']['copy'] ?? '' !!}</p>
      <div class="footer-social">
        <a href="mailto:{{ $contact['email'] ?? '' }}" aria-label="Email">
          <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="4" width="20" height="16" rx="2" stroke="currentColor" stroke-width="2"/><path d="M2 8l10 7 10-7" stroke="currentColor" stroke-width="2"/></svg>
        </a>
        <a href="{{ $contact['linkedin_url'] ?? '#' }}" target="_blank" rel="noopener" aria-label="LinkedIn">
          <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="2" width="20" height="20" rx="4" stroke="currentColor" stroke-width="2"/><path d="M7 10v7M7 7v.01M11 17v-4a2 2 0 0 1 4 0v4M11 10v7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        </a>
      </div>
    </div>
  </footer>

  <a href="#home" class="back-to-top" id="backToTop" aria-label="Back to top">
    <svg viewBox="0 0 24 24" fill="none"><path d="M12 19V5M5 12l7-7 7 7" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
  </a>

  <script src="{{ asset('grace-assets/script.js') }}"></script>
</body>
</html>