@extends('admin.layout')
@section('page-title', 'Vlog Page')

@php
    $pageContent = $content ?? [];
    $meta = $pageContent['meta'] ?? [];
    $brand = $pageContent['brand'] ?? [];
    $labels = $pageContent['labels'] ?? [];
    $hero = $pageContent['hero'] ?? [];
    $heroActions = $hero['actions'] ?? [];
    $about = $pageContent['about'] ?? [];
    $contact = $pageContent['contact'] ?? [];
    $footer = $pageContent['footer'] ?? [];
    $stripCards = old('strip_cards', $pageContent['strip_cards'] ?? []);
    $services = old('services', $pageContent['services'] ?? []);
    $portfolioItems = old('portfolio', $pageContent['portfolio'] ?? []);
    $tools = old('tools', $pageContent['tools'] ?? []);
    $heroLines = $hero['title_lines'] ?? [];
    $heroLine1 = old('hero_title_line_1', $heroLines[0] ?? '');
    $heroLine2 = old('hero_title_line_2', $heroLines[1] ?? '');
    $heroLine3 = old('hero_title_line_3', $heroLines[2] ?? '');
    $aboutProfileImageAlt = old('about_profile_image_alt', $about['profile_image_alt'] ?? '');
@endphp

@section('content')
<style>
    .gs-shell { max-width: 1280px; }
    .gs-tabs { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 18px; }
    .gs-tab-btn {
        border: 1px solid #cbd5e1; background: #fff; color: #334155; padding: 8px 12px;
        border-radius: 999px; font-size: 13px; cursor: pointer;
    }
    .gs-tab-btn.active { background: #1d4ed8; color: #fff; border-color: #1d4ed8; }
    .gs-panel { display: none; }
    .gs-panel.active { display: block; }
    .gs-grid-2 { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
    .gs-grid-3 { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; }
    .gs-repeat-list { display: grid; gap: 12px; }
    .gs-repeat-item {
        border: 1px solid #e2e8f0; border-radius: 12px; background: #f8fafc; padding: 14px;
    }
    .gs-repeat-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 12px; }
    .gs-repeat-title { font-size: 14px; font-weight: 600; color: #0f172a; }
    .gs-add-btn {
        border: 1px dashed #94a3b8; background: #fff; color: #1d4ed8; padding: 9px 12px;
        border-radius: 10px; cursor: pointer; font-size: 13px;
    }
    .gs-remove-btn {
        border: 1px solid #fecaca; background: #fff; color: #dc2626; padding: 8px 10px;
        border-radius: 10px; cursor: pointer; font-size: 12px;
    }
    .gs-section-title { font-size: 15px; font-weight: 600; margin-bottom: 12px; color: #0f172a; }
    .gs-hint { font-size: 12px; color: #64748b; margin-top: 4px; }
    @media (max-width: 960px) {
        .gs-grid-2, .gs-grid-3 { grid-template-columns: 1fr; }
    }
</style>

<div class="gs-shell">
    <h2 style="font-size:16px;font-weight:600;margin-bottom:8px;">Manage Vlog page content</h2>
    <p style="font-size:13px;color:#64748b;margin-bottom:16px;max-width:900px;">
        Each tab controls a section of the page. Use the add buttons to create more services, portfolio items, tools, or highlights.
    </p>

    <div class="gs-tabs" role="tablist" aria-label="Vlog page sections">
        <button type="button" class="gs-tab-btn active" data-tab="meta">Meta</button>
        <button type="button" class="gs-tab-btn" data-tab="labels">Page Labels</button>
        <button type="button" class="gs-tab-btn" data-tab="hero">Hero</button>
        <button type="button" class="gs-tab-btn" data-tab="strip">Top Cards</button>
        <button type="button" class="gs-tab-btn" data-tab="about">About</button>
        <button type="button" class="gs-tab-btn" data-tab="services">Services</button>
        <button type="button" class="gs-tab-btn" data-tab="portfolio">Portfolio</button>
        <button type="button" class="gs-tab-btn" data-tab="tools">Tools</button>
        <button type="button" class="gs-tab-btn" data-tab="contact">Contact</button>
        <button type="button" class="gs-tab-btn" data-tab="footer">Footer</button>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('grace-sellah.admin.page.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <section class="gs-panel active" data-panel="meta">
                <div class="gs-section-title">Meta and Brand</div>
                <div class="gs-grid-2">
                    <div class="form-group">
                        <label>Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $meta['title'] ?? '') }}" required>
                        @error('meta_title')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Brand Label</label>
                        <input type="text" name="brand_label" value="{{ old('brand_label', $brand['label'] ?? '') }}" required>
                        @error('brand_label')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Meta Description</label>
                    <textarea name="meta_description" rows="2" required>{{ old('meta_description', $meta['description'] ?? '') }}</textarea>
                    @error('meta_description')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Footer Brand Label</label>
                    <input type="text" name="brand_footer_label" value="{{ old('brand_footer_label', $brand['footer_label'] ?? '') }}" required>
                    @error('brand_footer_label')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </section>

            <section class="gs-panel" data-panel="labels">
                <div class="gs-section-title">Navigation and Section Copy</div>
                <p class="gs-hint" style="margin-bottom:16px;">Every public heading and form label can be changed here.</p>
                @php
                    $labelFields = [
                        'nav_home' => 'Navigation: Home',
                        'nav_about' => 'Navigation: About',
                        'nav_services' => 'Navigation: Services',
                        'nav_portfolio' => 'Navigation: Work',
                        'nav_tools' => 'Navigation: Tools',
                        'nav_contact' => 'Navigation: Contact',
                        'nav_cta' => 'Navigation CTA',
                        'services_eyebrow' => 'Services Eyebrow',
                        'services_title' => 'Services Heading',
                        'services_subtitle' => 'Services Introduction',
                        'portfolio_eyebrow' => 'Work Eyebrow',
                        'portfolio_title' => 'Work Heading',
                        'portfolio_subtitle' => 'Work Introduction',
                        'tools_eyebrow' => 'Tools Eyebrow',
                        'tools_title' => 'Tools Heading',
                        'tools_subtitle' => 'Tools Introduction',
                        'form_title' => 'Form Heading',
                        'form_name_label' => 'Name Field Label',
                        'form_email_label' => 'Email Field Label',
                        'form_service_label' => 'Service Field Label',
                        'form_message_label' => 'Message Field Label',
                        'form_submit_label' => 'Submit Button Label',
                    ];
                @endphp
                <div class="gs-grid-2">
                    @foreach($labelFields as $key => $label)
                        <div class="form-group">
                            <label>{{ $label }}</label>
                            <input type="text" name="labels[{{ $key }}]" value="{{ old('labels.'.$key, $labels[$key] ?? '') }}" required>
                            @error('labels.'.$key)<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="gs-panel" data-panel="hero">
                <div class="gs-section-title">Hero</div>
                <div class="form-group">
                    <label>Hero Eyebrow</label>
                    <input type="text" name="hero_eyebrow" value="{{ old('hero_eyebrow', $hero['eyebrow'] ?? '') }}" required>
                </div>
                <div class="gs-grid-3">
                    <div class="form-group">
                        <label>Title Line 1</label>
                        <input type="text" name="hero_title_line_1" value="{{ $heroLine1 }}" required>
                    </div>
                    <div class="form-group">
                        <label>Title Line 2</label>
                        <input type="text" name="hero_title_line_2" value="{{ $heroLine2 }}" required>
                    </div>
                    <div class="form-group">
                        <label>Title Line 3</label>
                        <input type="text" name="hero_title_line_3" value="{{ $heroLine3 }}" required>
                    </div>
                </div>
                <div class="gs-grid-2">
                    <div class="form-group">
                        <label>Hero Highlight</label>
                        <input type="text" name="hero_highlight" value="{{ old('hero_highlight', $hero['highlight'] ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Hero Background Image URL</label>
                        <input type="url" name="hero_background_image" value="{{ old('hero_background_image', $hero['background_image'] ?? '') }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Hero Subtitle</label>
                    <textarea name="hero_subtitle" rows="2" required>{{ old('hero_subtitle', $hero['subtitle'] ?? '') }}</textarea>
                </div>
                <div class="gs-grid-2">
                    <div class="form-group">
                        <label>Primary Button Label</label>
                        <input type="text" name="hero_primary_label" value="{{ old('hero_primary_label', $heroActions[0]['label'] ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Primary Button Link</label>
                        <input type="text" name="hero_primary_href" value="{{ old('hero_primary_href', $heroActions[0]['href'] ?? '#services') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Secondary Button Label</label>
                        <input type="text" name="hero_secondary_label" value="{{ old('hero_secondary_label', $heroActions[1]['label'] ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Secondary Button Link</label>
                        <input type="text" name="hero_secondary_href" value="{{ old('hero_secondary_href', $heroActions[1]['href'] ?? '#contact') }}" required>
                    </div>
                </div>
            </section>

            <section class="gs-panel" data-panel="strip">
                <div class="gs-repeat-head">
                    <div class="gs-section-title" style="margin-bottom:0;">Top Cards</div>
                    <button type="button" class="gs-add-btn" data-add="strip_cards">+ Add Card</button>
                </div>
                <div class="gs-repeat-list" data-list="strip_cards" data-next-index="{{ count($stripCards) }}">
                    @foreach($stripCards as $index => $card)
                        <div class="gs-repeat-item" data-row>
                            <div class="gs-repeat-head">
                                <div class="gs-repeat-title">Card {{ $index + 1 }}</div>
                                <button type="button" class="gs-remove-btn" data-remove>Remove</button>
                            </div>
                            <div class="gs-grid-2">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="strip_cards[{{ $index }}][title]" value="{{ old('strip_cards.' . $index . '.title', $card['title'] ?? '') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" name="strip_cards[{{ $index }}][description]" value="{{ old('strip_cards.' . $index . '.description', $card['description'] ?? '') }}" required>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="gs-hint">These cards appear under the hero section.</div>
            </section>

            <section class="gs-panel" data-panel="about">
                <div class="gs-section-title">About</div>
                <div class="gs-grid-2">
                    <div class="form-group">
                        <label>About Eyebrow</label>
                        <input type="text" name="about_eyebrow" value="{{ old('about_eyebrow', $about['eyebrow'] ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>About Title</label>
                        <input type="text" name="about_title" value="{{ old('about_title', $about['title'] ?? '') }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>About Description 1</label>
                    <textarea name="about_description_1" rows="3" required>{{ old('about_description_1', $about['description'][0] ?? '') }}</textarea>
                </div>
                <div class="form-group">
                    <label>About Description 2</label>
                    <textarea name="about_description_2" rows="3" required>{{ old('about_description_2', $about['description'][1] ?? '') }}</textarea>
                </div>
                @php
                    $currentProfileImage = '';
                    $profileImagePath = trim((string) ($about['profile_image_path'] ?? ''));
                    $profileImageFallbackUrl = trim((string) ($about['profile_image_url'] ?? ''));

                    if ($profileImagePath !== '' && \Illuminate\Support\Facades\Storage::disk('public')->exists($profileImagePath)) {
                        $currentProfileImage = asset('storage/' . $profileImagePath);
                    } elseif ($profileImageFallbackUrl !== '' && filter_var($profileImageFallbackUrl, FILTER_VALIDATE_URL)) {
                        $currentProfileImage = $profileImageFallbackUrl;
                    }
                @endphp
                <div class="gs-grid-2">
                    <div class="form-group">
                        <label>Profile Image Upload</label>
                        <input type="file" name="about_profile_image" accept="image/*">
                        @error('about_profile_image')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Profile Image Alt Text</label>
                        <input type="text" name="about_profile_image_alt" value="{{ $aboutProfileImageAlt }}" placeholder="Grace portrait alt text">
                        @error('about_profile_image_alt')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>Profile Image URL Fallback</label>
                    <input type="url" name="about_profile_image_url" value="{{ old('about_profile_image_url', $about['profile_image_url'] ?? '') }}" placeholder="https://...">
                    <div class="gs-hint">Optional. Used only if no file is uploaded.</div>
                    @error('about_profile_image_url')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                @if(!empty($currentProfileImage))
                    <div class="form-group">
                        <label>Current Image Preview</label>
                        <div style="max-width:240px;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;background:#fff;">
                            <img src="{{ $currentProfileImage }}" alt="Current profile image" style="display:block;width:100%;height:240px;object-fit:cover;" />
                        </div>
                    </div>
                @endif
                <div class="gs-grid-3">
                    <div class="form-group">
                        <label>Photo Note</label>
                        <input type="text" name="about_photo_note" value="{{ old('about_photo_note', $about['photo_note'] ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Badge Number</label>
                        <input type="text" name="about_badge_number" value="{{ old('about_badge_number', $about['badge_number'] ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Badge Text</label>
                        <input type="text" name="about_badge_text" value="{{ old('about_badge_text', $about['badge_text'] ?? '') }}" required>
                    </div>
                </div>
                <div class="gs-repeat-head">
                    <div class="gs-repeat-title">Highlights</div>
                    <button type="button" class="gs-add-btn" data-add="about_highlights">+ Add Highlight</button>
                </div>
                <div class="gs-repeat-list" data-list="about_highlights" data-next-index="{{ count($about['highlights'] ?? []) }}">
                    @foreach(($about['highlights'] ?? []) as $index => $highlight)
                        <div class="gs-repeat-item" data-row>
                            <div class="gs-repeat-head">
                                <div class="gs-repeat-title">Highlight {{ $index + 1 }}</div>
                                <button type="button" class="gs-remove-btn" data-remove>Remove</button>
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label>Text</label>
                                <input type="text" name="about_highlights[{{ $index }}][title]" value="{{ old('about_highlights.' . $index . '.title', is_array($highlight) ? ($highlight['title'] ?? '') : $highlight) }}" required>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form-group" style="margin-top:12px;">
                    <label>About CTA Label</label>
                    <input type="text" name="about_cta_label" value="{{ old('about_cta_label', $about['cta_label'] ?? '') }}" required>
                </div>
            </section>

            <section class="gs-panel" data-panel="services">
                <div class="gs-repeat-head">
                    <div class="gs-section-title" style="margin-bottom:0;">Services</div>
                    <button type="button" class="gs-add-btn" data-add="services">+ Add Service</button>
                </div>
                <div class="gs-repeat-list" data-list="services" data-next-index="{{ count($services) }}">
                    @foreach($services as $index => $service)
                        <div class="gs-repeat-item" data-row>
                            <div class="gs-repeat-head">
                                <div class="gs-repeat-title">Service {{ $index + 1 }}</div>
                                <button type="button" class="gs-remove-btn" data-remove>Remove</button>
                            </div>
                            <div class="gs-grid-2">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="services[{{ $index }}][title]" value="{{ old('services.' . $index . '.title', $service['title'] ?? '') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Gradient</label>
                                    <input type="text" name="services[{{ $index }}][gradient]" value="{{ old('services.' . $index . '.gradient', $service['gradient'] ?? '') }}" required>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label>Items</label>
                                <textarea name="services[{{ $index }}][items]" rows="6" required>{{ old('services.' . $index . '.items', implode("\n", $service['items'] ?? [])) }}</textarea>
                                <div class="gs-hint">One item per line.</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="gs-panel" data-panel="portfolio">
                <div class="gs-repeat-head">
                    <div class="gs-section-title" style="margin-bottom:0;">Portfolio Items</div>
                    <button type="button" class="gs-add-btn" data-add="portfolio">+ Add Portfolio Item</button>
                </div>
                <div class="gs-repeat-list" data-list="portfolio" data-next-index="{{ count($portfolioItems) }}">
                    @foreach($portfolioItems as $index => $item)
                        <div class="gs-repeat-item" data-row>
                            <div class="gs-repeat-head">
                                <div class="gs-repeat-title">Portfolio Item {{ $index + 1 }}</div>
                                <button type="button" class="gs-remove-btn" data-remove>Remove</button>
                            </div>
                            <div class="gs-grid-2">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="portfolio[{{ $index }}][title]" value="{{ old('portfolio.' . $index . '.title', $item['title'] ?? '') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="portfolio[{{ $index }}][description]" rows="2" required>{{ old('portfolio.' . $index . '.description', $item['description'] ?? '') }}</textarea>
                                </div>
                            </div>
                            <div class="gs-grid-2">
                                <div class="form-group">
                                    <label>Background Color</label>
                                    <input type="text" name="portfolio[{{ $index }}][background]" value="{{ old('portfolio.' . $index . '.background', $item['background'] ?? '') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Accent Color</label>
                                    <input type="text" name="portfolio[{{ $index }}][accent]" value="{{ old('portfolio.' . $index . '.accent', $item['accent'] ?? '') }}" required>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="gs-panel" data-panel="tools">
                <div class="gs-repeat-head">
                    <div class="gs-section-title" style="margin-bottom:0;">Tools</div>
                    <button type="button" class="gs-add-btn" data-add="tools">+ Add Tool</button>
                </div>
                <div class="gs-repeat-list" data-list="tools" data-next-index="{{ count($tools) }}">
                    @foreach($tools as $index => $tool)
                        <div class="gs-repeat-item" data-row>
                            <div class="gs-repeat-head">
                                <div class="gs-repeat-title">Tool {{ $index + 1 }}</div>
                                <button type="button" class="gs-remove-btn" data-remove>Remove</button>
                            </div>
                            <div class="gs-grid-2">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="tools[{{ $index }}][name]" value="{{ old('tools.' . $index . '.name', $tool['name'] ?? '') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Color</label>
                                    <input type="text" name="tools[{{ $index }}][color]" value="{{ old('tools.' . $index . '.color', $tool['color'] ?? '') }}" required>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="gs-panel" data-panel="contact">
                <div class="gs-section-title">Contact</div>
                <div class="gs-grid-2">
                    <div class="form-group">
                        <label>Contact Eyebrow</label>
                        <input type="text" name="contact_eyebrow" value="{{ old('contact_eyebrow', $contact['eyebrow'] ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Contact Title</label>
                        <input type="text" name="contact_title" value="{{ old('contact_title', $contact['title'] ?? '') }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Contact Description</label>
                    <textarea name="contact_description" rows="3" required>{{ old('contact_description', $contact['description'] ?? '') }}</textarea>
                </div>
                <div class="gs-grid-2">
                    <div class="form-group">
                        <label>Contact Email</label>
                        <input type="email" name="contact_email" value="{{ old('contact_email', $contact['email'] ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Contact Phone</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone', $contact['phone'] ?? '') }}" required>
                    </div>
                </div>
                <div class="gs-grid-2">
                    <div class="form-group">
                        <label>Contact Phone Tel</label>
                        <input type="text" name="contact_phone_tel" value="{{ old('contact_phone_tel', $contact['phone_tel'] ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>LinkedIn Label</label>
                        <input type="text" name="contact_linkedin_label" value="{{ old('contact_linkedin_label', $contact['linkedin_label'] ?? '') }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>LinkedIn URL</label>
                    <input type="url" name="contact_linkedin_url" value="{{ old('contact_linkedin_url', $contact['linkedin_url'] ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label>Contact Form Service Options</label>
                    <textarea name="contact_service_options" rows="6" required>{{ old('contact_service_options', implode("\n", $contact['service_options'] ?? [])) }}</textarea>
                    <div class="gs-hint">One option per line.</div>
                </div>
            </section>

            <section class="gs-panel" data-panel="footer">
                <div class="gs-section-title">Footer</div>
                <div class="form-group">
                    <label>Footer Copy</label>
                    <input type="text" name="footer_copy" value="{{ old('footer_copy', $footer['copy'] ?? '') }}" required>
                </div>
            </section>

            <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:22px;">
                <button type="submit" class="btn btn-primary">Save Page Content</button>
                <a href="{{ url('/grace-sellah') }}" target="_blank" class="btn btn-secondary">Preview Public Page</a>
            </div>

            <template id="template_strip_cards">
                <div class="gs-repeat-item" data-row>
                    <div class="gs-repeat-head">
                        <div class="gs-repeat-title">Card</div>
                        <button type="button" class="gs-remove-btn" data-remove>Remove</button>
                    </div>
                    <div class="gs-grid-2">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="strip_cards[__INDEX__][title]" value="" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="strip_cards[__INDEX__][description]" value="" required>
                        </div>
                    </div>
                </div>
            </template>

            <template id="template_about_highlights">
                <div class="gs-repeat-item" data-row>
                    <div class="gs-repeat-head">
                        <div class="gs-repeat-title">Highlight</div>
                        <button type="button" class="gs-remove-btn" data-remove>Remove</button>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label>Text</label>
                        <input type="text" name="about_highlights[__INDEX__][title]" value="" required>
                    </div>
                </div>
            </template>

            <template id="template_services">
                <div class="gs-repeat-item" data-row>
                    <div class="gs-repeat-head">
                        <div class="gs-repeat-title">Service</div>
                        <button type="button" class="gs-remove-btn" data-remove>Remove</button>
                    </div>
                    <div class="gs-grid-2">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="services[__INDEX__][title]" value="" required>
                        </div>
                        <div class="form-group">
                            <label>Gradient</label>
                            <input type="text" name="services[__INDEX__][gradient]" value="linear-gradient(135deg,#2d4a3e,#4a7c5f)" required>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label>Items</label>
                        <textarea name="services[__INDEX__][items]" rows="6" required></textarea>
                        <div class="gs-hint">One item per line.</div>
                    </div>
                </div>
            </template>

            <template id="template_portfolio">
                <div class="gs-repeat-item" data-row>
                    <div class="gs-repeat-head">
                        <div class="gs-repeat-title">Portfolio Item</div>
                        <button type="button" class="gs-remove-btn" data-remove>Remove</button>
                    </div>
                    <div class="gs-grid-2">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="portfolio[__INDEX__][title]" value="" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="portfolio[__INDEX__][description]" rows="2" required></textarea>
                        </div>
                    </div>
                    <div class="gs-grid-2">
                        <div class="form-group">
                            <label>Background Color</label>
                            <input type="text" name="portfolio[__INDEX__][background]" value="#f1f5f9" required>
                        </div>
                        <div class="form-group">
                            <label>Accent Color</label>
                            <input type="text" name="portfolio[__INDEX__][accent]" value="#64748b" required>
                        </div>
                    </div>
                </div>
            </template>

            <template id="template_tools">
                <div class="gs-repeat-item" data-row>
                    <div class="gs-repeat-head">
                        <div class="gs-repeat-title">Tool</div>
                        <button type="button" class="gs-remove-btn" data-remove>Remove</button>
                    </div>
                    <div class="gs-grid-2">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="tools[__INDEX__][name]" value="" required>
                        </div>
                        <div class="form-group">
                            <label>Color</label>
                            <input type="text" name="tools[__INDEX__][color]" value="#64748b" required>
                        </div>
                    </div>
                </div>
            </template>
        </form>
    </div>
</div>

<script>
(function () {
    const tabButtons = document.querySelectorAll('.gs-tab-btn');
    const panels = document.querySelectorAll('.gs-panel');

    function showTab(name) {
        tabButtons.forEach((button) => {
            button.classList.toggle('active', button.dataset.tab === name);
        });
        panels.forEach((panel) => {
            panel.classList.toggle('active', panel.dataset.panel === name);
        });
    }

    tabButtons.forEach((button) => {
        button.addEventListener('click', () => showTab(button.dataset.tab));
    });

    document.querySelectorAll('[data-add]').forEach((button) => {
        button.addEventListener('click', () => {
            const listName = button.dataset.add;
            const list = document.querySelector(`[data-list="${listName}"]`);
            const template = document.getElementById(`template_${listName}`);
            if (!list || !template) return;

            const nextIndex = Number(list.dataset.nextIndex || 0);
            list.dataset.nextIndex = String(nextIndex + 1);
            const html = template.innerHTML.replaceAll('__INDEX__', String(nextIndex));
            list.insertAdjacentHTML('beforeend', html);
        });
    });

    document.addEventListener('click', (event) => {
        const removeButton = event.target.closest('[data-remove]');
        if (!removeButton) return;

        const row = removeButton.closest('[data-row]');
        if (row) {
            row.remove();
        }
    });

    const firstInvalid = document.querySelector('.form-error');
    if (firstInvalid) {
        const panel = firstInvalid.closest('.gs-panel');
        if (panel && panel.dataset.panel) {
            showTab(panel.dataset.panel);
        }
    }

    const hashTab = window.location.hash.replace('#', '');
    if (hashTab && document.querySelector(`.gs-tab-btn[data-tab="${hashTab}"]`)) {
        showTab(hashTab);
    }
})();
</script>
@endsection
