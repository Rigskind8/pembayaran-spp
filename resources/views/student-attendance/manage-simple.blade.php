@extends('layouts.app')

@section('title', 'Kelola Absensi Siswa - Travina Prima')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root {
    --blue: #2563eb; --green: #059669; --amber: #d97706; --red: #dc2626;
    --bg: #f4f6fa; --card: #fff; --border: #e8eaf0;
    --txt: #111827; --txt2: #6b7280; --txt3: #9ca3af;
}

.container { max-width: 1200px; margin: 0 auto; padding: 20px; }
.page-title { font-size: 24px; font-weight: 800; margin-bottom: 8px; }
.page-sub { font-size: 14px; color: var(--txt2); margin-bottom: 24px; }
.live-chip { display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; color: var(--blue); background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 999px; padding: 5px 10px; margin-bottom: 20px; }
.live-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--blue); animation: pulse 1.2s infinite; }
@keyframes pulse { 0%{opacity:.3;} 50%{opacity:1;} 100%{opacity:.3;} }

.filter-box { background: var(--bg); padding: 16px; border-radius: 12px; margin-bottom: 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; align-items: end; }
.form-control { width: 100%; padding: 8px; border: 1px solid var(--border); border-radius: 6px; font-size: 12px; }
.btn-filter { padding: 8px 14px; background: var(--blue); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }

