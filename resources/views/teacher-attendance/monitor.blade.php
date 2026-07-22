@extends('layouts.app')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
.content-wrapper .badge,.content-wrapper .alert{padding:0!important;border-radius:0!important;font-size:inherit!important;font-weight:inherit!important;text-transform:none!important;background:none!important;color:inherit!important;border:none!important;display:block!important;position:static!important;width:auto!important;height:auto!important;line-height:inherit!important;margin:0!important}
.content-wrapper table{border-collapse:collapse!important;border-spacing:0!important;width:100%!important}
.content-wrapper table th,.content-wrapper table td{border:none!important;padding:0!important;background:none!important;vertical-align:middle!important}
.content-wrapper table thead tr{background:none!important}
.content-wrapper table tbody tr:hover{background:none!important}
.content-wrapper .btn,.content-wrapper .form-control,.content-wrapper .form-select,.content-wrapper textarea{font-family:inherit!important;box-shadow:none!important;border:none!important;background:none!important;padding:0!important;color:inherit!important;outline:none!important}
.content-wrapper .dropdown-menu{box-shadow:none!important;border:none!important;background:none!important}
.content-wrapper .card{background:none!important;border:none!important;box-shadow:none!important;border-radius:0!important;overflow:visible!important;padding:0!important;margin:0!important}
.content-wrapper .row{margin:0!important;gap:0!important;display:block!important}
.content-wrapper [class*="col-"]{padding:0!important;margin:0!important;flex:none!important;width:auto!important}
.content-wrapper .container,.content-wrapper .container-fluid{padding:0!important;max-width:none!important;margin:0!important}
.content-wrapper .collapse{display:block!important;visibility:visible!important;height:auto!important;overflow:visible!important}
.content-wrapper .navbar{padding:0!important;position:static!important;min-height:0!important}
.content-wrapper .nav-link{color:inherit!important;background:none!important;padding:0!important}
.content-wrapper .modal-backdrop{display:none!important}
.content-wrapper img{max-width:none!important}
.content-wrapper *,.content-wrapper *::before,.content-wrapper *::after{box-sizing:border-box}

:root {
    --sb: 72px;
    --sb-open: 250px;
}

.content-wrapper{
    --sw:72px;--sw-open:250px;
    --sb:var(--sw);
    --bg:#f0f2f7;--card:#fff;--border:#e4e8f0;--border2:#cdd3e0;
    --txt:#0c1322;--txt2:#586070;--txt3:#8e96a8;
    --blue:#1a56db;--blue-lt:#eef3ff;--blue-md:#bfcffd;
    --green:#057a55;--green-lt:#ecfdf5;--green-md:#6ee7b7;
    --red:#c81e1e;--red-lt:#fef2f2;--red-md:#fca5a5;
    --amber:#b45309;--amber-lt:#fffbeb;--amber-md:#fcd34d;
    --purple:#5521b5;--purple-lt:#f5f3ff;--purple-md:#c4b5fd;
    --teal:#0694a2;--teal-lt:#e6fffa;--teal-md:#7edce2;
    --indigo:#3730a3;--indigo-lt:#eef2ff;
    --sb-bg:#0f1623;--sb-border:#1e2840;
    --r:14px;--r-lg:18px;
    --sh:0 1px 3px rgba(0,0,0,.05),0 2px 8px rgba(0,0,0,.04);
    --sh-md:0 4px 20px rgba(0,0,0,.09);
    --sh-lg:0 12px 40px rgba(0,0,0,.12);
    --hover:#f7f9ff;--head:#fafbfe;--input-bg:#f7f8fa;
    --muted:#f0f2f8;--grid:#eef0f6;
    font-family:'DM Sans','Plus Jakarta Sans',sans-serif!important;
    background:var(--bg)!important;color:var(--txt)!important;
    -webkit-font-smoothing:antialiased;padding:0!important;margin:0!important;min-height:100vh;
    transition:background .3s,color .3s,border-color .3s;
}
[data-theme="dark"] .content-wrapper{
    --bg:#0a0a0c;--card:#111113;--border:rgba(255,255,255,.07);--border2:rgba(255,255,255,.13);
    --txt:#f0f0f2;--txt2:#a1a1aa;--txt3:#71717a;
    --blue:#5b8af5;--blue-lt:rgba(91,138,245,.06);--blue-md:rgba(91,138,245,.15);
    --green:#34d399;--green-lt:rgba(52,211,153,.06);--green-md:rgba(52,211,153,.15);
    --red:#f87171;--red-lt:rgba(248,113,113,.06);--red-md:rgba(248,113,113,.15);
    --amber:#fbbf24;--amber-lt:rgba(251,191,36,.06);--amber-md:rgba(251,191,36,.15);
    --purple:#a78bfa;--purple-lt:rgba(167,139,250,.06);--purple-md:rgba(167,139,250,.15);
    --teal:#0ab0bf;--teal-lt:rgba(10,176,191,.06);--teal-md:rgba(10,176,191,.15);
    --indigo:#818cf8;--indigo-lt:rgba(129,140,248,.06);
    --sb-bg:#080a10;--sb-border:rgba(255,255,255,.04);
    --sh:0 1px 3px rgba(0,0,0,.15);--sh-md:0 4px 20px rgba(0,0,0,.2);--sh-lg:0 12px 40px rgba(0,0,0,.3);
    --hover:rgba(255,255,255,.03);--head:rgba(255,255,255,.03);
    --input-bg:#0c0c0e;--muted:rgba(255,255,255,.04);
    --grid:rgba(255,255,255,.04);
}

