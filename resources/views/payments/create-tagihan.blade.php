{{-- resources/views/payments/create-tagihan.blade.php --}}
@extends('layouts.app')

@section('title', 'Buat Tagihan')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Geist:wght@300;400;500;600;700&display=swap');

    :root {
        --sw: 62px;
        --sw-open: 230px;
        --sb: var(--sw);
        --sb-open: var(--sw-open);
        --ink:       #0d0f14;
        --ink-2:     #4a5161;
        --ink-3:     #9299a8;
        --surface:   #f7f8fa;
        --card:      #ffffff;
        --border:    #e4e7ed;
        --border-2:  #d0d5df;
        --accent:    #2153e8;
        --accent-lt: #eef2fd;
        --accent-dk: #1640c4;
        --gold:      #e8a921;
        --gold-lt:   #fdf6e3;
        --green:     #16a34a;
        --green-lt:  #f0fdf4;
        --red:       #dc2626;
        --radius-sm: 10px;
        --radius:    16px;
        --radius-lg: 24px;
        --shadow-sm: 0 1px 3px rgba(13,15,20,.06), 0 1px 2px rgba(13,15,20,.04);
        --shadow:    0 4px 16px rgba(13,15,20,.07), 0 1px 4px rgba(13,15,20,.04);
        --shadow-lg: 0 16px 40px rgba(13,15,20,.10), 0 4px 12px rgba(13,15,20,.05);
    }

    html[data-theme="dark"] {
        --ink:       #edf0f7;
        --ink-2:     #9299a8;
        --ink-3:     #5a6070;
        --surface:   #0d0f14;
        --card:      #161922;
        --border:    #252a35;
        --border-2:  #2f3545;
        --accent-lt: #1a2550;
        --gold-lt:   #2a2010;
        --green-lt:  #0b1f10;
    }

    .tg-page {
        font-family: 'Geist', sans-serif;
        min-height: 100vh;
        background: var(--surface);
        color: var(--ink);
        padding: 36px 40px 60px;
        max-width: 1100px;
        margin: 0 auto;
    }

    /* ── Header ── */
    .tg-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 36px;
        gap: 16px;
    }
    .tg-header-left {}
    .tg-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11.5px;
        font-weight: 600;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--accent);
        background: var(--accent-lt);
        padding: 4px 12px;
        border-radius: 99px;
        margin-bottom: 10px;
    }
    .tg-title {
        font-family: 'Instrument Serif', Georgia, serif;
        font-size: 40px;
        font-weight: 400;
        line-height: 1.15;
        color: var(--ink);
        letter-spacing: -.02em;
        margin: 0 0 6px;
    }
    .tg-subtitle {
        font-size: 15px;
        color: var(--ink-3);
        font-weight: 400;
        margin: 0;
    }
    .tg-stat-pill {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 14px 20px;
        box-shadow: var(--shadow-sm);
        white-space: nowrap;
    }
    .tg-stat-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        background: var(--accent-lt);
        display: flex; align-items: center; justify-content: center;
        color: var(--accent);
        font-size: 16px;
        flex-shrink: 0;
    }
    .tg-stat-num {
        font-size: 22px;
        font-weight: 700;
        color: var(--ink);
        line-height: 1;
    }
    .tg-stat-lbl {
        font-size: 11px;
        color: var(--ink-3);
        font-weight: 500;
        margin-top: 2px;
    }

    /* ── Tab switcher ── */
    .tg-tabs {
        display: inline-flex;
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 4px;
        gap: 2px;
        margin-bottom: 28px;
        box-shadow: var(--shadow-sm);
    }
    .tg-tab {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 26px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        color: var(--ink-3);
        cursor: pointer;
        border: none;
        background: transparent;
        transition: all .18s ease;
        font-family: 'Geist', sans-serif;
    }
    .tg-tab .tab-ico {
        width: 24px; height: 24px;
        border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px;
        background: var(--surface);
        transition: background .18s;
    }
    .tg-tab:hover { color: var(--ink); }
    .tg-tab.active {
        background: var(--accent);
        color: #fff;
        box-shadow: 0 4px 14px rgba(33,83,232,.28);
    }
    .tg-tab.active .tab-ico {
        background: rgba(255,255,255,.2);
        color: #fff;
    }
    .tg-tab.active-gold {
        background: var(--gold);
        color: #fff;
        box-shadow: 0 4px 14px rgba(232,169,33,.3);
    }
    .tg-tab.active-gold .tab-ico {
        background: rgba(255,255,255,.2);
    }

    /* ── Panels ── */
    .tg-panel { display: none; }
    .tg-panel.show { display: block; animation: fadeUp .22s ease; }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Card ── */
    .tg-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        overflow: hidden;
        max-width: 100%;
    }
    .tg-card-head {
        padding: 24px 28px 20px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .tg-card-icon {
        width: 44px; height: 44px;
        border-radius: 13px;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .tg-card-icon.blue { background: var(--accent-lt); color: var(--accent); }
    .tg-card-icon.gold { background: var(--gold-lt); color: var(--gold); }
    .tg-card-htitle {
        font-size: 18px;
        font-weight: 700;
        color: var(--ink);
        margin: 0 0 2px;
    }
    .tg-card-hdesc {
        font-size: 13.5px;
        color: var(--ink-3);
        margin: 0;
    }
    .tg-card-body { padding: 28px; }

    /* ── Alert ── */
    .tg-alert-err {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: var(--radius-sm);
        padding: 14px 16px;
        margin-bottom: 22px;
        font-size: 13px;
        color: var(--red);
    }
    .tg-alert-err ul { margin: 6px 0 0; padding-left: 18px; }
    .tg-alert-ok {
        background: var(--green-lt);
        border: 1px solid #bbf7d0;
        border-radius: var(--radius-sm);
        padding: 14px 16px;
        margin-bottom: 22px;
        font-size: 13px;
        color: var(--green);
        display: flex; align-items: center; gap: 8px;
    }

    /* ── Form elements ── */
    .tg-field { margin-bottom: 20px; }
    .tg-label {
        display: block;
        font-size: 13px;
        font-weight: 650;
        color: var(--ink-2);
        margin-bottom: 7px;
        letter-spacing: .01em;
    }
    .tg-req { color: var(--red); margin-left: 2px; }
    .tg-input, .tg-select {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid var(--border-2);
        border-radius: var(--radius-sm);
        font-size: 15px;
        font-family: 'Geist', sans-serif;
        color: var(--ink);
        background: var(--surface);
        transition: border-color .16s, box-shadow .16s, background .16s;
        appearance: none;
        outline: none;
    }
    .tg-input::placeholder { color: var(--ink-3); }
    .tg-input:focus, .tg-select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(33,83,232,.12);
        background: var(--card);
    }
    .tg-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%239299a8' stroke-width='1.6' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 38px;
        cursor: pointer;
    }
    .tg-hint { font-size: 11.5px; color: var(--ink-3); margin-top: 5px; }
    .tg-err-msg { font-size: 11.5px; color: var(--red); margin-top: 5px; }
    .tg-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    /* ── Photo avatar section ── */
    .tg-avatar-row {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: var(--surface);
        border-radius: var(--radius-sm);
        border: 1.5px dashed var(--border-2);
        margin-bottom: 20px;
        cursor: pointer;
        transition: border-color .18s, background .18s;
    }
    .tg-avatar-row:hover { border-color: var(--accent); background: var(--accent-lt); }
    .tg-avatar-img { width: 56px; height: 56px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border); }
    .tg-avatar-info { flex: 1; }
    .tg-avatar-name { font-size: 14px; font-weight: 600; color: var(--ink); }
    .tg-avatar-hint { font-size: 12px; color: var(--ink-3); margin-top: 2px; }

    /* ── Nominal display ── */
    .tg-nominal-wrap { position: relative; }
    .tg-nominal-prefix {
        position: absolute;
        left: 14px; top: 50%; transform: translateY(-50%);
        font-size: 13px; font-weight: 700; color: var(--ink-3);
        pointer-events: none;
    }
    .tg-nominal-wrap .tg-input { padding-left: 46px; }

    /* ── Info banner (bulk) ── */
    .tg-info-banner {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        background: var(--gold-lt);
        border: 1px solid #f3d99a;
        border-radius: var(--radius-sm);
        padding: 14px 16px;
        margin-bottom: 22px;
    }
    .tg-info-banner-ico { font-size: 18px; flex-shrink: 0; margin-top: 1px; }
    .tg-info-banner-txt { font-size: 13px; color: #92630a; line-height: 1.5; }
    .tg-info-banner-txt strong { color: #7a4f06; }

    /* ── Divider ── */
    .tg-divider {
        height: 1px;
        background: var(--border);
        margin: 24px 0;
    }

    /* ── Buttons ── */
    .tg-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 28px;
        border-radius: var(--radius-sm);
        font-size: 15px;
        font-weight: 650;
        font-family: 'Geist', sans-serif;
        cursor: pointer;
        border: none;
        transition: all .18s ease;
        width: 100%;
    }
    .tg-btn-primary {
        background: var(--accent);
        color: #fff;
        box-shadow: 0 4px 14px rgba(33,83,232,.28);
    }
    .tg-btn-primary:hover {
        background: var(--accent-dk);
        box-shadow: 0 6px 18px rgba(33,83,232,.36);
        transform: translateY(-1px);
    }
    .tg-btn-gold {
        background: var(--gold);
        color: #fff;
        box-shadow: 0 4px 14px rgba(232,169,33,.3);
    }
    .tg-btn-gold:hover {
        background: #c9911a;
        transform: translateY(-1px);
    }
    .tg-btn-ico {
        width: 20px; height: 20px;
        border-radius: 6px;
        background: rgba(255,255,255,.22);
        display: flex; align-items: center; justify-content: center;
        font-size: 12px;
    }

    /* ── Hidden keterangan ── */
    .tg-extra { display: none; }
    .tg-extra.show { display: block; animation: fadeUp .18s ease; }

    @media (max-width: 900px) {
        .tg-page { padding: 20px 16px 48px; max-width: 100%; }
        .tg-header { flex-direction: column; }
        .tg-row { grid-template-columns: 1fr; gap: 0; }
        .tg-card-body { padding: 20px; }
        .tg-card-head { padding: 18px 20px 16px; }
        .tg-title { font-size: 28px; }
    }
</style>
@endpush

@section('content')
<div class="tg-page">

    {{-- ── Header ── --}}
    <div class="tg-header">
        <div class="tg-header-left">
            <div class="tg-eyebrow">
                <i class="fas fa-file-invoice-dollar"></i>
                Keuangan Sekolah
            </div>
            <h1 class="tg-title">Buat Tagihan</h1>
            <p class="tg-subtitle">Kelola tagihan pembayaran siswa — per individu atau massal sekaligus.</p>
        </div>
        <div class="tg-stat-pill">
            <div class="tg-stat-icon"><i class="fas fa-users"></i></div>
            <div>
                <div class="tg-stat-num">{{ $students->count() }}</div>
                <div class="tg-stat-lbl">Total Siswa Aktif</div>
            </div>
        </div>
    </div>

    {{-- ── Tab Switcher ── --}}
    <div class="tg-tabs">
        <button class="tg-tab active" id="tab-single" onclick="switchTab('single')">
            <span class="tab-ico"><i class="fas fa-user"></i></span>
            Satu Siswa
        </button>
        <button class="tg-tab" id="tab-bulk" onclick="switchTab('bulk')">
            <span class="tab-ico"><i class="fas fa-users"></i></span>
            Semua Siswa
        </button>
    </div>

    {{-- ══════════════════════════════
         PANEL: SINGLE
    ══════════════════════════════ --}}
    <div class="tg-panel show" id="panel-single">
        <div class="tg-card">
            <div class="tg-card-head">
                <div class="tg-card-icon blue"><i class="fas fa-user-tag"></i></div>
                <div>
                    <p class="tg-card-htitle">Tagihan Satu Siswa</p>
                    <p class="tg-card-hdesc">Buat tagihan untuk siswa tertentu secara individual.</p>
                </div>
            </div>
            <div class="tg-card-body">

                @if($errors->any())
                <div class="tg-alert-err">
                    <strong><i class="fas fa-circle-exclamation"></i> Terdapat kesalahan:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('admin.tagihan.store') }}" method="POST">
                    @csrf

                    {{-- Siswa --}}
                    <div class="tg-field">
                        <label class="tg-label">Pilih Siswa <span class="tg-req">*</span></label>
                        <select name="student_id" class="tg-select" required>
                            <option value="">— Pilih siswa —</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Jenis Tagihan --}}
                    <div class="tg-field">
                        <label class="tg-label">Jenis Tagihan <span class="tg-req">*</span></label>
                        <select name="jenis_tagihan" class="tg-select" id="jenis_single" required onchange="toggleKet('single', this.value)">
                            <option value="">— Pilih jenis —</option>
                            <option value="SPP"      {{ old('jenis_tagihan') == 'SPP'      ? 'selected' : '' }}>SPP Bulanan</option>
                            <option value="Seragam"  {{ old('jenis_tagihan') == 'Seragam'  ? 'selected' : '' }}>Seragam</option>
                            <option value="UTS"      {{ old('jenis_tagihan') == 'UTS'      ? 'selected' : '' }}>UTS</option>
                            <option value="UAS"      {{ old('jenis_tagihan') == 'UAS'      ? 'selected' : '' }}>UAS</option>
                            <option value="Lainnya"  {{ old('jenis_tagihan') == 'Lainnya'  ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    {{-- Keterangan (kondisional) --}}
                    <div class="tg-field tg-extra" id="ket_single">
                        <label class="tg-label">Keterangan Tagihan <span class="tg-req">*</span></label>
                        <input type="text" name="keterangan" class="tg-input"
                               placeholder="Contoh: Biaya Study Tour 2026"
                               value="{{ old('keterangan') }}">
                        <p class="tg-hint">Isi nama atau keterangan tagihan khusus ini.</p>
                    </div>

                    <div class="tg-divider"></div>

                    {{-- Bulan & Tahun --}}
                    <div class="tg-row">
                        <div class="tg-field" style="margin-bottom:0">
                            <label class="tg-label">Bulan <span class="tg-req">*</span></label>
                            <select name="month" class="tg-select" required>
                                <option value="">— Pilih bulan —</option>
                                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bln)
                                    <option value="{{ $bln }}" {{ old('month') == $bln ? 'selected' : '' }}>{{ $bln }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="tg-field" style="margin-bottom:0">
                            <label class="tg-label">Tahun <span class="tg-req">*</span></label>
                            <input type="number" name="year" class="tg-input"
                                   value="{{ old('year', date('Y')) }}"
                                   min="2020" max="2099" required>
                        </div>
                    </div>

                    <div style="margin-top: 20px;"></div>

                    {{-- Nominal --}}
                    <div class="tg-field">
                        <label class="tg-label">Nominal <span class="tg-req">*</span></label>
                        <div class="tg-nominal-wrap">
                            <span class="tg-nominal-prefix">Rp</span>
                            <input type="number" name="amount" class="tg-input"
                                   value="{{ old('amount') }}"
                                   min="1" placeholder="150.000" required>
                        </div>
                    </div>

                    <div class="tg-divider"></div>

                    <button type="submit" class="tg-btn tg-btn-primary">
                        <span class="tg-btn-ico"><i class="fas fa-floppy-disk"></i></span>
                        Buat Tagihan
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════
         PANEL: BULK
    ══════════════════════════════ --}}
    <div class="tg-panel" id="panel-bulk">
        <div class="tg-card">
            <div class="tg-card-head">
                <div class="tg-card-icon gold"><i class="fas fa-bolt"></i></div>
                <div>
                    <p class="tg-card-htitle">Tagihan Semua Siswa</p>
                    <p class="tg-card-hdesc">Generate tagihan sekaligus untuk seluruh siswa aktif.</p>
                </div>
            </div>
            <div class="tg-card-body">

                <div class="tg-info-banner">
                    <span class="tg-info-banner-ico">⚡</span>
                    <div class="tg-info-banner-txt">
                        Tagihan akan dibuat untuk <strong>{{ $students->count() }} siswa</strong>.
                        Tagihan yang sudah ada di bulan &amp; tahun yang sama akan <strong>dilewati otomatis</strong> — tidak ada duplikat.
                    </div>
                </div>

                <form action="{{ route('admin.tagihan.bulk') }}" method="POST">
                    @csrf

                    {{-- Jenis Tagihan --}}
                    <div class="tg-field">
                        <label class="tg-label">Jenis Tagihan <span class="tg-req">*</span></label>
                        <select name="jenis_tagihan" class="tg-select" id="jenis_bulk" required onchange="toggleKet('bulk', this.value)">
                            <option value="">— Pilih jenis —</option>
                            <option value="SPP">SPP Bulanan</option>
                            <option value="Seragam">Seragam</option>
                            <option value="UTS">UTS</option>
                            <option value="UAS">UAS</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    {{-- Keterangan (kondisional) --}}
                    <div class="tg-field tg-extra" id="ket_bulk">
                        <label class="tg-label">Keterangan Tagihan</label>
                        <input type="text" name="keterangan" class="tg-input"
                               placeholder="Contoh: Biaya Study Tour 2026">
                    </div>

                    <div class="tg-divider"></div>

                    {{-- Bulan & Tahun --}}
                    <div class="tg-row">
                        <div class="tg-field" style="margin-bottom:0">
                            <label class="tg-label">Bulan <span class="tg-req">*</span></label>
                            <select name="month" class="tg-select" required>
                                <option value="">— Pilih bulan —</option>
                                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bln)
                                    <option value="{{ $bln }}">{{ $bln }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="tg-field" style="margin-bottom:0">
                            <label class="tg-label">Tahun <span class="tg-req">*</span></label>
                            <input type="number" name="year" class="tg-input"
                                   value="{{ date('Y') }}"
                                   min="2020" max="2099" required>
                        </div>
                    </div>

                    <div style="margin-top: 20px;"></div>

                    {{-- Nominal --}}
                    <div class="tg-field">
                        <label class="tg-label">Nominal <span class="tg-req">*</span></label>
                        <div class="tg-nominal-wrap">
                            <span class="tg-nominal-prefix">Rp</span>
                            <input type="number" name="amount" class="tg-input"
                                   min="1" placeholder="150.000" required>
                        </div>
                    </div>

                    <div class="tg-divider"></div>

                    <button type="submit" class="tg-btn tg-btn-gold"
                        onclick="return confirm('Yakin ingin membuat tagihan untuk semua {{ $students->count() }} siswa?')">
                        <span class="tg-btn-ico"><i class="fas fa-bolt"></i></span>
                        Buat Tagihan Semua Siswa
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function switchTab(tab) {
        document.querySelectorAll('.tg-panel').forEach(p => p.classList.remove('show'));
        document.querySelectorAll('.tg-tab').forEach(t => {
            t.classList.remove('active', 'active-gold');
        });
        document.getElementById('panel-' + tab).classList.add('show');
        const btn = document.getElementById('tab-' + tab);
        btn.classList.add(tab === 'bulk' ? 'active-gold' : 'active');
    }

    function toggleKet(type, val) {
        const el = document.getElementById('ket_' + type);
        if (val === 'Lainnya') {
            el.classList.add('show');
        } else {
            el.classList.remove('show');
        }
    }

    // Restore state on page load if old('jenis_tagihan') === 'Lainnya'
    document.addEventListener('DOMContentLoaded', function () {
        ['single', 'bulk'].forEach(type => {
            const sel = document.getElementById('jenis_' + type);
            if (sel && sel.value === 'Lainnya') toggleKet(type, 'Lainnya');
        });
    });
</script>
@endpush
@endsection