<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class NilaiController extends Controller
{
    private function normalizeClassId(?string $classId): string
    {
        $value = mb_strtoupper(trim((string) $classId));
        $value = preg_replace('/\s+/', ' ', $value) ?? $value;
        $value = preg_replace('/\s*-\s*/', '-', $value) ?? $value;

        return trim($value);
    }

    private function isTeacherRole(string $role): bool
    {
        return in_array($role, ['guru', 'teacher'], true);
    }

    private function teacherScopeData(int $teacherId): array
    {
        $teacherSchedules = Schedule::where('teacher_id', $teacherId)->get(['subject_id', 'class_id']);

        $subjectIds = $teacherSchedules->pluck('subject_id')->filter()->unique()->values();
        $classIds = $teacherSchedules->pluck('class_id')->filter()->unique()->values();
        $studentIds = Student::whereIn('class_id', $classIds)->pluck('id');

        return [
            'subject_ids' => $subjectIds,
            'class_ids'   => $classIds,
            'student_ids' => $studentIds,
        ];
    }

    private function resolveStudentForAuthenticatedUser(): ?Student
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user) {
            return null;
        }

        $student = Student::findByUser($user);

        // Auto-create profil siswa bila role siswa belum punya relasi student.
        if (!$student && $user->role === 'siswa') {
            $student = Student::createForUser($user);
        }

        return $student;
    }

    public function student(Request $request)
    {
        $student = $this->resolveStudentForAuthenticatedUser();
        if (!$student) {
            return redirect()->route('dashboard')
                ->with('error', 'Profil siswa belum terhubung ke akun Anda.');
        }

        $semester = $request->get('semester', 1);
        $tahun    = $request->get('tahun', date('Y'));
        $nilaiUTS = Nilai::with('subject')->where('student_id', $student->id)->where('type', 'uts')->where('semester', $semester)->where('tahun', $tahun)->get();
        $nilaiUAS = Nilai::with('subject')->where('student_id', $student->id)->where('type', 'uas')->where('semester', $semester)->where('tahun', $tahun)->get();
        $tahunList = Nilai::where('student_id', $student->id)->distinct()->pluck('tahun')->sortDesc();
        return view('nilai.student', compact('student', 'nilaiUTS', 'nilaiUAS', 'semester', 'tahun', 'tahunList'));
    }

    public function adminIndex(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isTeacher = $this->isTeacherRole($user->role);

        $semester  = $request->get('semester', 1);
        $tahun     = $request->get('tahun', date('Y'));
        $studentId = $request->get('student_id');
        $type      = (string) $request->get('type', 'all');
        if (!in_array($type, ['all', 'uts', 'uas'], true)) {
            $type = 'all';
        }
        $selectedClassId = $request->get('class_id');
        $selectedSubjectId = $request->get('subject_id');

        $query = Nilai::with(['student', 'subject'])->where('semester', $semester)->where('tahun', $tahun);
        if ($type !== 'all') {
            $query->where('type', $type);
        }

        if ($isTeacher) {
            $scope = $this->teacherScopeData($user->id);
            $query->whereIn('subject_id', $scope['subject_ids'])
                ->whereIn('student_id', $scope['student_ids']);

            if ($studentId && !$scope['student_ids']->contains((int) $studentId)) {
                $studentId = null;
            }
        }

        if ($studentId) {
            $query->where('student_id', $studentId);
        }

        $nilais   = $query->orderBy('student_id')->get();

        if ($isTeacher) {
            $scope = $scope ?? $this->teacherScopeData($user->id);
            $students = Student::whereIn('id', $scope['student_ids'])->orderBy('name')->get();
            $subjects = Subject::whereIn('id', $scope['subject_ids'])->orderBy('name')->get();
            $classOptions = $scope['class_ids']->values();
        } else {
            $students = Student::orderBy('name')->get();
            $subjects = Subject::orderBy('name')->get();
            $classOptions = Student::query()
                ->select('class_id')
                ->whereNotNull('class_id')
                ->distinct()
                ->orderBy('class_id')
                ->pluck('class_id')
                ->values();
        }

        if ($selectedClassId && !$classOptions->contains($selectedClassId)) {
            $selectedClassId = null;
        }

        if ($selectedSubjectId && !$subjects->pluck('id')->contains((int) $selectedSubjectId)) {
            $selectedSubjectId = null;
        }

        $bulkStudents = collect();
        if ($selectedClassId && $selectedSubjectId) {
            $bulkStudentsQuery = Student::where('class_id', $selectedClassId)->orderBy('name');
            if ($isTeacher) {
                $bulkStudentsQuery->whereIn('id', $scope['student_ids']);
            }
            $bulkStudents = $bulkStudentsQuery->get();
        }

        return view('nilai.admin', compact(
            'nilais',
            'students',
            'subjects',
            'semester',
            'tahun',
            'type',
            'studentId',
            'classOptions',
            'selectedClassId',
            'selectedSubjectId',
            'bulkStudents'
        ));
    }

    public function storeBulk(Request $request)
    {
        $request->validate([
            'class_id'        => 'required|string|max:50',
            'subject_id'      => 'required|exists:subjects,id',
            'type'            => 'required|in:uts,uas',
            'semester'        => 'required|in:1,2',
            'tahun'           => 'required|digits:4|integer',
            'student_ids'     => 'required|array|min:1',
            'student_ids.*'   => 'integer|exists:students,id',
            'nilai'           => 'nullable|array',
            'nilai.*'         => 'nullable|numeric|min:0|max:100',
            'keterangan'      => 'nullable|array',
            'keterangan.*'    => 'nullable|string|max:255',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isTeacher = $this->isTeacherRole($user->role);

        $subject = Subject::findOrFail($request->subject_id);
        $requestedClass = $this->normalizeClassId($request->class_id);
        $subjectClass = $this->normalizeClassId((string) $subject->class_id);

        if ($subjectClass !== '' && $subjectClass !== $requestedClass) {
            return back()->with('error', 'Mapel tidak sesuai dengan kelas yang dipilih.');
        }

        $allowedStudentIds = Student::query()
            ->whereNotNull('class_id')
            ->get(['id', 'class_id'])
            ->filter(fn (Student $student) => $this->normalizeClassId((string) $student->class_id) === $requestedClass)
            ->pluck('id')
            ->values();

        if ($isTeacher) {
            $scope = $this->teacherScopeData($user->id);
            $scopeClassIds = $scope['class_ids']
                ->map(fn ($classId) => $this->normalizeClassId((string) $classId))
                ->filter()
                ->unique();

            if (!$scope['subject_ids']->contains((int) $request->subject_id) || !$scopeClassIds->contains($requestedClass)) {
                return back()->with('error', 'Anda hanya bisa input nilai untuk kelas dan mapel yang diajar.');
            }
            $allowedStudentIds = $allowedStudentIds->intersect($scope['student_ids'])->values();
        }

        $savedCount = 0;
        foreach ($request->student_ids as $studentId) {
            $studentId = (int) $studentId;
            if (!$allowedStudentIds->contains($studentId)) {
                continue;
            }

            $nilaiValue = data_get($request->nilai, (string) $studentId);
            if ($nilaiValue === null || $nilaiValue === '') {
                continue;
            }

            Nilai::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => (int) $request->subject_id,
                    'type'       => $request->type,
                    'semester'   => (int) $request->semester,
                    'tahun'      => (int) $request->tahun,
                ],
                [
                    'nilai'      => $nilaiValue,
                    'keterangan' => data_get($request->keterangan, (string) $studentId),
                ]
            );
            $savedCount++;
        }

        if ($savedCount === 0) {
            return back()->with('error', 'Tidak ada nilai yang tersimpan. Isi minimal satu kolom nilai.');
        }

        return redirect()->route('nilai.admin', [
            'type'       => $request->type,
            'semester'   => $request->semester,
            'tahun'      => $request->tahun,
            'class_id'   => $request->class_id,
            'subject_id' => $request->subject_id,
        ])->with('success', "Berhasil menyimpan {$savedCount} nilai sekaligus.");
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'type'       => 'required|in:uts,uas',
            'semester'   => 'required|in:1,2',
            'tahun'      => 'required|digits:4|integer',
            'nilai'      => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string|max:255',
        ]);
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($this->isTeacherRole($user->role)) {
            $scope = $this->teacherScopeData($user->id);
            if (!$scope['student_ids']->contains((int) $request->student_id) || !$scope['subject_ids']->contains((int) $request->subject_id)) {
                return back()->with('error', 'Anda hanya bisa input nilai untuk kelas dan mapel yang diajar.');
            }
        }

        Nilai::updateOrCreate(
            ['student_id' => $request->student_id, 'subject_id' => $request->subject_id, 'type' => $request->type, 'semester' => $request->semester, 'tahun' => $request->tahun],
            ['nilai' => $request->nilai, 'keterangan' => $request->keterangan]
        );

        return back()->with('success', 'Nilai berhasil disimpan.');
    }

    public function update(Request $request, Nilai $nilai)
    {
        $request->validate(['nilai' => 'required|numeric|min:0|max:100', 'keterangan' => 'nullable|string|max:255']);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($this->isTeacherRole($user->role)) {
            $scope = $this->teacherScopeData($user->id);
            if (!$scope['student_ids']->contains((int) $nilai->student_id) || !$scope['subject_ids']->contains((int) $nilai->subject_id)) {
                abort(403, 'Anda tidak memiliki akses untuk mengubah nilai ini.');
            }
        }

        $nilai->update($request->only('nilai', 'keterangan'));
        return back(302, [], route('nilai.admin'))->with('success', 'Nilai berhasil diupdate.');
    }

    public function destroy(Nilai $nilai)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($this->isTeacherRole($user->role)) {
            $scope = $this->teacherScopeData($user->id);
            if (!$scope['student_ids']->contains((int) $nilai->student_id) || !$scope['subject_ids']->contains((int) $nilai->subject_id)) {
                abort(403, 'Anda tidak memiliki akses untuk menghapus nilai ini.');
            }
        }

        $nilai->delete();
        return back(302, [], route('nilai.admin'))->with('success', 'Nilai berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $student = null;

        if ($request->has('student_id') && in_array($user->role, ['admin', 'guru', 'teacher', 'kepala_sekolah'], true)) {
            $student = Student::find($request->get('student_id'));
        }

        if (!$student) {
            $student = $this->resolveStudentForAuthenticatedUser();
        }

        if (!$student) {
            return redirect()->route('dashboard')
                ->with('error', 'Profil siswa tidak ditemukan.');
        }

        $semester = (int) $request->get('semester', 1);
        $tahun    = (int) $request->get('tahun', date('Y'));

        $nilaiUTS = Nilai::with('subject')->where('student_id', $student->id)->where('type', 'uts')->where('semester', $semester)->where('tahun', $tahun)->get();
        $nilaiUAS = Nilai::with('subject')->where('student_id', $student->id)->where('type', 'uas')->where('semester', $semester)->where('tahun', $tahun)->get();

        // Absensi summary
        $attendances = \App\Models\Attendance::where('student_id', $student->id)
            ->whereYear('date', $tahun)
            ->get();

        $absensiStats = [
            'hadir' => $attendances->where('status', 'hadir')->count(),
            'sakit' => $attendances->where('status', 'sakit')->count(),
            'izin'  => $attendances->where('status', 'izin')->count(),
            'alpha' => $attendances->where('status', 'alpha')->count(),
        ];

        // E-signatures & Settings
        $namaSekolah       = \App\Models\Setting::get('nama_sekolah', 'SMK TRAVINA PRIMA');
        $namaKepalaSekolah = \App\Models\Setting::get('nama_kepala_sekolah', 'Kepala Sekolah');
        $ttdKepalaSekolah  = \App\Models\Setting::get('ttd_kepala_sekolah');

        $toDataUri = static function (?string $path): ?string {
            if (empty($path)) return null;
            $fullPath = storage_path('app/public/' . ltrim((string)$path, '/'));
            if (!is_file($fullPath)) return null;
            $mime = @mime_content_type($fullPath) ?: 'image/png';
            $data = @file_get_contents($fullPath);
            return $data ? 'data:' . $mime . ';base64,' . base64_encode($data) : null;
        };

        $ttdImage = $toDataUri($ttdKepalaSekolah);

        $pdf = Pdf::loadView('nilai.pdf', compact(
            'student',
            'nilaiUTS',
            'nilaiUAS',
            'semester',
            'tahun',
            'absensiStats',
            'namaSekolah',
            'namaKepalaSekolah',
            'ttdImage'
        ))->setPaper('a4', 'portrait');

        $safeName = str_replace(' ', '_', $student->name);
        return $pdf->download("Raport_{$safeName}_Sem{$semester}_{$tahun}.pdf");
    }
}