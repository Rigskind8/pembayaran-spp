{{-- resources/views/ujian/schedule.blade.php --}}
@extends('layouts.app')

@section('title', 'Jadwal Ujian UTS / UAS - ' . config('app.name', 'SMK TRAVINA PRIMA'))

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

    .exam-schedule-wrap {
        padding: 24px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ── BREADCRUMB ── */
    .schedule-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--text-muted);
        margin-bottom: 16px;
    }

    .schedule-breadcrumb a {
        color: var(--text-muted);
        transition: color .15s ease;
    }

    .schedule-breadcrumb a:hover {
        color: var(--primary);
    }

    /* ── HERO BANNER ── */
    .hero-schedule {
        background: linear-gradient(135deg, #1e40af 0%, #2563eb 60%, #3b82f6 100%);
        border-radius: 20px;
        padding: 28px 32px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 16px 36px rgba(37, 99, 235, .22);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .hero-schedule::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -40px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .08);
        pointer-events: none;
    }

    .hero-schedule::after {
        content: '';
        position: absolute;
        bottom: -50px;
        right: 160px;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .05);
        pointer-events: none;
    }

    .hero-kicker {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, .85);
        background: rgba(255, 255, 255, .15);
        padding: 4px 12px;
        border-radius: 999px;
        margin-bottom: 10px;
        backdrop-filter: blur(4px);
    }

    .hero-title {
        font-size: 26px;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 8px;
        letter-spacing: -.02em;
    }

    .hero-sub {
        font-size: 14px;
        color: rgba(255, 255, 255, .88);
        margin: 0 0 16px;
        max-width: 600px;
        line-height: 1.5;
    }

    .hero-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .hero-badge-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, .18);
        border: 1px solid rgba(255, 255, 255, .25);
        border-radius: 10px;
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 700;
        color: #ffffff;
        backdrop-filter: blur(4px);
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        position: relative;
        z-index: 1;
    }

    .btn-hero-white {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        color: var(--primary);
        border: none;
        border-radius: 12px;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(0, 0, 0, .12);
        transition: all .2s ease;
        white-space: nowrap;
    }

    .btn-hero-white:hover {
        background: #f8fafc;
        transform: translateY(-2px);
        color: var(--primary-dark);
        box-shadow: 0 6px 20px rgba(0, 0, 0, .16);
    }

    .btn-hero-glass {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, .15);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, .3);
        border-radius: 12px;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        backdrop-filter: blur(4px);
        transition: all .2s ease;
        white-space: nowrap;
    }

    .btn-hero-glass:hover {
        background: rgba(255, 255, 255, .25);
        transform: translateY(-2px);
        color: #ffffff;
    }

    /* ── STAT GRID ── */
    .stat-grid-schedule {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    @media (max-width: 992px) {
        .stat-grid-schedule { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 520px) {
        .stat-grid-schedule { grid-template-columns: 1fr; }
    }

    .stat-card-sch {
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

    .stat-card-sch:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 28px -4px rgba(15, 23, 42, .08);
    }

    .stat-icon-sch {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .stat-icon-sch.blue   { background: #eff6ff; color: #2563eb; }
    .stat-icon-sch.indigo { background: #e0e7ff; color: #4f46e5; }
    .stat-icon-sch.amber  { background: #fffbeb; color: #d97706; }
    .stat-icon-sch.green  { background: #ecfdf5; color: #059669; }

    .stat-val-text {
        font-size: 22px;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 4px;
        color: var(--text-main);
    }

    .stat-label-text {
        font-size: 11px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    /* ── FILTER & TOOLBAR ── */
    .schedule-toolbar {
        background: var(--card-bg);
        border: 1px solid var(--line);
        border-radius: 18px;
        padding: 16px 20px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-soft);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .day-pills {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .day-pill-btn {
        background: #f8fafc;
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 7px 14px;
        font-size: 12.5px;
        font-weight: 700;
        color: var(--text-muted);
        cursor: pointer;
        transition: all .15s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .day-pill-btn:hover {
        background: #f1f5f9;
        color: var(--text-main);
    }

    .day-pill-btn.active {
        background: var(--primary);
        border-color: var(--primary);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, .25);
    }

    .day-pill-today-badge {
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .06em;
        background: #10b981;
        color: #ffffff;
        padding: 2px 6px;
        border-radius: 999px;
    }

    .day-pill-btn.active .day-pill-today-badge {
        background: rgba(255, 255, 255, .3);
        color: #ffffff;
    }

    .search-box-wrap {
        position: relative;
        min-width: 240px;
        flex: 1;
        max-width: 320px;
    }

    .search-box-wrap i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 13px;
        pointer-events: none;
    }

    .search-input-sch {
        width: 100%;
        padding: 8px 14px 8px 36px;
        border-radius: 12px;
        border: 1px solid var(--line);
        background: #f8fafc;
        font-size: 13px;
        color: var(--text-main);
        outline: none;
        transition: all .15s ease;
    }

    .search-input-sch:focus {
        background: #ffffff;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
    }

    /* ── CARD MAIN TABLE ── */
    .schedule-card {
        background: var(--card-bg);
        border: 1px solid var(--line);
        border-radius: 20px;
        box-shadow: var(--shadow-soft);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .schedule-card-head {
        padding: 18px 24px;
        background: #f8fafc;
        border-bottom: 1px solid var(--line);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .schedule-card-title {
        font-size: 16px;
        font-weight: 800;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .schedule-card-icon {
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

    .today-live-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #059669;
        font-size: 11.5px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 999px;
    }

    .today-pulse {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.6);
        animation: pulseDot 1.8s infinite;
    }

    @keyframes pulseDot {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 7px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    /* ── TABLE ── */
    .table-schedule-modern {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .table-schedule-modern thead th {
        background: #f8fafc;
        color: var(--text-muted);
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .06em;
        padding: 14px 22px;
        border-bottom: 1px solid var(--line);
        text-align: left;
    }

    .table-schedule-modern tbody td {
        padding: 16px 22px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13.5px;
        vertical-align: middle;
        color: var(--text-main);
        transition: background .15s ease;
    }

    .table-schedule-modern tbody tr:hover td {
        background: #f8fbff;
    }

    .table-schedule-modern tbody tr.row-today {
        background: rgba(37, 99, 235, .03);
    }

    .table-schedule-modern tbody tr.row-today td:first-child {
        border-left: 4px solid var(--primary);
    }

    .table-schedule-modern tbody tr:last-child td {
        border-bottom: none;
    }

    /* ── TABLE ELEMENTS ── */
    .day-text {
        font-size: 14px;
        font-weight: 800;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .tag-today {
        display: inline-block;
        background: #dbeafe;
        color: #1d4ed8;
        font-size: 10px;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .time-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 12.5px;
        font-weight: 700;
        white-space: nowrap;
    }

    .time-badge i {
        color: var(--primary);
        font-size: 11px;
    }

    .duration-text {
        display: block;
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 3px;
        font-weight: 600;
    }

    /* Subject pill styling */
    .subject-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
    }

    .subject-pill.blue   { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .subject-pill.indigo { background: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe; }
    .subject-pill.emerald{ background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .subject-pill.amber  { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .subject-pill.rose   { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
    .subject-pill.purple { background: #faf5ff; color: #7e22ce; border: 1px solid #e9d5ff; }

    .teacher-block {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .teacher-avatar-sch {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #6366f1);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11.5px;
        font-weight: 800;
        flex-shrink: 0;
    }

    .teacher-name-sch {
        font-weight: 700;
        font-size: 13px;
        color: var(--text-main);
    }

    .room-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f8fafc;
        border: 1px solid var(--line);
        color: #475569;
        border-radius: 8px;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .room-badge i {
        color: #94a3b8;
        font-size: 11px;
    }

    .btn-take-exam {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--primary);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all .15s ease;
        white-space: nowrap;
    }

    .btn-take-exam:hover {
        background: var(--primary-dark);
        color: #ffffff;
        transform: translateY(-1px);
    }

    /* ── EMPTY STATE ── */
    .schedule-empty {
        padding: 56px 20px;
        text-align: center;
    }

    .schedule-empty-icon {
        width: 68px;
        height: 68px;
        border-radius: 20px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: #94a3b8;
        margin: 0 auto 16px;
    }

    .schedule-empty h4 {
        font-size: 16px;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 6px;
    }

    .schedule-empty p {
        font-size: 13px;
        color: var(--text-muted);
        max-width: 360px;
        margin: 0 auto 16px;
        line-height: 1.5;
    }

    /* ── RULES / INFO CARD ── */
    .rules-card {
        background: var(--card-bg);
        border: 1px solid var(--line);
        border-radius: 20px;
        box-shadow: var(--shadow-soft);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .rules-card-head {
        padding: 16px 22px;
        background: #fffbeb;
        border-bottom: 1px solid #fef3c7;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .rules-card-head i {
        color: #d97706;
        font-size: 16px;
    }

    .rules-card-title {
        font-size: 14px;
        font-weight: 800;
        color: #92400e;
        margin: 0;
    }

    .rules-grid {
        padding: 20px 24px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    @media (max-width: 768px) {
        .rules-grid { grid-template-columns: 1fr; }
    }

    .rule-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .rule-num {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #eff6ff;
        color: var(--primary);
        font-weight: 800;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .rule-text h5 {
        font-size: 13px;
        font-weight: 800;
        color: var(--text-main);
        margin: 0 0 3px;
    }

    .rule-text p {
        font-size: 12px;
        color: var(--text-muted);
        margin: 0;
        line-height: 1.5;
    }

    /* ── PRINT VIEW ── */
    @media print {
        .sb, #mobile-topbar, .schedule-toolbar, .hero-actions, .btn-take-exam, .realtime-clock, .wa-float {
            display: none !important;
        }
        .main, #main-content {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
        .hero-schedule {
            background: #2563eb !important;
            color: #ffffff !important;
            box-shadow: none !important;
        }
        .schedule-card {
            border: 1px solid #ccc !important;
            box-shadow: none !important;
        }
    }

    /* ── RESPONSIVE MOBILE ── */
    @media (max-width: 768px) {
        .exam-schedule-wrap { padding: 16px 12px; }
        .hero-schedule { padding: 22px 18px; border-radius: 16px; }
        .hero-title { font-size: 20px; }
        .hero-actions { width: 100%; }
        .hero-actions a, .hero-actions button { flex: 1; justify-content: center; }
        .schedule-toolbar { padding: 14px 16px; flex-direction: column; align-items: stretch; }
        .search-box-wrap { max-width: 100%; }
        .day-pills { overflow-x: auto; padding-bottom: 4px; flex-wrap: nowrap; }
        .table-schedule-modern thead { display: none; }
        .table-schedule-modern, .table-schedule-modern tbody, .table-schedule-modern tr, .table-schedule-modern td {
            display: block;
            width: 100%;
        }
        .table-schedule-modern tbody tr {
            margin-bottom: 12px;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 12px 14px;
            background: #ffffff;
        }
        .table-schedule-modern tbody td {
            padding: 6px 0;
            border-bottom: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .table-schedule-modern tbody td::before {
            content: attr(data-label);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--text-muted);
            letter-spacing: .05em;
        }
        .teacher-block { justify-content: flex-end; }
    }
</style>
@endpush

@section('content')
<div class="exam-schedule-wrap">

    {{-- BREADCRUMB --}}
    <nav class="schedule-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Beranda</a>
        <i class="fas fa-chevron-right" style="font-size: 10px; opacity: .5;"></i>
        <span>Siswa</span>
        <i class="fas fa-chevron-right" style="font-size: 10px; opacity: .5;"></i>
        <span style="color: var(--text-main); font-weight: 700;">Jadwal Ujian</span>
    </nav>

    @php
        $todayIndo = \Carbon\Carbon::now()->locale('id')->isoFormat('dddd');
        $todayEnglish = \Carbon\Carbon::now()->format('l');

        $scheduleCollection = collect($scheduleList);
        $totalSessions = $scheduleCollection->count();
        $totalSubjects = $scheduleCollection->pluck('subject')->unique()->filter(fn($s) => $s && $s !== '-')->count();
        $todayCount = $scheduleCollection->filter(function($i) use ($todayIndo, $todayEnglish) {
            $d = strtolower($i['day']);
            return $d === strtolower($todayIndo) || $d === strtolower($todayEnglish);
        })->count();

        $uniqueRooms = $scheduleCollection->pluck('room')->unique()->filter(fn($r) => $r && $r !== '-')->count();

        function getSubjectColorPill($name) {
            $norm = strtolower($name);
            if (str_contains($norm, 'matematika') || str_contains($norm, 'math')) return ['class' => 'amber', 'icon' => 'fa-calculator'];
            if (str_contains($norm, 'inggris') || str_contains($norm, 'english')) return ['class' => 'indigo', 'icon' => 'fa-language'];
            if (str_contains($norm, 'indonesia')) return ['class' => 'rose', 'icon' => 'fa-book'];
            if (str_contains($norm, 'ipa') || str_contains($norm, 'fisika') || str_contains($norm, 'biologi') || str_contains($norm, 'kimia')) return ['class' => 'emerald', 'icon' => 'fa-flask'];
            if (str_contains($norm, 'rpl') || str_contains($norm, 'komputer') || str_contains($norm, 'web') || str_contains($norm, 'informatika')) return ['class' => 'blue', 'icon' => 'fa-code'];
            if (str_contains($norm, 'agama') || str_contains($norm, 'pai')) return ['class' => 'emerald', 'icon' => 'fa-mosque'];
            if (str_contains($norm, 'pkn') || str_contains($norm, 'sejarah')) return ['class' => 'purple', 'icon' => 'fa-landmark'];
            return ['class' => 'blue', 'icon' => 'fa-graduation-cap'];
        }

        function getTeacherInitials($name) {
            $words = explode(' ', trim($name));
            $initials = '';
            foreach (array_slice($words, 0, 2) as $w) {
                if (!empty($w)) $initials .= strtoupper(mb_substr($w, 0, 1));
            }
            return $initials ?: 'GP';
        }
    @endphp

    {{-- HERO BANNER --}}
    <div class="hero-schedule">
        <div class="hero-content">
            <div class="hero-kicker">
                <i class="fas fa-calendar-alt"></i> Tahun Pelajaran {{ date('Y') }}/{{ date('Y') + 1 }}
            </div>
            <h1 class="hero-title">Jadwal Ujian (UTS / UAS)</h1>
            <p class="hero-sub">
                Pantau jadwal ujian semester Anda secara langsung. Pastikan hadir tepat waktu dan persiapkan perlengkapan serta syarat ujian.
            </p>
            <div class="hero-badges">
                <div class="hero-badge-chip">
                    <i class="fas fa-chalkboard-teacher"></i>
                    Kelas: <strong>{{ $student->class_id ?? '-' }}</strong>
                </div>
                <div class="hero-badge-chip">
                    <i class="fas fa-user-graduate"></i>
                    Siswa: <strong>{{ $student->name ?? Auth::user()->name }}</strong>
                </div>
                @if(!empty($student?->nis))
                <div class="hero-badge-chip">
                    <i class="fas fa-id-card"></i>
                    NIS: <strong>{{ $student->nis }}</strong>
                </div>
                @endif
            </div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('ujian.uts') }}" class="btn-hero-white">
                <i class="fas fa-file-signature text-primary"></i> Halaman UTS
            </a>
            <a href="{{ route('ujian.uas') }}" class="btn-hero-white">
                <i class="fas fa-award text-primary"></i> Halaman UAS
            </a>
            <button onclick="window.print()" type="button" class="btn-hero-glass">
                <i class="fas fa-print"></i> Cetak Jadwal
            </button>
        </div>
    </div>

    {{-- STAT METRICS GRID --}}
    <div class="stat-grid-schedule">
        <div class="stat-card-sch">
            <div class="stat-icon-sch blue"><i class="fas fa-calendar-check"></i></div>
            <div>
                <div class="stat-val-text">{{ $totalSessions }}</div>
                <div class="stat-label-text">Total Sesi Ujian</div>
            </div>
        </div>
        <div class="stat-card-sch indigo">
            <div class="stat-icon-sch indigo"><i class="fas fa-book-open"></i></div>
            <div>
                <div class="stat-val-text">{{ $totalSubjects }}</div>
                <div class="stat-label-text">Mata Pelajaran</div>
            </div>
        </div>
        <div class="stat-card-sch green">
            <div class="stat-icon-sch green"><i class="fas fa-clock"></i></div>
            <div>
                <div class="stat-val-text">{{ $todayCount }}</div>
                <div class="stat-label-text">Ujian Hari Ini ({{ $todayIndo }})</div>
            </div>
        </div>
        <div class="stat-card-sch amber">
            <div class="stat-icon-sch amber"><i class="fas fa-door-open"></i></div>
            <div>
                <div class="stat-val-text">{{ $uniqueRooms ?: ($student->class_id ?? '1') }}</div>
                <div class="stat-label-text">Ruang Ujian</div>
            </div>
        </div>
    </div>

    {{-- FILTER & SEARCH TOOLBAR --}}
    <div class="schedule-toolbar">
        <div class="day-pills" id="dayFilters">
            <button type="button" class="day-pill-btn active" data-day="all">
                Semua Hari
            </button>
            @php
                $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            @endphp
            @foreach($days as $dayName)
                @php
                    $isTodayMatch = (strtolower($dayName) === strtolower($todayIndo));
                @endphp
                <button type="button" class="day-pill-btn" data-day="{{ strtolower($dayName) }}">
                    {{ $dayName }}
                    @if($isTodayMatch)
                        <span class="day-pill-today-badge">Hari Ini</span>
                    @endif
                </button>
            @endforeach
        </div>

        <div class="search-box-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="scheduleSearch" class="search-input-sch" placeholder="Cari mata pelajaran, guru, ruang...">
        </div>
    </div>

    {{-- SCHEDULE TABLE CARD --}}
    <div class="schedule-card">
        <div class="schedule-card-head">
            <div class="schedule-card-title">
                <div class="schedule-card-icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <span>Daftar Jadwal Ujian Resmi</span>
            </div>
            @if($todayCount > 0)
                <div class="today-live-badge">
                    <span class="today-pulse"></span>
                    <span>Ada {{ $todayCount }} Ujian Hari Ini</span>
                </div>
            @else
                <div class="text-muted" style="font-size: 12.5px; font-weight: 600;">
                    <i class="fas fa-info-circle" style="margin-right: 4px;"></i> Tidak ada ujian yang dijadwalkan hari ini
                </div>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table-schedule-modern" id="scheduleTable">
                <thead>
                    <tr>
                        <th style="width: 140px;">Hari</th>
                        <th style="width: 190px;">Waktu & Durasi</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru Pengawas / Pengajar</th>
                        <th style="width: 130px;">Ruangan</th>
                        <th style="width: 130px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($scheduleList as $item)
                        @php
                            $dayLower = strtolower($item['day']);
                            $isTodayRow = ($dayLower === strtolower($todayIndo) || $dayLower === strtolower($todayEnglish));
                            $pillInfo = getSubjectColorPill($item['subject']);
                            $initials = getTeacherInitials($item['teacher']);
                        @endphp
                        <tr class="schedule-row {{ $isTodayRow ? 'row-today' : '' }}" 
                            data-day="{{ $dayLower }}" 
                            data-subject="{{ strtolower($item['subject']) }}" 
                            data-teacher="{{ strtolower($item['teacher']) }}"
                            data-room="{{ strtolower($item['room']) }}">
                            
                            {{-- HARI --}}
                            <td data-label="Hari">
                                <div class="day-text">
                                    <span>{{ $item['day'] }}</span>
                                    @if($isTodayRow)
                                        <span class="tag-today">Hari Ini</span>
                                    @endif
                                </div>
                            </td>

                            {{-- WAKTU & DURASI --}}
                            <td data-label="Waktu">
                                <div>
                                    <span class="time-badge">
                                        <i class="fas fa-clock"></i> {{ $item['time'] }} WIB
                                    </span>
                                    @if(!empty($item['duration']))
                                        <span class="duration-text"><i class="fas fa-hourglass-half" style="font-size: 9px; opacity: .7;"></i> {{ $item['duration'] }}</span>
                                    @endif
                                </div>
                            </td>

                            {{-- MATA PELAJARAN --}}
                            <td data-label="Mata Pelajaran">
                                <div class="subject-pill {{ $pillInfo['class'] }}">
                                    <i class="fas {{ $pillInfo['icon'] }}"></i>
                                    <span>{{ $item['subject'] }}</span>
                                </div>
                            </td>

                            {{-- GURU PENGAWAS --}}
                            <td data-label="Guru / Pengawas">
                                <div class="teacher-block">
                                    <div class="teacher-avatar-sch">{{ $initials }}</div>
                                    <span class="teacher-name-sch">{{ $item['teacher'] }}</span>
                                </div>
                            </td>

                            {{-- RUANGAN --}}
                            <td data-label="Ruangan">
                                <span class="room-badge">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $item['room'] }}
                                </span>
                            </td>

                            {{-- AKSI --}}
                            <td data-label="Aksi" style="text-align: right;">
                                <a href="{{ route('ujian.uts') }}" class="btn-take-exam" title="Buka Halaman Ujian">
                                    <span>Ikut Ujian</span>
                                    <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyScheduleRow">
                            <td colspan="6">
                                <div class="schedule-empty">
                                    <div class="schedule-empty-icon">
                                        <i class="fas fa-calendar-times"></i>
                                    </div>
                                    <h4>Belum Ada Jadwal Ujian</h4>
                                    <p>Jadwal UTS/UAS untuk kelas {{ $student->class_id ?? 'Anda' }} belum dirilis oleh pihak kurikulum sekolah.</p>
                                    <a href="{{ route('dashboard') }}" class="btn-take-exam">
                                        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    {{-- Dynamic row when search yields 0 items --}}
                    <tr id="noSearchResultRow" style="display: none;">
                        <td colspan="6">
                            <div class="schedule-empty">
                                <div class="schedule-empty-icon">
                                    <i class="fas fa-search-minus"></i>
                                </div>
                                <h4>Jadwal Tidak Ditemukan</h4>
                                <p>Tidak ada mata pelajaran atau jadwal yang cocok dengan kata kunci pencarian Anda.</p>
                                <button type="button" class="btn-take-exam" id="btnResetSearch">
                                    <i class="fas fa-rotate-left"></i> Reset Filter & Pencarian
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- TATA TERTIB UJIAN CARD --}}
    <div class="rules-card">
        <div class="rules-card-head">
            <i class="fas fa-shield-alt"></i>
            <h4 class="rules-card-title">Tata Tertib & Ketentuan Peserta Ujian</h4>
        </div>
        <div class="rules-grid">
            <div class="rule-item">
                <div class="rule-num">1</div>
                <div class="rule-text">
                    <h5>Kehadiran Tepat Waktu</h5>
                    <p>Peserta wajib telah siap di ruangan ujian atau login ke sistem minimal 15 menit sebelum waktu ujian dimulai.</p>
                </div>
            </div>
            <div class="rule-item">
                <div class="rule-num">2</div>
                <div class="rule-text">
                    <h5>Syarat Verifikasi Pembayaran</h5>
                    <p>Pastikan administrasi dan pembayaran UTS / UAS telah disetujui admin untuk membuka akses pengerjaan soal ujian.</p>
                </div>
            </div>
            <div class="rule-item">
                <div class="rule-num">3</div>
                <div class="rule-text">
                    <h5>Koneksi & Perangkat Stabil</h5>
                    <p>Gunakan browser terkini (Chrome/Edge) dengan koneksi internet stabil serta daya baterai perangkat yang terisi cukup.</p>
                </div>
            </div>
            <div class="rule-item">
                <div class="rule-num">4</div>
                <div class="rule-text">
                    <h5>Integritas & Kejujuran Akademik</h5>
                    <p>Dilarang keras membuka tab lain, mengambil tangkapan layar (screenshot), atau bekerja sama dengan pihak lain selama ujian.</p>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dayButtons = document.querySelectorAll('#dayFilters .day-pill-btn');
        const searchInput = document.getElementById('scheduleSearch');
        const rows = document.querySelectorAll('.schedule-row');
        const noResultRow = document.getElementById('noSearchResultRow');
        const resetBtn = document.getElementById('btnResetSearch');

        let activeDay = 'all';
        let searchQuery = '';

        function filterSchedule() {
            let visibleCount = 0;

            rows.forEach(function (row) {
                const rowDay = row.getAttribute('data-day') || '';
                const rowSubj = row.getAttribute('data-subject') || '';
                const rowTeacher = row.getAttribute('data-teacher') || '';
                const rowRoom = row.getAttribute('data-room') || '';

                const matchesDay = (activeDay === 'all') || (rowDay === activeDay);
                const matchesSearch = !searchQuery || 
                    rowSubj.includes(searchQuery) || 
                    rowTeacher.includes(searchQuery) || 
                    rowRoom.includes(searchQuery) ||
                    rowDay.includes(searchQuery);

                if (matchesDay && matchesSearch) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (noResultRow) {
                if (visibleCount === 0 && rows.length > 0) {
                    noResultRow.style.display = '';
                } else {
                    noResultRow.style.display = 'none';
                }
            }
        }

        dayButtons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                dayButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                activeDay = this.getAttribute('data-day');
                filterSchedule();
            });
        });

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                searchQuery = this.value.trim().toLowerCase();
                filterSchedule();
            });
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', function () {
                activeDay = 'all';
                searchQuery = '';
                if (searchInput) searchInput.value = '';
                dayButtons.forEach(b => {
                    if (b.getAttribute('data-day') === 'all') b.classList.add('active');
                    else b.classList.remove('active');
                });
                filterSchedule();
            });
        }
    });
</script>
@endpush
@endsection