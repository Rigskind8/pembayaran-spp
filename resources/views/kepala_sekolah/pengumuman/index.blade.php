@extends('layouts.app')

@section('title', 'Pengumuman Kepala Sekolah')

@php
    $urgentCount = $announcements->getCollection()->where('type', 'urgent')->count();
    $pinnedCount = $announcements->getCollection()->where('is_pinned', true)->count();
@endphp

@push('styles')
<style>
.pg-shell {
    display: flex;
    min-height: 100vh;
}

.pg-main {
    margin-left: var(--sb);
    width: 100%;
    padding: 22px;
}

@media (max-width: 900px) {
    .pg-main {
        margin-left: 0;
        padding: 14px;
    }
}

.pg-head {
    border: 1px solid rgba(148, 163, 184, 0.24);
    border-radius: 18px;
    background: linear-gradient(135deg, rgba(15, 23, 42, 0.95), rgba(30, 41, 59, 0.95));
    color: #e2e8f0;
    padding: 18px;
    margin-bottom: 14px;
}

.pg-kicker {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #93c5fd;
    margin-bottom: 8px;
}

.pg-title {
    font-size: 24px;
    font-weight: 800;
    line-height: 1.25;
    margin-bottom: 5px;
}

.pg-sub {
    font-size: 13px;
    color: #cbd5e1;
}

.pg-metrics {
    margin-top: 14px;
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 10px;
}

.pg-metric {
    border: 1px solid rgba(148, 163, 184, 0.22);
    border-radius: 12px;
    padding: 10px 12px;
    background: rgba(15, 23, 42, 0.4);
}

.pg-metric-label {
    font-size: 11px;
    color: #94a3b8;
}

.pg-metric-value {
    font-size: 22px;
    font-weight: 800;
    color: #f8fafc;
    line-height: 1;
    margin-top: 4px;
}

@media (max-width: 900px) {
    .pg-metrics {
        grid-template-columns: 1fr;
    }
}

.pg-grid {
    display: grid;
    grid-template-columns: 1.05fr 1.3fr;
    gap: 14px;
}

@media (max-width: 1100px) {
    .pg-grid {
        grid-template-columns: 1fr;
    }
}

.pg-card {
    border: 1px solid rgba(148, 163, 184, 0.24);
    border-radius: 16px;
    background: #ffffff;
    box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
    overflow: hidden;
}

.pg-card-head {
    padding: 14px 16px;
    border-bottom: 1px solid rgba(148, 163, 184, 0.2);
    background: linear-gradient(180deg, #f8fafc, #ffffff);
}

.pg-card-title {
    font-size: 15px;
    font-weight: 800;
    color: #0f172a;
}

.pg-card-sub {
    margin-top: 2px;
    font-size: 12px;
    color: #64748b;
}

.pg-card-body {
    padding: 16px;
}

.pg-row {
    margin-bottom: 12px;
}

.pg-row:last-child {
    margin-bottom: 0;
}

.pg-label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
}

.pg-input,
.pg-select,
.pg-textarea {
    width: 100%;
    border: 1px solid rgba(148, 163, 184, 0.4);
    border-radius: 12px;
    padding: 10px 11px;
    background: #ffffff;
    color: #0f172a;
    outline: none;
}

.pg-input:focus,
.pg-select:focus,
.pg-textarea:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.13);
}

.pg-textarea {
    min-height: 130px;
    resize: vertical;
    line-height: 1.45;
}

.pg-counter {
    margin-top: 5px;
    font-size: 11px;
    color: #64748b;
    text-align: right;
}

.pg-actions {
    display: flex;
    gap: 8px;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    margin-top: 12px;
}

.btn-primary-custom {
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #2563eb, #0ea5e9);
    color: #ffffff;
    font-size: 13px;
    font-weight: 800;
    padding: 10px 14px;
}

.btn-subtle {
    border-radius: 10px;
    border: 1px solid rgba(148, 163, 184, 0.35);
    background: #ffffff;
    color: #0f172a;
    padding: 8px 11px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
}

