<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;

class AboutAdminController extends Controller
{
    private function aboutJsonPath(): string
    {
        return storage_path('app/about.json');
    }

    private function readAboutData(): array
    {
        $path = $this->aboutJsonPath();
        if (!file_exists($path)) {
            return [];
        }

        $raw = file_get_contents($path);
        if (!is_string($raw) || $raw === '') {
            return [];
        }

        // Tolerate UTF-8 BOM that may be introduced by external editors/tools.
        $raw = preg_replace('/^\xEF\xBB\xBF/', '', $raw);

        return json_decode($raw, true) ?: [];
    }

    private function writeAboutData(array $data): void
    {
        file_put_contents(
            $this->aboutJsonPath(),
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    /**
     * Delete file from public disk when URL points to /storage/ path.
     */
    private function deletePublicStorageFileByUrl(string $url): void
    {
        $parsed = parse_url($url, PHP_URL_PATH);
        if ($parsed && str_starts_with($parsed, '/storage/')) {
            $relative = substr($parsed, strlen('/storage/'));
            Storage::disk('public')->delete($relative);
        }
    }

    /**
     * Normalize gallery into a consistent array shape.
     *
     * @param mixed $galleryRaw
     * @return array<int, array{url:string,label:?string}>
     */
    private function normalizeGallery($galleryRaw): array
    {
        if (!is_array($galleryRaw)) {
            return [];
        }

        $normalized = [];
        foreach ($galleryRaw as $item) {
            if (is_string($item) && trim($item) !== '') {
                $normalized[] = ['url' => $item, 'label' => null];
                continue;
            }

            if (is_array($item) && !empty($item['url']) && is_string($item['url'])) {
                $label = isset($item['label']) && is_string($item['label']) ? trim($item['label']) : null;
                $normalized[] = [
                    'url' => $item['url'],
                    'label' => $label !== '' ? $label : null,
                ];
            }
        }

        // Keep unique URLs and preserve first-seen order.
        $seen = [];
        $result = [];
        foreach ($normalized as $entry) {
            if (isset($seen[$entry['url']])) {
                continue;
            }
            $seen[$entry['url']] = true;
            $result[] = $entry;
        }

        return $result;
    }

    public function edit()
    {
        $content = $this->readAboutData();

        $logoSekolah = Setting::get('logo_sekolah');

        return view('admin.about_edit', [
            'content' => $content,
            'logoSekolah' => $logoSekolah,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'programs' => 'nullable|string',
            'history' => 'nullable|string',
            'facilities' => 'nullable|string',
            'student_life' => 'nullable|string',
            'seo' => 'nullable|string',
            'hero_overlay_left_title' => 'nullable|string|max:120',
            'hero_overlay_left_subtitle' => 'nullable|string|max:180',
            'hero_overlay_right_title' => 'nullable|string|max:120',
            'hero_overlay_right_subtitle' => 'nullable|string|max:180',
            'gallery_urls' => 'nullable|array',
            'gallery_urls.*' => 'nullable|string',
            'gallery_labels' => 'nullable|array',
            'gallery_labels.*' => 'nullable|string|max:120',
        ]);

        // Preserve non-text keys (especially gallery) so "Simpan Konten" does not wipe uploaded media.
        $existing = $this->readAboutData();

        $merged = array_merge($existing, $data);

        if (isset($data['gallery_urls']) && is_array($data['gallery_urls'])) {
            $labels = $data['gallery_labels'] ?? [];
            $submittedGallery = [];

            foreach ($data['gallery_urls'] as $index => $url) {
                $url = is_string($url) ? trim($url) : '';
                if ($url === '') {
                    continue;
                }

                $label = isset($labels[$index]) && is_string($labels[$index])
                    ? trim($labels[$index])
                    : '';

                $submittedGallery[] = [
                    'url' => $url,
                    'label' => $label !== '' ? $label : null,
                ];
            }

            if (count($submittedGallery) > 0) {
                $merged['gallery'] = $this->normalizeGallery($submittedGallery);
            }
        }

        // Recovery guard: if gallery is empty in JSON but physical files exist, rebuild a small gallery set.
        $gallery = $this->normalizeGallery($merged['gallery'] ?? []);
        if (count($gallery) === 0) {
            $files = Storage::disk('public')->files('about/gallery');

            if (!empty($files)) {
                usort($files, function ($a, $b) {
                    return Storage::disk('public')->lastModified($b) <=> Storage::disk('public')->lastModified($a);
                });

                $gallery = array_map(function ($file) {
                    return [
                        'url' => Storage::url($file),
                        'label' => null,
                    ];
                }, array_slice($files, 0, 5));
            }
        }

        $merged['gallery'] = $gallery;

        $this->writeAboutData($merged);

        return redirect()->route('admin.about.edit')->with('success', 'Konten About disimpan.');
    }

    /**
     * Upload image used by WYSIWYG editor (Trix) and return URL
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:5120',
        ]);

        $file = $request->file('file');
        $path = Storage::disk('public')->putFile('about', $file);
        $url = Storage::url($path);

        return response()->json(['url' => $url], 201);
    }

    /**
     * Upload multiple gallery images and persist into about.json
     */
    public function uploadGallery(Request $request)
    {
        $request->validate([
            'images' => 'required',
            'images.*' => 'image|max:5120',
            'labels' => 'nullable|array',
            'labels.*' => 'nullable|string|max:120',
        ]);

        $uploaded = [];
        $labels = $request->input('labels', []);

        foreach ($request->file('images') as $index => $file) {
            $path = Storage::disk('public')->putFile('about/gallery', $file);
            $label = isset($labels[$index]) && is_string($labels[$index]) ? trim($labels[$index]) : '';

            $uploaded[] = [
                'url' => Storage::url($path),
                'label' => $label !== '' ? $label : null,
            ];
        }

        $about = $this->readAboutData();

        $existing = $this->normalizeGallery($about['gallery'] ?? []);
        $merged = array_merge($existing, $uploaded);
        $about['gallery'] = $this->normalizeGallery($merged);

        $this->writeAboutData($about);

        return response()->json([
            'urls' => array_values(array_map(fn ($item) => $item['url'], $uploaded)),
            'items' => $uploaded,
        ], 201);
    }

    /**
     * Remove a gallery image (delete file and remove from about.json)
     */
    public function removeGallery(Request $request)
    {
        $request->validate(['url' => 'required|string']);
        $url = $request->input('url');

        $about = $this->readAboutData();

        $gallery = $this->normalizeGallery($about['gallery'] ?? []);
        $about['gallery'] = array_values(array_filter($gallery, function ($g) use ($url) {
            return ($g['url'] ?? null) !== $url;
        }));

        $this->deletePublicStorageFileByUrl($url);

        $this->writeAboutData($about);

        return response()->json(['ok' => true]);
    }

    /**
     * Update one gallery item label and optionally replace its image.
     */
    public function updateGalleryItem(Request $request)
    {
        $data = $request->validate([
            'old_url' => 'required|string',
            'label' => 'nullable|string|max:120',
            'image' => 'nullable|image|max:5120',
        ]);

        $about = $this->readAboutData();

        $gallery = $this->normalizeGallery($about['gallery'] ?? []);
        $targetIndex = null;
        foreach ($gallery as $index => $item) {
            if (($item['url'] ?? null) === $data['old_url']) {
                $targetIndex = $index;
                break;
            }
        }

        if ($targetIndex === null) {
            return response()->json(['message' => 'Foto tidak ditemukan di galeri.'], 404);
        }

        $newUrl = $gallery[$targetIndex]['url'];
        if ($request->hasFile('image')) {
            $path = Storage::disk('public')->putFile('about/gallery', $request->file('image'));
            $newUrl = Storage::url($path);
            $this->deletePublicStorageFileByUrl((string) $gallery[$targetIndex]['url']);
        }

        $label = isset($data['label']) ? trim((string) $data['label']) : '';
        $gallery[$targetIndex] = [
            'url' => $newUrl,
            'label' => $label !== '' ? $label : null,
        ];

        $about['gallery'] = $this->normalizeGallery($gallery);
        $this->writeAboutData($about);

        return response()->json([
            'ok' => true,
            'item' => $gallery[$targetIndex],
        ]);
    }

    /**
     * Upload school logo and store to settings
     */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg,webp|max:4096',
        ]);

