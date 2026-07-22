@extends('layouts.app')

@section('title', 'Riwayat Absensi - Travina Prima')

@section('content')
<div class="app">
    @include('partials.sidebar')
    <div class="main">
        <header class="topbar">
            <div>
                <div class="top-title">📊 Riwayat Absensi</div>
                <div class="top-sub">Rekap kehadiran per mapel untuk siswa</div>
            </div>
        </header>
        <div class="page">
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

.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 24px; }
.stat-box { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 16px; border-left: 4px solid var(--blue); }
.stat-box.sakit { border-left-color: var(--amber); }
.stat-box.izin { border-left-color: #0ea5e9; }
.stat-box.alpha { border-left-color: var(--red); }
.stat-val { font-size: 28px; font-weight: 800; }
.stat-lbl { font-size: 12px; color: var(--txt2); margin-top: 6px; }

.filter-box { background: var(--bg); padding: 16px; border-radius: 12px; margin-bottom: 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; align-items: end; }
.form-control { width: 100%; padding: 8px; border: 1px solid var(--border); border-radius: 6px; font-size: 12px; }
.btn-filter { padding: 8px 14px; background: var(--blue); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }

.table-wrapper { background: var(--card); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
table { width: 100%; border-collapse: collapse; }
thead th { padding: 12px 14px; background: #f9f9f9; border-bottom: 1px solid var(--border); font-size: 11px; font-weight: 700; text-transform: uppercase; }
tbody td { padding: 12px 14px; border-bottom: 1px solid #f5f5f5; font-size: 13px; }
tbody tr:hover { background: #f9f9f9; }

.badge { display: inline-block; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; }
.badge-green { background: #ecfdf5; color: var(--green); }
.badge-amber { background: #fffbeb; color: var(--amber); }
.badge-blue { background: #cffafe; color: #0891b2; }
.badge-red { background: #fef2f2; color: var(--red); }
.badge-gray { background: #f3f4f6; color: #6b7280; }

.empty { text-align: center; padding: 40px; color: var(--txt3); }
</style>

<div class="container">
    <div class="page-title">📊 Riwayat Absensi</div>
    <div class="page-sub">Rekaititik kehadiran Anda per mapel</div>

    <!-- Summary Stats -->
    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-val" style="color: var(--green);">{{ $summary['hadir'] ?? 0 }}</div>
            <div class="stat-lbl">✓ Hadir</div>
        </div>
        <div class="stat-box sakit">
            <div class="stat-val" style="color: var(--amber);">{{ $summary['sakit'] ?? 0 }}</div>
            <div class="stat-lbl">🤒 Sakit</div>
        </div>
        <div class="stat-box izin">
            <div class="stat-val" style="color: #0891b2;">{{ $summary['izin'] ?? 0 }}</div>
            <div class="stat-lbl">📝 Izin</div>
        </div>
        <div class="stat-box alpha">
            <div class="stat-val" style="color: var(--red);">{{ $summary['alpha'] ?? 0 }}</div>
            <div class="stat-lbl">✕ Bolos</div>
        </div>
    </div>

    <!-- Filter -->
    <form action="{{ route('attendance.history') }}" method="GET" class="filter-box">
        <div>
            <label style="font-size: 11px; color: var(--txt2); display: block; margin-bottom: 4px;">Dari Tanggal</label>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
        </div>
        <div>
            <label style="font-size: 11px; color: var(--txt2); display: block; margin-bottom: 4px;">Sampai Tanggal</label>
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
        </div>
        <div>
            <label style="font-size: 11px; color: var(--txt2); display: block; margin-bottom: 4px;">Status</label>
            <select name="status" class="form-control">
                <option value="">-- Semua --</option>
                <option value="hadir" @selected(request('status') === 'hadir')>✓ Hadir</option>
                <option value="sakit" @selected(request('status') === 'sakit')>🤒 Sakit</option>
                <option value="izin" @selected(request('status') === 'izin')>📝 Izin</option>
                <option value="alpha" @selected(request('status') === 'alpha')>✕ Bolos</option>
            </select>
        </div>
        <button type="submit" class="btn-filter">🔍 Filter</button>
    </form>

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
                        <th>Mapel</th>
                        <th>Guru</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $att)
                        <tr>
                            <td><strong>{{ $att->date->format('d/m/Y') }}</strong></td>
                            <td>{{ $att->schedule?->subject->name ?? '-' }}<br><span style="font-size: 11px; color: var(--txt2);">{{ $att->schedule?->subject->code ?? '-' }}</span></td>
                            <td>{{ $att->schedule?->teacher?->name ?? '-' }}</td>
                            <td>{{ $att->schedule?->start_time->format('H:i') ?? '-' }}</td>
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
                                @if($att->comment)
                                    <details style="cursor: pointer;">
                                        <summary style="color: var(--blue); font-weight: 600;">📝 Lihat</summary>
                                        <p style="margin-top: 8px; padding: 8px; background: #f0f7ff; border-radius: 4px; font-size: 12px;">{{ $att->comment }}</p>
                                    </details>
                                @else
                                    <span style="color: var(--txt3);">-</span>
                                @endif
                            </td>
                            <td>
                                @if($att->proof_path)
                                    <a href="{{ Storage::url($att->proof_path) }}" target="_blank" class="badge badge-blue" style="text-decoration: none;">Lihat Bukti</a>
                                @else
                                    <span style="color: var(--txt3);">-</span>
                                @endif
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
</div>
@endsection
