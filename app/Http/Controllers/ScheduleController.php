<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Subject;
use App\Models\User;
use App\Models\Student;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user         = Auth::user();
        $dayOrder     = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $missingClass = false;
        $filter       = request()->query('filter', 'all');
        $riwayatAbsen = collect();
        $absensiSummary = ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alpha' => 0];
        $student      = null;
        $subjectTeachers = collect();

        $selectedDay = request()->query('day');
        if (!in_array($selectedDay, $dayOrder, true)) {
            $dow         = Carbon::now()->dayOfWeek;
            $dowMap      = [0=>0, 1=>0, 2=>1, 3=>2, 4=>3, 5=>4, 6=>5];
            $selectedDay = $dayOrder[$dowMap[$dow] ?? 0];
        }

        $subjects = collect();

        if ($user->role === 'siswa') {
            $student = Student::findByUser($user);
            $classId = $student?->class_id ?? null;

            if (!$classId) {
                $schedules        = collect()->groupBy('day');
                $subjects         = collect();
                $subjectTeachers  = collect();
                $missingClass     = true;
            } else {
                $student = Student::findByUser($user);
                $raw = Schedule::with(['subject', 'teacher', 'absensiHariIni'])
                    ->byClass($classId)->active()
                    ->orderBy('day')->orderBy('start_time')
                    ->get();

                $subjects = Subject::active()->where('class_id', $classId)->get();
                $subjectTeachers = $raw->groupBy('subject_id')->mapWithKeys(function ($group, $subjectId) {
                    $schedule = $group->first();
                    return [$subjectId => $schedule->teacher?->name ?? $schedule->subject?->teacher ?? '-'];
                });

                $seen      = [];
                $schedules = $raw->filter(function ($s) use (&$seen) {
                    $st  = $s->start_time instanceof Carbon
                        ? $s->start_time->format('H:i')
                        : substr($s->start_time, 0, 5);
                    $key = $s->day . '|' . $st;
                    if (isset($seen[$key])) return false;
                    $seen[$key] = true;
                    return true;
                })->groupBy('day');
            }

        } elseif ($user->role === 'guru') {
            $schedules = Schedule::with(['subject', 'teacher', 'absensiHariIni'])
                ->where('teacher_id', $user->id)->active()
                ->orderBy('day')->orderBy('start_time')
                ->get()->groupBy('day');
        } else {
            $classId   = request()->query('class');
            $query     = Schedule::with(['subject', 'teacher', 'absensiHariIni'])->active();
            if ($classId) $query->byClass($classId);
            $schedules = $query->orderBy('day')->orderBy('start_time')
                               ->get()->groupBy('day');
        }

        if ($student) {
            $history = Attendance::with(['schedule.subject'])
                        ->where('student_id', $student->id);
            if (in_array($filter, ['hadir','izin','sakit','alpha'], true)) {
                $history->where('status', $filter);
            }
            $riwayatAbsen = $history->orderByDesc('date')->orderByDesc('created_at')->get();

            $totals = Attendance::where('student_id', $student->id)->get()->countBy('status')->all();
            $absensiSummary = [
                'hadir' => $totals['hadir'] ?? 0,
                'izin' => $totals['izin'] ?? 0,
                'sakit' => $totals['sakit'] ?? 0,
                'alpha' => $totals['alpha'] ?? 0,
            ];
        }

        // Provide individual summary counts for the view (backwards-compatible)
        $hadirCount = $absensiSummary['hadir'] ?? 0;
        $izinCount  = $absensiSummary['izin'] ?? 0;
        $sakitCount = $absensiSummary['sakit'] ?? 0;
        $alphaCount = $absensiSummary['alpha'] ?? 0;

        return view('schedules.index', compact(
            'schedules', 'dayOrder', 'selectedDay', 'user', 'missingClass', 'riwayatAbsen', 'absensiSummary',
            'filter', 'subjects', 'subjectTeachers', 'hadirCount', 'izinCount', 'sakitCount', 'alphaCount'
        ));
    }

    public function manage()
    {
        $selectedClass = trim((string) request()->query('class', ''));
        $selectedDay = trim((string) request()->query('day', ''));
        $selectedTeacher = trim((string) request()->query('teacher', ''));
        $dayOptions = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        $scheduleQuery = Schedule::with(['subject', 'teacher']);
        if ($selectedClass !== '') {
            $scheduleQuery->byClass($selectedClass);
        }
        if (in_array($selectedDay, $dayOptions, true)) {
            $scheduleQuery->where('day', $selectedDay);
        }
        if ($selectedTeacher !== '') {
            $scheduleQuery->where(function ($query) use ($selectedTeacher) {
                $query->whereHas('teacher', function ($teacherQuery) use ($selectedTeacher) {
                    $teacherQuery->where('name', 'like', '%' . $selectedTeacher . '%')
                        ->orWhere('email', 'like', '%' . $selectedTeacher . '%');
                })->orWhereHas('subject', function ($subjectQuery) use ($selectedTeacher) {
                    $subjectQuery->where('teacher', 'like', '%' . $selectedTeacher . '%');
                });
            });
        }

        $schedules = $scheduleQuery
            ->orderBy('class_id')
            ->orderBy('day')
            ->orderBy('start_time')
            ->paginate(20)
            ->withQueryString();

        $subjects  = Subject::active()->orderBy('class_id')->orderBy('name')->get();
        $teachers  = $this->availableTeachersForSchedules();

        $teacherScheduleOverview = [
            'query' => $selectedTeacher,
            'display_name' => null,
            'total_slots' => 0,
            'active_days' => [],
        ];

        if ($selectedTeacher !== '') {
            $overviewQuery = Schedule::with(['teacher', 'subject'])
                ->active()
                ->where(function ($query) use ($selectedTeacher) {
                    $query->whereHas('teacher', function ($teacherQuery) use ($selectedTeacher) {
                        $teacherQuery->where('name', 'like', '%' . $selectedTeacher . '%')
                            ->orWhere('email', 'like', '%' . $selectedTeacher . '%');
                    })->orWhereHas('subject', function ($subjectQuery) use ($selectedTeacher) {
                        $subjectQuery->where('teacher', 'like', '%' . $selectedTeacher . '%');
                    });
                });

            if ($selectedClass !== '') {
                $overviewQuery->byClass($selectedClass);
            }

            $overviewItems = $overviewQuery->get();
            $firstItem = $overviewItems->first();

            $teacherScheduleOverview['display_name'] = $firstItem?->teacher?->name
                ?? $firstItem?->subject?->teacher
                ?? $selectedTeacher;
            $teacherScheduleOverview['total_slots'] = $overviewItems->count();
            $teacherScheduleOverview['active_days'] = $overviewItems
                ->groupBy('day')
                ->map(function ($items, $day) {
                    return [
                        'day' => $day,
                        'count' => $items->count(),
                    ];
                })
                ->values()
                ->sortBy(function ($item) {
                    $order = [
                        'Senin' => 1,
                        'Selasa' => 2,
                        'Rabu' => 3,
                        'Kamis' => 4,
                        'Jumat' => 5,
                        'Sabtu' => 6,
                    ];

                    return $order[$item['day']] ?? 99;
                })
                ->values()
                ->all();
        }

        $classOptions = collect()
            ->merge(Student::query()->pluck('class_id'))
            ->merge(Subject::query()->pluck('class_id'))
            ->merge(Schedule::query()->pluck('class_id'))
            ->filter(fn ($classId) => !empty($classId))
            ->map(fn ($classId) => trim((string) $classId))
            ->unique()
            ->sort()
            ->values();

        return view('schedules.manage', compact(
            'schedules',
            'subjects',
            'teachers',
            'classOptions',
            'selectedClass',
            'selectedDay',
            'selectedTeacher',
            'dayOptions',
            'teacherScheduleOverview'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'nullable|exists:users,id',
            'class_id'   => 'required|string',
            'day'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'room'       => 'nullable|string|max:50',
        ]);

        $validated['class_id'] = strtoupper(trim($validated['class_id']));

        if (!$this->subjectMatchesClass($validated['subject_id'], $validated['class_id'])) {
            return back()->withErrors([
                'subject_id' => 'Mata pelajaran ini tidak cocok dengan kelas yang dipilih.',
            ])->withInput();
        }

        $conflictMessage = $this->scheduleConflictMessage($validated);
        if ($conflictMessage) {
            return back()->withErrors(['start_time' => $conflictMessage])->withInput();
        }

        Schedule::create($validated);
        return back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'nullable|exists:users,id',
            'class_id'   => 'required|string',
            'day'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'room'       => 'nullable|string|max:50',
            'is_active'  => 'boolean',
        ]);

        $validated['class_id'] = strtoupper(trim($validated['class_id']));

        if (!$this->subjectMatchesClass($validated['subject_id'], $validated['class_id'])) {
            return back()->withErrors([
                'subject_id' => 'Mata pelajaran ini tidak cocok dengan kelas yang dipilih.',
            ])->withInput();
        }

        $conflictMessage = $this->scheduleConflictMessage($validated, $schedule);
        if ($conflictMessage) {
            return back()->withErrors(['start_time' => $conflictMessage])->withInput();
        }

        $schedule->update($validated);
        return back()->with('success', 'Jadwal berhasil diupdate.');
    }

    public function generateWeeklySchedulesWeb()
    {
        $result = $this->buildWeeklySchedules();

        if (!$result['success']) {
            return back()->withErrors(['schedule' => $result['message']]);
        }

        return back()->with(
            'success',
            'Jadwal mingguan berhasil dibuat ulang tanpa bentrok guru/kelas: '
            . $result['total_created']
            . ' slot untuk '
            . count($result['classes'])
            . ' kelas.'
        );
    }

    private function scheduleConflictMessage(array $data, Schedule $excludeSchedule = null): ?string
    {
        $normalizedClass = strtoupper(trim((string) $data['class_id']));
        $day = $data['day'];
        $start = $data['start_time'];
        $end = $data['end_time'];

        $overlapQuery = Schedule::query()
            ->where('day', $day)
            ->where('is_active', true)
            ->where('start_time', '<', $end)
            ->where('end_time', '>', $start);

        if ($excludeSchedule) {
            $overlapQuery->where('id', '!=', $excludeSchedule->id);
        }

        $classConflict = (clone $overlapQuery)
            ->whereRaw('UPPER(TRIM(class_id)) = ?', [$normalizedClass])
            ->exists();

        if ($classConflict) {
            return 'Jadwal bentrok untuk kelas ini pada jam yang sama.';
        }

        if (!empty($data['teacher_id'])) {
            $teacherConflict = (clone $overlapQuery)
                ->where('teacher_id', $data['teacher_id'])
                ->exists();

            if ($teacherConflict) {
                return 'Guru ini sudah mengajar di jam yang sama pada hari tersebut.';
            }
        }

        return null;
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Jadwal berhasil dihapus.');
    }

    public function getSchedulesJson(Request $request)
    {
        $query = Schedule::with(['subject', 'teacher'])->active();
        if ($request->query('class')) $query->byClass($request->query('class'));
        if ($request->query('day'))   $query->byDay($request->query('day'));
        return response()->json(['success' => true, 'data' => $query->orderBy('start_time')->get()]);
    }

    public function getLiveAttendance(Request $request, Schedule $schedule)
    {
        $students    = Student::where('class_id', $schedule->class_id)->get();
        $attendances = $schedule->attendances()
                               ->where('date', today()->toDateString())
                               ->get()->keyBy('student_id');
        return response()->json([
            'success'  => true,
            'schedule' => $schedule->load(['subject', 'teacher']),
            'students' => $students->map(fn($s) => [
                'id'        => $s->id,
                'name'      => $s->name,
                'status'    => $attendances->get($s->id)?->status ?? 'belum_absen',
                'timestamp' => $attendances->get($s->id)?->created_at?->format('H:i:s'),
            ]),
            'total'   => $students->count(),
            'present' => $attendances->where('status', 'hadir')->count(),
        ]);
    }

    /**
     * Generate jadwal mingguan.
     *
     * BUG SEBELUMNYA: ->toArray() mengubah Eloquent model jadi plain array,
     * sehingga $subject->id gagal (harusnya $subject['id']).
     *
     * FIX: pakai ->all() → tetap Eloquent model object, ->id tetap jalan.
     *
     * Algoritma hari berbeda:
     *  - Tiap hari dapat offset awal berbeda (step coprime dengan n)
     *  - Hari genap: urutan maju, hari ganjil: urutan mundur
     *  → Maksimalkan perbedaan antar hari
     */
    public function generateWeeklySchedules()
    {
        $result = $this->buildWeeklySchedules();

        if (!$result['success']) {
            return response()->json($result, 400);
        }

        return response()->json($result, 201);
    }

    private function buildWeeklySchedules(): array
    {
        $teachers = $this->availableTeachersForSchedules();

        if ($teachers->isEmpty()) {
            return ['success' => false, 'message' => 'Belum ada guru di database admin. Tambahkan data guru terlebih dahulu.'];
        }

        // Build classes list from students and subjects so new subject classes are included
        $classes = collect()
            ->merge(Student::pluck('class_id'))
            ->merge(Subject::pluck('class_id'))
            ->filter(fn ($classId) => !empty(trim((string) $classId)))
            ->map(fn ($classId) => strtoupper(trim((string) $classId)))
            ->unique()
            ->values();
        if ($classes->isEmpty())
            return ['success'=>false,'message'=>'Tidak ada kelas siswa.'];

        // ✅ Ambil subject sebagai Collection of models (jangan toArray!)
        $subjects = Subject::active()->get();
        if ($subjects->isEmpty())
            return ['success'=>false,'message'=>'Tidak ada mata pelajaran aktif.'];

        $slots = [
            ['07:00','08:30'],
            ['08:30','10:00'],
            ['10:15','11:45'],
            ['11:45','13:00'],
            ['13:30','15:00'],
            ['15:00','16:30'],
        ];

        $days    = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $n       = $subjects->count();
        $created = [];
        $occupiedTeachers = [];
        $teacherWeeklyLoad = [];
        $teacherDayLoad = [];
        $teacherActiveDays = [];

        // Hitung step coprime dengan n (GCD = 1)
        $step = max(2, (int)ceil($n / 2));
        while ($n > 1 && $this->gcd($step, $n) !== 1) {
            $step++;
        }

        foreach ($classes as $classId) {
            Schedule::where('class_id', $classId)->delete();

            $subjectModels = $subjects
                ->filter(function ($subject) use ($classId) {
                    $subjectClass = strtoupper(trim((string) ($subject->class_id ?? '')));
                    return $subjectClass === '' || $subjectClass === $classId;
                })
                ->values();

            if ($subjectModels->isEmpty()) {
                $subjectModels = $subjects->values();
            }

            $subjectCount = $subjectModels->count();
            $slotCount = min(count($slots), max(1, $subjectCount));
            $classSeed = $this->classSeed($classId) % $subjectCount;
            $subjectUsage = [];
            $previousDaySubjectIds = [];

            foreach ($days as $dayIndex => $day) {
                // Offset berbeda tiap hari dan tiap kelas
                $startOffset = ($classSeed + ($dayIndex * $step)) % $subjectCount;

                // Rotasi: ambil dari offset, wrap-around ke awal
                $rotated = array_merge(
                    array_slice($subjectModels->all(), $startOffset),
                    array_slice($subjectModels->all(), 0, $startOffset)
                );

                // Hari ganjil: balik urutan → makin beda dari hari genap
                if ($dayIndex % 2 === 1) {
                    $rotated = array_reverse($rotated);
                }

                // Randomize slot per hari: tidak semua mapel muncul setiap hari
                // Minimal 50% maksimal 80% dari available slot
                $minSlots = max(1, (int)ceil($slotCount * 0.5));
                $maxSlots = max($minSlots + 1, (int)floor($slotCount * 0.8));
                $randomSlotCount = rand($minSlots, $maxSlots);

                // Ambil mapel dengan prioritas yang belum sering muncul
                // dan kurangi repetisi mapel yang sama di hari berurutan.
                $todaySubjects = $this->pickSubjectsForDay(
                    $rotated,
                    $randomSlotCount,
                    $subjectUsage,
                    $previousDaySubjectIds
                );

                $previousDaySubjectIds = array_map(
                    static fn (Subject $subject) => (int) $subject->id,
                    $todaySubjects
                );

                foreach (array_slice($slots, 0, $slotCount) as $slotIndex => $slot) {
                    [$startTime, $endTime] = $slot;

                    $subject = $todaySubjects[$slotIndex] ?? null;
                    if (!$subject instanceof Subject) {
                        continue;
                    }

                    $teacher = $this->pickTeacherForSlot(
                        $subject,
                        $teachers,
                        $day,
                        $startTime,
                        $endTime,
                        $slotIndex,
                        $dayIndex,
                        $occupiedTeachers,
                        $teacherWeeklyLoad,
                        $teacherDayLoad,
                        $teacherActiveDays
                    );

                    if (!$teacher) {
                        continue;
                    }

                    $subjectClass = trim((string) ($subject->class_id ?? ''));
                    if ($subjectClass !== '' && strcasecmp($subjectClass, (string) $classId) !== 0) {
                        continue;
                    }

                    Schedule::create([
                        'class_id'   => $classId,
                        'subject_id' => $subject->id,
                        'teacher_id' => $teacher->id,
                        'day'        => $day,
                        'start_time' => $startTime . ':00',
                        'end_time'   => $endTime . ':00',
                        'room'       => 'Ruang ' . chr(65 + ($slotIndex % 6)),
                        'is_active'  => true,
                    ]);

                    $occupiedTeachers[$day . '|' . $startTime . '|' . $endTime . '|' . $teacher->id] = true;
                    $teacherWeeklyLoad[$teacher->id] = ($teacherWeeklyLoad[$teacher->id] ?? 0) + 1;
                    $teacherDayLoad[$teacher->id][$day] = ($teacherDayLoad[$teacher->id][$day] ?? 0) + 1;
                    $teacherActiveDays[$teacher->id][$day] = true;

                    $created[$classId][$day][] = "{$startTime} → {$subject->name}";
                }
            }
        }

        return [
            'success'       => true,
            'message'       => '✅ Jadwal berhasil dibuat ulang dengan variasi hari/mapel/guru yang lebih merata.',
            'subject_count' => $n,
            'step_used'     => $step,
            'classes'       => $classes->all(),
            'total_created' => collect($created)->flatten(2)->count(),
            'per_day'       => $created,   // lihat di sini apakah tiap hari beda
        ];
    }

    private function classSeed(string $classId): int
    {
        return array_sum(array_map('ord', str_split(strtoupper(trim($classId)))));
    }

    private function availableTeachersForSchedules()
    {
        $teacherRefs = Subject::active()
            ->whereNotNull('teacher')
            ->pluck('teacher')
            ->map(fn ($teacher) => trim((string) $teacher))
            ->filter()
            ->unique()
            ->values();

        if ($teacherRefs->isNotEmpty()) {
            $teachers = User::where(function ($query) use ($teacherRefs) {
                foreach ($teacherRefs as $teacherRef) {
                    $query->orWhere('name', $teacherRef)
                        ->orWhere('email', $teacherRef);
                }
            })
                ->orderBy('name')
                ->get();

            if ($teachers->isNotEmpty()) {
                return $teachers;
            }
        }

        return User::whereIn('role', ['guru', 'teacher', 'admin'])
            ->orderBy('name')
            ->get();
    }

    private function pickTeacherForSlot(
        Subject $subject,
        $teachers,
        string $day,
        string $startTime,
        string $endTime,
        int $slotIndex,
        int $dayIndex,
        array $occupiedTeachers,
        array $teacherWeeklyLoad,
        array $teacherDayLoad,
        array $teacherActiveDays
    ): ?User {
        $preferredTeacher = null;
        if (!empty($subject->teacher)) {
            $preferredTeacher = User::where('name', $subject->teacher)
                ->orWhere('email', $subject->teacher)
                ->first();
        }

        if ($preferredTeacher && !$this->isTeacherBusyAtSlot($preferredTeacher->id, $day, $startTime, $endTime, $occupiedTeachers)) {
            return $preferredTeacher;
        }

        if ($teachers->isEmpty()) {
            return null;
        }

        $candidateTeachers = $teachers->filter(function ($candidate) use ($day, $startTime, $endTime, $occupiedTeachers) {
            return !$this->isTeacherBusyAtSlot($candidate->id, $day, $startTime, $endTime, $occupiedTeachers);
        })->values();

        if ($candidateTeachers->isEmpty()) {
            return null;
        }

        $ranked = $candidateTeachers
            ->map(function ($candidate) use ($day, $teacherWeeklyLoad, $teacherDayLoad, $teacherActiveDays, $dayIndex, $slotIndex) {
                $weeklyLoad = (int) ($teacherWeeklyLoad[$candidate->id] ?? 0);
                $dayLoad = (int) ($teacherDayLoad[$candidate->id][$day] ?? 0);
                $alreadyHasDay = !empty($teacherActiveDays[$candidate->id][$day]);

                // Score kecil = prioritas tinggi.
                $score = ($dayLoad * 9) + ($weeklyLoad * 3) + ($alreadyHasDay ? 2 : 0);

                // Tie-breaker terkontrol agar tetap acak tapi stabil antar slot/hari.
                $seed = (($candidate->id * 31) + ($dayIndex * 17) + ($slotIndex * 13)) % 7;

                return [
                    'teacher' => $candidate,
                    'score' => $score,
                    'seed' => $seed,
                ];
            })
            ->sortBy([
                ['score', 'asc'],
                ['seed', 'asc'],
            ])
            ->values();

        $chosen = $ranked->first();
        if ($chosen && isset($chosen['teacher']) && $chosen['teacher'] instanceof User) {
            return $chosen['teacher'];
        }

        return null;
    }

    private function pickSubjectsForDay(array $subjectCandidates, int $neededCount, array &$subjectUsage, array $previousDaySubjectIds = []): array
    {
        if ($neededCount <= 0 || empty($subjectCandidates)) {
            return [];
        }

        $ranked = array_map(function ($subject) use ($subjectUsage, $previousDaySubjectIds) {
            $id = (int) $subject->id;
            return [
                'subject' => $subject,
                'usage' => (int) ($subjectUsage[$id] ?? 0),
                'was_used_yesterday' => in_array($id, $previousDaySubjectIds, true) ? 1 : 0,
                'rand' => random_int(1, 1000),
            ];
        }, $subjectCandidates);

        usort($ranked, function ($a, $b) {
            if ($a['usage'] !== $b['usage']) {
                return $a['usage'] <=> $b['usage'];
            }
            if ($a['was_used_yesterday'] !== $b['was_used_yesterday']) {
                return $a['was_used_yesterday'] <=> $b['was_used_yesterday'];
            }
            return $a['rand'] <=> $b['rand'];
        });

        $picked = [];
        foreach (array_slice($ranked, 0, $neededCount) as $entry) {
            /** @var Subject $subject */
            $subject = $entry['subject'];
            $picked[] = $subject;
            $subjectId = (int) $subject->id;
            $subjectUsage[$subjectId] = (int) ($subjectUsage[$subjectId] ?? 0) + 1;
        }

        return $picked;
    }

    private function isTeacherBusyAtSlot(int $teacherId, string $day, string $startTime, string $endTime, array $occupiedTeachers): bool
    {
        $cacheKey = $day . '|' . $startTime . '|' . $endTime . '|' . $teacherId;
        if (isset($occupiedTeachers[$cacheKey])) {
            return true;
        }

        return Schedule::query()
            ->where('teacher_id', $teacherId)
            ->where('day', $day)
            ->where('is_active', true)
            ->where('start_time', '<', $endTime . ':00')
            ->where('end_time', '>', $startTime . ':00')
            ->exists();
    }

    private function subjectMatchesClass(int $subjectId, string $classId): bool
    {
        $subject = Subject::find($subjectId);
        if (!$subject) {
            return false;
        }

        $subjectClass = trim((string) $subject->class_id);
        if ($subjectClass === '') {
            return true;
        }

        return strcasecmp($subjectClass, $classId) === 0;
    }

    private function gcd(int $a, int $b): int
    {
        return $b === 0 ? $a : $this->gcd($b, $a % $b);
    }
}