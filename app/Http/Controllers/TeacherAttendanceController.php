<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\TeacherAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherAttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = today();
        $dayName = $this->indonesianDayName($today);

        $schedules = Schedule::with('subject')
            ->where('teacher_id', $user->id)
            ->whereRaw('LOWER(TRIM(day)) = ?', [mb_strtolower($dayName)])
            ->active()
            ->orderBy('start_time')
            ->get();

        $attendances = TeacherAttendance::where('user_id', $user->id)
            ->whereRaw('date(date) = ?', [$today->toDateString()])
            ->get()
            ->keyBy('schedule_id');

        return view('teacher-attendance.index', compact('user', 'today', 'dayName', 'schedules', 'attendances'));
    }

    public function submit(Request $request, Schedule $schedule)
    {
        $user = Auth::user();
        $redirectUrl = $this->resolveRedirectUrl($request, 'teacher.attendance');

        if ((int) $schedule->teacher_id !== (int) $user->id) {
            abort(403, 'Jadwal ini bukan milik Anda.');
        }

        $today = today();
        $dayName = $this->indonesianDayName($today);
        if (mb_strtolower(trim((string) $schedule->day)) !== mb_strtolower($dayName)) {
            return redirect()->to($redirectUrl)
                ->with('error', 'Absensi guru hanya bisa dilakukan sesuai hari jadwal mengajar.');
        }

        $validated = $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'notes' => 'nullable|string|max:255',
        ]);

        if ($validated['status'] === 'hadir') {
            $now = now();
            $startRaw = $schedule->start_time instanceof Carbon
                ? $schedule->start_time->copy()
                : Carbon::parse((string) $schedule->start_time);
            $endRaw = $schedule->end_time instanceof Carbon
                ? $schedule->end_time->copy()
                : Carbon::parse((string) $schedule->end_time);

            $startAt = $today->copy()->setTime($startRaw->hour, $startRaw->minute, $startRaw->second);
            $endAt = $today->copy()->setTime($endRaw->hour, $endRaw->minute, $endRaw->second);

            if ($now->lt($startAt) || $now->gt($endAt)) {
                return redirect()->to($redirectUrl)
                    ->with('error', 'Status hadir hanya bisa diisi pada jam mengajar (' . $startAt->format('H:i') . ' - ' . $endAt->format('H:i') . ').');
            }
        }

        $attendanceDate = $today->copy()->startOfDay()->toDateTimeString();
        $timestamp = now();

        TeacherAttendance::query()->upsert(
            [[
                'user_id' => $user->id,
                'schedule_id' => $schedule->id,
                'date' => $attendanceDate,
                'status' => $validated['status'],
                'notes' => filled($validated['notes'] ?? null) ? trim((string) $validated['notes']) : null,
                'checked_in_at' => $timestamp,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]],
            ['user_id', 'schedule_id', 'date'],
            ['status', 'notes', 'checked_in_at', 'updated_at']
        );

        return redirect()->to($redirectUrl)
            ->with('success', 'Absensi mengajar berhasil disimpan.');
    }

    public function monitor(Request $request)
    {
        $dateInput = $request->input('date');
        $teacherQuery = trim((string) $request->input('teacher', ''));
        $date = today();

        if (is_string($dateInput) && trim($dateInput) !== '') {
            try {
                $date = Carbon::parse($dateInput);
            } catch (\Throwable $e) {
                $date = today();
            }
        }

        $dayName = $this->indonesianDayName($date);

        $teacherSchedules = Schedule::with(['subject', 'teacher'])
            ->whereRaw('LOWER(TRIM(day)) = ?', [mb_strtolower($dayName)])
            ->active()
            ->orderBy('start_time')
            ->orderBy('class_id')
            ->get();

        $attendanceMap = TeacherAttendance::with('teacher')
            ->whereRaw('date(date) = ?', [$date->toDateString()])
            ->get()
            ->keyBy(fn (TeacherAttendance $attendance) => $attendance->user_id . '-' . $attendance->schedule_id);

        $teacherWeeklyOverviewMap = Schedule::with(['subject', 'teacher'])
            ->active()
            ->when($teacherQuery !== '', function ($query) use ($teacherQuery) {
                $query->whereHas('teacher', function ($teacherSubQuery) use ($teacherQuery) {
                    $teacherSubQuery->where('name', 'like', '%' . $teacherQuery . '%')
                        ->orWhere('email', 'like', '%' . $teacherQuery . '%');
                });
            })
            ->get()
            ->groupBy('teacher_id')
            ->map(function ($items) {
                $first = $items->first();
                $dayOrder = ['Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6];

                $days = $items->pluck('day')
                    ->filter()
                    ->unique()
                    ->sortBy(fn ($day) => $dayOrder[(string) $day] ?? 99)
                    ->values()
                    ->all();

                $subjects = $items->pluck('subject.name')
                    ->filter()
                    ->unique()
                    ->values()
                    ->all();

                $classes = $items->pluck('class_id')
                    ->filter()
                    ->unique()
                    ->values()
                    ->all();

                return [
                    'teacher_name' => $first?->teacher?->name ?? '-',
                    'days' => $days,
                    'subjects' => $subjects,
                    'classes' => $classes,
                    'total_sessions' => $items->count(),
                ];
            })
            ->values();

        return view('teacher-attendance.monitor', compact(
            'date',
            'dayName',
            'teacherSchedules',
            'attendanceMap',
            'teacherQuery',
            'teacherWeeklyOverviewMap'
        ));
    }

    private function indonesianDayName(Carbon $date): string
    {
        return match ($date->format('l')) {
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            default => 'Senin',
        };
    }

    private function resolveRedirectUrl(Request $request, string $fallbackRoute): string
    {
        $baseUrl = rtrim(url('/'), '/');
        $explicitRedirect = (string) $request->input('redirect_to', '');

        if ($explicitRedirect !== '' && str_starts_with($explicitRedirect, $baseUrl)) {
            return $explicitRedirect;
        }

        $previousUrl = url()->previous();
        if (is_string($previousUrl) && str_starts_with($previousUrl, $baseUrl)) {
            return $previousUrl;
        }

        return route($fallbackRoute);
    }
}