.table-wrapper { background: var(--card); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
table { width: 100%; border-collapse: collapse; }
thead th { padding: 12px 14px; background: #f9f9f9; border-bottom: 1px solid var(--border); font-size: 11px; font-weight: 700; text-transform: uppercase; }
tbody td { padding: 12px 14px; border-bottom: 1px solid #f5f5f5; font-size: 13px; }
tbody tr:hover { background: #f9f9f9; }
.btn-edit { padding: 5px 10px; background: var(--blue); color: white; border: none; border-radius: 4px; font-size: 11px; font-weight: 600; cursor: pointer; }

.badge { display: inline-block; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; }
.badge-green { background: #ecfdf5; color: var(--green); }
.badge-amber { background: #fffbeb; color: var(--amber); }
.badge-blue { background: #cffafe; color: #0891b2; }
.badge-red { background: #fef2f2; color: var(--red); }
.badge-gray { background: #f3f4f6; color: #6b7280; }

.empty { text-align: center; padding: 40px; color: var(--txt3); }

.student-panel { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 16px; margin-bottom: 20px; }
.student-panel-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 14px; }
.student-panel-title { font-size: 14px; font-weight: 800; color: var(--txt); }
.student-panel-sub { font-size: 12px; color: var(--txt2); margin-top: 2px; }
.student-group { margin-bottom: 14px; }
.student-group:last-child { margin-bottom: 0; }
.student-group-title { font-size: 12px; font-weight: 800; color: var(--blue); margin-bottom: 8px; }
.student-chip-wrap { display: flex; flex-wrap: wrap; gap: 8px; }
.student-chip { display: inline-flex; align-items: center; gap: 6px; padding: 7px 10px; border-radius: 999px; background: #eff6ff; color: #1d4ed8; font-size: 12px; font-weight: 600; }
.student-chip.active { background: #1d4ed8; color: #fff; }
.student-chip a { color: inherit; text-decoration: none; }

.input-panel { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 16px; margin-bottom: 20px; }
.input-panel-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 14px; }
.input-panel-title { font-size: 14px; font-weight: 800; color: var(--txt); }
.input-panel-sub { font-size: 12px; color: var(--txt2); margin-top: 2px; }
.input-form { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 12px; align-items: end; }
.input-form .full { grid-column: 1 / -1; }

.modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
.modal.show { display: flex; }
.modal-content { background: white; border-radius: 12px; padding: 24px; max-width: 450px; width: 95%; box-shadow: 0 10px 40px rgba(0,0,0,0.15); }
.modal-header { font-size: 16px; font-weight: 800; margin-bottom: 18px; }
.form-group { margin-bottom: 14px; }
.form-label { display: block; font-size: 12px; font-weight: 700; margin-bottom: 5px; }
.form-control-modal { width: 100%; padding: 9px; border: 1px solid var(--border); border-radius: 6px; font-size: 12px; font-family: inherit; }
.modal-footer { display: flex; gap: 8px; justify-content: flex-end; margin-top: 18px; }
.btn-cancel { padding: 8px 14px; background: #e5e7eb; color: var(--txt); border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }
.btn-submit { padding: 8px 14px; background: var(--blue); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }
</style>

<div class="app">
    @include('partials.sidebar')

    <div class="main">
<div class="container">
    <div class="page-title"> Kelola Absensi Siswa</div>
    <div class="page-sub">Kelola kehadiran siswa per kelas dan mapel yang diajar</div>
    <div class="live-chip"><span class="live-dot"></span> Auto refresh 15 detik</div>

    @if(session('success'))
        <div style="background: #ecfdf5; padding: 12px; border-radius: 8px; margin-bottom: 16px; border-left: 4px solid var(--green); color: var(--green); font-size: 13px;">
            ✓ {{ session('success') }}
        </div>
    @endif

    <!-- Filter -->
    <form action="{{ route('attendance.manage') }}" method="GET" class="filter-box">
        <div>
            <label style="font-size: 11px; color: var(--txt2); display: block; margin-bottom: 4px;">Tanggal</label>
            <input type="date" name="date" value="{{ request('date', today()->format('Y-m-d')) }}" class="form-control">
        </div>
        <div>
            <label style="font-size: 11px; color: var(--txt2); display: block; margin-bottom: 4px;">Kelas</label>
            <select name="class" class="form-control">
                <option value="">-- Semua --</option>
                @foreach($classes as $c)
                    <option value="{{ $c }}" @selected((string) request()->input('class', '') === (string) $c)>{{ $c }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label style="font-size: 11px; color: var(--txt2); display: block; margin-bottom: 4px;">Mapel</label>
            <select name="subject_id" class="form-control">
                <option value="">-- Semua --</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" @selected((string) request()->input('subject_id', '') === (string) $subject->id)>{{ $subject->name ?? '-' }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-filter">🔍 Filter</button>
    </form>

    @php
        $studentGroups = ($students ?? collect())->groupBy('class_id');
        $studentTotal = ($students ?? collect())->count();
        $selectedStudentId = $selectedStudentId ?? null;
    @endphp

    <div class="student-panel">
        <div class="student-panel-head">
            <div>
                <div class="student-panel-title">Daftar Siswa Sesuai Filter</div>
                <div class="student-panel-sub">{{ $studentTotal }} siswa yang relevan dengan kelas atau mapel yang dipilih</div>
            </div>
        </div>

        @if($studentGroups->isEmpty())
            <div class="empty" style="padding: 14px 0 4px;">Pilih kelas atau mapel untuk menampilkan nama siswa.</div>
        @else
            @foreach($studentGroups as $classId => $groupStudents)
                <div class="student-group">
                    <div class="student-group-title">Kelas {{ $classId }}</div>
                    <div class="student-chip-wrap">
                        @foreach($groupStudents as $student)
                            @php
                                $queryParams = array_filter([
                                    'date' => request('date', today()->format('Y-m-d')),
                                    'class' => request('class'),
                                    'subject_id' => request('subject_id'),
                                    'student_id' => $student->id,
                                ], fn ($value) => $value !== null && $value !== '');
                            @endphp
                            <a class="student-chip {{ (int) $selectedStudentId === (int) $student->id ? 'active' : '' }}" href="{{ route('attendance.manage', $queryParams) }}">{{ $student->name }}</a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    @if($selectedStudent)
        <div class="input-panel">
            <div class="input-panel-head">
                <div>
                    <div class="input-panel-title">Input Absensi untuk {{ $selectedStudent->name }}</div>
                    <div class="input-panel-sub">Kelas {{ $selectedStudent->class_id }} · pilih mapel/jadwal yang sesuai lalu simpan</div>
                </div>
            </div>

            @if(($scheduleOptions ?? collect())->isEmpty())
                <div class="empty" style="padding: 12px 0 0;">Tidak ada jadwal yang cocok untuk siswa ini. Coba ubah filter kelas atau mapel.</div>
            @else
                <form action="{{ route('absensi.admin.store') }}" method="POST" class="input-form">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $selectedStudent->id }}">

                    <div>
                        <label style="font-size: 11px; color: var(--txt2); display: block; margin-bottom: 4px;">Tanggal</label>
                        <input type="date" name="date" value="{{ request('date', today()->format('Y-m-d')) }}" class="form-control" required>
                    </div>

                    <div>
                        <label style="font-size: 11px; color: var(--txt2); display: block; margin-bottom: 4px;">Jadwal / Mapel</label>
                        <select name="schedule_id" class="form-control" required>
                            <option value="">-- Pilih Jadwal --</option>
                            @foreach($scheduleOptions as $schedule)
                                <option value="{{ $schedule->id }}">
                                    {{ $schedule->subject?->name ?? '-' }} · {{ $schedule->day }} · {{ $schedule->start_time?->format('H:i') }}-{{ $schedule->end_time?->format('H:i') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="font-size: 11px; color: var(--txt2); display: block; margin-bottom: 4px;">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="hadir"> Hadir</option>
                            <option value="sakit"> Sakit</option>
                            <option value="izin"> Izin</option>
                            <option value="alpha"> Bolos</option>
                        </select>
                    </div>

                    <div class="full">
                        <label style="font-size: 11px; color: var(--txt2); display: block; margin-bottom: 4px;">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Opsional...">
                    </div>

                    <div class="full" style="display:flex; justify-content:flex-end; gap:10px;">
                        <button type="submit" class="btn-filter">Simpan Absensi</button>
                    </div>
                </form>
            @endif
        </div>
    @endif

    <!-- Table -->
    @if($attendances->isEmpty())
        <div class="empty">
            <p style="font-size: 16px;">Tidak ada data absensi</p>
        </div>
    @else
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Mapel</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $att)
                        <tr>
                            <td><strong>{{ $att->date->format('d/m/Y') }}</strong></td>
                            <td>
                                <strong>{{ $att->student->name }}</strong><br>
                                <span style="font-size: 11px; color: var(--txt2);">NIS: {{ $att->student->id }}</span>
                            </td>
                            <td>{{ $att->student->class_id }}</td>
                            <td>{{ $att->schedule?->subject->name ?? '-' }}</td>
                            <td>
                                @if($att->status === 'hadir')
                                    <span class="badge badge-green">✓ Hadir</span>
                                @elseif($att->status === 'sakit')
                                    <span class="badge badge-amber">🤒 Sakit</span>
                                @elseif($att->status === 'izin')
                                    <span class="badge badge-blue">📝 Izin</span>
                                @else
                                    <span class="badge badge-red">✕ Bolos</span>
                                @endif
                            </td>
                            <td>
                                {{ $att->keterangan ?: '-' }}
                            </td>
                            <td>
                                <button onclick="openModal({{ $att->id }}, '{{ $att->status }}', `{{ addslashes($att->keterangan ?? $att->comment ?? '') }}`, '{{ $att->proof_path ? Storage::url($att->proof_path) : '' }}')" class="btn-edit">
                                    ✎ Edit
                                    @if($att->proof_path)<i class="fas fa-paperclip" style="margin-left: 5px; font-size: 10px;"></i>@endif
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 16px; display: flex; justify-content: center; gap: 6px;">
            {{ $attendances->links() }}
        </div>
    @endif
</div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">Edit Absensi</div>
        <form id="editForm" method="POST">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label class="form-label">Status Kehadiran</label>
                <select id="statusSelect" name="status" class="form-control-modal" required>
                    <option value="hadir"> Hadir</option>
                    <option value="sakit"> Sakit</option>
                    <option value="izin"> Izin</option>
                    <option value="alpha"> Bolos</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Keterangan</label>
                <textarea id="noteInput" name="keterangan" class="form-control-modal" rows="3" placeholder="Opsional..."></textarea>
            </div>

            <div class="form-group" id="proofLinkGroup" style="display:none;">
                <label class="form-label">Bukti Absensi</label>
                <a id="proofLink" href="#" target="_blank" class="btn-submit" style="display:inline-block; text-decoration:none; background:#0ea5e9; margin-top:5px;">
                    <i class="fas fa-file-alt" style="margin-right:5px;"></i> Lihat Bukti
                </a>
            </div>

            <input type="hidden" id="attendanceId" value="">
        </form>

        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
            <button type="button" class="btn-submit" onclick="submitEdit()">Simpan</button>
        </div>
    </div>
</div>

<script>
function openModal(id, status, note) {
    let proofPath = arguments[3] || '';

    // Store the attendance ID
    document.getElementById('attendanceId').value = id;
    document.getElementById('statusSelect').value = status;
    document.getElementById('noteInput').value = note;
    document.getElementById('editModal').classList.add('show');

    if (proofPath) {
        document.getElementById('proofLink').href = proofPath;
        document.getElementById('proofLinkGroup').style.display = 'block';
    } else {
        document.getElementById('proofLinkGroup').style.display = 'none';
    }
}

function submitEdit() {
    const id = document.getElementById('attendanceId').value;
    if (!id) {
        alert('ID tidak ditemukan');
        return;
    }
    
    const form = document.getElementById('editForm');
    form.action = `/kelola-absensi-siswa/${id}`;
    form.submit();
}

function closeModal() {
    document.getElementById('editModal').classList.remove('show');
}

document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

function syncNoteRequirement() {
    const noteInput = document.getElementById('noteInput');
    if (!noteInput) {
        return;
    }

    noteInput.placeholder = 'Opsional...';
}

window.addEventListener('load', syncNoteRequirement);

setInterval(function () {
    const modal = document.getElementById('editModal');
    if (document.hidden || modal.classList.contains('show')) {
        return;
    }
    window.location.reload();
}, 15000);
</script>
@endsection