.app{display:flex;min-height:100vh;width:100%;}
.main{margin-left:72px !important;width:calc(100% - 72px) !important;min-width:0;flex:1;display:flex;flex-direction:column;min-height:100vh;transition:margin-left .25s cubic-bezier(.4,0,.2,1)}

.kp-app .kp-sb{width:var(--sw) !important;background:linear-gradient(180deg,#0b1220 0%,#1e2a78 52%,#0c7a86 100%);position:fixed;top:0;left:0;height:100vh;z-index:300;display:flex;flex-direction:column;align-items:center;padding:16px 0 20px;transition:width .25s cubic-bezier(.4,0,.2,1),padding .25s cubic-bezier(.4,0,.2,1);overflow:hidden;border-right:1px solid rgba(255,255,255,.12);transform:none !important}
.kp-app .kp-sb:hover{width:var(--sw-open) !important;align-items:flex-start;padding-left:12px;padding-right:12px}
.kp-app .kp-sb:hover ~ .kp-main{margin-left:var(--sw-open) !important}
.kp-sb-brand{display:flex;align-items:center;justify-content:center;gap:0;padding:4px 8px;width:100%;min-height:42px;margin-bottom:22px}
.kp-app .kp-sb:hover .kp-sb-brand{justify-content:flex-start;gap:10px;padding-left:13px;padding-right:13px}
.kp-sb-mark{width:32px;height:32px;border-radius:9px;flex-shrink:0;background:linear-gradient(135deg,#2563eb,#0ea5e9);display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px}
.kp-sb-name{font-family:'Syne',sans-serif;font-size:13px;font-weight:700;color:#fff;white-space:nowrap;opacity:0;transition:opacity .18s}
.kp-sb:hover .kp-sb-name{opacity:1}
.kp-sb-nav{width:100%;padding:0 8px;flex:1;display:flex;flex-direction:column;gap:1px;overflow-y:auto;overflow-x:hidden}
.kp-app .kp-sb:hover .kp-sb-nav{padding:0 9px}
.kp-sb-nav::-webkit-scrollbar{display:none}
.kp-app .kp-sb-grp{font-size:8px;font-weight:700;letter-spacing:.16em;color:#9db2cf;text-transform:uppercase;padding:14px 9px 4px;white-space:nowrap;opacity:0;max-width:0;overflow:hidden;pointer-events:none;transition:opacity .15s,max-width .15s}
.kp-app .kp-sb:hover .kp-sb-grp{opacity:1;max-width:200px;pointer-events:auto}
.kp-sb-a{display:flex;align-items:center;justify-content:center;gap:0;padding:7px 9px;border-radius:9px;color:#5e6e88;font-size:12.5px;font-weight:500;text-decoration:none!important;white-space:nowrap;transition:all .14s;cursor:pointer;min-width:0}
.kp-app .kp-sb:hover .kp-sb-a{justify-content:flex-start;gap:9px}
.kp-sb-a .kp-ic{width:32px;height:32px;border-radius:8px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:12px;color:#4b5a72;transition:all .14s}
.kp-sb-a:hover{color:#ffffff!important;background:rgba(255,255,255,.09)!important}
.kp-sb-a:hover .kp-ic{background:rgba(255,255,255,.13);color:#ffffff}
.kp-sb-a.on{color:#fff!important}
.kp-sb-a.on .kp-ic{background:linear-gradient(135deg,#2563eb,#0ea5e9);color:#fff;box-shadow:0 3px 12px rgba(14,116,144,.35)}
.kp-app .kp-sb-lbl{opacity:0;transition:opacity .15s,max-width .15s;pointer-events:none;color:#e2e8f0;min-width:0;flex:1;max-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap !important}
.kp-app .kp-sb:hover .kp-sb-lbl{opacity:1;pointer-events:auto;max-width:200px}
.kp-sb-foot{width:100%;padding:0 9px;margin-top:auto;border-top:1px solid var(--sb-border);padding-top:12px}
.kp-sb-user{display:flex;align-items:center;gap:8px;padding:8px;border-radius:9px;background:rgba(255,255,255,.04);margin-bottom:5px}
.kp-sb-av{width:30px;height:30px;border-radius:8px;flex-shrink:0;background:linear-gradient(135deg,var(--amber),#f59e0b);color:#fff;font-weight:700;font-size:12px;display:flex;align-items:center;justify-content:center}
.kp-sb-uname{font-size:11.5px;font-weight:700;color:#eef2f8}
.kp-sb-urole{font-size:9.5px;color:#4a5a72}
.kp-sb-out{display:flex;align-items:center;gap:9px;padding:8px;border-radius:9px;background:transparent!important;border:none!important;color:#e55!important;font-size:12px;font-weight:600;cursor:pointer;width:100%;font-family:inherit;white-space:nowrap;transition:background .13s}
.kp-sb-out:hover{background:rgba(220,50,50,.1)!important;color:#ff6666!important}
.kp-sb-out .kp-ic{width:30px;height:30px;border-radius:8px;background:rgba(220,50,50,.08);display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0}

.kp-topbar{display:flex;align-items:center;justify-content:space-between;padding:12px 26px;background:var(--bg);border-bottom:1px solid var(--border);position:sticky;top:0;z-index:100;gap:12px;transition:background .3s,border-color .3s}
.kp-top-ttl{font-family:'Syne',sans-serif;font-size:18px;font-weight:800;color:var(--txt);letter-spacing:-.4px;transition:color .3s}
.kp-top-sub{font-size:12.5px;color:var(--txt2);margin-top:2px;display:flex;align-items:center;gap:8px;flex-wrap:wrap;transition:color .3s;font-weight:500}
.kp-clock{font-family:'DM Mono',monospace;font-size:11px;color:var(--txt3);background:var(--card);border:1px solid var(--border);padding:4px 10px;border-radius:8px;font-weight:500;transition:background .3s,border-color .3s,color .3s}
.kp-top-btn{width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;background:var(--card);border:1px solid var(--border);color:var(--txt2);font-size:13px;cursor:pointer;transition:all .15s;flex-shrink:0}
.kp-top-btn:hover{background:var(--head);color:var(--txt);border-color:var(--border2)}
.kp-ro-badge{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:99px;background:var(--amber-lt);border:1px solid var(--amber-md);color:var(--amber);font-size:11px;font-weight:700;transition:background .3s,border-color .3s,color .3s}
.kp-hamburger{display:none;background:none!important;border:1px solid var(--border)!important;border-radius:8px;width:36px;height:36px;align-items:center;justify-content:center;cursor:pointer;color:var(--txt2)!important;font-size:14px;padding:0!important}
.kp-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:299}
.kp-overlay.kp-show{display:block}

.kp-body{padding:20px 20px;flex:1}

.kp-shell{display:grid;gap:14px}
.kp-hero{position:relative;overflow:hidden;background:linear-gradient(135deg,#1f3c88 0%,#1b5fbf 45%,#0ea5a4 100%);border-radius:18px;padding:20px 22px;border:1px solid rgba(255,255,255,.18);box-shadow:var(--sh-md);color:#fff}
.kp-hero::after{content:"";position:absolute;width:180px;height:180px;right:-45px;top:-55px;border-radius:999px;background:radial-gradient(circle,rgba(255,255,255,.34) 0%,rgba(255,255,255,0) 70%);pointer-events:none}
.kp-hero-head{display:flex;align-items:flex-start;justify-content:space-between;gap:14px;position:relative;z-index:1}
.kp-hero-kicker{display:inline-flex;align-items:center;gap:6px;font-size:10px;font-weight:800;letter-spacing:.12em;text-transform:uppercase;padding:6px 10px;border-radius:999px;background:rgba(255,255,255,.2);border:1px solid rgba(255,255,255,.3)}
.kp-hero-title{margin:10px 0 5px;font-family:'Syne',sans-serif;font-size:24px;line-height:1.2;letter-spacing:-.02em}
.kp-hero-sub{font-size:13px;color:rgba(255,255,255,.88);max-width:680px}
.kp-hero-day{display:inline-flex;align-items:center;gap:8px;padding:8px 11px;border-radius:10px;background:rgba(0,0,0,.16);border:1px solid rgba(255,255,255,.25);font-family:'DM Mono',monospace;font-size:11px;font-weight:500;white-space:nowrap}
.kp-hero-tools{display:flex;align-items:center;gap:8px}
.kp-hero-hamburger{display:none;width:36px;height:36px;border-radius:10px;border:1px solid rgba(255,255,255,.36);background:rgba(255,255,255,.12);color:#fff;align-items:center;justify-content:center;cursor:pointer;font-size:14px;flex-shrink:0}
.kp-hero-theme{width:36px;height:36px;border-radius:10px;border:1px solid rgba(255,255,255,.36);background:rgba(255,255,255,.12);color:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:13px;transition:background .15s,border-color .15s}
.kp-hero-theme:hover{background:rgba(255,255,255,.2);border-color:rgba(255,255,255,.55)}

.kp-content-card{background:var(--card);border:1px solid var(--border);border-radius:16px;box-shadow:var(--sh);padding:18px}
.kp-filter{display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap}
.kp-field{display:flex;flex-direction:column;gap:6px}
.kp-field label{font-size:11px;font-weight:700;color:var(--txt2);text-transform:uppercase;letter-spacing:.11em}
.kp-date{padding:11px 13px;border-radius:10px;border:1px solid var(--border);background:var(--input-bg);color:var(--txt);font-size:13px;min-width:210px;transition:border-color .15s,box-shadow .15s}
.kp-date:focus{border-color:var(--blue);box-shadow:0 0 0 3px var(--blue-lt)}
.kp-btn{padding:11px 16px;border-radius:10px;border:none;background:linear-gradient(135deg,#0f766e,#0ea5a4);color:#fff;font-size:13px;font-weight:700;cursor:pointer;transition:transform .14s,box-shadow .14s,filter .14s}
.kp-btn:hover{transform:translateY(-1px);box-shadow:0 8px 18px rgba(14,165,164,.26);filter:saturate(108%)}

.kp-btn-ghost{padding:11px 14px;border-radius:10px;border:1px solid var(--border2);background:var(--card);color:var(--txt);font-size:13px;font-weight:700;cursor:pointer;transition:all .14s}
.kp-btn-ghost:hover{background:var(--hover);border-color:var(--blue-md);color:var(--blue)}

.kp-stats{margin-left:auto;display:grid;grid-template-columns:repeat(3,minmax(130px,1fr));gap:10px;min-width:min(100%,430px)}
.kp-stat{padding:10px 11px;border-radius:12px;border:1px solid var(--border);background:var(--head);display:flex;flex-direction:column;gap:2px}
.kp-stat-label{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.11em;color:var(--txt3)}
.kp-stat-value{font-size:18px;font-weight:800;color:var(--txt);line-height:1.15}
.kp-stat-note{font-size:11px;color:var(--txt2)}
.kp-stat.ok{background:var(--green-lt);border-color:var(--green-md)}
.kp-stat.ok .kp-stat-value{color:var(--green)}
.kp-stat.warn{background:var(--red-lt);border-color:var(--red-md)}
.kp-stat.warn .kp-stat-value{color:var(--red)}

.kp-table-wrap{margin-top:15px;overflow-x:auto;border-radius:14px;border:1px solid var(--border);background:var(--card);box-shadow:inset 0 1px 0 rgba(255,255,255,.24)}
.kp-table{width:100%;border-collapse:separate;border-spacing:0;min-width:920px}
.kp-table thead th{position:sticky;top:0;z-index:2;background:linear-gradient(180deg,color-mix(in srgb,var(--head) 72%,var(--blue-lt) 28%) 0%,var(--head) 100%);padding:10px 12px;font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.11em;color:#41506b;text-align:left;border-bottom:1px solid var(--border)}
.kp-table thead th:first-child{border-top-left-radius:12px}
.kp-table thead th:last-child{border-top-right-radius:12px}
.kp-table tbody td{padding:10px 12px;font-size:12px;color:var(--txt);border-bottom:1px solid var(--grid);background:var(--card);transition:background .14s,color .14s;line-height:1.35}
.kp-table tbody tr:nth-child(2n) td{background:color-mix(in srgb,var(--card) 88%,#dbeafe 12%)}
.kp-table tbody tr:hover td{background:color-mix(in srgb,var(--hover) 76%,#bfdbfe 24%)}
.kp-table tbody tr:hover td:first-child{color:#0f3f9a}
.kp-teacher{font-weight:700;font-size:12.2px}
.kp-chip{display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:999px;font-size:10px;font-weight:800;letter-spacing:.01em;box-shadow:0 1px 0 rgba(255,255,255,.55) inset;white-space:nowrap}
.kp-chip.ok{background:linear-gradient(180deg,color-mix(in srgb,var(--green-lt) 70%,#fff 30%) 0%,var(--green-lt) 100%);color:var(--green);border:1px solid var(--green-md)}
.kp-chip.warn{background:linear-gradient(180deg,color-mix(in srgb,var(--red-lt) 70%,#fff 30%) 0%,var(--red-lt) 100%);color:var(--red);border:1px solid var(--red-md)}
.kp-empty{padding:24px 16px!important;text-align:center!important;color:var(--txt2)!important;font-size:12px!important}

[data-theme="dark"] .kp-hero{background:linear-gradient(135deg,#102353 0%,#0f3d7b 45%,#0f766e 100%);border-color:rgba(255,255,255,.15)}
[data-theme="dark"] .kp-hero-day{background:rgba(0,0,0,.26)}
[data-theme="dark"] .kp-hero-theme,[data-theme="dark"] .kp-hero-hamburger{background:rgba(0,0,0,.25);border-color:rgba(255,255,255,.3)}
[data-theme="dark"] .kp-table-wrap{box-shadow:inset 0 1px 0 rgba(255,255,255,.04)}
[data-theme="dark"] .kp-table thead th{background:linear-gradient(180deg,#182235 0%,#121a2b 100%);color:#9db2cf;border-bottom-color:#253047}
[data-theme="dark"] .kp-table tbody tr:nth-child(2n) td{background:color-mix(in srgb,var(--card) 86%,#18253d 14%)}
[data-theme="dark"] .kp-table tbody tr:hover td{background:color-mix(in srgb,#1a2942 65%,var(--hover) 35%)}
[data-theme="dark"] .kp-table tbody tr:hover td:first-child{color:#93c5fd}

@media(max-width:1100px){
    .kp-stats{margin-left:0;min-width:0;width:100%;grid-template-columns:repeat(3,minmax(0,1fr))}
}

@media(max-width:768px){
    .kp-sb{transform:translateX(-100%);width:var(--sw-open);align-items:flex-start}
    .kp-sb.kp-open{transform:translateX(0)}
    .kp-sb .kp-sb-lbl{opacity:1!important;pointer-events:auto!important}
    .kp-sb .kp-sb-grp{opacity:1!important;max-width:200px!important}
    .main, #dashApp.sb-open .main{margin-left:0!important;width:100%!important}
    .kp-hamburger{display:flex}
    .kp-overlay.kp-show{display:block}
    .kp-body{padding:14px}
    .kp-hero{padding:16px}
    .kp-hero-head{flex-direction:column;align-items:flex-start}
    .kp-hero-title{font-size:21px}
    .kp-hero-tools{align-self:stretch;justify-content:space-between;width:100%}
    .kp-hero-hamburger{display:flex}
    .kp-filter{align-items:stretch}
    .kp-date{min-width:0;width:100%}
    .kp-btn{width:100%}
    .kp-stats{grid-template-columns:1fr}
    .kp-table{min-width:700px}
}
</style>
@endpush

@section('title', 'Monitor Absensi Mengajar Guru')

@section('content')
<div id="dashApp" class="app content-wrapper">

    @include('partials.sidebar')
    
<div id="dashMain" class="main">
    <div class="kp-body">
        @php
            $totalSchedule = $teacherSchedules->count();
            $presentCount = 0;
            foreach ($teacherSchedules as $item) {
                $lookupKey = ($item->teacher_id ?? 0) . '-' . $item->id;
                if ($attendanceMap->has($lookupKey)) {
                    $presentCount++;
                }
            }
            $notYetCount = max($totalSchedule - $presentCount, 0);
        @endphp

        <div class="kp-shell">
            <section class="kp-hero">
                <div class="kp-hero-head">
                    <div>
                        <span class="kp-hero-kicker"><i class="fas fa-wave-square"></i> MONITORING REAL-TIME</span>
                        <h1 class="kp-hero-title">Pantau Absensi Guru Lebih Cepat</h1>
                        <p class="kp-hero-sub">Lihat kehadiran guru berdasarkan jadwal harian, identifikasi sesi yang belum terisi absensi, dan pantau kedisiplinan mengajar dalam satu tampilan.</p>
                    </div>
                    <div class="kp-hero-tools">
                    <button class="kp-hero-hamburger db-hamburger" data-sidebar-toggle type="button" aria-label="Buka menu"><i class="fas fa-bars"></i></button>
                        <div class="kp-hero-day"><i class="fas fa-calendar-day"></i> {{ $date->format('d M Y') }} · {{ $dayName }}</div>
                    </div>
                </div>
            </section>

            <section class="kp-content-card">
                <form method="GET" class="kp-filter">
                    <div class="kp-field">
                        <label for="monitorDate">Tanggal Monitoring</label>
                        <input id="monitorDate" class="kp-date" type="date" name="date" value="{{ $date->format('Y-m-d') }}">
                    </div>
                    <div class="kp-field" style="min-width:240px;">
                        <label for="monitorTeacher">Cari Guru</label>
                        <input id="monitorTeacher" class="kp-date" type="text" name="teacher" value="{{ $teacherQuery ?? '' }}" placeholder="Contoh: Ryan">
                    </div>
                    <button type="submit" class="kp-btn">Terapkan Filter</button>
                    <button type="submit" name="search_mode" value="teacher" class="kp-btn-ghost">Cari Guru</button>

                    <div class="kp-stats">
                        <div class="kp-stat">
                            <span class="kp-stat-label">Total Sesi</span>
                            <span class="kp-stat-value">{{ $totalSchedule }}</span>
                            <span class="kp-stat-note">jadwal hari ini</span>
                        </div>
                        <div class="kp-stat ok">
                            <span class="kp-stat-label">Sudah Absen</span>
                            <span class="kp-stat-value">{{ $presentCount }}</span>
                            <span class="kp-stat-note">status hadir</span>
                        </div>
                        <div class="kp-stat warn">
                            <span class="kp-stat-label">Belum Absen</span>
                            <span class="kp-stat-value">{{ $notYetCount }}</span>
                            <span class="kp-stat-note">perlu tindak lanjut</span>
                        </div>
                    </div>
                </form>

                <div style="margin-bottom: 20px;">
                    <label for="kpTeacherSearch" style="display:block; font-size:12px; font-weight:700; color:var(--txt2); margin-bottom:8px; text-transform:uppercase; letter-spacing:.06em;">Cari Guru</label>
                    <div style="display:flex; gap:8px; align-items:center;">
                        <input 
                            id="kpTeacherSearch" 
                            type="text" 
                            placeholder="Ketik nama guru..." 
                            value="{{ $teacherQuery ?? '' }}"
                            style="width:100%; padding:12px 14px; border:1px solid var(--border); border-radius:10px; background:var(--card); color:var(--txt); font-size:13px; outline:none; font-family:inherit;"
                        >
                        <button type="button" id="kpTeacherSearchBtn" class="kp-btn-ghost" style="white-space:nowrap;">
                            <i class="fas fa-search"></i> Cari Guru
                        </button>
                    </div>
                </div>

                <div id="kpTeacherSummary" style="display:none; margin-bottom:20px; padding:16px; border-radius:12px; background:linear-gradient(135deg, rgba(37,99,235,.08), rgba(14,165,233,.08)); border:1px solid rgba(37,99,235,.2);">
                    <div style="font-size:13px; font-weight:700; color:var(--txt); margin-bottom:10px;">
                        Jadwal <span id="kpTeacherName" style="color:#2563eb;"></span>
                    </div>
                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:12px;">
                        <div style="background:var(--card); padding:12px; border-radius:10px; border:1px solid var(--border);">
                            <div style="font-size:11px; color:var(--txt2); text-transform:uppercase; font-weight:700; margin-bottom:6px;">Mata Pelajaran</div>
                            <div id="kpTeacherSubjects" style="font-size:13px; color:var(--txt); line-height:1.6;"></div>
                        </div>
                        <div style="background:var(--card); padding:12px; border-radius:10px; border:1px solid var(--border);">
                            <div style="font-size:11px; color:var(--txt2); text-transform:uppercase; font-weight:700; margin-bottom:6px;">Kelas Diampu</div>
                            <div id="kpTeacherClasses" style="font-size:13px; color:var(--txt); line-height:1.6;"></div>
                        </div>
                        <div style="background:var(--card); padding:12px; border-radius:10px; border:1px solid var(--border);">
                            <div style="font-size:11px; color:var(--txt2); text-transform:uppercase; font-weight:700; margin-bottom:6px;">Hari Mengajar</div>
                            <div id="kpTeacherDays" style="font-size:13px; color:var(--txt); line-height:1.6;"></div>
                        </div>
                        <div style="background:var(--card); padding:12px; border-radius:10px; border:1px solid var(--border);">
                            <div style="font-size:11px; color:var(--txt2); text-transform:uppercase; font-weight:700; margin-bottom:6px;">Total Sesi</div>
                            <div id="kpTeacherCount" style="font-size:13px; color:var(--txt); font-weight:700;"></div>
                        </div>
                    </div>
                </div>

                <div class="kp-table-wrap">
                    <table class="kp-table">
                        <thead>
                            <tr>
                                <th>Guru</th>
                                <th>Mapel</th>
                                <th>Kelas</th>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Ruang</th>
                                <th>Status Mengajar</th>
                                <th>Waktu Absen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teacherSchedules as $schedule)
                                @php
                                    $key = ($schedule->teacher_id ?? 0) . '-' . $schedule->id;
                                    $record = $attendanceMap->get($key);
                                    $start = $schedule->start_time instanceof \Carbon\Carbon ? $schedule->start_time->format('H:i') : \Carbon\Carbon::parse($schedule->start_time)->format('H:i');
                                    $end = $schedule->end_time instanceof \Carbon\Carbon ? $schedule->end_time->format('H:i') : \Carbon\Carbon::parse($schedule->end_time)->format('H:i');
                                @endphp
                                <tr>
                                    <td class="kp-teacher">{{ $schedule->teacher?->name ?? '-' }}</td>
                                    <td>{{ $schedule->subject->name ?? '-' }}</td>
                                    <td>{{ $schedule->class_id }}</td>
                                    <td>{{ $schedule->day }}</td>
                                    <td>{{ $start }} - {{ $end }}</td>
                                    <td>{{ $schedule->room ?? '-' }}</td>
                                    <td>
                                        @if($record)
                                            <span class="kp-chip ok"><i class="fas fa-check-circle"></i> HADIR</span>
                                        @else
                                            <span class="kp-chip warn"><i class="fas fa-triangle-exclamation"></i> BELUM ABSEN</span>
                                        @endif
                                    </td>
                                    <td>{{ $record?->checked_in_at?->format('d M Y H:i') ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="kp-empty">Tidak ada jadwal guru di tanggal ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>

</div>

<div class="kp-overlay" id="kpOverlay"></div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.getElementById('kpHamburger');
    const sidebar = document.getElementById('kpSb');
    const overlay = document.getElementById('kpOverlay');
    
    hamburger?.addEventListener('click', () => {
        sidebar?.classList.toggle('kp-open');
        overlay?.classList.toggle('kp-show');
    });
    
    overlay?.addEventListener('click', () => {
        sidebar?.classList.remove('kp-open');
        overlay?.classList.remove('kp-show');
    });

    function updateClock() {
        const kpClock = document.getElementById('kpClock');
        if (kpClock) {
            const now = new Date();
            kpClock.textContent = now.toLocaleTimeString('id-ID');
        }
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Teacher Search & Summary Feature
    const searchInput = document.getElementById('kpTeacherSearch');
    const searchButton = document.getElementById('kpTeacherSearchBtn');
    const summaryDiv = document.getElementById('kpTeacherSummary');
    const teacherNameSpan = document.getElementById('kpTeacherName');
    const subjectsDiv = document.getElementById('kpTeacherSubjects');
    const classesDiv = document.getElementById('kpTeacherClasses');
    const daysDiv = document.getElementById('kpTeacherDays');
    const countDiv = document.getElementById('kpTeacherCount');
    const tableBody = document.querySelector('.kp-table tbody');
    const weeklyOverview = @json($teacherWeeklyOverviewMap ?? []);

    let noResultEl = document.getElementById('kpNoTeacherResult');
    if (!noResultEl && tableBody) {
        noResultEl = document.createElement('div');
        noResultEl.id = 'kpNoTeacherResult';
        noResultEl.style.display = 'none';
        noResultEl.style.margin = '10px 0 0';
        noResultEl.style.padding = '10px 12px';
        noResultEl.style.borderRadius = '10px';
        noResultEl.style.border = '1px solid rgba(248,113,113,.35)';
        noResultEl.style.background = 'rgba(254,242,242,.8)';
        noResultEl.style.color = '#991b1b';
        noResultEl.style.fontSize = '12px';
        noResultEl.style.fontWeight = '700';
        tableBody.parentElement.parentElement.insertBefore(noResultEl, tableBody.parentElement.nextSibling);
    }

    if (searchInput && tableBody) {
        const runTeacherSearch = function() {
            const keyword = searchInput.value.toLowerCase().trim();
            const rows = tableBody.querySelectorAll('tr');
            let matchedRows = [];
            let teacherData = {};

            rows.forEach(row => {
                const teacherCell = row.querySelector('.kp-teacher');
                if (teacherCell) {
                    const teacherName = teacherCell.textContent.toLowerCase();
                    const isMatch = keyword === '' || teacherName.includes(keyword);
                    
                    row.style.display = isMatch ? '' : 'none';
                    row.style.backgroundColor = isMatch && keyword !== '' ? 'rgba(37,99,235,.06)' : '';
                    
                    if (isMatch && keyword !== '') {
                        matchedRows.push(row);
                        const name = teacherCell.textContent.trim();
                        const subject = row.cells[1]?.textContent.trim() || '-';
                        const className = row.cells[2]?.textContent.trim() || '-';
                        const day = row.cells[3]?.textContent.trim() || '-';
                        
                        if (!teacherData[name]) {
                            teacherData[name] = { subjects: new Set(), classes: new Set(), days: new Set() };
                        }
                        teacherData[name].subjects.add(subject);
                        teacherData[name].classes.add(className);
                        teacherData[name].days.add(day);
                    }
                }
            });

            if (keyword === '') {
                summaryDiv.style.display = 'none';
                if (noResultEl) {
                    noResultEl.style.display = 'none';
                    noResultEl.textContent = '';
                }
            } else if (matchedRows.length > 0) {
                const firstTeacher = matchedRows[0].querySelector('.kp-teacher').textContent.trim();
                const data = teacherData[firstTeacher];
                
                teacherNameSpan.textContent = firstTeacher;
                subjectsDiv.innerHTML = Array.from(data.subjects)
                    .filter(s => s !== '-')
                    .map(s => `<div style="padding:4px 0;"><i class="fas fa-book" style="margin-right:6px; color:#2563eb;"></i> ${s}</div>`)
                    .join('') || '<span style="color:var(--txt3);">-</span>';
                classesDiv.innerHTML = Array.from(data.classes)
                    .filter(c => c !== '-')
                    .map(c => `<div style="padding:4px 0;"><i class="fas fa-users" style="margin-right:6px; color:#2563eb;"></i> ${c}</div>`)
                    .join('') || '<span style="color:var(--txt3);">-</span>';
                daysDiv.innerHTML = Array.from(data.days)
                    .filter(d => d !== '-')
                    .map(d => `<div style="padding:4px 0;"><i class="fas fa-calendar" style="margin-right:6px; color:#2563eb;"></i> ${d}</div>`)
                    .join('') || '<span style="color:var(--txt3);">-</span>';
                countDiv.textContent = matchedRows.length + ' sesi';
                
                summaryDiv.style.display = 'block';
                if (noResultEl) {
                    noResultEl.style.display = 'none';
                    noResultEl.textContent = '';
                }
            } else {
                const fallback = weeklyOverview.find((item) => {
                    const teacherName = String(item.teacher_name || '').toLowerCase();
                    return keyword !== '' && teacherName.includes(keyword);
                });

                if (fallback) {
                    teacherNameSpan.textContent = fallback.teacher_name || '-';
                    subjectsDiv.innerHTML = (fallback.subjects || [])
                        .map((subject) => `<div style="padding:4px 0;"><i class="fas fa-book" style="margin-right:6px; color:#2563eb;"></i> ${subject}</div>`)
                        .join('') || '<span style="color:var(--txt3);">-</span>';

                    classesDiv.innerHTML = (fallback.classes || [])
                        .map((className) => `<div style="padding:4px 0;"><i class="fas fa-users" style="margin-right:6px; color:#2563eb;"></i> ${className}</div>`)
                        .join('') || '<span style="color:var(--txt3);">-</span>';

                    daysDiv.innerHTML = (fallback.days || [])
                        .map((day) => `<div style="padding:4px 0;"><i class="fas fa-calendar" style="margin-right:6px; color:#2563eb;"></i> ${day}</div>`)
                        .join('') || '<span style="color:var(--txt3);">-</span>';

                    countDiv.textContent = `${fallback.total_sessions || 0} sesi (mingguan)`;
                    summaryDiv.style.display = 'block';

                    if (noResultEl) {
                        noResultEl.style.display = 'block';
                        noResultEl.textContent = 'Tidak ada jadwal di tanggal ini untuk guru tersebut. Ringkasan mingguan tetap ditampilkan.';
                    }
                } else {
                    summaryDiv.style.display = 'none';
                    if (noResultEl) {
                        noResultEl.style.display = 'block';
                        noResultEl.textContent = 'Nama guru tidak ditemukan pada jadwal aktif.';
                    }
                }
            }
        };

        searchInput.addEventListener('input', runTeacherSearch);
        searchButton?.addEventListener('click', runTeacherSearch);

        if (searchInput.value.trim() !== '') {
            runTeacherSearch();
        }
    }
});
</script>
@endsection
