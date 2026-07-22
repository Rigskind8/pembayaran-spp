{{-- resources/views/students/pembayaran.blade.php --}}
@extends('layouts.app')

@section('title', 'Pembayaran Siswa - SMK TRAVINA PRIMA')

@push('styles')
<style>
    * { box-sizing: border-box; }

    :root {
        --primary:        #2563eb;
        --primary-dark:   #1e40af;
        --primary-light:  #e0e7ff;
        --primary-border: #a5b4fc;
        --body-bg:        #f1f5fd;
        --card-bg:        #ffffff;
        --border:         rgba(37,99,235,0.08);
        --gray:           #64748b;
    }

    body { background: var(--body-bg); }

    /* ── SIDEBAR OFFSET ── */
    .main {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 8px 32px rgba(15,118,110,0.10);
        min-height: 100vh;
        padding-bottom: 32px;
    }
    @media (max-width: 640px) { .main { margin-left: 0 !important; } }

    /* ── HERO ── */
    .hero {
        background: linear-gradient(120deg, #2563eb 60%, #7c3aed 100%);
        padding: 1.5rem 1.75rem 2.8rem;
        position: relative;
        overflow: hidden;
        border-top-left-radius: 18px;
        border-top-right-radius: 18px;
    }
    .hero-stripe {
        position: absolute; top: 0; right: 0;
        width: 180px; height: 100%;
        background: rgba(255,255,255,0.05);
        clip-path: polygon(40% 0, 100% 0, 100% 100%, 0% 100%);
    }
    .hero-stripe2 {
        position: absolute; top: 0; right: 0;
        width: 110px; height: 100%;
        background: rgba(255,255,255,0.06);
        clip-path: polygon(60% 0, 100% 0, 100% 100%, 20% 100%);
    }
    .hero-arc {
        position: absolute; bottom: -1px; left: 0; right: 0;
        height: 28px;
        background: var(--body-bg);
        border-radius: 50% 50% 0 0 / 100% 100% 0 0;
    }
    .hero-inner {
        position: relative; z-index: 1;
        display: flex; align-items: flex-start; justify-content: space-between;
    }
    .hero-kicker {
        font-size: 11px; font-weight: 500; letter-spacing: .1em;
        text-transform: uppercase; color: rgba(255,255,255,.6);
        margin-bottom: 4px;
    }
    .hero-title {
        font-size: 22px; font-weight: 600; color: #fff;
        margin-bottom: 4px; line-height: 1.2;
    }
    .hero-sub { font-size: 14px; color: rgba(255,255,255,.7); margin: 0; }
    .hero-sub strong { color: #fff; font-weight: 500; }

    .btn-pdf {
        display: inline-flex; align-items: center; gap: 6px;
        background: #fff; color: var(--primary);
        border: none; border-radius: 10px;
        padding: 9px 16px; font-size: 12px; font-weight: 600;
        text-decoration: none; white-space: nowrap;
        transition: opacity .15s;
    }
    .btn-pdf:hover { opacity: .88; color: var(--primary); }
    .btn-pdf i { font-size: 13px; }

    /* ── CONTENT SHELL ── */
        .content-shell {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 1.25rem 2.5rem;
            margin-top: -1.5rem;
            position: relative;
            z-index: 2;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(15,118,110,0.08);
    }

    /* ── ALERT ── */
    .alert-ok {
        background: var(--primary-light);
        border: .5px solid var(--primary-border);
        border-radius: 10px;
        padding: 10px 14px;
        margin-bottom: 14px;
        font-size: 13px;
        color: var(--primary-dark);
        font-weight: 500;
    }
    .alert-err {
        background: #FCEBEB;
        border: .5px solid #F09595;
        border-radius: 10px;
        padding: 10px 14px;
        margin-bottom: 14px;
        font-size: 13px;
        color: #791F1F;
        font-weight: 500;
    }

    /* ── STAT GRID ── */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        margin-bottom: 1.25rem;
    }
    @media (max-width: 640px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }

    .stat-card {
        background: var(--card-bg);
        border: .5px solid var(--border);
        border-radius: 14px;
        padding: 14px;
    }
    .stat-dot {
        width: 32px; height: 32px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 10px;
        font-size: 15px;
    }
    .stat-dot.red    { background: #FCEBEB; color: #A32D2D; }
    .stat-dot.amber  { background: #FAEEDA; color: #854F0B; }
    .stat-dot.green  { background: #EAF3DE; color: #3B6D11; }
    .stat-dot.blue   { background: #E6F1FB; color: #185FA5; }
    .stat-num        { font-size: 22px; font-weight: 700; line-height: 1; margin-bottom: 3px; color: #111827; }
    .stat-num.red    { color: #A32D2D; }
    .stat-num.amber  { color: #854F0B; }
    .stat-num.green  { color: #3B6D11; }
    .stat-num.blue   { color: #185FA5; font-size: 13px; line-height: 1.4; }
    .stat-label      { font-size: 10px; font-weight: 600; color: var(--gray); text-transform: uppercase; letter-spacing: .05em; }
    .stat-note       { font-size: 10px; color: #9ca3af; margin-top: 2px; }

    /* ── SECTION CARD ── */
    .section-card {
        background: var(--card-bg);
        border: .5px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 14px;
    }
    .section-head {
        padding: 12px 16px;
        border-bottom: .5px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        background: #f9fafb;
    }
    .section-head-left { display: flex; align-items: center; gap: 10px; }
    .section-icon {
        width: 30px; height: 30px; border-radius: 8px;
        background: var(--primary-light);
        color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
    }
    .section-title { font-size: 14px; font-weight: 600; color: #111827; margin: 0; }

    /* ── PILLS / BADGES ── */
    .pill {
        display: inline-flex; align-items: center;
        padding: 3px 10px; border-radius: 999px;
        font-size: 11px; font-weight: 600;
    }
    .pill-teal   { background: #E1F5EE; color: #0F6E56; }
    .pill-amber  { background: #FAEEDA; color: #854F0B; }
    .pill-blue   { background: #E6F1FB; color: #185FA5; }
    .pill-purple { background: #EEEDFE; color: #3C3489; }
    .pill-gray   { background: #f3f4f6; color: #374151; border: .5px solid #e5e7eb; }
    .pill-red    { background: #FCEBEB; color: #A32D2D; }
    .pill-green  { background: #EAF3DE; color: #3B6D11; }
    .pill-warn   { background: #FAEEDA; color: #854F0B; }
    .badge-danger { display:inline-flex;align-items:center;padding:2px 10px;border-radius:999px;font-size:11px;font-weight:600;background:#FCEBEB;color:#A32D2D; }
    .badge-gray   { display:inline-flex;align-items:center;padding:2px 10px;border-radius:999px;font-size:11px;font-weight:600;background:#f3f4f6;color:#374151;border:.5px solid #e5e7eb; }

    /* ── TABLE ── */
    .tbl { width: 100%; border-collapse: collapse; font-size: 13px; }
    .tbl th {
        padding: 9px 16px;
        text-align: left;
        font-size: 10px; font-weight: 600;
        text-transform: uppercase; letter-spacing: .06em;
        color: var(--gray);
        border-bottom: .5px solid var(--border);
        background: #f9fafb;
    }
    .tbl td {
        padding: 11px 16px;
        color: #111827;
        border-bottom: .5px solid #f3f4f6;
        vertical-align: middle;
    }
    .tbl tbody tr:last-child td { border-bottom: none; }
    .tbl tbody tr:hover td      { background: #f0fdf9; }

    /* ── ACTION BUTTONS ── */
    .action-row { display: flex; gap: 6px; justify-content: flex-end; }
    .btn-pay {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 7px 14px;
        background: var(--primary); color: #fff;
        border: none; border-radius: 8px;
        font-size: 12px; font-weight: 600; cursor: pointer;
        transition: background .15s;
    }
    .btn-pay:hover { background: var(--primary-dark); }
    .btn-bukti {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 7px 14px;
        background: transparent; color: var(--gray);
        border: .5px solid #d1d5db; border-radius: 8px;
        font-size: 12px; font-weight: 600; cursor: pointer;
        transition: border-color .15s, color .15s;
    }
    .btn-bukti:hover { border-color: var(--primary); color: var(--primary); }

    .reject-note {
        font-size: 11px; color: #A32D2D;
        background: #FCEBEB; border-radius: 6px;
        padding: 4px 8px; margin-top: 4px;
    }

    /* ── EMPTY STATE ── */
    .empty-state { text-align: center; padding: 3rem 1rem; color: var(--gray); font-size: 13px; }
    .empty-icon {
        width: 40px; height: 40px;
        background: #f3f4f6; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 10px; font-size: 18px; color: #9ca3af;
    }

    /* ── MODAL ── */
    .modal-content { border: .5px solid var(--border); border-radius: 14px; }
    .modal-header  { border-bottom: .5px solid var(--border); padding: 14px 16px; }
    .modal-header .modal-title { font-size: 14px; font-weight: 600; color: #111827; }
    .modal-footer  { border-top: .5px solid var(--border); padding: 12px 16px; gap: 8px; }
    .modal-body    { padding: 16px; }

    .info-box {
        background: var(--primary-light);
        border: .5px solid var(--primary-border);
        border-radius: 10px; padding: 12px 14px; margin-bottom: 14px;
    }
    .info-box-label { font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; color: var(--primary); margin-bottom: 2px; }
    .info-box-val   { font-size: 18px; font-weight: 700; color: var(--primary-dark); }
    .info-box-note  { font-size: 12px; color: var(--primary); opacity: .75; margin-top: 1px; }

    .method-info {
        background: var(--primary-light);
        border: .5px solid var(--primary-border);
        border-radius: 10px; padding: 12px 14px; margin-bottom: 12px;
    }
    .rowline { font-size: 12px; color: var(--primary-dark); margin-bottom: 3px; }
    .rowline strong { color: var(--primary-dark); }
    .code-box {
        display: flex; align-items: center; justify-content: space-between;
        background: #fff; border: .5px solid var(--primary-border);
        border-radius: 6px; padding: 8px 10px; margin-top: 6px;
    }
    .code-val  { font-size: 13px; font-weight: 600; color: #0b2239; font-family: monospace; }
    .copy-btn  { font-size: 11px; color: var(--primary); font-weight: 600; background: none; border: none; cursor: pointer; }
    .qr-wrap   { text-align: center; margin-top: 10px; }
    .qr-wrap img { width: 180px; max-width: 100%; border-radius: 8px; }

    .btn-cancel {
        padding: 8px 18px; border-radius: 8px;
        font-size: 13px; font-weight: 500;
        background: none; color: var(--gray);
        border: .5px solid #d1d5db; cursor: pointer;
    }
    .btn-primary-solid {
        padding: 8px 20px; border-radius: 8px;
        font-size: 13px; font-weight: 600;
        background: var(--primary); color: #fff;
        border: none; cursor: pointer;
        transition: background .15s;
    }
    .btn-primary-solid:hover   { background: var(--primary-dark); }
    .btn-primary-solid:disabled { opacity: .6; cursor: not-allowed; }

    /* ── TOAST ── */
    .toast-wrapper {
        position: fixed; bottom: 24px; right: 24px;
        z-index: 9999;
    }
    .toast-msg {
        padding: 12px 20px; border-radius: 10px;
        color: #fff; font-size: 13px; font-weight: 500;
        box-shadow: 0 4px 16px rgba(0,0,0,.15);
        max-width: 320px;
    }

    /* ── RESPONSIVE TABLE ── */
    @media (max-width: 640px) {
        .tbl th:nth-child(3), .tbl td:nth-child(3),
        .tbl th:nth-child(5), .tbl td:nth-child(5) { display: none; }
    }
</style>
@endpush

@section('content')
@include('partials.sidebar')

<div class="main">

    {{-- ══ HERO ══ --}}
    <div class="hero">
        <div class="hero-stripe"></div>
        <div class="hero-stripe2"></div>
        <div class="hero-inner">
            <div>
                <p class="hero-kicker">Siswa Portal — SMK Travina Prima</p>
                <h1 class="hero-title">Pembayaran saya</h1>
                <p class="hero-sub">Halo, <strong>{{ $student->name }}</strong></p>
            </div>
            <a href="{{ route('siswa.pembayaran.pdf') }}" class="btn-pdf">
                <i class="fas fa-file-arrow-down"></i> Download PDF
            </a>
        </div>
        <div class="hero-arc"></div>
    </div>

    {{-- ══ CONTENT ══ --}}
    <div class="content-shell">

        {{-- Alert --}}
        @if(session('success'))
            <div class="alert-ok">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-err">{{ session('error') }}</div>
        @endif

        {{-- ── STAT CARDS ── --}}
        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-dot red"><i class="fas fa-circle-xmark"></i></div>
                <div class="stat-num red">{{ $tagihan->where('status','unpaid')->count() }}</div>
                <div class="stat-label">Belum bayar</div>
                <div class="stat-note">Butuh tindakan</div>
            </div>
            <div class="stat-card">
                <div class="stat-dot amber"><i class="fas fa-hourglass-half"></i></div>
                <div class="stat-num amber">{{ $tagihan->where('status','pending')->count() }}</div>
                <div class="stat-label">Pending verifikasi</div>
                <div class="stat-note">Menunggu admin</div>
            </div>
            <div class="stat-card">
                <div class="stat-dot green"><i class="fas fa-circle-check"></i></div>
                <div class="stat-num green">{{ $riwayat->whereIn('status',['approved','paid'])->count() }}</div>
                <div class="stat-label">Sudah lunas</div>
                <div class="stat-note">Pembayaran sukses</div>
            </div>
            <div class="stat-card">
                <div class="stat-dot blue"><i class="fas fa-wallet"></i></div>
                <div class="stat-num blue">
                    Rp {{ number_format($riwayat->whereIn('status',['approved','paid'])->sum('amount'), 0, ',', '.') }}
                </div>
                <div class="stat-label">Total dibayar</div>
                <div class="stat-note">Akumulasi</div>
            </div>
        </div>

        {{-- ── TAGIHAN AKTIF ── --}}
        <div class="section-card">
            <div class="section-head">
                <div class="section-head-left">
                    <span class="section-icon"><i class="fas fa-receipt"></i></span>
                    <span class="section-title">Tagihan aktif</span>
                </div>
                @if($tagihan->count() > 0)
                    <span class="badge-danger">{{ $tagihan->count() }} tagihan</span>
                @endif
            </div>

            @if($tagihan->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-check"></i></div>
                    <p>Tidak ada tagihan aktif. Semua sudah lunas!</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="tbl">
                        <thead>
                            <tr>
                                <th>Jenis</th>
                                <th>Keterangan</th>
                                <th>Periode</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th style="text-align:right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tagihan as $t)
                            @php
                                $pillMap = ['SPP'=>'pill-teal','Seragam'=>'pill-amber','UTS'=>'pill-blue','UAS'=>'pill-purple'];
                                $pillClass = $pillMap[$t->jenis_tagihan ?? ''] ?? 'pill-gray';
                            @endphp
                            <tr>
                                <td><span class="pill {{ $pillClass }}">{{ $t->jenis_tagihan ?? $t->type }}</span></td>
                                <td style="color:var(--gray);font-size:12px;">{{ $t->keterangan ?? '-' }}</td>
                                <td style="font-size:12px;font-weight:600;">{{ $t->month }} / {{ $t->year }}</td>
                                <td style="font-weight:700;">Rp {{ number_format($t->amount, 0, ',', '.') }}</td>
                                <td>
                                    @if($t->status === 'unpaid')
                                        <span class="pill pill-red">Belum bayar</span>
                                        @if($t->catatan_reject)
                                            <div class="reject-note">{{ $t->catatan_reject }}</div>
                                        @endif
                                    @elseif($t->status === 'pending')
                                        <span class="pill pill-warn">Menunggu verif.</span>
                                    @endif
                                </td>
                                <td>
                                    @if(in_array($t->status, ['unpaid','pending']))
                                        <div class="action-row">
                                            <button type="button" class="btn-pay"
                                                data-id="{{ $t->id }}"
                                                data-jenis="{{ $t->jenis_tagihan ?? $t->type }}"
                                                data-keterangan="{{ $t->keterangan ?? '' }}"
                                                data-amount="{{ $t->amount }}"
                                                onclick="openBayarModal(this)">
                                                <i class="fas fa-credit-card"></i> Bayar
                                            </button>
                                            <button type="button" class="btn-bukti"
                                                data-id="{{ $t->id }}"
                                                data-jenis="{{ $t->jenis_tagihan ?? $t->type }}"
                                                onclick="openUploadModal(this)">
                                                <i class="fas fa-paperclip"></i> Bukti
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- ── RIWAYAT ── --}}
        <div class="section-card">
            <div class="section-head">
                <div class="section-head-left">
                    <span class="section-icon"><i class="fas fa-clock-rotate-left"></i></span>
                    <span class="section-title">Riwayat pembayaran</span>
                </div>
                <span class="badge-gray">{{ $riwayat->count() }} transaksi</span>
            </div>

            @if($riwayat->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                    <p>Belum ada riwayat pembayaran.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="tbl">
                        <thead>
                            <tr>
                                <th>Jenis</th>
                                <th>Keterangan</th>
                                <th>Periode</th>
                                <th>Nominal</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayat as $r)
                            <tr>
                                <td><span class="pill pill-gray">{{ $r->jenis_tagihan ?? $r->type ?? '-' }}</span></td>
                                <td style="color:var(--gray);font-size:12px;">{{ $r->keterangan ?? '-' }}</td>
                                <td style="font-size:12px;">{{ $r->month }} / {{ $r->year }}</td>
                                <td style="font-weight:700;">Rp {{ number_format($r->amount, 0, ',', '.') }}</td>
                                <td style="color:var(--gray);font-size:12px;">{{ $r->payment_method ?? '-' }}</td>
                                <td>
                                    @if(in_array($r->status, ['approved','paid']))
                                        <span class="pill pill-green">Lunas</span>
                                    @elseif($r->status === 'pending')
                                        <span class="pill pill-warn">Pending</span>
                                    @elseif($r->status === 'unpaid')
                                        <span class="pill pill-red">Belum bayar</span>
                                    @else
                                        <span class="pill pill-gray">{{ $r->status }}</span>
                                    @endif
                                </td>
                                <td style="color:#9ca3af;font-size:11px;">{{ $r->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>{{-- /content-shell --}}
</div>{{-- /main --}}


{{-- ══════════════════════════════════════
     MODAL BAYAR
══════════════════════════════════════ --}}
<div class="modal fade" id="bayarModal" tabindex="-1" aria-labelledby="bayarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bayarModalLabel">Konfirmasi pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formBayar">
                @csrf
                <input type="hidden" id="bayar_payment_id" name="payment_id">
                <div class="modal-body">
                    <div class="info-box">
                        <div class="info-box-label" id="bayar_jenis"></div>
                        <div class="info-box-val"   id="bayar_nominal"></div>
                        <div class="info-box-note"  id="bayar_keterangan"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-600" style="font-size:12px;">Metode pembayaran <span class="text-danger">*</span></label>
                        <select name="payment_method" id="bayar_payment_method" class="form-select form-select-sm" required>
                            <option value="">-- Pilih metode --</option>
                            @if(($paymentMethods ?? collect())->count() > 0)
                                @foreach($paymentMethods as $method)
                                    <option value="{{ $method->name }}">{{ $method->name }}</option>
                                @endforeach
                            @else
                                <option value="Tunai">Tunai</option>
                                <option value="Transfer Bank">Transfer Bank</option>
                                <option value="Virtual Account">Virtual Account</option>
                                <option value="QRIS">QRIS</option>
                            @endif
                        </select>
                    </div>

                    <div id="bayarMethodInfo" class="method-info" style="display:none;">
                        <div class="rowline" style="margin-bottom:8px;"><strong>Rekening resmi SMK Travina Prima</strong></div>
                        <div class="rowline"><strong>Metode:</strong> <span id="bm_name">-</span></div>
                        <div class="rowline" id="bm_bank_wrap" style="display:none;"><strong>Bank/Platform:</strong> <span id="bm_bank">-</span></div>
                        <div class="rowline" id="bm_atas_wrap" style="display:none;"><strong>Atas nama:</strong> <span id="bm_atas">-</span></div>
                        <div id="bm_kode_wrap" style="display:none;">
                            <div class="rowline"><strong>Nomor / kode pembayaran:</strong></div>
                            <div class="code-box">
                                <div id="bm_kode" class="code-val">-</div>
                                <button type="button" class="copy-btn" onclick="copyBayarCode(this)">Salin</button>
                            </div>
                            <div style="font-size:11px;color:#6b7280;margin-top:5px;">Atas nama <strong>SMK Travina Prima</strong></div>
                        </div>
                        <div id="bm_qr_wrap" class="qr-wrap" style="display:none;">
                            <img id="bm_qr" src="" alt="QRIS">
                            <div style="font-size:11px;color:#6b7280;margin-top:5px;">Scan QR untuk bayar</div>
                        </div>
                        <div id="bm_hint" style="display:none;font-size:11px;color:#b45309;margin-top:6px;">Detail metode belum lengkap. Hubungi admin.</div>
                    </div>

                    <div class="mb-1">
                        <label class="form-label" style="font-size:12px;">Catatan <span style="color:#9ca3af;">(opsional)</span></label>
                        <textarea name="catatan" class="form-control form-control-sm" rows="2" placeholder="Contoh: sudah transfer ke BCA 1234567890"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary-solid" id="btnSubmitBayar">Kirim pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     MODAL UPLOAD BUKTI
══════════════════════════════════════ --}}
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload bukti pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formUpload" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="upload_payment_id" name="payment_id">
                <div class="modal-body">
                    <div class="info-box">
                        <div class="info-box-label" id="upload_jenis"></div>
                        <div class="info-box-val">Upload file bukti transfer</div>
                        <div class="info-box-note">JPG, PNG, atau PDF — maks 5MB</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:12px;">Metode pembayaran <span class="text-danger">*</span></label>
                        <select name="payment_method" id="upload_payment_method" class="form-select form-select-sm" required>
                            <option value="">-- Pilih metode --</option>
                            @if(($paymentMethods ?? collect())->count() > 0)
                                @foreach($paymentMethods as $method)
                                    <option value="{{ $method->name }}">{{ $method->name }}</option>
                                @endforeach
                            @else
                                <option value="BCA Transfer">BCA Transfer</option>
                                <option value="BNI Transfer">BNI Transfer</option>
                                <option value="BRI Transfer">BRI Transfer</option>
                                <option value="Mandiri Transfer">Mandiri Transfer</option>
                                <option value="BSI Transfer">BSI Transfer</option>
                                <option value="BCA Virtual Account">BCA Virtual Account</option>
                                <option value="BNI Virtual Account">BNI Virtual Account</option>
                                <option value="BRI Virtual Account">BRI Virtual Account</option>
                                <option value="Mandiri Virtual Account">Mandiri Virtual Account</option>
                                <option value="OVO">E-Wallet — OVO</option>
                                <option value="GoPay">E-Wallet — GoPay</option>
                                <option value="DANA">E-Wallet — Dana</option>
                                <option value="ShopeePay">E-Wallet — ShopeePay</option>
                                <option value="Indomaret">Indomaret</option>
                                <option value="Alfamart">Alfamart</option>
                                <option value="QRIS">QRIS</option>
                            @endif
                        </select>
                    </div>

                    @php
                        $paymentMethodInfo = ($paymentMethods ?? collect())->map(function($pm) {
                            $raw = (string)($pm->qr_image ?? '');
                            if ($raw && !str_starts_with($raw,'http')) {
                                $raw = asset('storage/'.ltrim($raw,'/'));
                            }
                            return [
                                'name'      => (string)($pm->name ?? ''),
                                'kode'      => (string)($pm->kode ?? ''),
                                'atas_nama' => (string)($pm->atas_nama ?: 'SMK TRAVINA PRIMA'),
                                'bank'      => (string)($pm->bank ?? ''),
                                'qr'        => $raw,
                            ];
                        })->values();
                    @endphp

                    <div id="uploadMethodInfo" class="method-info" style="display:none;">
                        <div class="rowline" style="margin-bottom:8px;"><strong>Rekening resmi SMK Travina Prima</strong></div>
                        <div class="rowline"><strong>Metode:</strong> <span id="mi_name">-</span></div>
                        <div class="rowline" id="mi_bank_wrap" style="display:none;"><strong>Bank/Platform:</strong> <span id="mi_bank">-</span></div>
                        <div class="rowline" id="mi_atas_wrap" style="display:none;"><strong>Atas nama:</strong> <span id="mi_atas">-</span></div>
                        <div id="mi_kode_wrap" style="display:none;">
                            <div class="rowline"><strong>Nomor / kode pembayaran:</strong></div>
                            <div class="code-box">
                                <div id="mi_kode" class="code-val">-</div>
                                <button type="button" class="copy-btn" onclick="copyMethodCode(this)">Salin</button>
                            </div>
                            <div style="font-size:11px;color:#6b7280;margin-top:5px;">Atas nama <strong>SMK Travina Prima</strong></div>
                        </div>
                        <div id="mi_qr_wrap" class="qr-wrap" style="display:none;">
                            <img id="mi_qr" src="" alt="QRIS">
                            <div style="font-size:11px;color:#6b7280;margin-top:5px;">Scan QR untuk bayar</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-size:12px;">File bukti <span class="text-danger">*</span></label>
                        <input type="file" name="proof" class="form-control form-control-sm"
                               accept="image/jpg,image/jpeg,image/png,application/pdf" required>
                        <div style="font-size:11px;color:#9ca3af;margin-top:4px;">Format: JPG, PNG, PDF. Maks 5MB.</div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label" style="font-size:12px;">Catatan <span style="color:#9ca3af;">(opsional)</span></label>
                        <textarea name="catatan" class="form-control form-control-sm" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary-solid" id="btnSubmitUpload">Upload bukti</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Toast --}}
<div class="toast-wrapper" id="toastWrapper" style="display:none;">
    <div class="toast-msg" id="toastMsg"></div>
</div>

@push('scripts')
<script>
const paymentMethodInfo = @json($paymentMethodInfo ?? []);
const schoolName        = 'SMK TRAVINA PRIMA';
const defaultQrisImage  = '{{ asset('images/qr/qr.jpeg') }}';

/* ── Toast ── */
function showToast(msg, success = true) {
    const wrapper = document.getElementById('toastWrapper');
    const el = document.getElementById('toastMsg');
    el.textContent = (success ? '✓ ' : '✕ ') + msg;
    el.style.background = success ? '#0F6E56' : '#A32D2D';
    wrapper.style.display = 'block';
    setTimeout(() => { wrapper.style.display = 'none'; }, 4000);
}

/* ── Helpers ── */
function n(v) { return (v || '').toString().trim().toLowerCase(); }

function findPaymentMethod(name) {
    const target = n(name);
    return paymentMethodInfo.find(m => n(m.name) === target) || fallback(name);
}

function fallback(name) {
    const nm = n(name);
    if (!nm) return null;
    const banks   = ['BCA','BNI','BRI','Mandiri','BSI'];
    const wallets = ['OVO','GoPay','DANA','ShopeePay'];

    if (nm.includes('qris'))
        return { name:'QRIS', kode:'', atas_nama:schoolName, bank:'QRIS', qr:defaultQrisImage };
    if (nm.includes('tunai') || nm.includes('cash'))
        return { name:'Tunai', kode:'', atas_nama:schoolName, bank:'', qr:'' };
    if (nm.includes('virtual account') || nm.includes(' va')) {
        const bank = banks.find(b => nm.includes(n(b))) || 'Bank';
        return { name:bank+' Virtual Account', kode:'VA00870'+Math.floor(1e12+Math.random()*9e12), atas_nama:schoolName, bank:bank+' VA', qr:'' };
    }
    if (nm.includes('transfer') || banks.some(b => nm.includes(n(b)))) {
        const bank = banks.find(b => nm.includes(n(b))) || 'Bank';
        return { name:bank+' Transfer', kode:Math.floor(1e9+Math.random()*9e9).toString(), atas_nama:schoolName, bank, qr:'' };
    }
    if (wallets.some(w => nm.includes(n(w)))) {
        const wallet = wallets.find(w => nm.includes(n(w)));
        return { name:'E-Wallet — '+wallet, kode:Math.floor(1e9+Math.random()*9e9).toString(), atas_nama:schoolName, bank:wallet, qr:'' };
    }
    return null;
}

function formatRp(amount) {
    return 'Rp ' + parseInt(amount||0,10).toLocaleString('id-ID');
}

function copyToClipboard(text) {
    if (navigator.clipboard && window.isSecureContext)
        return navigator.clipboard.writeText(text);
    return new Promise((res, rej) => {
        const ta = Object.assign(document.createElement('textarea'), {
            value: text, readOnly: true,
            style: 'position:fixed;top:-9999px;left:-9999px'
        });
        document.body.appendChild(ta);
        ta.select();
        const ok = document.execCommand('copy');
        document.body.removeChild(ta);
        ok ? res() : rej();
    });
}

/* ── Fill method info panel ── */
function fillMethodInfo(prefix, name) {
    const isBayar = prefix === 'bayar';
    const box = document.getElementById(isBayar ? 'bayarMethodInfo' : 'uploadMethodInfo');
    if (!name) { box.style.display = 'none'; return; }

    const m = findPaymentMethod(name);
    box.style.display = '';

    setEl(isBayar ? 'bm_name'  : 'mi_name',  m ? m.name : name);
    showWrap(isBayar ? 'bm_bank_wrap' : 'mi_bank_wrap',
             isBayar ? 'bm_bank' : 'mi_bank', m && m.bank ? m.bank : null);
    showWrap(isBayar ? 'bm_atas_wrap' : 'mi_atas_wrap',
             isBayar ? 'bm_atas' : 'mi_atas', m && m.atas_nama ? m.atas_nama : schoolName, true);
    showCode(isBayar ? 'bm_kode_wrap' : 'mi_kode_wrap',
             isBayar ? 'bm_kode' : 'mi_kode', m && m.kode ? m.kode : null);
    showQr(  isBayar ? 'bm_qr_wrap' : 'mi_qr_wrap',
             isBayar ? 'bm_qr' : 'mi_qr', m && m.qr ? m.qr : defaultQrisImage);

    if (isBayar) {
        const hint = document.getElementById('bm_hint');
        if (hint) hint.style.display = m ? 'none' : '';
    }
}

function setEl(id, val) {
    const el = document.getElementById(id);
    if (el) el.textContent = val;
}
function showWrap(wrapId, valId, val, alwaysShow = false) {
    const wrap = document.getElementById(wrapId);
    const valEl = document.getElementById(valId);
    if (!wrap) return;
    if (val || alwaysShow) {
        wrap.style.display = '';
        if (valEl) valEl.textContent = val || '-';
    } else {
        wrap.style.display = 'none';
    }
}
function showCode(wrapId, valId, code) {
    const wrap = document.getElementById(wrapId);
    if (!wrap) return;
    if (code) {
        wrap.style.display = '';
        setEl(valId, code);
    } else {
        wrap.style.display = 'none';
    }
}
function showQr(wrapId, imgId, src) {
    const wrap = document.getElementById(wrapId);
    const img  = document.getElementById(imgId);
    if (!wrap) return;
    wrap.style.display = '';
    if (img) img.src = src || '';
}

/* ── Copy buttons ── */
function copyBayarCode(btn) { doCopy('bm_kode', btn); }
function copyMethodCode(btn) { doCopy('mi_kode', btn); }
function doCopy(id, btn) {
    const val = (document.getElementById(id)?.textContent || '').trim();
    if (!val || val === '-') return;
    const orig = btn.textContent;
    btn.textContent = 'Menyalin…';
    copyToClipboard(val)
        .then(() => { btn.textContent = '✓ Disalin'; showToast('Kode disalin.'); })
        .catch(() => { showToast('Gagal menyalin.', false); })
        .finally(() => setTimeout(() => { btn.textContent = orig; }, 1400));
}

/* ── Open modals ── */
function openBayarModal(btn) {
    document.getElementById('formBayar').reset();
    document.getElementById('bayar_payment_id').value  = btn.dataset.id;
    document.getElementById('bayar_jenis').textContent  = btn.dataset.jenis;
    document.getElementById('bayar_nominal').textContent = formatRp(btn.dataset.amount);
    document.getElementById('bayar_keterangan').textContent = btn.dataset.keterangan
        ? '— ' + btn.dataset.keterangan : 'Pilih metode pembayaran di bawah';
    fillMethodInfo('bayar', '');
    document.getElementById('btnSubmitBayar').disabled = false;
    new bootstrap.Modal(document.getElementById('bayarModal')).show();
}

function openUploadModal(btn) {
    document.getElementById('formUpload').reset();
    document.getElementById('upload_payment_id').value  = btn.dataset.id;
    document.getElementById('upload_jenis').textContent = 'Tagihan: ' + btn.dataset.jenis;
    fillMethodInfo('upload', '');
    new bootstrap.Modal(document.getElementById('uploadModal')).show();
}

/* ── Method change ── */
document.getElementById('bayar_payment_method').addEventListener('change', function() {
    fillMethodInfo('bayar', this.value);
});
document.getElementById('upload_payment_method').addEventListener('change', function() {
    fillMethodInfo('upload', this.value);
});

/* ── Parse response ── */
function parseRes(res) {
    return res.text().then(text => {
        let data = {};
        try { data = text ? JSON.parse(text) : {}; } catch(_) { data = { message:'Respons server tidak valid.' }; }
        if (!res.ok) { if (!data.message) data.message = 'Terjadi kesalahan pada server.'; throw data; }
        return data;
    });
}

/* ── Submit bayar ── */
document.getElementById('formBayar').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnSubmitBayar');
    btn.disabled = true; btn.textContent = 'Mengirim…';
    fetch('{{ route("siswa.bayar") }}', {
        method: 'POST', body: new FormData(this),
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(parseRes)
    .then(data => {
        showToast(data.message || 'Pembayaran berhasil dikirim.');
        bootstrap.Modal.getInstance(document.getElementById('bayarModal'))?.hide();
        setTimeout(() => location.reload(), 1200);
    })
    .catch(err => {
        showToast(err.message || 'Gagal kirim pembayaran.', false);
        btn.disabled = false; btn.textContent = 'Kirim pembayaran';
    });
});

/* ── Submit upload ── */
document.getElementById('formUpload').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnSubmitUpload');
    btn.disabled = true; btn.textContent = 'Mengunggah…';
    fetch('{{ route("siswa.upload-bukti") }}', {
        method: 'POST', body: new FormData(this),
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(parseRes)
    .then(data => {
        showToast(data.message || 'Bukti berhasil diupload.');
        bootstrap.Modal.getInstance(document.getElementById('uploadModal'))?.hide();
        setTimeout(() => location.reload(), 1200);
    })
    .catch(err => {
        showToast(err.message || 'Gagal upload bukti.', false);
        btn.disabled = false; btn.textContent = 'Upload bukti';
    });
});
</script>
@endpush

@endsection