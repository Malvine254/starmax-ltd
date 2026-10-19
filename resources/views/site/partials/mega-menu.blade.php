<div class="nav-dropdown mega-menu" id="{{ $id }}" aria-labelledby="{{ $id }}-trigger">
    <div class="mega-menu-heading">
        <div>
            <p class="mega-menu-eyebrow">Explore {{ $title }}</p>
            <p class="mega-menu-title">{{ $description }}</p>
        </div>
        <a href="{{ $overviewUrl }}" class="mega-menu-overview">View all {{ strtolower($title) }} <i data-lucide="arrow-up-right" aria-hidden="true"></i></a>
    </div>
    <div class="mega-menu-grid">
        @foreach($groups as $group)
        <div class="mega-menu-group">
            <h2 class="mega-menu-label">{{ $group['label'] }}</h2>
            @foreach($group['links'] as $link)
            <a href="{{ $link['url'] }}" class="dropdown-item">
                <span class="dropdown-icon"><i data-lucide="{{ $link['icon'] }}" aria-hidden="true"></i></span>
                <span class="dropdown-text"><strong>{{ $link['title'] }}</strong><span>{{ $link['description'] }}</span></span>
                <i class="mega-menu-arrow" data-lucide="arrow-up-right" aria-hidden="true"></i>
            </a>
            @endforeach
        </div>
        @endforeach
    </div>
    <div class="mega-menu-footer">
        <p><strong>Not sure where to start?</strong> Tell us what your business needs.</p>
        <a href="/contact">Let's plan your project <i data-lucide="arrow-right" aria-hidden="true"></i></a>
    </div>
</div>
