@extends('layouts.app')

@section('title', 'Manage Absensi - SMK TRAVINA PRIMA')

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
    --purple: #7c3aed; --purple-bg: #f5f3ff;
    --cyan: #0891b2; --cyan-bg: #ecfeff;
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
.sb-grp { font-size: 11px; font-weight: 800; letter-spacing: .1em; color: #eef4ff; text-transform: uppercase; padding: 12px 8px 4px; white-space: nowrap; opacity: 0; transition: opacity .2s; text-shadow: 0 1px 1px rgba(0,0,0,.35); }
.sb:hover .sb-grp { opacity: 1; }
.sb-a { display: flex; align-items: center; gap: 10px; padding: 8px 9px; border-radius: 10px; color: #6b7280; font-size: 13px; font-weight: 500; text-decoration: none; white-space: nowrap; transition: all .15s; }
.sb-a .ic { width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 13px; color: #4b5163; transition: all .15s; }
.sb-a:hover { color: #d1d5db; }
.sb-a:hover .ic { background: #1c1f2e; color: #9ca3af; }
.sb-a.on { color: white; }
.sb-a.on .ic { background: var(--blue); color: white; box-shadow: 0 4px 10px rgba(37,99,235,.3); }
.sb-lbl { opacity: 0; transition: opacity .18s; pointer-events: none; white-space: nowrap; }
.sb:hover .sb-lbl { opacity: 1; pointer-events: auto; }
.sb-foot { width: 100%; padding: 0 10px; margin-top: auto; border-top: 1px solid #1a1d27; padding-top: 14px; }
.sb-user { display: flex; align-items: center; gap: 9px; padding: 9px; border-radius: 10px; background: rgba(255,255,255,.04); margin-bottom: 6px; }
.sb-av { width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0; background: var(--blue); color: white; font-weight: 800; font-size: 14px; display: flex; align-items: center; justify-content: center; }
.sb-uname { font-size: 12px; font-weight: 700; color: #f1f5f9; }
.sb-urole { font-size: 10px; color: #6b7280; }
.sb-out { display: flex; align-items: center; gap: 10px; padding: 9px; border-radius: 10px; background: transparent; border: none; color: #ef4444; font-size: 12px; font-weight: 600; cursor: pointer; width: 100%; font-family: inherit; white-space: nowrap; transition: background .15s; }
.sb-out:hover { background: rgba(239,68,68,.1); }
.sb-out .ic { width: 34px; height: 34px; border-radius: 9px; background: rgba(239,68,68,.08); display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0; }

/* TOPBAR */
.topbar { display: flex; align-items: center; justify-content: space-between; padding: 10px 28px; background: rgba(244,246,250,.95); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; }
.top-title { font-size: 18px; font-weight: 800; color: var(--txt); letter-spacing: -.3px; }
.top-sub { font-size: 12px; color: var(--txt2); margin-top: 1px; }

/* PAGE */
.page { padding: 18px 28px 28px; flex: 1; }
.pg-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
.pg-title { font-size: 22px; font-weight: 800; color: var(--txt); }
.pg-sub { font-size: 13px; color: var(--txt2); margin-top: 2px; }

/* BUTTONS */
.btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 9px; font-size: 13px; font-weight: 700; cursor: pointer; border: none; font-family: inherit; transition: all .15s; text-decoration: none; }
.btn-blue { background: var(--blue); color: white; }
.btn-blue:hover { background: #1d4ed8; }
.btn-red { background: var(--red); color: white; }
.btn-red:hover { background: #b91c1c; }
.btn-outline { background: white; color: var(--txt2); border: 1px solid var(--border); }
.btn-outline:hover { border-color: var(--blue); color: var(--blue); }
.btn-sm { padding: 5px 10px; font-size: 12px; }

/* STATS */
.stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
.stat-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); padding: 18px 20px; box-shadow: var(--shadow); display: flex; align-items: center; gap: 14px; }
.stat-ic { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
.stat-val { font-size: 22px; font-weight: 800; color: var(--txt); line-height: 1; }
.stat-lbl { font-size: 11px; color: var(--txt2); margin-top: 3px; font-weight: 600; }

/* FILTER BAR */
.filter-bar { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); padding: 16px 20px; display: flex; align-items: center; gap: 12px; margin-bottom: 24px; flex-wrap: wrap; box-shadow: var(--shadow); }
.filter-bar label { font-size: 12px; font-weight: 700; color: var(--txt2); }
.filter-bar select { border: 1px solid var(--border); border-radius: 8px; padding: 7px 12px; font-size: 13px; font-weight: 600; color: var(--txt); background: var(--bg); font-family: inherit; outline: none; }
.filter-bar select:focus { border-color: var(--blue); }

/* TABLE CARD */
.table-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); box-shadow: var(--shadow); overflow: hidden; margin-bottom: 24px; }
.tc-head { padding: 18px 22px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 12px; }
.tc-title { font-size: 15px; font-weight: 800; color: var(--txt); }
.tc-sub { font-size: 11px; color: var(--txt2); margin-top: 2px; }
table { width: 100%; border-collapse: collapse; }
thead th { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--txt3); padding: 10px 20px; text-align: left; background: #fafafa; border-bottom: 1px solid var(--border); }
tbody td { padding: 12px 20px; font-size: 13px; color: var(--txt); border-bottom: 1px solid #f5f5f7; vertical-align: middle; }
tbody tr:last-child td { border-bottom: none; }
tbody tr:hover td { background: #fafbff; }

/* STATUS BADGES */
.badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 99px; font-size: 11px; font-weight: 700; }
.badge-hadir  { background: var(--green-bg);  color: var(--green); }
.badge-sakit  { background: var(--amber-bg);  color: var(--amber); }
.badge-izin   { background: var(--blue-bg);   color: var(--blue);  }
.badge-alpha  { background: var(--red-bg);    color: var(--red);   }
.teacher-schedule-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 12px; margin-bottom: 20px; }
.teacher-schedule-card { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 14px 16px; box-shadow: var(--shadow); }
.teacher-schedule-day { display: inline-flex; align-items: center; gap: 6px; background: #eff6ff; color: var(--blue); border-radius: 999px; padding: 4px 8px; font-size: 11px; font-weight: 800; margin-bottom: 10px; }
.teacher-schedule-title { font-size: 14px; font-weight: 800; color: var(--txt); margin-bottom: 4px; }
.teacher-schedule-meta { font-size: 12px; color: var(--txt2); line-height: 1.5; }

.teacher-schedule-table-wrap { overflow-x: auto; border: 1px solid var(--border); border-radius: 14px; background: var(--card); box-shadow: var(--shadow); margin-bottom: 20px; }
.teacher-schedule-table { width: 100%; border-collapse: collapse; min-width: 760px; }
.teacher-schedule-table thead th { text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--txt3); padding: 10px 16px; border-bottom: 1px solid var(--border); background: #fafafa; }
.teacher-schedule-table tbody td { font-size: 13px; padding: 12px 16px; border-bottom: 1px solid #f5f5f7; vertical-align: top; }
.teacher-schedule-table tbody tr:last-child td { border-bottom: 0; }
.day-pill { display: inline-flex; align-items: center; gap: 5px; padding: 4px 8px; border-radius: 999px; background: var(--blue-bg); color: var(--blue); font-size: 11px; font-weight: 800; }

/* REKAP CARD */
.rekap-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 14px; margin-bottom: 24px; }
.rekap-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); padding: 16px 18px; box-shadow: var(--shadow); }
.rekap-name { font-size: 13px; font-weight: 800; color: var(--txt); margin-bottom: 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.rekap-bars { display: flex; flex-direction: column; gap: 5px; }
.rekap-row { display: flex; align-items: center; gap: 8px; }
.rekap-lbl { font-size: 10px; font-weight: 700; color: var(--txt3); width: 40px; flex-shrink: 0; }
.rekap-bar-wrap { flex: 1; background: #f3f4f6; border-radius: 99px; height: 6px; overflow: hidden; }
.rekap-bar { height: 100%; border-radius: 99px; }
.rekap-num { font-size: 11px; font-weight: 800; color: var(--txt); width: 20px; text-align: right; }

/* ACTION ROW */
.action-row { display: flex; gap: 6px; }

/* MODAL — pakai prefix abs- supaya tidak bentrok dengan Bootstrap */
.abs-modal-bg { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 9999; align-items: center; justify-content: center; }
.abs-modal-bg.show { display: flex; }
.abs-modal { background: white; border-radius: 20px; padding: 28px; width: 100%; max-width: 440px; box-shadow: 0 20px 60px rgba(0,0,0,.15); }
.abs-modal-title { font-size: 17px; font-weight: 800; color: var(--txt); margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
.form-group { margin-bottom: 16px; }
.form-group label { display: block; font-size: 12px; font-weight: 700; color: var(--txt2); margin-bottom: 6px; text-transform: uppercase; letter-spacing: .06em; }
.form-group select, .form-group input { width: 100%; border: 1.5px solid var(--border); border-radius: 10px; padding: 10px 14px; font-size: 13px; font-weight: 600; color: var(--txt); font-family: inherit; outline: none; transition: border-color .15s; background: white; }
.form-group select:focus, .form-group input:focus { border-color: var(--blue); }
.abs-modal-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px; }

/* EMPTY */
.empty-state { padding: 50px 20px; text-align: center; color: var(--txt3); }
.empty-state i { font-size: 40px; margin-bottom: 12px; display: block; }
.empty-state p { font-size: 13px; }

/* TABS */
.tabs { display: flex; gap: 4px; background: var(--bg); border-radius: 10px; padding: 4px; margin-bottom: 20px; width: fit-content; border: 1px solid var(--border); }
.tab { padding: 7px 18px; border-radius: 7px; font-size: 13px; font-weight: 700; cursor: pointer; color: var(--txt2); border: none; background: transparent; font-family: inherit; transition: all .15s; }
.tab.on { background: white; color: var(--blue); box-shadow: var(--shadow); }

/* TOASTS */
.toasts { position: fixed; bottom: 20px; right: 20px; z-index: 99999; display: flex; flex-direction: column; gap: 8px; }
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
    @include('partials.sidebar')

    <div class="main">
        <header class="topbar" style="justify-content: flex-end;">
            <button class="btn btn-blue" onclick="openModal()">
                <i class="fas fa-plus"></i> Input Absensi
            </button>
        </header>

        <div class="page">
            @if($errors->any())
                <div style="background: var(--red-bg); color: var(--red); border: 1px solid rgba(220,38,38,.25); padding: 12px 16px; border-radius: 12px; margin-bottom: 14px; font-size: 13px; font-weight: 600;">
                    <div style="margin-bottom:6px;"><i class="fas fa-triangle-exclamation"></i> Input belum berhasil:</div>
                    <ul style="margin:0 0 0 18px; padding:0; font-weight:500;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(($teacherSchedules ?? collect())->count() > 0)
                <div class="page-sub" style="margin-top:-8px; margin-bottom:12px; font-weight:700; color:var(--blue); font-size:12px;">
                    Jadwal mengajar aktif Anda.
                </div>
                <div class="teacher-schedule-table-wrap">
                    <table class="teacher-schedule-table">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Mapel</th>
                                <th>Kelas</th>
                                <th>Jam</th>
                                <th>Ruang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teacherSchedules as $schedule)
                                @php
                                    $start = $schedule->start_time instanceof \Carbon\Carbon
                                        ? $schedule->start_time->format('H:i')
                                        : \Carbon\Carbon::parse($schedule->start_time)->format('H:i');
                                    $end = $schedule->end_time instanceof \Carbon\Carbon
                                        ? $schedule->end_time->format('H:i')
                                        : \Carbon\Carbon::parse($schedule->end_time)->format('H:i');
                                @endphp
                                <tr>
                                    <td><span class="day-pill"><i class="fas fa-calendar-day"></i> {{ $schedule->day }}</span></td>
                                    <td><strong>{{ $schedule->subject->name ?? '-' }}</strong></td>
                                    <td>{{ $schedule->class_id }}</td>
                                    <td>{{ $start }} - {{ $end }}</td>
                                    <td>{{ $schedule->room ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- STATS --}}
            @php
                $totalHadir = $stats['hadir'];
                $totalSakit = $stats['sakit'];
                $totalIzin  = $stats['izin'];
                $totalAlpha = $stats['alpha'];
            @endphp
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-ic" style="background:var(--green-bg);color:var(--green);"><i class="fas fa-circle-check"></i></div>
                    <div><div class="stat-val">{{ $totalHadir }}</div><div class="stat-lbl">Hadir</div></div>
                </div>
                <div class="stat-card">
                    <div class="stat-ic" style="background:var(--amber-bg);color:var(--amber);"><i class="fas fa-heart-pulse"></i></div>
                    <div><div class="stat-val">{{ $totalSakit }}</div><div class="stat-lbl">Sakit</div></div>
                </div>
                <div class="stat-card">
                    <div class="stat-ic" style="background:var(--blue-bg);color:var(--blue);"><i class="fas fa-file-lines"></i></div>
                    <div><div class="stat-val">{{ $totalIzin }}</div><div class="stat-lbl">Izin</div></div>
                </div>
                <div class="stat-card">
                    <div class="stat-ic" style="background:var(--red-bg);color:var(--red);"><i class="fas fa-circle-xmark"></i></div>
                    <div><div class="stat-val">{{ $totalAlpha }}</div><div class="stat-lbl">Alpha</div></div>
                </div>
            </div>

            {{-- FILTER --}}
            <form method="GET" action="{{ route('absensi.admin') }}">
                <div class="filter-bar">
                    <i class="fas fa-filter" style="color:var(--txt3);font-size:13px;"></i>
                    <label>Bulan</label>
                    <select name="bulan">
                        @foreach(range(1,12) as $b)
                            <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                    <label>Tahun</label>
                    <select name="tahun">
                        @foreach(range(date('Y')-2, date('Y')+1) as $y)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                    <label>Kelas</label>
                    <select name="class_id">
                        <option value="">Semua Kelas</option>
                        @foreach(($classOptions ?? collect()) as $c)
                            <option value="{{ $c }}" {{ (string)($classId ?? '') === (string)$c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                    <label>Mapel</label>
                    <select name="subject_id">
                        <option value="">Semua Mapel</option>
                        @foreach(($subjectOptions ?? collect()) as $sub)
                            <option value="{{ $sub->id }}" {{ (string)($subjectId ?? '') === (string)$sub->id ? 'selected' : '' }}>
                                {{ $sub->name }}{{ !empty($sub->class_id) ? ' (' . $sub->class_id . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    <label>Siswa</label>
                    <select name="student_id">
                        <option value="">Semua Siswa</option>
                        @foreach($students as $s)
                            <option value="{{ $s->id }}" {{ $studentId == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-blue"><i class="fas fa-search"></i> Filter</button>
                </div>
            </form>

            {{-- TABS --}}
            <div class="tabs">
                <button class="tab on" onclick="switchTab('rekap', this)">Rekap per Siswa</button>
                <button class="tab" onclick="switchTab('detail', this)">Detail Absensi</button>
            </div>

            {{-- REKAP TAB --}}
            <div id="tab-rekap">
                @if($rekap->count() > 0)
                <div class="rekap-grid">
                    @foreach($rekap as $r)
                    @php $total = max($r['total'], 1); @endphp
                    <div class="rekap-card">
                        <div class="rekap-name">{{ $r['student']->name ?? '-' }}</div>
                        <div style="font-size:11px;color:var(--txt2);margin-bottom:10px;">
                            Kelas {{ $r['student']->class_id }} · Mapel sesuai jadwal Anda
                        </div>
                        <div class="rekap-bars">
                            <div class="rekap-row">
                                <span class="rekap-lbl">Hadir</span>
                                <div class="rekap-bar-wrap"><div class="rekap-bar" style="width:{{ ($r['hadir']/$total)*100 }}%;background:var(--green);"></div></div>
                                <span class="rekap-num">{{ $r['hadir'] }}</span>
                            </div>
                            <div class="rekap-row">
                                <span class="rekap-lbl">Sakit</span>
                                <div class="rekap-bar-wrap"><div class="rekap-bar" style="width:{{ ($r['sakit']/$total)*100 }}%;background:var(--amber);"></div></div>
                                <span class="rekap-num">{{ $r['sakit'] }}</span>
                            </div>
                            <div class="rekap-row">
                                <span class="rekap-lbl">Izin</span>
                                <div class="rekap-bar-wrap"><div class="rekap-bar" style="width:{{ ($r['izin']/$total)*100 }}%;background:var(--blue);"></div></div>
                                <span class="rekap-num">{{ $r['izin'] }}</span>
                            </div>
                            <div class="rekap-row">
                                <span class="rekap-lbl">Alpha</span>
                                <div class="rekap-bar-wrap"><div class="rekap-bar" style="width:{{ ($r['alpha']/$total)*100 }}%;background:var(--red);"></div></div>
                                <span class="rekap-num">{{ $r['alpha'] }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="table-card">
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>Belum ada data absensi untuk periode ini.</p>
                    </div>
                </div>
                @endif
            </div>

            {{-- DETAIL TAB --}}
            <div id="tab-detail" style="display:none;">
                <div class="table-card">
                    <div class="tc-head">
                        <div>
                            <div class="tc-title">Detail Absensi</div>
                            <div class="tc-sub">{{ $attendances->total() }} data ditemukan</div>
                        </div>
                    </div>
                    @if($attendances->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Siswa</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru</th>
                                <th>Hari</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Dikirim</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $i => $a)
                            <tr>
                                <td style="color:var(--txt3);">{{ $attendances->firstItem() + $i }}</td>
                                <td><strong>{{ $a->student->name ?? '-' }}</strong></td>
                                <td style="color:var(--txt2);">{{ $a->schedule?->subject?->name ?? '-' }}</td>
                                <td>{{ $a->schedule?->teacher?->name ?? '-' }}</td>
                                <td style="color:var(--txt2);">{{ $a->schedule?->day ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($a->date)->format('d M Y') }}</td>
                                <td style="color:var(--txt2);">
                                    @php
                                        $startTime = $a->schedule?->start_time
                                            ? (\Carbon\Carbon::parse($a->schedule->start_time)->format('H:i'))
                                            : '-';
                                        $endTime = $a->schedule?->end_time
                                            ? (\Carbon\Carbon::parse($a->schedule->end_time)->format('H:i'))
                                            : '-';
                                    @endphp
                                    {{ $startTime }} - {{ $endTime }}
                                </td>
                                <td>
                                    <span class="badge badge-{{ $a->status }}">
                                        <i class="fas fa-circle" style="font-size:6px;"></i>
                                        {{ ucfirst($a->status) }}
                                    </span>
                                </td>
                                <td style="color:var(--txt2);">{{ $a->keterangan ?? '-' }}</td>
                                <td style="color:var(--txt3);font-size:12px;">
                                    {{ $a->submitted_at ? $a->submitted_at->format('d M Y H:i') : '-' }}
                                </td>
                                <td>
                                    <div class="action-row">
                                        <button class="btn btn-outline btn-sm" onclick="openEdit({{ $a->id }}, '{{ $a->status }}', '{{ addslashes($a->keterangan) }}', '{{ \Carbon\Carbon::parse($a->date)->format('Y-m-d') }}')">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <form action="{{ route('absensi.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Hapus absensi ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-red btn-sm"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="padding:16px 20px;">
                        {{ $attendances->withQueryString()->links() }}
                    </div>
                    @else
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>Belum ada data absensi untuk periode ini.</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

{{-- MODAL INPUT ABSENSI --}}
<div class="abs-modal-bg" id="modalBg">
    <div class="abs-modal">
        <div class="abs-modal-title">
            <i class="fas fa-calendar-plus" style="color:var(--blue);"></i>
            <span id="modalTitleText">Input Absensi</span>
        </div>
        <form id="absensiForm" method="POST" action="{{ route('absensi.admin.store') }}">
            @csrf
            <span id="methodField"></span>

            <div class="form-group" id="studentGroup">
                <label>Siswa</label>
                <select name="student_id" id="inp_student" required>
                    <option value="">Pilih Siswa</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}" data-class-id="{{ $s->class_id }}" {{ (string) old('student_id') === (string) $s->id ? 'selected' : '' }}>{{ $s->name }} ({{ $s->class_id }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" id="scheduleGroup">
                <label>Jadwal / Mapel</label>
                <select name="schedule_id" id="inp_schedule" required>
                    <option value="">Pilih Jadwal</option>
                    @foreach(($scheduleOptions ?? collect()) as $schedule)
                        @php
                            $start = $schedule->start_time instanceof \Carbon\Carbon
                                ? $schedule->start_time->format('H:i')
                                : \Carbon\Carbon::parse($schedule->start_time)->format('H:i');
                            $end = $schedule->end_time instanceof \Carbon\Carbon
                                ? $schedule->end_time->format('H:i')
                                : \Carbon\Carbon::parse($schedule->end_time)->format('H:i');
                        @endphp
                        <option
                            value="{{ $schedule->id }}"
                            data-class-id="{{ $schedule->class_id }}"
                            {{ (string) old('schedule_id') === (string) $schedule->id ? 'selected' : '' }}
                        >
                            {{ $schedule->day }} · {{ $schedule->subject?->name ?? '-' }} · {{ $schedule->class_id }} · {{ $start }}-{{ $end }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" id="dateGroup">
                <label>Tanggal</label>
                <input type="date" name="date" id="inp_date" value="{{ old('date', date('Y-m-d')) }}" required>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" id="inp_status" required>
                    <option value="hadir" {{ old('status', 'hadir') === 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="sakit" {{ old('status') === 'sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="izin" {{ old('status') === 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="alpha" {{ old('status') === 'alpha' ? 'selected' : '' }}>Alpha</option>
                </select>
            </div>

            <div class="form-group">
                <label>Keterangan (Opsional)</label>
                <input type="text" name="keterangan" id="inp_ket" placeholder="Sakit demam, dll" value="{{ old('keterangan') }}">
            </div>

            <div class="abs-modal-actions">
                <button type="button" class="btn btn-outline" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn btn-blue" id="submitBtn">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function switchTab(tab, el) {
    document.getElementById('tab-rekap').style.display  = tab === 'rekap'  ? '' : 'none';
    document.getElementById('tab-detail').style.display = tab === 'detail' ? '' : 'none';
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('on'));
    el.classList.add('on');
}

function openModal() {
    document.getElementById('modalTitleText').textContent = 'Input Absensi';
    document.getElementById('submitBtn').innerHTML = '<i class="fas fa-save"></i> Simpan';
    document.getElementById('absensiForm').action = '{{ route('absensi.admin.store') }}';
    document.getElementById('methodField').innerHTML = '';
    document.getElementById('absensiForm').reset();
    document.getElementById('inp_date').value = '{{ date('Y-m-d') }}';
    document.getElementById('studentGroup').style.display = '';
    document.getElementById('scheduleGroup').style.display = '';
    document.getElementById('dateGroup').style.display = '';
    document.getElementById('inp_student').disabled = false;
    document.getElementById('inp_schedule').disabled = false;
    document.getElementById('inp_date').disabled = false;
    document.getElementById('modalBg').classList.add('show');
}

function openEdit(id, status, ket, date) {
    document.getElementById('modalTitleText').textContent = 'Edit Absensi';
    document.getElementById('submitBtn').innerHTML = '<i class="fas fa-save"></i> Update';
    document.getElementById('absensiForm').action = `/manage-absensi/${id}`;
    document.getElementById('methodField').innerHTML = `<input type="hidden" name="_method" value="PATCH">`;
    document.getElementById('inp_status').value = status;
    document.getElementById('inp_ket').value = ket !== 'null' ? ket : '';
    document.getElementById('inp_date').value = date || '{{ date('Y-m-d') }}';
    document.getElementById('studentGroup').style.display = 'none';
    document.getElementById('scheduleGroup').style.display = 'none';
    document.getElementById('dateGroup').style.display = '';
    document.getElementById('inp_student').disabled = true;
    document.getElementById('inp_schedule').disabled = true;
    document.getElementById('inp_date').disabled = false;
    document.getElementById('modalBg').classList.add('show');
}

function syncScheduleOptionsByStudent() {
    const studentSelect = document.getElementById('inp_student');
    const scheduleSelect = document.getElementById('inp_schedule');
    if (!studentSelect || !scheduleSelect) return;

    const selectedStudentOption = studentSelect.options[studentSelect.selectedIndex];
    const selectedClassId = selectedStudentOption ? selectedStudentOption.getAttribute('data-class-id') : '';

    let hasVisibleOption = false;
    Array.from(scheduleSelect.options).forEach((option, index) => {
        if (index === 0) {
            option.hidden = false;
            return;
        }
        const optionClass = option.getAttribute('data-class-id');
        const shouldShow = !selectedClassId || optionClass === selectedClassId;
        option.hidden = !shouldShow;

        if (shouldShow) {
            hasVisibleOption = true;
        }

        if (!shouldShow && option.selected) {
            scheduleSelect.value = '';
        }
    });

    scheduleSelect.disabled = !hasVisibleOption && !!selectedClassId;
}

document.getElementById('inp_student')?.addEventListener('change', syncScheduleOptionsByStudent);
window.addEventListener('load', syncScheduleOptionsByStudent);

function closeModal() {
    document.getElementById('modalBg').classList.remove('show');
}

document.getElementById('modalBg').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

function toast(type, title, msg) {
    const ic = {s:'fa-check', e:'fa-times'};
    const el = document.createElement('div');
    el.className = 'toast';
    el.innerHTML = `<div class="t-ic ${type}"><i class="fas ${ic[type]}"></i></div><div><div class="t-ttl">${title}</div><div class="t-msg">${msg}</div></div>`;
    document.getElementById('toasts').appendChild(el);
    setTimeout(() => { el.classList.add('hide'); setTimeout(() => el.remove(), 250); }, 3200);
}

@if(session('success')) window.addEventListener('load', () => toast('s','Berhasil','{{ session('success') }}')); @endif
@if(session('error'))   window.addEventListener('load', () => toast('e','Error','{{ session('error') }}')); @endif
@if($errors->any()) window.addEventListener('load', openModal); @endif
</script>
@endsection