.pg-toolbar {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 8px;
    margin-bottom: 12px;
}

@media (max-width: 640px) {
    .pg-toolbar {
        grid-template-columns: 1fr;
    }
}

.pg-search {
    border: 1px solid rgba(148, 163, 184, 0.4);
    border-radius: 12px;
    padding: 10px 12px;
    font-size: 13px;
}

.pg-filters {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}

.pg-filter-btn {
    border: 1px solid rgba(148, 163, 184, 0.35);
    background: #ffffff;
    color: #334155;
    border-radius: 999px;
    padding: 6px 10px;
    font-size: 11px;
    font-weight: 700;
    cursor: pointer;
}

.pg-filter-btn.is-on {
    border-color: #0ea5e9;
    background: rgba(14, 165, 233, 0.12);
    color: #0369a1;
}

.pg-list {
    display: grid;
    gap: 10px;
}

.pg-item {
    border: 1px solid rgba(148, 163, 184, 0.24);
    border-radius: 12px;
    padding: 12px;
    background: #f8fafc;
}

.pg-item-title {
    font-size: 14px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.35;
}

.pg-item-meta {
    margin-top: 5px;
    font-size: 12px;
    color: #64748b;
}

.pg-item-body {
    margin-top: 8px;
    font-size: 13px;
    color: #1f2937;
    line-height: 1.52;
    white-space: pre-wrap;
}

.pg-badges {
    display: inline-flex;
    gap: 6px;
    margin-left: 8px;
    vertical-align: middle;
}

.pg-badge {
    display: inline-flex;
    align-items: center;
    border-radius: 999px;
    padding: 2px 8px;
    font-size: 10px;
    font-weight: 800;
}

.pg-badge-info {
    background: #dbeafe;
    color: #1d4ed8;
}

.pg-badge-event {
    background: #dcfce7;
    color: #15803d;
}

.pg-badge-urgent {
    background: #fee2e2;
    color: #b91c1c;
}

.pg-badge-pin {
    background: #fef3c7;
    color: #92400e;
}

.pg-item-actions {
    margin-top: 10px;
}

.pg-empty {
    border: 1px dashed rgba(148, 163, 184, 0.5);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    color: #64748b;
    font-size: 13px;
}

.pg-pagination {
    margin-top: 12px;
}

.pg-note {
    font-size: 12px;
    color: #64748b;
}

.pg-check {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: #334155;
    font-weight: 700;
}

.pg-check input {
    width: 16px;
    height: 16px;
}

.pg-item-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.btn-pin {
    border: 1px solid #f59e0b;
    color: #92400e;
    background: #fffbeb;
    border-radius: 10px;
    padding: 5px 10px;
    font-size: 12px;
    font-weight: 700;
}

.btn-unpin {
    border: 1px solid #94a3b8;
    color: #334155;
    background: #f8fafc;
    border-radius: 10px;
    padding: 5px 10px;
    font-size: 12px;
    font-weight: 700;
}
</style>
@endpush

