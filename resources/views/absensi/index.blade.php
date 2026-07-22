@extends('layouts.app')
@section('title', 'Absensi Saya - Travina Prima')

@push('styles')
<style>
:root {
    --bg: #f3f6fb;
    --card: #ffffff;
    --line: #e2e8f0;
    --text: #0f172a;
    --muted: #64748b;
    --brand: #0f766e;
    --brand-2: #14b8a6;
    --ok: #059669;
    --warn: #d97706;
    --info: #2563eb;
    --danger: #dc2626;
    --shadow: 0 14px 34px rgba(15, 23, 42, .08);
}

.main {
    margin-left: var(--sb, 250px);
    min-height: 100vh;
    background: radial-gradient(circle at 10% 0%, rgba(20, 184, 166, .14), transparent 30%), var(--bg);
}

.page-wrap {
    padding: 28px;
}

.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-bottom: 18px;
}

.title {
    font-size: 30px;
    font-weight: 800;
    letter-spacing: -.02em;
    color: var(--text);
}

.subtitle {
    margin-top: 4px;
    font-size: 13px;
    color: var(--muted);
}

.chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border-radius: 999px;
    border: 1px solid var(--line);
    background: var(--card);
    color: var(--muted);
    font-size: 12px;
    font-weight: 700;
}

.hero {
    border-radius: 24px;
    background: linear-gradient(135deg, #0f766e 0%, #14b8a6 58%, #2dd4bf 100%);
    color: #f8fffe;
    box-shadow: 0 16px 44px rgba(15, 118, 110, .28);
    padding: 22px 24px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    flex-wrap: wrap;
}

.hero h2 {
    margin: 0 0 6px;
    font-size: 24px;
    font-weight: 800;
}

.hero p {
    margin: 0;
    opacity: .9;
    font-size: 13px;
}

.hero-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(90px, 1fr));
    gap: 10px;
}

.hstat {
    background: rgba(255, 255, 255, .18);
    border: 1px solid rgba(255, 255, 255, .26);
    border-radius: 14px;
    padding: 10px 12px;
    text-align: center;
}

.hstat strong {
    display: block;
    font-size: 20px;
    line-height: 1;
}

.hstat span {
    font-size: 10px;
    letter-spacing: .08em;
    text-transform: uppercase;
    font-weight: 700;
}

.grid {
    display: grid;
    grid-template-columns: 1.4fr .9fr;
    gap: 16px;
}

@media (max-width: 1024px) {
    .grid { grid-template-columns: 1fr; }
}

.card {
    border-radius: 18px;
    border: 1px solid var(--line);
    background: var(--card);
    box-shadow: var(--shadow);
    overflow: hidden;
}

