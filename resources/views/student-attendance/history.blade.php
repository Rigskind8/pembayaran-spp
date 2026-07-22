@extends('layouts.app')

@section('title', 'Riwayat Absensi - Travina Prima')

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
.stat-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 15px; margin-bottom: 25px; }
.stat-card { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 18px; text-align: center; }
.stat-val { font-size: 28px; font-weight: 800; line-height: 1; margin-bottom: 6px; }
.stat-lbl { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--txt2); }
.stat-hadir { border-left: 4px solid var(--green); }
.stat-sakit { border-left: 4px solid var(--amber); }
.stat-izin { border-left: 4px solid var(--blue); }
.stat-alpha { border-left: 4px solid var(--red); }
.stat-val.green { color: var(--green); }
.stat-val.amber { color: var(--amber); }
.stat-val.blue { color: var(--blue); }
.stat-val.red { color: var(--red); }
.filter-box { background: #f9f9f9; padding: 20px; border-radius: 12px; border-left: 4px solid var(--blue); margin-bottom: 25px; display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; align-items: end; }
.form-group { }
.form-label { display: block; margin-bottom: 6px; font-size: 12px; font-weight: 700; color: var(--txt); }
.form-control { width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 6px; font-size: 13px; }
.btn-filter { padding: 8px 16px; background: linear-gradient(135deg,var(--blue),#4f46e5); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }
table { width: 100%; border-collapse: collapse; }
thead { background: #f5f5f5; }
thead th { padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 700; color: var(--txt2); text-transform: uppercase; letter-spacing: .06em; border-bottom: 1px solid var(--border); }
tbody td { padding: 12px 16px; border-bottom: 1px solid #f5f5f5; font-size: 13px; }
tbody tr:hover { background: #f9f9f9; }
.badge { display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; }
.badge-green { background: #ecfdf5; color: var(--green); }
.badge-amber { background: #fffbeb; color: var(--amber); }
.badge-blue { background: #eff6ff; color: var(--blue); }
.badge-red { background: #fef2f2; color: var(--red); }
.badge-gray { background: #f3f4f6; color: #6b7280; }
.empty-state { padding: 40px 20px; text-align: center; color: var(--txt3); }
.empty-state i { font-size: 36px; margin-bottom: 10px; display: block; }
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
                <div class="top-title">📊 Riwayat Absensi</div>
                <div class="top-sub">Kelengkapan dan rekam jejak kehadiran Anda</div>
            </div>
        </header>

        <div class="page">
            <!-- Summary Cards -->
            <div class="stat-cards">
                <div class="stat-card stat-hadir">
                    <div class="stat-val green">{{ $summary['hadir'] ?? 0 }}</div>
                    <div class="stat-lbl">✓ Hadir</div>
                </div>
                <div class="stat-card stat-sakit">
                    <div class="stat-val amber">{{ $summary['sakit'] ?? 0 }}</div>
                    <div class="stat-lbl">🤒 Sakit</div>
                </div>
                <div class="stat-card stat-izin">
                    <div class="stat-val blue">{{ $summary['izin'] ?? 0 }}</div>
                    <div class="stat-lbl">📝 Izin</div>
                </div>
                <div class="stat-card stat-alpha">
                    <div class="stat-val red">{{ $summary['alpha'] ?? 0 }}</div>
                    <div class="stat-lbl">✕ Bolos</div>
                </div>
            </div>

            <!-- Filter -->
            <div class="filter-box">
                <form action="{{ route('attendance.history') }}" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; width: 100%; align-items: end;">
                    <div>
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
                    </div>
                    <div>
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
                    </div>
                    <div>
                        <label class="form-label">Status</label>
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
                                    <th>Mapel</th>
                                    <th>Guru</th>
                                    <th>Jam</th>
                                    <th>Status</th>
                                    <th>Komentar</th>
                                    <th>Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $attendance)
                                    <tr>
                                        <td style="font-weight: 600;">{{ $attendance->date->format('d/m/Y') }}</td>
                                        <td>
                                            <strong>{{ $attendance->schedule?->subject->name ?? '-' }}</strong><br>
                                            <span style="font-size: 11px; color: var(--txt2);">{{ $attendance->schedule?->subject->code ?? '-' }}</span>
                                        </td>
                                        <td style="color: var(--txt2);">{{ $attendance->schedule?->teacher?->name ?? '-' }}</td>
                                        <td style="font-size: 12px;">
                                            @if($attendance->schedule)
                                                {{ $attendance->schedule->start_time->format('H:i') }} - {{ $attendance->schedule->end_time->format('H:i') }}
                                            @else - @endif
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
                                                <details style="cursor: pointer;">
                                                    <summary>📝 Lihat</summary>
                                                    <p style=" margin-top: 8px; padding: 8px; background: #f9f9f9; border-radius: 4px; border-left: 3px solid var(--blue); font-size: 12px;">{{ $attendance->comment }}</p>
                                                </details>
                                            @else <span style="color: var(--txt3);">-</span> @endif
                                        </td>
                                        <td>
                                            @if($attendance->verification_status === 'pending')
                                                <span class="badge badge-gray">⏳ Pending</span>
                                            @elseif($attendance->verification_status === 'verified')
                                                <span class="badge badge-green">✓ Verified</span>
                                            @else
                                                <span class="badge badge-red">✕ Rejected</span>
                                            @endif
                                            @if($attendance->verification_note)
                                                <div style="margin-top: 5px; font-size: 11px; color: var(--txt2); padding: 5px; background: #f9f9f9; border-radius: 3px;">📌 {{ \Str::limit($attendance->verification_note, 50) }}</div>
                                            @endif
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
@endsection

