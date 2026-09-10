@extends('layouts.app')

@section('title', 'Activity Log / Audit Trail - SMK TRAVINA PRIMA')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
:root{--sb:64px;--sb-open:220px;--bg:#f4f6fa;--card:#fff;--border:#e8eaf0;--txt:#111827;--txt2:#6b7280;--blue:#2563eb;--green:#059669;--amber:#d97706;--red:#dc2626;--r:16px;--shadow:0 1px 3px rgba(0,0,0,.06),0 2px 8px rgba(0,0,0,.04);}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg);color:var(--txt);-webkit-font-smoothing:antialiased;}
.app{display:flex;min-height:100vh;}
.main{margin-left:var(--sb);flex:1;display:flex;flex-direction:column;}
.topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 28px;background:rgba(244,246,250,.95);backdrop-filter:blur(10px);border-bottom:1px solid var(--border);position:sticky;top:0;z-index:100;}
.top-title{font-size:18px;font-weight:800;color:var(--txt);letter-spacing:-.3px;}
.top-sub{font-size:12px;color:var(--txt2);margin-top:1px;}
.page{padding:28px;flex:1;}
.tbl-card{background:var(--card);border:1px solid var(--border);border-radius:var(--r);box-shadow:var(--shadow);overflow:hidden;}
.tbl-head{padding:18px 22px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;}
.search-box{display:flex;align-items:center;gap:8px;background:var(--bg);border:1px solid var(--border);border-radius:10px;padding:8px 12px;font-size:13px;}
.search-box input{border:none;background:transparent;outline:none;font-family:inherit;font-size:13px;color:var(--txt);width:220px;}
table.dt{width:100%;border-collapse:collapse;}
table.dt thead tr{background:#f8fafc;border-bottom:1px solid var(--border);}
table.dt th{padding:11px 18px;font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.15em;color:var(--txt2);text-align:left;}
table.dt tbody tr{border-bottom:1px solid #f3f4f8;transition:background .12s;}
table.dt tbody tr:hover{background:#f8f9ff;}
table.dt td{padding:13px 18px;font-size:13px;vertical-align:middle;}
.badge-act{display:inline-block;padding:3px 8px;border-radius:6px;font-size:11px;font-weight:800;text-transform:uppercase;}
.act-login{background:#ecfdf5;color:#059669;}
.act-logout{background:#fef2f2;color:#dc2626;}
.act-default{background:#eff6ff;color:#2563eb;}
@media(max-width:640px){.main{margin-left:0;}.page{padding:16px;}}
</style>

<div class="app">
    @include('partials.sidebar')

    <div class="main">
        <header class="topbar">
            <div>
                <div class="top-title">Activity Log & Audit Trail</div>
                <div class="top-sub">Pencatatan Riwayat Aktivitas & Keamanan Sistem</div>
            </div>
        </header>

        <div class="page">
            <div class="tbl-card">
                <div class="tbl-head">
                    <h6 style="font-size:15px;font-weight:800;">📜 Audit Trail Log</h6>
                    <form method="GET" action="{{ route('admin.activity-logs') }}" class="search-box">
                        <i class="fas fa-search" style="color:var(--txt2);"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / aksi / deskripsi...">
                        <button type="submit" style="display:none;"></button>
                    </form>
                </div>

                <div style="overflow-x:auto;">
                    <table class="dt">
                        <thead>
                            <tr>
                                <th style="width:50px;padding-left:22px;">#</th>
                                <th>Waktu</th>
                                <th>Pengguna</th>
                                <th>Role</th>
                                <th>Aksi</th>
                                <th>Deskripsi</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $i => $log)
                            <tr>
                                <td style="padding-left:22px;color:var(--txt2);font-weight:700;">
                                    {{ $logs->firstItem() + $i }}
                                </td>
                                <td style="white-space:nowrap;font-size:12px;font-weight:600;color:var(--txt2);">
                                    {{ $log->created_at->format('d M Y H:i:s') }}
                                </td>
                                <td style="font-weight:700;">{{ $log->user_name }}</td>
                                <td>
                                    <span style="background:#f1f5f9;color:#475569;padding:2px 8px;border-radius:4px;font-size:11px;font-weight:700;">
                                        {{ ucfirst($log->role) }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $actCls = match($log->action) {
                                            'LOGIN' => 'act-login',
                                            'LOGOUT' => 'act-logout',
                                            default => 'act-default',
                                        };
                                    @endphp
                                    <span class="badge-act {{ $actCls }}">{{ $log->action }}</span>
                                </td>
                                <td style="color:var(--txt);">{{ $log->description }}</td>
                                <td style="font-family:monospace;font-size:12px;color:var(--txt2);">{{ $log->ip_address }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="padding:30px;text-align:center;color:var(--txt2);">Belum ada catatan aktivitas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($logs->hasPages())
                <div style="padding:16px 22px;border-top:1px solid var(--border);">
                    {{ $logs->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
