@extends('layouts.app')

@section('title', 'Jadwal Mingguan - Travina Prima')

@push('styles')
<style>
:root {
    --blue: #2563eb; --green: #059669; --amber: #d97706; --red: #dc2626;
    --bg: #f4f6fa; --card: #fff; --border: #e8eaf0;
    --txt: #111827; --txt2: #6b7280; --txt3: #9ca3af;
}

.container-weekly { max-width: 1200px; margin: 0 auto; padding: 20px; }
.page-title { font-size: 24px; font-weight: 800; margin-bottom: 8px; color: var(--txt); }
.page-sub { font-size: 14px; color: var(--txt2); margin-bottom: 24px; }

.day-section {
    margin-bottom: 30px;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
}
.day-header {
    background: #f9fafb;
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
}
.day-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: var(--txt);
}

.schedule-list {
    padding: 15px 20px;
}
.schedule-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px 0;
    border-bottom: 1px solid #f5f5f5;
}
.schedule-item:last-child { border-bottom: none; }

.schedule-time {
    font-size: 14px;
    font-weight: 600;
    color: var(--blue);
    flex-shrink: 0;
    width: 100px; /* Fixed width for time */
}
.schedule-details {
    flex-grow: 1;
}
.schedule-details h4 {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    color: var(--txt);
}
.schedule-details p {
    margin: 4px 0 0;
    font-size: 12px;
    color: var(--txt2);
}

.empty-day {
    padding: 20px;
    text-align: center;
    color: var(--txt3);
    font-size: 14px;
}

@media (max-width: 768px) {
    .container-weekly { padding: 15px; }
    .page-title { font-size: 20px; }
    .day-header h3 { font-size: 16px; }
    .schedule-item { flex-direction: column; align-items: flex-start; gap: 5px; }
    .schedule-time { width: auto; }
}
</style>
@endpush

@section('content')
<div class="app">
    @include('partials.sidebar')
    <div class="main">
        <div class="container-weekly">
            <div class="page-title">🗓️ Jadwal Mingguan</div>
            <div class="page-sub">Jadwal pelajaran untuk kelas {{ $student->class_id }} selama seminggu.</div>

            @if($schedules->isEmpty())
                <div class="empty-day" style="background: var(--card); border-radius: 12px; border: 1px solid var(--border);">
                    <p>Tidak ada jadwal pelajaran yang ditemukan untuk kelas Anda.</p>
                    <p>Silakan hubungi admin sekolah jika ini adalah kesalahan.</p>
                </div>
            @else
                @foreach($dayOrder as $day)
                    <div class="day-section">
                        <div class="day-header">
                            <h3>{{ $day }}</h3>
                        </div>
                        <div class="schedule-list">
                            @if($schedules->has($day))
                                @foreach($schedules[$day] as $schedule)
                                    <div class="schedule-item">
                                        <div class="schedule-time">
                                            {{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}
                                        </div>
                                        <div class="schedule-details">
                                            <h4>{{ $schedule->subject->name ?? 'Mata Pelajaran Tidak Ditemukan' }}</h4>
                                            <p>
                                                Guru: {{ $schedule->teacher->name ?? ($schedule->subject->teacher ?? '-') }}
                                                @if($schedule->room) | Ruang: {{ $schedule->room }} @endif
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-day">
                                    Tidak ada jadwal untuk hari {{ $day }}.
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection