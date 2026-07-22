@extends('layouts.app')

@section('title', 'Diagnostic - Absen Mapel')

@section('content')
<div style="padding: 20px; max-width: 1200px; margin: 0 auto; font-family: monospace; background: #f5f5f5;">
    <h1>🔍 DIAGNOSTIC - Absen Mapel System</h1>
    <hr>
    
    <!-- AUTH INFO -->
    <div style="background: white; padding: 15px; margin: 10px 0; border-left: 4px solid #007bff;">
        <h2>Authentication & User</h2>
        <p><strong>User ID:</strong> {{ auth()->user()?->id ?? 'NOT AUTH' }}</p>
        <p><strong>User Email:</strong> {{ auth()->user()?->email ?? 'N/A' }}</p>
        <p><strong>User Role:</strong> {{ auth()->user()?->role ?? 'No role' }}</p>
    </div>
    
    <!-- STUDENT DATA -->
    <div style="background: white; padding: 15px; margin: 10px 0; border-left: 4px solid #28a745;">
        <h2>Student Record</h2>
        @if($student)
            <p>✅ Student record found</p>
            <p><strong>Student ID:</strong> {{ $student->id }}</p>
            <p><strong>Student Name:</strong> {{ $student->name }}</p>
            <p><strong>NIS:</strong> {{ $student->nis }}</p>
            <p><strong>Class ID:</strong> {{ $student->class_id }}</p>
        @else
            <p style="color: red;">❌ Student record NOT found for user</p>
            <p>This is likely the issue! Check if student record exists for user_id = {{ auth()->user()->id }}</p>
        @endif
    </div>
    
    <!-- DATE & DAY NAME -->
    <div style="background: white; padding: 15px; margin: 10px 0; border-left: 4px solid #ffc107;">
        <h2>Date Information</h2>
        <p><strong>Today's Date:</strong> {{ $today->format('d M Y') }}</p>
        <p><strong>Day Name:</strong> {{ $dayName }}</p>
        <p><strong>Formatted for Schedule Query:</strong> "{{ $dayName }}"</p>
    </div>
    
    <!-- SCHEDULES -->
    <div style="background: white; padding: 15px; margin: 10px 0; border-left: 4px solid #17a2b8;">
        <h2>Schedules for Today ({{ $dayName }})</h2>
        @if($schedules->isEmpty())
            <p style="color: orange;">⚠️ No schedules found</p>
            <p>Possible causes:</p>
            <ul>
                <li>No schedules created for {{ $dayName }}</li>
                <li>Student class doesn't have schedules</li>
                <li>All schedules marked as inactive (is_active = false)</li>
                <li>Query scope issue</li>
            </ul>
            
            <h3>Debug Info - Raw Schedule Count</h3>
            <p>Total schedules in DB: @php echo \App\Models\Schedule::count() @endphp</p>
            <p>Schedules for {{ $dayName }}:  @php echo \App\Models\Schedule::where('day', $dayName)->count() @endphp</p>
            <p>Active schedules for {{ $dayName }}: @php echo \App\Models\Schedule::where('day', $dayName)->where('is_active', true)->count() @endphp</p>
            @if($student)
                <p>Schedules for class {{ $student->class_id }}: @php echo \App\Models\Schedule::where('class_id', $student->class_id)->count() @endphp</p>
                <p>Schedules for class {{ $student->class_id }} on {{ $dayName }}: @php echo \App\Models\Schedule::where('class_id', $student->class_id)->where('day', $dayName)->count() @endphp</p>
            @endif
        @else
            <p>✅ Found {{ $schedules->count() }} schedules</p>
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr style="background: #f0f0f0;">
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Subject</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Teacher</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Time</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedules as $schedule)
                        @php $att = $attendances[$schedule->id] ?? null; @endphp
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 8px;">{{ $schedule->subject->name ?? 'N/A' }}</td>
                            <td style="border: 1px solid #ddd; padding: 8px;">{{ $schedule->teacher->name ?? 'N/A' }}</td>
                            <td style="border: 1px solid #ddd; padding: 8px;">{{ $schedule->start_time?->format('H:i') ?? 'N/A' }} - {{ $schedule->end_time?->format('H:i') ?? 'N/A' }}</td>
                            <td style="border: 1px solid #ddd; padding: 8px;">
                                @if($att)
                                    <span style="color: green;">✅ {{ $att->status }}</span>
                                @else
                                    <span style="color: red;">❌ Not submitted</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    
    <!-- ATTENDANCE RECORDS -->
    <div style="background: white; padding: 15px; margin: 10px 0; border-left: 4px solid #dc3545;">
        <h2>Attendance Records for Today</h2>
        @if($attendances->isEmpty())
            <p>No attendance records submitted yet</p>
        @else
            <p>{{ $attendances->count() }} record(s) found</p>
        @endif
    </div>
    
    <!-- ACTION BUTTONS -->
    <div style="background: white; padding: 15px; margin: 10px 0;">
        <h2>Next Steps</h2>
        <a href="{{ route('attendance.today') }}" style="display: inline-block; padding: 10px 15px; background: blue; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px;">Back to Attendance (Normal View)</a>
        <a href="{{ route('dashboard') }}" style="display: inline-block; padding: 10px 15px; background: gray; color: white; text-decoration: none; border-radius: 4px;">Back to Dashboard</a>
    </div>

</div>
@endsection
