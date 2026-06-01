<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GraceSellahPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GraceSellahPageController extends Controller
{
    public function edit()
    {
        $page = GraceSellahPage::firstOrCreate(
            ['slug' => 'grace-sellah'],
            ['content' => GraceSellahPage::defaultContent()],
        );
        $content = $page->mergedContent();

        return view('admin.grace-sellah.edit', [
            'page' => $page,
            'content' => $content,
        ]);
    }

    public function update(Request $request)
    {
        $page = GraceSellahPage::firstOrCreate(
            ['slug' => 'grace-sellah'],
            ['content' => GraceSellahPage::defaultContent()],
        );

        $validated = $request->validate([
            'meta_title' => ['required', 'string', 'max:255'],
            'meta_description' => ['required', 'string', 'max:500'],
            'brand_label' => ['required', 'string', 'max:120'],
            'brand_footer_label' => ['required', 'string', 'max:120'],
            'hero_eyebrow' => ['required', 'string', 'max:255'],
            'hero_title_line_1' => ['required', 'string', 'max:255'],
            'hero_title_line_2' => ['required', 'string', 'max:255'],
            'hero_title_line_3' => ['required', 'string', 'max:255'],
            'hero_highlight' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['required', 'string', 'max:255'],
            'hero_background_image' => ['required', 'url', 'max:2048'],
            'about_eyebrow' => ['required', 'string', 'max:255'],
            'about_title' => ['required', 'string', 'max:255'],
            'about_description_1' => ['required', 'string', 'max:2000'],
            'about_description_2' => ['required', 'string', 'max:2000'],
            'about_profile_image' => ['nullable', 'image', 'max:4096'],
            'about_profile_image_url' => ['nullable', 'url', 'max:2048'],
            'about_profile_image_alt' => ['nullable', 'string', 'max:255'],
            'about_photo_note' => ['required', 'string', 'max:255'],
            'about_badge_number' => ['required', 'string', 'max:20'],
            'about_badge_text' => ['required', 'string', 'max:120'],
            'about_highlights' => ['required', 'array', 'min:1'],
            'about_highlights.*.title' => ['required', 'string', 'max:255'],
            'about_cta_label' => ['required', 'string', 'max:120'],
            'contact_eyebrow' => ['required', 'string', 'max:255'],
            'contact_title' => ['required', 'string', 'max:255'],
            'contact_description' => ['required', 'string', 'max:2000'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:80'],
            'contact_phone_tel' => ['required', 'string', 'max:40'],
            'contact_linkedin_label' => ['required', 'string', 'max:255'],
            'contact_linkedin_url' => ['required', 'url', 'max:2048'],
            'footer_copy' => ['required', 'string', 'max:255'],
            'strip_cards' => ['required', 'array', 'min:1'],
            'strip_cards.*.title' => ['required', 'string', 'max:120'],
            'strip_cards.*.description' => ['required', 'string', 'max:255'],
            'services' => ['required', 'array', 'min:1'],
            'services.*.title' => ['required', 'string', 'max:120'],
            'services.*.gradient' => ['required', 'string', 'max:255'],
            'services.*.items' => ['required', 'string', 'max:4000'],
            'portfolio' => ['required', 'array', 'min:1'],
            'portfolio.*.title' => ['required', 'string', 'max:120'],
            'portfolio.*.description' => ['required', 'string', 'max:1000'],
            'portfolio.*.background' => ['required', 'string', 'max:40'],
            'portfolio.*.accent' => ['required', 'string', 'max:40'],
            'tools' => ['required', 'array', 'min:1'],
            'tools.*.name' => ['required', 'string', 'max:120'],
            'tools.*.color' => ['required', 'string', 'max:40'],
        ]);

        $content = [
            'meta' => [
                'title' => $validated['meta_title'],
                'description' => $validated['meta_description'],
            ],
            'brand' => [
                'label' => $validated['brand_label'],
                'footer_label' => $validated['brand_footer_label'],
            ],
            'hero' => [
                'eyebrow' => $validated['hero_eyebrow'],
                'title_lines' => [
                    $validated['hero_title_line_1'],
                    $validated['hero_title_line_2'],
                    $validated['hero_title_line_3'],
                ],
                'highlight' => $validated['hero_highlight'],
                'subtitle' => $validated['hero_subtitle'],
                'background_image' => $validated['hero_background_image'],
                'actions' => GraceSellahPage::defaultContent()['hero']['actions'],
            ],
            'strip_cards' => $this->normalizeCards($validated['strip_cards'], ['title', 'description']),
            'about' => [
                'eyebrow' => $validated['about_eyebrow'],
                'title' => $validated['about_title'],
                'description' => [
                    $validated['about_description_1'],
                    $validated['about_description_2'],
                ],
                'profile_image_path' => $page->mergedContent()['about']['profile_image_path'] ?? '',
                'profile_image_url' => $validated['about_profile_image_url'] ?? '',
                'profile_image_alt' => $validated['about_profile_image_alt'] ?: GraceSellahPage::defaultContent()['about']['profile_image_alt'],
                'photo_note' => $validated['about_photo_note'],
                'badge_number' => $validated['about_badge_number'],
                'badge_text' => $validated['about_badge_text'],
                'highlights' => $this->normalizeTextList($validated['about_highlights']),
                'cta_label' => $validated['about_cta_label'],
            ],
            'services' => $this->normalizeServices($validated['services']),
            'portfolio' => $this->normalizeCards($validated['portfolio'], ['title', 'description', 'background', 'accent']),
            'tools' => $this->normalizeCards($validated['tools'], ['name', 'color']),
            'contact' => [
                'eyebrow' => $validated['contact_eyebrow'],
                'title' => $validated['contact_title'],
                'description' => $validated['contact_description'],
                'email' => $validated['contact_email'],
                'phone' => $validated['contact_phone'],
                'phone_tel' => $validated['contact_phone_tel'],
                'linkedin_label' => $validated['contact_linkedin_label'],
                'linkedin_url' => $validated['contact_linkedin_url'],
                'service_options' => GraceSellahPage::defaultContent()['contact']['service_options'],
            ],
            'footer' => [
                'copy' => $validated['footer_copy'],
            ],
        ];

        if ($request->hasFile('about_profile_image')) {
            $existingPath = $page->mergedContent()['about']['profile_image_path'] ?? null;
            if ($existingPath) {
                Storage::disk('public')->delete($existingPath);
            }

            $content['about']['profile_image_path'] = $request->file('about_profile_image')->store('grace-sellah/profile', 'public');
        }

        $page->update([
            'content' => $content,
        ]);

        return back()->with('success', 'Grace Sellah page content updated.');
    }

    private function linesToArray(string $text): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $text) ?: [])));
    }

    private function normalizeCards(array $items, array $keys): array
    {
        return array_values(array_map(function (array $item) use ($keys): array {
            $normalized = [];

            foreach ($keys as $key) {
                $normalized[$key] = trim((string) ($item[$key] ?? ''));
            }

            return $normalized;
        }, array_filter($items, fn (array $item) => collect($item)->filter(fn ($value) => trim((string) $value) !== '')->isNotEmpty())));
    }

    private function normalizeServices(array $services): array
    {
        return array_values(array_map(function (array $service): array {
            return [
                'title' => trim((string) ($service['title'] ?? '')),
                'gradient' => trim((string) ($service['gradient'] ?? '')),
                'items' => $this->linesToArray((string) ($service['items'] ?? '')),
            ];
        }, array_filter($services, fn (array $service) => collect($service)->filter(fn ($value) => trim((string) $value) !== '')->isNotEmpty())));
    }

    private function normalizeTextList(array $items): array
    {
        return array_values(array_filter(array_map(function (array $item): string {
            return trim((string) ($item['title'] ?? ''));
        }, array_filter($items, fn (array $item) => collect($item)->filter(fn ($value) => trim((string) $value) !== '')->isNotEmpty()))));
    }
}