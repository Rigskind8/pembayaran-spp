@extends('layouts.app')

@section('title', 'Nilai UTS & UAS - SMK TRAVINA PRIMA')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --sb: 64px; --sb-open: 220px;
    --bg: #f4f6fa; --card: #ffffff; --border: #e8eaf0;
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

/* ══ SIDEBAR ══ */
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
.sb-dot { margin-left: auto; background: var(--red); color: white; font-size: 9px; font-weight: 800; padding: 2px 5px; border-radius: 99px; opacity: 0; transition: opacity .2s; }
.sb:hover .sb-dot { opacity: 1; }
.sb-foot { width: 100%; padding: 0 10px; margin-top: auto; border-top: 1px solid #1a1d27; padding-top: 14px; }
.sb-user { display: flex; align-items: center; gap: 9px; padding: 9px; border-radius: 10px; background: rgba(255,255,255,.04); margin-bottom: 6px; }
.sb-av { width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0; background: var(--blue); color: white; font-weight: 800; font-size: 14px; display: flex; align-items: center; justify-content: center; }
.sb-uname { font-size: 12px; font-weight: 700; color: #f1f5f9; }
.sb-urole { font-size: 10px; color: #6b7280; }
.sb-out { display: flex; align-items: center; gap: 10px; padding: 9px; border-radius: 10px; background: transparent; border: none; color: #ef4444; font-size: 12px; font-weight: 600; cursor: pointer; width: 100%; font-family: inherit; white-space: nowrap; transition: background .15s; }
.sb-out:hover { background: rgba(239,68,68,.1); }
.sb-out .ic { width: 34px; height: 34px; border-radius: 9px; background: rgba(239,68,68,.08); display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0; }

/* ══ TOPBAR ══ */
.topbar { display: flex; align-items: center; justify-content: space-between; padding: 14px 28px; background: rgba(244,246,250,.95); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; }
.top-title { font-size: 18px; font-weight: 800; color: var(--txt); letter-spacing: -.3px; }
.top-sub { font-size: 12px; color: var(--txt2); margin-top: 1px; }
.top-r { display: flex; align-items: center; gap: 8px; }
.chip { display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; border-radius: 99px; border: 1px solid var(--border); background: var(--card); font-size: 11px; font-weight: 600; color: var(--txt2); }
.chip i { font-size: 10px; color: var(--blue); }

/* ══ PAGE ══ */
.page { padding: 28px; flex: 1; }

/* ══ PAGE HEADER ══ */
.pg-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; gap: 16px; flex-wrap: wrap; }
.pg-title { font-size: 22px; font-weight: 800; color: var(--txt); letter-spacing: -.4px; }
.pg-sub { font-size: 13px; color: var(--txt2); margin-top: 2px; }

/* ══ FILTER BAR ══ */
.filter-bar { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); padding: 16px 20px; display: flex; align-items: center; gap: 12px; margin-bottom: 24px; flex-wrap: wrap; box-shadow: var(--shadow); }
.filter-bar label { font-size: 12px; font-weight: 700; color: var(--txt2); }
.filter-bar select { border: 1px solid var(--border); border-radius: 8px; padding: 7px 12px; font-size: 13px; font-weight: 600; color: var(--txt); background: var(--bg); font-family: inherit; outline: none; cursor: pointer; }
.filter-bar select:focus { border-color: var(--blue); }
.btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 9px; font-size: 13px; font-weight: 700; cursor: pointer; border: none; font-family: inherit; transition: all .15s; text-decoration: none; }
.btn-blue { background: var(--blue); color: white; }
.btn-blue:hover { background: #1d4ed8; }
.btn-outline { background: white; color: var(--txt2); border: 1px solid var(--border); }
.btn-outline:hover { border-color: var(--blue); color: var(--blue); }

/* ══ STATS ROW ══ */
.stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
.stat-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); padding: 18px 20px; box-shadow: var(--shadow); display: flex; align-items: center; gap: 14px; }
.stat-ic { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
.stat-val { font-size: 22px; font-weight: 800; color: var(--txt); line-height: 1; }
.stat-lbl { font-size: 11px; color: var(--txt2); margin-top: 3px; font-weight: 600; }

/* ══ NILAI GRID ══ */
.nilai-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.nilai-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); box-shadow: var(--shadow); overflow: hidden; }
.nc-head { padding: 18px 22px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; }
.nc-ic { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }
.nc-title { font-size: 15px; font-weight: 800; color: var(--txt); }
.nc-sub { font-size: 11px; color: var(--txt2); margin-top: 1px; }
.nc-table { width: 100%; border-collapse: collapse; }
.nc-table th { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--txt3); padding: 10px 22px; text-align: left; background: #fafafa; border-bottom: 1px solid var(--border); }
.nc-table td { padding: 11px 22px; font-size: 13px; color: var(--txt); border-bottom: 1px solid #f5f5f7; }
.nc-table tr:last-child td { border-bottom: none; }
.nc-table tr:hover td { background: #fafbff; }
.badge-nilai { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 99px; font-size: 12px; font-weight: 800; }
.badge-a { background: var(--green-bg); color: var(--green); }
.badge-b { background: var(--blue-bg); color: var(--blue); }
.badge-c { background: var(--amber-bg); color: var(--amber); }
.badge-d { background: var(--red-bg); color: var(--red); }
.empty-state { padding: 40px 20px; text-align: center; color: var(--txt3); }
.empty-state i { font-size: 36px; margin-bottom: 10px; display: block; }
.empty-state p { font-size: 13px; }

/* ══ TOAST ══ */
.toasts { position: fixed; bottom: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 8px; }
.toast { display: flex; align-items: center; gap: 10px; padding: 12px 16px; background: white; border-radius: 12px; box-shadow: var(--shadow-md); border: 1px solid var(--border); min-width: 260px; animation: tIn .25s ease; }
@keyframes tIn { from{opacity:0;transform:translateX(30px)} to{opacity:1;transform:none} }
.toast.hide { opacity: 0; transform: translateX(30px); transition: all .25s; }
.t-ic { width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 14px; }
.t-ic.s { background: var(--green-bg); color: var(--green); }
.t-ttl { font-size: 12.5px; font-weight: 700; color: var(--txt); }
.t-msg { font-size: 11px; color: var(--txt2); }

@media(max-width:900px) { .nilai-grid{grid-template-columns:1fr;} .stats-row{grid-template-columns:repeat(2,1fr);} }
@media(max-width:640px) { .sb{display:none;} .main{margin-left:0;} .page{padding:16px;} }
</style>

<div class="toasts" id="toasts"></div>

<div class="app">
    {{-- SIDEBAR --}}
    @include('partials.sidebar')

    {{-- MAIN --}}
    <div class="main">
        <header class="topbar">
            <div>
                <div class="top-title">Nilai UTS & UAS</div>
                <div class="top-sub">Portal Siswa · {{ date('d M Y') }}</div>
            </div>
            <div class="top-r">
                <div class="chip"><i class="fas fa-id-card"></i> {{ $student->nis }}</div>
            </div>
        </header>

        <div class="page">

            {{-- FILTER --}}
            <form method="GET" action="{{ route('nilai.student') }}">
                <div class="filter-bar">
                    <i class="fas fa-filter" style="color:var(--txt3);font-size:13px;"></i>
                    <label>Semester</label>
                    <select name="semester">
                        <option value="1" {{ $semester == 1 ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                        <option value="2" {{ $semester == 2 ? 'selected' : '' }}>Semester 2 (Genap)</option>
                    </select>
                    <label>Tahun</label>
                    <select name="tahun">
                        @foreach($tahunList as $t)
                            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                        @if($tahunList->isEmpty())
                            <option value="{{ date('Y') }}" selected>{{ date('Y') }}</option>
                        @endif
                    </select>
                    <button type="submit" class="btn btn-blue"><i class="fas fa-search"></i> Tampilkan</button>
                    <a href="{{ route('nilai.exportPdf', ['semester' => $semester, 'tahun' => $tahun]) }}" class="btn btn-blue">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>
            </form>

            {{-- STATS --}}
            @php
                $allNilai = $nilaiUTS->merge($nilaiUAS);
                $avg = $allNilai->avg('nilai') ?? 0;
                $highest = $allNilai->max('nilai') ?? 0;
                $lowest  = $allNilai->min('nilai') ?? 0;
                $total   = $allNilai->count();
            @endphp
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-ic" style="background:var(--blue-bg);color:var(--blue);"><i class="fas fa-chart-line"></i></div>
                    <div>
                        <div class="stat-val">{{ number_format($avg, 1) }}</div>
                        <div class="stat-lbl">Rata-rata Nilai</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ic" style="background:var(--green-bg);color:var(--green);"><i class="fas fa-arrow-up"></i></div>
                    <div>
                        <div class="stat-val">{{ number_format($highest, 1) }}</div>
                        <div class="stat-lbl">Nilai Tertinggi</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ic" style="background:var(--red-bg);color:var(--red);"><i class="fas fa-arrow-down"></i></div>
                    <div>
                        <div class="stat-val">{{ number_format($lowest, 1) }}</div>
                        <div class="stat-lbl">Nilai Terendah</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ic" style="background:var(--purple-bg);color:var(--purple);"><i class="fas fa-book"></i></div>
                    <div>
                        <div class="stat-val">{{ $total }}</div>
                        <div class="stat-lbl">Total Mata Pelajaran</div>
                    </div>
                </div>
            </div>

            {{-- NILAI TABLES --}}
            <div class="nilai-grid">

                {{-- UTS --}}
                <div class="nilai-card">
                    <div class="nc-head">
                        <div class="nc-ic" style="background:var(--purple-bg);color:var(--purple);"><i class="fas fa-file-pen"></i></div>
                        <div>
                            <div class="nc-title">Nilai UTS</div>
                            <div class="nc-sub">Ujian Tengah Semester · Sem {{ $semester }} / {{ $tahun }}</div>
                        </div>
                    </div>
                    @if($nilaiUTS->count() > 0)
                    <table class="nc-table">
                        <thead>
                            <tr>
                                <th>Mata Pelajaran</th>
                                <th>Nilai</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nilaiUTS as $n)
                            @php
                                $v = $n->nilai;
                                $grade = $v >= 90 ? 'A' : ($v >= 80 ? 'B' : ($v >= 70 ? 'C' : 'D'));
                                $cls   = $v >= 90 ? 'badge-a' : ($v >= 80 ? 'badge-b' : ($v >= 70 ? 'badge-c' : 'badge-d'));
                            @endphp
                            <tr>
                                <td>{{ $n->subject->name ?? '-' }}</td>
                                <td><strong>{{ number_format($v, 1) }}</strong></td>
                                <td><span class="badge-nilai {{ $cls }}">{{ $grade }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>Belum ada nilai UTS<br>untuk semester ini.</p>
                    </div>
                    @endif
                </div>

                {{-- UAS --}}
                <div class="nilai-card">
                    <div class="nc-head">
                        <div class="nc-ic" style="background:var(--cyan-bg);color:var(--cyan);"><i class="fas fa-graduation-cap"></i></div>
                        <div>
                            <div class="nc-title">Nilai UAS</div>
                            <div class="nc-sub">Ujian Akhir Semester · Sem {{ $semester }} / {{ $tahun }}</div>
                        </div>
                    </div>
                    @if($nilaiUAS->count() > 0)
                    <table class="nc-table">
                        <thead>
                            <tr>
                                <th>Mata Pelajaran</th>
                                <th>Nilai</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nilaiUAS as $n)
                            @php
                                $v = $n->nilai;
                                $grade = $v >= 90 ? 'A' : ($v >= 80 ? 'B' : ($v >= 70 ? 'C' : 'D'));
                                $cls   = $v >= 90 ? 'badge-a' : ($v >= 80 ? 'badge-b' : ($v >= 70 ? 'badge-c' : 'badge-d'));
                            @endphp
                            <tr>
                                <td>{{ $n->subject->name ?? '-' }}</td>
                                <td><strong>{{ number_format($v, 1) }}</strong></td>
                                <td><span class="badge-nilai {{ $cls }}">{{ $grade }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>Belum ada nilai UAS<br>untuk semester ini.</p>
                    </div>
                    @endif
                </div>

            </div>{{-- /nilai-grid --}}
        </div>{{-- /page --}}
    </div>{{-- /main --}}
</div>

<script>
function toast(type,title,msg){
    const ic={s:'fa-check',e:'fa-times'};
    const el=document.createElement('div');
    el.className='toast';
    el.innerHTML=`<div class="t-ic ${type}"><i class="fas ${ic[type]}"></i></div><div><div class="t-ttl">${title}</div><div class="t-msg">${msg}</div></div>`;
    document.getElementById('toasts').appendChild(el);
    setTimeout(()=>{el.classList.add('hide');setTimeout(()=>el.remove(),250);},3200);
}
@if(session('success')) window.addEventListener('load',()=>toast('s','Berhasil','{{ session('success') }}')); @endif
@if(session('error'))   window.addEventListener('load',()=>toast('e','Error','{{ session('error') }}')); @endif
</script>
@endsection
