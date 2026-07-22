@extends('layouts.app')

@section('title', 'Detail Pembayaran - Paramount')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
        --sw: 68px; --sb: #0d1117;
        --acc: #2563eb; --acc2: #7c3aed;
        --card: #fff; --bdr: #e2e8f0; --bg: #f0f2f7;
        --t1: #0f172a; --t2: #64748b;
        --grn: #059669; --grn-bg: #ecfdf5; --grn-bd: #a7f3d0;
        --red: #dc2626; --red-bg: #fff1f2; --red-bd: #fecdd3;
        --amb: #d97706; --amb-bg: #fffbeb; --amb-bd: #fde68a;
        --rad: 18px;
        --sh: 0 1px 3px rgba(0,0,0,.06);
        --sh-md: 0 4px 16px rgba(0,0,0,.08);
        --sh-lg: 0 10px 40px rgba(0,0,0,.12);
    }
    html, body { height:100%; font-family:'Plus Jakarta Sans',sans-serif; background:var(--bg); color:var(--t1); -webkit-font-smoothing:antialiased; }
    .wrap { display:flex; min-height:100vh; }

    /* SIDEBAR */
    .sb { width:var(--sw);background:var(--sb);position:fixed;top:0;left:0;height:100vh;z-index:200;display:flex;flex-direction:column;align-items:center;padding:20px 0 24px;transition:width .3s cubic-bezier(.4,0,.2,1);overflow:hidden; }
    .sb:hover { width:240px;align-items:flex-start; }
    .sb::after { content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--acc),var(--acc2)); }
    .sb-logo { display:flex;align-items:center;gap:12px;padding:6px 18px;width:100%;min-height:52px;margin-bottom:28px;flex-shrink:0; }
    .sb-logo-icon { width:36px;height:36px;border-radius:11px;background:linear-gradient(135deg,var(--acc),var(--acc2));display:flex;align-items:center;justify-content:center;color:white;font-size:16px;flex-shrink:0;box-shadow:0 4px 14px rgba(37,99,235,.45); }
    .sb-nav { display:flex;flex-direction:column;gap:2px;width:100%;padding:0 10px;flex:1; }
    .sb-lbl { font-size:9px;font-weight:700;letter-spacing:.16em;color:#374151;text-transform:uppercase;padding:12px 8px 6px;white-space:nowrap;opacity:0;transition:opacity .2s; }
    .sb:hover .sb-lbl { opacity:1; }
    .sb-a { display:flex;align-items:center;gap:12px;padding:11px 10px;border-radius:12px;color:#6b7280;font-size:13px;font-weight:600;text-decoration:none;white-space:nowrap;transition:all .18s;position:relative; }
    .sb-ico { width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;background:rgba(255,255,255,.04);transition:all .18s; }
    .sb-a:hover { color:#e2e8f0;background:rgba(255,255,255,.05); }
    .sb-a:hover .sb-ico { background:rgba(37,99,235,.15);color:#93c5fd; }
    .sb-a.active { color:#fff;background:rgba(37,99,235,.12); }
    .sb-a.active .sb-ico { background:linear-gradient(135deg,var(--acc),var(--acc2));color:white;box-shadow:0 4px 12px rgba(37,99,235,.4); }
    .sb-a.active::before { content:'';position:absolute;left:-10px;top:50%;transform:translateY(-50%);width:3px;height:24px;background:linear-gradient(180deg,var(--acc),var(--acc2));border-radius:0 3px 3px 0; }
    .sb-footer { width:100%;padding:0 10px;margin-top:auto;border-top:1px solid rgba(255,255,255,.05);padding-top:16px; }
    .sb-user { display:flex;align-items:center;gap:10px;padding:10px;border-radius:12px;background:rgba(255,255,255,.04);margin-bottom:8px; }
    .sb-av { width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,var(--acc),var(--acc2));color:white;font-weight:800;font-size:15px;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
    .sb-uname { font-size:12.5px;font-weight:700;color:#f1f5f9;line-height:1.3;white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
    .sb-urole { font-size:10px;color:#6b7280; }
    .sb-logout { display:flex;align-items:center;gap:12px;padding:10px;border-radius:12px;background:transparent;border:none;color:#ef4444;font-size:13px;font-weight:600;cursor:pointer;width:100%;font-family:inherit;white-space:nowrap;transition:background .18s; }
    .sb-logout:hover { background:rgba(239,68,68,.1); }
    .sb-logout .sb-ico { background:rgba(239,68,68,.08);font-size:14px; }
    .sb-txt { opacity:0;pointer-events:none;transition:opacity .2s;white-space:nowrap; }
    .sb:hover .sb-txt { opacity:1;pointer-events:auto; }

    /* MAIN */
    .main { margin-left:var(--sw);flex:1;display:flex;flex-direction:column;min-height:100vh; }

    /* TOPBAR */
    .topbar { display:flex;align-items:center;justify-content:space-between;padding:16px 32px;background:rgba(240,242,247,.85);backdrop-filter:blur(12px);border-bottom:1px solid var(--bdr);position:sticky;top:0;z-index:100;gap:16px; }
    .topbar-left { display:flex;align-items:center;gap:12px; }
    .back-btn { display:inline-flex;align-items:center;gap:7px;padding:8px 14px;border-radius:10px;background:var(--card);border:1px solid var(--bdr);color:var(--t2);font-size:12px;font-weight:700;text-decoration:none;transition:all .15s;box-shadow:var(--sh); }
    .back-btn:hover { background:#f1f5f9;color:var(--t1); }
    .topbar-left h1 { font-size:18px;font-weight:800;color:var(--t1);letter-spacing:-.4px; }
    .pill { display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;border:1px solid var(--bdr);background:var(--card);font-size:11px;font-weight:600;color:var(--t2);box-shadow:var(--sh);white-space:nowrap; }
    .pill i { font-size:10px;color:var(--acc); }
    .pill.dk { background:var(--sb);color:#94a3b8;border-color:transparent; }
    .pill.dk i { color:#475569; }

    /* BODY */
    .body { padding:28px 32px;flex:1; }

    /* LAYOUT */
    .detail-layout { display:grid;grid-template-columns:1fr 340px;gap:20px; }

    /* CARDS */
    .card { background:var(--card);border:1px solid var(--bdr);border-radius:var(--rad);box-shadow:var(--sh);overflow:hidden; }
    .card-head { padding:20px 24px;border-bottom:1px solid var(--bdr);background:#fafbff;display:flex;align-items:center;justify-content:space-between;gap:12px; }
    .card-title { font-size:15px;font-weight:800;color:var(--t1);letter-spacing:-.3px; }
    .card-sub { font-size:12px;color:var(--t2);margin-top:2px; }
    .card-body { padding:24px; }

    /* Hero tagihan */
    .tagihan-hero { background:linear-gradient(135deg,#1e3a8a,#1d4ed8 50%,#6d28d9);border-radius:16px;padding:24px;display:flex;align-items:center;gap:20px;margin-bottom:24px;position:relative;overflow:hidden; }
    .tagihan-hero::before { content:'';position:absolute;top:-30px;right:-30px;width:140px;height:140px;border-radius:50%;background:rgba(255,255,255,.06); }
    .tagihan-hero-icon { width:56px;height:56px;border-radius:16px;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;font-size:24px;color:white;flex-shrink:0; }
    .tagihan-hero-month { font-size:11px;font-weight:700;color:rgba(255,255,255,.6);text-transform:uppercase;letter-spacing:.1em;margin-bottom:4px; }
    .tagihan-hero-amount { font-size:28px;font-weight:800;color:white;letter-spacing:-.5px;line-height:1; }
    .tagihan-hero-meta { font-size:12px;color:rgba(255,255,255,.6);margin-top:5px; }

    /* Info rows */
    .info-row { display:flex;justify-content:space-between;align-items:flex-start;padding:13px 0;border-bottom:1px solid #f1f5f9; }
    .info-row:last-child { border-bottom:none; }
    .info-label { font-size:12px;color:var(--t2);font-weight:500;display:flex;align-items:center;gap:7px; }
    .info-label i { font-size:11px;color:#94a3b8;width:14px;text-align:center; }
    .info-val { font-size:13px;font-weight:700;color:var(--t1);text-align:right;max-width:60%; }

    /* Badge */
    .badge { display:inline-flex;align-items:center;gap:5px;padding:5px 13px;border-radius:8px;font-size:10px;font-weight:800;letter-spacing:.06em;text-transform:uppercase; }
    .badge.paid { background:var(--grn-bg);color:var(--grn);border:1px solid var(--grn-bd); }
    .badge.pending { background:#eff6ff;color:var(--acc);border:1px solid #bfdbfe; }
    .badge.unpaid { background:var(--amb-bg);color:var(--amb);border:1px solid var(--amb-bd); }
    .badge.rejected { background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd); }

    /* Bukti preview */
    .proof-wrap { border:2px solid var(--bdr);border-radius:14px;overflow:hidden;cursor:pointer;transition:all .18s;position:relative; }
    .proof-wrap:hover { border-color:var(--acc);box-shadow:var(--sh-md); }
    .proof-wrap img { width:100%;height:220px;object-fit:cover;display:block; }
    .proof-overlay { position:absolute;inset:0;background:rgba(0,0,0,.4);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .18s; }
    .proof-wrap:hover .proof-overlay { opacity:1; }
    .proof-overlay span { color:white;font-size:13px;font-weight:700; }
    .no-proof { border:2px dashed var(--bdr);border-radius:14px;padding:40px 24px;text-align:center;color:var(--t2); }
    .no-proof i { font-size:32px;color:#cbd5e1;margin-bottom:10px;display:block; }
    .no-proof p { font-size:13px;font-weight:600; }

    /* Action buttons */
    .action-bar { display:flex;gap:10px;flex-wrap:wrap; }
    .btn-primary { display:inline-flex;align-items:center;gap:7px;padding:11px 22px;background:linear-gradient(135deg,var(--acc),var(--acc2));color:white;border-radius:12px;font-size:12.5px;font-weight:700;text-decoration:none;border:none;cursor:pointer;font-family:inherit;box-shadow:0 4px 14px rgba(37,99,235,.35);transition:all .18s; }
    .btn-primary:hover { transform:translateY(-1px);box-shadow:0 8px 20px rgba(37,99,235,.4);color:white; }
    .btn-success { background:linear-gradient(135deg,var(--grn),#10b981);box-shadow:0 4px 14px rgba(5,150,105,.35); }
    .btn-success:hover { box-shadow:0 8px 20px rgba(5,150,105,.4); }
    .btn-danger { background:linear-gradient(135deg,var(--red),#ef4444);box-shadow:0 4px 14px rgba(220,38,38,.35); }
    .btn-danger:hover { box-shadow:0 8px 20px rgba(220,38,38,.4); }
    .btn-outline { display:inline-flex;align-items:center;gap:7px;padding:11px 22px;background:white;color:var(--t1);border:1.5px solid var(--bdr);border-radius:12px;font-size:12.5px;font-weight:700;text-decoration:none;cursor:pointer;font-family:inherit;transition:all .15s; }
    .btn-outline:hover { background:#f8fafc;color:var(--t1); }

    /* Timeline */
    .timeline { display:flex;flex-direction:column;gap:0; }
    .tl-item { display:flex;gap:14px;padding:14px 0;position:relative; }
    .tl-item:not(:last-child)::after { content:'';position:absolute;left:18px;top:46px;width:2px;height:calc(100% - 14px);background:#f1f5f9; }
    .tl-dot { width:36px;height:36px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:13px;z-index:1; }
    .tl-dot.blue { background:#eff6ff;color:var(--acc); }
    .tl-dot.green { background:var(--grn-bg);color:var(--grn); }
    .tl-dot.amber { background:var(--amb-bg);color:var(--amb); }
    .tl-dot.red { background:var(--red-bg);color:var(--red); }
    .tl-title { font-size:13px;font-weight:700;color:var(--t1);line-height:1.3; }
    .tl-meta { font-size:11px;color:var(--t2);margin-top:3px; }

    /* Lightbox */
    .lightbox { position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:9999;display:none;align-items:center;justify-content:center; }
    .lightbox.open { display:flex; }
    .lightbox img { max-width:90vw;max-height:85vh;border-radius:12px;box-shadow:0 20px 60px rgba(0,0,0,.5); }
    .lightbox-close { position:absolute;top:20px;right:20px;width:40px;height:40px;background:white;border-radius:50%;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:18px;color:var(--t1); }

    /* Toast */
    .toast-c { position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:8px; }
    .toast { display:flex;align-items:center;gap:12px;padding:14px 18px;background:white;border-radius:14px;box-shadow:var(--sh-lg);border:1px solid var(--bdr);min-width:260px;animation:toastIn .3s ease; }
    @keyframes toastIn { from{opacity:0;transform:translateX(40px)} to{opacity:1;transform:translateX(0)} }
    .t-ico { width:34px;height:34px;border-radius:9px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:15px; }
    .t-ico.ok { background:var(--grn-bg);color:var(--grn); }
    .t-ico.err { background:var(--red-bg);color:var(--red); }

    @media (max-width:1024px) { .detail-layout { grid-template-columns:1fr; } }
    @media (max-width:768px) { .sb { display:none; } .main { margin-left:0; } .body { padding:18px; } .topbar { padding:14px 18px; } }
</style>

<div class="toast-c" id="toastC"></div>

<div class="lightbox" id="lightbox" onclick="this.classList.remove('open')">
    <button class="lightbox-close" onclick="event.stopPropagation();document.getElementById('lightbox').classList.remove('open')"><i class="fas fa-times"></i></button>
    <img id="lightboxImg" src="" alt="Bukti Transfer">
</div>

<div class="wrap">

{{-- SIDEBAR --}}
@include('partials.sidebar')

{{-- MAIN --}}
<div class="main">

    <header class="topbar">
        <div class="topbar-left">
            <a href="{{ route('siswa.pembayaran') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <h1><i class="fas fa-receipt" style="color:var(--acc);margin-right:6px;"></i>Detail Pembayaran</h1>
        </div>
        <div style="display:flex;align-items:center;gap:8px;">
            @php $s = strtolower($payment->status); @endphp
            @if($s === 'paid' || $s === 'approved')
                <span class="badge paid"><i class="fas fa-check-circle"></i> Lunas</span>
            @elseif($s === 'pending')
                <span class="badge pending"><i class="fas fa-hourglass-half"></i> Menunggu Verifikasi</span>
            @elseif($s === 'rejected')
                <span class="badge rejected"><i class="fas fa-ban"></i> Ditolak</span>
            @else
                <span class="badge unpaid"><i class="fas fa-clock"></i> Belum Bayar</span>
            @endif
            <div class="pill dk"><i class="fas fa-calendar-days"></i> {{ date('d M Y') }}</div>
        </div>
    </header>

    <div class="body">

        @if(session('success'))
        <div style="display:flex;align-items:center;gap:12px;padding:14px 20px;border-radius:14px;background:var(--grn-bg);border:1px solid var(--grn-bd);color:var(--grn);font-size:13px;font-weight:600;margin-bottom:20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        <div class="detail-layout">

            {{-- LEFT COLUMN --}}
            <div style="display:flex;flex-direction:column;gap:20px;">

                {{-- Hero --}}
                <div class="tagihan-hero">
                    <div class="tagihan-hero-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                    <div style="position:relative;z-index:1;">
                        <div class="tagihan-hero-month">{{ $payment->month ?? 'Pembayaran' }} {{ $payment->year ?? '' }} · SPP Bulanan</div>
                        <div class="tagihan-hero-amount">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                        <div class="tagihan-hero-meta">
                            <i class="fas fa-user" style="margin-right:4px;"></i>{{ $payment->student->name ?? '-' }}
                            &nbsp;·&nbsp;
                            <i class="fas fa-calendar" style="margin-right:4px;"></i>{{ $payment->created_at ? $payment->created_at->format('d M Y') : '-' }}
                        </div>
                    </div>
                </div>

                {{-- Info Detail --}}
                <div class="card">
                    <div class="card-head">
                        <div>
                            <div class="card-title">Informasi Pembayaran</div>
                            <div class="card-sub">Detail lengkap transaksi ini</div>
                        </div>
                        <a href="{{ route('payments.edit', $payment->id) }}" class="btn-outline" style="padding:8px 16px;font-size:12px;">
                            <i class="fas fa-pen"></i> Edit
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-hashtag"></i> ID Transaksi</span>
                            <span class="info-val">#{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-user-graduate"></i> Nama Siswa</span>
                            <span class="info-val">{{ $payment->student->name ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-id-card"></i> NIS</span>
                            <span class="info-val">{{ $payment->student->nis ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-chalkboard-teacher"></i> Kelas</span>
                            <span class="info-val">{{ $payment->student->class_id ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-calendar-alt"></i> Periode</span>
                            <span class="info-val">{{ $payment->month ?? '-' }} {{ $payment->year ?? '' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-coins"></i> Nominal</span>
                            <span class="info-val" style="font-size:15px;color:var(--acc);">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                        </div>
                        @if($payment->payment_method)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-credit-card"></i> Metode Bayar</span>
                            <span class="info-val">{{ $payment->payment_method }}</span>
                        </div>
                        @endif
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-circle-dot"></i> Status</span>
                            <span class="info-val">
                                @if($s === 'paid' || $s === 'approved')
                                    <span class="badge paid"><i class="fas fa-check-circle"></i> Lunas</span>
                                @elseif($s === 'pending')
                                    <span class="badge pending"><i class="fas fa-hourglass-half"></i> Menunggu Verifikasi</span>
                                @elseif($s === 'rejected')
                                    <span class="badge rejected"><i class="fas fa-ban"></i> Ditolak</span>
                                @else
                                    <span class="badge unpaid"><i class="fas fa-clock"></i> Belum Bayar</span>
                                @endif
                            </span>
                        </div>
                        @if($payment->catatan)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-comment"></i> Catatan Siswa</span>
                            <span class="info-val" style="font-style:italic;">{{ $payment->catatan }}</span>
                        </div>
                        @endif
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-clock"></i> Dibuat</span>
                            <span class="info-val">{{ $payment->created_at ? $payment->created_at->format('d M Y, H:i') : '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-rotate"></i> Diperbarui</span>
                            <span class="info-val">{{ $payment->updated_at ? $payment->updated_at->format('d M Y, H:i') : '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Admin Actions --}}
                @if($s === 'pending')
                <div class="card">
                    <div class="card-head">
                        <div>
                            <div class="card-title"><i class="fas fa-gavel" style="color:var(--acc);margin-right:6px;"></i>Tindakan Admin</div>
                            <div class="card-sub">Verifikasi atau tolak pembayaran ini</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div style="display:flex;gap:10px;flex-wrap:wrap;">
                            <form action="{{ route('payments.verify', $payment->id) }}" method="POST" style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-primary btn-success">
                                    <i class="fas fa-check-circle"></i> Approve — Tandai Lunas
                                </button>
                            </form>
                            <form action="{{ route('payments.reject', $payment->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menolak pembayaran ini?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-primary btn-danger">
                                    <i class="fas fa-ban"></i> Tolak Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

            </div>

            {{-- RIGHT COLUMN --}}
            <div style="display:flex;flex-direction:column;gap:20px;">

                {{-- Bukti Transfer --}}
                <div class="card">
                    <div class="card-head">
                        <div>
                            <div class="card-title">Bukti Transfer</div>
                            <div class="card-sub">Screenshot/foto dari siswa</div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($payment->proof)
                            <div class="proof-wrap" onclick="openLightbox('{{ Storage::url($payment->proof) }}')">
                                <img src="{{ Storage::url($payment->proof) }}" alt="Bukti Transfer">
                                <div class="proof-overlay"><span><i class="fas fa-expand"></i> Lihat Penuh</span></div>
                            </div>
                            <div style="margin-top:12px;">
                                <a href="{{ Storage::url($payment->proof) }}" download class="btn-outline" style="width:100%;justify-content:center;padding:10px;">
                                    <i class="fas fa-download"></i> Download Bukti
                                </a>
                            </div>
                        @else
                            <div class="no-proof">
                                <i class="fas fa-image"></i>
                                <p>Belum ada bukti upload</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Timeline Status --}}
                <div class="card">
                    <div class="card-head">
                        <div class="card-title">Riwayat Status</div>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="tl-item">
                                <div class="tl-dot blue"><i class="fas fa-plus"></i></div>
                                <div>
                                    <div class="tl-title">Tagihan Dibuat</div>
                                    <div class="tl-meta">{{ $payment->created_at ? $payment->created_at->format('d M Y, H:i') : '-' }}</div>
                                </div>
                            </div>
                            @if($payment->proof)
                            <div class="tl-item">
                                <div class="tl-dot amber"><i class="fas fa-upload"></i></div>
                                <div>
                                    <div class="tl-title">Bukti Diupload Siswa</div>
                                    <div class="tl-meta">{{ $payment->updated_at ? $payment->updated_at->format('d M Y, H:i') : '-' }} · {{ $payment->payment_method ?? 'Transfer' }}</div>
                                </div>
                            </div>
                            @endif
                            @if($s === 'paid' || $s === 'approved')
                            <div class="tl-item">
                                <div class="tl-dot green"><i class="fas fa-check"></i></div>
                                <div>
                                    <div class="tl-title">Pembayaran Diverifikasi</div>
                                    <div class="tl-meta">Status: Lunas ✓</div>
                                </div>
                            </div>
                            @elseif($s === 'rejected')
                            <div class="tl-item">
                                <div class="tl-dot red"><i class="fas fa-times"></i></div>
                                <div>
                                    <div class="tl-title">Pembayaran Ditolak</div>
                                    <div class="tl-meta">Silakan upload ulang bukti transfer.</div>
                                </div>
                            </div>
                            @elseif($s === 'pending')
                            <div class="tl-item">
                                <div class="tl-dot" style="background:#eff6ff;color:var(--acc);"><i class="fas fa-hourglass-half"></i></div>
                                <div>
                                    <div class="tl-title">Menunggu Verifikasi Admin</div>
                                    <div class="tl-meta">Sedang diperiksa...</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Delete --}}
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data pembayaran ini? Tindakan tidak bisa dibatalkan.')">
                            @csrf @method('DELETE')
                            <button type="submit" style="width:100%;display:flex;align-items:center;justify-content:center;gap:8px;padding:11px;border-radius:12px;background:var(--red-bg);color:var(--red);border:1.5px solid var(--red-bd);font-size:13px;font-weight:700;cursor:pointer;font-family:inherit;transition:all .15s;">
                                <i class="fas fa-trash"></i> Hapus Data Pembayaran
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
</div>

<script>
function openLightbox(url) {
    document.getElementById('lightboxImg').src = url;
    document.getElementById('lightbox').classList.add('open');
}

@if(session('success'))
window.addEventListener('load', () => {
    const t = document.createElement('div');
    t.className = 'toast';
    t.innerHTML = `<div class="t-ico ok"><i class="fas fa-check"></i></div><div><p style="font-size:13px;font-weight:700;">Berhasil!</p><span style="font-size:11px;color:var(--t2);">{{ session('success') }}</span></div>`;
    document.getElementById('toastC').appendChild(t);
    setTimeout(() => t.remove(), 4000);
});
@endif
</script>

@endsection
