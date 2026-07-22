@extends('layouts.app')

@section('title', 'Tambah Pembayaran - SMK TRAVINA PRIMA')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;1,9..40,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --sw: 60px; --sw-open: 220px;
    --bg: #f2f4f8;
    --card: #ffffff;
    --border: #e6e9f0;
    --txt: #0d1321;
    --txt2: #5a6274;
    --txt3: #9099ab;
    --blue: #2463eb;
    --blue-lt: #eff4ff;
    --blue-md: #c7d9fd;
    --green: #0a9060;
    --green-lt: #edfaf4;
    --green-md: #a3e6cb;
    --red: #d42b2b;
    --red-lt: #fff0f0;
    --red-md: #ffc4c4;
    --amber: #c97a00;
    --amber-lt: #fff8ed;
    --amber-md: #fddca0;
    --purple: #6d36e0;
    --sb-bg: #0d1117;
    --sb-border: #1e2330;
    --r: 14px; --r-lg: 18px;
    --sh: 0 1px 2px rgba(0,0,0,.04), 0 2px 8px rgba(0,0,0,.04);
    --sh-md: 0 4px 20px rgba(0,0,0,.08);
    --sh-lg: 0 12px 40px rgba(0,0,0,.13);
}

body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--txt); -webkit-font-smoothing: antialiased; }
.app  { display: flex; min-height: 100vh; }
.main { margin-left: var(--sw); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

/* ══ SIDEBAR ══ */
.sb { width: var(--sw); background: var(--sb-bg); position: fixed; top: 0; left: 0; height: 100vh; z-index: 300; display: flex; flex-direction: column; align-items: center; padding: 16px 0 20px; transition: width .25s cubic-bezier(.4,0,.2,1); overflow: hidden; border-right: 1px solid var(--sb-border); }
.sb:hover { width: var(--sw-open); align-items: flex-start; }
.sb-brand { display: flex; align-items: center; gap: 10px; padding: 4px 13px; width: 100%; min-height: 42px; margin-bottom: 22px; }
.sb-mark  { width: 30px; height: 30px; border-radius: 8px; flex-shrink: 0; background: var(--blue); display: flex; align-items: center; justify-content: center; color: white; font-size: 13px; }
.sb-name-text { font-size: 13px; font-weight: 700; color: white; white-space: nowrap; opacity: 0; transition: opacity .18s; }
.sb:hover .sb-name-text { opacity: 1; }
.sb-nav { width: 100%; padding: 0 9px; flex: 1; display: flex; flex-direction: column; gap: 1px; overflow-y: auto; overflow-x: hidden; }
.sb-nav::-webkit-scrollbar { display: none; }
.sb-grp { font-size: 8px; font-weight: 700; letter-spacing: .16em; color: #3d4556; text-transform: uppercase; padding: 14px 9px 4px; white-space: nowrap; opacity: 0; transition: opacity .15s; }
.sb:hover .sb-grp { opacity: 1; }
.sb-a { display: flex; align-items: center; gap: 9px; padding: 7px 9px; border-radius: 9px; color: #5e697a; font-size: 12.5px; font-weight: 500; text-decoration: none; white-space: nowrap; transition: all .14s; position: relative; }
.sb-a .ic { width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 12px; color: #4b5163; transition: all .14s; }
.sb-a:hover { color: #c8cdd8; }
.sb-a:hover .ic { background: #1c2130; color: #8b95a8; }
.sb-a.on { color: white; }
.sb-a.on .ic { background: var(--blue); color: white; box-shadow: 0 3px 10px rgba(36,99,235,.3); }
.sb-a.hl .ic { background: linear-gradient(135deg, var(--blue), var(--purple)); color: white; }
.sb-a.hl { color: #8daef5; }
.sb-lbl { opacity: 0; transition: opacity .15s; pointer-events: none; white-space: nowrap; }
.sb:hover .sb-lbl { opacity: 1; pointer-events: auto; }
.sb-foot { width: 100%; padding: 0 9px; margin-top: auto; border-top: 1px solid var(--sb-border); padding-top: 12px; }
.sb-user { display: flex; align-items: center; gap: 8px; padding: 8px; border-radius: 9px; background: rgba(255,255,255,.04); margin-bottom: 5px; }
.sb-av { width: 30px; height: 30px; border-radius: 8px; flex-shrink: 0; background: var(--blue); color: white; font-weight: 700; font-size: 12px; display: flex; align-items: center; justify-content: center; }
.sb-uname { font-size: 11.5px; font-weight: 700; color: #eef0f4; }
.sb-urole { font-size: 9.5px; color: #5a6477; }
.sb-out { display: flex; align-items: center; gap: 9px; padding: 8px; border-radius: 9px; background: transparent; border: none; color: #e55; font-size: 12px; font-weight: 600; cursor: pointer; width: 100%; font-family: inherit; white-space: nowrap; transition: background .13s; }
.sb-out:hover { background: rgba(220,50,50,.1); }
.sb-out .ic { width: 30px; height: 30px; border-radius: 8px; background: rgba(220,50,50,.08); display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0; }

/* ══ TOPBAR ══ */
.topbar { display: flex; align-items: center; justify-content: space-between; padding: 12px 26px; background: rgba(242,244,248,.94); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; gap: 12px; }
.top-ttl { font-size: 17px; font-weight: 800; color: var(--txt); letter-spacing: -.3px; }
.top-sub { font-size: 11.5px; color: var(--txt2); margin-top: 1px; }
.top-r { display: flex; align-items: center; gap: 7px; }

/* ══ BODY ══ */
.body { padding: 28px 26px; flex: 1; }

/* ══ BREADCRUMB ══ */
.breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 11.5px; color: var(--txt3); margin-bottom: 20px; }
.breadcrumb a { color: var(--txt3); text-decoration: none; transition: color .12s; }
.breadcrumb a:hover { color: var(--blue); }
.breadcrumb i { font-size: 8px; }

/* ══ PAGE HEADER ══ */
.page-hdr { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 24px; gap: 16px; }
.page-hdr-left { display: flex; align-items: center; gap: 14px; }
.page-icon { width: 48px; height: 48px; border-radius: 14px; background: linear-gradient(135deg, var(--blue), var(--purple)); display: flex; align-items: center; justify-content: center; font-size: 20px; color: white; box-shadow: 0 6px 20px rgba(36,99,235,.25); flex-shrink: 0; }
.page-ttl { font-size: 22px; font-weight: 800; color: var(--txt); letter-spacing: -.4px; }
.page-sub { font-size: 12.5px; color: var(--txt2); margin-top: 3px; }

/* ══ FORM LAYOUT ══ */
.form-grid { display: grid; grid-template-columns: 1fr 340px; gap: 20px; align-items: start; }

/* ══ CARD ══ */
.card { background: var(--card); border: 1px solid var(--border); border-radius: var(--r-lg); box-shadow: var(--sh); overflow: hidden; }
.card-head { padding: 18px 22px; border-bottom: 1px solid var(--border); background: #fafbfe; }
.card-head-inner { display: flex; align-items: center; gap: 10px; }
.card-head-ic { width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; }
.card-ttl { font-size: 13.5px; font-weight: 800; color: var(--txt); }
.card-sub { font-size: 11px; color: var(--txt2); margin-top: 1px; }
.card-body { padding: 22px; }

/* ══ FORM ELEMENTS ══ */
.fg { margin-bottom: 18px; }
.fg:last-child { margin-bottom: 0; }
.fg-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 18px; }
.fg-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; margin-bottom: 18px; }
.fl { display: flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 700; color: var(--txt); margin-bottom: 6px; }
.fl .req { color: var(--red); font-size: 13px; line-height: 1; }
.fl .hint { font-size: 10px; font-weight: 500; color: var(--txt3); margin-left: auto; }
.fc { width: 100%; padding: 9px 12px; border: 1.5px solid var(--border); border-radius: 9px; font-size: 13px; font-family: inherit; color: var(--txt); background: white; outline: none; transition: all .15s; appearance: none; }
.fc:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(36,99,235,.1); }
.fc.err { border-color: var(--red); box-shadow: 0 0 0 3px rgba(212,43,43,.1); }
.fc-select { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239099ab' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 34px; cursor: pointer; }
.fc-money { padding-left: 44px; font-family: 'DM Mono', monospace; font-size: 13px; letter-spacing: .02em; }
.input-wrap { position: relative; }
.input-prefix { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-size: 12px; font-weight: 700; color: var(--txt3); pointer-events: none; }
.err-msg { font-size: 10.5px; color: var(--red); margin-top: 5px; display: flex; align-items: center; gap: 4px; }

/* ══ JENIS PEMBAYARAN GRID ══ */
.type-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 18px; }
.type-card { border: 2px solid var(--border); border-radius: 10px; padding: 10px 8px; cursor: pointer; transition: all .15s; display: flex; flex-direction: column; align-items: center; gap: 4px; background: white; }
.type-card:hover { border-color: var(--blue); background: var(--blue-lt); }
.type-card.selected { border-color: var(--blue); background: var(--blue-lt); }
.type-card input { display: none; }
.type-emoji { font-size: 20px; }
.type-name { font-size: 11px; font-weight: 700; color: var(--txt); }

/* ══ STUDENT SEARCH ══ */
.stu-search-wrap { position: relative; }
.stu-search-ic { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--txt3); font-size: 11px; pointer-events: none; }
.fc-search { padding-left: 34px; }
.stu-dropdown { position: absolute; top: calc(100% + 6px); left: 0; right: 0; background: white; border: 1.5px solid var(--border); border-radius: 10px; box-shadow: var(--sh-lg); z-index: 50; max-height: 220px; overflow-y: auto; display: none; }
.stu-dropdown.open { display: block; }
.stu-opt { display: flex; align-items: center; gap: 10px; padding: 10px 12px; cursor: pointer; transition: background .1s; border-bottom: 1px solid #f1f3f9; }
.stu-opt:last-child { border-bottom: none; }
.stu-opt:hover, .stu-opt.sel { background: var(--blue-lt); }
.stu-av { width: 30px; height: 30px; border-radius: 7px; background: var(--blue); color: white; font-size: 11px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.stu-opt-name { font-size: 12.5px; font-weight: 700; color: var(--txt); }
.stu-opt-meta { font-size: 10.5px; color: var(--txt2); }
.stu-selected { display: none; align-items: center; gap: 10px; padding: 10px 12px; background: var(--blue-lt); border: 1.5px solid var(--blue-md); border-radius: 9px; }
.stu-selected.show { display: flex; }
.stu-selected-name { font-size: 13px; font-weight: 700; color: var(--blue); flex: 1; }
.stu-selected-meta { font-size: 11px; color: var(--txt2); }
.stu-clear { width: 24px; height: 24px; border-radius: 6px; background: white; border: 1px solid var(--blue-md); color: var(--blue); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 10px; transition: all .12s; flex-shrink: 0; }
.stu-clear:hover { background: var(--red-lt); color: var(--red); border-color: var(--red-md); }

/* ══ NOMINAL PRESETS ══ */
.presets { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 8px; }
.preset-btn { padding: 4px 11px; border-radius: 7px; border: 1.5px solid var(--border); background: white; font-size: 10.5px; font-weight: 700; color: var(--txt2); cursor: pointer; font-family: 'DM Mono', monospace; transition: all .12px; }
.preset-btn:hover { border-color: var(--blue); color: var(--blue); background: var(--blue-lt); }
.preset-btn.on { border-color: var(--blue); color: white; background: var(--blue); }

/* ══ STATUS TOGGLE ══ */
.status-toggle { display: flex; gap: 8px; }
.status-opt { flex: 1; border: 2px solid var(--border); border-radius: 10px; padding: 10px; cursor: pointer; transition: all .15s; display: flex; align-items: center; gap: 8px; background: white; }
.status-opt input { display: none; }
.status-opt:hover { border-color: var(--blue); }
.status-opt.sel-paid { border-color: var(--green); background: var(--green-lt); }
.status-opt.sel-unpaid { border-color: var(--amber); background: var(--amber-lt); }
.status-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.status-lbl { font-size: 12px; font-weight: 700; }

/* ══ SUMMARY CARD ══ */
.summary-card { background: linear-gradient(135deg, #0d1321 0%, #1a2540 100%); border-radius: var(--r-lg); padding: 20px; color: white; margin-bottom: 16px; }
.sum-title { font-size: 10px; font-weight: 700; letter-spacing: .15em; text-transform: uppercase; color: rgba(255,255,255,.45); margin-bottom: 12px; }
.sum-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,.07); }
.sum-row:last-child { border-bottom: none; padding-bottom: 0; }
.sum-lbl { font-size: 11.5px; color: rgba(255,255,255,.55); }
.sum-val { font-size: 12.5px; font-weight: 700; color: white; font-family: 'DM Mono', monospace; }
.sum-total { margin-top: 14px; padding-top: 14px; border-top: 1px solid rgba(255,255,255,.12); display: flex; justify-content: space-between; align-items: center; }
.sum-total-lbl { font-size: 12px; font-weight: 700; color: rgba(255,255,255,.7); }
.sum-total-val { font-size: 20px; font-weight: 800; color: #60a5fa; font-family: 'DM Mono', monospace; letter-spacing: -.5px; }

/* ══ INFO BOX ══ */
.info-box { border-radius: 10px; padding: 12px 14px; display: flex; align-items: flex-start; gap: 10px; margin-bottom: 14px; }
.info-box.blue { background: var(--blue-lt); border: 1px solid var(--blue-md); }
.info-box.amber { background: var(--amber-lt); border: 1px solid var(--amber-md); }
.info-box i { font-size: 13px; flex-shrink: 0; margin-top: 1px; }
.info-box.blue i { color: var(--blue); }
.info-box.amber i { color: var(--amber); }
.info-box p { font-size: 11.5px; font-weight: 600; line-height: 1.5; }
.info-box.blue p { color: var(--blue); }
.info-box.amber p { color: var(--amber); }

/* ══ BUTTONS ══ */
.btn-row { display: flex; gap: 9px; margin-top: 6px; }
.btn-submit { flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 7px; padding: 12px 20px; background: var(--blue); color: white; border: none; border-radius: 10px; font-size: 13.5px; font-weight: 800; cursor: pointer; font-family: inherit; box-shadow: 0 4px 16px rgba(36,99,235,.28); transition: all .15s; letter-spacing: -.1px; }
.btn-submit:hover { background: #1a55d8; transform: translateY(-1px); }
.btn-submit:disabled { background: #a0b4e8; cursor: not-allowed; transform: none; box-shadow: none; }
.btn-cancel-lg { display: inline-flex; align-items: center; justify-content: center; gap: 7px; padding: 12px 18px; background: white; color: var(--txt); border: 1.5px solid var(--border); border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit; text-decoration: none; transition: all .13s; }
.btn-cancel-lg:hover { background: #f6f8fc; color: var(--txt); }

.divider { height: 1px; background: var(--border); margin: 20px 0; }

/* ══ TOASTS ══ */
.toasts { position: fixed; bottom: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 7px; }
.toast { display: flex; align-items: center; gap: 10px; padding: 12px 16px; background: white; border-radius: 12px; box-shadow: var(--sh-lg); border: 1px solid var(--border); min-width: 250px; animation: tIn .25s ease; }
@keyframes tIn { from { opacity:0; transform:translateX(30px); } to { opacity:1; transform:none; } }

@media (max-width: 960px) { .form-grid { grid-template-columns: 1fr; } }
@media (max-width: 640px) { .sb { display: none; } .main { margin-left: 0; } .body { padding: 16px; } .fg-row { grid-template-columns: 1fr; } .type-grid { grid-template-columns: repeat(2, 1fr); } }
</style>

<div class="toasts" id="toasts"></div>

<div class="app">

{{-- ── MAIN ── --}}
<div class="main">

    <header class="topbar">
        <div>
            <div class="top-ttl">Tambah Tagihan</div>
            <div class="top-sub">Buat tagihan SPP, UTS, atau UAS untuk siswa</div>
        </div>
        <div class="top-r">
            <a href="{{ route('payments.index') }}" class="btn-cancel-lg">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </header>

    <div class="body">

        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('payments.index') }}">Pembayaran</a>
            <i class="fas fa-chevron-right"></i>
            <span style="color:var(--txt2);">Tambah Tagihan</span>
        </div>

        <div class="page-hdr">
            <div class="page-hdr-left">
                <div class="page-icon"><i class="fas fa-plus"></i></div>
                <div>
                    <div class="page-ttl">Tambah Tagihan</div>
                    <div class="page-sub">Buat tagihan baru untuk siswa. Status <strong>Belum Bayar</strong> artinya siswa akan upload bukti sendiri.</div>
                </div>
            </div>
        </div>

        @if($errors->any())
        <div class="info-box amber" style="margin-bottom:20px;">
            <i class="fas fa-triangle-exclamation"></i>
            <div>
                <p style="font-weight:800;margin-bottom:4px;">Ada {{ $errors->count() }} kesalahan:</p>
                @foreach($errors->all() as $err)
                <p style="margin-top:2px;">· {{ $err }}</p>
                @endforeach
            </div>
        </div>
        @endif

        <form action="{{ route('payments.store') }}" method="POST" id="payForm">
            @csrf
            <div class="form-grid">

                {{-- KIRI --}}
                <div style="display:flex;flex-direction:column;gap:16px;">

                    {{-- Siswa --}}
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-inner">
                                <div class="card-head-ic" style="background:var(--blue-lt);color:var(--blue);"><i class="fas fa-user-graduate"></i></div>
                                <div>
                                    <div class="card-ttl">Data Siswa</div>
                                    <div class="card-sub">Pilih siswa yang akan ditagih</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="fg">
                                <label class="fl">Nama Siswa <span class="req">*</span></label>
                                <div class="stu-selected" id="stuSelected">
                                    <div class="stu-av" id="stuAv">A</div>
                                    <div style="flex:1;min-width:0;">
                                        <div class="stu-selected-name" id="stuSelName">—</div>
                                        <div class="stu-selected-meta" id="stuSelMeta">—</div>
                                    </div>
                                    <button type="button" class="stu-clear" onclick="clearStudent()"><i class="fas fa-times"></i></button>
                                </div>
                                <div class="stu-search-wrap" id="stuSearchWrap">
                                    <i class="fas fa-search stu-search-ic"></i>
                                    <input type="text" id="stuSearch" class="fc fc-search {{ $errors->has('student_id') ? 'err' : '' }}"
                                        placeholder="Ketik nama siswa..." autocomplete="off">
                                    <div class="stu-dropdown" id="stuDropdown">
                                        @foreach($students as $stu)
                                        <div class="stu-opt"
                                            data-id="{{ $stu['id'] }}"
                                            data-name="{{ $stu['name'] }}"
                                            data-nis="{{ $stu['nis'] }}"
                                            data-class="{{ $stu['class'] }}"
                                            onclick="selectStudent(this)">
                                            <div class="stu-av">{{ substr($stu['name'], 0, 1) }}</div>
                                            <div>
                                                <div class="stu-opt-name">{{ $stu['name'] }}</div>
                                                <div class="stu-opt-meta">{{ $stu['nis'] ?: 'NIS: —' }}{{ $stu['class'] ? ' · '.$stu['class'] : '' }}</div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <input type="hidden" name="student_id" id="studentId" value="{{ old('student_id') }}">
                                @error('student_id')
                                <div class="err-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Jenis Pembayaran --}}
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-inner">
                                <div class="card-head-ic" style="background:#f5f3ff;color:#7c3aed;"><i class="fas fa-tags"></i></div>
                                <div>
                                    <div class="card-ttl">Jenis Pembayaran</div>
                                    <div class="card-sub">Pilih jenis tagihan yang akan dibuat</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <label class="fl">Jenis <span class="req">*</span></label>
                            <div class="type-grid">
                                @php $types = ['SPP' => '📅', 'UTS' => '📝', 'UAS' => '📋', 'Lainnya' => '💰']; @endphp
                                @foreach($types as $type => $emoji)
                                <label class="type-card {{ old('type', 'SPP') === $type ? 'selected' : '' }}" onclick="selectType(this, '{{ $type }}')">
                                    <input type="radio" name="type" value="{{ $type }}" {{ old('type', 'SPP') === $type ? 'checked' : '' }}>
                                    <span class="type-emoji">{{ $emoji }}</span>
                                    <span class="type-name">{{ $type }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('type')
                            <div class="err-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Detail --}}
                    <div class="card">
                        <div class="card-head">
                            <div class="card-head-inner">
                                <div class="card-head-ic" style="background:var(--green-lt);color:var(--green);"><i class="fas fa-receipt"></i></div>
                                <div>
                                    <div class="card-ttl">Detail Tagihan</div>
                                    <div class="card-sub">Periode dan nominal tagihan</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="fg-row">
                                <div>
                                    <label class="fl">Bulan <span class="req">*</span></label>
                                    <select name="month" id="selMonth" class="fc fc-select {{ $errors->has('month') ? 'err' : '' }}">
                                        <option value="">— Pilih Bulan —</option>
                                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bulan)
                                        <option value="{{ $bulan }}" {{ old('month') == $bulan ? 'selected' : '' }}>{{ $bulan }}</option>
                                        @endforeach
                                    </select>
                                    @error('month')<div class="err-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                                </div>
                                <div>
                                    <label class="fl">Tahun <span class="req">*</span></label>
                                    <select name="year" id="selYear" class="fc fc-select {{ $errors->has('year') ? 'err' : '' }}">
                                        <option value="">— Pilih Tahun —</option>
                                        @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                                        <option value="{{ $y }}" {{ old('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endfor
                                    </select>
                                    @error('year')<div class="err-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="fg">
                                <label class="fl">Nominal <span class="req">*</span><span class="hint">Pilih preset atau isi manual</span></label>
                                <div class="input-wrap">
                                    <span class="input-prefix">Rp</span>
                                    <input type="number" name="amount" id="amount"
                                        class="fc fc-money {{ $errors->has('amount') ? 'err' : '' }}"
                                        placeholder="0" value="{{ old('amount') }}" min="0" step="1000">
                                </div>
                                <div class="presets">
                                    <button type="button" class="preset-btn" onclick="setAmount(100000, this)">100rb</button>
                                    <button type="button" class="preset-btn" onclick="setAmount(150000, this)">150rb</button>
                                    <button type="button" class="preset-btn" onclick="setAmount(200000, this)">200rb</button>
                                    <button type="button" class="preset-btn" onclick="setAmount(250000, this)">250rb</button>
                                    <button type="button" class="preset-btn" onclick="setAmount(300000, this)">300rb</button>
                                    <button type="button" class="preset-btn" onclick="setAmount(500000, this)">500rb</button>
                                </div>
                                @error('amount')<div class="err-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                            </div>

                            <div class="divider"></div>

                            {{-- STATUS --}}
                            <div class="fg">
                                <label class="fl">Status Awal <span class="req">*</span></label>
                                <div class="status-toggle">
                                    <label class="status-opt {{ old('status', 'unpaid') === 'unpaid' ? 'sel-unpaid' : '' }}" id="optUnpaid" onclick="selectStatus('unpaid')">
                                        <input type="radio" name="status" value="unpaid" {{ old('status', 'unpaid') === 'unpaid' ? 'checked' : '' }}>
                                        <span class="status-dot" style="background:#d97706;"></span>
                                        <div>
                                            <div class="status-lbl" style="color:#d97706;">Belum Bayar</div>
                                            <div style="font-size:10px;color:var(--txt3);">Siswa upload bukti sendiri</div>
                                        </div>
                                    </label>
                                    <label class="status-opt {{ old('status') === 'paid' ? 'sel-paid' : '' }}" id="optPaid" onclick="selectStatus('paid')">
                                        <input type="radio" name="status" value="paid" {{ old('status') === 'paid' ? 'checked' : '' }}>
                                        <span class="status-dot" style="background:#0a9060;"></span>
                                        <div>
                                            <div class="status-lbl" style="color:#0a9060;">Langsung Lunas</div>
                                            <div style="font-size:10px;color:var(--txt3);">Bayar tunai / sudah dikonfirmasi</div>
                                        </div>
                                    </label>
                                </div>
                                @error('status')<div class="err-msg"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                            </div>

                            <div class="divider"></div>

                            <div class="fg">
                                <label class="fl">Catatan <span class="hint">Opsional</span></label>
                                <textarea name="catatan" class="fc" rows="2"
                                    placeholder="Catatan tambahan (opsional)..."
                                    style="resize:none;">{{ old('catatan') }}</textarea>
                            </div>

                        </div>
                    </div>

                </div>

                {{-- KANAN --}}
                <div>
                    <div class="summary-card" id="summaryCard">
                        <div class="sum-title">Ringkasan Tagihan</div>
                        <div class="sum-row">
                            <span class="sum-lbl">Siswa</span>
                            <span class="sum-val" id="sumSiswa" style="font-family:'DM Sans',sans-serif;font-size:12px;">—</span>
                        </div>
                        <div class="sum-row">
                            <span class="sum-lbl">Jenis</span>
                            <span class="sum-val" id="sumType" style="font-family:'DM Sans',sans-serif;">SPP</span>
                        </div>
                        <div class="sum-row">
                            <span class="sum-lbl">Periode</span>
                            <span class="sum-val" id="sumPeriode">—</span>
                        </div>
                        <div class="sum-row">
                            <span class="sum-lbl">Status</span>
                            <span class="sum-val" id="sumStatus" style="color:#fbbf24;">⏳ Belum Bayar</span>
                        </div>
                        <div class="sum-total">
                            <span class="sum-total-lbl">Total</span>
                            <span class="sum-total-val" id="sumTotal">Rp 0</span>
                        </div>
                    </div>

                    <div class="info-box blue">
                        <i class="fas fa-info-circle"></i>
                        <p>Pilih <strong>"Belum Bayar"</strong> agar siswa bisa upload bukti transfer. Pilih <strong>"Langsung Lunas"</strong> untuk pembayaran tunai.</p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="btn-row">
                                <a href="{{ route('payments.index') }}" class="btn-cancel-lg">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                                <button type="submit" class="btn-submit" id="btnSubmit" disabled>
                                    <i class="fas fa-plus"></i> Buat Tagihan
                                </button>
                            </div>
                            <p style="font-size:10.5px;color:var(--txt3);margin-top:10px;text-align:center;">
                                <i class="fas fa-lock" style="font-size:9px;"></i> Data tersimpan langsung ke database
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
</div>

<script>
const students = {!! json_encode($students) !!};

// ── Siswa search
const stuSearch     = document.getElementById('stuSearch');
const stuDropdown   = document.getElementById('stuDropdown');
const stuSelected   = document.getElementById('stuSelected');
const stuSearchWrap = document.getElementById('stuSearchWrap');

stuSearch.addEventListener('input', function() {
    const q = this.value.toLowerCase().trim();
    document.querySelectorAll('.stu-opt').forEach(opt => {
        const match = opt.dataset.name.toLowerCase().includes(q) || opt.dataset.nis.toLowerCase().includes(q);
        opt.style.display = (!q || match) ? '' : 'none';
    });
    stuDropdown.classList.toggle('open', this.value.length > 0);
});
stuSearch.addEventListener('focus', function() { if (this.value.length > 0) stuDropdown.classList.add('open'); });
document.addEventListener('click', e => { if (!e.target.closest('.stu-search-wrap')) stuDropdown.classList.remove('open'); });

function selectStudent(el) {
    document.getElementById('studentId').value        = el.dataset.id;
    document.getElementById('stuAv').textContent      = el.dataset.name.charAt(0).toUpperCase();
    document.getElementById('stuSelName').textContent = el.dataset.name;
    document.getElementById('stuSelMeta').textContent = [el.dataset.nis, el.dataset.class].filter(Boolean).join(' · ') || '—';
    stuSelected.classList.add('show');
    stuSearchWrap.style.display = 'none';
    stuDropdown.classList.remove('open');
    document.getElementById('sumSiswa').textContent = el.dataset.name;
    updateSubmitBtn();
}
function clearStudent() {
    document.getElementById('studentId').value = '';
    stuSelected.classList.remove('show');
    stuSearchWrap.style.display = '';
    stuSearch.value = '';
    document.getElementById('sumSiswa').textContent = '—';
    updateSubmitBtn();
}

// ── Jenis pembayaran
let selectedType = '{{ old("type", "SPP") }}';
function selectType(card, type) {
    document.querySelectorAll('.type-card').forEach(c => c.classList.remove('selected'));
    card.classList.add('selected');
    selectedType = type;
    document.getElementById('sumType').textContent = type;
    updateSubmitBtn();
}

// ── Status
function selectStatus(val) {
    document.getElementById('optUnpaid').className = 'status-opt' + (val === 'unpaid' ? ' sel-unpaid' : '');
    document.getElementById('optPaid').className   = 'status-opt' + (val === 'paid'   ? ' sel-paid'   : '');
    document.getElementById('sumStatus').textContent = val === 'paid' ? '✓ Langsung Lunas' : '⏳ Belum Bayar';
    document.getElementById('sumStatus').style.color  = val === 'paid' ? '#4ade80' : '#fbbf24';
}

// ── Preset nominal
function setAmount(val, btn) {
    document.getElementById('amount').value = val;
    document.querySelectorAll('.preset-btn').forEach(b => b.classList.remove('on'));
    btn.classList.add('on');
    updateSummary();
}
document.getElementById('amount').addEventListener('input', function() {
    document.querySelectorAll('.preset-btn').forEach(b => b.classList.remove('on'));
    updateSummary();
});

// ── Update summary
function updateSummary() {
    const month  = document.getElementById('selMonth').value;
    const year   = document.getElementById('selYear').value;
    const amount = parseInt(document.getElementById('amount').value) || 0;
    document.getElementById('sumPeriode').textContent = (month && year) ? month + ' ' + year : '—';
    document.getElementById('sumTotal').textContent   = 'Rp ' + amount.toLocaleString('id-ID');
    updateSubmitBtn();
}
['selMonth', 'selYear'].forEach(id => document.getElementById(id).addEventListener('change', updateSummary));

function updateSubmitBtn() {
    const ok = document.getElementById('studentId').value &&
               document.getElementById('selMonth').value &&
               document.getElementById('selYear').value &&
               parseInt(document.getElementById('amount').value) > 0;
    document.getElementById('btnSubmit').disabled = !ok;
}

// ── Restore old values
window.addEventListener('load', function() {
    const oldId = '{{ old("student_id") }}';
    if (oldId) {
        const stu = students.find(s => s.id == oldId);
        if (stu) {
            document.getElementById('studentId').value        = stu.id;
            document.getElementById('stuAv').textContent      = stu.name.charAt(0);
            document.getElementById('stuSelName').textContent = stu.name;
            document.getElementById('stuSelMeta').textContent = [stu.nis, stu.class].filter(Boolean).join(' · ') || '—';
            stuSelected.classList.add('show');
            stuSearchWrap.style.display = 'none';
            document.getElementById('sumSiswa').textContent = stu.name;
        }
    }
    const oldStatus = '{{ old("status", "unpaid") }}';
    selectStatus(oldStatus);
    updateSummary();
});
</script>
@endsection
