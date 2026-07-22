@extends('layouts.app')
@section('title', 'Jadwal UTS/UAS - SMK TRAVINA PRIMA')
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>

:root {
  --ink:       #1e293b;
  --surface:   #f8fafc;
  --card:      #fff;
  --border:    #e5e7eb;
  --blue:      #2563eb;
  --blue-light: #60a5fa;
  --gold:      #fbbf24;
  --muted:     #64748b;
  --radius:    16px;
}




*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.main {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 8px 32px rgba(15,118,110,0.10);
  min-height: 100vh;
  padding: 0 24px 32px 24px;
}
@media (max-width: 700px) {
  .main { border-radius: 0; box-shadow: none; padding: 0 4px 24px 4px; }
}

.exam-page {
  background: var(--surface);
  min-height: 100vh;
  font-family: 'DM Sans', sans-serif;
  color: var(--ink);
  padding: 48px 0 64px 0;
}
}

/* ── HERO BANNER ─────────────────────────────────────── */

.exam-hero {
  max-width: 900px;
  margin: 0 auto 36px;
  position: relative;
  background: #fff;
  border: 1px solid var(--border);
  border-radius: 20px;
  padding: 36px 40px 32px 40px;
  overflow: hidden;
  animation: fadeUp .5s ease both;
  box-shadow: 0 4px 32px #2563eb11;
}

.exam-hero-top {
  display: flex;
  align-items: flex-start;
  gap: 22px;
  justify-content: center;
}

.exam-icon-wrap {
  flex-shrink: 0;
  width: 64px;
  height: 64px;
  border-radius: 18px;
  background: linear-gradient(135deg, var(--gold) 0%, #c88e2a 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 26px;
  color: #1a1000;
  box-shadow: 0 8px 24px rgba(232,184,75,.30);
}

.exam-hero-text {
  flex: 1;
  text-align: center;
}

.exam-school-tag {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(232,184,75,.12);
  border: 1px solid rgba(232,184,75,.25);
  color: var(--gold);
  font-size: 11px;
  font-weight: 700;
  letter-spacing: .12em;
  text-transform: uppercase;
  border-radius: 100px;
  padding: 4px 12px;
  margin-bottom: 10px;
}

.exam-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(1.6rem, 4vw, 2.4rem);
  font-weight: 900;
  color: var(--ink);
  line-height: 1.1;
  margin-bottom: 6px;
  font-size: clamp(1.7rem, 4vw, 2.3rem);
}

.exam-class-chip {
  display: inline-block;
  background: linear-gradient(90deg, var(--gold) 0%, #c88e2a 100%);
  color: #1a1000;
  font-size: 13px;
  font-weight: 800;
  border-radius: 8px;
  padding: 3px 12px;
  margin-left: 10px;
  vertical-align: middle;
  background: #fef9c3;
  color: #b45309;
}

.exam-subtitle {
  color: var(--muted);
  font-size: 1.05rem;
  line-height: 1.6;
  margin-top: 10px;
  max-width: 600px;
  font-weight: 500;
  text-align: center;
  margin-left: auto;
  margin-right: auto;
}

.exam-divider {
  height: 1px;
  background: var(--border);
  margin: 24px 0;
}

.exam-alert {
  display: flex;
  align-items: center;
  gap: 12px;
  background: rgba(56,189,248,.08);
  border: 1px solid rgba(56,189,248,.20);
  border-radius: 12px;
  padding: 13px 18px;
  color: var(--sky);
  font-size: .88rem;
  font-weight: 500;
  line-height: 1.5;
  justify-content: center;
  text-align: center;
}

.exam-alert i { font-size: 18px; flex-shrink: 0; }

/* ── STATS ROW ───────────────────────────────────────── */
.exam-stats {
  max-width: 940px;
  margin: 0 auto 28px;
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 14px;
  animation: fadeUp .5s .1s ease both;
}

.stat-card {
  background: #fff;
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 18px 20px;
  display: flex;
  align-items: center;
  gap: 14px;
  box-shadow: 0 2px 12px #2563eb11;
}

.stat-icon {
  width: 42px;
  height: 42px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  flex-shrink: 0;
}

.stat-icon.gold  { background: rgba(232,184,75,.15);  color: var(--gold); }
.stat-icon.sky   { background: rgba(56,189,248,.15);  color: var(--sky); }
.stat-icon.mint  { background: rgba(52,211,153,.15);  color: var(--mint); }

.stat-val {
  font-family: 'Playfair Display', serif;
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--blue);
  line-height: 1;
}

