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

.page-wrap {
    padding: 24px;
    max-width: 1200px;
    margin: 0 auto;
}

.topbar-box {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 14px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.title {
    font-size: 28px;
    font-weight: 800;
    letter-spacing: -.02em;
    color: var(--text);
    margin: 0;
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
    padding: 8px 14px;
    border: 1px solid var(--line);
    border-radius: 999px;
    background: var(--card);
    color: var(--text);
    font-size: 13px;
    font-weight: 700;
}

.hero {
    border-radius: 20px;
    padding: 22px 24px;
    color: #f8fdff;
    margin-bottom: 20px;
    background: linear-gradient(135deg, #0369a1 0%, #0284c7 56%, #0ea5e9 100%);
    box-shadow: 0 16px 40px rgba(3, 105, 161, .28);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

.hero h2 {
    margin: 0 0 6px;
    font-size: 22px;
    font-weight: 800;
}

.hero p {
    margin: 0;
    opacity: .9;
    font-size: 13px;
}

.hero-stats {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.stat {
    background: rgba(255, 255, 255, .18);
    border: 1px solid rgba(255, 255, 255, .28);
    border-radius: 14px;
    padding: 10px 14px;
    text-align: center;
    min-width: 90px;
}

.stat strong {
    display: block;
    font-size: 22px;
    line-height: 1;
}

.stat span {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .06em;
    font-weight: 700;
}

.grid-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
    gap: 18px;
}

@media (max-width: 640px) {
    .grid-cards { grid-template-columns: 1fr; }
}

.card-schedule {
    border-radius: 18px;
    background: var(--card);
    border: 1px solid var(--line);
    box-shadow: var(--shadow);
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.card-head {
    background: #f8fafc;
    border-bottom: 1px solid var(--line);
    padding: 14px 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
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
    padding: 6px 12px;
    font-size: 11px;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    white-space: nowrap;
    gap: 5px;
}

.status-hadir { background: #ecfdf5; color: var(--ok); }
.status-sakit { background: #fffbeb; color: var(--warn); }
.status-izin { background: #dbeafe; color: var(--info); }
.status-alpha { background: #fef2f2; color: var(--danger); }
.status-empty { background: #f1f5f9; color: #475569; }

.card-body-content {
    padding: 18px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.info-list {
    display: grid;
    gap: 10px;
}

.info-row {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #334155;
    font-size: 13px;
}

.info-icon {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--brand-soft);
    color: var(--brand);
    font-size: 13px;
    flex-shrink: 0;
}

.actions-grid {
    margin-top: 18px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
}

@media (max-width: 440px) {
    .actions-grid { grid-template-columns: repeat(2, 1fr); }
}

.btn-status {
    border: 1px solid var(--line);
    border-radius: 12px;
    padding: 10px 6px;
    font-size: 12px;
    font-weight: 800;
    cursor: pointer;
    background: #ffffff;
    transition: all .2s ease;
    text-align: center;
}

.btn-status:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(15, 23, 42, .08);
}

.btn-hadir { color: #065f46; border-color: #a7f3d0; background: #ecfdf5; }
.btn-hadir:hover { background: #059669; color: #fff; border-color: #059669; }

.btn-sakit { color: #92400e; border-color: #fcd34d; background: #fffbeb; }
.btn-sakit:hover { background: #d97706; color: #fff; border-color: #d97706; }

.btn-izin { color: #1e40af; border-color: #bfdbfe; background: #eff6ff; }
.btn-izin:hover { background: #2563eb; color: #fff; border-color: #2563eb; }

.btn-alpha { color: #991b1b; border-color: #fecaca; background: #fef2f2; }
.btn-alpha:hover { background: #dc2626; color: #fff; border-color: #dc2626; }

.attendance-done {
    margin-top: 14px;
    padding: 12px;
    border-radius: 12px;
    background: #f8fafc;
    border: 1px solid var(--line);
    font-size: 12px;
}

.empty-state {
    border-radius: 18px;
    border: 1px solid var(--line);
    background: var(--card);
    text-align: center;
    padding: 40px 20px;
    color: var(--muted);
}

/* Modal Styling */
.modal-custom {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, .6);
    backdrop-filter: blur(4px);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 16px;
}

.modal-custom.is-open {
    display: flex;
}

.modal-card {
    width: 100%;
    max-width: 480px;
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 24px 60px rgba(15, 23, 42, .25);
    overflow: hidden;
    animation: modalPop .2s ease;
}

@keyframes modalPop {
    from { opacity: 0; transform: scale(.95); }
    to { opacity: 1; transform: scale(1); }
}

.modal-header-box {
    padding: 16px 20px;
    background: #f8fafc;
    border-bottom: 1px solid var(--line);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title-text {
    margin: 0;
    font-size: 17px;
    font-weight: 800;
    color: var(--text);
}

.modal-close-btn {
    border: none;
    background: transparent;
    font-size: 22px;
    color: var(--muted);
    cursor: pointer;
}

.modal-body-box {
    padding: 18px 20px;
}

.modal-group {
    margin-bottom: 14px;
}

.modal-label {
    display: block;
    margin-bottom: 6px;
    font-size: 12px;
    font-weight: 700;
    color: var(--muted);
}

.modal-input {
    width: 100%;
    border: 1px solid var(--line);
    border-radius: 10px;
    padding: 9px 12px;
    font-size: 13px;
    font-family: inherit;
    color: var(--text);
    background: #ffffff;
}

.modal-input[readonly] {
    background: #f8fafc;
}

.modal-footer-box {
    padding: 14px 20px;
    border-top: 1px solid var(--line);
    background: #f8fafc;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn-batal {
    padding: 9px 16px;
    border: 1px solid var(--line);
    border-radius: 10px;
    background: #ffffff;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
}

.btn-simpan {
    padding: 9px 20px;
    border: none;
    border-radius: 10px;
    background: var(--info);
    color: #ffffff;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
}
</style>
@endpush

@section('content')
<div class="page-wrap">
    <div class="topbar-box">
        <div>
            <h1 class="title">Absen Mapel Hari Ini</h1>
            <div class="subtitle">{{ $dayName }}, {{ \Carbon\Carbon::parse($today)->translatedFormat('d F Y') }} · Kelas <strong>{{ $student->class_id }}</strong> · NIS {{ $student->nis }}</div>
        </div>
        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('attendance.history') }}" class="btn btn-sm btn-outline-primary" style="border-radius: 999px; font-weight:700;">
                <i class="fas fa-history me-1"></i> Riwayat Absensi
            </a>
            <a href="{{ Route::has('schedule.index') ? route('schedule.index') : url('/jadwal') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 999px; font-weight:700;">
                <i class="fas fa-calendar-alt me-1"></i> Jadwal Pelajaran
            </a>
            <div class="chip">
                <i class="fas fa-user-graduate" style="color: var(--brand);"></i>
                {{ $student->name }}
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center mb-3" style="border-radius: 14px;">
            <i class="fas fa-check-circle me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center mb-3" style="border-radius: 14px;">
            <i class="fas fa-exclamation-circle me-2 fs-5"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger mb-3" style="border-radius: 14px;">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $totalSchedules = $schedules->count();
        $sudahAbsen = $attendances->count();
        $belumAbsen = max($totalSchedules - $sudahAbsen, 0);
    @endphp

    <section class="hero">
        <div>
            <h2>Presensi Harian Per Sesi</h2>
            <p>Klik salah satu status (Hadir, Sakit, Izin, atau Alpha) pada mapel yang dijadwalkan hari ini.</p>
        </div>
        <div class="hero-stats">
            <div class="stat"><strong>{{ $totalSchedules }}</strong><span>Total Sesi</span></div>
            <div class="stat"><strong>{{ $sudahAbsen }}</strong><span>Sudah Absen</span></div>
            <div class="stat"><strong>{{ $belumAbsen }}</strong><span>Belum Absen</span></div>
        </div>
    </section>

    @if($schedules->isEmpty())
        <div class="empty-state">
            <i class="fas fa-calendar-times mb-2" style="font-size: 36px; color: var(--muted);"></i>
            <h5 class="fw-bold mb-1">Tidak Ada Jadwal Pelajaran Hari Ini</h5>
            <p class="text-muted mb-0">Tidak ada jadwal mapel aktif untuk kelas <strong>{{ $student->class_id }}</strong> pada hari <strong>{{ $dayName }}</strong>.</p>
        </div>
    @else
        <div class="grid-cards">
            @foreach($schedules as $schedule)
                @php
                    $attendance = $attendances->get($schedule->id);
                    $status = $attendance?->status;
                    $teacherName = $schedule->teacher?->name
                        ?? $schedule->subject?->teacher
                        ?? 'Guru Belum Diset';
                    $startTime = \Carbon\Carbon::parse($schedule->start_time)->format('H:i');
                    $endTime = \Carbon\Carbon::parse($schedule->end_time)->format('H:i');
                    $roomName = $schedule->room ?: 'Kelas ' . $student->class_id;
                    $mapelName = $schedule->subject?->name ?? 'Mata Pelajaran';
                    $mapelCode = $schedule->subject?->code ?? '-';
                @endphp

                <div class="card-schedule">
                    <div class="card-head">
                        <div>
                            <div class="subject-name">{{ $mapelName }}</div>
                            <div class="subject-code">{{ $mapelCode }}</div>
                        </div>
                        <span class="status-badge {{ $status ? 'status-' . $status : 'status-empty' }}">
                            @if($status === 'hadir') <i class="fas fa-check-circle"></i> Hadir
                            @elseif($status === 'sakit') <i class="fas fa-thermometer-half"></i> Sakit
                            @elseif($status === 'izin') <i class="fas fa-envelope-open-text"></i> Izin
                            @elseif($status === 'alpha') <i class="fas fa-times-circle"></i> Alpha
                            @else <i class="fas fa-clock"></i> Belum Absen
                            @endif
                        </span>
                    </div>

                    <div class="card-body-content">
                        <div class="info-list">
                            <div class="info-row">
                                <div class="info-icon"><i class="fas fa-clock"></i></div>
                                <div><strong>{{ $startTime }} - {{ $endTime }} WIB</strong></div>
                            </div>
                            <div class="info-row">
                                <div class="info-icon"><i class="fas fa-user-tie"></i></div>
                                <div>{{ $teacherName }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-icon"><i class="fas fa-location-dot"></i></div>
                                <div>Ruang: {{ $roomName }}</div>
                            </div>
                        </div>

                        @if($attendance)
                            <div class="attendance-done">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted">Status Presensi:</span>
                                    <strong class="text-capitalize text-{{ $status === 'hadir' ? 'success' : ($status === 'alpha' ? 'danger' : 'warning') }}">
                                        {{ $status }}
                                    </strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Verifikasi Guru:</span>
                                    @if($attendance->verification_status === 'verified')
                                        <span class="badge bg-success">Terverifikasi</span>
                                    @elseif($attendance->verification_status === 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                    @endif
                                </div>
                                @if($attendance->comment)
                                    <div class="text-muted small mb-2">Keterangan: {{ $attendance->comment }}</div>
                                @endif

                                @if(!in_array((string)$attendance->verification_status, ['verified', 'rejected'], true))
                                    <form action="{{ route('attendance.undo', $attendance->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan absensi ini untuk mengisi ulang?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-warning w-100 fw-bold">
                                            <i class="fas fa-rotate-left me-1"></i> Ajukan Perubahan (Undo)
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @else
                            <div class="actions-grid">
                                <button type="button" class="btn-status btn-hadir" data-schedule-id="{{ $schedule->id }}" data-status="hadir" data-mapel="{{ $mapelName }}" data-time="{{ $startTime }} - {{ $endTime }}" data-teacher="{{ $teacherName }}" data-room="{{ $roomName }}">
                                    ✓ Hadir
                                </button>
                                <button type="button" class="btn-status btn-sakit" data-schedule-id="{{ $schedule->id }}" data-status="sakit" data-mapel="{{ $mapelName }}" data-time="{{ $startTime }} - {{ $endTime }}" data-teacher="{{ $teacherName }}" data-room="{{ $roomName }}">
                                    🤒 Sakit
                                </button>
                                <button type="button" class="btn-status btn-izin" data-schedule-id="{{ $schedule->id }}" data-status="izin" data-mapel="{{ $mapelName }}" data-time="{{ $startTime }} - {{ $endTime }}" data-teacher="{{ $teacherName }}" data-room="{{ $roomName }}">
                                    📝 Izin
                                </button>
                                <button type="button" class="btn-status btn-alpha" data-schedule-id="{{ $schedule->id }}" data-status="alpha" data-mapel="{{ $mapelName }}" data-time="{{ $startTime }} - {{ $endTime }}" data-teacher="{{ $teacherName }}" data-room="{{ $roomName }}">
                                    ✕ Alpha
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modal Konfirmasi Absensi (Diletakkan sekali di luar loop) -->
<div id="attendanceModal" class="modal-custom" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-card">
        <div class="modal-header-box">
            <h5 class="modal-title-text" id="modalTitle">Konfirmasi Absensi Mapel</h5>
            <button type="button" class="modal-close-btn" id="btnModalClose" aria-label="Tutup">&times;</button>
        </div>

        <form id="attendanceForm" method="POST" action="{{ route('absensi.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="scheduleId" name="schedule_id">
            <input type="hidden" id="statusValue" name="status">

            <div class="modal-body-box">
                <div class="modal-group">
                    <label class="modal-label">Mata Pelajaran</label>
                    <input type="text" id="mapelName" class="modal-input" readonly>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <label class="modal-label">Guru Pengajar</label>
                        <input type="text" id="teacherName" class="modal-input" readonly>
                    </div>
                    <div class="col-6">
                        <label class="modal-label">Waktu Sesi</label>
                        <input type="text" id="scheduleTime" class="modal-input" readonly>
                    </div>
                </div>
                <div class="modal-group">
                    <label class="modal-label">Status Presensi Dipilih</label>
                    <input type="text" id="statusDisplay" class="modal-input fw-bold" readonly>
                </div>
                <div class="modal-group">
                    <label class="modal-label">Keterangan (Opsional)</label>
                    <textarea name="keterangan" id="keteranganInput" class="modal-input" rows="3" placeholder="Tuliskan keterangan jika sakit/izin atau catatan tambahan..."></textarea>
                </div>
                <div class="modal-group" id="proofGroup" style="display:none;">
                    <label class="modal-label text-danger">Upload Surat / Bukti (Format: JPG, PNG, PDF max 2MB)</label>
                    <input type="file" name="proof" id="proofInput" class="modal-input" accept="image/jpeg,image/png,application/pdf">
                </div>
            </div>

            <div class="modal-footer-box">
                <button type="button" class="btn-batal" id="btnModalBatal">Batal</button>
                <button type="submit" class="btn-simpan" id="submitBtn">Kirim Presensi</button>
            </div>
        </form>
    </div>
</div>

<script>
(function() {
    function initAttendance() {
        const modal = document.getElementById('attendanceModal');
        const form = document.getElementById('attendanceForm');
        const scheduleIdInput = document.getElementById('scheduleId');
        const statusValueInput = document.getElementById('statusValue');
        const statusDisplayInput = document.getElementById('statusDisplay');
        const mapelNameInput = document.getElementById('mapelName');
        const teacherNameInput = document.getElementById('teacherName');
        const scheduleTimeInput = document.getElementById('scheduleTime');
        const proofGroup = document.getElementById('proofGroup');
        const keteranganInput = document.getElementById('keteranganInput');
        const btnClose = document.getElementById('btnModalClose');
        const btnBatal = document.getElementById('btnModalBatal');

        if (!modal) return;

        function openModal(scheduleId, status, mapel, time, teacher, room) {
            scheduleIdInput.value = scheduleId;
            statusValueInput.value = status;
            
            const labels = {
                hadir: '✓ Hadir',
                sakit: '🤒 Sakit',
                izin: '📝 Izin',
                alpha: '✕ Alpha'
            };
            statusDisplayInput.value = labels[status] || status;
            mapelNameInput.value = mapel;
            teacherNameInput.value = teacher;
            scheduleTimeInput.value = time + ' (' + room + ')';
            keteranganInput.value = '';

            if (status === 'sakit' || status === 'izin') {
                proofGroup.style.display = 'block';
            } else {
                proofGroup.style.display = 'none';
            }

            modal.classList.add('is-open');
        }

        function closeModal() {
            modal.classList.remove('is-open');
        }

        document.querySelectorAll('.btn-status').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-schedule-id');
                const st = this.getAttribute('data-status');
                const mp = this.getAttribute('data-mapel');
                const tm = this.getAttribute('data-time');
                const tc = this.getAttribute('data-teacher');
                const rm = this.getAttribute('data-room');
                openModal(id, st, mp, tm, tc, rm);
            });
        });

        if (btnClose) btnClose.addEventListener('click', closeModal);
        if (btnBatal) btnBatal.addEventListener('click', closeModal);

        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('is-open')) {
                closeModal();
            }
        });

        form.addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerText = 'Menyimpan...';
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAttendance);
    } else {
        initAttendance();
    }
})();
</script>
@endsection
