@extends('layouts.app')

@section('title', 'Jadwal Mengajar Guru')

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
    --shadow: 0 1px 3px rgba(0,0,0,.06), 0 2px 8px rgba(0,0,0,.04);
}
* { box-sizing: border-box; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--txt); }
.app { display: flex; min-height: 100vh; }
.main { margin-left: var(--sb); width: 100%; }
.page { padding: 28px; }
.top { display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom: 18px; }
.ttl { font-size: 26px; font-weight: 800; letter-spacing: -.02em; }
.sub { color: var(--txt2); font-size: 13px; margin-top: 4px; }
.card { background: var(--card); border: 1px solid var(--border); border-radius: 14px; box-shadow: var(--shadow); padding: 16px; }
.head { display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom: 12px; }
.pill { display:inline-flex; align-items:center; gap:6px; padding:4px 8px; border-radius:999px; background: var(--blue-bg); color: var(--blue); font-size:11px; font-weight:800; }
.day-grid { display:grid; grid-template-columns:repeat(6,minmax(0,1fr)); gap:10px; margin-bottom:16px; }
.day-card { border:1px solid var(--border); border-radius:12px; padding:12px; background:#fff; min-height:110px; }
.day-card.active { border-color:#bfdbfe; background:linear-gradient(180deg,#f8fbff 0%,#ffffff 100%); }
.day-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:8px; }
.day-name { font-size:12px; font-weight:800; color:var(--txt); }
.day-count { font-size:11px; font-weight:800; color:var(--blue); background:var(--blue-bg); padding:3px 8px; border-radius:999px; }
.day-empty { font-size:11px; color:var(--txt2); }
.day-list { display:flex; flex-wrap:wrap; gap:6px; }
.day-sub { font-size:10.5px; font-weight:700; color:#1e3a8a; background:#eef2ff; border:1px solid #dbeafe; border-radius:999px; padding:3px 7px; }
.table-wrap { overflow-x:auto; border:1px solid var(--border); border-radius:14px; }
.tbl { width:100%; min-width:760px; border-collapse:collapse; background:#fff; }
.tbl thead th { text-align:left; font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:var(--txt2); padding:10px 14px; border-bottom:1px solid var(--border); background:#fafafa; }
.tbl tbody td { padding:12px 14px; font-size:13px; border-bottom:1px solid #f2f4f7; }
.tbl tbody tr:last-child td { border-bottom:0; }
.empty { color:var(--txt2); padding:20px 0; }
@media (max-width: 1200px) { .day-grid { grid-template-columns:repeat(3,minmax(0,1fr)); } }
@media (max-width: 760px) { .day-grid { grid-template-columns:repeat(2,minmax(0,1fr)); } }
@media (max-width: 640px) { .main { margin-left:0; } .page { padding:16px; } }
</style>

<div class="app">
    @include('partials.sidebar')
    <div class="main">
        <div class="page">
            <div class="top">
                <div>
                    <div class="ttl">{{ ($isManagementView ?? false) ? 'Jadwal Mengajar Semua Guru' : 'Jadwal Mengajar Saya' }}</div>
                    <div class="sub">
                        {{ ($isManagementView ?? false)
                            ? 'Rekap semua jadwal aktif dari data admin/kepala sekolah: guru, mapel, hari, jam, kelas, dan ruang.'
                            : 'Daftar kelas, mapel, hari, jam, dan ruang yang terhubung ke akun guru ini.' }}
                    </div>
                </div>
                <a href="{{ route('dashboard') }}" class="pill" style="text-decoration:none;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>

            <div class="card">
                @php
                    $dayOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $normalizeDay = function ($rawDay) {
                        $normalized = mb_strtolower(trim((string) $rawDay));
                        return match ($normalized) {
                            'monday', 'senin' => 'Senin',
                            'tuesday', 'selasa' => 'Selasa',
                            'wednesday', 'rabu' => 'Rabu',
                            'thursday', 'kamis' => 'Kamis',
                            'friday', 'jumat' => 'Jumat',
                            'saturday', 'sabtu' => 'Sabtu',
                            default => ucfirst(trim((string) $rawDay)),
                        };
                    };
                    $schedulesByDay = ($teacherSchedules ?? collect())->groupBy(fn($schedule) => $normalizeDay($schedule->day));
                    $activeDays = $schedulesByDay->filter(fn($items) => $items->count() > 0)->count();
                @endphp

                <div class="head">
                    <div>
                        <div style="font-size:15px;font-weight:800;">Jadwal Aktif</div>
                        <div style="font-size:12px;color:var(--txt2);margin-top:3px;">
                            {{ ($isManagementView ?? false)
                                ? 'Menampilkan seluruh jadwal aktif lintas guru.'
                                : 'Hanya schedule yang dibuat admin untuk guru ini.' }}
                        </div>
                    </div>
                    <span class="pill"><i class="fas fa-calendar-days"></i> {{ ($teacherSchedules ?? collect())->count() }} slot · {{ $activeDays }} hari aktif</span>
                </div>

                <div style="font-size:13px;font-weight:800;margin-bottom:10px;">Ringkasan Hari Mengajar</div>
                <div class="day-grid">
                    @foreach($dayOrder as $day)
                        @php
                            $dayItems = $schedulesByDay->get($day, collect());
                            $daySubjects = $dayItems->pluck('subject.name')->filter()->unique()->values();
                            $isActive = $dayItems->count() > 0;
                        @endphp
                        <div class="day-card {{ $isActive ? 'active' : '' }}">
                            <div class="day-head">
                                <span class="day-name">{{ $day }}</span>
                                <span class="day-count">{{ $dayItems->count() }} slot</span>
                            </div>

                            @if($isActive)
                                <div class="day-list">
                                    @foreach($daySubjects->take(3) as $subjectName)
                                        <span class="day-sub">{{ $subjectName }}</span>
                                    @endforeach
                                    @if($daySubjects->count() > 3)
                                        <span class="day-sub">+{{ $daySubjects->count() - 3 }} mapel</span>
                                    @endif
                                </div>
                            @else
                                <div class="day-empty">Tidak ada jadwal</div>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if(($teacherSchedules ?? collect())->count() > 0)
                    <div class="table-wrap">
                        <table class="tbl">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    @if($isManagementView ?? false)
                                        <th>Guru</th>
                                    @endif
                                    <th>Mapel</th>
                                    <th>Kelas</th>
                                    <th>Jam</th>
                                    <th>Ruang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teacherSchedules as $schedule)
                                    @php
                                        $start = $schedule->start_time instanceof \Carbon\Carbon ? $schedule->start_time->format('H:i') : \Carbon\Carbon::parse($schedule->start_time)->format('H:i');
                                        $end = $schedule->end_time instanceof \Carbon\Carbon ? $schedule->end_time->format('H:i') : \Carbon\Carbon::parse($schedule->end_time)->format('H:i');
                                    @endphp
                                    <tr>
                                        <td><span class="pill">{{ $normalizeDay($schedule->day) }}</span></td>
                                        @if($isManagementView ?? false)
                                            <td>{{ $schedule->teacher->name ?? $schedule->subject->teacher ?? '-' }}</td>
                                        @endif
                                        <td><strong>{{ $schedule->subject->name ?? '-' }}</strong></td>
                                        <td>{{ $schedule->class_id }}</td>
                                        <td>{{ $start }} - {{ $end }}</td>
                                        <td>{{ $schedule->room ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty">Belum ada jadwal ngajar yang ditetapkan admin.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection