@extends('layouts.app')

@section('title', 'Jadwal Mata Pelajaran')

@push('styles')
<style>
:root {
  --bg: #f3f6fb;
  --card: #ffffff;
  --line: #e2e8f0;
  --text: #0f172a;
  --muted: #64748b;
  --brand: #0f766e;
  --brand2: #14b8a6;
  --brand-soft: #ccfbf1;
  --ok: #059669;
  --warn: #d97706;
  --danger: #dc2626;
  --indigo: #4f46e5;
  --shadow: 0 14px 34px rgba(15, 23, 42, .08);
}

html, body {
  overflow-x: hidden;
}

.schedules-wrapper {
  min-height: 100vh;
  width: 100%;
  max-width: 100%;
  box-sizing: border-box;
  overflow-x: hidden;
  background: radial-gradient(circle at 90% 0%, rgba(20, 184, 166, .13), transparent 30%), var(--bg);
}

.page-wrap {
  padding: 16px 24px 24px;
  width: 100%;
  box-sizing: border-box;
}

.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 12px;
  margin-bottom: 18px;
}

.top-title {
  font-size: 30px;
  line-height: 1.1;
  font-weight: 800;
  letter-spacing: -.02em;
  color: var(--text);
}

.top-sub {
  margin-top: 4px;
  color: var(--muted);
  font-size: 13px;
}

.top-chip {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 12px;
  border-radius: 999px;
  border: 1px solid var(--line);
  background: var(--card);
  color: var(--muted);
  font-size: 12px;
  font-weight: 700;
}

.hero {
  border-radius: 24px;
  background: linear-gradient(135deg, #0f766e 0%, #14b8a6 58%, #2dd4bf 100%);
  color: #f8fffe;
  box-shadow: 0 16px 44px rgba(15, 118, 110, .28);
  padding: 22px 24px;
  margin-bottom: 16px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
}

.hero h2 {
  margin: 0 0 5px;
  font-size: 24px;
  font-weight: 800;
}

.hero p {
  margin: 0;
  opacity: .92;
  font-size: 13px;
}

.hero-stats {
  display: grid;
  grid-template-columns: repeat(4, minmax(92px, 1fr));
  gap: 8px;
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
  display: block;
  margin-top: 3px;
  font-size: 10px;
  text-transform: uppercase;
  letter-spacing: .08em;
  font-weight: 700;
}

.day-nav {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  margin: 14px 0 16px;
}

.day-tab {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  text-decoration: none;
  padding: 8px 13px;
  border-radius: 999px;
  border: 1px solid var(--line);
  background: var(--card);
  color: #475569;
  font-size: 12px;
  font-weight: 700;
  transition: .15s ease;
}

.day-tab:hover {
  border-color: #99f6e4;
  color: #0f766e;
}

.day-tab.active {
  background: var(--brand);
  border-color: var(--brand);
  color: #ecfeff;
}

.day-count {
  border-radius: 999px;
  padding: 2px 7px;
  font-size: 10px;
  font-weight: 800;
  background: #f1f5f9;
  color: #64748b;
}

.day-tab.active .day-count {
  background: rgba(255, 255, 255, .2);
  color: #ffffff;
}

.section-head {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 10px;
  margin-bottom: 12px;
}

.section-title {
  font-size: 18px;
  font-weight: 800;
  color: var(--text);
}

.section-sub {
  margin-top: 3px;
  font-size: 12px;
  color: var(--muted);
}

.badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  border-radius: 999px;
  padding: 6px 11px;
  font-size: 11px;
  font-weight: 700;
  background: #eef2ff;
  border: 1px solid #c7d2fe;
  color: #4338ca;
}

.grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 14px;
}

.schedule-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(280px, 1fr));
  gap: 16px;
}

@media (max-width: 1200px) {
  .schedule-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}

@media (max-width: 760px) {
  .schedule-grid { grid-template-columns: 1fr; }
}

.card {
  border-radius: 18px;
  border: 1px solid var(--line);
  background: var(--card);
  box-shadow: var(--shadow);
  overflow: hidden;
}

