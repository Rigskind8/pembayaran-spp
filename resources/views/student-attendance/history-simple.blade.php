@extends('layouts.app')

@section('title', 'Riwayat Absensi - ' . config('app.name', 'SMK Travina Prima'))

@push('styles')
<style>
:root {
    --bg-page: #f8fafc;
    --card-bg: #ffffff;
    --line: #e2e8f0;
    --text-main: #0f172a;
    --text-muted: #64748b;
    --brand-blue: #2563eb;
    --brand-green: #059669;
    --brand-amber: #d97706;
    --brand-red: #dc2626;
    --brand-sky: #0284c7;
    --shadow-soft: 0 10px 25px -5px rgba(15, 23, 42, .06), 0 8px 10px -6px rgba(15, 23, 42, .04);
}

.history-wrap {
    padding: 24px;
    max-width: 1200px;
    margin: 0 auto;
}

.history-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 16px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.history-title {
    font-size: 28px;
    font-weight: 800;
    letter-spacing: -.02em;
    color: var(--text-main);
    margin: 0 0 4px;
}

.history-sub {
    color: var(--text-muted);
    font-size: 13px;
    margin: 0;
}

/* Stats Cards */
.stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

@media (max-width: 900px) {
    .stats-row { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 480px) {
    .stats-row { grid-template-columns: 1fr; }
}

.stat-card-modern {
    background: var(--card-bg);
    border: 1px solid var(--line);
    border-radius: 18px;
    padding: 18px 20px;
    box-shadow: var(--shadow-soft);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: transform .2s ease, box-shadow .2s ease;
}

.stat-card-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 28px -4px rgba(15, 23, 42, .1);
}

