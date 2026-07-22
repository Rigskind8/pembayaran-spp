@extends('layouts.app')
@section('title', 'Mata Pelajaran - Paramount')

@push('styles')
<style>
:root {
    --bg: #f2f5fb;
    --card: #ffffff;
    --line: #e2e8f0;
    --text: #0f172a;
    --muted: #64748b;
    --brand: #0f766e;
    --brand-2: #14b8a6;
    --brand-soft: #ccfbf1;
    --accent: #f59e0b;
    --shadow: 0 12px 34px rgba(15, 23, 42, .08);
}

.main {
    margin-left: var(--sb, 250px);
    min-height: 100vh;
    background: radial-gradient(circle at 12% 0%, rgba(20, 184, 166, .15), transparent 32%), var(--bg);
}

.page-wrap {
    padding: 28px;
}

.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-bottom: 22px;
}

.title {
    font-size: 30px;
    font-weight: 800;
    letter-spacing: -.02em;
    color: var(--text);
}

.subtitle {
    color: var(--muted);
    font-size: 13px;
    margin-top: 4px;
}

.pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background: var(--card);
    border: 1px solid var(--line);
    border-radius: 999px;
    color: var(--muted);
    font-size: 12px;
    font-weight: 700;
}

.hero {
    background: linear-gradient(135deg, #0f766e 0%, #14b8a6 58%, #2dd4bf 100%);
    border-radius: 24px;
    padding: 26px 28px;
    color: #f8fffe;
    box-shadow: 0 16px 44px rgba(15, 118, 110, .28);
    margin-bottom: 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
}

.hero h2 {
    font-size: 28px;
    font-weight: 800;
    margin: 0 0 6px;
}

.hero p {
    margin: 0;
    opacity: .9;
    font-size: 13px;
}

.hero-stats {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.hero-stat {
    background: rgba(255, 255, 255, .18);
    border: 1px solid rgba(255, 255, 255, .28);
    border-radius: 14px;
    min-width: 110px;
    text-align: center;
    padding: 12px 14px;
}

.hero-stat strong {
    display: block;
    font-size: 24px;
    line-height: 1;
}

.hero-stat span {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.grid {
    display: grid;
    grid-template-columns: 1.5fr .9fr;
    gap: 18px;
}

.card {
    background: var(--card);
    border: 1px solid var(--line);
    border-radius: 20px;
    box-shadow: var(--shadow);
}

.card-head {
    padding: 18px 20px;
    border-bottom: 1px solid var(--line);
}

.card-title {
    margin: 0;
    font-size: 16px;
    font-weight: 800;
    color: var(--text);
}

.card-sub {
    margin-top: 4px;
    color: var(--muted);
    font-size: 12px;
}

.subject-list {
    padding: 14px;
    display: grid;
    gap: 10px;
}

.subject-item {
    border: 1px solid var(--line);
    border-radius: 16px;
    padding: 14px;
    display: grid;
    grid-template-columns: 46px 1fr;
    gap: 12px;
    transition: transform .15s ease, box-shadow .15s ease;
}

.subject-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 26px rgba(15, 23, 42, .08);
}

.subject-icon {
    width: 46px;
    height: 46px;
    border-radius: 14px;
    background: var(--brand-soft);
    color: var(--brand);
    display: grid;
    place-items: center;
    font-size: 18px;
}

.subject-name {
    margin: 0;
    font-size: 15px;
    font-weight: 800;
    color: var(--text);
}

.subject-teacher {
    margin-top: 3px;
    color: var(--muted);
    font-size: 12px;
}

.subject-time {
    margin-top: 8px;
    color: #334155;
    font-size: 12px;
    line-height: 1.5;
}

.subject-progress {
    margin-top: 10px;
}

.progress-track {
    height: 7px;
    background: #e2e8f0;
    border-radius: 999px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    border-radius: 999px;
    width: 0;
    background: linear-gradient(90deg, #0f766e, #14b8a6);
    transition: width .9s ease;
}

.progress-row {
    margin-top: 5px;
    display: flex;
    justify-content: space-between;
    color: var(--muted);
    font-size: 11px;
    font-weight: 700;
}

.side-stack {
    display: grid;
    gap: 14px;
}

.quick {
    padding: 18px 20px;
}

.quick h4 {
    margin: 0;
    font-size: 14px;
    font-weight: 800;
    color: var(--text);
}

.quick p {
    margin: 6px 0 0;
    font-size: 12px;
    color: var(--muted);
    line-height: 1.55;
}

.mini-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 8px;
    margin-top: 12px;
}

.mini {
    border-radius: 12px;
    border: 1px solid var(--line);
    background: #f8fafc;
    padding: 10px;
    text-align: center;
}

.mini strong {
    display: block;
    font-size: 18px;
    color: var(--brand);
}

.mini span {
    font-size: 10px;
    color: var(--muted);
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
}

.week {
    padding: 12px;
    display: grid;
    gap: 8px;
}

.week-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8fafc;
    border: 1px solid var(--line);
    border-radius: 12px;
    padding: 10px 12px;
    font-size: 12px;
}

.week-item strong {
    color: var(--text);
}

.empty {
    padding: 28px;
    text-align: center;
    color: var(--muted);
}

@media (max-width: 1040px) {
    .grid { grid-template-columns: 1fr; }
}

@media (max-width: 900px) {
    .main { margin-left: 0; }
    .page-wrap { padding: 18px; }
    .hero { padding: 20px; flex-direction: column; align-items: flex-start; }
    .title { font-size: 25px; }
}
</style>
@endpush

@section('content')
<div class="app">
    @include('partials.sidebar')

    <main class="main">
        <div class="page-wrap">
            <div class="topbar">
                <div>
                    <div class="title">Mapel Saya</div>
                    <div class="subtitle">Nama: {{ $student->name }} · Kelas {{ $student->class_id }} · NIS {{ $student->nis }}</div>
                </div>
                <div class="pill">
                    <i class="fas fa-calendar-week" style="color: var(--accent);"></i>
                    {{ $todayName }}, {{ now()->format('d M Y') }}
                </div>
            </div>

            <section class="hero">
                <div>
                    <h2>Jadwal Mata Pelajaran</h2>
                    <p>Desain baru yang lebih fokus ke informasi penting, ritme belajar, dan distribusi jadwal mingguan.</p>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <strong>{{ $totalSubjects }}</strong>
                        <span>Total Mapel</span>
                    </div>
                    <div class="hero-stat">
                        <strong>{{ $totalHours }}</strong>
                        <span>Jam / Minggu</span>
                    </div>
                </div>
            </section>

            @php
                $todaySchedules = $scheduleByDay->get($todayName, collect())->sortBy(function ($schedule) {
                    return $schedule->start_time instanceof \Carbon\Carbon ? $schedule->start_time->format('H:i') : $schedule->start_time;
                });
                $nextSchedule = $todaySchedules->first(function ($schedule) {
                    return now()->lessThanOrEqualTo($schedule->end_time);
                });
                $averageProgress = $subjects->avg('progress') ? round($subjects->avg('progress')) : 0;
            @endphp

            <div class="grid">
                <section class="card">
                    <header class="card-head">
                        <h3 class="card-title">Daftar Mapel</h3>
                        <div class="card-sub">{{ $totalSubjects }} mapel aktif untuk kelas {{ $student->class_id }}</div>
                    </header>
                    <div class="subject-list">
                        @forelse($subjects as $mp)
                            <article class="subject-item">
                                <div class="subject-icon"><i class="fas fa-book"></i></div>
                                <div>
                                    <h4 class="subject-name">{{ $mp['name'] }}</h4>
                                    <div class="subject-teacher"><i class="fas fa-user-tie" style="font-size:10px;margin-right:5px;"></i>{{ $mp['teacher'] }}</div>
                                    <div class="subject-time">{{ $mp['times']->implode(' · ') }}</div>
                                    <div class="subject-progress">
                                        <div class="progress-track"><div class="progress-fill" data-w="{{ $mp['progress'] }}"></div></div>
                                        <div class="progress-row"><span>{{ $mp['sessions'] }} sesi</span><span>{{ $mp['progress'] }}%</span></div>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="empty">
                                Tidak ada mata pelajaran terdaftar untuk kelas {{ $student->class_id }}.
                            </div>
                        @endforelse
                    </div>
                </section>

                <aside class="side-stack">
                    <section class="card quick">
                        <h4>Ringkasan Hari Ini</h4>
                        <p>
                            @if($nextSchedule)
                                Kelas berikutnya: <strong>{{ $nextSchedule->subject->name ?? '-' }}</strong> pukul <strong>{{ $nextSchedule->start_time->format('H:i') }} - {{ $nextSchedule->end_time->format('H:i') }}</strong>.
                            @elseif($todaySchedules->isEmpty())
                                Tidak ada jadwal pelajaran hari ini.
                            @else
                                Semua kelas hari ini sudah selesai.
                            @endif
                        </p>
                        <div class="mini-grid">
                            <div class="mini"><strong>{{ $todaySchedules->count() }}</strong><span>Hari Ini</span></div>
                            <div class="mini"><strong>{{ $totalSubjects }}</strong><span>Mapel</span></div>
                            <div class="mini"><strong>{{ $averageProgress }}%</strong><span>Rata2</span></div>
                        </div>
                    </section>

                    <section class="card">
                        <header class="card-head">
                            <h3 class="card-title">Distribusi Mingguan</h3>
                            <div class="card-sub">Jumlah sesi per hari</div>
                        </header>
                        <div class="week">
                            @foreach($dayOrder as $day)
                                @php $count = $scheduleByDay->get($day)?->count() ?? 0; @endphp
                                <div class="week-item">
                                    <span>{{ $day }}</span>
                                    <strong>{{ $count }} sesi</strong>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </aside>
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
window.addEventListener('load', () => {
    document.querySelectorAll('.progress-fill').forEach((bar) => {
        bar.style.width = `${bar.getAttribute('data-w') || 0}%`;
    });
});
</script>
@endpush
