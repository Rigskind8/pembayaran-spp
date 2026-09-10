{{-- resources/views/students/pembayaran.blade.php --}}
@extends('layouts.app')

@section('title', 'Pembayaran SPP - ' . config('app.name', 'SMK TRAVINA PRIMA'))

@push('styles')
<style>
    :root {
        --primary:        #2563eb;
        --primary-dark:   #1d4ed8;
        --primary-light:  #eff6ff;
        --primary-border: #bfdbfe;
        --line:           #e2e8f0;
        --text-main:      #0f172a;
        --text-muted:     #64748b;
        --card-bg:        #ffffff;
        --shadow-soft:    0 10px 25px -5px rgba(15, 23, 42, .06), 0 8px 10px -6px rgba(15, 23, 42, .04);
    }

    .payment-wrap {
        padding: 24px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ── HERO BANNER ── */
    .hero-payment {
        background: linear-gradient(135deg, #1e40af 0%, #2563eb 60%, #3b82f6 100%);
        border-radius: 20px;
        padding: 24px 28px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 16px 36px rgba(37, 99, 235, .24);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .hero-payment::after {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .08);
        pointer-events: none;
    }

    .hero-kicker {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, .75);
        margin-bottom: 4px;
    }

    .hero-title {
        font-size: 24px;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 4px;
        letter-spacing: -.02em;
    }

    .hero-sub {
        font-size: 14px;
        color: rgba(255, 255, 255, .85);
        margin: 0;
    }

    .btn-pdf-hero {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        color: var(--primary);
        border: none;
        border-radius: 999px;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
        transition: all .2s ease;
    }

    .btn-pdf-hero:hover {
        background: #f8fafc;
        transform: translateY(-2px);
        color: var(--primary-dark);
    }

    /* ── STAT GRID ── */
    .stat-grid-modern {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    @media (max-width: 992px) {
        .stat-grid-modern { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 520px) {
        .stat-grid-modern { grid-template-columns: 1fr; }
    }

    .stat-card-pay {
        background: var(--card-bg);
        border: 1px solid var(--line);
        border-radius: 18px;
        padding: 18px 20px;
        box-shadow: var(--shadow-soft);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .stat-card-pay:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 28px -4px rgba(15, 23, 42, .1);
    }

    .stat-icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-icon-red    { background: #fef2f2; color: #dc2626; }
    .stat-icon-amber  { background: #fffbeb; color: #d97706; }
    .stat-icon-green  { background: #ecfdf5; color: #059669; }
    .stat-icon-blue   { background: #eff6ff; color: #2563eb; }

    .stat-val-text {
        font-size: 22px;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 4px;
    }

    .stat-label-text {
        font-size: 11px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    /* ── SECTION CARDS ── */
    .section-box {
        background: var(--card-bg);
        border: 1px solid var(--line);
        border-radius: 20px;
        box-shadow: var(--shadow-soft);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .section-box-head {
        padding: 16px 22px;
        background: #f8fafc;
        border-bottom: 1px solid var(--line);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .section-box-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-box-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }

    .section-box-title {
        font-size: 16px;
        font-weight: 800;
        color: var(--text-main);
        margin: 0;
    }

    /* ── TABLE ── */
    .table-pay {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .table-pay thead th {
        background: #f8fafc;
        color: var(--text-muted);
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .06em;
        padding: 14px 20px;
        border-bottom: 1px solid var(--line);
    }

    .table-pay tbody td {
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
        vertical-align: middle;
        color: var(--text-main);
    }

    .table-pay tbody tr:hover td {
        background: #f8fbff;
    }

    .table-pay tbody tr:last-child td {
        border-bottom: none;
    }

    /* ── PILLS ── */
    .pill-custom {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .pill-spp     { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .pill-seragam { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
    .pill-uts     { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .pill-uas     { background: #faf5ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    .pill-default { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

    .badge-status-unpaid  { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .badge-status-pending { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
    .badge-status-paid    { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }

    /* ── ACTION BUTTONS ── */
    .btn-action-pay {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        background: var(--primary);
        color: #ffffff;
        border: none;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all .15s ease;
    }

    .btn-action-pay:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        color: #ffffff;
    }

    .btn-action-bukti {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        background: #ffffff;
        color: var(--text-muted);
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all .15s ease;
    }

    .btn-action-bukti:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: #f8fbff;
    }

    .reject-box {
        font-size: 11px;
        color: #b91c1c;
        background: #fef2f2;
        border-radius: 6px;
        padding: 4px 8px;
        margin-top: 4px;
        border: 1px solid #fecaca;
    }

    /* ── EMPTY STATE ── */
    .empty-box {
        text-align: center;
        padding: 40px 20px;
        color: var(--text-muted);
    }

    .empty-box-icon {
        width: 48px;
        height: 48px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 20px;
        color: #94a3b8;
    }

    /* ── MODAL MODERN ── */
    .modal-content {
        border: 1px solid var(--line);
        border-radius: 20px;
        box-shadow: 0 24px 60px rgba(15, 23, 42, .2);
        overflow: hidden;
    }

    .modal-header {
        background: #f8fafc;
        border-bottom: 1px solid var(--line);
        padding: 16px 20px;
    }

    .modal-title {
        font-size: 16px;
        font-weight: 800;
        color: var(--text-main);
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        background: #f8fafc;
        border-top: 1px solid var(--line);
        padding: 14px 20px;
    }

    .info-box-highlight {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 16px;
    }

    .info-box-tag {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--primary);
        margin-bottom: 2px;
    }

    .info-box-amount {
        font-size: 22px;
        font-weight: 800;
        color: var(--primary-dark);
    }

    .info-box-desc {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .method-detail-card {
        background: #f8fafc;
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 14px;
    }

    .code-salin-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: 8px;
        padding: 8px 12px;
        margin-top: 6px;
    }

    .code-salin-val {
        font-size: 14px;
        font-weight: 800;
        font-family: monospace;
        color: #0f172a;
    }

    .btn-salin {
        background: none;
        border: none;
        color: var(--primary);
        font-weight: 700;
        font-size: 12px;
        cursor: pointer;
    }

    .qr-container {
        text-align: center;
        margin-top: 12px;
        padding: 12px;
        background: #ffffff;
        border: 1px solid var(--line);
        border-radius: 12px;
    }

    .qr-container img {
        width: 190px;
        max-width: 100%;
        border-radius: 8px;
    }

    /* ── TOAST ── */
    .toast-wrapper {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 9999;
    }

    .toast-msg {
        padding: 12px 20px;
        border-radius: 10px;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .2);
        max-width: 340px;
    }
</style>
@endpush

@section('content')
<div class="payment-wrap">

    {{-- ══ HERO BANNER ══ --}}
    <div class="hero-payment">
        <div>
            <div class="hero-kicker">Portal Keuangan Siswa · SMK Travina Prima</div>
            <h1 class="hero-title">Status Tagihan & Pembayaran SPP</h1>
            <p class="hero-sub">Nama Siswa: <strong>{{ $student->name }}</strong> (Kelas {{ $student->class_id }} · NIS {{ $student->nis }})</p>
        </div>
        <a href="{{ route('siswa.pembayaran.pdf') }}" class="btn-pdf-hero">
            <i class="fas fa-file-pdf text-danger fs-5"></i> Unduh Rekap PDF
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center mb-4" style="border-radius: 14px;">
            <i class="fas fa-check-circle me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center mb-4" style="border-radius: 14px;">
            <i class="fas fa-exclamation-circle me-2 fs-5"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    {{-- ── STAT CARDS ── --}}
    <div class="stat-grid-modern">
        <div class="stat-card-pay">
            <div class="stat-icon-circle stat-icon-red"><i class="fas fa-circle-xmark"></i></div>
            <div>
                <div class="stat-val-text text-danger">{{ $tagihan->where('status','unpaid')->count() }}</div>
                <div class="stat-label-text">Belum Bayar</div>
            </div>
        </div>
        <div class="stat-card-pay">
            <div class="stat-icon-circle stat-icon-amber"><i class="fas fa-hourglass-half"></i></div>
            <div>
                <div class="stat-val-text text-warning">{{ $tagihan->where('status','pending')->count() }}</div>
                <div class="stat-label-text">Menunggu Verif</div>
            </div>
        </div>
        <div class="stat-card-pay">
            <div class="stat-icon-circle stat-icon-green"><i class="fas fa-circle-check"></i></div>
            <div>
                <div class="stat-val-text text-success">{{ $riwayat->whereIn('status',['approved','paid'])->count() }}</div>
                <div class="stat-label-text">Sudah Lunas</div>
            </div>
        </div>
        <div class="stat-card-pay">
            <div class="stat-icon-circle stat-icon-blue"><i class="fas fa-wallet"></i></div>
            <div>
                <div class="stat-val-text text-primary" style="font-size: 17px;">
                    Rp {{ number_format($riwayat->whereIn('status',['approved','paid'])->sum('amount'), 0, ',', '.') }}
                </div>
                <div class="stat-label-text">Total Terbayar</div>
            </div>
        </div>
    </div>

    {{-- ── TAGIHAN AKTIF ── --}}
    <div class="section-box">
        <div class="section-box-head">
            <div class="section-box-left">
                <span class="section-box-icon"><i class="fas fa-receipt"></i></span>
                <h2 class="section-box-title">Tagihan Aktif Siswa</h2>
            </div>
            @if($tagihan->count() > 0)
                <span class="badge bg-danger rounded-pill px-3 py-2 fw-bold">{{ $tagihan->count() }} Tagihan Perlu Tindakan</span>
            @endif
        </div>

        @if($tagihan->isEmpty())
            <div class="empty-box">
                <div class="empty-box-icon"><i class="fas fa-circle-check text-success"></i></div>
                <h5 class="fw-bold text-dark mb-1">Semua Tagihan Sudah Lunas!</h5>
                <p class="text-muted mb-0">Tidak ada tagihan tertunggak untuk saat ini.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table-pay">
                    <thead>
                        <tr>
                            <th>Jenis Pembayaran</th>
                            <th>Keterangan</th>
                            <th>Periode</th>
                            <th>Nominal</th>
                            <th>Status Tagihan</th>
                            <th style="text-align:right;">Aksi Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tagihan as $t)
                        @php
                            $jenis = $t->jenis_tagihan ?? $t->type;
                            $pillMap = ['SPP' => 'pill-spp', 'Seragam' => 'pill-seragam', 'UTS' => 'pill-uts', 'UAS' => 'pill-uas'];
                            $pillClass = $pillMap[$jenis] ?? 'pill-default';
                        @endphp
                        <tr>
                            <td><span class="pill-custom {{ $pillClass }}">{{ $jenis }}</span></td>
                            <td class="text-muted">{{ $t->keterangan ?: '-' }}</td>
                            <td><strong>{{ $t->month }} {{ $t->year }}</strong></td>
                            <td class="fw-bold text-dark fs-6">Rp {{ number_format($t->amount, 0, ',', '.') }}</td>
                            <td>
                                @if($t->status === 'unpaid')
                                    <span class="pill-custom badge-status-unpaid"><i class="fas fa-times-circle"></i> Belum Bayar</span>
                                    @if($t->catatan_reject)
                                        <div class="reject-box"><i class="fas fa-info-circle me-1"></i> {{ $t->catatan_reject }}</div>
                                    @endif
                                @elseif($t->status === 'pending')
                                    <span class="pill-custom badge-status-pending"><i class="fas fa-clock"></i> Menunggu Verifikasi</span>
                                @endif
                            </td>
                            <td style="text-align:right;">
                                @if(in_array($t->status, ['unpaid','pending']))
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn-action-pay"
                                            data-id="{{ $t->id }}"
                                            data-jenis="{{ $jenis }}"
                                            data-keterangan="{{ $t->keterangan ?? '' }}"
                                            data-amount="{{ $t->amount }}"
                                            onclick="openBayarModal(this)">
                                            <i class="fas fa-credit-card"></i> Bayar
                                        </button>
                                        <button type="button" class="btn-action-bukti"
                                            data-id="{{ $t->id }}"
                                            data-jenis="{{ $jenis }}"
                                            onclick="openUploadModal(this)">
                                            <i class="fas fa-paperclip"></i> Upload Bukti
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

    {{-- ── RIWAYAT PEMBAYARAN ── --}}
    <div class="section-box">
        <div class="section-box-head">
            <div class="section-box-left">
                <span class="section-box-icon"><i class="fas fa-clock-rotate-left"></i></span>
                <h2 class="section-box-title">Riwayat Pembayaran Terverifikasi</h2>
            </div>
            <span class="badge bg-light text-dark border px-3 py-2 fw-bold">{{ $riwayat->count() }} Transaksi Sukses</span>
        </div>

        @if($riwayat->isEmpty())
            <div class="empty-box">
                <div class="empty-box-icon"><i class="fas fa-receipt"></i></div>
                <h5 class="fw-bold text-dark mb-1">Belum Ada Riwayat Transaksi</h5>
                <p class="text-muted mb-0">Pembayaran yang telah disetujui akan ditampilkan di sini.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table-pay">
                    <thead>
                        <tr>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>Periode</th>
                            <th>Nominal</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Tanggal Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $r)
                        <tr>
                            <td><span class="pill-custom pill-default">{{ $r->jenis_tagihan ?? $r->type ?? '-' }}</span></td>
                            <td class="text-muted">{{ $r->keterangan ?: '-' }}</td>
                            <td>{{ $r->month }} {{ $r->year }}</td>
                            <td class="fw-bold text-dark">Rp {{ number_format($r->amount, 0, ',', '.') }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $r->payment_method ?? '-' }}</span></td>
                            <td>
                                @if(in_array($r->status, ['approved','paid']))
                                    <span class="pill-custom badge-status-paid"><i class="fas fa-check-circle"></i> Lunas</span>
                                @elseif($r->status === 'pending')
                                    <span class="pill-custom badge-status-pending"><i class="fas fa-clock"></i> Pending</span>
                                @else
                                    <span class="pill-custom pill-default">{{ $r->status }}</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $r->created_at->format('d M Y, H:i') }} WIB</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

{{-- ══════════════════════════════════════
     MODAL BAYAR
══════════════════════════════════════ --}}
<div class="modal fade" id="bayarModal" tabindex="-1" aria-labelledby="bayarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bayarModalLabel"><i class="fas fa-credit-card me-2 text-primary"></i> Konfirmasi Pembayaran Tagihan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formBayar">
                @csrf
                <input type="hidden" id="bayar_payment_id" name="payment_id">
                <div class="modal-body">
                    <div class="info-box-highlight">
                        <div class="info-box-tag" id="bayar_jenis"></div>
                        <div class="info-box-amount" id="bayar_nominal"></div>
                        <div class="info-box-desc" id="bayar_keterangan"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Pilih Metode Pembayaran <span class="text-danger">*</span></label>
                        <select name="payment_method" id="bayar_payment_method" class="form-select" required>
                            <option value="">-- Pilih Metode --</option>
                            @if(($paymentMethods ?? collect())->count() > 0)
                                @foreach($paymentMethods as $method)
                                    <option value="{{ $method->name }}">{{ $method->name }}</option>
                                @endforeach
                            @else
                                <option value="Transfer BCA">Transfer BCA</option>
                                <option value="Transfer BNI">Transfer BNI</option>
                                <option value="Transfer BRI">Transfer BRI</option>
                                <option value="Transfer Mandiri">Transfer Mandiri</option>
                                <option value="QRIS">QRIS</option>
                                <option value="Tunai">Tunai / Loket</option>
                            @endif
                        </select>
                    </div>

                    <div id="bayarMethodInfo" class="method-detail-card" style="display:none;">
                        <div class="fw-bold text-dark mb-2 small"><i class="fas fa-building-columns text-primary me-1"></i> Rekening Resmi SMK Travina Prima</div>
                        <div class="small mb-1"><strong>Metode:</strong> <span id="bm_name">-</span></div>
                        <div class="small mb-1" id="bm_bank_wrap" style="display:none;"><strong>Bank:</strong> <span id="bm_bank">-</span></div>
                        <div class="small mb-2" id="bm_atas_wrap" style="display:none;"><strong>Atas Nama:</strong> <span id="bm_atas">-</span></div>
                        <div id="bm_kode_wrap" style="display:none;">
                            <div class="small text-muted mb-1">Nomor Rekening / Kode Bayar:</div>
                            <div class="code-salin-box">
                                <span id="bm_kode" class="code-salin-val">-</span>
                                <button type="button" class="btn-salin" onclick="copyBayarCode(this)"><i class="fas fa-copy me-1"></i> Salin</button>
                            </div>
                        </div>
                        <div id="bm_qr_wrap" class="qr-container" style="display:none;">
                            <img id="bm_qr" src="" alt="QRIS">
                            <div class="small text-muted mt-2">Scan kode QRIS di atas untuk melakukan transfer</div>
                        </div>
                        <div id="bm_hint" style="display:none; font-size:11px; color:#b45309; margin-top:6px;">Detail metode belum lengkap. Hubungi bendahara sekolah.</div>
                    </div>

                    <div class="mb-1">
                        <label class="form-label small text-muted">Catatan Tambahan (Opsional)</label>
                        <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: Sudah transfer atas nama Ayah / Wali"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary fw-bold" id="btnSubmitBayar">Kirim Konfirmasi Bayar</button>
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
                <h5 class="modal-title" id="uploadModalLabel"><i class="fas fa-upload me-2 text-primary"></i> Upload Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formUpload" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="upload_payment_id" name="payment_id">
                <div class="modal-body">
                    <div class="info-box-highlight">
                        <div class="info-box-tag" id="upload_jenis"></div>
                        <div class="info-box-amount" style="font-size: 16px;">Lampirkan Bukti Transfer</div>
                        <div class="info-box-desc">Format file: JPG, PNG, atau PDF (Maksimal 5MB)</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Metode Pembayaran Yang Digunakan <span class="text-danger">*</span></label>
                        <select name="payment_method" id="upload_payment_method" class="form-select" required>
                            <option value="">-- Pilih Metode --</option>
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
                                <option value="QRIS">QRIS</option>
                                <option value="Tunai">Tunai</option>
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

                    <div id="uploadMethodInfo" class="method-detail-card" style="display:none;">
                        <div class="fw-bold text-dark mb-2 small"><i class="fas fa-building-columns text-primary me-1"></i> Rekening Tujuan</div>
                        <div class="small mb-1"><strong>Metode:</strong> <span id="mi_name">-</span></div>
                        <div class="small mb-1" id="mi_bank_wrap" style="display:none;"><strong>Bank:</strong> <span id="mi_bank">-</span></div>
                        <div class="small mb-2" id="mi_atas_wrap" style="display:none;"><strong>Atas Nama:</strong> <span id="mi_atas">-</span></div>
                        <div id="mi_kode_wrap" style="display:none;">
                            <div class="small text-muted mb-1">Nomor Rekening Tujuan:</div>
                            <div class="code-salin-box">
                                <span id="mi_kode" class="code-salin-val">-</span>
                                <button type="button" class="btn-salin" onclick="copyMethodCode(this)"><i class="fas fa-copy me-1"></i> Salin</button>
                            </div>
                        </div>
                        <div id="mi_qr_wrap" class="qr-container" style="display:none;">
                            <img id="mi_qr" src="" alt="QRIS">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">File Bukti Struk / Screenshot <span class="text-danger">*</span></label>
                        <input type="file" name="proof" class="form-control" accept="image/jpg,image/jpeg,image/png,application/pdf" required>
                    </div>

                    <div class="mb-1">
                        <label class="form-label small text-muted">Catatan (Opsional)</label>
                        <textarea name="catatan" class="form-control" rows="2" placeholder="Tuliskan keterangan jika ada"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary fw-bold" id="btnSubmitUpload">Upload File Bukti</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Toast Notification --}}
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
    el.style.background = success ? '#059669' : '#dc2626';
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
    const orig = btn.innerHTML;
    btn.innerHTML = '✓ Disalin';
    copyToClipboard(val)
        .then(() => { showToast('Kode berhasil disalin.'); })
        .catch(() => { showToast('Gagal menyalin kode.', false); })
        .finally(() => setTimeout(() => { btn.innerHTML = orig; }, 1400));
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
        btn.disabled = false; btn.textContent = 'Kirim konfirmasi bayar';
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
        btn.disabled = false; btn.textContent = 'Upload File Bukti';
    });
});
</script>
@endpush

@endsection