.stat-lbl {
  font-size: .78rem;
  color: var(--muted);
  margin-top: 3px;
  font-weight: 500;
}

/* ── TABLE CARD ──────────────────────────────────────── */
.exam-table-card {
  max-width: 940px;
  margin: 0 auto;
  background: #fff;
  border: 1px solid var(--border);
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 2px 12px #2563eb11;
  animation: fadeUp .5s .2s ease both;
}

.exam-table-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px 28px;
  border-bottom: 1px solid var(--border);
}

.exam-table-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.15rem;
  font-weight: 700;
  color: var(--ink);
}

.exam-table-meta {
  font-size: .82rem;
  color: var(--muted);
}

.today-dot {
  display: inline-block;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: var(--mint);
  margin-right: 6px;
  box-shadow: 0 0 8px var(--mint);
}

table.exam-tbl {
  width: 100%;
  border-collapse: collapse;
}

table.exam-tbl thead th {
  background: #f4f8ff;
  padding: 13px 20px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: .12em;
  text-transform: uppercase;
  color: var(--blue);
  text-align: left;
  border-bottom: 1px solid #e0e7ef;
}

table.exam-tbl tbody tr {
  border-bottom: 1px solid var(--border);
  transition: background .18s;
}

table.exam-tbl tbody tr:last-child {
  border-bottom: none;
}

table.exam-tbl tbody tr:hover {
  background: #e0e7ff;
}

table.exam-tbl tbody tr.is-today {
  background: rgba(232,184,75,.06);
  border-left: 3px solid var(--gold);
}

table.exam-tbl tbody tr.is-today td:first-child {
  padding-left: 17px;
}

table.exam-tbl tbody td {
  padding: 16px 20px;
  font-size: .92rem;
  vertical-align: middle;
}