@section('content')
<div class="pg-shell">
    @include('partials.sidebar')

    <main class="pg-main">
        <section class="pg-head">
            <div class="pg-kicker"><i class="fas fa-bullhorn"></i> Informasi Sekolah</div>
            <div class="pg-title">Pusat Pengumuman</div>
            <div class="pg-sub">Kelola, kirim, dan pantau semua pengumuman resmi untuk guru dan siswa dari satu halaman.</div>

            <div class="pg-metrics">
                <div class="pg-metric">
                    <div class="pg-metric-label">Total Pengumuman</div>
                    <div class="pg-metric-value">{{ $announcements->total() }}</div>
                </div>
                <div class="pg-metric">
                    <div class="pg-metric-label">Penting (Halaman Ini)</div>
                    <div class="pg-metric-value">{{ $urgentCount }}</div>
                </div>
                <div class="pg-metric">
                    <div class="pg-metric-label">Disematkan (Halaman Ini)</div>
                    <div class="pg-metric-value">{{ $pinnedCount }}</div>
                </div>
            </div>
        </section>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="pg-grid">
            <section class="pg-card">
                <div class="pg-card-head">
                    <div class="pg-card-title">Buat Pengumuman Baru</div>
                    <div class="pg-card-sub">Gunakan bahasa singkat, jelas, dan spesifik target.</div>
                </div>

                <div class="pg-card-body">
                    <form action="{{ route('kepala-sekolah.pengumuman.store') }}" method="POST">
                        @csrf
                        <div class="pg-row">
                            <label class="pg-label" for="ann-title">Judul</label>
                            <input id="ann-title" class="pg-input" type="text" name="title" maxlength="255" required placeholder="Contoh: Libur Nasional 17 Agustus">
                        </div>

                        <div class="pg-row">
                            <label class="pg-label" for="ann-type">Tipe</label>
                            <select id="ann-type" class="pg-select" name="type" required>
                                <option value="info">Informasi</option>
                                <option value="event">Event</option>
                                <option value="urgent">Penting</option>
                            </select>
                        </div>

                        <div class="pg-row">
                            <label class="pg-label" for="ann-body">Isi Pengumuman</label>
                            <textarea id="ann-body" class="pg-textarea" name="body" maxlength="2000" required placeholder="Tulis isi pengumuman di sini..."></textarea>
                            <div class="pg-counter"><span id="ann-counter">0</span> / 2000 karakter</div>
                        </div>

                        <div class="pg-row">
                            <label class="pg-check" for="ann-pin">
                                <input id="ann-pin" type="checkbox" name="is_pinned" value="1">
                                Sematkan pengumuman ini di bagian atas
                            </label>
                        </div>

                        <div class="pg-actions">
                            <span class="pg-note">Pengumuman akan langsung tampil untuk pengguna terkait.</span>
                            <button class="btn-primary-custom" type="submit"><i class="fas fa-paper-plane"></i> Kirim</button>
                        </div>
                    </form>
                </div>
            </section>

            <section class="pg-card">
                <div class="pg-card-head">
                    <div class="pg-card-title">Daftar Pengumuman</div>
                    <div class="pg-card-sub">Filter cepat berdasarkan kategori dan kata kunci.</div>
                </div>

                <div class="pg-card-body">
                    <div class="pg-toolbar">
                        <input id="ann-search" class="pg-search" type="text" placeholder="Cari judul atau isi pengumuman...">
                        <a class="btn-subtle" href="{{ route('dashboard') }}"><i class="fas fa-arrow-left"></i> Dashboard</a>
                    </div>

                    <div class="pg-filters" style="margin-bottom:12px;">
                        <button type="button" class="pg-filter-btn is-on" data-filter="all">Semua</button>
                        <button type="button" class="pg-filter-btn" data-filter="info">Informasi</button>
                        <button type="button" class="pg-filter-btn" data-filter="event">Event</button>
                        <button type="button" class="pg-filter-btn" data-filter="urgent">Penting</button>
                        <button type="button" class="pg-filter-btn" data-filter="pinned">Disematkan</button>
                    </div>

                    <div class="pg-list" id="ann-list">
                        @forelse($announcements as $ann)
                            @php
                                $typeClass = $ann->type === 'urgent' ? 'pg-badge-urgent' : ($ann->type === 'event' ? 'pg-badge-event' : 'pg-badge-info');
                            @endphp
                            <article class="pg-item" data-type="{{ $ann->type }}" data-pinned="{{ $ann->is_pinned ? '1' : '0' }}" data-text="{{ strtolower($ann->title . ' ' . $ann->body) }}">
                                <div class="pg-item-title">
                                    {{ $ann->title }}
                                    <span class="pg-badges">
                                        <span class="pg-badge {{ $typeClass }}">{{ strtoupper($ann->type) }}</span>
                                        @if($ann->is_pinned)
                                            <span class="pg-badge pg-badge-pin">PIN</span>
                                        @endif
                                    </span>
                                </div>

                                @php
                                    $announcerName = $ann->user?->name ?? 'Admin';
                                    $rawRole = $ann->user?->role ?? null;
                                    $roleLabel = null;
                                    if ($rawRole === 'kepala_sekolah') $roleLabel = 'Kepala Sekolah';
                                    elseif ($rawRole === 'admin') $roleLabel = 'Admin';
                                    elseif ($rawRole === 'guru' || $rawRole === 'teacher') $roleLabel = 'Guru';
                                    elseif ($rawRole === 'siswa') $roleLabel = 'Siswa';
                                    elseif ($rawRole) $roleLabel = ucfirst($rawRole);
                                @endphp
                                <div class="pg-item-meta">
                                    <i class="fas fa-user"></i> {{ $announcerName }}@if($roleLabel) <small style="color:#6b7280"> &mdash; {{ $roleLabel }}</small>@endif
                                    <span> · </span>
                                    <i class="fas fa-calendar"></i> {{ optional($ann->created_at)->translatedFormat('d M Y H:i') }}
                                </div>

                                <div class="pg-item-body">{{ $ann->body }}</div>

                                @if(auth()->id() === $ann->user_id || auth()->user()->role === 'admin' || auth()->user()->role === 'kepala_sekolah')
                                    <div class="pg-item-actions">
                                        <form action="{{ route('kepala-sekolah.pengumuman.pin', $ann->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="{{ $ann->is_pinned ? 'btn-unpin' : 'btn-pin' }}">
                                                <i class="fas {{ $ann->is_pinned ? 'fa-thumbtack-slash' : 'fa-thumbtack' }}"></i>
                                                {{ $ann->is_pinned ? 'Lepas Semat' : 'Sematkan' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('kepala-sekolah.pengumuman.destroy', $ann->id) }}" method="POST" onsubmit="return confirm('Hapus pengumuman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </div>
                                @endif
                            </article>
                        @empty
                            <div class="pg-empty">Belum ada pengumuman.</div>
                        @endforelse
                    </div>

                    <div id="ann-empty-filter" class="pg-empty" style="display:none;">Tidak ada pengumuman yang cocok dengan filter/pencarian.</div>

                    <div class="pg-pagination">
                        {{ $announcements->links() }}
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
(function () {
    var bodyInput = document.getElementById('ann-body');
    var counter = document.getElementById('ann-counter');
    if (bodyInput && counter) {
        var syncCount = function () {
            counter.textContent = String(bodyInput.value.length);
        };
        bodyInput.addEventListener('input', syncCount);
        syncCount();
    }

    var search = document.getElementById('ann-search');
    var list = document.getElementById('ann-list');
    if (!search || !list) return;

    var items = Array.prototype.slice.call(list.querySelectorAll('.pg-item'));
    var filterButtons = Array.prototype.slice.call(document.querySelectorAll('.pg-filter-btn'));
    var empty = document.getElementById('ann-empty-filter');
    var activeFilter = 'all';

    function applyFilters() {
        var keyword = (search.value || '').toLowerCase().trim();
        var shown = 0;

        items.forEach(function (item) {
            var type = item.getAttribute('data-type') || '';
            var pinned = item.getAttribute('data-pinned') === '1';
            var text = item.getAttribute('data-text') || '';

            var matchType =
                activeFilter === 'all' ||
                (activeFilter === 'pinned' && pinned) ||
                (activeFilter !== 'pinned' && activeFilter === type);

            var matchSearch = !keyword || text.indexOf(keyword) !== -1;
            var visible = matchType && matchSearch;

            item.style.display = visible ? '' : 'none';
            if (visible) shown++;
        });

        if (empty) empty.style.display = shown === 0 ? '' : 'none';
    }

    filterButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            activeFilter = btn.getAttribute('data-filter') || 'all';
            filterButtons.forEach(function (b) {
                b.classList.remove('is-on');
            });
            btn.classList.add('is-on');
            applyFilters();
        });
    });

    search.addEventListener('input', applyFilters);
})();
</script>
@endpush
