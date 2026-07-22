@extends('layouts.premium')

@section('title','Edit About — Admin')

@section('content')
<div class="max-w-6xl mx-auto p-6 space-y-6">
    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-50 border border-green-200 text-green-800">{{ session('success') }}</div>
    @endif

    <div class="panel panel-header">
        <div>
            <h1 class="panel-title">Kelola About Landing</h1>
            <p class="panel-subtitle">Atur konten, logo, foto sekolah, dan kegiatan dari satu halaman agar edit lebih cepat.</p>
        </div>
        <div class="quick-links">
            <a href="#logo-section" class="quick-link">Logo</a>
            <a href="#hero-image-section" class="quick-link">Foto Hero</a>
            <a href="#content-section" class="quick-link">Konten</a>
            <a href="#gallery-section" class="quick-link">Foto & Kegiatan</a>
            <a href="#seo-section" class="quick-link">SEO</a>
        </div>
    </div>

    <form id="about-form" method="POST" action="{{ route('admin.about.update') }}" class="space-y-6">
        @csrf

        <div class="sticky-actions">
            <div class="sticky-note">Perubahan teks disimpan lewat tombol ini.</div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan Konten About</button>
        </div>

        <section id="logo-section" class="panel">
            <h2 class="section-title">Logo Sekolah</h2>
            <p class="section-subtitle">Logo tampil di navbar halaman About.</p>
            <div class="flex items-center gap-4 flex-wrap mt-3">
                <div class="w-20 h-20 rounded-lg border bg-slate-50 overflow-hidden flex items-center justify-center" id="logo-preview-wrap">
                    @if(!empty($logoSekolah))
                        @php
                            $isAbsLogo = str_starts_with($logoSekolah, 'http://') || str_starts_with($logoSekolah, 'https://');
                            $logoPreviewUrl = $isAbsLogo ? $logoSekolah : asset('storage/' . ltrim($logoSekolah, '/'));
                        @endphp
                        <img id="logo-preview" src="{{ $logoPreviewUrl }}" alt="Logo Sekolah" class="w-full h-full object-contain">
                    @else
                        <span id="logo-placeholder" class="text-xs text-slate-500">Belum ada</span>
                        <img id="logo-preview" src="" alt="Logo Sekolah" class="w-full h-full object-contain hidden">
                    @endif
                </div>

                <div class="flex items-center gap-2">
                    <input id="logo-file" type="file" accept="image/png,image/jpg,image/jpeg,image/webp" class="border p-2 rounded">
                    <button id="logo-upload-btn" type="button" class="px-3 py-2 bg-blue-600 text-white rounded">Upload Logo</button>
                    <button id="logo-remove-btn" type="button" class="px-3 py-2 bg-red-600 text-white rounded">Hapus Logo</button>
                </div>
            </div>
            <p class="text-sm text-slate-500 mt-2">Disarankan PNG transparan minimal 512x512 agar tampilan lebih jernih.</p>
        </section>

        <section id="hero-image-section" class="panel">
            <h2 class="section-title">Foto Hero Utama</h2>
            <p class="section-subtitle">Foto khusus untuk kartu hero besar di halaman About (bagian yang kamu tandai).</p>
            @php
                $heroOverlayImage = $content['hero_overlay_image'] ?? null;
                $heroOverlayImageUrl = null;
                if (!empty($heroOverlayImage) && is_string($heroOverlayImage)) {
                    $isAbsHero = str_starts_with($heroOverlayImage, 'http://') || str_starts_with($heroOverlayImage, 'https://');
                    $heroOverlayImageUrl = $isAbsHero || str_starts_with($heroOverlayImage, '/storage/')
                        ? $heroOverlayImage
                        : asset('storage/' . ltrim($heroOverlayImage, '/'));
                }
            @endphp
            <div class="flex items-center gap-4 flex-wrap mt-3">
                <div class="w-48 h-28 rounded-lg border bg-slate-50 overflow-hidden flex items-center justify-center" id="hero-image-preview-wrap">
                    @if(!empty($heroOverlayImageUrl))
                        <img id="hero-image-preview" src="{{ $heroOverlayImageUrl }}" alt="Hero About" class="w-full h-full object-cover">
                        <span id="hero-image-placeholder" class="text-xs text-slate-500 hidden">Belum ada</span>
                    @else
                        <img id="hero-image-preview" src="" alt="Hero About" class="w-full h-full object-cover hidden">
                        <span id="hero-image-placeholder" class="text-xs text-slate-500">Belum ada</span>
                    @endif
                </div>

                <div class="flex items-center gap-2">
                    <input id="hero-image-file" type="file" accept="image/png,image/jpg,image/jpeg,image/webp" class="border p-2 rounded">
                    <button id="hero-image-upload-btn" type="button" class="px-3 py-2 bg-blue-600 text-white rounded">Upload Foto Hero</button>
                    <button id="hero-image-remove-btn" type="button" class="px-3 py-2 bg-red-600 text-white rounded">Hapus Foto Hero</button>
                </div>
            </div>
            <p class="text-sm text-slate-500 mt-2">Disarankan foto landscape (rasio 16:9) agar tampil rapi di kartu hero.</p>
        </section>

        <section id="content-section" class="panel">
            <h2 class="section-title">Konten Utama</h2>
            <p class="section-subtitle">Isi teks utama halaman About. Bisa pakai format rich text.</p>

            <div class="editor-item" style="margin-top: 14px;">
                <label class="editor-label">Teks Overlay Hero (Bagian Foto Utama)</label>
                <div class="editor-grid" style="grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label class="text-sm text-slate-600" for="hero_overlay_left_title">Kiri - Judul</label>
                        <input id="hero_overlay_left_title" name="hero_overlay_left_title" type="text" class="w-full border rounded px-3 py-2 mt-1" value="{{ old('hero_overlay_left_title', $content['hero_overlay_left_title'] ?? '') }}" placeholder="Contoh: Lingkungan belajar yang rapi">
                    </div>
                    <div>
                        <label class="text-sm text-slate-600" for="hero_overlay_left_subtitle">Kiri - Subjudul</label>
                        <input id="hero_overlay_left_subtitle" name="hero_overlay_left_subtitle" type="text" class="w-full border rounded px-3 py-2 mt-1" value="{{ old('hero_overlay_left_subtitle', $content['hero_overlay_left_subtitle'] ?? '') }}" placeholder="Contoh: Visual utama sekolah dan nuansa modern.">
                    </div>
                    <div>
                        <label class="text-sm text-slate-600" for="hero_overlay_right_title">Kanan - Judul</label>
                        <input id="hero_overlay_right_title" name="hero_overlay_right_title" type="text" class="w-full border rounded px-3 py-2 mt-1" value="{{ old('hero_overlay_right_title', $content['hero_overlay_right_title'] ?? '') }}" placeholder="Contoh: TKR + TKJ">
                    </div>
                    <div>
                        <label class="text-sm text-slate-600" for="hero_overlay_right_subtitle">Kanan - Subjudul</label>
                        <input id="hero_overlay_right_subtitle" name="hero_overlay_right_subtitle" type="text" class="w-full border rounded px-3 py-2 mt-1" value="{{ old('hero_overlay_right_subtitle', $content['hero_overlay_right_subtitle'] ?? '') }}" placeholder="Contoh: Fokus jurusan utama.">
                    </div>
                </div>
            </div>

            <div class="editor-grid mt-4">
                <div class="editor-item">
                    <label class="editor-label" for="vision">Vision</label>
                    <input id="vision" type="hidden" name="vision" value="{{ old('vision', $content['vision'] ?? '') }}">
                    <trix-editor input="vision" class="trix-content"></trix-editor>
                </div>

                <div class="editor-item">
                    <label class="editor-label" for="mission">Mission</label>
                    <input id="mission" type="hidden" name="mission" value="{{ old('mission', $content['mission'] ?? '') }}">
                    <trix-editor input="mission" class="trix-content"></trix-editor>
                </div>

                <div class="editor-item">
                    <label class="editor-label" for="programs">Programs & Curriculum</label>
                    <input id="programs" type="hidden" name="programs" value="{{ old('programs', $content['programs'] ?? '') }}">
                    <trix-editor input="programs" class="trix-content"></trix-editor>
                </div>

                <div class="editor-item">
                    <label class="editor-label" for="history">History / Timeline</label>
                    <input id="history" type="hidden" name="history" value="{{ old('history', $content['history'] ?? '') }}">
                    <trix-editor input="history" class="trix-content"></trix-editor>
                </div>

                <div class="editor-item">
                    <label class="editor-label" for="facilities">Facilities</label>
                    <input id="facilities" type="hidden" name="facilities" value="{{ old('facilities', $content['facilities'] ?? '') }}">
                    <trix-editor input="facilities" class="trix-content"></trix-editor>
                </div>

                <div class="editor-item">
                    <label class="editor-label" for="student_life">Student Life / Activities</label>
                    <input id="student_life" type="hidden" name="student_life" value="{{ old('student_life', $content['student_life'] ?? '') }}">
                    <trix-editor input="student_life" class="trix-content"></trix-editor>
                </div>
            </div>
        </section>

        <section id="gallery-section" class="panel">
            <h2 class="section-title">Foto dan Kegiatan</h2>
            <p class="section-subtitle">Upload banyak foto sekaligus, lalu edit nama kegiatan atau ganti foto per baris.</p>

            <div id="gallery-preview" class="grid grid-cols-3 gap-3 mb-2">
                @if(!empty($content['gallery']) && is_array($content['gallery']))
                    @foreach($content['gallery'] as $g)
                        @php
                            $galleryUrl = is_array($g) ? ($g['url'] ?? null) : $g;
                            $galleryLabel = is_array($g) ? ($g['label'] ?? null) : null;
                        @endphp
                        @if(!empty($galleryUrl))
                        <div class="relative" data-gallery-item data-url="{{ $galleryUrl }}">
                            <img src="{{ $galleryUrl }}" class="w-full h-24 object-cover rounded" />
                            @if(!empty($galleryLabel))
                                <span class="gallery-chip">{{ $galleryLabel }}</span>
                            @endif
                            <button type="button" class="remove-gallery absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs" data-url="{{ $galleryUrl }}">×</button>
                        </div>
                        @endif
                    @endforeach
                @endif
            </div>
            <div id="gallery-meta-list" class="mt-3 grid gap-2"></div>
            <p class="text-sm text-slate-500 mt-2">Upload foto gedung, kelas, lab TKJ, bengkel TKR, dan kegiatan siswa. Maks 5MB/gambar.</p>

            <div class="mt-4 p-4 rounded-lg border border-blue-100 bg-blue-50 flex items-center justify-between gap-3 flex-wrap">
                <div>
                    <div class="font-semibold text-slate-800">Upload foto baru</div>
                    <div class="text-sm text-slate-600">Pilih file lalu klik upload. Label bisa diisi dari field yang muncul setelah pilih file.</div>
                </div>
                <div class="flex items-center gap-3 flex-wrap">
                    <input id="gallery-files" type="file" multiple accept="image/*" class="border p-2 rounded bg-white" />
                    <button id="gallery-upload-btn" type="button" class="px-4 py-2 bg-blue-600 text-white rounded font-semibold shadow-sm">Upload Foto</button>
                </div>
            </div>

            <div class="gallery-table-wrap">
                <table class="gallery-table">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Kegiatan</th>
                            <th>Ganti Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="gallery-table-body">
                        @php $galleryList = $content['gallery'] ?? []; @endphp
                        @forelse($galleryList as $g)
                            @php
                                $galleryUrl = is_array($g) ? ($g['url'] ?? null) : $g;
                                $galleryLabel = is_array($g) ? ($g['label'] ?? null) : null;
                            @endphp
                            @if(!empty($galleryUrl))
                                <tr data-gallery-item data-url="{{ $galleryUrl }}">
                                    <td><img src="{{ $galleryUrl }}" alt="Foto sekolah" class="table-thumb"></td>
                                    <td>
                                        <input type="hidden" class="row-url" name="gallery_urls[]" value="{{ $galleryUrl }}">
                                        <input type="text" class="row-label" name="gallery_labels[]" value="{{ $galleryLabel ?? '' }}" placeholder="Contoh: Kegiatan Siswa">
                                    </td>
                                    <td>
                                        <input type="file" class="row-file hidden" accept="image/*">
                                        <div class="row-file-meta">
                                            <span class="row-file-name">Belum pilih foto</span>
                                            <div class="row-file-actions">
                                                <button type="button" class="pick-gallery-file px-3 py-2 bg-slate-100 text-slate-700 rounded text-sm">Pilih Foto</button>
                                                <button type="button" class="upload-gallery-row px-4 py-2 bg-blue-600 text-white rounded text-sm font-semibold shadow-sm">Upload / Ganti Foto</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="actions">
                                        <button type="button" class="remove-gallery px-3 py-2 bg-red-600 text-white rounded text-sm" data-url="{{ $galleryUrl }}">Hapus</button>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr id="gallery-table-empty">
                                <td colspan="4" class="text-slate-500 text-sm py-3">Belum ada foto sekolah. Upload foto dulu di atas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <p class="text-sm text-slate-500 mt-2">Anda bisa ubah nama kegiatan dan ganti foto per baris agar sesuai tabel foto dan kegiatan.</p>
        </section>

        <section id="seo-section" class="panel">
            <h2 class="section-title">SEO / Catatan Tambahan</h2>
            <p class="section-subtitle">Opsional. Biarkan kosong jika tidak digunakan.</p>
            <textarea name="seo" rows="3" class="w-full border rounded px-3 py-2 mt-3">{{ old('seo', $content['seo'] ?? '') }}</textarea>
        </section>

        <div class="flex justify-end">
            <button class="px-4 py-2 bg-blue-600 text-white rounded">Simpan Konten About</button>
        </div>
    </form>
