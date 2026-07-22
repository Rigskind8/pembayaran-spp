@extends('layouts.app')

@section('title', 'Dashboard Kepala Sekolah')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
:root {
    --ks-dark: #0c0f1a;
    --ks-navy: #111827;
    --ks-card: #ffffff;
    --ks-border: #e5e9f0;
    --ks-muted: #6b7280;
    --ks-txt: #111827;
    --ks-blue: #2563eb;
    --ks-blue-lt: #eff6ff;
    --ks-green: #059669;
    --ks-green-lt: #ecfdf5;
    --ks-amber: #d97706;
    --ks-amber-lt: #fffbeb;
    --ks-red: #dc2626;
    --ks-red-lt: #fef2f2;
    --ks-indigo: #4f46e5;
    --ks-indigo-lt: #eef2ff;
    --ks-radius: 16px;
    --ks-radius-sm: 10px;
    --ks-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.04);
    --ks-shadow-lg: 0 8px 32px rgba(0,0,0,0.08);
}

* { box-sizing: border-box; }

.ks-root {
    font-family: 'Sora', sans-serif;
    background: #f4f6fa;
    min-height: 100vh;
    padding: 0;
}

/* ── TOPBAR ── */
.ks-topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 28px;
    background: white;
    border-bottom: 1px solid var(--ks-border);
    position: sticky;
    top: 0;
    z-index: 50;
}
.ks-topbar-left h1 {
    font-size: 16px;
    font-weight: 700;
    color: var(--ks-txt);
    margin: 0 0 2px;
}
.ks-topbar-left p {
    font-size: 12px;
    color: var(--ks-muted);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 5px;
}
.ks-topbar-right {
    display: flex;
    align-items: center;
    gap: 12px;
}
.ks-clock {
    font-family: 'JetBrains Mono', monospace;
    font-size: 20px;
    font-weight: 700;
    color: var(--ks-txt);
    background: #f4f6fa;
    padding: 8px 14px;
    border-radius: var(--ks-radius-sm);
    border: 1px solid var(--ks-border);
    letter-spacing: 0.04em;
}

/* ── PAGE BODY ── */
.ks-body {
    padding: 24px 28px;
    max-width: 1400px;
    margin: 0 auto;
}

