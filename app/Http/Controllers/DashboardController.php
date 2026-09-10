<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Student;
use App\Models\Payment;
use App\Models\Nilai;
use App\Models\PaymentMethod;
use App\Models\Schedule;
use App\Models\User;

class DashboardController extends Controller
{
    public function updateStudentProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'current_password' => ['nullable', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan akun lain.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('open_profile_modal', true)
                ->with('error', $validator->errors()->first());
        }

        if ($request->filled('new_password')) {
            if (!$request->filled('current_password')) {
                return back()
                    ->withInput()
                    ->with('open_profile_modal', true)
                    ->with('error', 'Password saat ini wajib diisi untuk mengganti password.');
            }

            if (!Hash::check((string) $request->input('current_password'), (string) $user->password)) {
                return back()
                    ->withInput()
                    ->with('open_profile_modal', true)
                    ->with('error', 'Password saat ini tidak sesuai.');
            }
        }

        $oldEmail = (string) $user->email;

        $user->name = (string) $request->input('name');
        $user->email = (string) $request->input('email');

        if ($request->hasFile('avatar')) {
            if (!Schema::hasColumn('users', 'avatar_path')) {
                return back()
                    ->withInput()
                    ->with('open_profile_modal', true)
                    ->with('error', 'Kolom foto profil belum tersedia. Jalankan migrasi database terlebih dahulu.');
            }

            if (!empty($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $user->avatar_path = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->filled('new_password')) {
            $user->password = Hash::make((string) $request->input('new_password'));
        }
        $user->save();

        $student = Student::where('email', $oldEmail)
            ->orWhere('user_id', $user->id)
            ->first();

        if ($student) {
            $student->name = (string) $request->input('name');
            $student->email = (string) $request->input('email');
            $student->save();
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function index()
    {
        /** @var \App\Models\User $user */
        $user     = Auth::user();
        $roleName = $user->role;

        return match($roleName) {
            'admin'          => $this->adminDashboard($user),
            'guru',
            'teacher'        => $this->teacherDashboard($user),
            'siswa'          => $this->studentDashboard($user),
            'kepala_sekolah' => $this->kepalaSekolahDashboard($user),
            default          => abort(403, 'Role tidak dikenali'),
        };
    }

    // ─────────────────────────────────────────
    // ADMIN
    // ─────────────────────────────────────────
    private function adminDashboard($user): \Illuminate\View\View
    {
        $totalStudents   = Student::count();
        $totalTeachers   = User::where('role', 'guru')->count() + User::where('role', 'admin')->count();
        $totalPayments   = Payment::count();
        $totalRevenue    = Payment::whereIn('status', ['paid', 'approved'])->sum('amount');
        $paidCount       = Payment::whereIn('status', ['paid', 'approved'])
                           ->whereMonth('created_at', now()->month)->count();
        $pendingCount    = Payment::where('status', 'pending')->count();
        $pendingPayments = Payment::with('student')
                           ->where('status', 'pending')
                           ->orderByDesc('created_at')
                           ->get();
        $recentPayments  = Payment::with('student')
                           ->orderByDesc('created_at')
                           ->take(10)
                           ->get();

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

        $todayScheduleCount = Schedule::byDay($dayName)
            ->active()
            ->count();

        $classStats = Student::selectRaw('class_id, count(*) as total')
                        ->groupBy('class_id')
                        ->get()
                        ->map(function ($c) {
                            $paid = Payment::whereHas('student', fn($q) => $q->where('class_id', $c->class_id))
                                    ->whereIn('status', ['paid', 'approved'])
                                    ->whereMonth('created_at', now()->month)
                                    ->count();
                            return ['name' => $c->class_id, 'total' => $c->total, 'paid' => $paid];
                        })->toArray();

        $recentActivities = [];

        return view('dashboard.admin', compact(
            'user',
            'totalStudents',
            'totalTeachers',
            'totalPayments',
            'totalRevenue',
            'paidCount',
            'pendingCount',
            'pendingPayments',
            'recentPayments',
            'todayScheduleCount',
            'classStats',
            'recentActivities'
        ));
    }

    // ─────────────────────────────────────────
    // TEACHER
    // ─────────────────────────────────────────
    private function teacherDashboard($user): \Illuminate\View\View
    {
        $teacherSchedules = $this->teacherSchedulesFor($user);

        $classIds = $teacherSchedules
            ->pluck('class_id')
            ->filter()
            ->unique();

        $subjectIds = $teacherSchedules
            ->pluck('subject_id')
            ->filter()
            ->unique();

        $studentIds = Student::whereIn('class_id', $classIds)->pluck('id');

        $totalStudents = Student::whereIn('id', $studentIds)->count();
        $totalTeachers = User::whereIn('role', ['guru', 'teacher'])->count();

        $todayAttendances = \App\Models\Attendance::with('student')
                            ->where('date', today()->toDateString())
                            ->whereIn('student_id', $studentIds)
                            ->orderByDesc('created_at')
                            ->get();

        $monthStats = [
            'hadir' => \App\Models\Attendance::whereMonth('date', now()->month)->whereIn('student_id', $studentIds)->where('status', 'hadir')->count(),
            'sakit' => \App\Models\Attendance::whereMonth('date', now()->month)->whereIn('student_id', $studentIds)->where('status', 'sakit')->count(),
            'izin'  => \App\Models\Attendance::whereMonth('date', now()->month)->whereIn('student_id', $studentIds)->where('status', 'izin')->count(),
            'alpha' => \App\Models\Attendance::whereMonth('date', now()->month)->whereIn('student_id', $studentIds)->where('status', 'alpha')->count(),
        ];

        $recentNilai = Nilai::with(['student', 'subject'])
                       ->whereIn('subject_id', $subjectIds)
                       ->whereIn('student_id', $studentIds)
                   ->orderByDesc('created_at')
                   ->take(10)
                   ->get();

        $totalNilaiUTS = Nilai::where('type', 'uts')->whereIn('subject_id', $subjectIds)->whereIn('student_id', $studentIds)->count();
        $totalNilaiUAS = Nilai::where('type', 'uas')->whereIn('subject_id', $subjectIds)->whereIn('student_id', $studentIds)->count();

        try {
            $announcements = \App\Models\Pengumuman::with('user')
                ->orderByDesc('is_pinned')
                ->latest()
                ->take(5)
                ->get();
        } catch (\Throwable $e) {
            $announcements = collect();
        }

        return view('dashboard.teacher', compact(
            'user',
            'totalStudents',
            'totalTeachers',
            'teacherSchedules',
            'todayAttendances',
            'monthStats',
            'recentNilai',
            'totalNilaiUTS',
            'totalNilaiUAS',
            'announcements'
        ));
    }

    public function teacherSchedulePage()
    {
        $user = Auth::user();
        $isManagementView = in_array((string) $user->role, ['admin', 'kepala_sekolah'], true);
        $teacherSchedules = $isManagementView
            ? $this->allTeacherSchedules()
            : $this->teacherSchedulesFor($user);

        return view('dashboard.teacher-schedule', compact('user', 'teacherSchedules', 'isManagementView'));
    }

    private function teacherSchedulesFor($user)
    {
        return Schedule::with(['subject', 'teacher'])
            ->where(function ($query) use ($user) {
                $query->where('teacher_id', $user->id)
                    ->orWhereHas('subject', function ($subjectQuery) use ($user) {
                        $subjectQuery->where('teacher', $user->name)
                            ->orWhere('teacher', $user->email);
                    });
            })
            ->active()
            ->orderByRaw($this->dayOrderSql())
            ->orderBy('class_id')
            ->orderBy('start_time')
            ->get();
    }

    private function allTeacherSchedules()
    {
        return Schedule::with(['subject', 'teacher'])
            ->active()
            ->orderByRaw($this->dayOrderSql())
            ->orderBy('class_id')
            ->orderBy('start_time')
            ->get();
    }

    private function dayOrderSql(): string
    {
        return "CASE LOWER(TRIM(day))
            WHEN 'senin' THEN 1
            WHEN 'selasa' THEN 2
            WHEN 'rabu' THEN 3
            WHEN 'kamis' THEN 4
            WHEN 'jumat' THEN 5
            WHEN 'sabtu' THEN 6
            WHEN 'monday' THEN 1
            WHEN 'tuesday' THEN 2
            WHEN 'wednesday' THEN 3
            WHEN 'thursday' THEN 4
            WHEN 'friday' THEN 5
            WHEN 'saturday' THEN 6
            ELSE 99
        END";
    }

    // ─────────────────────────────────────────
    // STUDENT / SISWA
    // ─────────────────────────────────────────
    private function studentDashboard($user): \Illuminate\View\View
    {
        $student = Student::findByUser($user);

        if (!$student) {
            $student = (object)[
                'id'       => 0,
                'name'     => $user->name,
                'nis'      => '-',
                'class_id' => '-',
                'email'    => $user->email,
            ];
        }

        $today = today();
        $dayMapping = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];
        $dayOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $dayName = $dayMapping[$today->format('l')] ?? $today->format('l');
        $selectedScheduleDay = request()->query('schedule_day');
        if (!in_array($selectedScheduleDay, $dayOrder, true)) {
            $selectedScheduleDay = $dayName;
        }

        $scheduleByDay = $student->id
            ? Schedule::with(['subject', 'teacher'])
                ->byClass($student->class_id)
                ->active()
                ->orderBy('day')
                ->orderBy('start_time')
                ->get()
                ->groupBy('day')
            : collect();

        $todayScheduleCount = $scheduleByDay->get($selectedScheduleDay)?->count() ?? 0;
        $todaySchedules = $scheduleByDay->get($selectedScheduleDay) ?? collect();

        $payments = $student->id
            ? Payment::where('student_id', $student->id)->orderBy('year')->orderBy('month')->get()
            : collect();

        $paidPayments      = $payments->whereIn('status', ['paid', 'approved']);
        $unpaidPayments    = $payments->whereNotIn('status', ['paid', 'approved', 'pending']);
        $totalPaid         = $paidPayments->sum('amount');
        $paymentPercentage = $payments->count() > 0
            ? ($paidPayments->count() / $payments->count()) * 100
            : 0;

        try {
            $paymentMethods = PaymentMethod::where('is_active', true)->get();
        } catch (\Throwable $e) {
            $paymentMethods = collect();
        }

        try {
            $examPayments = \App\Models\ExamPayment::where('student_id', $student->id)
                ->orderByDesc('created_at')->get();
        } catch (\Throwable $e) {
            $examPayments = collect();
        }

        try {
            $nilaiUTS = Nilai::with('subject')->where('student_id', $student->id)->where('type', 'uts')->get();
            $nilaiUAS = Nilai::with('subject')->where('student_id', $student->id)->where('type', 'uas')->get();
        } catch (\Throwable $e) {
            $nilaiUTS = collect();
            $nilaiUAS = collect();
        }

        try {
            $attendances = \App\Models\Attendance::where('student_id', $student->id)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->orderByDesc('date')->get();

            $attendanceStats = [
                'hadir' => $attendances->where('status', 'hadir')->count(),
                'sakit' => $attendances->where('status', 'sakit')->count(),
                'izin'  => $attendances->where('status', 'izin')->count(),
                'alpha' => $attendances->where('status', 'alpha')->count(),
            ];
            $attendanceStreak = 0;
        } catch (\Throwable $e) {
            $attendances      = collect();
            $attendanceStats  = ['hadir' => 0, 'sakit' => 0, 'izin' => 0, 'alpha' => 0];
            $attendanceStreak = 0;
        }

        try {
            $announcements = \App\Models\Pengumuman::with('user')
                ->orderByDesc('is_pinned')
                ->latest()
                ->take(5)
                ->get();
        } catch (\Throwable $e) {
            $announcements = collect();
        }

        return view('dashboard.student', compact(
            'student',
            'payments',
            'paidPayments',
            'unpaidPayments',
            'totalPaid',
            'paymentPercentage',
            'paymentMethods',
            'examPayments',
            'nilaiUTS',
            'nilaiUAS',
            'attendances',
            'attendanceStats',
            'attendanceStreak',
            'todayScheduleCount',
            'todaySchedules',
            'announcements',
            'dayOrder',
            'selectedScheduleDay',
            'scheduleByDay'
        ));
    }

    // ─────────────────────────────────────────
    // KEPALA SEKOLAH
    // ─────────────────────────────────────────
    private function kepalaSekolahDashboard($user): \Illuminate\View\View
    {
        // ── Keuangan ──
        $monthStart = now()->startOfMonth();
        $monthEnd   = now()->endOfMonth();

        $totalStudents   = Student::count();
        $totalTeachers   = User::where('role', 'guru')->count() + User::where('role', 'admin')->count();
        $totalPayments   = Payment::count();
        $totalRevenue    = Payment::whereIn('status', ['paid', 'approved'])
                           ->whereBetween('created_at', [$monthStart, $monthEnd])
                           ->sum('amount');
        $paidCount       = Payment::whereIn('status', ['paid', 'approved'])
                           ->whereMonth('created_at', now()->month)->count();
        $pendingCount    = Payment::where('status', 'pending')->count();
        $pendingPayments = Payment::with('student')
                           ->where('status', 'pending')
                           ->orderByDesc('created_at')
                           ->get();

        $recentPayments = Payment::with('student')
                          ->orderByDesc('created_at')
                          ->take(10)
                          ->get();

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

        $todayScheduleCount = Schedule::byDay($dayName)
            ->active()
            ->count();

        // ── Revenue Trend (6 bulan terakhir) ──
        try {
            $revenueTrend = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i)->month;
                $year = now()->subMonths($i)->year;
                $total = Payment::whereMonth('created_at', $month)
                         ->whereYear('created_at', $year)
                         ->whereIn('status', ['paid', 'approved'])
                         ->sum('amount');
                $revenueTrend[] = [
                    'label' => now()->subMonths($i)->format('M'),
                    'total' => intval($total),
                ];
            }
        } catch (\Throwable $e) {
            $revenueTrend = [];
        }

        try {
            $announcements = \App\Models\Pengumuman::with('user')->latest()->take(5)->get();
        } catch (\Throwable $e) {
            $announcements = collect();
        }

        return view('dashboard.kepala_sekolah', compact(
            'user',
            'totalStudents',
            'totalTeachers',
            'totalPayments',
            'totalRevenue',
            'paidCount',
            'pendingCount',
            'pendingPayments',
            'recentPayments',
            'todayScheduleCount',
            'announcements',
            'revenueTrend'
        ));
    }
}