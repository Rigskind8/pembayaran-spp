@extends('layouts.app')

@section('title', 'Absen Mapel Hari Ini')

@push('styles')
<style>
:root {
    --bg: #f3f6fb;
    --card: #ffffff;
    --line: #e2e8f0;
    --text: #0f172a;
    --muted: #64748b;
    --brand: #0369a1;
    --brand-2: #0ea5e9;
    --brand-soft: #e0f2fe;
    --ok: #059669;
    --warn: #d97706;
    --info: #2563eb;
    --danger: #dc2626;
    --shadow: 0 14px 32px rgba(15, 23, 42, .08);
}

.main {
    margin-left: var(--sb, 250px);
    min-height: 100vh;
    background: radial-gradient(circle at 90% 0%, rgba(14, 165, 233, .14), transparent 28%), var(--bg);
}

.page-wrap {
    padding: 28px;
}

.topbar {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 10px;
    margin-bottom: 18px;
}

.title {
    font-size: 30px;
    font-weight: 800;
    letter-spacing: -.02em;
    color: var(--text);
}

.subtitle {
    margin-top: 4px;
    color: var(--muted);
    font-size: 13px;
}

.chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border: 1px solid var(--line);
    border-radius: 999px;
    background: var(--card);
    color: var(--muted);
    font-size: 12px;
    font-weight: 700;
}

.hero {
    border-radius: 24px;
    padding: 22px 24px;
    color: #f8fdff;
    margin-bottom: 18px;
    background: linear-gradient(135deg, #0369a1 0%, #0284c7 56%, #0ea5e9 100%);
    box-shadow: 0 16px 40px rgba(3, 105, 161, .28);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap; /* Allow wrapping on smaller screens */
}

.hero h2, .hero h3 {
    margin: 0 0 6px;
    font-size: 24px;
    font-weight: 800;
}

.hero p {
    margin: 0;
    opacity: .9;
    font-size: 13px;
}

.hero-progress {
    width: 100%;
    height: 8px;
    background: rgba(255, 255, 255, .2);
    border-radius: 999px;
    overflow: hidden;
    margin-top: 10px;
}
.hero-progress-bar {
    height: 100%;
    background: #ffffff;
    border-radius: 999px;
}

.hero-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(90px, 1fr)); /* Responsive stats */
}

.stat {
    background: rgba(255, 255, 255, .18);
    border: 1px solid rgba(255, 255, 255, .28);
    border-radius: 14px;
    padding: 10px 12px;
    text-align: center;
}

.stat strong {
    display: block;
    font-size: 20px;
    line-height: 1;
}

.stat span {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: .08em;
    font-weight: 700;
}

.alert-success {
    border-radius: 14px;
    padding: 12px 14px;
    background: #ecfdf5;
    color: #14532d;
    border: 1px solid #a7f3d0;
    margin-bottom: 14px;
    font-size: 13px;
    font-weight: 700;
}

.grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
}

@media (max-width: 980px) {
    .grid { grid-template-columns: 1fr; }
}

.card {
    border-radius: 18px;
    background: var(--card);
    border: 1px solid var(--line);
    box-shadow: var(--shadow);
    overflow: hidden;
}

.card-head {
    background: #f8fafc;
    border-bottom: 1px solid var(--line);
    padding: 14px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
}

.subject-name {
    margin: 0;
    font-size: 16px;
    font-weight: 800;
    color: var(--text);
}

.subject-code {
    font-size: 11px;
    color: var(--muted);
    margin-top: 2px;
}

.status-badge {
    border-radius: 999px;
    padding: 6px 11px;
    font-size: 11px;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    white-space: nowrap; /* Prevent badge text from wrapping */
    gap: 5px;
}

