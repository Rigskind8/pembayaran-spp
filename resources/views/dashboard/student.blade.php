@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')

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
.user-chip { display:inline-flex; align-items:center; gap:8px; padding:7px 10px 7px 7px; border-radius:999px; background:#fff; border:1px solid var(--border); color:var(--txt); font-size:11px; font-weight:700; }
.user-chip .chip-av { width:24px; height:24px; border-radius:999px; overflow:hidden; background:linear-gradient(135deg,var(--blue),#4f46e5); color:#fff; display:flex; align-items:center; justify-content:center; font-size:11px; flex-shrink:0; }
.user-chip .chip-av img { width:100%; height:100%; object-fit:cover; display:block; }
.sb-mark { width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0; background: var(--blue); display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; }
.sb-name { font-size: 13px; font-weight: 700; color: white; white-space: nowrap; opacity: 0; transition: opacity .2s; }
.sb:hover .sb-name { opacity: 1; }
.sb-nav { width: 100%; padding: 0 10px; flex: 1; display: flex; flex-direction: column; gap: 2px; }
.sb-grp { font-size: 9px; font-weight: 700; letter-spacing: .14em; color: #374151; text-transform: uppercase; padding: 12px 8px 4px; white-space: nowrap; opacity: 0; transition: opacity .2s; }
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
.topbar { display: flex; align-items: center; justify-content: space-between; padding: 14px 28px; background: rgba(242,244,248,1); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; }
.top-title { font-size: 18px; font-weight: 800; color: var(--txt); }
.top-sub { font-size: 12px; color: var(--txt2); margin-top: 1px; }

/* PAGE */
.page { padding: 28px; flex: 1; }

/* BANNER */
.banner { background: radial-gradient(circle at 15% 20%, rgba(255,255,255,.2), transparent 45%), linear-gradient(120deg, #0f172a 0%, #1d4ed8 55%, #2563eb 100%); border-radius: 22px; padding: 26px 30px; display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 24px; position: relative; overflow: hidden; box-shadow: 0 14px 34px rgba(30,64,175,.22); }
.banner::before { content:''; position:absolute; right:-28px; top:-30px; width:190px; height:190px; border-radius:50%; background:rgba(255,255,255,.07); pointer-events:none; }
.banner::after { content:''; position:absolute; left:42%; bottom:-54px; width:240px; height:120px; border-radius:999px; background:rgba(255,255,255,.08); filter:blur(1px); pointer-events:none; }
.bn-tag { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:99px; background:rgba(255,255,255,.15); font-size:9.5px; font-weight:700; color:rgba(255,255,255,.85); letter-spacing:.08em; text-transform:uppercase; margin-bottom:10px; }
.bn-title { font-size:22px; font-weight:800; color:white; margin-bottom:4px; }
.bn-sub { font-size:12px; color:rgba(255,255,255,.6); }
.bn-badge { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.25); border-radius:10px; color:white; font-size:12px; font-weight:700; }

/* BROCHURE */
.brochure-grid { display:grid; grid-template-columns: 1.2fr .8fr; gap:14px; margin-bottom:22px; }
.brochure-card { background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%); border:1px solid var(--border); border-radius: 22px; padding:20px; box-shadow: var(--shadow); position:relative; overflow:hidden; }
.brochure-card::before { content:''; position:absolute; inset:auto -30px -30px auto; width:180px; height:180px; border-radius:50%; background:radial-gradient(circle, rgba(37,99,235,.12), transparent 68%); pointer-events:none; }
.brochure-hero { background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 54%, #2563eb 100%); color:white; }
.brochure-hero::before { background: radial-gradient(circle, rgba(255,255,255,.14), transparent 70%); }
.brochure-kicker { display:inline-flex; align-items:center; gap:6px; padding:5px 10px; border-radius:999px; background:rgba(255,255,255,.14); color:rgba(255,255,255,.88); font-size:10px; font-weight:800; letter-spacing:.08em; text-transform:uppercase; margin-bottom:12px; }
.brochure-title { font-size:22px; font-weight:800; line-height:1.15; letter-spacing:-.03em; margin-bottom:8px; }
.brochure-sub { font-size:12.5px; line-height:1.7; color:rgba(255,255,255,.78); max-width:64ch; }
.brochure-pills { display:flex; flex-wrap:wrap; gap:8px; margin-top:16px; }
.brochure-pill { display:inline-flex; align-items:center; gap:6px; padding:8px 11px; border-radius:999px; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.15); font-size:11px; font-weight:700; color:#fff; }

/* OVERVIEW - single card now */
.overview-card { background: var(--card); border:1px solid var(--border); border-radius: 18px; padding:18px 20px; box-shadow: var(--shadow); margin-bottom: 22px; }
.overview-head { display:flex; align-items:center; justify-content:space-between; gap:10px; margin-bottom:12px; }
.overview-title { font-size:14px; font-weight:800; color:var(--txt); }
.overview-sub { font-size:12px; color:var(--txt2); }

/* SUMMARY */
.summary-list { display:grid; gap:10px; margin-top:8px; }
.summary-row { display:flex; justify-content:space-between; gap:14px; align-items:flex-start; padding:12px 0; border-bottom:1px solid var(--border); }
.summary-row:last-child { border-bottom:none; padding-bottom:0; }
.summary-label { font-size:12px; color:var(--txt2); line-height:1.4; }
.summary-value { font-size:13px; font-weight:800; color:var(--txt); text-align:right; }
.progress-wrap { margin-top:14px; }
.progress-track { width:100%; height:10px; border-radius:999px; background:#edf2f7; overflow:hidden; }
.progress-bar { height:100%; border-radius:999px; background:linear-gradient(90deg, var(--blue) 0%, #4f46e5 60%, #06b6d4 100%); }
.progress-meta { display:flex; justify-content:space-between; gap:10px; margin-top:8px; font-size:11px; color:var(--txt2); }

/* DETAIL */
.detail-grid { display:grid; gap:10px; margin-top:14px; }
.detail-item { display:flex; align-items:flex-start; gap:10px; padding:12px; border-radius:14px; background:#f8fafc; border:1px solid #eef2f7; }
.detail-dot { width:10px; height:10px; margin-top:4px; border-radius:999px; background:var(--blue); flex-shrink:0; box-shadow:0 0 0 4px rgba(37,99,235,.12); }
.detail-item strong { font-size:12.5px; color:var(--txt); display:block; margin-bottom:3px; }
.detail-item span { display:block; font-size:11.5px; color:var(--txt2); line-height:1.55; }

/* STATS */
.stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
.stat-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); padding: 18px 20px; box-shadow: var(--shadow); display: flex; align-items: center; gap: 14px; transition: transform .15s, box-shadow .15s; }
.stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
.stat-ic { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
.stat-val { font-size: 22px; font-weight: 800; color: var(--txt); line-height: 1; }
.stat-lbl { font-size: 11px; color: var(--txt2); margin-top: 3px; font-weight: 600; }

/* GRID */
.grid2 { display: grid; grid-template-columns: 1.15fr .85fr; gap: 18px; margin-bottom: 18px; }
.stack-col { display:flex; flex-direction:column; gap:16px; }

/* CARD */
.card { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); box-shadow: var(--shadow); overflow: hidden; }
.card-head { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
.card-ttl { font-size: 14px; font-weight: 800; color: var(--txt); }
.card-sub { font-size: 11px; color: var(--txt2); margin-top: 2px; }

/* TABLE */
table { width: 100%; border-collapse: collapse; }
thead th { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--txt3); padding: 10px 20px; text-align: left; background: #fafafa; border-bottom: 1px solid var(--border); }
tbody td { padding: 12px 20px; font-size: 13px; color: var(--txt); border-bottom: 1px solid #f5f5f7; vertical-align: middle; }
tbody tr:last-child td { border-bottom: none; }
tbody tr:hover td { background: #fafbff; }

/* BADGES */
.badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 99px; font-size: 11px; font-weight: 700; }
.badge-green { background: var(--green-bg); color: var(--green); }
.badge-amber { background: var(--amber-bg); color: var(--amber); }
.badge-blue  { background: var(--blue-bg);  color: var(--blue); }
.badge-red   { background: var(--red-bg);   color: var(--red); }

/* BUTTONS */
.btn-bayar { display:inline-flex; align-items:center; gap:5px; background:var(--blue); color:white; border:none; border-radius:8px; padding:5px 12px; font-size:11px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .15s; }
.btn-bayar:hover { background:#1d4ed8; }
.btn-bukti { display:inline-flex; align-items:center; gap:5px; background:white; color:var(--txt2); border:1px solid var(--border); border-radius:8px; padding:5px 12px; font-size:11px; font-weight:700; cursor:pointer; font-family:inherit; transition:border-color .15s; margin-left:4px; }
.btn-bukti:hover { border-color:var(--blue); color:var(--blue); }

/* PROFILE */
.profile-card { padding: 20px; }
.profile-av { width:64px; height:64px; border-radius:16px; background:linear-gradient(135deg,var(--blue),#4f46e5); color:white; font-weight:800; font-size:26px; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; overflow:hidden; position:relative; }
.profile-av img { width:100%; height:100%; object-fit:cover; display:block; }
.profile-name { font-size:15px; font-weight:800; text-align:center; }
.profile-nis { font-size:11px; color:var(--txt2); text-align:center; margin-top:3px; }
.profile-row { display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid var(--border); }
.profile-row:last-child { border-bottom:none; }
.profile-lbl { font-size:11.5px; color:var(--txt2); font-weight:600; }
.profile-val { font-size:12px; font-weight:700; text-align:right; }
.divider { height:1px; background:var(--border); margin:14px 0; }

/* ABSENSI */
.abs-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:10px; padding:16px; }
.abs-item { background:#f8f9fc; border:1px solid var(--border); border-radius:10px; padding:13px; text-align:center; }
.abs-ic { width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:14px; margin:0 auto 7px; }
.abs-val { font-size:20px; font-weight:800; line-height:1; }
.abs-lbl { font-size:10px; color:var(--txt2); margin-top:3px; font-weight:600; text-transform:uppercase; letter-spacing:.06em; }

/* EMPTY */
.empty-state { padding:36px 20px; text-align:center; color:var(--txt3); }
.empty-state i { font-size:36px; margin-bottom:10px; display:block; }

/* MODAL */
.modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:1000; align-items:center; justify-content:center; }
.modal-overlay.show { display:flex; }
.modal-box { background:white; border-radius:20px; box-shadow:0 20px 60px rgba(0,0,0,.2); width:100%; max-width:460px; margin:16px; overflow:hidden; animation:mIn .2s ease; }
@keyframes mIn { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:none} }
.modal-hd { padding:18px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; }
.modal-ttl { font-size:15px; font-weight:800; }
.modal-close { background:none; border:none; font-size:18px; color:var(--txt3); cursor:pointer; padding:2px 6px; border-radius:6px; }
.modal-close:hover { background:#f3f4f6; color:var(--txt); }
.modal-body { padding:20px; max-height:70vh; overflow-y:auto; }
.modal-ft { padding:14px 20px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:8px; }

/* Info box */
.info-box { background:var(--blue-bg); border:1px solid #bfdbfe; border-radius:12px; padding:14px 16px; margin-bottom:18px; }
.info-box .lbl { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#3b82f6; }
.info-box .val { font-size:18px; font-weight:800; color:#1e40af; margin-top:2px; }
.info-box .sub { font-size:11px; color:#3b82f6; margin-top:2px; }

/* Step indicator */
.step { display:flex; align-items:flex-start; gap:12px; margin-bottom:14px; }
.step-num { width:24px; height:24px; border-radius:50%; background:var(--blue); color:white; font-size:11px; font-weight:800; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:1px; }
.step-txt { font-size:13px; color:var(--txt); line-height:1.5; }
.step-txt strong { font-weight:700; }

/* Metode cards */
.metode-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:16px; }
.metode-card { border:2px solid var(--border); border-radius:12px; padding:12px; cursor:pointer; transition:border-color .15s, background .15s; }
.metode-card:hover { border-color:#93c5fd; background:#f0f7ff; }
.metode-card.selected { border-color:var(--blue); background:var(--blue-bg); }
.metode-card .m-icon { font-size:20px; margin-bottom:6px; }
.metode-card .m-name { font-size:12px; font-weight:700; color:var(--txt); }
.metode-card .m-bank { font-size:10px; color:var(--txt2); margin-top:2px; }

/* Instruksi */
.instruksi-box { background:#f8fafc; border:1px solid var(--border); border-radius:12px; padding:16px; margin-bottom:16px; display:none; }
.instruksi-box.show { display:block; }
.instruksi-title { font-size:12px; font-weight:700; color:var(--txt2); text-transform:uppercase; letter-spacing:.06em; margin-bottom:12px; }
.instruksi_qr_preview { text-align:center; margin:14px 0; }
.instruksi_qr_preview img { width:260px; max-width:100%; border-radius:14px; border:2px solid var(--border); object-fit:contain; background:#f8fafc; padding:8px; }
.kode-box { background:white; border:1.5px solid #bfdbfe; border-radius:10px; padding:12px 14px; display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; }
.kode-val { font-size:18px; font-weight:800; color:#1e40af; letter-spacing:.05em; font-family:monospace; }
.kode-sub { font-size:11px; color:var(--txt2); margin-top:2px; }
.btn-copy { background:var(--blue); color:white; border:none; border-radius:8px; padding:6px 12px; font-size:11px; font-weight:700; cursor:pointer; font-family:inherit; white-space:nowrap; flex-shrink:0; transition:background .15s; }
.btn-copy:hover { background:#1d4ed8; }
.tunai-info { background:var(--green-bg); border:1px solid #86efac; border-radius:10px; padding:12px 14px; font-size:13px; color:var(--green); font-weight:600; }

/* Form fields */
.fm-lbl { font-size:11.5px; font-weight:700; color:var(--txt2); margin-bottom:6px; display:block; }
.fm-sel, .fm-ta, .fm-input { width:100%; border:1.5px solid var(--border); border-radius:10px; padding:9px 12px; font-size:13px; font-family:inherit; color:var(--txt); background:white; margin-bottom:14px; transition:border-color .15s; outline:none; }
.fm-sel:focus, .fm-ta:focus, .fm-input:focus { border-color:var(--blue); box-shadow:0 0 0 3px rgba(37,99,235,.1); }
.avatar-preview-wrap { display:flex; align-items:center; gap:14px; margin-bottom:14px; }
.avatar-preview { width:72px; height:72px; border-radius:18px; overflow:hidden; background:linear-gradient(135deg,var(--blue),#4f46e5); color:white; display:flex; align-items:center; justify-content:center; font-size:28px; font-weight:800; flex-shrink:0; }
.avatar-preview img { width:100%; height:100%; object-fit:cover; display:block; }
.avatar-hint { font-size:11px; color:var(--txt2); line-height:1.5; }

/* Buttons */
.btn-primary { background:var(--blue); color:white; border:none; border-radius:10px; padding:10px 20px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .15s; }
.btn-primary:hover { background:#1d4ed8; }
.btn-primary:disabled { opacity:.6; cursor:not-allowed; }
.btn-cancel { background:#f3f4f6; color:var(--txt); border:none; border-radius:10px; padding:10px 16px; font-size:13px; font-weight:700; cursor:pointer; font-family:inherit; }
.btn-cancel:hover { background:#e5e7eb; }

/* TOASTS */
.toasts { position:fixed; bottom:20px; right:20px; z-index:9999; display:flex; flex-direction:column; gap:8px; }
.toast { display:flex; align-items:center; gap:10px; padding:12px 16px; background:white; border-radius:12px; box-shadow:var(--shadow-md); border:1px solid var(--border); min-width:260px; animation:tIn .25s ease; }
@keyframes tIn { from{opacity:0;transform:translateX(30px)} to{opacity:1;transform:none} }
.toast.hide { opacity:0; transform:translateX(30px); transition:all .25s; }
.t-ic { width:32px; height:32px; border-radius:9px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:14px; }
.t-ic.s { background:var(--green-bg); color:var(--green); }
.t-ic.e { background:var(--red-bg); color:var(--red); }
.t-ttl { font-size:12.5px; font-weight:700; }
.t-msg { font-size:11px; color:var(--txt2); }

@media(max-width:960px) {
    .grid2 { grid-template-columns:1fr; }
    .stats-row { grid-template-columns:repeat(2,1fr); }
    .metode-grid { grid-template-columns:1fr; }
    .brochure-grid { grid-template-columns:1fr; }
}
@media(max-width:640px) {
    .sb { display:none; }
    .main { margin-left:0; }
    .page { padding:16px; }
    .stats-row { grid-template-columns:repeat(2,1fr); }
}
</style>

<div class="toasts" id="toasts"></div>

<div class="app">


    <div class="main">

        {{-- TOPBAR --}}
        <header class="topbar">
            <div>
                <div class="top-title">Dashboard Siswa</div>
                <div class="top-sub">{{ date('d M Y') }}</div>
            </div>
            <div class="user-chip">
                <div class="chip-av">
                    @if(!empty(Auth::user()->avatar_path))
                        <img src="{{ asset('storage/' . Auth::user()->avatar_path) }}" alt="Avatar">
                    @else
                        {{ substr(Auth::user()->name, 0, 1) }}
                    @endif
                </div>
                <span>{{ Auth::user()->name }}</span>
            </div>
        </header>

        <div class="page">

            {{-- PHP DATA --}}
            @php
                $payments            = $payments ?? collect();
                $lunas               = $payments->whereIn('status', ['approved','paid'])->count();
                $pending             = $payments->where('status','pending')->count();
                $belumBayar          = $payments->where('status','unpaid')->count();
                $totalBayar          = $payments->whereIn('status', ['approved','paid'])->sum('amount');
                $paymentMethodsList  = collect($paymentMethods ?? []);
                $paymentProgress     = max(0, min(100, (float)($paymentPercentage ?? 0)));
                $totalTagihan        = $payments->sum('amount');
                $totalPendingAmount  = $payments->where('status','pending')->sum('amount');
                $totalBelumAmount    = $payments->where('status','unpaid')->sum('amount');
                $latestPayment       = $payments->last();
            @endphp

            <div class="dm-progress-source" data-progress="{{ (float)$paymentProgress }}" data-progress-label="Progress Bayar" style="display:none;"></div>

            {{-- BANNER --}}
            <div class="banner">
                <div style="position:relative;z-index:1;">
                    <div class="bn-tag"><i class="fas fa-graduation-cap"></i> SMK Travina Prima</div>
                    <div class="bn-title">Halo, {{ explode(' ', Auth::user()->name)[0] }}! 👋</div>
                    <div class="bn-sub">Pantau pembayaran SPP dan aktivitas sekolahmu di sini.</div>
                </div>
                @if(isset($student) && $student->class_id)
                    <div class="bn-badge"><i class="fas fa-chalkboard"></i> Kelas {{ $student->class_id }}</div>
                @endif
            </div>

            {{-- BROCHURE GRID --}}
            <div class="brochure-grid">
                <section class="brochure-card brochure-hero reveal">
                    <div class="brochure-kicker"><i class="fas fa-file-lines"></i> Brosur Pembayaran</div>
                    <div class="brochure-title">Semua informasi pembayaran dijelaskan lebih rapi di sini.</div>
                    <div class="brochure-sub">Bagian ini merangkum rincian pembayaran SPP, status tagihan, metode pembayaran aktif, dan gambaran alur konfirmasi supaya kamu tidak perlu menebak-nebak lagi.</div>
                    <div class="brochure-pills">
                        <div class="brochure-pill"><i class="fas fa-circle-check"></i> {{ $lunas }} tagihan lunas</div>
                        <div class="brochure-pill"><i class="fas fa-clock"></i> {{ $pending }} menunggu verifikasi</div>
                        <div class="brochure-pill"><i class="fas fa-wallet"></i> {{ $paymentMethodsList->count() }} metode aktif</div>
                    </div>
                </section>

                <section class="brochure-card reveal">
                    <div class="overview-head" style="margin-bottom:4px;">
                        <div>
                            <div class="overview-title">Rincian Pembayaran</div>
                            <div class="overview-sub">Ringkasan progres dan nominal yang sudah masuk</div>
                        </div>
                        <span class="badge badge-blue">{{ number_format($paymentProgress, 0) }}%</span>
                    </div>
                    <div class="progress-wrap">
                        <div class="progress-track">
                            <div class="progress-bar" style="width:{{ $paymentProgress }}%;"></div>
                        </div>
                        <div class="progress-meta">
                            <span>Lunas berdasarkan status pembayaran</span>
                            <span>{{ number_format($paymentProgress, 1) }}%</span>
                        </div>
                    </div>
                    <div class="summary-list">
                        <div class="summary-row">
                            <div class="summary-label">Total tagihan di riwayat</div>
                            <div class="summary-value">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</div>
                        </div>
                        <div class="summary-row">
                            <div class="summary-label">Nominal terbayar</div>
                            <div class="summary-value" style="color:var(--green);">Rp {{ number_format($totalBayar, 0, ',', '.') }}</div>
                        </div>
                        <div class="summary-row">
                            <div class="summary-label">Menunggu verifikasi</div>
                            <div class="summary-value" style="color:var(--amber);">Rp {{ number_format($totalPendingAmount, 0, ',', '.') }}</div>
                        </div>
                        <div class="summary-row">
                            <div class="summary-label">Belum dibayar</div>
                            <div class="summary-value" style="color:var(--red);">Rp {{ number_format($totalBelumAmount, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </section>
            </div>

            {{-- PENJELASAN SINGKAT (single card, full width) --}}
            <div class="overview-card reveal">
                <div class="overview-head">
                    <div>
                        <div class="overview-title">Penjelasan Singkat Pembayaran</div>
                        <div class="overview-sub">Supaya jelas, ini arti setiap status di dashboard</div>
                    </div>
                    <span class="badge badge-green">Lengkap</span>
                </div>
                <div class="detail-grid" style="grid-template-columns:repeat(3,1fr);">
                    <div class="detail-item">
                        <div class="detail-dot"></div>
                        <div>
                            <strong>SPP Lunas</strong>
                            <span>Tagihan berstatus <em>paid</em> atau <em>approved</em> — sudah masuk dan diverifikasi.</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-dot" style="background:var(--amber);box-shadow:0 0 0 4px rgba(217,119,6,.12);"></div>
                        <div>
                            <strong>Menunggu Verifikasi</strong>
                            <span>Sudah dikirim ke admin, tetapi masih menunggu pengecekan bukti pembayaran.</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-dot" style="background:var(--red);box-shadow:0 0 0 4px rgba(220,38,38,.12);"></div>
                        <div>
                            <strong>Belum Bayar</strong>
                            <span>Tagihan masih terbuka dan perlu segera dibayar sesuai periode yang tampil di tabel.</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- STATS ROW --}}
            @if(class_exists(\App\Livewire\PortalDashboard::class))
                <livewire:portal-dashboard :student-id="$student->id ?? 0" />
            @else
                <div class="stats-row">
                    <div class="stat-card">
                        <div class="stat-ic" style="background:var(--green-bg);color:var(--green);"><i class="fas fa-circle-check"></i></div>
                        <div><div class="stat-val">{{ $lunas }}</div><div class="stat-lbl">SPP Lunas</div></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-ic" style="background:var(--amber-bg);color:var(--amber);"><i class="fas fa-clock"></i></div>
                        <div><div class="stat-val">{{ $pending }}</div><div class="stat-lbl">Menunggu Verif</div></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-ic" style="background:var(--red-bg);color:var(--red);"><i class="fas fa-circle-xmark"></i></div>
                        <div><div class="stat-val">{{ $belumBayar }}</div><div class="stat-lbl">Belum Bayar</div></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-ic" style="background:var(--blue-bg);color:var(--blue);"><i class="fas fa-coins"></i></div>
                        <div>
                            <div class="stat-val" style="font-size:14px;">Rp {{ number_format($totalBayar, 0, ',', '.') }}</div>
                            <div class="stat-lbl">Total Terbayar</div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- MAIN GRID: Kiri = Pengumuman + Tabel | Kanan = Profil --}}
            <div class="grid2">

                {{-- KOLOM KIRI --}}
                <div class="stack-col">

                    {{-- PENGUMUMAN --}}
                    <div class="card" id="pengumumanSection">
                        <div class="card-head">
                            <div>
                                <div class="card-ttl"><i class="fas fa-bullhorn" style="color:var(--amber);margin-right:6px;"></i> Pengumuman</div>
                                <div class="card-sub">Info terbaru dari sekolah</div>
                            </div>
                        </div>
                        <div style="padding:16px 20px;">
                            @php $announcementItems = $announcements ?? collect(); @endphp
                            @forelse($announcementItems as $ann)
                                <div style="padding-bottom:12px;border-bottom:1px solid var(--border);margin-bottom:12px;">
                                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:4px;">
                                        <div style="font-size:13px;font-weight:800;color:var(--txt);">{{ $ann->title }}</div>
                                        <span class="badge badge-blue" style="font-size:9px;padding:2px 6px;">{{ ucfirst($ann->type ?? 'Info') }}</span>
                                    </div>
                                    <div style="font-size:12px;color:var(--txt2);line-height:1.5;margin-bottom:6px;">
                                        {{ Str::limit(strip_tags($ann->body), 280) }}
                                    </div>
                                    <div style="font-size:10px;color:var(--txt3);">
                                        @php
                                            $announcerName = $ann->user?->name ?? 'Kepala Sekolah';
                                            $rawRole = $ann->user?->role ?? null;
                                            $roleLabel = match($rawRole) {
                                                'kepala_sekolah' => 'Kepala Sekolah',
                                                'admin'          => 'Admin',
                                                'guru', 'teacher'=> 'Guru',
                                                'siswa'          => 'Siswa',
                                                default          => $rawRole ? ucfirst($rawRole) : null,
                                            };
                                        @endphp
                                        <i class="fas fa-clock"></i> {{ $ann->created_at?->diffForHumans() ?? '-' }}
                                        &nbsp;·&nbsp;
                                        <i class="fas fa-user"></i> {{ $announcerName }}
                                        @if($roleLabel) <span style="font-weight:600;"> &mdash; {{ $roleLabel }}</span> @endif
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state" style="padding:20px 10px;">
                                    <i class="fas fa-bullhorn" style="font-size:24px;"></i>
                                    <p style="font-size:12px;">Belum ada pengumuman.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- TABEL PEMBAYARAN SPP --}}
                    <div class="card" id="pembayaranSection">
                        <div class="card-head">
                            <div>
                                <div class="card-ttl">Riwayat Pembayaran SPP</div>
                                <div class="card-sub">Semua tagihan dan status pembayaran</div>
                            </div>
                        </div>
                        @if($payments->isEmpty())
                            <div class="empty-state">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <p>Belum ada data pembayaran.</p>
                            </div>
                        @else
                            <div style="overflow-x:auto;">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Periode</th>
                                            <th>Nominal</th>
                                            <th>Metode</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($payments as $p)
                                            <tr>
                                                <td style="font-weight:700;">{{ $p->month }} {{ $p->year }}</td>
                                                <td style="font-family:monospace;font-weight:700;">Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                                                <td style="color:var(--txt2);font-size:12px;">{{ $p->payment_method ?? '-' }}</td>
                                                <td>
                                                    @php $st = strtolower($p->status); @endphp
                                                    @if(in_array($st, ['approved','paid']))
                                                        <span class="badge badge-green"><i class="fas fa-check-circle"></i> Lunas</span>
                                                    @elseif($st === 'pending')
                                                        <span class="badge badge-blue"><i class="fas fa-hourglass-half"></i> Pending</span>
                                                    @else
                                                        <span class="badge badge-amber"><i class="fas fa-clock"></i> Belum Bayar</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(in_array($p->status, ['unpaid','pending']))
                                                        <button type="button" class="btn-bayar"
                                                            data-id="{{ $p->id }}"
                                                            data-jenis="{{ $p->jenis_tagihan ?? $p->type }}"
                                                            data-keterangan="{{ $p->keterangan ?? '' }}"
                                                            data-amount="{{ $p->amount }}"
                                                            data-bulan="{{ $p->month }} {{ $p->year }}"
                                                            onclick="openBayar(this)">
                                                            <i class="fas fa-credit-card"></i> Bayar
                                                        </button>
                                                        <button type="button" class="btn-bukti"
                                                            data-id="{{ $p->id }}"
                                                            data-jenis="{{ $p->jenis_tagihan ?? $p->type }}"
                                                            data-bulan="{{ $p->month }} {{ $p->year }}"
                                                            onclick="openUpload(this)">
                                                            <i class="fas fa-paperclip"></i> Bukti
                                                        </button>
                                                    @else
                                                        <span style="color:var(--txt3);font-size:11px;">—</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                </div>{{-- END KOLOM KIRI --}}

                {{-- KOLOM KANAN --}}
                <div class="stack-col">

                    {{-- PROFIL --}}
                    <div class="card">
                        <div class="card-head"><div class="card-ttl">Profil Saya</div></div>
                        <div class="profile-card">
                            <div class="profile-av">
                                @if(Auth::user()->avatar_path)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar_path) }}" alt="Foto profil">
                                @else
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                @endif
                            </div>
                            <div class="profile-name">{{ Auth::user()->name }}</div>
                            <div class="profile-nis">{{ $student->nis ?? '-' }}</div>
                            <div class="divider"></div>
                            <div class="profile-row">
                                <span class="profile-lbl">Kelas</span>
                                <span class="profile-val">{{ $student->class_id ?? '-' }}</span>
                            </div>
                            <div class="profile-row">
                                <span class="profile-lbl">Email</span>
                                <span class="profile-val" style="font-size:11px;">{{ Auth::user()->email }}</span>
                            </div>
                            <div class="profile-row">
                                <span class="profile-lbl">Tahun Ajaran</span>
                                <span class="profile-val">{{ date('Y') }}/{{ date('Y')+1 }}</span>
                            </div>
                            <div style="margin-top:14px;">
                                <button type="button" class="btn-bukti" style="margin-left:0;width:100%;justify-content:center;" onclick="openModal('modalProfil')">
                                    <i class="fas fa-gear"></i> Pengaturan Profil
                                </button>
                            </div>
                        </div>
                    </div>

                </div>{{-- END KOLOM KANAN --}}

            </div>{{-- END GRID2 --}}

        </div>{{-- END PAGE --}}
    </div>{{-- END MAIN --}}
</div>{{-- END APP --}}


{{-- ===== MODAL PROFIL ===== --}}
<div class="modal-overlay" id="modalProfil">
    <div class="modal-box">
        <div class="modal-hd">
            <span class="modal-ttl">Pengaturan Profil</span>
            <button class="modal-close" onclick="closeModal('modalProfil')">✕</button>
        </div>
        <form method="POST" action="{{ route('siswa.profile.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="avatar-preview-wrap">
                    <div class="avatar-preview" id="avatarPreview">
                        @if(Auth::user()->avatar_path)
                            <img src="{{ asset('storage/' . Auth::user()->avatar_path) }}" alt="Preview">
                        @else
                            {{ substr(Auth::user()->name, 0, 1) }}
                        @endif
                    </div>
                    <div>
                        <label class="fm-lbl">Foto Profil</label>
                        <input type="file" name="avatar" id="avatarInput" class="fm-input" accept="image/*">
                        <div class="avatar-hint">Upload foto JPG, PNG, atau WEBP. Maksimal 2MB. Kosongkan kalau tidak ingin mengganti foto.</div>
                    </div>
                </div>

                <label class="fm-lbl">Nama Lengkap</label>
                <input type="text" name="name" class="fm-input" value="{{ old('name', Auth::user()->name) }}" required>

                <label class="fm-lbl">Email</label>
                <input type="email" name="email" class="fm-input" value="{{ old('email', Auth::user()->email) }}" required>

                <div class="divider" style="margin:16px 0;"></div>
                <div style="font-size:11px;color:var(--txt2);margin-bottom:12px;">Kosongkan password baru jika tidak ingin mengganti password.</div>

                <label class="fm-lbl">Password Saat Ini</label>
                <input type="password" name="current_password" class="fm-input" autocomplete="current-password" placeholder="Wajib diisi jika ganti password">

                <label class="fm-lbl">Password Baru</label>
                <input type="password" name="new_password" class="fm-input" autocomplete="new-password" placeholder="Minimal 8 karakter">

                <label class="fm-lbl">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation" class="fm-input" autocomplete="new-password">
            </div>
            <div class="modal-ft">
                <button type="button" class="btn-cancel" onclick="closeModal('modalProfil')">Batal</button>
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL BAYAR ===== --}}
<div class="modal-overlay" id="modalBayar">
    <div class="modal-box">
        <div class="modal-hd">
            <span class="modal-ttl">💳 Konfirmasi Pembayaran</span>
            <button class="modal-close" onclick="closeModal('modalBayar')">✕</button>
        </div>
        <form id="formBayar">
            @csrf
            <input type="hidden" id="bayar_id" name="payment_id">
            <input type="hidden" id="bayar_metode_val" name="payment_method">
            <div class="modal-body">
                <div class="info-box">
                    <div class="lbl" id="bayar_jenis"></div>
                    <div class="val" id="bayar_nominal"></div>
                    <div class="sub" id="bayar_bulan"></div>
                </div>

                <label class="fm-lbl">Pilih Kategori Pembayaran <span style="color:var(--red);">*</span></label>
                <div class="metode-grid" id="kategoriGrid" style="grid-template-columns:repeat(3,1fr);">
                    <div class="metode-card" data-kategori="tunai"      onclick="pilihKategori(this)"><div class="m-icon">💵</div><div class="m-name">Tunai</div></div>
                    <div class="metode-card" data-kategori="transfer"   onclick="pilihKategori(this)"><div class="m-icon">🏦</div><div class="m-name">Transfer Bank</div></div>
                    <div class="metode-card" data-kategori="va"         onclick="pilihKategori(this)"><div class="m-icon">🔢</div><div class="m-name">Virtual Account</div></div>
                    <div class="metode-card" data-kategori="ewallet"    onclick="pilihKategori(this)"><div class="m-icon">📱</div><div class="m-name">E-Wallet</div></div>
                    <div class="metode-card" data-kategori="qris"       onclick="pilihKategori(this)"><div class="m-icon">📷</div><div class="m-name">QRIS</div></div>
                    <div class="metode-card" data-kategori="minimarket" onclick="pilihKategori(this)"><div class="m-icon">🏪</div><div class="m-name">Minimarket</div></div>
                </div>

                <div id="subMetodeWrap" style="display:none;margin-bottom:16px;">
                    <label class="fm-lbl" id="subMetodeLbl">Pilih Bank</label>
                    <div class="metode-grid" id="subMetodeGrid" style="grid-template-columns:repeat(3,1fr);"></div>
                </div>

                @php
                    $paymentMethodsJson = ($paymentMethods ?? collect())->map(fn($pm) => [
                        'id'        => $pm->id,
                        'name'      => $pm->name,
                        'kode'      => $pm->kode,
                        'atas_nama' => $pm->atas_nama ?: 'SMK TRAVINA PRIMA',
                        'bank'      => $pm->bank,
                        'qr'        => $pm->qr_image ? asset($pm->qr_image) : '',
                    ])->values();
                @endphp
                <script>
                var allMethods = @json($paymentMethodsJson);
                var schoolName = 'SMK TRAVINA PRIMA';
                var defaultQrisImage = '{{ asset('images/qr/qr.jpeg') }}';

                function normalizeText(v) { return (v||'').toString().trim().toLowerCase(); }
                function includesAny(text, words) { return words.some(w => text.indexOf(w) !== -1); }
                function randomDigits(n) { return Array.from({length:n}, () => Math.floor(Math.random()*10)).join(''); }
                function bankPrefix(bank) {
                    var n = normalizeText(bank);
                    if(n.includes('bca')) return 'BCA'; if(n.includes('bni')) return 'BNI';
                    if(n.includes('bri')) return 'BRI'; if(n.includes('mandiri')) return 'MDR';
                    if(n.includes('bsi')) return 'BSI'; if(n.includes('cimb')) return 'CIM';
                    if(n.includes('permata')) return 'PRM'; return 'BK';
                }
                function makeFallbackCode(prefix, bank) {
                    var bc = bank ? bankPrefix(bank) : '';
                    return prefix + (bc ? '-'+bc : '') + randomDigits(prefix==='VA'?12:10);
                }
                function fallbackMethodsByCategory(k) {
                    var banks = ['BCA','BNI','BRI','Mandiri','BSI','CIMB','Permata'];
                    var ewallets = ['OVO','GoPay','DANA','ShopeePay'];
                    var minis = ['Indomaret','Alfamart','Alfamidi'];
                    if(k==='tunai') return [{name:'Tunai',bank:'',kode:'',atas_nama:schoolName,qr:''}];
                    if(k==='qris') return [{name:'QRIS',bank:'QRIS',kode:'',atas_nama:schoolName,qr:defaultQrisImage}];
                    if(k==='transfer') return banks.map(b=>({name:b+' Transfer',bank:b,kode:makeFallbackCode('TRF',b),atas_nama:schoolName,qr:''}));
                    if(k==='va') return banks.map(b=>({name:b+' Virtual Account',bank:b+' VA',kode:makeFallbackCode('VA',b),atas_nama:schoolName,qr:''}));
                    if(k==='ewallet') return ewallets.map(n=>({name:'E-Wallet - '+n,bank:n,kode:makeFallbackCode('EW',n),atas_nama:schoolName,qr:''}));
                    if(k==='minimarket') return minis.map(n=>({name:n,bank:n,kode:makeFallbackCode('MM',n),atas_nama:schoolName,qr:''}));
                    return [];
                }
                function mergeUniqueMethods(a,b) {
                    var seen={};
                    return [...(a||[]),...(b||[])].filter(item=>{
                        var key=normalizeText(item.name||'')+'|'+normalizeText(item.bank||'');
                        if(!key||seen[key]) return false; seen[key]=true; return true;
                    });
                }
                function methodCategory(m) {
                    var text = normalizeText((m?.name||'')+' '+(m?.bank||''));
                    if(includesAny(text,['tunai','cash'])) return 'tunai';
                    if(includesAny(text,['qris'])) return 'qris';
                    if(includesAny(text,['virtual account',' va '])) return 'va';
                    if(includesAny(text,['ovo','gopay','dana','shopeepay','e-wallet','ewallet'])) return 'ewallet';
                    if(includesAny(text,['indomaret','alfamart','minimarket'])) return 'minimarket';
                    return 'transfer';
                }
                function getMethodsByCategory(k) {
                    return mergeUniqueMethods((allMethods||[]).filter(m=>methodCategory(m)===k), fallbackMethodsByCategory(k));
                }
                var ewalletIcons = {OVO:'💜',GoPay:'💚',Dana:'💙',ShopeePay:'🧡'};
                var bankIcons = {BCA:'🔵',BNI:'🟠',BRI:'🔴',Mandiri:'🟡',BSI:'🟢'};
                </script>

                <div class="instruksi-box" id="instruksiBox">
                    <div class="instruksi-title">📋 Instruksi Pembayaran</div>
                    <div id="instruksi_tunai" style="display:none;">
                        <div class="tunai-info"><i class="fas fa-info-circle"></i> Lakukan pembayaran langsung ke <strong>Bendahara Sekolah</strong> dan minta bukti kwitansi. Kemudian konfirmasi pembayaran di bawah.</div>
                    </div>
                    <div id="instruksi_qris" style="display:none;">
                        <div class="step"><div class="step-num">1</div><div class="step-txt">Scan QR Code berikut menggunakan aplikasi apapun yang mendukung QRIS</div></div>
                        <div class="instruksi_qr_preview">
                            <img id="ins_qr_img" src="" alt="QR Code">
                            <div style="font-size:11px;color:var(--txt2);margin-top:8px;">a.n. <span id="ins_qr_nama"></span></div>
                        </div>
                        <div class="step"><div class="step-num">2</div><div class="step-txt">Masukkan nominal tepat <strong id="ins_qr_nominal"></strong></div></div>
                        <div class="step"><div class="step-num">3</div><div class="step-txt">Setelah berhasil, klik <strong>Kirim Konfirmasi</strong></div></div>
                    </div>
                    <div id="instruksi_transfer" style="display:none;">
                        <div class="step"><div class="step-num">1</div><div class="step-txt">Buka aplikasi <strong id="ins_bank"></strong></div></div>
                        <div class="step"><div class="step-num">2</div><div class="step-txt">Transfer ke nomor berikut:</div></div>
                        <div class="kode-box">
                            <div><div class="kode-val" id="ins_kode">-</div><div class="kode-sub">a.n. <span id="ins_atas_nama"></span></div></div>
                            <button type="button" class="btn-copy" onclick="copyKode(this)"><i class="fas fa-copy"></i> Salin</button>
                        </div>
                        <div class="step"><div class="step-num">3</div><div class="step-txt">Masukkan nominal tepat <strong id="ins_nominal"></strong></div></div>
                        <div class="step"><div class="step-num">4</div><div class="step-txt">Setelah transfer, klik <strong>Kirim Konfirmasi</strong></div></div>
                    </div>
                    <div id="instruksi_minimarket" style="display:none;">
                        <div class="step"><div class="step-num">1</div><div class="step-txt">Pergi ke <strong id="ins_mini_name"></strong> terdekat</div></div>
                        <div class="step"><div class="step-num">2</div><div class="step-txt">Tunjukkan kode berikut ke kasir:</div></div>
                        <div class="kode-box">
                            <div><div class="kode-val" id="ins_mini_kode">-</div></div>
                            <button type="button" class="btn-copy" onclick="copyMiniKode(this)"><i class="fas fa-copy"></i> Salin</button>
                        </div>
                        <div class="step"><div class="step-num">3</div><div class="step-txt">Bayar sejumlah <strong id="ins_mini_nominal"></strong> dan simpan struk</div></div>
                        <div class="step"><div class="step-num">4</div><div class="step-txt">Klik <strong>Kirim Konfirmasi</strong> dan upload struk</div></div>
                    </div>
                </div>

                <label class="fm-lbl">Catatan <span style="color:var(--txt3);font-weight:400;">(opsional)</span></label>
                <textarea name="catatan" class="fm-ta" rows="2" placeholder="Contoh: Sudah transfer jam 10.00..."></textarea>
            </div>
            <div class="modal-ft">
                <button type="button" class="btn-cancel" onclick="closeModal('modalBayar')">Batal</button>
                <button type="submit" class="btn-primary" id="btnBayar" disabled>Kirim Konfirmasi</button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL UPLOAD ===== --}}
<div class="modal-overlay" id="modalUpload">
    <div class="modal-box">
        <div class="modal-hd">
            <span class="modal-ttl">📎 Upload Bukti Pembayaran</span>
            <button class="modal-close" onclick="closeModal('modalUpload')">✕</button>
        </div>
        <form id="formUpload" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="upload_id" name="payment_id">
            <div class="modal-body">
                <div class="info-box">
                    <div class="lbl" id="upload_jenis"></div>
                    <div class="sub" id="upload_bulan"></div>
                </div>
                <label class="fm-lbl">Metode Pembayaran <span style="color:var(--red);">*</span></label>
                <select name="payment_method" class="fm-sel" required>
                    <option value="">-- Pilih Metode --</option>
                    @forelse($paymentMethods ?? [] as $pm)
                        <option value="{{ data_get($pm,'name','') }}">
                            {{ data_get($pm,'name','') }}{{ data_get($pm,'bank') ? ' ('.data_get($pm,'bank').')' : '' }}
                        </option>
                    @empty
                        <option value="Tunai">Tunai</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="Virtual Account">Virtual Account</option>
                        <option value="E-Wallet - OVO">E-Wallet - OVO</option>
                        <option value="E-Wallet - GoPay">E-Wallet - GoPay</option>
                        <option value="E-Wallet - Dana">E-Wallet - Dana</option>
                    @endforelse
                </select>
                <label class="fm-lbl">File Bukti <span style="color:var(--red);">*</span></label>
                <input type="file" name="proof" class="fm-input" accept="image/jpg,image/jpeg,image/png,application/pdf" required>
                <div style="font-size:11px;color:var(--txt3);margin-top:-10px;margin-bottom:14px;">Format: JPG, PNG, PDF. Maks 5MB.</div>
                <label class="fm-lbl">Catatan <span style="color:var(--txt3);font-weight:400;">(opsional)</span></label>
                <textarea name="catatan" class="fm-ta" rows="2"></textarea>
            </div>
            <div class="modal-ft">
                <button type="button" class="btn-cancel" onclick="closeModal('modalUpload')">Batal</button>
                <button type="submit" class="btn-primary" id="btnUpload">Upload Bukti</button>
            </div>
        </form>
    </div>
</div>

<script>
// MODAL
function openModal(id)  { document.getElementById(id).classList.add('show'); }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', e => { if(e.target===el) el.classList.remove('show'); });
});

// REVEAL
(function() {
    var els = document.querySelectorAll('.reveal');
    if(!els.length) return;
    if('IntersectionObserver' in window) {
        var obs = new IntersectionObserver((entries, o) => {
            entries.forEach(e => { if(e.isIntersecting) { e.target.classList.add('is-visible'); o.unobserve(e.target); } });
        }, {threshold:0.14, rootMargin:'0px 0px -8% 0px'});
        els.forEach(el => obs.observe(el));
    } else {
        els.forEach(el => el.classList.add('is-visible'));
    }
})();

// OPEN BAYAR
var currentAmount = 0;
function openBayar(btn) {
    currentAmount = parseInt(btn.dataset.amount);
    document.getElementById('formBayar').reset();
    document.getElementById('bayar_id').value          = btn.dataset.id;
    document.getElementById('bayar_metode_val').value  = '';
    document.getElementById('bayar_jenis').textContent = btn.dataset.jenis + (btn.dataset.keterangan ? ' – '+btn.dataset.keterangan : '');
    document.getElementById('bayar_nominal').textContent = 'Rp ' + currentAmount.toLocaleString('id-ID');
    document.getElementById('bayar_bulan').textContent = btn.dataset.bulan;
    document.getElementById('btnBayar').disabled       = true;
    document.getElementById('btnBayar').textContent    = 'Kirim Konfirmasi';
    document.getElementById('instruksiBox').classList.remove('show');
    document.querySelectorAll('.metode-card').forEach(c => c.classList.remove('selected'));
    document.getElementById('subMetodeWrap').style.display = 'none';
    document.getElementById('subMetodeGrid').innerHTML = '';
    openModal('modalBayar');
}

function pilihKategori(card) {
    document.querySelectorAll('#kategoriGrid .metode-card').forEach(c => c.classList.remove('selected'));
    card.classList.add('selected');
    var k = card.dataset.kategori;
    document.getElementById('bayar_metode_val').value = '';
    document.getElementById('btnBayar').disabled = true;
    document.getElementById('instruksiBox').classList.remove('show');
    ['instruksi_tunai','instruksi_qris','instruksi_transfer','instruksi_minimarket'].forEach(id => document.getElementById(id).style.display='none');

    if(k==='tunai'||k==='qris') {
        var m = getMethodsByCategory(k)[0];
        if(m) showInstruksi(m);
        document.getElementById('subMetodeWrap').style.display='none';
        return;
    }
    var filtered = getMethodsByCategory(k);
    if(!filtered.length) { document.getElementById('subMetodeWrap').style.display='none'; return; }
    var labels = {transfer:'Pilih Bank Tujuan',va:'Pilih Bank VA',ewallet:'Pilih E-Wallet',minimarket:'Pilih Minimarket'};
    document.getElementById('subMetodeLbl').textContent = labels[k]||'Pilih';
    var grid = document.getElementById('subMetodeGrid');
    grid.innerHTML='';
    filtered.forEach(m => {
        var icon = ewalletIcons[m.bank]||bankIcons[m.bank]||'💳';
        var div = document.createElement('div');
        div.className='metode-card';
        div.innerHTML='<div class="m-icon">'+icon+'</div><div class="m-name">'+(m.bank||m.name)+'</div>';
        div.onclick = () => pilihSubMetode(div,m);
        grid.appendChild(div);
    });
    document.getElementById('subMetodeWrap').style.display='block';
    var first = grid.querySelector('.metode-card');
    if(first) { first.classList.add('selected'); showInstruksi(filtered[0]); }
}

function pilihSubMetode(card, m) {
    document.querySelectorAll('#subMetodeGrid .metode-card').forEach(c => c.classList.remove('selected'));
    card.classList.add('selected');
    showInstruksi(m);
}

function showInstruksi(m) {
    var k = methodCategory(m);
    document.getElementById('bayar_metode_val').value = m.name||'';
    document.getElementById('btnBayar').disabled = false;
    document.getElementById('instruksiBox').classList.add('show');
    ['instruksi_tunai','instruksi_qris','instruksi_transfer','instruksi_minimarket'].forEach(id => document.getElementById(id).style.display='none');
    if(k==='tunai') {
        document.getElementById('instruksi_tunai').style.display='block';
    } else if(k==='qris') {
        document.getElementById('instruksi_qris').style.display='block';
        document.getElementById('ins_qr_img').src = m.qr||defaultQrisImage;
        document.getElementById('ins_qr_nama').textContent = m.atas_nama||schoolName;
        document.getElementById('ins_qr_nominal').textContent = 'Rp '+currentAmount.toLocaleString('id-ID');
    } else if(k==='minimarket') {
        document.getElementById('instruksi_minimarket').style.display='block';
        document.getElementById('ins_mini_name').textContent = m.name||m.bank||'Minimarket';
        document.getElementById('ins_mini_kode').textContent = m.kode||'-';
        document.getElementById('ins_mini_nominal').textContent = 'Rp '+currentAmount.toLocaleString('id-ID');
    } else {
        document.getElementById('instruksi_transfer').style.display='block';
        document.getElementById('ins_bank').textContent = m.bank||m.name;
        document.getElementById('ins_kode').textContent = m.kode||'-';
        document.getElementById('ins_atas_nama').textContent = m.atas_nama||schoolName;
        document.getElementById('ins_nominal').textContent = 'Rp '+currentAmount.toLocaleString('id-ID');
    }
}

function copyToClipboard(text) {
    if(!text||text==='-') return Promise.reject(new Error('empty'));
    if(navigator.clipboard&&window.isSecureContext) return navigator.clipboard.writeText(text);
    return new Promise((res,rej) => {
        var ta = document.createElement('textarea');
        ta.value=text; ta.style.position='fixed'; ta.style.top='-9999px';
        document.body.appendChild(ta); ta.focus(); ta.select();
        var ok = false; try { ok=document.execCommand('copy'); } catch(e){}
        document.body.removeChild(ta);
        ok ? res() : rej(new Error('copy-failed'));
    });
}
function copyKode(btn) {
    var kode = document.getElementById('ins_kode').textContent;
    copyToClipboard(kode).then(()=>toast('s','Disalin!',kode+' berhasil disalin.')).catch(()=>toast('e','Gagal','Kode gagal disalin.'));
}
function copyMiniKode(btn) {
    var kode = document.getElementById('ins_mini_kode').textContent;
    copyToClipboard(kode).then(()=>toast('s','Disalin!',kode+' berhasil disalin.')).catch(()=>toast('e','Gagal','Kode gagal disalin.'));
}

// OPEN UPLOAD
function openUpload(btn) {
    document.getElementById('formUpload').reset();
    document.getElementById('upload_id').value          = btn.dataset.id;
    document.getElementById('upload_jenis').textContent = btn.dataset.jenis;
    document.getElementById('upload_bulan').textContent = btn.dataset.bulan;
    document.getElementById('btnUpload').disabled       = false;
    document.getElementById('btnUpload').textContent    = 'Upload Bukti';
    openModal('modalUpload');
}

// TOAST
function toast(type, title, msg) {
    var el = document.createElement('div');
    el.className='toast';
    el.innerHTML='<div class="t-ic '+type+'"><i class="fas '+(type==='s'?'fa-check':'fa-times')+'"></i></div><div><div class="t-ttl">'+title+'</div><div class="t-msg">'+msg+'</div></div>';
    document.getElementById('toasts').appendChild(el);
    setTimeout(()=>{ el.classList.add('hide'); setTimeout(()=>el.remove(),250); },3500);
}

// SUBMIT BAYAR
document.getElementById('formBayar').addEventListener('submit', function(e) {
    e.preventDefault();
    var method = (document.getElementById('bayar_metode_val').value||'').trim();
    if(!method) { toast('e','Pilih Metode','Silakan pilih metode pembayaran terlebih dahulu.'); return; }
    var btn = document.getElementById('btnBayar');
    btn.disabled=true; btn.textContent='Mengirim...';
    fetch('{{ route("siswa.bayar") }}', {method:'POST',body:new FormData(this),headers:{'X-Requested-With':'XMLHttpRequest'}})
        .then(r=>r.json())
        .then(data=>{
            if(data.success) { closeModal('modalBayar'); toast('s','Berhasil!',data.message); setTimeout(()=>location.reload(),1500); }
            else { toast('e','Gagal',data.message||'Gagal mengirim pembayaran.'); btn.disabled=false; btn.textContent='Kirim Konfirmasi'; }
        })
        .catch(()=>{ toast('e','Error','Terjadi kesalahan. Coba lagi.'); btn.disabled=false; btn.textContent='Kirim Konfirmasi'; });
});

// SUBMIT UPLOAD
document.getElementById('formUpload').addEventListener('submit', function(e) {
    e.preventDefault();
    var btn = document.getElementById('btnUpload');
    btn.disabled=true; btn.textContent='Mengupload...';
    fetch('{{ route("siswa.upload-bukti") }}', {method:'POST',body:new FormData(this),headers:{'X-Requested-With':'XMLHttpRequest'}})
        .then(r=>r.json())
        .then(data=>{
            if(data.success) { closeModal('modalUpload'); toast('s','Berhasil!',data.message); setTimeout(()=>location.reload(),1500); }
            else { toast('e','Gagal',data.message||'Gagal upload bukti.'); btn.disabled=false; btn.textContent='Upload Bukti'; }
        })
        .catch(()=>{ toast('e','Error','Terjadi kesalahan. Coba lagi.'); btn.disabled=false; btn.textContent='Upload Bukti'; });
});

// SESSION TOASTS & MODALS
window.addEventListener('load', function() {
    @if(session('success')) toast('s','Berhasil','{{ addslashes(session('success')) }}'); @endif
    @if(session('error'))   toast('e','Error','{{ addslashes(session('error')) }}'); @endif
    @if(session('open_profile_modal') || $errors->any() || request()->query('settings') === 'profil')
        openModal('modalProfil');
    @endif
});

// AVATAR PREVIEW
document.getElementById('avatarInput')?.addEventListener('change', function() {
    var file = this.files?.[0];
    var preview = document.getElementById('avatarPreview');
    if(!preview) return;
    if(!file) { preview.innerHTML='{{ substr(Auth::user()->name, 0, 1) }}'; return; }
    var reader = new FileReader();
    reader.onload = e => preview.innerHTML='<img src="'+e.target.result+'" alt="Preview">';
    reader.readAsDataURL(file);
});
</script>

@include('partials.dashboard-motion')
@endsection