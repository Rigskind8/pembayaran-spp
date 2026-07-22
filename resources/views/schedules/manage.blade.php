@extends('layouts.app')

@php
    $formatTime = function ($value) {
        if ($value instanceof \Carbon\CarbonInterface) {
            return $value->format('H:i');
        }

        try {
            return \Carbon\Carbon::parse((string) $value)->format('H:i');
        } catch (\Throwable $e) {
            return trim((string) $value);
        }
    };

    $totalSchedules = $schedules->total();
    $totalClasses = count($classOptions);
    $totalSubjects = $subjects->count();
    $totalTeachers = $teachers->count();
@endphp

@section('content')
<style>
    .schedule-shell {
        min-height: 100vh;
        background:
            radial-gradient(circle at top left, rgba(59,130,246,.12), transparent 32%),
            radial-gradient(circle at top right, rgba(249,115,22,.12), transparent 28%),
            linear-gradient(180deg, #f8fbff 0%, #f3f7fc 100%);
    }

    .schedule-hero {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(148,163,184,.25);
        border-radius: 24px;
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 55%, #2563eb 100%);
        color: #fff;
        box-shadow: 0 20px 45px rgba(15,23,42,.14);
    }

    .schedule-hero::after {
        content: '';
        position: absolute;
        inset: auto -90px -90px auto;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(255,255,255,.08);
        filter: blur(2px);
    }

    .schedule-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 12px;
        border-radius: 999px;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.14);
        color: rgba(255,255,255,.92);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .02em;
    }

    .schedule-card {
        background: rgba(255,255,255,.86);
        border: 1px solid rgba(148,163,184,.18);
        border-radius: 22px;
        box-shadow: 0 16px 32px rgba(15,23,42,.06);
        backdrop-filter: blur(10px);
    }

    .schedule-panel-title {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -.01em;
    }

    .schedule-muted {
        color: #64748b;
    }

    .schedule-grid {
        display: grid;
        gap: 16px;
    }

    .schedule-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .stat-card {
        padding: 18px;
        border-radius: 20px;
        background: rgba(255,255,255,.92);
        border: 1px solid rgba(148,163,184,.16);
        box-shadow: 0 10px 24px rgba(15,23,42,.05);
    }

    .stat-label {
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
    }

    .stat-value {
        margin-top: 8px;
        color: #0f172a;
        font-size: 28px;
        font-weight: 900;
        line-height: 1;
    }

    .stat-note {
        margin-top: 8px;
        color: #64748b;
        font-size: 12px;
    }

    .toolbar-grid {
        display: grid;
        grid-template-columns: 1.2fr .9fr;
        gap: 16px;
    }

    .schedule-box {
        padding: 18px;
        border-radius: 18px;
        border: 1px solid rgba(148,163,184,.18);
        background: #fff;
    }

    .field-label {
        display: block;
        margin-bottom: 7px;
        color: #334155;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .field-control {
        width: 100%;
        padding: 12px 14px;
        border-radius: 14px;
        border: 1px solid #cbd5e1;
        background: #fff;
        color: #0f172a;
        transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
    }

    .field-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59,130,246,.12);
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 16px;
        border: none;
        border-radius: 14px;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #fff;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 0 14px 24px rgba(37,99,235,.22);
        transition: transform .18s ease, box-shadow .18s ease, opacity .18s ease;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 18px 28px rgba(37,99,235,.26);
        color: #fff;
    }

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 16px;
        border-radius: 14px;
        background: #fff;
        border: 1px solid #cbd5e1;
        color: #0f172a;
        font-weight: 800;
        text-decoration: none;
    }

    .btn-warm {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 16px;
        border-radius: 14px;
        border: none;
        background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
        color: #fff;
        font-weight: 800;
        box-shadow: 0 14px 24px rgba(249,115,22,.24);
    }

    .badge-soft {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 999px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 12px;
        font-weight: 800;
    }

    .teacher-overview {
        margin-top: 12px;
        padding: 14px;
        border-radius: 14px;
        border: 1px solid #dbeafe;
        background: #eff6ff;
        display: grid;
        gap: 10px;
    }

    .teacher-days {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .teacher-day-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        border: 1px solid #bfdbfe;
        background: #fff;
        color: #1e3a8a;
        padding: 6px 10px;
        font-size: 12px;
        font-weight: 800;
    }

    .teacher-search-row {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .teacher-search-row .field-control {
        flex: 1;
    }

    .table-wrap {
        overflow: auto;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        background: #fff;
    }

    .schedule-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .schedule-table thead th {
        position: sticky;
        top: 0;
        z-index: 1;
        padding: 14px 16px;
        background: #f8fafc;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: .06em;
        font-size: 11px;
        font-weight: 900;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .schedule-table tbody td {
        padding: 15px 16px;
        border-bottom: 1px solid #eef2f7;
        vertical-align: middle;
        color: #0f172a;
    }

    .schedule-table tbody tr:hover {
        background: #f8fbff;
    }

    .action-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 11px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 800;
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none;
        transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
    }

    .action-link:hover {
        transform: translateY(-1px);
    }

    .action-edit {
        background: #eff6ff;
        color: #1d4ed8;
        border-color: #bfdbfe;
    }

    .action-delete {
        background: #fef2f2;
        color: #b91c1c;
        border-color: #fecaca;
    }

    .empty-state {
        padding: 36px 18px;
        text-align: center;
        color: #64748b;
        background: #fff;
        border: 1px dashed #cbd5e1;
        border-radius: 18px;
    }

    .pagination-wrap {
        margin-top: 18px;
        padding-top: 16px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
    }

    .pagination-wrap .pagination {
        margin: 0;
        flex-wrap: wrap;
        gap: .35rem;
    }

    .pagination-wrap .page-item {
        margin: 0;
    }

    .pagination-wrap .page-link {
        min-width: 40px;
        padding: 8px 12px;
        border-radius: 12px !important;
        border: 1px solid rgba(148,163,184,.35);
        color: #0f172a;
        background: #fff;
        transition: all .15s ease;
        box-shadow: none;
    }

    .pagination-wrap .page-link:hover {
        background: #f8fafc;
    }

    .pagination-wrap .page-item.active .page-link {
        background: #2563eb;
        border-color: #2563eb;
        color: #fff;
        box-shadow: 0 12px 24px rgba(37,99,235,.12);
    }

    .pagination-wrap .page-item.disabled .page-link {
        background: #f8fafc;
        border-color: #e2e8f0;
        color: #94a3b8;
        cursor: not-allowed;
    }

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15,23,42,.56);
        backdrop-filter: blur(6px);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 24px;
        z-index: 60;
    }

    .modal-overlay.open {
        display: flex;
    }

    .modal-panel {
        width: min(760px, 100%);
        max-height: 90vh;
        overflow: auto;
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 28px 70px rgba(15,23,42,.24);
    }

    .modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        padding: 20px 22px 0;
    }

    .modal-body {
        padding: 20px 22px 22px;
    }

    .modal-close {
        border: none;
        background: #f1f5f9;
        color: #0f172a;
        width: 38px;
        height: 38px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 6px;
        flex-wrap: wrap;
    }

    .alert-box {
        padding: 14px 16px;
        border-radius: 16px;
        font-weight: 700;
    }

    .alert-success {
        background: #ecfdf5;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .alert-danger {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    @media (max-width: 1100px) {
        .schedule-stats,
        .toolbar-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 860px) {
        .schedule-stats,
        .toolbar-grid,
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="schedule-shell">
    <div class="app">
        @include('partials.sidebar')

        <div class="main">
            <div class="page schedule-grid" style="padding-top:24px;">
                <section class="schedule-hero">
                    <div style="position:relative; z-index:1; padding:24px; display:grid; gap:16px;">
                        <div style="display:flex; flex-wrap:wrap; gap:10px; align-items:center;">
                            <span class="schedule-chip"><i class="fas fa-calendar-days"></i> Penjadwalan otomatis</span>
                            <span class="schedule-chip"><i class="fas fa-layer-group"></i> {{ $totalClasses }} kelas</span>
                            <span class="schedule-chip"><i class="fas fa-book-open"></i> {{ $totalSubjects }} mapel aktif</span>
                        </div>
                        <div style="max-width:760px;">
                            <div style="font-size:30px; font-weight:900; line-height:1.15; letter-spacing:-.03em;">Jadwal yang lebih mudah dibaca, lebih cepat dikelola, dan lebih enak dipakai admin.</div>
                            <div style="margin-top:10px; max-width:720px; color:rgba(255,255,255,.82); font-size:14px; line-height:1.7;">Gunakan generator otomatis untuk menyusun jadwal per kelas dan per hari, lalu edit detailnya langsung dari tabel tanpa pindah halaman.</div>
                        </div>
                        <div style="display:flex; flex-wrap:wrap; gap:10px;">
                            <span class="badge-soft">{{ $totalSchedules }} jadwal terdata</span>
                            <span class="badge-soft">{{ $totalTeachers }} guru terhubung</span>
                            <span class="badge-soft">{{ $schedules->lastPage() }} halaman data</span>
                        </div>
                    </div>
                </section>

                <section class="schedule-stats">
                    <div class="stat-card">
                        <div class="stat-label">Total Jadwal</div>
                        <div class="stat-value">{{ $totalSchedules }}</div>
                        <div class="stat-note">Semua entri yang tampil pada daftar jadwal.</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Kelas Aktif</div>
                        <div class="stat-value">{{ $totalClasses }}</div>
                        <div class="stat-note">Kelas yang tersedia untuk penjadwalan otomatis.</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Mapel Aktif</div>
                        <div class="stat-value">{{ $totalSubjects }}</div>
                        <div class="stat-note">Mata pelajaran yang siap dipakai generator.</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Guru Tersedia</div>
                        <div class="stat-value">{{ $totalTeachers }}</div>
                        <div class="stat-note">Guru yang dapat dipasangkan ke jadwal.</div>
                    </div>
                </section>

                @if(session('success'))
                    <div class="alert-box alert-success">✓ {{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert-box alert-danger">
                        @foreach($errors->all() as $error)
                            <div>✕ {{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <section class="toolbar-grid">
                    <div class="schedule-card">
                        <div class="schedule-box">
                            <div class="schedule-panel-title">Filter Jadwal</div>
                            <div class="schedule-muted" style="margin-top:6px; margin-bottom:16px;">Saring jadwal berdasarkan kelas dan hari agar data lebih fokus.</div>

                            <form action="{{ route('schedule.manage') }}" method="GET" class="schedule-grid" style="gap:14px;">
                                <div class="form-grid">
                                    <div>
                                        <label class="field-label">Filter Kelas</label>
                                        <select name="class" class="field-control">
                                            <option value="">Semua Kelas</option>
                                            @foreach($classOptions as $class)
                                                <option value="{{ $class }}" {{ $selectedClass === $class ? 'selected' : '' }}>{{ $class }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="field-label">Filter Hari</label>
                                        <select name="day" class="field-control">
                                            <option value="">Semua Hari</option>
                                            @foreach($dayOptions as $day)
                                                <option value="{{ $day }}" {{ $selectedDay === $day ? 'selected' : '' }}>{{ $day }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="field-label">Cari Guru</label>
                                        <div class="teacher-search-row">
                                            <input
                                                type="text"
                                                name="teacher"
                                                list="teacher-list"
                                                class="field-control"
                                                placeholder="Contoh: Ryan"
                                                value="{{ $selectedTeacher ?? '' }}"
                                            >
                                            <button type="submit" class="btn-secondary">
                                                <i class="fas fa-search"></i> Cari Guru
                                            </button>
                                        </div>
                                        <datalist id="teacher-list">
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->name }}"></option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>

                                <div class="form-actions" style="justify-content:flex-start; margin-top:4px;">
                                    <button type="submit" name="search_mode" value="teacher" class="btn-secondary">
                                        <i class="fas fa-search"></i> Cari Guru
                                    </button>
                                    <button type="submit" class="btn-primary"><i class="fas fa-filter"></i> Terapkan</button>
                                    <a href="{{ route('schedule.manage') }}" class="btn-secondary"><i class="fas fa-rotate-left"></i> Reset</a>
                                </div>
                            </form>

                            @if(!empty($teacherScheduleOverview['query']))
                                <div class="teacher-overview">
                                    @if(($teacherScheduleOverview['total_slots'] ?? 0) > 0)
                                        <div style="font-size:13px; font-weight:800; color:#1e3a8a;">
                                            Hasil pencarian guru: {{ $teacherScheduleOverview['display_name'] }}
                                        </div>
                                        <div class="schedule-muted" style="font-size:12px;">
                                            Total {{ $teacherScheduleOverview['total_slots'] }} slot ditemukan.
                                        </div>
                                        <div class="teacher-days">
                                            @foreach($teacherScheduleOverview['active_days'] as $dayInfo)
                                                <span class="teacher-day-chip">
                                                    <i class="fas fa-calendar-day"></i>
                                                    {{ $dayInfo['day'] }}
                                                    <span style="color:#475569; font-weight:700;">({{ $dayInfo['count'] }} slot)</span>
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <div style="font-size:13px; font-weight:800; color:#991b1b;">
                                            Guru "{{ $teacherScheduleOverview['query'] }}" tidak ditemukan pada jadwal aktif.
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="schedule-card">
                        <div class="schedule-box" style="height:100%; display:flex; flex-direction:column; justify-content:space-between;">
                            <div>
                                <div class="schedule-panel-title">Generator Jadwal Mingguan</div>
                                <div class="schedule-muted" style="margin-top:6px; line-height:1.7;">Buat ulang jadwal otomatis dengan jam berbeda tiap hari, distribusi guru yang merata, dan perlindungan bentrok guru maupun kelas. Proses ini akan mengganti jadwal lama pada kelas yang sama.</div>
                            </div>
                            <form action="{{ route('schedule.generate-weekly') }}" method="POST" onsubmit="return confirm('Generate ulang jadwal mingguan semua kelas? Jadwal lama akan diganti.');" style="margin-top:14px;">
                                @csrf
                                <button type="submit" class="btn-warm" style="width:100%;">
                                    <i class="fas fa-magic"></i> Generate Otomatis Sekarang
                                </button>
                            </form>
                        </div>
                    </div>
                </section>

                <section class="schedule-card">
                    <div class="schedule-box">
                        <div style="display:flex; justify-content:space-between; gap:16px; align-items:flex-start; flex-wrap:wrap; margin-bottom:18px;">
                            <div>
                                <div class="schedule-panel-title">Tambah Jadwal Baru</div>
                                <div class="schedule-muted" style="margin-top:6px;">Input manual tetap tersedia untuk koreksi cepat atau jadwal khusus.</div>
                            </div>
                            <span class="badge-soft"><i class="fas fa-circle-check"></i>&nbsp; Validasi bentrok guru + kelas aktif</span>
                        </div>

                        <form action="{{ route('schedule.store') }}" method="POST" class="schedule-grid" style="gap:14px;">
                            @csrf
                            <div class="form-grid">
                                <div>
                                    <label class="field-label">Mata Pelajaran</label>
                                    <select name="subject_id" required class="field-control">
                                        <option value="">-- Pilih --</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->code }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="field-label">Guru</label>
                                    <select name="teacher_id" class="field-control">
                                        <option value="">-- Tidak Ada --</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="field-label">Kelas</label>
                                    <input type="text" name="class_id" list="kelas-list" placeholder="X-A" value="{{ old('class_id', $selectedClass) }}" required class="field-control">
                                    <datalist id="kelas-list">
                                        @foreach($classOptions as $class)
                                            <option value="{{ $class }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>

                                <div>
                                    <label class="field-label">Hari</label>
                                    <select name="day" required class="field-control">
                                        <option value="">-- Pilih --</option>
                                        @foreach($dayOptions as $day)
                                            <option value="{{ $day }}" {{ old('day', $selectedDay) === $day ? 'selected' : '' }}>{{ $day }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="field-label">Jam Mulai</label>
                                    <input type="time" name="start_time" required class="field-control">
                                </div>

                                <div>
                                    <label class="field-label">Jam Selesai</label>
                                    <input type="time" name="end_time" required class="field-control">
                                </div>

                                <div>
                                    <label class="field-label">Ruang</label>
                                    <input type="text" name="room" placeholder="Ruang 1" class="field-control">
                                </div>

                                <div style="display:flex; align-items:end;">
                                    <button type="submit" class="btn-primary" style="width:100%;">
                                        <i class="fas fa-plus"></i> Tambah Jadwal
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>

                <section class="schedule-card">
                    <div class="schedule-box">
                        <div style="display:flex; justify-content:space-between; gap:16px; align-items:flex-start; flex-wrap:wrap; margin-bottom:18px;">
                            <div>
                                <div class="schedule-panel-title">Daftar Jadwal</div>
                                <div class="schedule-muted" style="margin-top:6px;">Menampilkan jadwal{{ $selectedClass ? ' kelas ' . $selectedClass : '' }}{{ $selectedDay ? ' hari ' . $selectedDay : ' semua hari' }}.</div>
                            </div>
                            <span class="badge-soft"><i class="fas fa-table-list"></i>&nbsp; {{ $schedules->count() }} data di halaman ini</span>
                        </div>

                        @if($schedules->isEmpty())
                            <div class="empty-state">
                                <div style="font-size:18px; font-weight:800; color:#334155;">Belum ada jadwal yang dibuat</div>
                                <div style="margin-top:8px;">Gunakan generator otomatis atau tambahkan jadwal manual dari form di atas.</div>
                            </div>
                        @else
                            <div class="table-wrap">
                                <table class="schedule-table">
                                    <thead>
                                        <tr>
                                            <th>Mata Pelajaran</th>
                                            <th>Guru</th>
                                            <th>Kelas</th>
                                            <th>Hari</th>
                                            <th>Jam</th>
                                            <th>Ruang</th>
                                            <th style="text-align:center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($schedules as $schedule)
                                            @php
                                                $startTime = $formatTime($schedule->start_time);
                                                $endTime = $formatTime($schedule->end_time);
                                            @endphp
                                            <tr>
                                                <td style="font-weight:800;">{{ $schedule->subject->name }}</td>
                                                <td>{{ $schedule->teacher?->name ?? '-' }}</td>
                                                <td><span class="badge-soft">{{ $schedule->class_id }}</span></td>
                                                <td>{{ $schedule->day }}</td>
                                                <td>{{ $startTime }} - {{ $endTime }}</td>
                                                <td>{{ $schedule->room ?? '-' }}</td>
                                                <td style="text-align:center; white-space:nowrap;">
                                                    <button
                                                        type="button"
                                                        class="action-link action-edit"
                                                        onclick="openEditModal(this)"
                                                        data-id="{{ $schedule->id }}"
                                                        data-subject-id="{{ $schedule->subject_id }}"
                                                        data-teacher-id="{{ $schedule->teacher_id }}"
                                                        data-class-id="{{ $schedule->class_id }}"
                                                        data-day="{{ $schedule->day }}"
                                                        data-start-time="{{ $startTime }}"
                                                        data-end-time="{{ $endTime }}"
                                                        data-room="{{ $schedule->room }}"
                                                        data-update-url="{{ route('schedule.update', $schedule) }}"
                                                    >
                                                        <i class="fas fa-pen"></i> Edit
                                                    </button>
                                                    <form action="{{ route('schedule.destroy', $schedule) }}" method="POST" style="display:inline; margin-left:6px;" onsubmit="return confirm('Hapus jadwal ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="action-link action-delete">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="pagination-wrap">
                                <span>Menampilkan {{ $schedules->firstItem() }}–{{ $schedules->lastItem() }} dari {{ $schedules->total() }} jadwal</span>
                                <div>
                                    {{ $schedules->withQueryString()->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<div class="modal-overlay" id="editScheduleModal" aria-hidden="true">
    <div class="modal-panel">
        <div class="modal-header">
            <div>
                <div class="schedule-panel-title">Edit Jadwal</div>
                <div class="schedule-muted" style="margin-top:6px;">Perbaiki data jadwal tanpa meninggalkan halaman ini.</div>
            </div>
            <button type="button" class="modal-close" onclick="closeEditModal()" aria-label="Tutup modal">
                <i class="fas fa-xmark"></i>
            </button>
        </div>

        <div class="modal-body">
            <form id="editScheduleForm" method="POST" class="schedule-grid" style="gap:14px;">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div>
                        <label class="field-label">Mata Pelajaran</label>
                        <select name="subject_id" id="edit_subject_id" required class="field-control">
                            <option value="">-- Pilih --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="field-label">Guru</label>
                        <select name="teacher_id" id="edit_teacher_id" class="field-control">
                            <option value="">-- Tidak Ada --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="field-label">Kelas</label>
                        <input type="text" name="class_id" id="edit_class_id" list="kelas-list-edit" required class="field-control">
                        <datalist id="kelas-list-edit">
                            @foreach($classOptions as $class)
                                <option value="{{ $class }}"></option>
                            @endforeach
                        </datalist>
                    </div>

                    <div>
                        <label class="field-label">Hari</label>
                        <select name="day" id="edit_day" required class="field-control">
                            @foreach($dayOptions as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="field-label">Jam Mulai</label>
                        <input type="time" name="start_time" id="edit_start_time" required class="field-control">
                    </div>

                    <div>
                        <label class="field-label">Jam Selesai</label>
                        <input type="time" name="end_time" id="edit_end_time" required class="field-control">
                    </div>

                    <div>
                        <label class="field-label">Ruang</label>
                        <input type="text" name="room" id="edit_room" class="field-control" placeholder="Ruang 1">
                    </div>

                    <div style="display:flex; align-items:end;">
                        <button type="submit" class="btn-primary" style="width:100%;">
                            <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal(button) {
        const modal = document.getElementById('editScheduleModal');
        const form = document.getElementById('editScheduleForm');

        form.action = button.dataset.updateUrl;
        document.getElementById('edit_subject_id').value = button.dataset.subjectId || '';
        document.getElementById('edit_teacher_id').value = button.dataset.teacherId || '';
        document.getElementById('edit_class_id').value = button.dataset.classId || '';
        document.getElementById('edit_day').value = button.dataset.day || '';
        document.getElementById('edit_start_time').value = button.dataset.startTime || '';
        document.getElementById('edit_end_time').value = button.dataset.endTime || '';
        document.getElementById('edit_room').value = button.dataset.room || '';

        modal.classList.add('open');
        modal.setAttribute('aria-hidden', 'false');
    }

    function closeEditModal() {
        const modal = document.getElementById('editScheduleModal');
        modal.classList.remove('open');
        modal.setAttribute('aria-hidden', 'true');
    }

    document.getElementById('editScheduleModal').addEventListener('click', function (event) {
        if (event.target === this) {
            closeEditModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeEditModal();
        }
    });
</script>
@endsection