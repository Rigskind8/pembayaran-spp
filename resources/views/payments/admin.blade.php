@extends('layouts.app')

@section('title', 'Manage Pembayaran SPP - Travina Prima')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
    --sb: 64px; --sb-open: 220px;
    --bg: #f4f6fa; --card: #fff; --border: #e8eaf0;
    --txt: #111827; --txt2: #6b7280; --txt3: #9ca3af;
    --blue: #2563eb; --blue-bg: #eff6ff;
    --green: #059669; --green-bg: #ecfdf5;
    --red: #dc2626; --red-bg: #fef2f2;
    --amber: #d97706; --amber-bg: #fffbeb;
    --orange: #ea580c; --orange-bg: #fff7ed;
    --sb-bg: #0f1117;
    --r: 16px;
    --shadow: 0 1px 3px rgba(0,0,0,.06), 0 2px 8px rgba(0,0,0,.04);
    --shadow-md: 0 4px 16px rgba(0,0,0,.08);
}
body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--txt); -webkit-font-smoothing: antialiased; }
.app { display: flex; min-height: 100vh; }
.main { margin-left: var(--sb); flex: 1; display: flex; flex-direction: column; }

/* SIDEBAR */
.sb { width: var(--sb); background: var(--sb-bg); position: fixed; top: 0; left: 0; height: 100vh; z-index: 200; display: flex; flex-direction: column; align-items: center; padding: 16px 0 20px; transition: width .28s cubic-bezier(.4,0,.2,1); overflow: hidden; border-right: 1px solid #1a1d27; }
.sb:hover { width: var(--sb-open); align-items: flex-start; }
.sb-brand { display: flex; align-items: center; gap: 10px; padding: 4px 14px; width: 100%; min-height: 44px; margin-bottom: 20px; }
.sb-mark { width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0; background: var(--blue); display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; }
.sb-name { font-size: 13px; font-weight: 700; color: white; white-space: nowrap; opacity: 0; transition: opacity .2s; }
.sb:hover .sb-name { opacity: 1; }
.sb-nav { width: 100%; padding: 0 10px; flex: 1; display: flex; flex-direction: column; gap: 2px; }
.sb-grp { font-size: 9px; font-weight: 700; letter-spacing: .14em; color: #374151; text-transform: uppercase; padding: 12px 8px 4px; white-space: nowrap; opacity: 0; transition: opacity .2s; }
.sb:hover .sb-grp { opacity: 1; }
.sb-a { display: flex; align-items: center; gap: 10px; padding: 8px 9px; border-radius: 10px; color: #6b7280; font-size: 13px; font-weight: 500; text-decoration: none; white-space: nowrap; transition: all .15s; position: relative; }
.sb-a .ic { width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 13px; color: #4b5163; transition: all .15s; position: relative; }
.sb-a:hover { color: #d1d5db; }
.sb-a:hover .ic { background: #1c1f2e; color: #9ca3af; }
.sb-a.on { color: white; }
.sb-a.on .ic { background: var(--orange); color: white; box-shadow: 0 4px 10px rgba(234,88,12,.3); }
.sb-lbl { opacity: 0; transition: opacity .18s; pointer-events: none; white-space: nowrap; display: flex; align-items: center; gap: 6px; }
.sb:hover .sb-lbl { opacity: 1; pointer-events: auto; }
.sb-foot { width: 100%; padding: 0 10px; margin-top: auto; border-top: 1px solid #1a1d27; padding-top: 14px; }
.sb-user { display: flex; align-items: center; gap: 9px; padding: 9px; border-radius: 10px; background: rgba(255,255,255,.04); margin-bottom: 6px; }
.sb-av { width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0; background: var(--orange); color: white; font-weight: 800; font-size: 14px; display: flex; align-items: center; justify-content: center; }
.sb-uname { font-size: 12px; font-weight: 700; color: #f1f5f9; }
.sb-urole { font-size: 10px; color: #6b7280; }
.sb-out { display: flex; align-items: center; gap: 10px; padding: 9px; border-radius: 10px; background: transparent; border: none; color: #ef4444; font-size: 12px; font-weight: 600; cursor: pointer; width: 100%; font-family: inherit; white-space: nowrap; transition: background .15s; }
.sb-out:hover { background: rgba(239,68,68,.1); }
.sb-out .ic { width: 34px; height: 34px; border-radius: 9px; background: rgba(239,68,68,.08); display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0; }
.sb-badge { background: #ef4444; color: white; font-size: 9px; font-weight: 800; padding: 2px 6px; border-radius: 999px; line-height: 1.4; flex-shrink: 0; }
.pending-dot { position: absolute; top: 4px; right: 4px; width: 8px; height: 8px; background: #ef4444; border-radius: 50%; border: 1.5px solid var(--sb-bg); display: none; }

/* TOPBAR */
.topbar { display: flex; align-items: center; justify-content: space-between; padding: 14px 28px; background: rgba(244,246,250,.95); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; }
.top-title { font-size: 18px; font-weight: 800; color: var(--txt); letter-spacing: -.3px; }
.top-sub { font-size: 12px; color: var(--txt2); margin-top: 1px; }
.top-r { display: flex; gap: 8px; align-items: center; }

/* PAGE */
.page { padding: 28px; flex: 1; }
.pg-title { font-size: 22px; font-weight: 800; color: var(--txt); }
.pg-sub { font-size: 13px; color: var(--txt2); margin-top: 2px; margin-bottom: 24px; }

/* BUTTONS */
.btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 9px; font-size: 13px; font-weight: 700; cursor: pointer; border: none; font-family: inherit; transition: all .15s; text-decoration: none; }
.btn-blue   { background: var(--blue);  color: white; }
.btn-blue:hover   { background: #1d4ed8; }
.btn-green  { background: var(--green); color: white; }
.btn-green:hover  { background: #047857; }
.btn-red    { background: var(--red);   color: white; }
.btn-red:hover    { background: #b91c1c; }
.btn-amber  { background: var(--amber); color: white; }
.btn-amber:hover  { background: #b45309; }
.btn-outline { background: white; color: var(--txt2); border: 1px solid var(--border); }
.btn-outline:hover { border-color: var(--blue); color: var(--blue); }
.btn-sm { padding: 5px 10px; font-size: 12px; }

/* STATS */
.stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
.stat-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); padding: 18px 20px; box-shadow: var(--shadow); display: flex; align-items: center; gap: 14px; }
.stat-ic { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
.stat-val { font-size: 20px; font-weight: 800; color: var(--txt); line-height: 1; }
.stat-lbl { font-size: 11px; color: var(--txt2); margin-top: 3px; font-weight: 600; }
.stat-card.highlight-pending { border-color: #fde68a; background: #fffbeb; }
.stat-card.highlight-pending .stat-val { color: var(--amber); }

/* TABLE */
.table-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); box-shadow: var(--shadow); overflow: hidden; margin-bottom: 24px; }
.tc-head { padding: 18px 22px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
.tc-title { font-size: 15px; font-weight: 800; color: var(--txt); }
.tc-sub { font-size: 11px; color: var(--txt2); margin-top: 2px; }
table { width: 100%; border-collapse: collapse; }
thead th { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--txt3); padding: 10px 20px; text-align: left; background: #fafafa; border-bottom: 1px solid var(--border); }
tbody td { padding: 12px 20px; font-size: 13px; color: var(--txt); border-bottom: 1px solid #f5f5f7; vertical-align: middle; }
tbody tr:last-child td { border-bottom: none; }
tbody tr:hover td { background: #fafbff; }
tbody tr.row-pending td { background: #fffdf0; }
tbody tr.row-pending:hover td { background: #fff9e0; }
.pagination { display: flex; flex-wrap: wrap; align-items: center; gap: 0.35rem; margin: 0; padding: 0; list-style: none; }
.pagination .page-item { margin: 0; }
.pagination .page-link { min-width: 40px; padding: 8px 12px; border-radius: 12px; border: 1px solid rgba(148,163,184,.35); color: #0f172a; background: #ffffff; transition: all .15s ease; }
.pagination .page-link:hover { background: #f8fafc; }
.pagination .page-item.active .page-link { background: #2563eb; border-color: #2563eb; color: #ffffff; box-shadow: 0 12px 24px rgba(37,99,235,.12); }
.pagination .page-item.disabled .page-link { background: #f8fafc; border-color: #e2e8f0; color: #94a3b8; cursor: not-allowed; }
.pagination .page-item.disabled .page-link:hover { background: #f8fafc; }
.pagination .page-link svg, .pagination .page-link i { vertical-align: middle; }

/* BADGES */
.badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 99px; font-size: 11px; font-weight: 700; }
.badge-approved { background: var(--green-bg); color: var(--green); }
.badge-paid     { background: var(--blue-bg);  color: var(--blue);  }
.badge-pending  { background: var(--amber-bg); color: var(--amber); }
.badge-unpaid   { background: var(--red-bg);   color: var(--red);   }
.badge-rejected { background: var(--red-bg);   color: var(--red);   }

/* PROOF */
.proof-thumb { width: 36px; height: 36px; border-radius: 8px; object-fit: cover; cursor: pointer; border: 1px solid var(--border); transition: transform .15s; }
.proof-thumb:hover { transform: scale(1.1); }
.action-row { display: flex; gap: 6px; flex-wrap: wrap; }

/* LIGHTBOX */
.lightbox { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.85); z-index: 2000; align-items: center; justify-content: center; }
.lightbox.show { display: flex; }
.lightbox img { max-width: 90vw; max-height: 90vh; border-radius: 12px; }
.lightbox-close { position: absolute; top: 20px; right: 24px; color: white; font-size: 32px; cursor: pointer; background: none; border: none; line-height: 1; }

/* MODAL REJECT */
.modal-bg { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 1000; align-items: center; justify-content: center; }
.modal-bg.show { display: flex; }
.modal { background: white; border-radius: 20px; padding: 28px; width: 100%; max-width: 420px; box-shadow: 0 20px 60px rgba(0,0,0,.15); }
.modal-title { font-size: 17px; font-weight: 800; color: var(--txt); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
.form-group label { display: block; font-size: 12px; font-weight: 700; color: var(--txt2); margin-bottom: 6px; text-transform: uppercase; letter-spacing: .06em; }
.form-group textarea { width: 100%; border: 1.5px solid var(--border); border-radius: 10px; padding: 10px 14px; font-size: 13px; font-family: inherit; outline: none; resize: vertical; min-height: 80px; }
.form-group textarea:focus { border-color: var(--red); }
.modal-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 16px; }

/* EMPTY */
.empty-state { padding: 50px 20px; text-align: center; color: var(--txt3); }
.empty-state i { font-size: 40px; margin-bottom: 12px; display: block; }
.empty-state p { font-size: 13px; }

/* TOASTS */
.toasts { position: fixed; bottom: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 8px; }
.toast { display: flex; align-items: center; gap: 10px; padding: 12px 16px; background: white; border-radius: 12px; box-shadow: var(--shadow-md); border: 1px solid var(--border); min-width: 260px; animation: tIn .25s ease; }
@keyframes tIn { from{opacity:0;transform:translateX(30px)} to{opacity:1;transform:none} }
.toast.hide { opacity: 0; transform: translateX(30px); transition: all .25s; }
.t-ic { width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 14px; }
.t-ic.s { background: var(--green-bg); color: var(--green); }
.t-ic.e { background: var(--red-bg); color: var(--red); }
.t-ttl { font-size: 12.5px; font-weight: 700; color: var(--txt); }
.t-msg { font-size: 11px; color: var(--txt2); }

@media(max-width:900px) { .stats-row{grid-template-columns:repeat(2,1fr);} }
@media(max-width:640px) { .sb{display:none;} .main{margin-left:0;} .page{padding:16px;} }
</style>

<div class="toasts" id="toasts"></div>

<div class="app">
    {{-- ===== SIDEBAR ===== --}}
    @include('partials.sidebar')

    <div class="main">
        <header class="topbar">
            <div>
                <div class="top-title">
                    Pembayaran SPP
                    @if($totalPending > 0)
                    <span style="background:var(--amber-bg);color:var(--amber);border:1px solid #fde68a;font-size:11px;font-weight:700;padding:3px 10px;border-radius:99px;margin-left:8px;vertical-align:middle;">
                        <i class="fas fa-clock" style="font-size:9px;"></i>
                        {{ $totalPending }} Menunggu Verifikasi
                    </span>
                    @endif
                </div>
                <div class="top-sub">{{ date('d M Y') }}</div>
            </div>
            <div class="top-r">
                @if($totalPending > 0)
                <form action="{{ route('payments.bulkApprove') }}" method="POST"
                      onsubmit="return confirm('Approve semua {{ $totalPending }} pembayaran pending?')">
                    @csrf
                    <button type="submit" class="btn btn-green">
                        <i class="fas fa-check-double"></i> Approve Semua ({{ $totalPending }})
                    </button>
                </form>
                @endif
            </div>
        </header>

        <div class="page">
            {{-- STATS — variabel dari controller, bukan query di blade --}}
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-ic" style="background:var(--green-bg);color:var(--green);"><i class="fas fa-circle-check"></i></div>
                    <div>
                        <div class="stat-val">{{ $totalApproved }}</div>
                        <div class="stat-lbl">Lunas / Approved</div>
                    </div>
                </div>
                <div class="stat-card {{ $totalPending > 0 ? 'highlight-pending' : '' }}">
                    <div class="stat-ic" style="background:var(--amber-bg);color:var(--amber);"><i class="fas fa-clock"></i></div>
                    <div>
                        <div class="stat-val">{{ $totalPending }}</div>
                        <div class="stat-lbl">
                            Menunggu Verifikasi
                            @if($totalPending > 0)
                            <span style="display:block;font-size:10px;color:var(--amber);margin-top:2px;">⚠ Perlu tindakan</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ic" style="background:var(--red-bg);color:var(--red);"><i class="fas fa-circle-xmark"></i></div>
                    <div>
                        <div class="stat-val">{{ $totalUnpaid }}</div>
                        <div class="stat-lbl">Belum Bayar</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ic" style="background:var(--blue-bg);color:var(--blue);"><i class="fas fa-coins"></i></div>
                    <div>
                        <div class="stat-val">Rp {{ number_format($totalNominal, 0, ',', '.') }}</div>
                        <div class="stat-lbl">Total Pemasukan</div>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="table-card">
                <div class="tc-head">
                    <div>
                        <div class="tc-title">Semua Transaksi</div>
                        <div class="tc-sub">{{ $payments->total() }} total data &middot; Halaman {{ $payments->currentPage() }}</div>
                    </div>
                </div>

                @if($payments->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Siswa</th>
                            <th>Rincian Tagihan</th>
                            <th>Nominal</th>
                            <th>Metode</th>
                            <th>Bukti</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $i => $p)
                        <tr class="{{ $p->status === 'pending' ? 'row-pending' : '' }}">
                            <td style="color:var(--txt3);">{{ ($payments->currentPage()-1)*$payments->perPage() + $i + 1 }}</td>
                            <td><strong>{{ $p->student->name ?? '-' }}</strong></td>
                            <td>
                                <div style="font-weight: 700;">{{ $p->jenis_tagihan ?? $p->type ?? 'Pembayaran' }}</div>
                                <div style="font-size: 12px; color: var(--txt2); margin-top: 2px;">
                                    {{ $p->month }} {{ $p->year }}
                                    @if($p->keterangan || $p->catatan)
                                        <div style="color: var(--txt3); font-style: italic; font-size: 11px; margin-top: 3px;">"{{ $p->keterangan ?: $p->catatan }}"</div>
                                    @endif
                                </div>
                            </td>
                            <td><strong>Rp {{ number_format($p->amount, 0, ',', '.') }}</strong></td>
                            <td style="color:var(--txt2);">{{ $p->payment_method ?? '-' }}</td>
                            <td>
                                @if($p->proof)
                                    @if(str_ends_with(strtolower($p->proof), '.pdf'))
                                        <a href="{{ Storage::url($p->proof) }}" target="_blank" class="btn btn-outline btn-sm">
                                            <i class="fas fa-file-pdf"></i> PDF
                                        </a>
                                    @else
                                        <img src="{{ Storage::url($p->proof) }}"
                                             class="proof-thumb"
                                             onclick="showLightbox('{{ Storage::url($p->proof) }}')"
                                             alt="Bukti">
                                    @endif
                                @else
                                    <span style="color:var(--txt3);font-size:12px;">—</span>
                                @endif
                            </td>
                            <td>
                                @if(in_array($p->status, ['paid', 'approved']))
                                    <span class="badge badge-approved">
                                        <i class="fas fa-check-circle"></i> Lunas
                                    </span>
                                    <div style="font-size:11px; color:var(--txt3); margin-top:4px;">Pembayaran selesai</div>
                                @elseif($p->status === 'pending')
                                    <span class="badge badge-pending">
                                        <i class="fas fa-hourglass-half"></i> Menunggu Verifikasi
                                    </span>
                                    <div style="font-size:11px; color:var(--amber); margin-top:4px;">Perlu tindakan admin</div>
                                @elseif($p->status === 'rejected')
                                    <span class="badge badge-rejected">
                                        <i class="fas fa-ban"></i> Ditolak
                                    </span>
                                    <div style="font-size:11px; color:var(--red); margin-top:4px;">Menunggu siswa upload ulang</div>
                                @else
                                    <span class="badge badge-unpaid">
                                        <i class="fas fa-clock"></i> Belum Bayar
                                    </span>
                                    <div style="font-size:11px; color:var(--txt3); margin-top:4px;">Belum ada tindakan dari siswa</div>
                                @endif
                            </td>
                            <td style="color:var(--txt2);font-size:12px;">{{ $p->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="action-row">
                                    @if($p->status === 'pending')
                                    {{-- FIX: pakai route yang ada di web.php --}}
                                    <form action="{{ route('payments.verify', $p->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-green btn-sm" title="Approve">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <button class="btn btn-red btn-sm" title="Tolak"
                                        onclick="openReject({{ $p->id }})">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                    @else
                                        {{-- Tampilkan label status kalau sudah diproses --}}
                                        @if(in_array($p->status, ['approved','paid']))
                                        <span style="color:var(--green);font-size:12px;font-weight:700;">
                                            <i class="fas fa-check-circle"></i> Lunas
                                        </span>
                                        @elseif($p->status === 'rejected')
                                        <span style="color:var(--red);font-size:12px;font-weight:700;">
                                            <i class="fas fa-ban"></i> Ditolak
                                        </span>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($payments->hasPages())
                <div style="padding:16px 22px;border-top:1px solid var(--border);display:flex;align-items:center;gap:8px;flex-wrap:wrap;justify-content:flex-end;">
                    {{ $payments->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
                @endif

                @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>Belum ada data pembayaran.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- LIGHTBOX --}}
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
    <img src="" id="lightboxImg" alt="Bukti Pembayaran">
</div>

{{-- MODAL REJECT --}}
<div class="modal-bg" id="rejectModal">
    <div class="modal">
        <div class="modal-title">
            <i class="fas fa-times-circle" style="color:var(--red);"></i> Tolak Pembayaran
        </div>
        <form id="rejectForm" method="POST">
            @csrf @method('PATCH')
            <div class="form-group">
                <label>Alasan Penolakan (Opsional)</label>
                <textarea name="reason" placeholder="Bukti tidak jelas, nominal tidak sesuai, dll..."></textarea>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeReject()">Batal</button>
                <button type="submit" class="btn btn-red"><i class="fas fa-times"></i> Tolak</button>
            </div>
        </form>
    </div>
</div>

<script>
function showLightbox(src) {
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightbox').classList.add('show');
}
function closeLightbox() {
    document.getElementById('lightbox').classList.remove('show');
}

function openReject(id) {
    document.getElementById('rejectForm').action = '/payments/' + id + '/reject';
    document.getElementById('rejectModal').classList.add('show');
}
function closeReject() {
    document.getElementById('rejectModal').classList.remove('show');
}
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) closeReject();
});

@if($totalPending > 0)
(function() {
    var sb = document.querySelector('.sb');
    var dot = document.getElementById('pendingDot');
    if (!sb || !dot) return;
    function updateDot() {
        dot.style.display = sb.offsetWidth > 80 ? 'none' : 'block';
    }
    new ResizeObserver(updateDot).observe(sb);
    updateDot();
})();
@endif

// Toasts
function toast(type, title, msg) {
    var ic = {s:'fa-check', e:'fa-times'};
    var el = document.createElement('div');
    el.className = 'toast';
    el.innerHTML = '<div class="t-ic ' + type + '"><i class="fas ' + ic[type] + '"></i></div><div><div class="t-ttl">' + title + '</div><div class="t-msg">' + msg + '</div></div>';
    document.getElementById('toasts').appendChild(el);
    setTimeout(function() {
        el.classList.add('hide');
        setTimeout(function() { el.remove(); }, 250);
    }, 3200);
}
window.addEventListener('load', function() {
    @if(session('success'))
        toast('s', 'Berhasil', '{{ addslashes(session('success')) }}');
    @endif
    @if(session('error'))
        toast('e', 'Error', '{{ addslashes(session('error')) }}');
    @endif
});
</script>
@endsection
