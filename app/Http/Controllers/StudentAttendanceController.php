<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAttendanceController extends Controller
{
    private function teacherManagedSchedules(User $teacher)
    {
        return Schedule::with('subject')
            ->where(function ($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id)
                    ->orWhereHas('subject', function ($subjectQuery) use ($teacher) {
                        $subjectQuery->where('teacher', $teacher->name)
                            ->orWhere('teacher', $teacher->email);
                    });
            })
            ->active()
            ->get();
    }

    private function teacherCanManageSchedule(User $teacher, Schedule $schedule): bool
    {
        $schedule->loadMissing('subject');

        return (int) $schedule->teacher_id === (int) $teacher->id
            || in_array((string) $schedule->subject?->teacher, [(string) $teacher->name, (string) $teacher->email], true);
    }

    /**
     * Siswa lihat jadwal hari ini dan absen per mapel
     */
    public function todaySchedule()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $student = Student::findByUser($user);

        if (!$student) {
            return back()->withErrors('Data siswa tidak ditemukan. Hubungi admin untuk setup akun siswa Anda.');
        }

        $today = today();
        $dayName = $this->getDayNameIndonesian($today);

        $this->backfillMissedAttendances($student, $today);

        $schedules = Schedule::with(['subject', 'teacher'])
            ->byClass($student->class_id)
            ->byDay($dayName)
            ->active()
            ->orderBy('start_time')
            ->orderBy('subject_id')
            ->get();

        $todayDate = $today->toDateString();
        $attendances = Attendance::where('student_id', $student->id)
            ->whereRaw('date(date) = ?', [$todayDate])
            ->get()
            ->keyBy('schedule_id');

        $notSubmittedCount = $schedules->count() - $attendances->count();

        return view('student-attendance.today-schedule', compact(
            'student',
            'today',
            'dayName',
            'schedules',
            'attendances',
            'notSubmittedCount'
        ));
    }

    /**
     * Siswa submit attendance untuk satu mapel
     * Dipanggil via:
     *   POST /absen-mapel/{schedule}  (route model binding)
     *   POST /absensi                 (JSON fetch dari jadwal page — schedule_id di body)
     */
    public function submitAttendance(Request $request, Schedule $schedule = null)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $student = Student::findByUser($user);

        if (!$student) {
            return $this->jsonOrBack($request, 'Data siswa tidak ditemukan.', 404);
        }

        $rules = [
            'status'     => 'required|in:hadir,sakit,izin,alpha',
            'keterangan' => 'nullable|string|max:500',
            'comment'    => 'nullable|string|max:500',
            'proof'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Max 2MB
        ];

        if (!$schedule) {
            $rules['schedule_id'] = 'required|exists:schedules,id';
        }

        $validated = $request->validate($rules);

        if (!$schedule) {
            $schedule = Schedule::findOrFail($validated['schedule_id']);
        }

        if ((string) $schedule->class_id !== (string) $student->class_id) {
            return $this->jsonOrBack($request, 'Jadwal ini bukan untuk kelas Anda.', 403);
        }

        $todayDate = today()->toDateString();
        $todayDateKey = today()->copy()->startOfDay()->toDateTimeString();
        $scheduledDate = $this->resolveScheduleDateForWeek($schedule, today());

        $existingTodayAttendance = Attendance::where('student_id', $student->id)
            ->where('schedule_id', $schedule->id)
            ->whereRaw('date(date) = ?', [$todayDate])
            ->first();

        if (
            $existingTodayAttendance
            && in_array((string) $existingTodayAttendance->verification_status, ['verified', 'rejected'], true)
        ) {
            $lockedMessage = $existingTodayAttendance->verification_status === 'rejected'
                ? ($existingTodayAttendance->verification_note ?: 'Absensi Anda ditolak dan ditetapkan sebagai alpha oleh admin/guru.')
                : 'Absensi Anda sudah diverifikasi dan tidak dapat diubah lagi.';

            return $this->jsonOrBack($request, $lockedMessage, 422);
        }

        if ($scheduledDate && $scheduledDate->toDateString() !== $todayDate) {
            if ($scheduledDate->lessThan(today())) {
                $scheduledDateKey = $scheduledDate->copy()->startOfDay()->toDateTimeString();
                $alphaData = [
                    'status'              => 'alpha',
                    'keterangan'          => 'Alpha otomatis karena tidak absen pada hari jadwal.',
                    'comment'             => 'Alpha otomatis karena tidak absen pada hari jadwal.',
                    'submitted_at'        => now(),
                    'verification_status' => 'pending',
                    'created_by'          => $user->id,
                ];

                $existingMissed = Attendance::where('student_id', $student->id)
                    ->where('schedule_id', $schedule->id)
                    ->whereRaw('date(date) = ?', [$scheduledDate->toDateString()])
                    ->first();

                if ($existingMissed) {
                    if (!in_array((string) $existingMissed->verification_status, ['verified', 'rejected'], true)) {
                        $existingMissed->update($alphaData);
                    }
                } else {
                    Attendance::create([
                        'student_id'  => $student->id,
                        'schedule_id' => $schedule->id,
                        'date'        => $scheduledDateKey,
                    ] + $alphaData);
                }

                return $this->jsonOrBack($request, 'Sesi ini sudah lewat dan otomatis dianggap alpha.', 422);
            }

            return $this->jsonOrBack($request, 'Absensi hanya bisa dilakukan pada hari jadwalnya.', 422);
        }

        $this->backfillMissedAttendances($student, today());

        $comment = $validated['keterangan'] ?? $validated['comment'] ?? null;

        $proofPath = null;
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('attendance_proofs', 'public');
        }

        // Prepare attendance data
        $attendanceData = [
            'status'              => $validated['status'],
            'keterangan'          => $comment,
            'comment'             => $comment,
            'submitted_at'        => now(),
            'verification_status' => 'pending',
            'created_by'          => $user->id,
            'proof_path'          => $proofPath,
        ];

        $attendance = $existingTodayAttendance;

        if ($attendance) {
            $attendance->update($attendanceData);
        } else {
            try {
                $attendance = Attendance::create([
                    'student_id'  => $student->id,
                    'schedule_id' => $schedule->id,
                    'date'        => $todayDateKey,
                ] + $attendanceData);
            } catch (QueryException $exception) {
                if (!$this->isDuplicateAttendanceException($exception)) {
                    throw $exception;
                }

                $attendance = Attendance::where('student_id', $student->id)
                    ->where('schedule_id', $schedule->id)
                    ->whereRaw('date(date) = ?', [$todayDate])
                    ->first();

                if ($attendance) {
                    $attendance->update($attendanceData);
                } else {
                    throw $exception;
                }
            }
        }

        $message = $attendance->wasRecentlyCreated
            ? 'Absensi berhasil disimpan.'
            : 'Absensi berhasil diperbarui.';

        if ($request->expectsJson()) {
            return response()->json([
                'success'    => true,
                'message'    => $message,
                'attendance' => $attendance,
            ], 200);
        }

        return back()->with('success', $message);
    }

    /**
     * Siswa mengajukan perubahan absensi (undo) jika status masih pending.
     */
    public function undoAttendance(Request $request, Attendance $attendance)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ((int) $attendance->student_id !== (int) $user->student->id) {
            return back()->withErrors('Anda tidak memiliki akses untuk mengubah absensi ini.');
        }

        if (in_array((string) $attendance->verification_status, ['verified', 'rejected'], true)) {
            return back()->withErrors('Absensi sudah diverifikasi/ditolak dan tidak dapat diubah lagi.');
        }

        // Delete the attendance record, allowing the student to resubmit.
        // If there was a proof file, it should also be deleted.
        if ($attendance->proof_path) {
            \Storage::disk('public')->delete($attendance->proof_path);
        }
        $attendance->delete();
        return back()->with('success', 'Pengajuan perubahan absensi berhasil. Anda bisa mengisi ulang absensi untuk mapel ini.');
    }

    /**
     * Admin manage attendance - lihat dan edit
     */
    public function manageAttendance(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $query = Attendance::with(['student', 'schedule.subject', 'schedule.teacher', 'createdBy']);

        $date = $request->input('date', today()->toDateString());
        $query->whereRaw('date(date) = ?', [$date]);
        $selectedStudentId = $request->filled('student_id') ? (int) $request->student_id : null;
        $selectedStudent = null;

        $classes = Student::distinct('class_id')
            ->orderBy('class_id')
            ->get(['class_id'])
            ->map(fn ($s) => (string) $s->class_id)
            ->values();
        $subjects = collect();
        $students = collect();
        $scheduleOptions = collect();

        if ($user->isGuru()) {
            $teacherSchedules = $this->teacherManagedSchedules($user);
            $teacherScheduleIds = $teacherSchedules->pluck('id')->values();
            $teacherClassIds = $teacherSchedules
                ->pluck('class_id')
                ->filter()
                ->map(fn ($classId) => (string) $classId)
                ->unique()
                ->values();
            $teacherSubjectIds = $teacherSchedules
                ->pluck('subject_id')
                ->filter()
                ->map(fn ($subjectId) => (int) $subjectId)
                ->unique()
                ->values();
            $teacherSubjects = $teacherSchedules
                ->pluck('subject')
                ->filter()
                ->unique('id')
                ->values();
            $filteredTeacherSchedules = $teacherSchedules;

            if ($request->filled('class')) {
                $requestedClass = (string) $request->class;
                $filteredTeacherSchedules = $filteredTeacherSchedules->where('class_id', $requestedClass)->values();
            }

            if ($request->filled('subject_id')) {
                $requestedSubjectId = (int) $request->subject_id;
                $filteredTeacherSchedules = $filteredTeacherSchedules->where('subject_id', $requestedSubjectId)->values();
            }

            $studentClassIds = $filteredTeacherSchedules
                ->pluck('class_id')
                ->filter()
                ->map(fn ($classId) => (string) $classId)
                ->unique()
                ->values();

            $classes = $teacherClassIds;
            $subjects = $teacherSubjects;
            $students = $studentClassIds->isNotEmpty()
                ? Student::whereIn('class_id', $studentClassIds)
                    ->orderBy('class_id')
                    ->orderBy('name')
                    ->get()
                : collect();

            if ($selectedStudentId) {
                $selectedStudent = $students->firstWhere('id', $selectedStudentId);

                if (!$selectedStudent) {
                    $query->whereRaw('1 = 0');
                } else {
                    $query->where('student_id', $selectedStudentId);
                }
            }

            if ($teacherScheduleIds->isEmpty()) {
                $query->whereRaw('1 = 0');
            } else {
                $query->whereIn('schedule_id', $teacherScheduleIds);
            }

            if ($request->filled('class')) {
                $requestedClass = (string) $request->class;

                if (!$teacherClassIds->contains($requestedClass)) {
                    $query->whereRaw('1 = 0');
                } else {
                    $query->whereHas('student', fn ($q) => $q->where('class_id', $requestedClass));
                }
            }

            if ($request->filled('subject_id')) {
                $requestedSubjectId = (int) $request->subject_id;

                if (!$teacherSubjectIds->contains($requestedSubjectId)) {
                    $query->whereRaw('1 = 0');
                } else {
                    $query->whereHas('schedule', fn ($scheduleQuery) => $scheduleQuery->where('subject_id', $requestedSubjectId));
                }
            }
        } elseif ($request->filled('class')) {
            $query->whereHas('student', fn ($q) => $q->where('class_id', $request->class));

            if ($request->filled('subject_id')) {
                $query->whereHas('schedule', fn ($scheduleQuery) => $scheduleQuery->where('subject_id', $request->subject_id));
            }
        } elseif ($request->filled('subject_id')) {
            $query->whereHas('schedule', fn ($scheduleQuery) => $scheduleQuery->where('subject_id', $request->subject_id));
        }

        if (!$user->isGuru() && $selectedStudentId) {
            $selectedStudent = Student::find($selectedStudentId);

            if ($selectedStudent) {
                $query->where('student_id', $selectedStudentId);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        if (!$user->isGuru()) {
            $studentClassIds = collect();

            if ($request->filled('class')) {
                $studentClassIds->push((string) $request->class);
            }

            if ($request->filled('subject_id')) {
                $subjectSchedules = Schedule::with('subject')
                    ->where('subject_id', (int) $request->subject_id)
                    ->active()
                    ->get();

                $studentClassIds = $studentClassIds
                    ->merge($subjectSchedules->pluck('class_id')->filter()->map(fn ($classId) => (string) $classId))
                    ->unique()
                    ->values();
            }

            if ($studentClassIds->isNotEmpty()) {
                $students = Student::whereIn('class_id', $studentClassIds)
                    ->orderBy('class_id')
                    ->orderBy('name')
                    ->get();
            }
        }

        if (!$user->isGuru() && $selectedStudentId) {
            $selectedStudent = Student::find($selectedStudentId);

            if ($selectedStudent) {
                $query->where('student_id', $selectedStudentId);
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        if ($user->isGuru()) {
            $scheduleOptions = isset($teacherSchedules)
                ? $teacherSchedules
                : collect();

            if ($selectedStudent) {
                $scheduleOptions = $scheduleOptions
                    ->where('class_id', (string) $selectedStudent->class_id)
                    ->values();
            }

            if ($request->filled('class')) {
                $scheduleOptions = $scheduleOptions
                    ->where('class_id', (string) $request->class)
                    ->values();
            }

            if ($request->filled('subject_id')) {
                $scheduleOptions = $scheduleOptions
                    ->where('subject_id', (int) $request->subject_id)
                    ->values();
            }
        } else {
            $scheduleOptions = Schedule::with(['subject', 'teacher'])
                ->active()
                ->orderBy('day')
                ->orderBy('start_time')
                ->get();

            if ($selectedStudent) {
                $scheduleOptions = $scheduleOptions
                    ->where('class_id', (string) $selectedStudent->class_id)
                    ->values();
            }

            if ($request->filled('class')) {
                $scheduleOptions = $scheduleOptions
                    ->where('class_id', (string) $request->class)
                    ->values();
            }

            if ($request->filled('subject_id')) {
                $scheduleOptions = $scheduleOptions
                    ->where('subject_id', (int) $request->subject_id)
                    ->values();
            }
        }

        $attendances = $query->orderByDesc('date')
            ->orderBy('student_id')
            ->paginate(20);

        return view('student-attendance.manage-simple', compact('attendances', 'classes', 'subjects', 'students', 'selectedStudentId', 'selectedStudent', 'scheduleOptions'));
    }

    /**
     * Admin update attendance status
     */
    public function updateAttendance(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'status'     => 'required|in:hadir,sakit,izin,alpha',
            'keterangan' => 'nullable|string|max:500',
        ]);

        /** @var \App\Models\User $actor */
        $actor = Auth::user();
        if ($actor->isGuru()) {
            $attendance->loadMissing('schedule.subject');

            if (!$attendance->schedule || !$this->teacherCanManageSchedule($actor, $attendance->schedule)) {
                abort(403, 'Anda hanya bisa mengubah absensi untuk kelas atau mapel yang Anda ajar.');
            }
        }

        $updateData = [
            'status'              => $validated['status'],
            'keterangan'          => $validated['keterangan'] ?? null,
            'comment'             => $validated['keterangan'] ?? null,
            'verification_status' => $attendance->verification_status ?? 'verified',
        ];

        $attendance->update($updateData);

        return back(302, [], route('attendance.manage'))->with('success', 'Data absensi berhasil diupdate.');
    }

    /**
     * Get attendance JSON untuk real-time display
     */
    public function getAttendanceJson(Request $request, Schedule $schedule)
    {
        $date = $request->query('date', today()->toDateString());
        /** @var User $user */
        $user = Auth::user();

        if ($user->isGuru() && !$this->teacherCanManageSchedule($user, $schedule)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda hanya bisa melihat absensi untuk kelas atau mapel yang Anda ajar.',
            ], 403);
        }

        $attendances = Attendance::with('student')
            ->where('schedule_id', $schedule->id)
            ->whereRaw('date(date) = ?', [$date])
            ->get()
            ->map(fn ($att) => [
                'id'                  => $att->id,
                'student_name'        => $att->student->name,
                'status'              => $att->status,
                'comment'             => $att->comment,
                'verification_status' => $att->verification_status,
                'timestamp'           => $att->submitted_at?->format('H:i:s'),
            ]);

        return response()->json([
            'success'     => true,
            'schedule'    => $schedule->load(['subject', 'teacher']),
            'date'        => $date,
            'attendances' => $attendances,
        ]);
    }

    /**
     * Siswa lihat history absensi mereka
     */
    public function myAttendanceHistory(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $student = Student::findByUser($user);

        if (!$student) {
            return back()->withErrors('Data siswa tidak ditemukan. Hubungi admin.');
        }

        $query = Attendance::with(['schedule.subject', 'schedule.teacher', 'createdBy'])
            ->where('student_id', $student->id);

        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->to_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->orderByDesc('date')->paginate(20);

        $allAttendances = Attendance::where('student_id', $student->id)->get();
        $summary = [
            'hadir' => $allAttendances->where('status', 'hadir')->count(),
            'sakit' => $allAttendances->where('status', 'sakit')->count(),
            'izin'  => $allAttendances->where('status', 'izin')->count(),
            'alpha' => $allAttendances->where('status', 'alpha')->count(),
        ];

        return view('student-attendance.history-simple', compact('student', 'attendances', 'summary'));
    }

    /**
     * Konversi Carbon ke nama hari Bahasa Indonesia
     */
    private function getDayNameIndonesian(Carbon $date): string
    {
        $map = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];

        return $map[$date->format('l')] ?? $date->format('l');
    }

    /**
     * Return JSON jika request expects JSON, otherwise redirect back with error
     */
    private function jsonOrBack(Request $request, string $message, int $status)
    {
        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => $message], $status);
        }

        return back()->withErrors($message);
    }

    private function isDuplicateAttendanceException(QueryException $exception): bool
    {
        $message = $exception->getMessage();

        return str_contains($message, 'UNIQUE constraint failed: attendances.student_id, attendances.schedule_id, attendances.date')
            || str_contains($message, '23000');
    }

    private function backfillMissedAttendances(Student $student, Carbon $untilDate): void
    {
        $dayOffsets = [
            'Senin'  => 0,
            'Selasa' => 1,
            'Rabu'   => 2,
            'Kamis'  => 3,
            'Jumat'  => 4,
            'Sabtu'  => 5,
        ];

        $weekStart = Carbon::parse($untilDate)->startOfWeek(Carbon::MONDAY);
        $schedules = Schedule::where('class_id', $student->class_id)
            ->active()
            ->get();

        foreach ($schedules as $schedule) {
            $offset = $dayOffsets[$schedule->day] ?? null;
            if ($offset === null) {
                continue;
            }

            $scheduleDate = (clone $weekStart)->addDays($offset)->toDateString();

            if ($scheduleDate >= $untilDate->toDateString()) {
                continue;
            }

            $alphaData = [
                'status'              => 'alpha',
                'keterangan'          => 'Alpha otomatis karena tidak absen pada hari jadwal.',
                'comment'             => 'Alpha otomatis karena tidak absen pada hari jadwal.',
                'submitted_at'        => now(),
                'verification_status' => 'pending',
                'created_by'          => Auth::id(),
            ];

            $existing = Attendance::where('student_id', $student->id)
                ->where('schedule_id', $schedule->id)
                ->whereRaw('date(date) = ?', [$scheduleDate])
                ->first();

            if ($existing) {
                if (in_array((string) $existing->verification_status, ['verified', 'rejected'], true)) {
                    continue;
                }

                $existing->update($alphaData);
                continue;
            }

            Attendance::create([
                'student_id'  => $student->id,
                'schedule_id' => $schedule->id,
                'date'        => Carbon::parse($scheduleDate)->startOfDay()->toDateTimeString(),
            ] + $alphaData);
        }
    }

    private function resolveScheduleDateForWeek(Schedule $schedule, Carbon $referenceDate): ?Carbon
    {
        $dayOffsets = [
            'Senin'  => 0,
            'Selasa' => 1,
            'Rabu'   => 2,
            'Kamis'  => 3,
            'Jumat'  => 4,
            'Sabtu'  => 5,
        ];

        if (!array_key_exists($schedule->day, $dayOffsets)) {
            return null;
        }

        return Carbon::parse($referenceDate)->startOfWeek(Carbon::MONDAY)->addDays($dayOffsets[$schedule->day]);
    }
}