</div>

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/trix/dist/trix.css">
    <style>
        .panel { background:#fff; border:1px solid rgba(2,6,23,0.08); border-radius:14px; padding:18px; }
        .panel-header { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; flex-wrap:wrap; }
        .panel-title { font-size:22px; font-weight:800; color:#0f172a; margin:0; }
        .panel-subtitle { font-size:13px; color:#64748b; margin:4px 0 0; }
        .section-title { font-size:16px; font-weight:700; color:#0f172a; margin:0; }
        .section-subtitle { font-size:13px; color:#64748b; margin:4px 0 0; }
        .quick-links { display:flex; gap:8px; flex-wrap:wrap; }
        .quick-link { font-size:12px; color:#1d4ed8; background:#eff6ff; border:1px solid #dbeafe; padding:6px 10px; border-radius:999px; text-decoration:none; }
        .quick-link:hover { background:#dbeafe; }
        .sticky-actions { position:sticky; top:12px; z-index:30; display:flex; align-items:center; justify-content:space-between; gap:12px; background:#f8fafc; border:1px solid rgba(2,6,23,0.08); border-radius:12px; padding:10px 12px; }
        .sticky-note { font-size:12px; color:#475569; }
        .editor-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .editor-item { background:#f8fafc; border:1px solid rgba(2,6,23,0.08); border-radius:12px; padding:10px; }
        .editor-label { display:block; font-size:13px; font-weight:700; color:#0f172a; margin-bottom:8px; }
        .trix-content { min-height:160px; border-radius:8px; background:#fff; border:1px solid rgba(2,6,23,0.06); padding:8px; }
        #gallery-preview { display:grid; grid-template-columns:repeat(3,1fr); gap:0.5rem; }
        #gallery-preview .relative { position:relative; }
        .remove-gallery { position:absolute; top:6px; right:6px; width:26px; height:26px; border-radius:999px; display:flex; align-items:center; justify-content:center; font-weight:600; }
        .gallery-chip { position:absolute; left:6px; bottom:6px; background:rgba(15,23,42,.72); color:#fff; font-size:11px; padding:3px 8px; border-radius:999px; }
        #gallery-meta-list .meta-item { display:grid; grid-template-columns: 1fr 1fr; gap:8px; align-items:center; }
        #gallery-meta-list .meta-name { font-size:12px; color:#334155; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        #gallery-meta-list .meta-input { border:1px solid rgba(2,6,23,0.12); padding:8px 10px; border-radius:8px; font-size:13px; }
        #gallery-files { border:1px dashed rgba(2,6,23,0.08); padding:8px; border-radius:6px; background:#fafafa; }
        .gallery-table-wrap { overflow-x:auto; }
        .gallery-table { width:100%; border-collapse:collapse; min-width:760px; }
        .gallery-table th, .gallery-table td { border-bottom:1px solid rgba(2,6,23,0.08); padding:10px; text-align:left; vertical-align:middle; }
        .gallery-table th { font-size:12px; color:#475569; text-transform:uppercase; letter-spacing:.03em; }
        .gallery-table .table-thumb { width:84px; height:56px; border-radius:8px; object-fit:cover; border:1px solid rgba(2,6,23,0.08); }
        .gallery-table .row-label, .gallery-table .row-file { width:100%; border:1px solid rgba(2,6,23,0.12); padding:8px 10px; border-radius:8px; font-size:13px; }
        .gallery-table .row-file-meta { display:flex; flex-direction:column; gap:8px; }
        .gallery-table .row-file-name { font-size:12px; color:#64748b; }
        .gallery-table .row-file-actions { display:flex; gap:8px; flex-wrap:wrap; }
        .gallery-table .actions { white-space:nowrap; }
        .gallery-table .actions .remove-gallery { margin-right:6px; }
        .gallery-table .upload-gallery-row { white-space:nowrap; }
        @media (max-width: 900px) {
            .editor-grid { grid-template-columns:1fr; }
            #gallery-preview { grid-template-columns:repeat(2,1fr); }
            .sticky-actions { position:static; }
        }
        @media (max-width: 640px) {
            #gallery-preview { grid-template-columns:1fr; }
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/trix/dist/trix.js"></script>
    <script>
        document.addEventListener('trix-attachment-add', function(event) {
            var attachment = event.attachment;
            if (attachment.file) {
                uploadAttachment(attachment);
            }
        });

        // Dedicated hero image upload handler
        document.getElementById('hero-image-upload-btn')?.addEventListener('click', function(){
            var input = document.getElementById('hero-image-file');
            if (!input || !input.files || input.files.length === 0) return alert('Pilih foto hero terlebih dahulu.');

            var form = new FormData();
            form.append('image', input.files[0]);

            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('admin.about.upload_hero_image') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                body: form,
                credentials: 'same-origin'
            }).then(r => r.json()).then(function(data){
                var img = document.getElementById('hero-image-preview');
                var ph = document.getElementById('hero-image-placeholder');
                if (img && data.url) {
                    img.src = data.url;
                    img.classList.remove('hidden');
                }
                if (ph) ph.classList.add('hidden');
                input.value = '';
                alert('Foto hero berhasil diupload.');
            }).catch(function(err){
                console.error(err);
                alert('Upload foto hero gagal.');
            });
        });

        // Dedicated hero image remove handler
        document.getElementById('hero-image-remove-btn')?.addEventListener('click', function(){
            if (!confirm('Hapus foto hero utama dari halaman About?')) return;

            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch("{{ route('admin.about.remove_hero_image') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                credentials: 'same-origin'
            }).then(r => r.json()).then(function(){
                var img = document.getElementById('hero-image-preview');
                var ph = document.getElementById('hero-image-placeholder');
                if (img) {
                    img.src = '';
                    img.classList.add('hidden');
                }
                if (ph) {
                    ph.classList.remove('hidden');
                    ph.textContent = 'Belum ada';
                }
                var input = document.getElementById('hero-image-file');
                if (input) input.value = '';
                alert('Foto hero berhasil dihapus.');
            }).catch(function(err){
                console.error(err);
                alert('Gagal menghapus foto hero.');
            });
        });

        // Logo upload handler
        document.getElementById('logo-upload-btn')?.addEventListener('click', function(){
            var input = document.getElementById('logo-file');
            if (!input || !input.files || input.files.length === 0) return alert('Pilih logo terlebih dahulu.');

            var form = new FormData();
            form.append('logo', input.files[0]);

            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('admin.about.upload_logo') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                body: form,
                credentials: 'same-origin'
            }).then(r => r.json()).then(function(data){
                var img = document.getElementById('logo-preview');
                var ph = document.getElementById('logo-placeholder');
                if (img && data.url) {
                    img.src = data.url;
                    img.classList.remove('hidden');
                }
                if (ph) ph.classList.add('hidden');
                input.value = '';
                alert('Logo berhasil diupload dan dipasang.');
            }).catch(function(err){
                console.error(err);
                alert('Upload logo gagal.');
            });
        });

        // Logo remove handler
        document.getElementById('logo-remove-btn')?.addEventListener('click', function(){
            if (!confirm('Hapus logo sekolah dari halaman About?')) return;

            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch("{{ route('admin.about.remove_logo') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                credentials: 'same-origin'
            }).then(r => r.json()).then(function(){
                var img = document.getElementById('logo-preview');
                var ph = document.getElementById('logo-placeholder');
                if (img) {
                    img.src = '';
                    img.classList.add('hidden');
                }
                if (ph) {
                    ph.classList.remove('hidden');
                    ph.textContent = 'Belum ada';
                }
                alert('Logo berhasil dihapus.');
            }).catch(function(err){
                console.error(err);
                alert('Gagal menghapus logo.');
            });
        });

        function uploadAttachment(attachment) {
            var file = attachment.file;
            var form = new FormData();
            form.append('file', file);

            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('admin.about.upload_image') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                body: form,
                credentials: 'same-origin'
            }).then(function(response) {
                return response.json();
            }).then(function(data) {
                attachment.setAttributes({ url: data.url, href: data.url });
            }).catch(function(err) {
                console.error('Upload failed', err);
            });
        }

        // Gallery upload handler
        var galleryInput = document.getElementById('gallery-files');
        var galleryMetaList = document.getElementById('gallery-meta-list');
        var galleryPreview = document.getElementById('gallery-preview');
        var galleryTableBody = document.getElementById('gallery-table-body');

        function hideGalleryEmptyRow() {
            var empty = document.getElementById('gallery-table-empty');
            if (empty) empty.remove();
        }

        function buildPreviewItem(item) {
            var wrapper = document.createElement('div');
            wrapper.className = 'relative';
            wrapper.setAttribute('data-gallery-item', 'true');
            wrapper.setAttribute('data-url', item.url);

            var img = document.createElement('img');
            img.src = item.url;
            img.className = 'w-full h-24 object-cover rounded';
            wrapper.appendChild(img);

            if (item.label) {
                var chip = document.createElement('span');
                chip.className = 'gallery-chip';
                chip.textContent = item.label;
                wrapper.appendChild(chip);
            }

            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'remove-gallery absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs';
            btn.dataset.url = item.url;
            btn.innerText = '×';
            wrapper.appendChild(btn);

            return wrapper;
        }

        function buildTableRow(item) {
            var tr = document.createElement('tr');
            tr.setAttribute('data-gallery-item', 'true');
            tr.setAttribute('data-url', item.url);

            var tdImg = document.createElement('td');
            var img = document.createElement('img');
            img.src = item.url;
            img.alt = 'Foto sekolah';
            img.className = 'table-thumb';
            tdImg.appendChild(img);

            var tdLabel = document.createElement('td');
            var rowUrl = document.createElement('input');
            rowUrl.type = 'hidden';
            rowUrl.className = 'row-url';
            rowUrl.name = 'gallery_urls[]';
            rowUrl.value = item.url;

            var labelInput = document.createElement('input');
            labelInput.type = 'text';
            labelInput.className = 'row-label';
            labelInput.name = 'gallery_labels[]';
            labelInput.placeholder = 'Contoh: Kegiatan Siswa';
            labelInput.value = item.label || '';
            tdLabel.appendChild(rowUrl);
            tdLabel.appendChild(labelInput);

            var tdFile = document.createElement('td');
            var fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.className = 'row-file';
            fileInput.style.display = 'none';
            fileInput.accept = 'image/*';

            var fileMeta = document.createElement('div');
            fileMeta.className = 'row-file-meta';

            var fileName = document.createElement('span');
            fileName.className = 'row-file-name';
            fileName.textContent = 'Belum pilih foto';

            var fileActions = document.createElement('div');
            fileActions.className = 'row-file-actions';

            var pickBtn = document.createElement('button');
            pickBtn.type = 'button';
            pickBtn.className = 'pick-gallery-file px-3 py-2 bg-slate-100 text-slate-700 rounded text-sm';
            pickBtn.textContent = 'Pilih Foto';

            var uploadBtn = document.createElement('button');
            uploadBtn.type = 'button';
            uploadBtn.className = 'upload-gallery-row px-3 py-2 bg-blue-600 text-white rounded text-sm';
            uploadBtn.textContent = 'Upload Foto';

            fileActions.appendChild(pickBtn);
            fileActions.appendChild(uploadBtn);
            fileMeta.appendChild(fileName);
            fileMeta.appendChild(fileActions);

            tdFile.appendChild(fileInput);
            tdFile.appendChild(fileMeta);

            var tdActions = document.createElement('td');
            tdActions.className = 'actions';
            var removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'remove-gallery px-3 py-2 bg-red-600 text-white rounded text-sm';
            removeBtn.dataset.url = item.url;
            removeBtn.textContent = 'Hapus';
            tdActions.appendChild(removeBtn);

            tr.appendChild(tdImg);
            tr.appendChild(tdLabel);
            tr.appendChild(tdFile);
            tr.appendChild(tdActions);

            return tr;
        }

        function getGalleryNodesByUrl(url) {
            var previewNode = null;
            var tableNode = null;

            Array.from((galleryPreview || document).querySelectorAll('[data-gallery-item]')).forEach(function(node){
                if (node.getAttribute('data-url') === url) previewNode = node;
            });
            Array.from((galleryTableBody || document).querySelectorAll('[data-gallery-item]')).forEach(function(node){
                if (node.getAttribute('data-url') === url) tableNode = node;
            });

            return { previewNode: previewNode, tableNode: tableNode };
        }

        function updateGalleryNodes(oldUrl, item) {
            var nodes = getGalleryNodesByUrl(oldUrl);

            if (nodes.previewNode) {
                nodes.previewNode.setAttribute('data-url', item.url);
                var pImg = nodes.previewNode.querySelector('img');
                if (pImg) pImg.src = item.url;

                var pRemove = nodes.previewNode.querySelector('.remove-gallery');
                if (pRemove) pRemove.dataset.url = item.url;

                var oldChip = nodes.previewNode.querySelector('.gallery-chip');
                if (oldChip) oldChip.remove();
                if (item.label) {
                    var chip = document.createElement('span');
                    chip.className = 'gallery-chip';
                    chip.textContent = item.label;
                    nodes.previewNode.appendChild(chip);
                }
            }

            if (nodes.tableNode) {
                nodes.tableNode.setAttribute('data-url', item.url);
                var tImg = nodes.tableNode.querySelector('img.table-thumb');
                if (tImg) tImg.src = item.url;
                var tUrl = nodes.tableNode.querySelector('.row-url');
                if (tUrl) tUrl.value = item.url;
                var tLabel = nodes.tableNode.querySelector('.row-label');
                if (tLabel) tLabel.value = item.label || '';
                var tFile = nodes.tableNode.querySelector('.row-file');
                if (tFile) tFile.value = '';
                var tFileName = nodes.tableNode.querySelector('.row-file-name');
                if (tFileName) tFileName.textContent = 'Belum pilih foto';
                var tRemove = nodes.tableNode.querySelector('.remove-gallery');
                if (tRemove) tRemove.dataset.url = item.url;
            }
        }

        function removeGalleryNodes(url) {
            var nodes = getGalleryNodesByUrl(url);
            if (nodes.previewNode) nodes.previewNode.remove();
            if (nodes.tableNode) nodes.tableNode.remove();

            var hasRow = (galleryTableBody || document).querySelector('[data-gallery-item]');
            if (!hasRow && galleryTableBody) {
                var empty = document.createElement('tr');
                empty.id = 'gallery-table-empty';
                empty.innerHTML = '<td colspan="4" class="text-slate-500 text-sm py-3">Belum ada foto sekolah. Upload foto dulu di atas.</td>';
                galleryTableBody.appendChild(empty);
            }
        }

        function buildDefaultLabel(fileName) {
            var base = (fileName || '').replace(/\.[^/.]+$/, '').replace(/[\-_]+/g, ' ').trim();
            if (!base) return 'Foto Sekolah';
            return base.replace(/\b\w/g, function(c){ return c.toUpperCase(); });
        }

        galleryInput?.addEventListener('change', function(){
            if (!galleryMetaList) return;
            galleryMetaList.innerHTML = '';
            Array.from(this.files || []).forEach(function(file, index){
                var row = document.createElement('div');
                row.className = 'meta-item';

                var name = document.createElement('div');
                name.className = 'meta-name';
                name.textContent = file.name;

                var input = document.createElement('input');
                input.type = 'text';
                input.className = 'meta-input';
                input.placeholder = 'Label foto (contoh: Bengkel TKR)';
                input.value = buildDefaultLabel(file.name);
                input.setAttribute('data-index', String(index));

                row.appendChild(name);
                row.appendChild(input);
                galleryMetaList.appendChild(row);
            });
        });

        document.getElementById('gallery-upload-btn')?.addEventListener('click', function(){
            var input = document.getElementById('gallery-files');
            if (!input || !input.files || input.files.length === 0) return alert('Pilih gambar terlebih dahulu.');
            var form = new FormData();
            Array.from(input.files).forEach((f) => form.append('images[]', f));

            var labels = Array.from((galleryMetaList || document).querySelectorAll('.meta-input')).map(function(el){
                return (el.value || '').trim();
            });
            labels.forEach(function(label){
                form.append('labels[]', label);
            });

            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('admin.about.upload_gallery') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                body: form,
                credentials: 'same-origin'
            }).then(r => r.json()).then(function(data){
                // append previews
                var preview = document.getElementById('gallery-preview');
                var uploadedItems = (data.items || []).map(function(item){
                    if (typeof item === 'string') {
                        return { url: item, label: null };
                    }
                    return { url: item.url, label: item.label || null };
                });

                uploadedItems.forEach(function(item){
                    if (!item.url) return;
                    hideGalleryEmptyRow();
                    preview.appendChild(buildPreviewItem(item));
                    if (galleryTableBody) {
                        galleryTableBody.appendChild(buildTableRow(item));
                    }
                });
                input.value = '';
                if (galleryMetaList) galleryMetaList.innerHTML = '';
                alert('Foto sekolah berhasil ditambahkan ke galeri About.');
            }).catch(function(err){ console.error(err); alert('Upload galeri gagal'); });
        });

        // Save one gallery row (update kegiatan and/or replace image)
        document.addEventListener('click', function(e){
            if (!e.target.matches) return;

            if (e.target.matches('.pick-gallery-file')) {
                var pickRow = e.target.closest('tr[data-gallery-item]');
                if (!pickRow) return;
                var pickInput = pickRow.querySelector('.row-file');
                if (pickInput) pickInput.click();
                return;
            }

            if (!e.target.matches('.upload-gallery-row')) return;

            var row = e.target.closest('tr[data-gallery-item]');
            if (!row) return;

            var oldUrl = row.getAttribute('data-url');
            var labelInput = row.querySelector('.row-label');
            var fileInput = row.querySelector('.row-file');

            if (!oldUrl) return alert('Data foto tidak valid.');

            var form = new FormData();
            form.append('old_url', oldUrl);
            form.append('label', (labelInput && labelInput.value ? labelInput.value : '').trim());
            if (fileInput && fileInput.files && fileInput.files[0]) {
                form.append('image', fileInput.files[0]);
            }

            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('admin.about.update_gallery_item') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                body: form,
                credentials: 'same-origin'
            }).then(function(r){ return r.json(); }).then(function(data){
                if (!data || !data.item || !data.item.url) {
                    throw new Error('Respon server tidak valid');
                }
                updateGalleryNodes(oldUrl, { url: data.item.url, label: data.item.label || null });
                alert('Foto dan kegiatan berhasil diperbarui.');
            }).catch(function(err){
                console.error(err);
                alert('Gagal memperbarui baris foto/kegiatan.');
            });
        });

        document.addEventListener('change', function(e){
            if (!e.target.matches || !e.target.matches('.row-file')) return;
            var row = e.target.closest('tr[data-gallery-item]');
            if (!row) return;
            var fileName = row.querySelector('.row-file-name');
            if (fileName) {
                fileName.textContent = e.target.files && e.target.files[0] ? e.target.files[0].name : 'Belum pilih foto';
            }
        });

        // Delegate remove gallery
        document.addEventListener('click', function(e){
            if (!e.target.matches || !e.target.matches('.remove-gallery')) return;
            var url = e.target.dataset.url;
            if (!confirm('Hapus gambar ini dari galeri?')) return;
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var form = new FormData(); form.append('url', url);
            fetch("{{ route('admin.about.remove_gallery') }}", { method: 'POST', headers: { 'X-CSRF-TOKEN': token }, body: form, credentials: 'same-origin' })
            .then(r => r.json()).then(function(){
                removeGalleryNodes(url);
            }).catch(function(err){ console.error(err); alert('Gagal menghapus gambar'); });
        });
    </script>
    @endpush
@endsection
