@extends('layouts.app')

@section('title', 'Data User - Paramount')

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

/* MODAL BACKGROUND */
.modal-bg { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.6); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(2px); }
.modal-bg.show { display: flex; }
</style>

<div class="app">
    @include('partials.sidebar')

    <div class="main">
        <header class="topbar">
            <div>
                <div style="font-size:18px; font-weight:800;">Manajemen User</div>
                <div style="font-size:12px; color:var(--txt2);">Kelola hak akses dan akun pengguna</div>
            </div>
            <a href="{{ route('users.create') }}" class="btn btn-blue">
                <i class="fas fa-plus"></i> Tambah User
            </a>
        </header>

        <div class="page">
            @php
                $totalUsers = $users->count();
                $roleCounts = $users->groupBy(fn($user) => strtolower(trim((string) $user->role)));
            @endphp

            <div style="display:grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap:12px; margin-bottom:20px;">
                <div style="background:var(--card); border:1px solid var(--border); border-radius:14px; padding:14px 16px; box-shadow:var(--shadow);">
                    <div style="font-size:11px; font-weight:700; color:var(--txt2); text-transform:uppercase; letter-spacing:.12em; margin-bottom:4px;">Total User</div>
                    <div style="font-size:24px; font-weight:800; color:var(--txt);">{{ $totalUsers }}</div>
                </div>
                <div style="background:var(--card); border:1px solid var(--border); border-radius:14px; padding:14px 16px; box-shadow:var(--shadow);">
                    <div style="font-size:11px; font-weight:700; color:var(--txt2); text-transform:uppercase; letter-spacing:.12em; margin-bottom:4px;">Admin</div>
                    <div style="font-size:24px; font-weight:800; color:var(--txt);">{{ $roleCounts->get('admin', collect())->count() }}</div>
                </div>
                <div style="background:var(--card); border:1px solid var(--border); border-radius:14px; padding:14px 16px; box-shadow:var(--shadow);">
                    <div style="font-size:11px; font-weight:700; color:var(--txt2); text-transform:uppercase; letter-spacing:.12em; margin-bottom:4px;">Guru</div>
                    <div style="font-size:24px; font-weight:800; color:var(--txt);">{{ $roleCounts->get('guru', collect())->count() }}</div>
                </div>
                <div style="background:var(--card); border:1px solid var(--border); border-radius:14px; padding:14px 16px; box-shadow:var(--shadow);">
                    <div style="font-size:11px; font-weight:700; color:var(--txt2); text-transform:uppercase; letter-spacing:.12em; margin-bottom:4px;">Siswa</div>
                    <div style="font-size:24px; font-weight:800; color:var(--txt);">{{ $roleCounts->get('siswa', collect())->count() }}</div>
                </div>
            </div>
            
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
                            <th>User</th>
                            <th>Email</th>
                            <th>Role / Hak Akses</th>
                            <th>Tgl Terdaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                        <tr>
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <div style="width:32px; height:32px; background:var(--blue-bg); color:var(--blue); border-radius:8px; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:12px;">
                                        {{ substr($u->name, 0, 1) }}
                                    </div>
                                    <strong>{{ $u->name }}</strong>
                                </div>
                            </td>
                            <td style="color:var(--txt2);">{{ $u->email }}</td>
                            <td>
                                @php
                                    $role = strtolower(trim((string) $u->role));
                                    $roleLabel = match ($role) {
                                        'admin' => 'Admin',
                                        'guru', 'teacher' => 'Guru',
                                        'siswa', 'student' => 'Siswa',
                                        'kepala_sekolah', 'kepala sekolah' => 'Kepala Sekolah',
                                        default => $u->role ? ucfirst($u->role) : 'User',
                                    };
                                @endphp
                                @if($role === 'admin')
                                    <span style="background:var(--purple-bg); color:var(--purple); padding:4px 10px; border-radius:99px; font-size:11px; font-weight:700;"><i class="fas fa-shield-halved"></i> {{ $roleLabel }}</span>
                                @elseif(in_array($role, ['guru', 'teacher'], true))
                                    <span style="background:var(--blue-bg); color:var(--blue); padding:4px 10px; border-radius:99px; font-size:11px; font-weight:700;"><i class="fas fa-chalkboard-user"></i> {{ $roleLabel }}</span>
                                @elseif(in_array($role, ['siswa', 'student'], true))
                                    <span style="background:var(--green-bg); color:var(--green); padding:4px 10px; border-radius:99px; font-size:11px; font-weight:700;"><i class="fas fa-user-graduate"></i> {{ $roleLabel }}</span>
                                @else
                                    <span style="background:var(--bg); color:var(--txt2); padding:4px 10px; border-radius:99px; font-size:11px; font-weight:700;"><i class="fas fa-user"></i> {{ $roleLabel }}</span>
                                @endif
                            </td>
                            <td style="color:var(--txt2); font-size:12px;">{{ $u->created_at->format('d M Y') }}</td>
                            <td>
                                <div style="display:flex; gap:6px;">
                                    <a href="{{ route('users.edit', $u->id) }}" class="btn btn-blue" title="Edit Akun">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    {{-- Tombol Reset Password dengan pengaman addslashes --}}
                                    <button type="button" class="btn btn-amber" onclick="openResetModal({{ $u->id }}, '{{ addslashes($u->name) }}')" title="Reset Password">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    
                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin hapus akun {{ $u->name }}?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-red" title="Hapus Akun"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($users->isEmpty())
                <div style="padding:40px 20px; text-align:center; color:var(--txt2);">Belum ada data user.</div>
            @endif
        </div>
    </div>
</div>

{{-- MODAL RESET PASSWORD YANG UDAH DI-FIX WARNANYA --}}
<div class="modal-bg" id="resetModal">
    <div style="background: #ffffff; border-radius: 16px; padding: 24px; width: 100%; max-width: 400px; box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
        <h3 style="margin-bottom: 12px; font-size:18px; color: #0f172a;">🔑 Reset Password</h3>
        
        <p style="font-size:13px; color: #475569; margin-bottom:20px; line-height: 1.5;">
            Masukkan password baru untuk akun atas nama <br>
            <strong id="resetUserName" style="color: #2563eb; font-size:14px;"></strong>.
        </p>
        
        <form id="resetForm" method="POST">
            @csrf
            <div style="margin-bottom: 20px;">
                <label style="display:block; font-size:12px; font-weight:700; color: #334155; margin-bottom:8px;">Password Baru</label>
                <input type="text" name="new_password" placeholder="Ketik minimal 6 karakter..." required minlength="6" 
                    style="width: 100%; padding: 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-family: inherit; font-size: 14px; background: #f8fafc; color: #0f172a; outline: none;">
            </div>
            
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" class="btn" style="background: #e2e8f0; color: #475569;" onclick="closeResetModal()">Batal</button>
                <button type="submit" class="btn" style="background: #2563eb; color: #ffffff;"><i class="fas fa-save"></i> Simpan Password</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openResetModal(id, name) {
        // Set action URL di form-nya
        document.getElementById('resetForm').action = '/users/' + id + '/reset-password';
        
        // Pake innerHTML biar text/namanya dijamin ngerender
        document.getElementById('resetUserName').innerHTML = name;
        
        // Munculin modalnya
        document.getElementById('resetModal').classList.add('show');
    }
    
    function closeResetModal() {
        // Sembunyiin modalnya
        document.getElementById('resetModal').classList.remove('show');
    }
</script>
@endsection
