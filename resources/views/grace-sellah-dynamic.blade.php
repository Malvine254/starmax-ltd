<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $content['meta']['title'] }}</title>
  <meta name="description" content="{{ $content['meta']['description'] }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="theme-color" content="#11100e">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('grace-assets/style.css') }}?v={{ filemtime(public_path('grace-assets/style.css')) }}">
</head>
<body>
@php
  $hero = $content['hero'];
  $about = $content['about'];
  $contact = $content['contact'];
  $labels = $content['labels'];
  $profileImageUrl = '';
  $profileImagePath = trim((string) ($about['profile_image_path'] ?? ''));
  $fallbackImage = trim((string) ($about['profile_image_url'] ?? ''));
  if ($profileImagePath !== '' && \Illuminate\Support\Facades\Storage::disk('public')->exists($profileImagePath)) {
      $profileImageUrl = asset('storage/'.$profileImagePath);
  } elseif ($fallbackImage !== '' && filter_var($fallbackImage, FILTER_VALIDATE_URL)) {
      $profileImageUrl = $fallbackImage;
  }
@endphp

<nav id="navbar" aria-label="Primary navigation">
  <div class="nav-container">
    <a href="#home" class="logo">{{ $content['brand']['label'] }}<span>.</span></a>
    <ul class="nav-links">
      <li><a href="#home">{{ $labels['nav_home'] }}</a></li>
      <li><a href="#about">{{ $labels['nav_about'] }}</a></li>
      <li><a href="#services">{{ $labels['nav_services'] }}</a></li>
      <li><a href="#portfolio">{{ $labels['nav_portfolio'] }}</a></li>
      <li><a href="#tools">{{ $labels['nav_tools'] }}</a></li>
      <li><a href="#contact" class="nav-cta">{{ $labels['nav_cta'] }}</a></li>
    </ul>
    <button class="hamburger" id="hamburger" type="button" aria-label="Open menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<main>
  <section id="home" class="hero">
    <div class="hero-bg" style="background-image:url('{{ $hero['background_image'] }}')"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <p class="hero-eyebrow">{{ $hero['eyebrow'] }}</p>
      <h1 class="hero-title">
        @foreach($hero['title_lines'] as $line)
          <span>{{ $line }}</span>
        @endforeach
      </h1>
      <p class="hero-subtitle">{{ $hero['subtitle'] }}</p>
      <div class="hero-actions">
        @foreach($hero['actions'] as $action)
          <a href="{{ $action['href'] }}" class="btn {{ $action['variant'] }}">{{ $action['label'] }}</a>
        @endforeach
      </div>
    </div>
    <div class="hero-proof" aria-label="Key services">
      @foreach(array_slice($content['strip_cards'], 0, 3) as $card)
        <div><strong>{{ $card['title'] }}</strong><span>{{ $card['description'] }}</span></div>
      @endforeach
    </div>
  </section>

  <section id="about" class="about section">
    <div class="container about-grid">
      <div class="about-image-wrap">
        <div class="about-image-frame">
          @if($profileImageUrl)
            <img class="about-profile-image" src="{{ $profileImageUrl }}" alt="{{ $about['profile_image_alt'] }}">
          @else
            <div class="about-image-placeholder">
              <span>{{ strtoupper(substr($content['brand']['label'], 0, 1)) }}</span>
              <p>{{ $about['photo_note'] }}</p>
            </div>
          @endif
        </div>
        <div class="about-badge"><b>{{ $about['badge_number'] }}</b><span>{{ $about['badge_text'] }}</span></div>
      </div>
      <div class="about-content">
        <p class="section-eyebrow">{{ $about['eyebrow'] }}</p>
        <h2 class="section-title">{{ $about['title'] }}</h2>
        @foreach($about['description'] as $paragraph)<p class="about-body">{{ $paragraph }}</p>@endforeach
        <div class="about-highlights">
          @foreach($about['highlights'] as $highlight)
            <span>✓ {{ is_array($highlight) ? $highlight['title'] : $highlight }}</span>
          @endforeach
        </div>
        <a href="#contact" class="text-link">{{ $about['cta_label'] }} <span>→</span></a>
      </div>
    </div>
  </section>

  <section id="services" class="services section">
    <div class="container">
      <header class="section-header">
        <p class="section-eyebrow">{{ $labels['services_eyebrow'] }}</p>
        <h2 class="section-title">{{ $labels['services_title'] }}</h2>
        <p class="section-subtitle">{{ $labels['services_subtitle'] }}</p>
      </header>
      <div class="services-grid">
        @foreach($content['services'] as $service)
          <article class="service-card">
            <span class="service-number">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
            <h3>{{ $service['title'] }}</h3>
            <ul>@foreach($service['items'] as $item)<li>{{ $item }}</li>@endforeach</ul>
          </article>
        @endforeach
      </div>
    </div>
  </section>

  <section id="portfolio" class="portfolio section">
    <div class="container">
      <header class="section-header">
        <p class="section-eyebrow">{{ $labels['portfolio_eyebrow'] }}</p>
        <h2 class="section-title">{{ $labels['portfolio_title'] }}</h2>
        <p class="section-subtitle">{{ $labels['portfolio_subtitle'] }}</p>
      </header>
      <div class="portfolio-grid">
        @foreach($content['portfolio'] as $item)
          <article class="portfolio-item" style="--item-accent:{{ $item['accent'] }};--item-bg:{{ $item['background'] }}">
            <span class="portfolio-index">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
            <div><h3>{{ $item['title'] }}</h3><p>{{ $item['description'] }}</p></div>
          </article>
        @endforeach
      </div>
    </div>
  </section>

  <section id="tools" class="tools section">
    <div class="container tools-layout">
      <header class="section-header">
        <p class="section-eyebrow">{{ $labels['tools_eyebrow'] }}</p>
        <h2 class="section-title">{{ $labels['tools_title'] }}</h2>
        <p class="section-subtitle">{{ $labels['tools_subtitle'] }}</p>
      </header>
      <div class="tools-grid">
        @foreach($content['tools'] as $tool)
          <span class="tool-pill"><i style="background:{{ $tool['color'] }}"></i>{{ $tool['name'] }}</span>
        @endforeach
      </div>
    </div>
  </section>

  <section id="contact" class="contact section">
    <div class="container contact-grid">
      <div class="contact-info">
        <p class="section-eyebrow">{{ $contact['eyebrow'] }}</p>
        <h2 class="section-title">{{ $contact['title'] }}</h2>
        <p class="contact-body">{{ $contact['description'] }}</p>
        <div class="contact-details">
          <a href="mailto:{{ $contact['email'] }}"><span>Email</span><strong>{{ $contact['email'] }}</strong></a>
          <a href="tel:{{ $contact['phone_tel'] }}"><span>Phone</span><strong>{{ $contact['phone'] }}</strong></a>
          <a href="{{ $contact['linkedin_url'] }}" target="_blank" rel="noopener"><span>LinkedIn</span><strong>{{ $contact['linkedin_label'] }}</strong></a>
        </div>
      </div>
      <form class="contact-form" id="graceContactForm">
        <h3>{{ $labels['form_title'] }}</h3>
        <div class="form-group"><label for="name">{{ $labels['form_name_label'] }}</label><input type="text" id="name" name="name" autocomplete="name" required></div>
        <div class="form-group"><label for="email">{{ $labels['form_email_label'] }}</label><input type="email" id="email" name="email" autocomplete="email" required></div>
        <div class="form-group"><label for="service">{{ $labels['form_service_label'] }}</label><select id="service" name="service"><option value="">Select one</option>@foreach($contact['service_options'] as $option)<option value="{{ $option }}">{{ $option }}</option>@endforeach</select></div>
        <div class="form-group"><label for="message">{{ $labels['form_message_label'] }}</label><textarea id="message" name="message" rows="4" required></textarea></div>
        <button type="submit" class="btn btn-primary full-width" data-label="{{ $labels['form_submit_label'] }}">{{ $labels['form_submit_label'] }}</button>
        <p class="form-note" id="form-msg" aria-live="polite"></p>
      </form>
    </div>
  </section>
</main>

<footer class="footer">
  <div class="container footer-inner">
    <a href="#home" class="logo">{{ $content['brand']['footer_label'] }}<span>.</span></a>
    <p>{{ html_entity_decode($content['footer']['copy'], ENT_QUOTES | ENT_HTML5) }}</p>
    <a href="#home" class="footer-top">Back to top ↑</a>
  </div>
</footer>
<a href="#home" class="back-to-top" id="backToTop" aria-label="Back to top">↑</a>
<script src="{{ asset('grace-assets/script.js') }}?v={{ filemtime(public_path('grace-assets/script.js')) }}"></script>
</body>
</html>
