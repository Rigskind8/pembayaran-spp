@extends('layouts.app')

@section('title', 'Absensi Mengajar Guru')

@section('content')
<style>
.teacher-attendance-app {
    --sb: 72px;
    --bg: radial-gradient(1200px 600px at -10% -10%, rgba(20, 184, 166, .16), transparent 55%), radial-gradient(900px 500px at 110% -20%, rgba(30, 64, 175, .14), transparent 58%), #f4f7fc;
    --card: #ffffff;
    --border: #dbe5f2;
    --txt: #0f172a;
    --txt2: #64748b;
    --ok: #047857;
    --ok-bg: #ecfdf5;
    --warn: #b45309;
    --warn-bg: #fffbeb;
    --danger: #b91c1c;
    --danger-bg: #fef2f2;
    --accent: #0f766e;
    --accent-2: #1d4ed8;
    --shadow: 0 8px 28px rgba(15, 23, 42, .08);
    min-height: 100vh;
    background: var(--bg);
    color: var(--txt);
    display: flex;
}

html[data-theme='dark'] .teacher-attendance-app {
    --bg: radial-gradient(1200px 600px at -10% -10%, rgba(20, 184, 166, .2), transparent 55%), radial-gradient(900px 500px at 110% -20%, rgba(37, 99, 235, .16), transparent 58%), #071019;
    --card: #0f172a;
    --border: #1f334a;
    --txt: #e2e8f0;
    --txt2: #93a4ba;
    --ok: #34d399;
    --ok-bg: rgba(52, 211, 153, .12);
    --warn: #f59e0b;
    --warn-bg: rgba(251, 191, 36, .11);
    --danger: #f87171;
    --danger-bg: rgba(248, 113, 113, .11);
    --accent: #14b8a6;
    --accent-2: #60a5fa;
    --shadow: 0 14px 34px rgba(2, 6, 23, .35);
}

.teacher-main {
    width: 100%;
    padding: 24px 24px 34px;
}

.teacher-shell {
    max-width: 1280px;
    margin: 0 auto;
    display: grid;
    gap: 16px;
}

.teacher-hero {
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, .22);
    border-radius: 22px;
    padding: 24px;
    background: linear-gradient(140deg, #134e4a 0%, #0e7490 46%, #1d4ed8 100%);
    box-shadow: 0 18px 36px rgba(15, 23, 42, .18);
    color: #f8fafc;
}

.teacher-hero::after {
    content: '';
    position: absolute;
    width: 320px;
    height: 320px;
    border-radius: 50%;
    top: -135px;
    right: -95px;
    background: radial-gradient(circle, rgba(255, 255, 255, .3) 0%, rgba(255, 255, 255, 0) 70%);
}

.teacher-hero-head {
    position: relative;
    z-index: 1;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    flex-wrap: wrap;
}

.teacher-kicker {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .12em;
    padding: 6px 10px;
    border-radius: 999px;
    border: 1px solid rgba(255, 255, 255, .32);
    background: rgba(255, 255, 255, .14);
}

.teacher-title {
    margin-top: 10px;
    font-family: 'Syne', 'Plus Jakarta Sans', sans-serif;
    font-size: 30px;
    font-weight: 800;
    line-height: 1.16;
    letter-spacing: -.03em;
}

.teacher-sub {
    margin-top: 8px;
    max-width: 740px;
    font-size: 14px;
    color: rgba(248, 250, 252, .88);
}

.teacher-chip {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 12px;
    border-radius: 11px;
    background: rgba(0, 0, 0, .18);
    border: 1px solid rgba(255, 255, 255, .25);
    font-weight: 700;
    font-size: 12px;
}

.teacher-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.teacher-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    border-radius: 11px;
    padding: 10px 14px;
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
    border: 1px solid rgba(255, 255, 255, .24);
    color: #f8fafc;
    background: rgba(255, 255, 255, .14);
    transition: transform .15s ease, background .15s ease;
}

.teacher-btn:hover {
    transform: translateY(-1px);
    background: rgba(255, 255, 255, .22);
}

.teacher-grid {
    display: grid;
    gap: 12px;
    grid-template-columns: repeat(3, minmax(0, 1fr));
}

.teacher-stat {
    border: 1px solid var(--border);
    border-radius: 16px;
    background: var(--card);
    box-shadow: var(--shadow);
    padding: 14px 16px;
}

.teacher-stat-label {
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--txt2);
}

.teacher-stat-value {
    font-size: 30px;
    font-weight: 800;
    line-height: 1.1;
    margin-top: 6px;
}

.teacher-stat-note {
    margin-top: 2px;
    font-size: 12px;
    color: var(--txt2);
}

.teacher-stat.ok .teacher-stat-value { color: var(--ok); }
.teacher-stat.warn .teacher-stat-value { color: var(--warn); }

