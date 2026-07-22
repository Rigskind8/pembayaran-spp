@extends('layouts.app')

@section('title', 'Data Guru - Paramount')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root { --sb: 64px; --sb-open: 220px; --bg: #f4f6fa; --card: #fff; --border: #e8eaf0; --txt: #111827; --txt2: #6b7280; --txt3: #9ca3af; --blue: #2563eb; --blue-bg: #eff6ff; --green: #059669; --green-bg: #ecfdf5; --red: #dc2626; --red-bg: #fef2f2; --amber: #d97706; --purple: #7c3aed; --purple-bg: #f5f3ff; --sb-bg: #0f1117; --r: 16px; --shadow: 0 1px 3px rgba(0,0,0,.06), 0 2px 8px rgba(0,0,0,.04); }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--txt); }
.app { display: flex; min-height: 100vh; }
.main { margin-left: var(--sb); flex: 1; display: flex; flex-direction: column; }

/* SIDEBAR */
.sb { width: var(--sb); background: var(--sb-bg); position: fixed; top: 0; left: 0; height: 100vh; z-index: 200; display: flex; flex-direction: column; align-items: center; padding: 16px 0 20px; transition: width .28s; overflow: hidden; border-right: 1px solid #1a1d27; }
.sb:hover { width: var(--sb-open); align-items: flex-start; }
.sb-brand { display: flex; align-items: center; gap: 10px; padding: 4px 14px; width: 100%; min-height: 44px; margin-bottom: 20px; }
.sb-mark { width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0; background: var(--blue); display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; }
.sb-name { font-size: 13px; font-weight: 700; color: white; white-space: nowrap; opacity: 0; transition: opacity .2s; }
.sb:hover .sb-name { opacity: 1; }
.sb-nav { width: 100%; padding: 0 10px; flex: 1; display: flex; flex-direction: column; gap: 2px; }
.sb-grp { font-size: 11px; font-weight: 800; letter-spacing: .1em; color: #eef4ff; text-transform: uppercase; padding: 12px 8px 4px; white-space: nowrap; opacity: 0; text-shadow: 0 1px 1px rgba(0,0,0,.35); }
.sb:hover .sb-grp { opacity: 1; }
.sb-a { display: flex; align-items: center; gap: 10px; padding: 8px 9px; border-radius: 10px; color: #6b7280; font-size: 13px; font-weight: 500; text-decoration: none; white-space: nowrap; }
.sb-a .ic { width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 13px; color: #4b5163; }
.sb-a.on { color: white; }
.sb-a.on .ic { background: var(--blue); color: white; box-shadow: 0 4px 10px rgba(37,99,235,.3); }
.sb-lbl { opacity: 0; transition: opacity .18s; pointer-events: none; white-space: nowrap; }
.sb:hover .sb-lbl { opacity: 1; pointer-events: auto; }

/* LAYOUT */
.topbar { display: flex; justify-content: space-between; padding: 14px 28px; background: rgba(244,246,250,.95); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border); }
.page { padding: 28px; flex: 1; }
.table-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); box-shadow: var(--shadow); overflow: hidden; margin-bottom: 24px; }
table { width: 100%; border-collapse: collapse; }
thead th { font-size: 10px; font-weight: 700; text-transform: uppercase; color: var(--txt3); padding: 12px 20px; text-align: left; background: #fafafa; border-bottom: 1px solid var(--border); }
tbody td { padding: 12px 20px; font-size: 13px; color: var(--txt); border-bottom: 1px solid #f5f5f7; vertical-align: middle; }
.btn { padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; border: none; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
.btn-blue { background: var(--blue); color: white; }
.btn-red { background: var(--red); color: white; }
.btn-amber { background: var(--amber); color: white; }
.badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; }
.badge-purple { background: var(--purple-bg); color: var(--purple); }
.avatar { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: white; }
.pagination { display: flex; gap: 4px; align-items: center; margin-top: 20px; justify-content: center; }
.pagination a, .pagination span { padding: 6px 10px; border-radius: 6px; font-size: 12px; }
.pagination a { background: white; border: 1px solid var(--border); cursor: pointer; }
.pagination a:hover { background: var(--blue-bg); }
.pagination .active { background: var(--blue); color: white; }

/* MODAL BACKGROUND */
.modal-bg { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.6); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(2px); }
.modal-bg.show { display: flex; }
</style>

<div class="app">
    @include('partials.sidebar')

    <div class="main">
        <header class="topbar">
            <div>
                <div style="font-size:18px; font-weight:800;">Data Guru</div>
                <div style="font-size:12px; color:var(--txt2);">Kelola data guru dan akun pengguna</div>
            </div>
            <a href="{{ route('users.create') }}" class="btn btn-blue">
                <i class="fas fa-plus"></i> Tambah Guru
            </a>
        </header>

        <div class="page">
            
            @if(session('success'))
            <div style="background:var(--green-bg); color:var(--green); padding:12px 16px; border-radius:8px; margin-bottom:20px; font-weight:600; font-size:13px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div style="background:var(--red-bg); color:var(--red); padding:12px 16px; border-radius:8px; margin-bottom:20px; font-weight:600; font-size:13px;">
                <i class="fas fa-triangle-exclamation"></i> {{ session('error') }}
            </div>
            @endif

            <div class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Guru</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Tgl Terdaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <div class="avatar" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size:13px;">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge badge-purple">
                                    <i class="fas fa-graduation-cap"></i> Guru
                                </span>
                            </td>
                            <td>{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</td>
                            <td>
                                <div style="display:flex; gap:6px; flex-wrap:wrap;">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-amber" title="Edit guru">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus guru ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-red" style="cursor:pointer;" title="Hapus guru">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding:40px; color:var(--txt3);">
                                <i class="fas fa-inbox" style="font-size:24px; margin-bottom:10px;"></i>
                                <div>Belum ada data guru</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
            <div class="pagination">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

