@extends('layouts.app')

@section('title', 'Absen Mapel')

@section('content')
<div style="padding: 20px; max-width: 1200px; margin: 0 auto;">
    <h1>Absen Mapel Hari Ini</h1>
    <p>{{ $dayName }}, {{ $today->format('d M Y') }}</p>
    
    @if($schedules->isEmpty())
        <p>Tidak ada jadwal hari ini</p>
    @else
        @foreach($schedules as $schedule)
            <div style="border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 5px;">
                <h3>{{ $schedule->subject->name }}</h3>
                <p>Waktu: {{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</p>
                <p>Guru: {{ $schedule->teacher->name ?? '-' }}</p>
                
                @php
                    $att = $attendances[$schedule->id] ?? null;
                @endphp
                
                @if($att)
                    <p style="color: green;"><strong>Status: {{ $att->status }}</strong></p>
                @else
                    <p style="color: red;"><strong>Belum absen</strong></p>
                @endif
                
                <form action="{{ route('attendance.submit', $schedule->id) }}" method="POST" style="margin-top: 10px;">
                    @csrf
                    <select name="status" required>
                        <option value="">-- Pilih --</option>
                        <option value="hadir" @selected($att?->status === 'hadir')>Hadir</option>
                        <option value="sakit" @selected($att?->status === 'sakit')>Sakit</option>
                        <option value="izin" @selected($att?->status === 'izin')>Izin</option>
                        <option value="alpha" @selected($att?->status === 'alpha')>Bolos</option>
                    </select>
                    <textarea name="comment" placeholder="Komentar (opsional)" style="width: 100%; margin: 10px 0; padding: 5px;"></textarea>
                    <button type="submit" style="padding: 8px 15px; background: blue; color: white; border: none; border-radius: 4px; cursor: pointer;">Simpan</button>
                </form>
            </div>
        @endforeach
    @endif
</div>
@endsection