.card-head {
    border-bottom: 1px solid var(--line);
    background: #f8fafc;
    padding: 14px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-title {
    margin: 0;
    font-size: 15px;
    font-weight: 800;
    color: var(--text);
}

.card-sub {
    margin-top: 3px;
    color: var(--muted);
    font-size: 12px;
}

table.dt {
    width: 100%;
    border-collapse: collapse;
}

table.dt thead tr {
    background: #f8fafc;
}

table.dt th {
    padding: 10px 14px;
    border-bottom: 1px solid var(--line);
    text-transform: uppercase;
    font-size: 10px;
    letter-spacing: .08em;
    color: var(--muted);
    text-align: left;
}

table.dt td {
    padding: 11px 14px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    color: #334155;
}

table.dt tbody tr:hover {
    background: #f8fafc;
}

.bdg {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    border-radius: 999px;
    padding: 5px 10px;
    font-size: 11px;
    font-weight: 800;
}

.bdg.hadir { background: #ecfdf5; color: var(--ok); }
.bdg.sakit { background: #fffbeb; color: var(--warn); }
.bdg.izin { background: #dbeafe; color: var(--info); }
.bdg.alpha { background: #fef2f2; color: var(--danger); }

.empty {
    text-align: center;
    padding: 34px 20px;
    color: var(--muted);
}

.sched-list {
    padding: 12px;
    display: grid;
    gap: 8px;
}

.sched-item {
    border: 1px solid var(--line);
    border-radius: 12px;
    padding: 10px 12px;
    background: #ffffff;
}

.sched-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
}

.sched-name {
    margin: 0;
    font-size: 13px;
    font-weight: 800;
    color: var(--text);
}

.sched-time {
    font-size: 11px;
    color: var(--muted);
    font-weight: 700;
}

.sched-teacher {
    margin-top: 4px;
    font-size: 12px;
    color: var(--muted);
}

.today-note {
    margin-top: 12px;
    border: 1px solid var(--line);
    border-radius: 12px;
    background: #f8fafc;
    padding: 10px 12px;
    font-size: 12px;
    color: #475569;
}

.action-box {
    margin-top: 10px;
    padding: 12px;
    border-radius: 12px;
    border: 1px dashed #bae6fd;
    background: #f0f9ff;
}

.action-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 8px;
    text-decoration: none;
    font-size: 12px;
    font-weight: 800;
    color: #0369a1;
}

@media (max-width: 900px) {
    .main { margin-left: 0; }
    .page-wrap { padding: 18px; }
    .title { font-size: 24px; }
    .hero { padding: 18px; }
    .hero-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); width: 100%; }
}
</style>
@endpush

@section('content')
<div class="app">
    @include('partials.sidebar')

    <main class="main">
        <div class="page-wrap">
            <div class="topbar">
                <div>
                    <div class="title">Absensi Siswa</div>
                    <div class="subtitle">{{ now()->translatedFormat('l, d F Y') }} · {{ $student?->name ?? Auth::user()->name }} · Kelas {{ $student?->class_id ?? '-' }}</div>
                </div>
                <div class="chip"><i class="fas fa-user-graduate" style="color: var(--brand);"></i> NIS {{ $student?->nis ?? '-' }}</div>
            </div>

            <section class="hero">
                <div>
                    <h2>Ringkasan Kehadiran</h2>
                    <p>Pantau statistik absensi bulan ini dan cek jadwal mapel hari ini secara cepat.</p>
                </div>
                <div class="hero-stats">
                    <div class="hstat"><strong>{{ $attendanceStats['hadir'] }}</strong><span>Hadir</span></div>
                    <div class="hstat"><strong>{{ $attendanceStats['sakit'] }}</strong><span>Sakit</span></div>
                    <div class="hstat"><strong>{{ $attendanceStats['izin'] }}</strong><span>Izin</span></div>
                    <div class="hstat"><strong>{{ $attendanceStats['alpha'] }}</strong><span>Alpha</span></div>
                </div>
            </section>

            <div class="grid">
                <section class="card">
                    <header class="card-head">
                        <div>
                            <h3 class="card-title">Riwayat Absensi Bulan Ini</h3>
                            <div class="card-sub">Data absensi {{ now()->translatedFormat('F Y') }}</div>
                        </div>
                        <span class="chip">{{ $attendances->count() }} data</span>
                    </header>

                    @if($attendances->isEmpty())
                        <div class="empty">
                            Belum ada data absensi bulan ini.
                        </div>
                    @else
                        <table class="dt">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Hari</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $a)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($a->date)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($a->date)->translatedFormat('l') }}</td>
                                        <td><span class="bdg {{ $a->status }}">{{ ucfirst($a->status) }}</span></td>
                                        <td>{{ $a->keterangan ?: '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </section>

                <aside class="card">
                    <header class="card-head">
                        <div>
                            <h3 class="card-title">Jadwal Hari Ini</h3>
                            <div class="card-sub">{{ $dayName }}</div>
                        </div>
                    </header>

                    @if(isset($todaySchedules) && $todaySchedules->isNotEmpty())
                        <div class="sched-list">
                            @foreach($todaySchedules as $schedule)
                                @php
                                    $attendance = $todayAttendances->get($schedule->id);
                                    $statusClass = $attendance?->status;
                                @endphp
                                <div class="sched-item">
                                    <div class="sched-top">
                                        <h4 class="sched-name">{{ $schedule->subject->name ?? '-' }}</h4>
                                        <span class="sched-time">{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</span>
                                    </div>
                                    <div class="sched-teacher">{{ $schedule->teacher->name ?? 'Guru belum diset' }}</div>
                                    <div class="today-note">
                                        Status: @if($attendance)<span class="bdg {{ $statusClass }}">{{ ucfirst($attendance->status) }}</span>@else <span class="bdg" style="background:#f1f5f9;color:#475569;">Belum Absen</span>@endif
                                    </div>
                                </div>
                            @endforeach

                            <div class="action-box">
                                Isi absensi per mapel dengan tampilan terbaru.
                                <br>
                                <a class="action-link" href="{{ route('attendance.today') }}"><i class="fas fa-arrow-right"></i> Buka Halaman Absen Mapel</a>
                            </div>
                        </div>
                    @else
                        <div class="empty">Tidak ada jadwal hari ini untuk kelas {{ $student?->class_id ?? '-' }}.</div>
                    @endif
                </aside>
            </div>
        </div>
    </main>
</div>
@endsection
