@extends('layouts.app')

@section('title', 'Manage Ujian - Travina Prima')

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
.sb-mark { width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0; background: var(--purple); display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; }
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
.sb-a.on .ic { background: var(--purple); color: white; box-shadow: 0 4px 10px rgba(124,58,237,.3); }
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
.topbar { display: flex; align-items: center; justify-content: space-between; padding: 14px 28px; background: rgba(244,246,250,.95); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; }
.top-title { font-size: 18px; font-weight: 800; color: var(--txt); letter-spacing: -.3px; }
.top-sub { font-size: 12px; color: var(--txt2); margin-top: 1px; }

/* PAGE */
.page { padding: 28px; flex: 1; }
.pg-title { font-size: 22px; font-weight: 800; color: var(--txt); }
.pg-sub { font-size: 13px; color: var(--txt2); margin-top: 2px; margin-bottom: 24px; }

/* TABLE CARD */
.table-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); box-shadow: var(--shadow); overflow: hidden; margin-bottom: 24px; }
.tc-head { padding: 18px 22px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
.tc-title { font-size: 15px; font-weight: 800; color: var(--txt); }
table { width: 100%; border-collapse: collapse; }
thead th { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--txt3); padding: 10px 20px; text-align: left; background: #fafafa; border-bottom: 1px solid var(--border); }
tbody td { padding: 12px 20px; font-size: 13px; color: var(--txt); border-bottom: 1px solid #f5f5f7; vertical-align: middle; }
tbody tr:last-child td { border-bottom: none; }
tbody tr:hover td { background: #fafbff; }

/* BADGES */
.badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 99px; font-size: 11px; font-weight: 700; }
.badge-uts { background: var(--blue-bg); color: var(--blue); }
.badge-uas { background: var(--purple-bg); color: var(--purple); }
.badge-pending { background: var(--amber-bg); color: var(--amber); }

/* EMPTY */
.empty-state { padding: 50px 20px; text-align: center; color: var(--txt3); }
.empty-state i { font-size: 40px; margin-bottom: 12px; display: block; }
.empty-state p { font-size: 13px; }
</style>

<div class="app">
    @include('partials.sidebar')

    <div class="main">
        <header class="topbar">
            <div>
                <div class="top-title">Manajemen Ujian</div>
                <div class="top-sub">{{ date('d M Y') }}</div>
            </div>
        </header>

        <div class="page">
            <div class="pg-title">📝 Verifikasi Bukti Ujian</div>
            <div class="pg-sub">Kelola dan verifikasi bukti pendaftaran UTS dan UAS siswa</div>

            {{-- TABLE CARD --}}
            <div class="table-card">
                <div class="tc-head">
                    <div class="tc-title">Daftar Pengajuan Ujian Terbaru</div>
                </div>

                {{-- Karena datanya belum dikirim dari Controller, kita pakai isset() biar aman --}}
                @if(isset($ujians) && $ujians->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Siswa</th>
                            <th>Tipe Ujian</th>
                            <th>Semester</th>
                            <th>Status</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ujians as $i => $u)
                        <tr>
                            <td style="color:var(--txt3);">{{ $i + 1 }}</td>
                            <td><strong>{{ $u->student->name ?? '-' }}</strong></td>
                            <td>
                                <span class="badge badge-{{ strtolower($u->type) }}">
                                    {{ strtoupper($u->type) }}
                                </span>
                            </td>
                            <td>{{ $u->semester }}</td>
                            <td>
                                <span class="badge badge-pending">
                                    <i class="fas fa-clock" style="font-size:10px;"></i> Pending
                                </span>
                            </td>
                            <td>
                                <a href="{{ Storage::url($u->bukti) }}" target="_blank" style="color:var(--blue);text-decoration:none;font-weight:600;">
                                    <i class="fas fa-eye"></i> Lihat File
                                </a>
                            </td>
                            <td>
                                {{-- Tombol aksi bisa disesuaikan nanti --}}
                                <button class="btn btn-blue" style="padding: 6px 12px; font-size: 11px;">Verifikasi</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <p>Belum ada data pengajuan bukti ujian untuk saat ini.</p>
                    <p style="color:var(--txt3); font-size:11px; margin-top:4px;">(Data akan muncul jika controller mengirimkan variabel $ujians)</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