/* ── DAY CELL ────────────────────────────────────────── */
.day-cell {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.day-name {
  font-weight: 700;
  color: #111;
  font-size: .93rem;
}

.day-tag {
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .10em;
  background: rgba(232,184,75,.18);
  color: var(--gold);
  border-radius: 6px;
  padding: 2px 7px;
  width: fit-content;
  display: none;
}

tr.is-today .day-tag { display: block; }

/* ── DATE / TIME ─────────────────────────────────────── */
.date-text {
  color: var(--muted);
  font-size: .90rem;
}

.time-chip {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: transparent !important;
  border: 1px solid transparent !important;
  border-radius: 8px;
  padding: 5px 11px;
  font-size: .85rem;
  font-weight: 600;
  color: var(--blue);
  white-space: nowrap;
}

.time-chip i { font-size: 11px; color: var(--muted); }

/* ── SUBJECT BADGES ──────────────────────────────────── */
.subj-badge {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  border-radius: 10px;
  padding: 6px 14px;
  font-size: .83rem;
  font-weight: 700;
  letter-spacing: .01em;
  white-space: nowrap;
}

.subj-badge.math    { background: #fef9c3;  color: #b45309;  border: 1px solid #fde68a; }
.subj-badge.english { background: #e0e7ff;  color: var(--blue);    border: 1px solid #bae6fd; }
.subj-badge.science { background: #dcfce7;  color: #059669;   border: 1px solid #bbf7d0; }
.subj-badge.bahasa  { background: #ffe4e6; color: #be185d;   border: 1px solid #fbcfe8; }
.subj-badge.other   { background: #ede9fe; color: #7c3aed; border: 1px solid #ddd6fe; }

.subj-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  flex-shrink: 0;
}

.math    .subj-dot { background: var(--amber); }
.english .subj-dot { background: var(--sky); }
.science .subj-dot { background: var(--mint); }
.bahasa  .subj-dot { background: var(--rose); }
.other   .subj-dot { background: var(--violet); }

/* ── TEACHER / ROOM ─────────────────────────────────── */
.teacher-cell {
  display: flex;
  align-items: center;
  gap: 9px;
}

.teacher-avatar {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: linear-gradient(135deg, #6366f1, #38bdf8);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  font-weight: 800;
  color: #fff;
  flex-shrink: 0;
}

.teacher-name {
  font-weight: 600;
  font-size: .88rem;
  color: #2563eb;
}

.room-chip {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: .84rem;
  font-weight: 700;
  color: var(--muted);
}

.room-chip i { font-size: 12px; }

/* ── EMPTY STATE ─────────────────────────────────────── */
.exam-empty {
  padding: 64px 20px;
  text-align: center;
}

.exam-empty-icon {
  width: 72px;
  height: 72px;
  border-radius: 20px;
  background: rgba(255,255,255,.05);
  border: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
  color: var(--muted);
  margin: 0 auto 18px;
}

.exam-empty h3 {
  font-family: 'Playfair Display', serif;
  font-size: 1.2rem;
  color: var(--text);
  margin-bottom: 8px;
}

.exam-empty p {
  font-size: .88rem;
  color: var(--muted);
  max-width: 300px;
  margin: 0 auto;
}

/* ── ANIMATIONS ──────────────────────────────────────── */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* ── RESPONSIVE ──────────────────────────────────────── */
@media (max-width: 700px) {
  .exam-page { padding: 20px 12px 48px; }
  .exam-hero { padding: 24px 20px; border-radius: 18px; }
  .exam-hero-top { gap: 14px; }
  .exam-icon-wrap { width: 50px; height: 50px; font-size: 20px; border-radius: 14px; }
  .exam-stats { grid-template-columns: 1fr; gap: 10px; }
  .exam-table-header { padding: 14px 16px; }
  table.exam-tbl thead th,
  table.exam-tbl tbody td { padding: 12px 12px; font-size: .80rem; }
  .teacher-avatar { display: none; }
  .time-chip { padding: 4px 8px; font-size: .78rem; }
  .subj-badge { padding: 5px 10px; font-size: .78rem; }
}
</style>
@endpush

@section('content')
<div class="app">
  @include('partials.sidebar')
  <div class="main">
    <div class="exam-page">

      @php
        $today = \Carbon\Carbon::now()->translatedFormat('l');
        $todayCount = collect($scheduleList)->filter(fn($i) => strtolower($i['day']) === strtolower($today))->count();
        $totalSubjects = collect($scheduleList)->pluck('subject')->unique()->count();

        function utsuasSubjectBadge($subject) {
          $map = [
            'matematika'      => 'math',
            'math'            => 'math',
            'english'         => 'english',
            'bahasa inggris'  => 'english',
            'ipa'             => 'science',
            'science'         => 'science',
            'bahasa indonesia'=> 'bahasa',
            'b.indonesia'     => 'bahasa',
          ];
          return $map[strtolower($subject)] ?? 'other';
        }

        function subjectIcon($type) {
          return match($type) {
            'math'    => 'fa-calculator',
            'english' => 'fa-language',
            'science' => 'fa-flask',
            'bahasa'  => 'fa-book-open',
            default   => 'fa-pencil-alt',
          };
        }

        function teacherInitials($name) {
          $parts = explode(' ', trim($name));
          $init = '';
          foreach (array_slice($parts, 0, 2) as $p) $init .= strtoupper(substr($p, 0, 1));
          return $init ?: '?';
        }
      @endphp

      {{-- ── HERO ── --}}
      <div class="exam-hero">
        <div class="exam-hero-top">
          <div class="exam-hero-text">
            <div class="exam-school-tag">
              <i class="fas fa-star" style="font-size:9px;"></i>
              SMK TRAVINA PRIMA
            </div>
            <div class="exam-title">
              Jadwal UTS / UAS
              @if(isset($student) && $student->class_id)
                <span class="exam-class-chip">{{ $student->class_id }}</span>
              @endif
            </div>
            <p class="exam-subtitle">
              Jadwal resmi ujian tengah dan akhir semester. Cek tanggal, waktu, dan ruangan dengan teliti sebelum hari ujian tiba.
            </p>
          </div>
        </div>
        <div class="exam-divider"></div>
        <div class="exam-alert">
          Pastikan perangkat dan koneksi internet stabil sebelum ujian dimulai. Login tepat waktu ke sistem ujian online. Dilarang melakukan kecurangan atau membuka tab lain selama ujian berlangsung.
        </div>
      </div>

      {{-- ── STATS ── --}}
      <div class="exam-stats">
        <div class="stat-card">
          <div class="stat-icon gold"><i class="fas fa-calendar-check"></i></div>
          <div>
            <div class="stat-val">{{ count($scheduleList) }}</div>
            <div class="stat-lbl">Total Sesi Ujian</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon sky"><i class="fas fa-book"></i></div>
          <div>
            <div class="stat-val">{{ $totalSubjects }}</div>
            <div class="stat-lbl">Mata Pelajaran</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon mint"><i class="fas fa-sun"></i></div>
          <div>
            <div class="stat-val">{{ $todayCount }}</div>
            <div class="stat-lbl">Ujian Hari Ini</div>
          </div>
        </div>
      </div>

      {{-- ── TABLE ── --}}
      <div class="exam-table-card">
        <div class="exam-table-header">
          <div class="exam-table-title">Daftar Jadwal Ujian</div>
          <div class="exam-table-meta">
            @if($todayCount > 0)
              <span class="today-dot"></span> Ada ujian hari ini
            @else
              Tidak ada ujian hari ini
            @endif
          </div>
        </div>

        <table class="exam-tbl">
          <thead>
            <tr>
              <th>Hari</th>
              <th>Tanggal</th>
              <th>Waktu</th>
              <th>Mata Pelajaran</th>
              <th>Guru Pengajar</th>
              <th>Ruang</th>
            </tr>
          </thead>
          <tbody>
            @forelse($scheduleList as $item)
              @php
                $isToday = strtolower($item['day']) === strtolower($today);
                $type    = utsuasSubjectBadge($item['subject']);
                $icon    = subjectIcon($type);
                $initials= teacherInitials($item['teacher']);
              @endphp
              <tr class="{{ $isToday ? 'is-today' : '' }}">
                {{-- DAY --}}
                <td>
                  <div class="day-cell">
                    <span class="day-name">{{ $item['day'] }}</span>
                    @if($isToday)<span class="day-tag">Hari ini</span>@endif
                  </div>
                </td>

                {{-- DATE --}}
                <td>
                  <span class="date-text">{{ $item['date'] ?: '—' }}</span>
                </td>

                {{-- TIME --}}
                <td>
                  <span class="time-chip">
                    <i class="fas fa-clock"></i>
                    {{ $item['time'] }}
                  </span>
                </td>

                {{-- SUBJECT --}}
                <td>
                  <span class="subj-badge {{ $type }}">
                    <span class="subj-dot"></span>
                    <i class="fas {{ $icon }}"></i>
                    {{ $item['subject'] }}
                  </span>
                </td>

                {{-- TEACHER --}}
                <td>
                  <div class="teacher-cell">
                    <div class="teacher-avatar">{{ $initials }}</div>
                    <span class="teacher-name">{{ $item['teacher'] }}</span>
                  </div>
                </td>

                {{-- ROOM --}}
                <td>
                  <span class="room-chip">
                    <i class="fas fa-door-open"></i>
                    {{ $item['room'] }}
                  </span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6">
                  <div class="exam-empty">
                    <div class="exam-empty-icon"><i class="fas fa-calendar-times"></i></div>
                    <h3>Belum Ada Jadwal</h3>
                    <p>Jadwal UTS/UAS untuk kelas Anda belum tersedia. Silakan hubungi admin sekolah untuk informasi lebih lanjut.</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>
@endsection