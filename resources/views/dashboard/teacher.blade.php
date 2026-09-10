@extends('layouts.app')

@section('title', 'Dashboard Guru - SMK TRAVINA PRIMA')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root {
    --sb: 72px;
    --bg: #f4f6fa;
    --card: #ffffff;
    --border: #e8eaf0;
    --txt: #111827;
    --txt2: #6b7280;
    --blue: #2563eb;
    --blue-bg: #eff6ff;
    --green: #059669;
    --green-bg: #ecfdf5;
    --amber: #d97706;
    --amber-bg: #fffbeb;
    --red: #dc2626;
    --red-bg: #fef2f2;
    --shadow: 0 1px 3px rgba(0,0,0,.06), 0 2px 8px rgba(0,0,0,.04);
}
* { box-sizing: border-box; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--txt); }
.app { display: flex; min-height: 100vh; }
.main { margin-left: var(--sb); width: 100%; }
.page { padding: 28px; }
.top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 22px;
}
.ttl { font-size: 26px; font-weight: 800; letter-spacing: -.02em; }
.sub { color: var(--txt2); font-size: 13px; margin-top: 4px; }
.quick { display: flex; gap: 10px; flex-wrap: wrap; }
.btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--blue);
    color: #fff;
    border: 0;
    border-radius: 11px;
    padding: 10px 14px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
}
.grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 18px; }
.card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 14px;
    box-shadow: var(--shadow);
    padding: 16px;
}
.k { font-size: 12px; color: var(--txt2); font-weight: 600; }
.v { font-size: 26px; font-weight: 800; margin-top: 4px; }
.badges { display: flex; gap: 7px; flex-wrap: wrap; margin-top: 10px; }
.b {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    border-radius: 999px;
    padding: 5px 9px;
    font-size: 11px;
    font-weight: 700;
}
.b-hadir { background: var(--green-bg); color: var(--green); }
.b-sakit { background: var(--amber-bg); color: var(--amber); }
.b-izin { background: var(--blue-bg); color: var(--blue); }
.b-alpha { background: var(--red-bg); color: var(--red); }
.list-wrap {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 14px;
    box-shadow: var(--shadow);
    overflow: hidden;
}
.list-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 16px;
    border-bottom: 1px solid var(--border);
}
.list-title { font-size: 15px; font-weight: 800; }
.tbl { width: 100%; border-collapse: collapse; }
.tbl th {
    text-align: left;
    font-size: 11px;
    color: var(--txt2);
    text-transform: uppercase;
    letter-spacing: .05em;
    padding: 10px 16px;
    border-bottom: 1px solid var(--border);
}
.tbl td {
    font-size: 13px;
    padding: 11px 16px;
    border-bottom: 1px solid #f2f4f7;
}
.tbl tr:last-child td { border-bottom: 0; }
.empty { color: var(--txt2); padding: 20px 16px; font-size: 13px; }
.row {
    display: grid;
    grid-template-columns: 1.3fr 1fr;
    gap: 14px;
    margin-top: 14px;
}

.schedule-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 12px;
}

.schedule-card {
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 14px 16px;
    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
}

.schedule-day {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 8px;
    border-radius: 999px;
    background: var(--blue-bg);
    color: var(--blue);
    font-size: 11px;
    font-weight: 800;
    margin-bottom: 10px;
}

.schedule-subject {
    font-size: 15px;
    font-weight: 800;
    color: var(--txt);
    margin-bottom: 4px;
}

.schedule-meta {
    font-size: 12px;
    color: var(--txt2);
    line-height: 1.5;
}