/* ── HERO BANNER ── */
.ks-hero {
    background: var(--ks-dark);
    border-radius: 20px;
    padding: 36px 40px;
    margin-bottom: 24px;
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 32px;
    align-items: center;
    position: relative;
    overflow: hidden;
}
.ks-hero::before {
    content: '';
    position: absolute;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(37,99,235,0.15) 0%, transparent 70%);
    right: -200px;
    top: -200px;
    pointer-events: none;
}
.ks-hero::after {
    content: '';
    position: absolute;
    width: 1px;
    height: 100%;
    left: 40%;
    top: 0;
    background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.04) 40%, transparent);
}
.ks-hero-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(37,99,235,0.2);
    border: 1px solid rgba(37,99,235,0.35);
    color: #93c5fd;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 5px 12px;
    border-radius: 999px;
    margin-bottom: 16px;
}
.ks-hero-pill svg { width: 12px; height: 12px; }
.ks-hero h2 {
    font-size: 28px;
    font-weight: 800;
    color: white;
    margin: 0 0 10px;
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.ks-hero p {
    font-size: 13.5px;
    color: rgba(255,255,255,0.5);
    margin: 0;
    line-height: 1.7;
    max-width: 460px;
}
.ks-hero-stats {
    display: flex;
    gap: 12px;
}
.ks-hero-stat {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 14px;
    padding: 18px 22px;
    text-align: center;
    min-width: 120px;
    backdrop-filter: blur(8px);
}
.ks-hero-stat .num {
    font-size: 32px;
    font-weight: 800;
    color: white;
    line-height: 1;
    display: block;
    margin-bottom: 6px;
    font-variant-numeric: tabular-nums;
}
.ks-hero-stat .lbl {
    font-size: 10.5px;
    font-weight: 600;
    color: rgba(255,255,255,0.45);
    text-transform: uppercase;
    letter-spacing: 0.07em;
    line-height: 1.5;
}

/* ── STAT CARDS ROW ── */
.ks-statrow {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}
.ks-sc {
    background: white;
    border: 1px solid var(--ks-border);
    border-radius: var(--ks-radius);
    padding: 22px 20px;
    box-shadow: var(--ks-shadow);
    display: flex;
    align-items: center;
    gap: 16px;
    position: relative;
    overflow: hidden;
    transition: box-shadow 0.2s, transform 0.2s;
}
.ks-sc:hover { transform: translateY(-3px); box-shadow: var(--ks-shadow-lg); }
.ks-sc-accent {
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    border-radius: 16px 16px 0 0;
}
.ks-sc-icon {
    width: 50px; height: 50px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.ks-sc-info { flex: 1; min-width: 0; }
.ks-sc-lbl {
    font-size: 11px;
    font-weight: 700;
    color: var(--ks-muted);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 5px;
}
.ks-sc-val {
    font-size: 26px;
    font-weight: 800;
    color: var(--ks-txt);
    letter-spacing: -0.02em;
    line-height: 1;
}
.ks-sc-val.sm { font-size: 18px; }

/* ── MAIN GRID ── */
.ks-maingrid {
    display: grid;
    grid-template-columns: 1.65fr 1fr;
    gap: 20px;
}
.ks-col { display: flex; flex-direction: column; gap: 20px; }

/* ── CARD ── */
.ks-card {
    background: white;
    border: 1px solid var(--ks-border);
    border-radius: var(--ks-radius);
    box-shadow: var(--ks-shadow);
    overflow: hidden;
}
.ks-card-head {
    padding: 18px 22px 16px;
    border-bottom: 1px solid var(--ks-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.ks-card-title {
    font-size: 14px;
    font-weight: 800;
    color: var(--ks-txt);
    display: flex;
    align-items: center;
    gap: 9px;
    margin: 0;
}
.ks-card-title .ico {
    width: 30px; height: 30px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px;
}
.ks-card-link {
    font-size: 12px;
    font-weight: 700;
    color: var(--ks-blue);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 5px 10px;
    border-radius: 8px;
    background: var(--ks-blue-lt);
    transition: opacity 0.15s;
}
.ks-card-link:hover { opacity: 0.8; }
.ks-card-body { padding: 22px; }

/* ── ABSENSI GRID ── */
.ks-absgrid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
}
.ks-abs-item {
    border-radius: 14px;
    padding: 20px 12px;
    text-align: center;
    border: 1px solid transparent;
    transition: transform 0.15s;
}
.ks-abs-item:hover { transform: scale(1.04); }
.ks-abs-item .val {
    font-size: 34px;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 8px;
    letter-spacing: -0.02em;
    font-variant-numeric: tabular-nums;
}
.ks-abs-item .lbl {
    font-size: 10.5px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.07em;
}

/* ── TABLE ── */
.ks-tbl { width: 100%; border-collapse: collapse; }
.ks-tbl th {
    padding: 12px 20px;
    font-size: 10.5px;
    font-weight: 800;
    color: var(--ks-muted);
    text-transform: uppercase;
    letter-spacing: 0.07em;
    background: #f9fafb;
    border-bottom: 1px solid var(--ks-border);
    text-align: left;
    white-space: nowrap;
}
.ks-tbl td {
    padding: 15px 20px;
    font-size: 13px;
    color: #374151;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}
.ks-tbl tr:last-child td { border-bottom: none; }
.ks-tbl tr:hover td { background: #fafbfd; }
.ks-tbl .name { font-weight: 700; color: var(--ks-txt); font-size: 13.5px; }
.ks-tbl .meta { font-size: 11px; color: var(--ks-muted); font-weight: 600; margin-top: 2px; }
.ks-tbl .mono { font-family: 'JetBrains Mono', monospace; font-size: 13px; font-weight: 600; color: var(--ks-txt); }

/* ── BADGE ── */
.ks-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 11px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.02em;
    white-space: nowrap;
}
.ks-badge.ok { background: #dcfce7; color: #166534; }
.ks-badge.warn { background: #fef3c7; color: #92400e; }
.ks-badge.bad { background: #fee2e2; color: #991b1b; }

/* ── RANK LIST ── */
.ks-ranklist { display: flex; flex-direction: column; gap: 10px; }
.ks-rank-row {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 13px 16px;
    border-radius: 14px;
    border: 1px solid var(--ks-border);
    background: #fafbfd;
    transition: all 0.18s;
}
.ks-rank-row:hover { background: white; border-color: #cbd5e1; box-shadow: var(--ks-shadow); }
.ks-rank-num {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-weight: 900;
    font-size: 14px;
    flex-shrink: 0;
}
.ks-rank-num.r1 { background: linear-gradient(135deg,#fcd34d,#f59e0b); color: white; box-shadow: 0 3px 10px rgba(245,158,11,0.3); }
.ks-rank-num.r2 { background: linear-gradient(135deg,#e2e8f0,#94a3b8); color: white; box-shadow: 0 3px 10px rgba(148,163,184,0.3); }
.ks-rank-num.r3 { background: linear-gradient(135deg,#fdba74,#c2410c); color: white; box-shadow: 0 3px 10px rgba(194,65,12,0.3); }
.ks-rank-num.rn { background: #f1f5f9; color: #64748b; }
.ks-rank-info { flex: 1; }
.ks-rank-name { font-size: 14px; font-weight: 700; color: var(--ks-txt); }
.ks-rank-sub { font-size: 11px; font-weight: 600; color: var(--ks-muted); margin-top: 2px; }
.ks-rank-score {
    font-family: 'JetBrains Mono', monospace;
    font-size: 20px;
    font-weight: 700;
    color: var(--ks-blue);
}

/* ── ALPHA LIST ── */
.ks-alphalist { display: flex; flex-direction: column; gap: 10px; }
.ks-alpha-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 16px;
    border-radius: 14px;
    background: #fff5f5;
    border: 1px solid #fed7d7;
    transition: transform 0.15s;
}
.ks-alpha-row:hover { transform: translateX(3px); }
.ks-alpha-row h5 { font-size: 13.5px; font-weight: 800; color: #991b1b; margin: 0 0 3px; }
.ks-alpha-row p { font-size: 11px; font-weight: 600; color: #c53030; margin: 0; }
.ks-alpha-count {
    font-family: 'JetBrains Mono', monospace;
    font-size: 16px;
    font-weight: 700;
    color: #dc2626;
    background: #fecaca;
    padding: 6px 14px;
    border-radius: 10px;
    border: 1px solid #fc8181;
}
.ks-all-ok {
    text-align: center;
    padding: 24px 20px;
    background: #f0fdf4;
    border-radius: 14px;
    border: 1px solid #bbf7d0;
}
.ks-all-ok .ico { font-size: 28px; margin-bottom: 8px; color: var(--ks-green); }
.ks-all-ok p { color: #166534; font-weight: 700; font-size: 13px; margin: 0 0 4px; }
.ks-all-ok span { font-size: 11.5px; font-weight: 600; color: #4ade80; display: block; }

/* ── ANNOUNCEMENTS ── */
.ks-annlist { display: flex; flex-direction: column; }
.ks-ann-row {
    display: flex;
    gap: 14px;
    padding: 16px 0;
    border-bottom: 1px solid var(--ks-border);
}
.ks-ann-row:last-child { border-bottom: none; padding-bottom: 0; }
.ks-ann-ico {
    width: 40px; height: 40px;
    background: var(--ks-indigo-lt);
    color: var(--ks-indigo);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}
.ks-ann-row h5 { font-size: 13.5px; font-weight: 700; color: var(--ks-txt); margin: 0 0 5px; line-height: 1.4; }
.ks-ann-row p { font-size: 11px; font-weight: 600; color: var(--ks-muted); margin: 0; display: flex; align-items: center; gap: 5px; }
.ks-empty {
    text-align: center;
    padding: 30px 20px;
    color: var(--ks-muted);
    font-size: 13px;
    font-weight: 600;
}

/* ── RESPONSIVE ── */
@media (max-width: 1200px) {
    .ks-maingrid { grid-template-columns: 1fr; }
    .ks-statrow { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .ks-body { padding: 16px; }
    .ks-hero { grid-template-columns: 1fr; }
    .ks-hero-stats { flex-direction: row; }
    .ks-absgrid { grid-template-columns: repeat(2, 1fr); }
    .ks-statrow { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 500px) {
    .ks-statrow { grid-template-columns: 1fr; }
    .ks-hero-stats { flex-wrap: wrap; }
}
</style>

<div class="ks-root">
    <!-- Topbar -->
    <div class="ks-topbar">
        <div class="ks-topbar-left">
            <h1>Dashboard Kepala Sekolah</h1>
            <p>
                <i class="fas fa-calendar-alt"></i>
                {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
            </p>
        </div>
        <div class="ks-topbar-right">

                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>



        <!-- Hero Banner -->
        <div class="ks-hero">
            <div>
                <div class="ks-hero-pill">
                    <i class="fas fa-crown"></i> Portal Eksekutif
                </div>
                <h2>Selamat Datang, {{ explode(' ', $user->name)[0] }} </h2>
                <p>Pantau performa akademik, kehadiran, dan operasional keuangan sekolah secara komprehensif hari ini.</p>
            </div>
            <div class="ks-hero-stats">
                <div class="ks-hero-stat">
                    <span class="num">{{ $todayScheduleCount }}</span>
                    <span class="lbl">Jadwal Kelas<br>Hari Ini</span>
                </div>
                <div class="ks-hero-stat">
                    <span class="num">{{ $pendingCount }}</span>
                    <span class="lbl">Pending<br>Bayar SPP</span>
                </div>
            </div>
        </div>

        <!-- Stat Cards Row -->
        <div class="ks-statrow">
            <div class="ks-sc">
                <div class="ks-sc-accent" style="background: var(--ks-blue);"></div>
                <div class="ks-sc-icon" style="background: var(--ks-blue-lt); color: var(--ks-blue);">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="ks-sc-info">
                    <div class="ks-sc-lbl">Total Siswa</div>
                    <div class="ks-sc-val">{{ number_format($totalStudents) }}</div>
                </div>
            </div>
            <div class="ks-sc">
                <div class="ks-sc-accent" style="background: var(--ks-green);"></div>
                <div class="ks-sc-icon" style="background: var(--ks-green-lt); color: var(--ks-green);">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="ks-sc-info">
                    <div class="ks-sc-lbl">Guru & Staff</div>
                    <div class="ks-sc-val">{{ number_format($totalTeachers) }}</div>
                </div>
            </div>
            <div class="ks-sc">
                <div class="ks-sc-accent" style="background: var(--ks-amber);"></div>
                <div class="ks-sc-icon" style="background: var(--ks-amber-lt); color: var(--ks-amber);">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="ks-sc-info">
                    <div class="ks-sc-lbl">Pemasukan Bulan Ini</div>
                    <div class="ks-sc-val sm">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="ks-sc">
                <div class="ks-sc-accent" style="background: var(--ks-red);"></div>
                <div class="ks-sc-icon" style="background: var(--ks-red-lt); color: var(--ks-red);">
                    <i class="fas fa-user-xmark"></i>
                </div>
                <div class="ks-sc-info">
                    <div class="ks-sc-lbl">Siswa Alpha (Bulan Ini)</div>
                    <div class="ks-sc-val">{{ number_format($absenStats['alpha'] ?? 0) }}</div>
                </div>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="ks-maingrid">

            <!-- Left Column -->
            <div class="ks-col">

                <!-- Transaksi Pembayaran -->
                <div class="ks-card">
                    <div class="ks-card-head">
                        <h3 class="ks-card-title">
                            <span class="ico" style="background: var(--ks-green-lt); color: var(--ks-green);">
                                <i class="fas fa-receipt"></i>
                            </span>
                            Transaksi Pembayaran SPP Terbaru
                        </h3>
                        @if(Route::has('payments.index'))
                            <a href="{{ route('payments.index') }}" class="ks-card-link">
                                Selengkapnya <i class="fas fa-arrow-right"></i>
                            </a>
                        @endif
                    </div>
                    <div style="overflow-x: auto;">
                        <table class="ks-tbl">
                            <thead>
                                <tr>
                                    <th>Siswa</th>
                                    <th>Periode</th>
                                    <th>Nominal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPayments as $payment)
                                <tr>
                                    <td>
                                        <div class="name">{{ $payment->student->name ?? '-' }}</div>
                                        <div class="meta">Kelas {{ $payment->student->class_id ?? '-' }}</div>
                                    </td>
                                    <td style="font-weight: 600;">{{ $payment->month }} {{ $payment->year }}</td>
                                    <td class="mono">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if(in_array($payment->status, ['paid', 'approved']))
                                            <span class="ks-badge ok"><i class="fas fa-check-circle"></i> Lunas</span>
                                        @elseif($payment->status == 'pending')
                                            <span class="ks-badge warn"><i class="fas fa-hourglass-half"></i> Pending</span>
                                        @else
                                            <span class="ks-badge bad"><i class="fas fa-times-circle"></i> Belum</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="ks-empty">
                                        <i class="fas fa-inbox" style="display:block;font-size:24px;margin-bottom:8px;"></i>
                                        Belum ada transaksi pembayaran terbaru.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Right Column -->
            <div class="ks-col">

                <!-- Pengumuman Sekolah -->
                <div class="ks-card">
                    <div class="ks-card-head">
                        <h3 class="ks-card-title">
                            <span class="ico" style="background: var(--ks-indigo-lt); color: var(--ks-indigo);">
                                <i class="fas fa-bullhorn"></i>
                            </span>
                            Pengumuman Sekolah
                        </h3>
                    </div>
                    <div class="ks-card-body" style="padding-top: 8px;">
                        <div class="ks-annlist">
                            @forelse($announcements as $ann)
                            <div class="ks-ann-row">
                                <div class="ks-ann-ico">
                                    <i class="fas fa-envelope-open-text"></i>
                                </div>
                                <div>
                                    <h5>{{ $ann->judul ?? $ann->title }}</h5>
                                    <p><i class="far fa-clock"></i> {{ $ann->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="ks-empty">
                                <i class="fas fa-inbox" style="display:block;font-size:22px;margin-bottom:8px;"></i>
                                Belum ada pengumuman disebarkan.
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
function updateClock() {
    const el = document.getElementById('liveClock');
    if (el) el.textContent = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
}
setInterval(updateClock, 1000);
updateClock();
</script>
@endpush