.teacher-card {
    border: 1px solid var(--border);
    border-radius: 18px;
    background: var(--card);
    box-shadow: var(--shadow);
    overflow: hidden;
}

.teacher-card-head {
    padding: 14px 16px;
    border-bottom: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.teacher-card-title {
    font-size: 16px;
    font-weight: 800;
    letter-spacing: -.02em;
}

.teacher-card-sub {
    font-size: 12px;
    color: var(--txt2);
}

.teacher-table-wrap {
    overflow-x: auto;
}

.teacher-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    min-width: 980px;
}

.teacher-table th {
    text-align: left;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .09em;
    text-transform: uppercase;
    color: var(--txt2);
    background: color-mix(in srgb, var(--card) 86%, #dbeafe 14%);
    padding: 12px;
    border-bottom: 1px solid var(--border);
}

.teacher-table td {
    padding: 12px;
    font-size: 13px;
    color: var(--txt);
    border-bottom: 1px solid color-mix(in srgb, var(--border) 76%, transparent);
    vertical-align: top;
}

.teacher-table tr:nth-child(even) td {
    background: color-mix(in srgb, var(--card) 95%, #dbeafe 5%);
}

.teacher-table tr:hover td {
    background: color-mix(in srgb, var(--card) 85%, #bfdbfe 15%);
}

.teacher-subject {
    font-weight: 800;
    letter-spacing: -.01em;
}

.teacher-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border-radius: 999px;
    padding: 5px 10px;
    font-size: 11px;
    font-weight: 800;
    border: 1px solid transparent;
}

.teacher-badge.hadir {
    color: var(--ok);
    background: var(--ok-bg);
    border-color: color-mix(in srgb, var(--ok) 30%, transparent);
}

.teacher-badge.izin,
.teacher-badge.sakit {
    color: var(--warn);
    background: var(--warn-bg);
    border-color: color-mix(in srgb, var(--warn) 30%, transparent);
}

.teacher-badge.alpha,
.teacher-badge.belum {
    color: var(--danger);
    background: var(--danger-bg);
    border-color: color-mix(in srgb, var(--danger) 30%, transparent);
}

.teacher-time {
    margin-top: 6px;
    font-size: 11px;
    color: var(--txt2);
}

.teacher-form {
    display: grid;
    grid-template-columns: 118px 1fr auto;
    gap: 8px;
}

.teacher-select,
.teacher-input {
    width: 100%;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 8px 10px;
    font-size: 12px;
    color: var(--txt);
    background: color-mix(in srgb, var(--card) 93%, #f8fafc 7%);
    outline: none;
}

.teacher-select:focus,
.teacher-input:focus {
    border-color: color-mix(in srgb, var(--accent-2) 52%, #fff 48%);
    box-shadow: 0 0 0 3px color-mix(in srgb, var(--accent-2) 14%, transparent);
}

.teacher-save {
    border: 0;
    border-radius: 10px;
    padding: 9px 12px;
    font-size: 12px;
    font-weight: 800;
    color: #fff;
    background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
    cursor: pointer;
    white-space: nowrap;
}

.teacher-save:hover {
    filter: saturate(112%);
}

.teacher-flash {
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 10px 12px;
    font-size: 13px;
    font-weight: 600;
}

.teacher-flash.success {
    color: var(--ok);
    background: var(--ok-bg);
    border-color: color-mix(in srgb, var(--ok) 32%, transparent);
}

.teacher-flash.error {
    color: var(--danger);
    background: var(--danger-bg);
    border-color: color-mix(in srgb, var(--danger) 32%, transparent);
}

.teacher-empty {
    border: 1px dashed var(--border);
    border-radius: 15px;
    padding: 24px 16px;
    text-align: center;
    color: var(--txt2);
    background: color-mix(in srgb, var(--card) 92%, #f1f5f9 8%);
}

@media (max-width: 1120px) {
    .teacher-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 900px) {
    .teacher-main {
        margin-left: 0;
        padding: 16px;
    }
}

@media (max-width: 780px) {
    .teacher-title {
        font-size: 24px;
    }

    .teacher-form {
        grid-template-columns: 1fr;
    }

    .teacher-save {
        width: 100%;
    }
}
</style>

@php
    $presentCount = $attendances->count();
    $totalCount = $schedules->count();
    $pendingCount = max($totalCount - $presentCount, 0);
@endphp

<div class="teacher-attendance-app">
    <main class="teacher-main">
        <div class="teacher-shell">
            <section class="teacher-hero">
                <div class="teacher-hero-head">
                    <div>
                        <span class="teacher-kicker"><i class="fas fa-wave-square"></i> Teaching Presence Tracker</span>
                        <h1 class="teacher-title">Absensi Mengajar Guru</h1>
                        <p class="teacher-sub">Update kehadiran mengajar setiap sesi dengan cepat. Data hari ini ditampilkan real-time agar Anda mudah memantau kelas yang sudah dan belum diisi absensinya.</p>
                    </div>

                    <div class="teacher-actions">
                        <span class="teacher-chip"><i class="fas fa-calendar-day"></i> {{ $dayName }}, {{ $today->format('d M Y') }}</span>
                        <a href="{{ route('teacher.schedule') }}" class="teacher-btn"><i class="fas fa-calendar-days"></i> Lihat Jadwal Mengajar</a>
                    </div>
                </div>
            </section>

            <section class="teacher-grid">
                <article class="teacher-stat">
                    <div class="teacher-stat-label">Total Sesi Hari Ini</div>
                    <div class="teacher-stat-value">{{ $totalCount }}</div>
                    <div class="teacher-stat-note">Jadwal aktif pada {{ $dayName }}</div>
                </article>

                <article class="teacher-stat ok">
                    <div class="teacher-stat-label">Sudah Diabsen</div>
                    <div class="teacher-stat-value">{{ $presentCount }}</div>
                    <div class="teacher-stat-note">Sesi yang sudah memiliki status kehadiran</div>
                </article>

                <article class="teacher-stat warn">
                    <div class="teacher-stat-label">Belum Diabsen</div>
                    <div class="teacher-stat-value">{{ $pendingCount }}</div>
                    <div class="teacher-stat-note">Perlu pembaruan absensi</div>
                </article>
            </section>

            @if(session('success'))
                <div class="teacher-flash success"><i class="fas fa-circle-check"></i> {{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="teacher-flash error"><i class="fas fa-circle-exclamation"></i> {{ session('error') }}</div>
            @endif

            @if($schedules->isEmpty())
                <section class="teacher-empty">
                    <i class="fas fa-inbox" style="font-size:22px;margin-bottom:8px;"></i>
                    <div style="font-weight:700;margin-bottom:4px;">Tidak ada jadwal mengajar untuk hari ini.</div>
                    <div style="font-size:12px;">Cek kembali jadwal atau pilih hari mengajar yang sesuai.</div>
                </section>
            @else
                <section class="teacher-card">
                    <div class="teacher-card-head">
                        <div>
                            <div class="teacher-card-title">Daftar Sesi Mengajar {{ $user->name }}</div>
                            <div class="teacher-card-sub">Isi status kehadiran per sesi agar monitoring lebih akurat.</div>
                        </div>
                    </div>

                    <div class="teacher-table-wrap">
                        <table class="teacher-table">
                            <thead>
                                <tr>
                                    <th>Mapel</th>
                                    <th>Kelas</th>
                                    <th>Jam</th>
                                    <th>Ruang</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                    <th style="width: 320px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schedules as $schedule)
                                    @php
                                        $start = $schedule->start_time instanceof \Carbon\Carbon ? $schedule->start_time->format('H:i') : \Carbon\Carbon::parse($schedule->start_time)->format('H:i');
                                        $end = $schedule->end_time instanceof \Carbon\Carbon ? $schedule->end_time->format('H:i') : \Carbon\Carbon::parse($schedule->end_time)->format('H:i');
                                        $record = $attendances->get($schedule->id);
                                        $statusLabel = strtoupper($record->status ?? 'belum');
                                        $statusClass = $record->status ?? 'belum';
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="teacher-subject">{{ $schedule->subject->name ?? '-' }}</div>
                                        </td>
                                        <td>{{ $schedule->class_id }}</td>
                                        <td>{{ $start }} - {{ $end }}</td>
                                        <td>{{ $schedule->room ?? '-' }}</td>
                                        <td>
                                            <span class="teacher-badge {{ $statusClass }}">
                                                <i class="fas {{ $record ? 'fa-circle-check' : 'fa-hourglass-half' }}"></i>
                                                {{ $statusLabel }}
                                            </span>
                                            @if($record)
                                                <div class="teacher-time">Absen: {{ $record->checked_in_at?->format('H:i') ?? '-' }}</div>
                                            @endif
                                        </td>
                                        <td>{{ $record?->notes ?: '-' }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('teacher.attendance.submit', $schedule) }}" class="teacher-form">
                                                @csrf
                                                <input type="hidden" name="redirect_to" value="{{ request()->fullUrl() }}">

                                                <select name="status" class="teacher-select" required>
                                                    @foreach(['hadir', 'izin', 'sakit', 'alpha'] as $status)
                                                        <option value="{{ $status }}" {{ ($record->status ?? 'hadir') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                                    @endforeach
                                                </select>

                                                <input
                                                    type="text"
                                                    name="notes"
                                                    class="teacher-input"
                                                    value="{{ $record->notes ?? '' }}"
                                                    placeholder="Catatan (opsional)"
                                                    maxlength="255"
                                                >

                                                <button type="submit" class="teacher-save">Simpan</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            @endif
        </div>
    </main>
</div>
@endsection