.stat-icon-wrap {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.stat-hadir .stat-icon-wrap { background: #ecfdf5; color: var(--brand-green); }
.stat-sakit .stat-icon-wrap { background: #fffbeb; color: var(--brand-amber); }
.stat-izin .stat-icon-wrap { background: #f0f9ff; color: var(--brand-sky); }
.stat-alpha .stat-icon-wrap { background: #fef2f2; color: var(--brand-red); }

.stat-num-val {
    font-size: 28px;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 4px;
}

.stat-lbl-text {
    font-size: 12px;
    font-weight: 700;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: .05em;
}

/* Filter Card */
.filter-card {
    background: var(--card-bg);
    border: 1px solid var(--line);
    border-radius: 18px;
    padding: 18px 22px;
    margin-bottom: 24px;
    box-shadow: var(--shadow-soft);
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)) 120px auto;
    gap: 14px;
    align-items: flex-end;
}

@media (max-width: 768px) {
    .filter-grid { grid-template-columns: 1fr; }
}

.form-label-custom {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: var(--text-muted);
    margin-bottom: 6px;
}

.form-input-custom {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid var(--line);
    border-radius: 10px;
    font-size: 13px;
    font-family: inherit;
    color: var(--text-main);
    background: #ffffff;
}

.form-input-custom:focus {
    outline: none;
    border-color: var(--brand-blue);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
}

/* Table Card */
.table-card-modern {
    background: var(--card-bg);
    border: 1px solid var(--line);
    border-radius: 20px;
    box-shadow: var(--shadow-soft);
    overflow: hidden;
}

.table-custom {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
}

.table-custom thead th {
    background: #f8fafc;
    color: var(--text-muted);
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .06em;
    padding: 14px 18px;
    border-bottom: 1px solid var(--line);
}

.table-custom tbody td {
    padding: 14px 18px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    vertical-align: middle;
}

.table-custom tbody tr:hover {
    background: #f8fbff;
}

.table-custom tbody tr:last-child td {
    border-bottom: none;
}

/* Badges */
.badge-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 800;
    white-space: nowrap;
}

.badge-hadir { background: #ecfdf5; color: var(--brand-green); border: 1px solid #a7f3d0; }
.badge-sakit { background: #fffbeb; color: var(--brand-amber); border: 1px solid #fde68a; }
.badge-izin { background: #f0f9ff; color: var(--brand-sky); border: 1px solid #bae6fd; }
.badge-alpha { background: #fef2f2; color: var(--brand-red); border: 1px solid #fecaca; }

.badge-verify-verified { background: #ecfdf5; color: #047857; font-size: 11px; font-weight: 700; border-radius: 6px; padding: 3px 8px; }
.badge-verify-rejected { background: #fef2f2; color: #b91c1c; font-size: 11px; font-weight: 700; border-radius: 6px; padding: 3px 8px; }
.badge-verify-pending { background: #fffbeb; color: #b45309; font-size: 11px; font-weight: 700; border-radius: 6px; padding: 3px 8px; }

.btn-proof {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 8px;
    background: #eff6ff;
    color: var(--brand-blue);
    font-size: 11px;
    font-weight: 700;
    text-decoration: none;
    border: 1px solid #bfdbfe;
    transition: all .15s ease;
}

.btn-proof:hover {
    background: var(--brand-blue);
    color: #ffffff;
}

.empty-state-box {
    text-align: center;
    padding: 48px 24px;
    color: var(--text-muted);
}
</style>
@endpush

@section('content')
<div class="history-wrap">
    <!-- Header -->
    <div class="history-header">
        <div>
            <h1 class="history-title">Riwayat Absensi Siswa</h1>
            <p class="history-sub">Rekapitulasi kehadiran mata pelajaran untuk <strong>{{ $student->name }}</strong> (Kelas {{ $student->class_id }})</p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('student.attendance.today') }}" class="btn btn-primary btn-sm" style="border-radius: 999px; font-weight: 700; padding: 8px 16px;">
                <i class="fas fa-calendar-check me-1"></i> Absen Hari Ini
            </a>
            <a href="{{ Route::has('schedule.index') ? route('schedule.index') : url('/jadwal') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 999px; font-weight: 700; padding: 8px 16px;">
                <i class="fas fa-book-open me-1"></i> Jadwal Pelajaran
            </a>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="stats-row">
        <div class="stat-card-modern stat-hadir">
            <div class="stat-icon-wrap"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="stat-num-val" style="color: var(--brand-green);">{{ $summary['hadir'] ?? 0 }}</div>
                <div class="stat-lbl-text">Total Hadir</div>
            </div>
        </div>
        <div class="stat-card-modern stat-sakit">
            <div class="stat-icon-wrap"><i class="fas fa-thermometer-half"></i></div>
            <div>
                <div class="stat-num-val" style="color: var(--brand-amber);">{{ $summary['sakit'] ?? 0 }}</div>
                <div class="stat-lbl-text">Sakit</div>
            </div>
        </div>
        <div class="stat-card-modern stat-izin">
            <div class="stat-icon-wrap"><i class="fas fa-envelope-open-text"></i></div>
            <div>
                <div class="stat-num-val" style="color: var(--brand-sky);">{{ $summary['izin'] ?? 0 }}</div>
                <div class="stat-lbl-text">Izin</div>
            </div>
        </div>
        <div class="stat-card-modern stat-alpha">
            <div class="stat-icon-wrap"><i class="fas fa-times-circle"></i></div>
            <div>
                <div class="stat-num-val" style="color: var(--brand-red);">{{ $summary['alpha'] ?? 0 }}</div>
                <div class="stat-lbl-text">Alpha / Bolos</div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="filter-card">
        <form action="{{ route('attendance.history') }}" method="GET" class="filter-grid">
            <div>
                <label class="form-label-custom">Dari Tanggal</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-input-custom">
            </div>
            <div>
                <label class="form-label-custom">Sampai Tanggal</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-input-custom">
            </div>
            <div>
                <label class="form-label-custom">Status Presensi</label>
                <select name="status" class="form-input-custom">
                    <option value="">-- Semua Status --</option>
                    <option value="hadir" @selected(request('status') === 'hadir')>✓ Hadir</option>
                    <option value="sakit" @selected(request('status') === 'sakit')>🤒 Sakit</option>
                    <option value="izin" @selected(request('status') === 'izin')>📝 Izin</option>
                    <option value="alpha" @selected(request('status') === 'alpha')>✕ Alpha</option>
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-primary w-100" style="border-radius: 10px; font-weight: 700; padding: 9px 14px;">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
            </div>
            @if(request()->filled('from_date') || request()->filled('to_date') || request()->filled('status'))
                <div>
                    <a href="{{ route('attendance.history') }}" class="btn btn-outline-secondary w-100" style="border-radius: 10px; font-weight: 700; padding: 9px 14px;">
                        Reset
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="table-card-modern">
        @if($attendances->isEmpty())
            <div class="empty-state-box">
                <i class="fas fa-clipboard-list mb-3" style="font-size: 40px; color: var(--line);"></i>
                <h5 class="fw-bold mb-1">Belum Ada Data Absensi</h5>
                <p class="mb-0 text-muted">Data presensi Anda belum tercatat atau tidak ada data yang cocok dengan filter tanggal.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Mata Pelajaran</th>
                            <th>Guru Pengajar</th>
                            <th>Waktu Sesi</th>
                            <th>Status Presensi</th>
                            <th>Verifikasi</th>
                            <th>Keterangan / Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $att)
                            @php
                                $attDate = \Carbon\Carbon::parse($att->date)->translatedFormat('d M Y');
                                $subjectName = $att->schedule?->subject?->name ?? 'Mata Pelajaran';
                                $subjectCode = $att->schedule?->subject?->code ?? '-';
                                $teacherName = $att->schedule?->teacher?->name
                                    ?? $att->schedule?->subject?->teacher
                                    ?? '-';
                                $startTime = $att->schedule?->start_time ? substr((string)$att->schedule->start_time, 0, 5) : '-';
                                $endTime = $att->schedule?->end_time ? substr((string)$att->schedule->end_time, 0, 5) : '-';
                            @endphp
                            <tr>
                                <td><strong>{{ $attDate }}</strong></td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $subjectName }}</div>
                                    <div class="text-muted small">{{ $subjectCode }}</div>
                                </td>
                                <td>{{ $teacherName }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $startTime }} - {{ $endTime }}</span>
                                </td>
                                <td>
                                    @if($att->status === 'hadir')
                                        <span class="badge-pill badge-hadir"><i class="fas fa-check-circle"></i> Hadir</span>
                                    @elseif($att->status === 'sakit')
                                        <span class="badge-pill badge-sakit"><i class="fas fa-thermometer-half"></i> Sakit</span>
                                    @elseif($att->status === 'izin')
                                        <span class="badge-pill badge-izin"><i class="fas fa-envelope-open-text"></i> Izin</span>
                                    @else
                                        <span class="badge-pill badge-alpha"><i class="fas fa-times-circle"></i> Alpha</span>
                                    @endif
                                </td>
                                <td>
                                    @if($att->verification_status === 'verified')
                                        <span class="badge-verify-verified"><i class="fas fa-check me-1"></i> Terverifikasi</span>
                                    @elseif($att->verification_status === 'rejected')
                                        <span class="badge-verify-rejected"><i class="fas fa-times me-1"></i> Ditolak</span>
                                    @else
                                        <span class="badge-verify-pending"><i class="fas fa-clock me-1"></i> Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    @if($att->comment)
                                        <div class="small text-muted mb-1">{{ $att->comment }}</div>
                                    @endif
                                    @if($att->proof_path)
                                        <a href="{{ asset('storage/' . $att->proof_path) }}" target="_blank" class="btn-proof" rel="noopener">
                                            <i class="fas fa-paperclip"></i> Lihat Bukti
                                        </a>
                                    @elseif(!$att->comment)
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($attendances->hasPages())
                <div class="p-3 border-top d-flex justify-content-center">
                    {{ $attendances->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