@media (max-width: 1024px) {
    .grid { grid-template-columns: repeat(2, 1fr); }
    .row { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
    .main { margin-left: 0; }
    .page { padding: 16px; }
    .grid { grid-template-columns: 1fr; }
}
</style>

<style>
.announcement-ticker { overflow:hidden; border:1px solid #bfdbfe; border-radius:12px; background:linear-gradient(90deg,#eff6ff,#eef2ff); margin:0 16px 14px; }
.announcement-ticker-track { display:flex; width:max-content; animation: announcementMarquee 28s linear infinite; }
.announcement-ticker:hover .announcement-ticker-track { animation-play-state:paused; }
.announcement-ticker-item { display:flex; align-items:center; gap:8px; min-width:max-content; padding:10px 22px; color:#1e40af; font-size:12px; font-weight:700; }
.announcement-ticker-item i { color:#2563eb; }
@keyframes announcementMarquee { from { transform:translateX(0); } to { transform:translateX(-50%); } }
@media (prefers-reduced-motion: reduce) { .announcement-ticker-track { animation:none; } }
</style>

<div class="app">
    @include('partials.sidebar')

    <div class="main">
        <div class="page">
            <div class="top">
                <div>
                    <div class="ttl">Dashboard Guru</div>
                    <div class="sub">Halo, {{ $user->name }}. Kelola absensi dan nilai siswa dari satu tempat.</div>
                </div>
                <div class="quick">
                    <a class="btn" href="{{ route('absensi.admin') }}">
                        <i class="fas fa-calendar-check"></i> Input Absensi
                    </a>
                    <a class="btn" href="{{ route('nilai.admin') }}">
                        <i class="fas fa-star"></i> Input Nilai
                    </a>
                    <a class="btn" href="{{ route('exam-results.index') }}">
                        <i class="fas fa-poll"></i> Hasil Ujian
                    </a>
                </div>
            </div>

            @php
                $hadirMonth = (int)($monthStats['hadir'] ?? 0);
                $totalMonth = (int)($monthStats['hadir'] ?? 0) + (int)($monthStats['sakit'] ?? 0) + (int)($monthStats['izin'] ?? 0) + (int)($monthStats['alpha'] ?? 0);
                $teacherAttendancePct = $totalMonth > 0 ? round(($hadirMonth / $totalMonth) * 100) : 0;
            @endphp
            <div class="dm-progress-source" data-progress="{{ $teacherAttendancePct }}" data-progress-label="Kehadiran" style="display:none;"></div>

            <div class="grid">
                <div class="card">
                    <div class="k">Total Siswa</div>
                    <div class="v">{{ $totalStudents }}</div>
                </div>
                <div class="card">
                    <div class="k">Total Guru</div>
                    <div class="v">{{ $totalTeachers }}</div>
                </div>
                <div class="card">
                    <div class="k">Input Nilai UTS</div>
                    <div class="v">{{ $totalNilaiUTS }}</div>
                </div>
                <div class="card">
                    <div class="k">Input Nilai UAS</div>
                    <div class="v">{{ $totalNilaiUAS }}</div>
                </div>
            </div>

            <div class="card">
                <div class="k">Ringkasan Absensi Bulan Ini</div>
                <div class="badges">
                    <span class="b b-hadir"><i class="fas fa-circle"></i> Hadir: {{ $monthStats['hadir'] ?? 0 }}</span>
                    <span class="b b-sakit"><i class="fas fa-circle"></i> Sakit: {{ $monthStats['sakit'] ?? 0 }}</span>
                    <span class="b b-izin"><i class="fas fa-circle"></i> Izin: {{ $monthStats['izin'] ?? 0 }}</span>
                    <span class="b b-alpha"><i class="fas fa-circle"></i> Alpha: {{ $monthStats['alpha'] ?? 0 }}</span>
                </div>
            </div>

            <div class="row">
                <div class="list-wrap">
                    <div class="list-head">
                        <div class="list-title">Absensi Hari Ini</div>
                        <a href="{{ route('absensi.admin') }}" style="font-size:12px;font-weight:700;color:var(--blue);">Kelola</a>
                    </div>
                    @if(($todayAttendances ?? collect())->count() > 0)
                        <table class="tbl">
                            <thead>
                                <tr>
                                    <th>Siswa</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayAttendances->take(8) as $item)
                                    <tr>
                                        <td>{{ $item->student->name ?? '-' }}</td>
                                        <td>{{ ucfirst($item->status) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty">Belum ada absensi hari ini.</div>
                    @endif
                </div>

                <div class="list-wrap">
                    <div class="list-head">
                        <div class="list-title">Nilai Terbaru</div>
                        <a href="{{ route('nilai.admin') }}" style="font-size:12px;font-weight:700;color:var(--blue);">Kelola</a>
                    </div>
                    @if(($recentNilai ?? collect())->count() > 0)
                        <table class="tbl">
                            <thead>
                                <tr>
                                    <th>Siswa</th>
                                    <th>Mapel</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentNilai->take(8) as $item)
                                    <tr>
                                        <td>{{ $item->student->name ?? '-' }}</td>
                                        <td>{{ $item->subject->name ?? '-' }}</td>
                                        <td>{{ $item->nilai }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty">Belum ada input nilai terbaru.</div>
                    @endif
                </div>
            </div>

            @if(($announcements ?? collect())->count() > 0)
                <div class="list-wrap" style="margin-top:14px;">
                    <div class="list-head">
                        <div class="list-title">Pengumuman Terbaru</div>
                    </div>
                    <div class="announcement-ticker" aria-label="Pengumuman berjalan">
                        <div class="announcement-ticker-track">
                            @foreach($announcements->take(5) as $a)
                                <div class="announcement-ticker-item"><i class="fas fa-bullhorn"></i><span>{{ $a->title }}</span>@if($a->is_pinned)<strong>• PIN</strong>@endif</div>
                            @endforeach
                            @foreach($announcements->take(5) as $a)
                                <div class="announcement-ticker-item" aria-hidden="true"><i class="fas fa-bullhorn"></i><span>{{ $a->title }}</span>@if($a->is_pinned)<strong>• PIN</strong>@endif</div>
                            @endforeach
                        </div>
                    </div>
                    <table class="tbl">
                        <thead>
                            <tr>
                                <th style="width:50%;">Judul & Ringkasan</th>
                                <th>Oleh</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($announcements->take(5) as $a)
                                <tr>
                                    <td>
                                        <div style="font-weight:800;display:flex;align-items:center;gap:8px;">
                                            @if(!empty($a->is_pinned) && $a->is_pinned)
                                                <span style="background:var(--amber-bg);color:var(--amber);padding:4px 8px;border-radius:8px;font-size:11px;font-weight:800;">PIN</span>
                                            @endif
                                            <div>{{ $a->title }}</div>
                                        </div>
                                        @if(!empty($a->body))
                                            <div style="font-size:13px;color:var(--txt2);margin-top:6px;">{{ \Illuminate\Support\Str::limit(strip_tags($a->body), 120) }}</div>
                                        @endif
                                    </td>
                                    @php
                                        $announcerName = $a->user?->name ?? '-';
                                        $rawRole = $a->user?->role ?? null;
                                        $roleLabel = null;
                                        if ($rawRole === 'kepala_sekolah') $roleLabel = 'Kepala Sekolah';
                                        elseif ($rawRole === 'admin') $roleLabel = 'Admin';
                                        elseif ($rawRole === 'guru' || $rawRole === 'teacher') $roleLabel = 'Guru';
                                        elseif ($rawRole === 'siswa') $roleLabel = 'Siswa';
                                        elseif ($rawRole) $roleLabel = ucfirst($rawRole);
                                    @endphp
                                    <td>
                                        <div style="font-weight:700;">{{ $announcerName }}</div>
                                        @if($roleLabel)
                                            <div style="font-size:12px;color:var(--txt2);">{{ $roleLabel }}</div>
                                        @endif
                                    </td>
                                    <td>{{ $a->created_at?->format('d M Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="list-wrap" style="margin-top:14px;">
                    <div class="list-head">
                        <div class="list-title">Pengumuman Terbaru</div>
                    </div>
                    <div class="empty">Belum ada pengumuman untuk saat ini.</div>
                </div>
            @endif
        </div>
    </div>
</div>

@include('partials.dashboard-motion')
@endsection
