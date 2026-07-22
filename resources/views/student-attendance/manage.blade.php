@extends('layouts.app')

@section('title', 'Kelola Absensi Siswa - Travina Prima')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
    --sb: 64px; --sb-open: 220px;
    --bg: #f4f6fa; --card: #fff; --border: #e8eaf0;
    --txt: #111827; --txt2: #6b7280; --txt3: #9ca3af;
    --blue: #2563eb; --green: #059669; --red: #dc2626; --amber: #d97706;
    --sb-bg: #0f1117; --r: 16px;
    --shadow: 0 1px 3px rgba(0,0,0,.06), 0 2px 8px rgba(0,0,0,.04);
}
body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--txt); }
.app { display: flex; min-height: 100vh; }
.main { margin-left: var(--sb); flex: 1; display: flex; flex-direction: column; }
.sb { width: var(--sb); background: var(--sb-bg); position: fixed; top: 0; left: 0; height: 100vh; z-index: 200; display: flex; flex-direction: column; align-items: center; padding: 16px 0 20px; transition: width .28s; overflow: hidden; border-right: 1px solid #1a1d27; }
.sb:hover { width: var(--sb-open); align-items: flex-start; }
.sb-brand { display: flex; align-items: center; gap: 10px; padding: 4px 14px; width: 100%; min-height: 44px; margin-bottom: 20px; }
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
.sb:hover .sb-lbl { opacity: 1; }
.topbar { display: flex; align-items: center; justify-content: space-between; padding: 14px 28px; background: rgba(244,246,250,.95); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; }
.top-title { font-size: 18px; font-weight: 800; color: var(--txt); }
.top-sub { font-size: 12px; color: var(--txt2); margin-top: 1px; }
.page { padding: 28px; flex: 1; overflow-y: auto; }
.card { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); box-shadow: var(--shadow); overflow: hidden; }
.filter-box { background: #f9f9f9; padding: 20px; border-radius: 12px; border-left: 4px solid var(--blue); margin-bottom: 25px; display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; align-items: end; }
.form-group { }
.form-label { display: block; margin-bottom: 6px; font-size: 12px; font-weight: 700; color: var(--txt); }
.form-control { width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 6px; font-size: 13px; }
.btn-filter { padding: 8px 16px; background: linear-gradient(135deg,var(--blue),#4f46e5); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }
.btn-primary { padding: 8px 16px; background: var(--blue); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }
.btn-danger { padding: 8px 16px; background: var(--red); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }
.badge { display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; }
.badge-green { background: #ecfdf5; color: var(--green); }
.badge-amber { background: #fffbeb; color: var(--amber); }
.badge-blue { background: #eff6ff; color: var(--blue); }
.badge-red { background: #fef2f2; color: var(--red); }
.badge-gray { background: #f3f4f6; color: #6b7280; }
table { width: 100%; border-collapse: collapse; }
thead { background: #f5f5f5; }
thead th { padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 700; color: var(--txt2); text-transform: uppercase; letter-spacing: .06em; border-bottom: 1px solid var(--border); }
tbody td { padding: 12px 16px; border-bottom: 1px solid #f5f5f5; font-size: 13px; }
tbody tr:hover { background: #f9f9f9; }
.empty-state { padding: 40px 20px; text-align: center; color: var(--txt3); }
.empty-state i { font-size: 36px; margin-bottom: 10px; display: block; }
.modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,.5); justify-content: center; align-items: center; z-index: 1000; }
.modal.show { display: flex; }
.modal-content { background: white; border-radius: 12px; padding: 30px; max-width: 500px; width: 90%; box-shadow: 0 10px 40px rgba(0,0,0,.2); position: relative; }
.modal-header { font-size: 18px; font-weight: 800; margin-bottom: 20px; color: var(--txt); }
.modal-close { position: absolute; top: 20px; right: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: var(--txt2); }
.form-group-modal { margin-bottom: 20px; }
.form-label-modal { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 700; color: var(--txt); }
.form-control-modal { width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; font-size: 13px; font-family: inherit; }
.modal-footer { display: flex; gap: 10px; justify-content: flex-end; margin-top: 25px; }
.pagination { display: flex; justify-content: center; gap: 5px; margin-top: 20px; }
.paginate-link, .paginate-item { padding: 6px 10px; border: 1px solid var(--border); border-radius: 4px; }
.paginate-link.active { background: var(--blue); color: white; border-color: var(--blue); }
</style>

<div class="app">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <div class="main">
        <header class="topbar">
            <div>
                <div class="top-title">✓ Kelola Absensi Siswa</div>
                <div class="top-sub">Verifikasi dan kelola kehadiran siswa</div>
            </div>
        </header>

        <div class="page">
            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #28a745;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <!-- Filter -->
            <div class="filter-box">
                <form action="{{ route('attendance.manage') }}" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; width: 100%; align-items: end;">
                    <div>
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="date" value="{{ request('date', today()->format('Y-m-d')) }}" class="form-control">
                    </div>
                    <div>
                        <label class="form-label">Kelas</label>
                        <select name="class" class="form-control">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class }}" @selected(request('class') === $class)>{{ $class }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Verifikasi</label>
                        <select name="verification" class="form-control">
                            <option value="">-- Semua Status --</option>
                            <option value="pending" @selected(request('verification') === 'pending')>⏳ Pending</option>
                            <option value="verified" @selected(request('verification') === 'verified')>✓ Verified</option>
                            <option value="rejected" @selected(request('verification') === 'rejected')>✕ Rejected</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-filter">🔍 Filter</button>
                </form>
            </div>

            <!-- Table -->
            <div class="card">
                @if($attendances->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p style="font-size: 16px; font-weight: 600; margin-top: 10px;">Tidak ada data absensi</p>
                    </div>
                @else
                    <div style="overflow-x: auto;">
                        <table>
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Siswa</th>
                                    <th>Kelas</th>
                                    <th>Mapel</th>
                                    <th>Status</th>
                                    <th>Komentar</th>
                                    <th>Verifikasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $attendance)
                                    <tr>
                                        <td style="font-weight: 600;">{{ $attendance->date->format('d/m/Y') }}</td>
                                        <td>
                                            <strong>{{ $attendance->student->name }}</strong><br>
                                            <span style="font-size: 11px; color: var(--txt2);">NIS: {{ $attendance->student->id }}</span>
                                        </td>
                                        <td>{{ $attendance->student->class_id }}</td>
                                        <td>
                                            <strong>{{ $attendance->schedule?->subject->name ?? '-' }}</strong><br>
                                            <span style="font-size: 11px; color: var(--txt2);">{{ $attendance->schedule?->subject->code ?? '-' }} | {{ $attendance->schedule?->teacher?->name ?? '-' }}</span>
                                        </td>
                                        <td>
                                            @if($attendance->status === 'hadir')
                                                <span class="badge badge-green">✓ Hadir</span>
                                            @elseif($attendance->status === 'sakit')
                                                <span class="badge badge-amber">🤒 Sakit</span>
                                            @elseif($attendance->status === 'izin')
                                                <span class="badge badge-blue">📝 Izin</span>
                                            @else
                                                <span class="badge badge-red">✕ Bolos</span>
                                            @endif
                                        </td>
                                        <td style="font-size: 12px;">
                                            @if($attendance->comment)
                                                <span title="{{ $attendance->comment }}" style="cursor: help;">{{ \Str::limit($attendance->comment, 30) }}</span>
                                            @else
                                                <span style="color: var(--txt3);">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($attendance->verification_status === 'pending')
                                                <span class="badge badge-gray">⏳ Pending</span>
                                            @elseif($attendance->verification_status === 'verified')
                                                <span class="badge badge-green">✓ Verified</span>
                                            @else
                                                <span class="badge badge-red">✕ Rejected</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button onclick="openEditModal({{ $attendance->id }}, '{{ $attendance->status }}', '{{ $attendance->verification_status }}', `{{ addslashes($attendance->verification_note ?? '') }}`)" class="btn-primary" style="padding: 5px 10px; font-size: 12px;">✎ Edit</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($attendances->hasPages())
                        <div style="padding: 16px; text-align: center;">
                            {{ $attendances->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeEditModal()">✕</button>
        <div class="modal-header">Kelola Absensi</div>

        <form id="editForm" method="POST" style="display: flex; flex-direction: column;">
            @csrf
            @method('PATCH')

            <div class="form-group-modal">
                <label class="form-label-modal">Status Kehadiran</label>
                <select name="status" id="statusSelect" class="form-control-modal" required>
                    <option value="hadir">✓ Hadir</option>
                    <option value="sakit">🤒 Sakit</option>
                    <option value="izin">📝 Izin</option>
                    <option value="alpha">✕ Bolos</option>
                </select>
            </div>

            <div class="form-group-modal">
                <label class="form-label-modal">Status Verifikasi</label>
                <select name="verification_status" id="verifySelect" class="form-control-modal" required>
                    <option value="pending">⏳ Pending</option>
                    <option value="verified">✓ Verified</option>
                    <option value="rejected">✕ Rejected</option>
                </select>
            </div>

            <div class="form-group-modal">
                <label class="form-label-modal">Catatan Verifikasi</label>
                <textarea name="verification_note" id="noteTextarea" class="form-control-modal" rows="4" placeholder="Masukkan catatan (opsional)..."></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-danger" onclick="closeEditModal()" style="background: #6b7280;">Batal</button>
                <button type="submit" class="btn-primary">💾 Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, status, verifyStatus, note) {
    const form = document.getElementById('editForm');
    form.action = `/kelola-absensi-siswa/${id}`;
    
    document.getElementById('statusSelect').value = status;
    document.getElementById('verifySelect').value = verifyStatus;
    document.getElementById('noteTextarea').value = note;
    
    document.getElementById('editModal').classList.add('show');
}

function closeEditModal() {
    document.getElementById('editModal').classList.remove('show');
}

document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});
</script>
@endsection