.sc-head {
  background: #f8fafc;
  border-bottom: 1px solid var(--line);
  padding: 14px 16px;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 10px;
}

.sc-name {
  margin: 0;
  font-size: 16px;
  font-weight: 800;
  color: var(--text);
}

.sc-code {
  margin-top: 2px;
  color: var(--muted);
  font-size: 11px;
}

.sc-time {
  border-radius: 999px;
  padding: 6px 10px;
  background: #ecfeff;
  color: #0e7490;
  border: 1px solid #a5f3fc;
  font-size: 11px;
  font-weight: 800;
}

.sc-body {
  padding: 14px 16px;
}

.sc-info {
  display: grid;
  gap: 8px;
}

.sc-row {
  display: grid;
  grid-template-columns: 26px 1fr;
  gap: 10px;
  align-items: center;
  color: #334155;
  font-size: 13px;
}

.ic {
  width: 26px;
  height: 26px;
  border-radius: 8px;
  background: var(--brand-soft);
  color: var(--brand);
  display: grid;
  place-items: center;
  font-size: 12px;
}

.sc-foot {
  margin-top: 12px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.absen-btn {
  flex: 1;
  border: none;
  border-radius: 12px;
  padding: 11px 12px;
  background: linear-gradient(135deg, var(--indigo), #4338ca);
  color: #f8fafc;
  font-size: 12px;
  font-weight: 800;
  cursor: pointer;
  transition: .15s ease;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 7px;
}

.absen-btn:hover:not(:disabled) {
  transform: translateY(-1px);
  box-shadow: 0 10px 20px rgba(67, 56, 202, .25);
}

.absen-btn.done,
.absen-btn:disabled {
  background: #ecfdf5;
  color: var(--ok);
  border: 1px solid #a7f3d0;
  box-shadow: none;
  cursor: default;
}

.absen-status {
  font-size: 11px;
  color: var(--muted);
  font-weight: 700;
}

.st-hadir { color: var(--ok); }
.st-izin { color: var(--warn); }
.st-sakit { color: var(--danger); }

.empty {
  border: 1px dashed #cbd5e1;
  border-radius: 16px;
  padding: 28px 16px;
  text-align: center;
  color: var(--muted);
}

.riwayat {
  margin-top: 6px;
}

.r-head {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
  margin-bottom: 10px;
}

.r-title {
  font-size: 18px;
  font-weight: 800;
  color: var(--text);
}

.filters {
  display: flex;
  gap: 6px;
  flex-wrap: wrap;
}

.rf {
  text-decoration: none;
  border: 1px solid var(--line);
  border-radius: 999px;
  padding: 6px 11px;
  background: var(--card);
  color: #475569;
  font-size: 11px;
  font-weight: 700;
}

.rf.active {
  background: var(--brand);
  border-color: var(--brand);
  color: #ecfeff;
}

.rsum {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 8px;
  margin-bottom: 10px;
}

@media (max-width: 760px) {
  .rsum { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}

.rbox {
  border-radius: 14px;
  border: 1px solid var(--line);
  background: #ffffff;
  padding: 10px 12px;
  display: flex;
  align-items: center;
  gap: 9px;
}

.rico {
  width: 30px;
  height: 30px;
  border-radius: 9px;
  display: grid;
  place-items: center;
  font-size: 12px;
}

.rval {
  font-size: 18px;
  font-weight: 800;
  color: var(--text);
  line-height: 1;
}

.rlbl {
  margin-top: 2px;
  font-size: 10px;
  color: var(--muted);
  text-transform: uppercase;
  font-weight: 700;
  letter-spacing: .06em;
}

.tbl-wrap {
  border-radius: 16px;
  overflow: hidden;
  border: 1px solid var(--line);
  background: #ffffff;
}

.tbl {
  width: 100%;
  border-collapse: collapse;
}

.tbl thead tr {
  background: #f8fafc;
}

.tbl th {
  padding: 10px 12px;
  text-align: left;
  border-bottom: 1px solid var(--line);
  color: var(--muted);
  text-transform: uppercase;
  font-size: 10px;
  letter-spacing: .08em;
}

.tbl td {
  padding: 11px 12px;
  border-bottom: 1px solid #f1f5f9;
  color: #334155;
  font-size: 12px;
}

.tbl tr:last-child td {
  border-bottom: none;
}

.pill {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  border-radius: 999px;
  padding: 4px 9px;
  font-size: 11px;
  font-weight: 800;
}

.p-hadir { background: #ecfdf5; color: var(--ok); }
.p-izin { background: #fffbeb; color: var(--warn); }
.p-sakit { background: #fef2f2; color: var(--danger); }
.p-alpha { background: #f1f5f9; color: #64748b; }

.pill-dot {
  width: 5px;
  height: 5px;
  border-radius: 50%;
  background: currentColor;
}

.ket {
  max-width: 220px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  color: var(--muted);
}

#absenModalWrap {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(15, 23, 42, .52);
  z-index: 9000;
  align-items: center;
  justify-content: center;
  padding: 16px;
}

#absenModalWrap.absen-show { display: flex; }

#absenModalBox {
  width: min(450px, 94vw);
  background: #ffffff;
  border-radius: 20px;
  border: 1px solid var(--line);
  box-shadow: 0 24px 60px rgba(15, 23, 42, .22);
  overflow: hidden;
}

.am-hd {
  background: #f8fafc;
  border-bottom: 1px solid var(--line);
  padding: 14px 16px;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 10px;
}

.am-htitle {
  font-size: 17px;
  font-weight: 800;
  color: var(--text);
}

.am-hsub {
  margin-top: 3px;
  font-size: 12px;
  color: var(--muted);
}

.am-x {
  width: 30px;
  height: 30px;
  border-radius: 9px;
  border: 1px solid var(--line);
  background: #ffffff;
  color: #64748b;
  cursor: pointer;
}

.am-bd { padding: 16px; }

.am-lbl {
  margin-bottom: 8px;
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: .08em;
  color: var(--muted);
  font-weight: 700;
}

.am-opts {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 8px;
  margin-bottom: 14px;
}

.am-opt {
  border-radius: 12px;
  border: 1.5px solid var(--line);
  background: #ffffff;
  padding: 12px 8px;
  text-align: center;
  cursor: pointer;
}

.am-opt-ico { font-size: 18px; color: #64748b; margin-bottom: 6px; }
.am-opt-lbl { font-size: 12px; font-weight: 700; color: #475569; }

.am-opt[data-status="hadir"].am-on { background: #ecfdf5; border-color: #10b981; }
.am-opt[data-status="hadir"].am-on .am-opt-ico,
.am-opt[data-status="hadir"].am-on .am-opt-lbl { color: var(--ok); }

.am-opt[data-status="izin"].am-on { background: #fffbeb; border-color: #f59e0b; }
.am-opt[data-status="izin"].am-on .am-opt-ico,
.am-opt[data-status="izin"].am-on .am-opt-lbl { color: var(--warn); }

.am-opt[data-status="sakit"].am-on { background: #fef2f2; border-color: #ef4444; }
.am-opt[data-status="sakit"].am-on .am-opt-ico,
.am-opt[data-status="sakit"].am-on .am-opt-lbl { color: var(--danger); }

.am-ta {
  width: 100%;
  min-height: 86px;
  border-radius: 12px;
  border: 1px solid var(--line);
  background: #ffffff;
  padding: 10px 12px;
  font-size: 13px;
  color: var(--text);
  font-family: inherit;
  resize: none;
}

.am-ta:focus {
  outline: none;
  border-color: #93c5fd;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, .15);
}

.am-ft {
  border-top: 1px solid var(--line);
  padding: 12px 16px;
  display: flex;
  justify-content: flex-end;
  gap: 8px;
}

.am-cancel,
.am-submit {
  border: none;
  border-radius: 11px;
  padding: 10px 14px;
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
}

.am-cancel { background: #e2e8f0; color: #334155; }
.am-submit { background: var(--brand); color: #ecfeff; }

.am-submit:disabled {
  opacity: .6;
  cursor: not-allowed;
}

#absenToast {
  position: fixed;
  right: 22px;
  bottom: 22px;
  z-index: 9999;
  display: flex;
  align-items: center;
  gap: 8px;
  border-radius: 12px;
  padding: 11px 14px;
  color: #ffffff;
  font-size: 12px;
  font-weight: 700;
  transform: translateY(14px);
  opacity: 0;
  pointer-events: none;
  transition: .25s ease;
}

#absenToast.at-show {
  transform: translateY(0);
  opacity: 1;
}

#absenToast.at-ok { background: var(--ok); }
#absenToast.at-err { background: var(--danger); }

@media (max-width: 900px) {
  .page-wrap { padding: 18px; }
  .top-title { font-size: 24px; }
  .hero { padding: 18px; }
  .hero-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); width: 100%; }
}
</style>
@endpush

@section('content')

<div class="schedules-wrapper">
  @php
    $totalCourses = $schedules->flatten()->count();
    $daySchedules = $schedules->get($selectedDay, collect());
  @endphp

  <div class="page-wrap">
    <div class="topbar">
      <div>
        <div class="top-title">Jadwal Mata Pelajaran</div>
        <div class="top-sub">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</div>
      </div>
      <div style="display:flex;gap:8px;flex-wrap:wrap;">
        @if(in_array($user->role ?? '', ['admin','kepala_sekolah']) && Route::has('schedule.manage'))
          <a href="{{ route('schedule.manage') }}" class="top-chip" style="text-decoration:none;">
            <i class="fas fa-sliders"></i>
            Kelola Jadwal
          </a>
        @endif
        <div class="top-chip"><i class="fas fa-bell"></i> Jadwal Aktif</div>
      </div>
    </div>

    <section class="hero">
      <div>
        <h2>Belajar Terstruktur Setiap Hari</h2>
        <p>Pilih hari untuk melihat slot mapel yang tersedia.</p>
      </div>
      <div class="hero-stats">
        <div class="stat"><strong>{{ $totalCourses }}</strong><span>Total Slot</span></div>
      </div>
    </section>

    <div class="day-nav">
      @foreach($dayOrder as $day)
        @php $cnt = $schedules->get($day)?->count() ?? 0; @endphp
        <a href="{{ request()->fullUrlWithQuery(['day' => $day]) }}" class="day-tab {{ $selectedDay === $day ? 'active' : '' }}">
          {{ $day }}
          <span class="day-count">{{ $cnt }}</span>
        </a>
      @endforeach
    </div>

    <div class="section-head">
      <div>
        <div class="section-title">Jadwal {{ $selectedDay }}</div>
        <div class="section-sub">Mapel yang dijadwalkan pada hari ini</div>
      </div>
      <span class="badge"><i class="fas fa-layer-group"></i> {{ $daySchedules->count() }} slot</span>
    </div>

    <div class="grid">
      @if($daySchedules->isEmpty())
        <div class="empty">Tidak ada jadwal untuk hari <strong>{{ $selectedDay }}</strong>.</div>
      @else
        <div class="schedule-grid">
          @foreach($daySchedules as $schedule)
            @php
              $start = ($schedule->start_time instanceof \Carbon\Carbon
                ? $schedule->start_time
                : \Carbon\Carbon::parse($schedule->start_time))->format('H:i');
              $end = ($schedule->end_time instanceof \Carbon\Carbon
                ? $schedule->end_time
                : \Carbon\Carbon::parse($schedule->end_time))->format('H:i');
              $absen = $schedule->absensiHariIni ?? null;
              $teacherName = $schedule->teacher?->name
                ?? $schedule->subject->teacher
                ?? 'Belum ditentukan';
            @endphp

            <article class="card">
              <header class="sc-head">
                <div>
                  <h3 class="sc-name">{{ $schedule->subject->name ?? '-' }}</h3>
                  <div class="sc-code">{{ strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', (string)($schedule->subject->name ?? 'MP')), 0, 6)) }}</div>
                </div>
                <div class="sc-time">{{ $start }} - {{ $end }}</div>
              </header>
              <div class="sc-body">
                <div class="sc-info">
                  <div class="sc-row"><div class="ic"><i class="fas fa-chalkboard-user"></i></div><div>Guru: {{ $teacherName }}</div></div>
                  @if($schedule->room)
                    <div class="sc-row"><div class="ic"><i class="fas fa-door-open"></i></div><div>Ruang {{ $schedule->room }}</div></div>
                  @endif
                  @if(!empty($schedule->subject->description))
                    <div class="sc-row"><div class="ic"><i class="fas fa-book-open"></i></div><div>{{ $schedule->subject->description }}</div></div>
                  @endif
                </div>
              </div>
            </article>
          @endforeach
        </div>
      @endif
    </div>

    <section class="riwayat">
      <div class="r-head">
        <div class="r-title">Riwayat Absensi</div>
        <div class="filters">
          <a href="{{ request()->fullUrlWithQuery(['filter'=>'all']) }}" class="rf {{ ($filter ?? 'all')==='all' ? 'active' : '' }}">Semua</a>
          <a href="{{ request()->fullUrlWithQuery(['filter'=>'hadir']) }}" class="rf {{ ($filter ?? '')==='hadir' ? 'active' : '' }}">Hadir</a>
          <a href="{{ request()->fullUrlWithQuery(['filter'=>'izin']) }}" class="rf {{ ($filter ?? '')==='izin' ? 'active' : '' }}">Izin</a>
          <a href="{{ request()->fullUrlWithQuery(['filter'=>'sakit']) }}" class="rf {{ ($filter ?? '')==='sakit' ? 'active' : '' }}">Sakit</a>
          <a href="{{ request()->fullUrlWithQuery(['filter'=>'alpha']) }}" class="rf {{ ($filter ?? '')==='alpha' ? 'active' : '' }}">Alpha</a>
        </div>
      </div>

      <div class="rsum">
        <div class="rbox"><div class="rico" style="background:#ecfdf5;color:var(--ok);"><i class="fas fa-circle-check"></i></div><div><div class="rval">{{ $hadirCount }}</div><div class="rlbl">Hadir</div></div></div>
        <div class="rbox"><div class="rico" style="background:#fffbeb;color:var(--warn);"><i class="fas fa-file-circle-check"></i></div><div><div class="rval">{{ $izinCount }}</div><div class="rlbl">Izin</div></div></div>
        <div class="rbox"><div class="rico" style="background:#fef2f2;color:var(--danger);"><i class="fas fa-kit-medical"></i></div><div><div class="rval">{{ $sakitCount }}</div><div class="rlbl">Sakit</div></div></div>
        <div class="rbox"><div class="rico" style="background:#f1f5f9;color:#64748b;"><i class="fas fa-circle-minus"></i></div><div><div class="rval">{{ $alphaCount }}</div><div class="rlbl">Alpha</div></div></div>
      </div>

      <div class="tbl-wrap">
        <table class="tbl">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Mata Pelajaran</th>
              <th>Jam</th>
              <th>Status</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            @forelse($riwayatAbsen as $ab)
              <tr>
                <td>{{ 
                  (\Illuminate\Support\Arr::get($ab, 'date') instanceof \Carbon\Carbon)
                    ? $ab->date->format('Y-m-d')
                    : (\Illuminate\Support\Arr::get($ab, 'date') ?? '-')
                }}</td>
                <td>{{ $ab->schedule?->subject?->name ?? '-' }}</td>
                <td>
                  @php
                    $st = $ab->schedule?->start_time ?? null;
                    $et = $ab->schedule?->end_time ?? null;
                    if ($st instanceof \Carbon\Carbon) $st = $st->format('H:i');
                    if ($et instanceof \Carbon\Carbon) $et = $et->format('H:i');
                  @endphp
                  {{ $st ?? '-' }} - {{ $et ?? '-' }}
                </td>
                <td>{{ ucfirst($ab->status ?? '-') }}</td>
                <td>{{ $ab->note ?? '-' }}</td>
              </tr>
            @empty
              <tr><td colspan="5">Belum ada riwayat absensi.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="am-lbl">Keterangan <span style="font-size:10px;font-weight:500;text-transform:none;letter-spacing:0;">(opsional)</span></div>
    </section>
  </div>
</div>

@endsection