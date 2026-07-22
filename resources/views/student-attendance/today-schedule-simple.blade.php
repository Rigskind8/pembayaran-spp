@extends('layouts.app')

@section('title', 'Absen Mapel - Travina Prima')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root {
    --blue: #2563eb; --green: #059669; --amber: #d97706; --red: #dc2626;
    --bg: #f4f6fa; --card: #fff; --border: #e8eaf0;
    --txt: #111827; --txt2: #6b7280; --txt3: #9ca3af;
}

.container-attendance { max-width: 1200px; margin: 0 auto; padding: 20px; }
.page-title { font-size: 24px; font-weight: 800; margin-bottom: 8px; color: var(--txt); }
.page-sub { font-size: 14px; color: var(--txt2); margin-bottom: 24px; }

.schedule-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px; margin-bottom: 24px; }

.schedule-card { 
    background: var(--card); border: 1px solid var(--border); border-radius: 16px; 
    padding: 18px; cursor: pointer; transition: all .2s;
    border-left: 4px solid var(--blue);
}
.schedule-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.1); transform: translateY(-2px); }

.schedule-card.hadir { border-left-color: var(--green); }
.schedule-card.sakit { border-left-color: var(--amber); }
.schedule-card.izin{ border-left-color: #0ea5e9; }
.schedule-card.alpha { border-left-color: var(--red); }

.card-header { display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px; }
.mapel-name { font-size: 16px; font-weight: 700; color: var(--txt); }
.status-badge { font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 6px; }
.status-badge.hadir { background: #ecfdf5; color: var(--green); }
.status-badge.sakit { background: #fffbeb; color: var(--amber); }
.status-badge.izin { background: #cffafe; color: #0891b2; }
.status-badge.alpha { background: #fef2f2; color: var(--red); }

.card-info { color: var(--txt2); font-size: 13px; margin: 10px 0; }
.card-footer { margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--border); display: flex; gap: 8px; }
.btn-small { padding: 8px 12px; font-size: 12px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; transition: all .2s; }
.btn-primary-small { background: var(--blue); color: white; }
.btn-primary-small:hover { background: #1d4ed8; }

.modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
.modal.show { display: flex; }
.modal-content { background: white; border-radius: 16px; padding: 28px; max-width: 500px; width: 95%; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
.modal-header { font-size: 18px; font-weight: 800; margin-bottom: 20px; }
.form-group { margin-bottom: 16px; }
.form-label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 6px; color: var(--txt); }
.form-control { width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px; font-family: inherit; }
.form-control:focus { outline: none; border-color: var(--blue); box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
.modal-footer { display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px; }
.btn-modal { padding: 10px 18px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; }
.btn-cancel { background: #e5e7eb; color: var(--txt); }
.btn-submit { background: var(--blue); color: white; }
</style>

<div class="container-attendance">
    <div class="page-title">📋 Absen Mapel Hari Ini</div>
    <div class="page-sub">{{ $dayName }}, {{ $today->format('d M Y') }}</div>

    @if($schedules->isEmpty())
        <div style="background: var(--bg); padding: 40px; border-radius: 12px; text-align: center; color: var(--txt3);">
            <p style="font-size: 16px;">Tidak ada jadwal mapel hari ini</p>
        </div>
    @else
        <div class="schedule-grid">
            @foreach($schedules as $schedule)
                @php
                    $attendance = $attendances[$schedule->id] ?? null;
                    $status = $attendance?->status ?? null;
                    $statusClass = ['hadir' => 'hadir', 'sakit' => 'sakit', 'izin' => 'izin', 'alpha' => 'alpha'][$status] ?? '';
                @endphp
                <div class="schedule-card {{ $statusClass }}">
                    <div class="card-header">
                        <div class="mapel-name">{{ $schedule->subject->name }}</div>
                        @if($status)
                            <span class="status-badge {{ $statusClass }}">
                                @if($status === 'hadir')✓ Hadir
                                @elseif($status === 'sakit')🤒 Sakit
                                @elseif($status === 'izin')📝 Izin
                                @else✕ Bolos
                                @endif
                            </span>
                        @else
                            <span class="status-badge" style="background: #f3f4f6; color: #6b7280;">Belum</span>
                        @endif
                    </div>
                    
                    <div class="card-info">
                        <div>⏰ {{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</div>
                        @php
                            $teacherName = $schedule->teacher?->name
                                ?? $schedule->subject->teacher
                                ?? '-';
                        @endphp
                        <div>👨‍🏫 {{ $teacherName }}</div>
                        <div>📍 Ruang {{ $schedule->room ?? '-' }}</div>
                    </div>

                    @if($attendance?->comment)
                        <div style="background: var(--bg); padding: 10px; border-radius: 8px; margin: 10px 0; font-size: 12px; color: var(--txt2);">
                            📝 <strong>Komentar:</strong> {{ $attendance->comment }}
                        </div>
                    @endif

                    <div class="card-footer">
                        <button onclick="openModal({{ $schedule->id }}, '{{ $schedule->subject->name }}', '{{ $status ?? '' }}')" class="btn-small btn-primary-small">
                            {{ $status ? '✎ Ubah' : '✓ Absen' }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modal Absen -->
<div id="attendanceModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">Pilih Status Absensi</div>
        <form id="attendanceForm" method="POST" style="display: flex; flex-direction: column;">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Status</label>
                <select id="statusSelect" name="status" class="form-control" required>
                    <option value="hadir">✓ Hadir</option>
                    <option value="sakit">🤒 Sakit</option>
                    <option value="izin">📝 Izin</option>
                    <option value="alpha">✕ Bolos</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Komentar (opsional)</label>
                <textarea id="commentInput" name="comment" class="form-control" rows="4" placeholder="Tulis komentar tentang guru atau alasan absen..."></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-modal btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-modal btn-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
let currentScheduleId = null;

function openModal(scheduleId, mapelName, status) {
    currentScheduleId = scheduleId;
    document.getElementById('statusSelect').value = status || 'hadir';
    document.getElementById('commentInput').value = '';
    document.getElementById('attendanceForm').action = `/absen-mapel/${scheduleId}`;
    document.getElementById('attendanceModal').classList.add('show');
}

function closeModal() {
    document.getElementById('attendanceModal').classList.remove('show');
}

document.getElementById('attendanceModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endsection