.status-hadir { background: #ecfdf5; color: var(--ok); }
.status-sakit { background: #fffbeb; color: var(--warn); }
.status-izin { background: #dbeafe; color: var(--info); }
.status-alpha { background: #fef2f2; color: var(--danger); }
.status-empty { background: #f1f5f9; color: #475569; }

.card-body {
    padding: 16px;
}

.info-list {
    display: grid;
    gap: 8px;
}

.info-row {
    display: grid;
    grid-template-columns: 28px 1fr;
    gap: 10px;
    align-items: center;
    color: #334155;
    font-size: 13px;
}

.icon {
    width: 28px;
    height: 28px;
    border-radius: 9px;
    display: grid;
    place-items: center;
    background: var(--brand-soft);
    color: var(--brand);
    font-size: 12px;
}

.current-note {
    margin-top: 12px;
    padding: 12px;
    border-radius: 12px;
    border: 1px solid var(--line);
    background: #f8fafc;
    font-size: 12px;
    color: #475569;
}

.actions {
    margin-top: 14px;
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 8px;
}

.btn-status {
    border: 1px solid var(--line);
    border-radius: 12px;
    padding: 11px 8px;
    font-size: 12px;
    line-height: 1.2; /* Better line height for text */
    font-weight: 800;
    cursor: pointer;
    background: #ffffff;
    transition: .18s ease;
    box-shadow: inset 0 0 0 1px transparent;
}

.btn-status:hover {
    color: #ffffff !important; /* Ensure text color changes on hover */
    transform: translateY(-1px);
    box-shadow: 0 8px 18px rgba(15, 23, 42, .08);
}

.btn-hadir {
    color: #065f46;
    border-color: #a7f3d0;
    background: linear-gradient(180deg, #ecfdf5 0%, #d1fae5 100%); /* Light green */
}

.btn-hadir:hover {
    border-color: #059669;
    background: linear-gradient(180deg, #10b981 0%, #059669 100%); /* Darker green */
}

.btn-sakit {
    color: #92400e;
    border-color: #fcd34d;
    background: linear-gradient(180deg, #fffbeb 0%, #fef3c7 100%); /* Light amber */
}

.btn-sakit:hover {
    border-color: #d97706;
    background: linear-gradient(180deg, #f59e0b 0%, #d97706 100%); /* Darker amber */
}

.btn-izin {
    color: #1e40af;
    border-color: #bfdbfe;
    background: linear-gradient(180deg, #eff6ff 0%, #dbeafe 100%); /* Light blue */
}

.btn-izin:hover {
    border-color: #2563eb;
    background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%); /* Darker blue */
}

.btn-alpha {
    color: #991b1b;
    border-color: #fecaca;
    background: linear-gradient(180deg, #fef2f2 0%, #fee2e2 100%); /* Light red */
}

.btn-alpha:hover {
    color: #ffffff;
    border-color: #dc2626;
    background: linear-gradient(180deg, #ef4444 0%, #dc2626 100%);
}

.empty-state {
    margin-top: 10px;
    border-radius: 18px;
    border: 1px solid var(--line);
    background: var(--card);
    text-align: center;
    padding: 34px 20px;
    color: var(--muted);
}

.empty-state i {
    font-size: 38px;
    color: var(--brand);
    margin-bottom: 12px;
}

.empty-state a {
    margin-top: 12px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    background: var(--brand);
    color: #ffffff;
    font-weight: 700;
    border-radius: 12px;
    padding: 10px 14px;
}

.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, .5);
    z-index: 2000;
    align-items: center;
    justify-content: center;
    padding: 16px;
}

.modal.show { display: flex; }

.modal-box {
    width: 100%;
    max-width: 500px;
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid var(--line);
    box-shadow: 0 24px 60px rgba(15, 23, 42, .2);
    overflow: hidden;
}

.modal-head {
    padding: 16px 18px;
    border-bottom: 1px solid var(--line);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    margin: 0;
    font-size: 17px;
    font-weight: 800;
    color: var(--text);
}

.modal-close {
    border: none;
    background: transparent;
    color: var(--muted);
    font-size: 24px;
    cursor: pointer;
}

.modal-body {
    padding: 16px 18px 8px;
}

.group {
    margin-bottom: 13px;
}

.label {
    display: block;
    margin-bottom: 6px;
    color: var(--muted);
    font-size: 12px;
    font-weight: 700;
}

.control {
    width: 100%;
    border: 1px solid var(--line);
    border-radius: 12px;
    min-height: 42px;
    padding: 10px 12px;
    font-size: 13px;
    font-family: inherit;
    color: var(--text);
    background: #ffffff;
}

.control[readonly] {
    background: #f8fafc;
}

.control:focus {
    outline: none;
    border-color: var(--brand);
    box-shadow: 0 0 0 3px rgba(14, 165, 233, .14);
}

.modal-foot {
    border-top: 1px solid var(--line);
    padding: 12px 18px;
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}

.btn-modal {
    border: none;
    border-radius: 11px;
    padding: 10px 14px;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
}

.btn-secondary { background: #e2e8f0; color: #334155; }
.btn-primary { background: var(--brand); color: #ffffff; }

@media (max-width: 900px) {
    .main { margin-left: 0; }
    .page-wrap { padding: 18px; }
    .topbar { flex-direction: column; align-items: flex-start; }
    .title { font-size: 24px; }
    .hero { padding: 18px; }
    .hero-stats { width: 100%; }
}

/* Mobile specific adjustments for buttons */
@media (max-width: 480px) {
    .actions { grid-template-columns: 1fr; } /* Stack buttons vertically */
}
</style>
@endpush

@section('content')

<div class="app">
    @include('partials.sidebar')
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
            <h1>Jadwal Hari Ini: {{ $dayName }}, {{ \Carbon\Carbon::parse($today)->format('d M Y') }}</h1>
            <div>
                <a href="{{ route('attendance.history') }}" class="btn btn-outline-primary" style="margin-right:8px;">Riwayat Absensi</a>
                <a href="{{ Route::has('schedule.index') ? route('schedule.index') : url('/jadwal') }}" class="btn btn-outline-info">Jadwal Pelajaran</a>
            </div>
        </div>

    <main class="main">
        <div class="page-wrap">
            <div class="topbar">
                <div>
                    <div class="title">Absen Mapel</div>
                    <div class="subtitle">{{ $dayName }}, {{ \Carbon\Carbon::parse($today)->format('d M Y') }} · Kelas {{ $student->class_id }} · NIS {{ $student->nis }}</div>
                </div>
                <div class="chip">
                    <i class="fas fa-user-graduate" style="color: var(--brand);"></i>
                    {{ $student->name }}
                </div>
            </div>

        @if(session('success'))
            <div class="alert alert-success" id="feedback-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger" id="feedback-error">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger" id="feedback-errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

            @php
                $submittedCount = $schedules->count() - $notSubmittedCount;
            @endphp
    @if($schedules->isEmpty())
        <p>Tidak ada jadwal untuk hari ini.</p>
    @else
        @foreach($schedules as $schedule)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $schedule->subject->name }}</h5>
                    <p class="card-text">Guru: {{ $schedule->teacher->name }}</p>
                    <p class="card-text">Waktu: {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</p>

            <section class="hero">
                <div>
                    <h2>Kehadiran Harian Per Mapel</h2>
                    <p>Pilih status hadir, sakit, izin, atau alpha untuk setiap sesi pelajaran hari ini.</p>
                </div>
                <div class="hero-stats">
                    <div class="stat"><strong>{{ $schedules->count() }}</strong><span>Total Sesi</span></div>
                    <div class="stat"><strong>{{ $submittedCount }}</strong><span>Sudah Absen</span></div>
                    <div class="stat"><strong>{{ $notSubmittedCount }}</strong><span>Belum Absen</span></div>
                </div>
            </section>

                    @php
                        // Memeriksa apakah absensi untuk jadwal ini sudah ada untuk hari ini
                        $attendance = $attendances->get($schedule->id);
                        $isSubmitted = (bool) $attendance;
                        $isDisabled = $isSubmitted; // Jika ada record absensi, tombol akan dinonaktifkan
                        $statusMessage = '';
                        $statusClass = '';
                        if ($isSubmitted) {
                            if ($attendance->verification_status === 'verified') {
                                $statusMessage = 'Sudah Absen (Terverifikasi)';
                                $statusClass = 'text-success';
                            } elseif ($attendance->verification_status === 'rejected') {
                                $statusMessage = 'Absensi Ditolak: ' . ($attendance->verification_note ?: 'Silakan hubungi admin.');
                                $statusClass = 'text-danger';
                            } else { // status 'pending'
                                $statusMessage = 'Sudah Absen (Menunggu Verifikasi)';
                                $statusClass = 'text-warning';
                            }
                        }
                    @endphp

            @if($schedules->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <div style="font-size: 18px; font-weight: 800; margin-bottom: 6px;">Tidak ada jadwal hari ini</div>
                    <div>Belum ada mapel untuk kelas <strong>{{ $student->class_id }}</strong> pada hari <strong>{{ $dayName }}</strong>.</div>
                    <a href="{{ route('schedule.generate') }}"><i class="fas fa-magic"></i> Buat Jadwal Mingguan</a>
                </div>
            @else
                <div class="grid">
                    @foreach($schedules as $schedule)
                        @php
                            $attendance = $attendances->get($schedule->id);
                            $status = $attendance?->status;
                            $teacherName = $schedule->teacher?->name
                                ?? $schedule->subject->teacher
                                ?? 'Guru belum diset';
                        @endphp

                        <article class="card">
                            <header class="card-head">
                                <div>
                                    <h3 class="subject-name">{{ $schedule->subject->name ?? '-' }}</h3>
                                    <div class="subject-code">{{ $schedule->subject->code ?? '-' }}</div>
                                </div>
                                <span class="status-badge {{ $status ? 'status-' . $status : 'status-empty' }}">
                                    @if($status === 'hadir') ✓ Hadir
                                    @elseif($status === 'sakit') Sakit
                                    @elseif($status === 'izin') Izin
                                    @elseif($status === 'alpha') Alpha
                                    @else Belum Absen
                                    @endif
                                </span>
                            </header>
                            <div class="card-body">
                                <div class="info-list">
                                    <div class="info-row"><div class="icon"><i class="fas fa-clock"></i></div><div>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</div></div>
                                    <div class="info-row"><div class="icon"><i class="fas fa-user-tie"></i></div><div>{{ $teacherName }}</div></div>
                                    <div class="info-row"><div class="icon"><i class="fas fa-school"></i></div><div>Ruang {{ $schedule->room ?? '-' }}</div></div>
                                </div>

                                @if($attendance)
                                    <div class="current-note">
                                        @if($attendance->comment)
                                            Catatan terakhir: {{ \Illuminate\Support\Str::limit($attendance->comment, 110) }}
                                        @else
                                            Status sudah direkam untuk mapel ini.
                                        @endif
                                        <br>
                                        <strong>Status hari ini:</strong> {{ ucfirst($attendance->status) }}
                                        @if($attendance->status === 'alpha')
                                            <br><span style="color: #991b1b;">Absensi otomatis karena tidak diisi pada hari jadwal.</span>
                                        @endif
                                        @if($attendance->verification_status === 'rejected')
                                            <br><span style="color: #991b1b; font-weight: 700;">Absensi ditolak admin/guru.</span>
                                            @if($attendance->verification_note)
                                                <br><span style="color: #7f1d1d;">{{ $attendance->verification_note }}</span>
                                            @endif
                                        @elseif($attendance->verification_status === 'verified')
                                            <br><span style="color: #065f46; font-weight: 700;">Absensi sudah diverifikasi.</span>
                                        @endif
                                        <br>
                                        <form action="{{ route('attendance.undo', $attendance->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm" style="margin-top:8px;">Undo / Ajukan Perubahan</button>
                                        </form>
                                    </div>
                                @else
                                    <div class="actions">
                                        <button type="button" class="btn-status btn-hadir" onclick="openModal({{ $schedule->id }}, 'hadir', @json($schedule->subject->name ?? '-'), '{{ $schedule->start_time }}', '{{ $schedule->end_time }}', '{{ $teacherName }}', '{{ $schedule->room ?? '-' }}')">Hadir</button>
                                        <button type="button" class="btn-status btn-sakit" onclick="openModal({{ $schedule->id }}, 'sakit', @json($schedule->subject->name ?? '-'), '{{ $schedule->start_time }}', '{{ $schedule->end_time }}', '{{ $teacherName }}', '{{ $schedule->room ?? '-' }}')">Sakit</button>
                                        <button type="button" class="btn-status btn-izin" onclick="openModal({{ $schedule->id }}, 'izin', @json($schedule->subject->name ?? '-'), '{{ $schedule->start_time }}', '{{ $schedule->end_time }}', '{{ $teacherName }}', '{{ $schedule->room ?? '-' }}')">Izin</button>
                                        <button type="button" class="btn-status btn-alpha" onclick="openModal({{ $schedule->id }}, 'alpha', @json($schedule->subject->name ?? '-'), '{{ $schedule->start_time }}', '{{ $schedule->end_time }}', '{{ $teacherName }}', '{{ $schedule->room ?? '-' }}')">Alpha</button>
                                    </div>
                                @endif
                    {{-- Bagian form absen manual dihapus, hanya tampil status jika sudah absen --}}
                    {{-- Sudah di-handle pada blok atas: jika $attendance, tampil status dan info; jika belum, tampil tombol aksi absen --}}
                    </article>
                    @endforeach
                </div>
            @endif
        </div>
    </main>
</div>

<div id="attendanceModal" class="modal">
    <div class="modal-box">
        <div class="modal-head">
            <h4 class="modal-title">Konfirmasi Absensi</h4>
            <button type="button" class="modal-close" onclick="closeModal()">&times;</button>
        </div>

        <form id="attendanceForm" method="POST" action="{{ route('absensi.store') }}" enctype="multipart/form-data" onsubmit="return validateAttendanceTime();">
            @csrf
            <div class="modal-body">
                <div class="group">
                    <label class="label">Mata Pelajaran</label>
                    <input id="mapelName" type="text" class="control" readonly>
                </div>
                <div class="group">
                    <label class="label">Guru</label>
                    <input id="teacherName" type="text" class="control" readonly>
                </div>
                <div class="group">
                    <label class="label">Jam</label>
                    <input id="scheduleTime" type="text" class="control" readonly>
                </div>
                <div class="group">
                    <label class="label">Ruang</label>
                    <input id="roomName" type="text" class="control" readonly>
                </div>
                <input id="scheduleId" name="schedule_id" type="hidden">
                <div class="group">
                    <label class="label">Status</label>
                    <input id="statusValue" name="status" type="hidden">
                    <input id="statusDisplay" type="text" class="control" readonly>
                </div>
                <div class="group">
                    <label class="label">Keterangan (Opsional)</label>
                    <textarea name="keterangan" class="control" rows="4" placeholder="Tambahkan keterangan jika perlu..."></textarea>
                </div>
                <div class="group" id="proofGroup" style="display:none;">
                    <label class="label">Upload Bukti (khusus Sakit/Izin)</label>
                    <input type="file" name="proof" id="proofInput" class="control" accept="image/*,application/pdf">
                </div>
                <div id="loadingIndicator" style="display:none;text-align:center;margin:10px 0;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengirim absensi...
                </div>
                <div id="feedbackArea"></div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn-modal btn-secondary" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-modal btn-primary" id="submitBtn">Simpan</button>
            </div>
        </form>
    </div>
        @endforeach
    @endif
</div>
@endsection

@push('scripts')
<script>
// Reminder jika ada sesi belum absen
window.addEventListener('DOMContentLoaded', function() {
    const notSubmitted = {{ $notSubmittedCount ?? 0 }};
    if (notSubmitted > 0) {
        setTimeout(() => {
            alert('Ada ' + notSubmitted + ' sesi yang belum diabsen hari ini!');
        }, 1200);
    }
});

function openModal(scheduleId, status, mapelName, startTime, endTime, teacherName, roomName) {
    const labels = {
        hadir: 'Hadir',
        sakit: '🤒 Sakit',
        izin: 'Izin',
        alpha: 'Alpha',
    };
    document.getElementById('mapelName').value = mapelName;
    document.getElementById('scheduleId').value = scheduleId;
    document.getElementById('statusValue').value = status;
    document.getElementById('statusDisplay').value = labels[status] || status;
    document.getElementById('teacherName').value = teacherName;
    document.getElementById('scheduleTime').value = startTime + ' - ' + endTime;
    document.getElementById('roomName').value = roomName === '-' ? 'Online' : roomName; // Default to 'Online' if room is '-'
    // Tampilkan upload bukti jika sakit/izin
    document.getElementById('proofGroup').style.display = (status === 'sakit' || status === 'izin') ? 'block' : 'none';
    document.getElementById('attendanceModal').classList.add('show');
}

function closeModal() {
    document.getElementById('attendanceModal').classList.remove('show');
}

// Loading indicator saat submit
document.getElementById('attendanceForm').addEventListener('submit', function() {
    document.getElementById('loadingIndicator').style.display = 'block';
    document.getElementById('submitBtn').disabled = true;
    document.getElementById('feedbackArea').innerHTML = ''; // Clear previous feedback
}

// Aksesibilitas: tombol bisa diakses keyboard
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});

// Feedback submit dekat tombol
function showFeedback(msg, isSuccess = true) {
    const area = document.getElementById('feedbackArea');
    area.innerHTML = `<div style="color:${isSuccess ? 'green':'red'};font-weight:700;">${msg}</div>`;
}
</script>
@endpush
