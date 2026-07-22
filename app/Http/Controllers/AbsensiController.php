<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AbsensiController extends Controller
{
    private function classMajor(string $classId): string
    {
        $value = preg_replace('/\s+/', ' ', trim($classId));
        if ($value === '') {
            return '';
        }

        $parts = array_values(array_filter(array_map('trim', explode('-', $value))));
        if (count($parts) >= 2) {
            return strtoupper((string) end($parts));
        }

        $tokens = preg_split('/\s+/', $value) ?: [];
        return strtoupper((string) end($tokens));
    }

    private function classLevel(string $classId): string
    {
        $value = strtoupper(preg_replace('/\s+/', ' ', trim($classId)));
        if ($value === '') {
            return '';
        }

        if (preg_match('/\b(XII|XI|X1|X)\b/', $value, $matches) === 1) {
            $level = $matches[1];
            return $level === 'X1' ? 'XI' : $level;
        }

        return '';
    }

    private function classSignature(string $classId): string
    {
        $level = $this->classLevel($classId);
        $major = $this->classMajor($classId);

        if ($level === '' || $major === '') {
            return '';
        }

        return $level . '|' . $major;
    }

    private function classIdAliases(string $classId): array
    {
        $base = preg_replace('/\s+/', ' ', trim($classId));
        if ($base === '') {
            return [];
        }

        $aliases = [$base];

        if (preg_match('/\bXI\b/i', $base)) {
            $aliases[] = preg_replace('/\bXI\b/i', 'X1', $base);
        }

        if (preg_match('/\bX1\b/i', $base)) {
            $aliases[] = preg_replace('/\bX1\b/i', 'XI', $base);
        }

        return array_values(array_unique(array_map(
            static fn (string $value): string => preg_replace('/\s+/', ' ', trim($value)),
            $aliases
        )));
    }

    private function expandClassIds(Collection $classIds): Collection
    {
        return $classIds
            ->filter()
            ->flatMap(fn ($classId) => $this->classIdAliases((string) $classId))
            ->unique()
            ->values();
    }

    private function isTeacherRole(string $role): bool
    {
        return in_array($role, ['guru', 'teacher'], true);
    }

    private function teacherAllowedStudentIds(int $teacherId)
    {
        $teacher = User::find($teacherId);

        $classIds = Schedule::where(function ($query) use ($teacherId, $teacher) {
                $query->where('teacher_id', $teacherId);

                if ($teacher) {
                    $query->orWhereHas('subject', function ($subjectQuery) use ($teacher) {
                        $subjectQuery->where('teacher', $teacher->name)
                            ->orWhere('teacher', $teacher->email);
                    });
                }
            })
            ->pluck('class_id')
            ->filter()
            ->unique();

        $classIds = $this->expandClassIds($classIds);

        return Student::whereIn('class_id', $classIds)->pluck('id');
    }

    public function index()
    {
        /** @var \App\Models\User $user */
        $user    = Auth::user();
        $student = Student::findByUser($user);

        $today = today();
        $dayMapping = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];
        $dayName = $dayMapping[$today->format('l')] ?? $today->format('l');

        if (!$student) {
            return view('absensi.index', [
                'attendances'     => collect(),
                'attendanceStats' => ['hadir'=>0,'sakit'=>0,'izin'=>0,'alpha'=>0],
                'today'           => $today,
                'dayName'         => $dayName,
                'todaySchedules'  => collect(),
                'todayAttendances'=> collect(),
                'student'         => null,
            ]);
        }

        $attendances = Attendance::where('student_id', $student->id)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->orderBy('date', 'asc')
            ->get();

        $attendanceStats = [
            'hadir' => $attendances->where('status', 'hadir')->count(),
            'sakit' => $attendances->where('status', 'sakit')->count(),
            'izin'  => $attendances->where('status', 'izin')->count(),
            'alpha' => $attendances->where('status', 'alpha')->count(),
        ];

        $todaySchedules = Schedule::with(['subject', 'teacher'])
            ->byClass($student->class_id)
            ->byDay($dayName)
            ->active()
            ->orderBy('start_time')
            ->get();

        $todayScheduleIds = $todaySchedules->pluck('id');
        $todayAttendances = $todayScheduleIds->isNotEmpty()
            ? Attendance::where('student_id', $student->id)
                ->where('date', $today->toDateString())
                ->whereIn('schedule_id', $todayScheduleIds)
                ->get()
                ->keyBy('schedule_id')
            : collect();

        return view('absensi.index', compact(
            'attendances',
            'attendanceStats',
            'today',
            'dayName',
            'todaySchedules',
            'todayAttendances',
            'student'
        ));
    }

    public function adminIndex(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isTeacher = $this->isTeacherRole($user->role);

        $bulan     = $request->input('bulan', now()->month);
        $tahun     = $request->input('tahun', now()->year);
        $studentId = $request->input('student_id');
        $classId = $request->input('class_id');
        $subjectId = $request->input('subject_id');

        $teacherSchedules = collect();
        $teacherScheduleIds = collect();
        $teacherClassIds = collect();

        $query = Attendance::with(['student', 'schedule.subject', 'schedule.teacher'])
            ->orderByDesc('submitted_at')
            ->orderBy('date', 'desc');
        $query->whereMonth('date', $bulan)->whereYear('date', $tahun);

        $scheduleOptions = $isTeacher
            ? collect()
            : Schedule::with('subject')
                ->active()
                ->orderBy('day')
                ->orderBy('start_time')
                ->get();

        if ($isTeacher) {
            $teacherSchedules = Schedule::with(['subject'])
                ->where(function ($query) use ($user) {
                    $query->where('teacher_id', $user->id)
                        ->orWhereHas('subject', function ($subjectQuery) use ($user) {
                            $subjectQuery->where('teacher', $user->name)
                                ->orWhere('teacher', $user->email);
                        });
                })
                ->active()
                ->orderBy('day')
                ->orderBy('start_time')
                ->get();

            $scheduleOptions = $teacherSchedules->values();

            $teacherScheduleIds = $teacherSchedules->pluck('id');
            $teacherClassIds = $teacherSchedules->pluck('class_id')->filter()->unique()->values();
            $teacherClassIds = $this->expandClassIds($teacherClassIds);
            $allowedStudentIds = Student::whereIn('class_id', $teacherClassIds)->pluck('id');

            $query->whereIn('student_id', $allowedStudentIds);

            if ($studentId && !$allowedStudentIds->contains((int) $studentId)) {
                $studentId = null;
            }
        }

        $classOptions = $scheduleOptions
            ->pluck('class_id')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        if ($classId && !$classOptions->contains((string) $classId)) {
            $classId = null;
        }

        $subjectOptions = $scheduleOptions
            ->pluck('subject')
            ->filter()
            ->unique('id')
            ->sortBy('name')
            ->values();

        if ($subjectId && !$subjectOptions->pluck('id')->contains((int) $subjectId)) {
            $subjectId = null;
        }

        $effectiveSchedules = $scheduleOptions->filter(function ($schedule) use ($classId, $subjectId) {
            if ($classId && (string) $schedule->class_id !== (string) $classId) {
                return false;
            }
            if ($subjectId && (int) $schedule->subject_id !== (int) $subjectId) {
                return false;
            }

            return true;
        });

        $effectiveScheduleIds = $effectiveSchedules->pluck('id');
        $hasScheduleFilter = !empty($classId) || !empty($subjectId);

        if ($isTeacher || $hasScheduleFilter) {
            $query->whereIn('schedule_id', $effectiveScheduleIds);
        }

        if ($studentId) {
            $query->where('student_id', $studentId);
        }

        $attendances = $query->paginate(20)->withQueryString();

        $studentsQuery = $isTeacher
            ? Student::whereIn('id', $allowedStudentIds ?? collect())
            : Student::query();

        if ($classId) {
            $studentsQuery->whereIn('class_id', $this->classIdAliases((string) $classId));
        }

        if ($subjectId) {
            $subjectClassIds = $this->expandClassIds(
                $effectiveSchedules->pluck('class_id')->filter()->unique()->values()
            );
            $studentsQuery->whereIn('class_id', $subjectClassIds);
        }

        $students = $studentsQuery->orderBy('name')->get();

        if ($subjectId && $students->isEmpty()) {
            $subjectClassSignatures = $effectiveSchedules
                ->pluck('class_id')
                ->flatMap(fn ($classId) => $this->classIdAliases((string) $classId))
                ->map(fn ($classId) => $this->classSignature((string) $classId))
                ->filter()
                ->unique()
                ->values();

            if ($subjectClassSignatures->isNotEmpty()) {
                $fallbackStudentsQuery = $isTeacher
                    ? Student::whereIn('id', $allowedStudentIds ?? collect())
                    : Student::query();

                if ($classId) {
                    $fallbackStudentsQuery->whereIn('class_id', $this->classIdAliases((string) $classId));
                }

                $students = $fallbackStudentsQuery
                    ->orderBy('name')
                    ->get()
                    ->filter(fn ($student) => $subjectClassSignatures->contains($this->classSignature((string) $student->class_id)))
                    ->values();
            }

            if ($students->isEmpty() && !$classId) {
                $subjectMajors = $effectiveSchedules
                    ->pluck('class_id')
                    ->map(fn ($scheduleClass) => $this->classMajor((string) $scheduleClass))
                    ->filter()
                    ->unique()
                    ->values();

                if ($subjectMajors->isNotEmpty()) {
                    $fallbackMajorQuery = $isTeacher
                        ? Student::whereIn('id', $allowedStudentIds ?? collect())
                        : Student::query();

                    $students = $fallbackMajorQuery
                        ->orderBy('name')
                        ->get()
                        ->filter(fn ($student) => $subjectMajors->contains($this->classMajor((string) $student->class_id)))
                        ->values();
                }
            }
        }

        $statsQuery = Attendance::whereMonth('date', $bulan)
            ->whereYear('date', $tahun);

        if ($isTeacher) {
            $statsQuery->whereIn('student_id', $allowedStudentIds ?? collect())
                ->whereIn('schedule_id', $effectiveScheduleIds);
        } elseif ($hasScheduleFilter) {
            $statsQuery->whereIn('schedule_id', $effectiveScheduleIds);
        }

        $stats = [
            'hadir' => (clone $statsQuery)->where('status', 'hadir')->count(),
            'sakit' => (clone $statsQuery)->where('status', 'sakit')->count(),
            'izin'  => (clone $statsQuery)->where('status', 'izin')->count(),
            'alpha' => (clone $statsQuery)->where('status', 'alpha')->count(),
        ];

        $rekap = $students->map(function ($student) use ($bulan, $tahun, $effectiveScheduleIds, $isTeacher, $hasScheduleFilter) {
            $absenSiswa = Attendance::where('student_id', $student->id)
                ->whereMonth('date', $bulan)
                ->whereYear('date', $tahun)
            ->when($isTeacher || $hasScheduleFilter, fn ($q) => $q->whereIn('schedule_id', $effectiveScheduleIds))
                ->get();

            return [
                'student' => $student,
                'hadir'   => $absenSiswa->where('status', 'hadir')->count(),
                'sakit'   => $absenSiswa->where('status', 'sakit')->count(),
                'izin'    => $absenSiswa->where('status', 'izin')->count(),
                'alpha'   => $absenSiswa->where('status', 'alpha')->count(),
                'total'   => $absenSiswa->count(),
            ];
        });

        return view('absensi.admin', compact(
            'attendances',
            'students',
            'stats',
            'bulan',
            'tahun',
            'rekap',
            'studentId',
            'classId',
            'subjectId',
            'classOptions',
            'subjectOptions',
            'teacherSchedules',
            'scheduleOptions'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'schedule_id'=> 'required|exists:schedules,id',
            'date'       => 'required|date',
            'status'     => 'required|in:hadir,sakit,izin,alpha',
            'keterangan' => 'nullable|string|max:255',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $schedule = Schedule::findOrFail((int) $request->schedule_id);
        $student = Student::findOrFail((int) $request->student_id);

        $allowedStudentClasses = $this->classIdAliases((string) $schedule->class_id);
        $isSameClass = in_array((string) $student->class_id, $allowedStudentClasses, true);

        if (!$isSameClass) {
            $scheduleHasStudents = Student::whereIn('class_id', $allowedStudentClasses)->exists();
            if (!$scheduleHasStudents) {
                $scheduleSignatures = collect($allowedStudentClasses)
                    ->map(fn ($classId) => $this->classSignature((string) $classId))
                    ->filter()
                    ->unique();

                $isSameClass = $scheduleSignatures->contains($this->classSignature((string) $student->class_id));
            }
        }

        if (!$isSameClass) {
            return back()->with('error', 'Siswa tidak berada pada kelas yang sesuai jadwal/mapel terpilih.')->withInput();
        }

        if ($this->isTeacherRole($user->role)) {
            $allowedStudentIds = $this->teacherAllowedStudentIds($user->id);
            if (!$allowedStudentIds->contains((int) $request->student_id)) {
                return back()->with('error', 'Anda hanya bisa input absensi untuk kelas yang diajar.');
            }

            $allowedScheduleIds = Schedule::where(function ($query) use ($user) {
                    $query->where('teacher_id', $user->id)
                        ->orWhereHas('subject', function ($subjectQuery) use ($user) {
                            $subjectQuery->where('teacher', $user->name)
                                ->orWhere('teacher', $user->email);
                        });
                })
                ->active()
                ->pluck('id');

            if (!$allowedScheduleIds->contains((int) $request->schedule_id)) {
                return back()->with('error', 'Anda hanya bisa input absensi untuk jadwal yang Anda ajar.')->withInput();
            }
        }

        $attendanceDate = Carbon::parse((string) $request->date)->startOfDay();
        $dateOnly = $attendanceDate->toDateString();

        $existing = Attendance::where('student_id', $request->student_id)
            ->where('schedule_id', $request->schedule_id)
            ->whereRaw('date(date) = ?', [$dateOnly])
            ->first();

        if ($existing) {
            $existing->update([
                'status' => $request->status,
                'keterangan' => $request->keterangan,
                'submitted_at' => now(),
                'verification_status' => 'pending',
            ]);

            return back()->with('success', 'Absensi pada tanggal yang sama sudah ada, data berhasil diperbarui.');
        }

        Attendance::create([
            'student_id' => $request->student_id,
            'schedule_id'=> $request->schedule_id,
            'date'       => $attendanceDate->toDateTimeString(),
            'status'     => $request->status,
            'keterangan' => $request->keterangan,
            'created_by' => Auth::id(),
            'submitted_at' => now(),
            'verification_status' => 'pending',
        ]);

        return back()->with('success', 'Absensi berhasil ditambahkan.');
    }

    public function update(Request $request, Attendance $absensi)
    {
        $request->validate([
            'date'       => 'required|date',
            'status'     => 'required|in:hadir,sakit,izin,alpha',
            'keterangan' => 'nullable|string|max:255',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($this->isTeacherRole($user->role)) {
            $allowedStudentIds = $this->teacherAllowedStudentIds($user->id);
            if (!$allowedStudentIds->contains((int) $absensi->student_id)) {
                abort(403, 'Anda tidak memiliki akses untuk mengubah absensi ini.');
            }
        }

        $attendanceDate = Carbon::parse((string) $request->date)->startOfDay();
        $dateOnly = $attendanceDate->toDateString();

        $duplicate = Attendance::where('student_id', $absensi->student_id)
            ->where('schedule_id', $absensi->schedule_id)
            ->whereRaw('date(date) = ?', [$dateOnly])
            ->where('id', '!=', $absensi->id)
            ->exists();

        if ($duplicate) {
            return back()->with('error', 'Tanggal tersebut sudah terisi untuk siswa dan jadwal yang sama.')->withInput();
        }

        $absensi->update([
            'date'       => $attendanceDate->toDateTimeString(),
            'status'     => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return back(302, [], route('absensi.admin'))->with('success', 'Absensi berhasil diperbarui.');
    }

    public function destroy(Attendance $absensi)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($this->isTeacherRole($user->role)) {
            $allowedStudentIds = $this->teacherAllowedStudentIds($user->id);
            if (!$allowedStudentIds->contains((int) $absensi->student_id)) {
                abort(403, 'Anda tidak memiliki akses untuk menghapus absensi ini.');
            }
        }

        $absensi->delete();

        return back(302, [], route('absensi.admin'))->with('success', 'Absensi berhasil dihapus.');
    }
}