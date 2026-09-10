@extends('layouts.app')
@section('title', 'Data Siswa - SMK TRAVINA PRIMA')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
:root{--sb:64px;--sb-open:220px;--bg:#f4f6fa;--card:#fff;--border:#e8eaf0;--txt:#111827;--txt2:#6b7280;--txt3:#9ca3af;--green:#059669;--green-bg:#ecfdf5;--red:#dc2626;--red-bg:#fef2f2;--amber:#d97706;--amber-bg:#fffbeb;--blue:#2563eb;--blue-bg:#eff6ff;--orange:#ea580c;--orange-bg:#fff7ed;--sb-bg:#0f1117;--r:16px;--shadow:0 1px 3px rgba(0,0,0,.06),0 2px 8px rgba(0,0,0,.04);}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg);color:var(--txt);-webkit-font-smoothing:antialiased;}
.app{display:flex;min-height:100vh;}
.main{margin-left:var(--sb);flex:1;display:flex;flex-direction:column;}
.sb{width:var(--sb);background:var(--sb-bg);position:fixed;top:0;left:0;height:100vh;z-index:200;display:flex;flex-direction:column;align-items:center;padding:16px 0 20px;transition:width .28s cubic-bezier(.4,0,.2,1);overflow:hidden;border-right:1px solid #1a1d27;}
.sb:hover{width:var(--sb-open);align-items:flex-start;}
.sb-brand{display:flex;align-items:center;gap:10px;padding:4px 14px;width:100%;min-height:44px;margin-bottom:20px;}
.sb-mark{width:32px;height:32px;border-radius:9px;flex-shrink:0;background:var(--blue);display:flex;align-items:center;justify-content:center;color:white;font-size:14px;}
.sb-name{font-size:13px;font-weight:700;color:white;white-space:nowrap;opacity:0;transition:opacity .2s;}
.sb:hover .sb-name{opacity:1;}
.sb-nav{width:100%;padding:0 10px;flex:1;display:flex;flex-direction:column;gap:2px;}
.sb-grp{font-size:9px;font-weight:700;letter-spacing:.14em;color:#374151;text-transform:uppercase;padding:12px 8px 4px;white-space:nowrap;opacity:0;transition:opacity .2s;}
.sb:hover .sb-grp{opacity:1;}
.sb-a{display:flex;align-items:center;gap:10px;padding:8px 9px;border-radius:10px;color:#6b7280;font-size:13px;font-weight:500;text-decoration:none;white-space:nowrap;transition:all .15s;}
.sb-a .ic{width:34px;height:34px;border-radius:9px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:13px;color:#4b5163;transition:all .15s;}
.sb-a:hover{color:#d1d5db;}
.sb-a:hover .ic{background:#1c1f2e;color:#9ca3af;}
.sb-a.on{color:white;}
.sb-a.on .ic{background:var(--orange);color:white;box-shadow:0 4px 10px rgba(234,88,12,.3);}
.sb-lbl{opacity:0;transition:opacity .18s;pointer-events:none;white-space:nowrap;}
.sb:hover .sb-lbl{opacity:1;pointer-events:auto;}
.sb-foot{width:100%;padding:0 10px;margin-top:auto;border-top:1px solid #1a1d27;padding-top:14px;}
.sb-user{display:flex;align-items:center;gap:9px;padding:9px;border-radius:10px;background:rgba(255,255,255,.04);margin-bottom:6px;}
.sb-av{width:32px;height:32px;border-radius:9px;flex-shrink:0;background:var(--orange);color:white;font-weight:800;font-size:14px;display:flex;align-items:center;justify-content:center;}
.sb-uname{font-size:12px;font-weight:700;color:#f1f5f9;}
.sb-urole{font-size:10px;color:#6b7280;}
.sb-out{display:flex;align-items:center;gap:10px;padding:9px;border-radius:10px;background:transparent;border:none;color:#ef4444;font-size:12px;font-weight:600;cursor:pointer;width:100%;font-family:inherit;white-space:nowrap;transition:background .15s;}
.sb-out:hover{background:rgba(239,68,68,.1);}
.sb-out .ic{width:34px;height:34px;border-radius:9px;background:rgba(239,68,68,.08);display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;}
.topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 28px;background:rgba(244,246,250,.95);backdrop-filter:blur(10px);border-bottom:1px solid var(--border);position:sticky;top:0;z-index:100;}
.top-left{display:flex;align-items:center;gap:10px;}
.back-btn{width:34px;height:34px;border-radius:9px;background:var(--card);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--txt2);text-decoration:none;transition:all .15s;}
.back-btn:hover{background:var(--orange-bg);color:var(--orange);border-color:var(--orange);}
.top-title{font-size:18px;font-weight:800;color:var(--txt);letter-spacing:-.3px;}
.top-sub{font-size:12px;color:var(--txt2);margin-top:1px;}
.chip{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:99px;border:1px solid var(--border);background:var(--card);font-size:11px;font-weight:600;color:var(--txt2);}
.page{padding:28px;flex:1;}
.btn{display:inline-flex;align-items:center;gap:7px;padding:10px 18px;border-radius:10px;font-size:13px;font-weight:700;border:none;cursor:pointer;font-family:inherit;transition:all .15s;text-decoration:none;}
.btn-orange{background:var(--orange);color:white;}
.btn-orange:hover{background:#c2410c;}
.btn-ghost{background:transparent;color:var(--txt2);border:1px solid var(--border);}
.btn-ghost:hover{background:#f3f4f6;}
.btn-red{background:var(--red-bg);color:var(--red);border:1px solid #fecaca;}
.btn-red:hover{background:#fee2e2;}
.btn-sm{padding:6px 12px;font-size:11px;border-radius:8px;}
.tbl-card{background:var(--card);border:1px solid var(--border);border-radius:var(--r);box-shadow:var(--shadow);}
.tbl-head{padding:18px 22px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;}
.tbl-head h6{font-size:15px;font-weight:800;}
.search-box{display:flex;align-items:center;gap:8px;background:var(--bg);border:1px solid var(--border);border-radius:10px;padding:8px 12px;font-size:13px;color:var(--txt2);}
.search-box input{border:none;background:transparent;outline:none;font-family:inherit;font-size:13px;color:var(--txt);width:200px;}
table.dt{width:100%;border-collapse:collapse;}
table.dt thead tr{background:#f8fafc;border-bottom:1px solid var(--border);}
table.dt th{padding:11px 18px;font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.15em;color:var(--txt2);text-align:left;}
table.dt tbody tr{border-bottom:1px solid #f3f4f8;transition:background .12s;}
table.dt tbody tr:last-child{border-bottom:none;}
table.dt tbody tr:hover{background:#f8f9ff;}
table.dt td{padding:13px 18px;font-size:13px;vertical-align:middle;}
.ava{width:34px;height:34px;border-radius:9px;background:var(--orange-bg);color:var(--orange);font-weight:800;font-size:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.empty-state{padding:48px 24px;text-align:center;}
.pagination-wrap{padding:14px 22px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;font-size:12px;color:var(--txt2);}
.pagination-wrap .page-links{display:flex;gap:4px;}
.pagination-wrap .page-links a,.pagination-wrap .page-links span{padding:6px 11px;border-radius:8px;border:1px solid var(--border);font-size:12px;font-weight:600;text-decoration:none;color:var(--txt2);transition:all .15s;}
.pagination-wrap .page-links a:hover{background:var(--orange-bg);border-color:var(--orange);color:var(--orange);}
.pagination-wrap .page-links span.active{background:var(--orange);border-color:var(--orange);color:white;}
@media(max-width:640px){.sb{display:none;}.main{margin-left:0;}.page{padding:16px;}}
</style>

<div class="app">
    @include('partials.sidebar')

    <div class="main">
        <header class="topbar">
            <div class="top-left">
                <a href="{{ route('dashboard') }}" class="back-btn"><i class="fas fa-arrow-left"></i></a>
                <div>
                    <div class="top-title">Data Siswa</div>
                    <div class="top-sub">{{ $students->total() }} siswa terdaftar</div>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <a href="{{ route('students.create') }}" class="btn btn-orange">
                    <i class="fas fa-plus"></i> Tambah Siswa
                </a>
            </div>
        </header>

        <div class="page">

            @if(session('success'))
            <div style="background:var(--green-bg);border:1px solid #a7f3d0;border-radius:12px;padding:12px 18px;margin-bottom:18px;font-size:13px;font-weight:600;color:var(--green);display:flex;align-items:center;gap:8px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif

            <div class="tbl-card">
                <div class="tbl-head">
                    <h6>👥 Daftar Siswa</h6>
                    <div class="search-box">
                        <i class="fas fa-search" style="color:var(--txt3);"></i>
                        <input type="text" id="searchInput" placeholder="Cari nama / NIS...">
                    </div>
                </div>
                <table class="dt">
                    <thead>
                        <tr>
                            <th style="padding-left:22px;width:50px;">#</th>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>Email</th>
                            <th>Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Jenis Kelamin</th>
                            <th>Beasiswa / Diskon</th>
                            <th style="padding-right:22px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="studentTable">
                        @forelse($students as $i => $s)
                        <tr>
                            <td style="padding-left:22px;color:var(--txt3);font-weight:700;">
                                {{ $students->firstItem() + $i }}
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div class="ava">{{ substr($s->name, 0, 1) }}</div>
                                    <div>
                                        <div style="font-weight:700;">{{ $s->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="color:var(--txt2);font-weight:600;">{{ $s->nis }}</td>
                            <td style="color:var(--txt2);">{{ $s->email }}</td>
                            <td>
                                <span style="background:var(--blue-bg);color:var(--blue);padding:3px 10px;border-radius:6px;font-size:11px;font-weight:700;">
                                    {{ $s->class_id ?? $s->kelas ?? '-' }}
                                </span>
                            </td>
                            <td style="color:var(--txt2);font-weight:600;">{{ $s->tahun_ajaran ?? '-' }}</td>
                            <td style="color:var(--txt2);font-weight:600;">
                                {{ $s->gender === 'L' ? 'Laki-laki' : ($s->gender === 'P' ? 'Perempuan' : '-') }}
                            </td>
                            <td>
                                @if($s->beasiswa_type && $s->beasiswa_type !== 'reguler')
                                    <span style="background:#fef3c7;color:#92400e;padding:4px 8px;border-radius:6px;font-size:11px;font-weight:700;display:inline-block;">
                                        🎓 {{ ucwords(str_replace('_', ' ', $s->beasiswa_type)) }}
                                    </span>
                                    @if($s->potongan_spp > 0)
                                        <div style="font-size:10px;color:#059669;font-weight:700;margin-top:2px;">
                                            -Rp {{ number_format($s->potongan_spp, 0, ',', '.') }}/bln
                                        </div>
                                    @endif
                                @else
                                    <span style="color:var(--txt3);font-size:11px;">Reguler</span>
                                @endif
                            </td>
                            <td style="padding-right:22px;">
                                <div style="display:flex;gap:6px;">
                                    <a href="{{ route('students.edit', $s->id) }}" class="btn btn-ghost btn-sm">
                                        <i class="fas fa-pen"></i> Edit
                                    </a>
                                    <form action="{{ route('students.destroy', $s->id) }}" method="POST"
                                          onsubmit="return confirm('Hapus siswa {{ addslashes($s->name) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-red btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8">
                            <div class="empty-state">
                                <div style="font-size:2.5rem;">👥</div>
                                <p style="font-size:13px;font-weight:600;color:var(--txt2);margin-top:8px;">Belum ada data siswa.</p>
                                <a href="{{ route('students.create') }}" class="btn btn-orange" style="margin-top:14px;">
                                    <i class="fas fa-plus"></i> Tambah Siswa
                                </a>
                            </div>
                        </td></tr>
                        @endforelse
                    </tbody>
                </table>

                @if($students->hasPages())
                <div class="pagination-wrap">
                    <span>Menampilkan {{ $students->firstItem() }}–{{ $students->lastItem() }} dari {{ $students->total() }} siswa</span>
                    {{ $students->links('pagination.custom') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Search filter
document.getElementById('searchInput').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#studentTable tr').forEach(function(row) {
        const txt = row.textContent.toLowerCase();
        row.style.display = txt.includes(q) ? '' : 'none';
    });
});
</script>
@endsection