        $oldLogo = Setting::get('logo_sekolah');
        if ($oldLogo && !str_starts_with((string) $oldLogo, 'http://') && !str_starts_with((string) $oldLogo, 'https://')) {
            Storage::disk('public')->delete($oldLogo);
        }

        $path = Storage::disk('public')->putFile('settings/logo', $request->file('logo'));
        Setting::set('logo_sekolah', $path);

        return response()->json([
            'ok' => true,
            'path' => $path,
            'url' => Storage::url($path),
        ], 201);
    }

    /**
     * Remove school logo from settings and storage
     */
    public function removeLogo()
    {
        $oldLogo = Setting::get('logo_sekolah');
        if ($oldLogo && !str_starts_with((string) $oldLogo, 'http://') && !str_starts_with((string) $oldLogo, 'https://')) {
            Storage::disk('public')->delete($oldLogo);
        }

        Setting::set('logo_sekolah', null);

        return response()->json(['ok' => true]);
    }

    /**
     * Upload dedicated hero image used on About hero card.
     */
    public function uploadHeroImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:6144',
        ]);

        $about = $this->readAboutData();
        $oldHeroImage = isset($about['hero_overlay_image']) && is_string($about['hero_overlay_image'])
            ? $about['hero_overlay_image']
            : null;

        if (!empty($oldHeroImage)) {
            $this->deletePublicStorageFileByUrl($oldHeroImage);
        }

        $path = Storage::disk('public')->putFile('about/hero', $request->file('image'));
        $url = Storage::url($path);

        $about['hero_overlay_image'] = $url;
        $this->writeAboutData($about);

        return response()->json([
            'ok' => true,
            'url' => $url,
        ], 201);
    }

    /**
     * Remove dedicated hero image from About page.
     */
    public function removeHeroImage()
    {
        $about = $this->readAboutData();
        $oldHeroImage = isset($about['hero_overlay_image']) && is_string($about['hero_overlay_image'])
            ? $about['hero_overlay_image']
            : null;

        if (!empty($oldHeroImage)) {
            $this->deletePublicStorageFileByUrl($oldHeroImage);
        }

        $about['hero_overlay_image'] = null;
        $this->writeAboutData($about);

        return response()->json(['ok' => true]);
    }
}
