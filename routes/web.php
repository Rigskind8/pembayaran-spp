<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AboutAdminController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamQuestionController;
use App\Http\Controllers\ExamResultController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentAttendanceController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherAttendanceController;
use App\Http\Controllers\SuratController;
use App\Livewire\Guru\HasilUjian;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| PUBLIC & AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/

// Public About page (uses admin-managed logo/gallery from settings + about.json)
Route::get('/', function () {
    $schoolName = \App\Models\Setting::get('nama_sekolah', 'SMK Travina Prima');
    $logoSekolah = \App\Models\Setting::get('logo_sekolah');

    $about    = [];
    $aboutPath = storage_path('app/about.json');

    if (is_file($aboutPath)) {
        $aboutRaw = file_get_contents($aboutPath);
        if (is_string($aboutRaw)) {
            $aboutRaw = preg_replace('/^\xEF\xBB\xBF/', '', $aboutRaw);
            $about    = json_decode($aboutRaw, true) ?: [];
        }
    }

    return view('about', compact('schoolName', 'logoSekolah', 'about'));
})->name('about');

// Legacy URL: keep /about working but canonical URL is /
Route::get('/about', fn() => redirect()->route('about'));

// About brochure PDF (printable)
Route::get('/about/brochure', function () {
    $schoolName    = \App\Models\Setting::get('nama_sekolah', config('app.name', 'SMA Contoh Kita'));
    $logoPath      = \App\Models\Setting::get('logo_sekolah');
    $schoolLogoSrc = null;

    if (! empty($logoPath)) {
        $isAbsoluteLogo = str_starts_with($logoPath, 'http://') || str_starts_with($logoPath, 'https://');

        if (! $isAbsoluteLogo) {
            $localLogoPath = storage_path('app/public/' . ltrim($logoPath, '/'));
            if (is_file($localLogoPath)) {
                $mimeType      = mime_content_type($localLogoPath) ?: 'image/png';
                $schoolLogoSrc = 'data:' . $mimeType . ';base64,' . base64_encode(file_get_contents($localLogoPath));
            }
        }
    }

    $paymentMethods = \App\Models\PaymentMethod::active()->orderBy('name')->get();
    $html           = view('about-brochure-pdf', compact('schoolName', 'schoolLogoSrc', 'paymentMethods'))->render();

    $safeSchoolName = preg_replace('/[^A-Za-z0-9\-]+/', '-', (string) $schoolName);
    $safeSchoolName = trim((string) $safeSchoolName, '-');
    $downloadName   = 'brosur-' . strtolower($safeSchoolName !== '' ? $safeSchoolName : 'sekolah') . '.pdf';

    return \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)
        ->setPaper('a4')
        ->setOption('isHtml5ParserEnabled', true)
        ->download($downloadName);
})->name('about.brochure');

// Contact form submission
Route::post('/about/contact', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'name'    => 'required|string|max:120',
        'email'   => 'required|email|max:200',
        'message' => 'required|string|max:2000',
    ]);

    $data['ip']         = $request->ip();
    $data['created_at'] = now()->toDateTimeString();

    file_put_contents(
        storage_path('app/contacts.jsonl'),
        json_encode($data, JSON_UNESCAPED_UNICODE) . PHP_EOL,
        FILE_APPEND | LOCK_EX
    );

    return redirect()->route('about')->with('success', 'Pesan Anda telah dikirim. Kami akan menghubungi Anda.');
})->name('about.contact');

// Authentication
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);

// Manual logout via URL
Route::get('logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout.get');

/*
|--------------------------------------------------------------------------
| DEV / DEBUG ROUTES (No Auth — Local Only)
|--------------------------------------------------------------------------
*/

Route::get('/_dev/regenerate-schedules-noauth', function () {
    if (! app()->environment('local') && request()->ip() !== '127.0.0.1') {
        abort(403, 'Forbidden');
    }

    try {
        if (class_exists(\Database\Seeders\SubjectSeeder::class)) {
            (new \Database\Seeders\SubjectSeeder())->run();
        }

        $controller = app(ScheduleController::class);
        return $controller->generateWeeklySchedules();
    } catch (\Throwable $e) {
        return response('Failed: ' . $e->getMessage(), 500);
    }
})->name('dev.regen.noauth');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED AREA
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('notifications/mark-read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markRead');

    // WA Redirect (available for all authenticated roles)
    Route::get('/admin/wa', function () {
        $rawNumber = \App\Models\Setting::get('wa_admin_number', '6281388796229');
        $waNumber  = preg_replace('/\D+/', '', (string) $rawNumber);

        if (str_starts_with($waNumber, '0')) {
            $waNumber = '62' . substr($waNumber, 1);
        }

        $waNumber = $waNumber ?: '6281388796229';

        return redirect('https://wa.me/' . $waNumber);
    })->name('admin.wa');

    Route::get('jadwal-mengajar', [DashboardController::class, 'teacherSchedulePage'])->name('teacher.schedule');

    /*
    |----------------------------------------------------------------------
    | STUDENT AREA
    |----------------------------------------------------------------------
    */

    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', fn() => view('siswa.dashboard'))->name('dashboard');

        Route::get('/profile/update', function () {
            return redirect()->route('dashboard', ['settings' => 'profil'])
                ->with('open_profile_modal', true);
        })->name('profile.update.view');

        Route::post('/profile/update', [DashboardController::class, 'updateStudentProfile'])->name('profile.update');

        Route::get('/pembayaran', [PembayaranController::class, 'indexSiswa'])->name('pembayaran');
        Route::post('/pembayaran/upload-bukti', [PembayaranController::class, 'uploadBukti'])->name('upload-bukti');
        Route::post('/bayar', [PembayaranController::class, 'bayarLangsung'])->name('bayar');
        Route::get('/pembayaran/download-pdf', [PembayaranController::class, 'downloadPDF'])->name('pembayaran.pdf');
    });

    // Fitur Akademik Siswa
    Route::get('/jadwal', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/jadwal/live-attendance/{schedule}', [ScheduleController::class, 'getLiveAttendance'])->name('schedule.attendance');
    Route::get('/jadwal-json', [ScheduleController::class, 'getSchedulesJson'])->name('schedule.json');

    Route::get('/mapel', [MapelController::class, 'index'])->name('mapel.index');
    Route::get('/nilai', [NilaiController::class, 'student'])->name('nilai.student');
    Route::get('/nilai/export-pdf', [NilaiController::class, 'exportPdf'])->name('nilai.exportPdf');

    // Fitur Absensi Siswa
    Route::get('/absensi-siswa', [StudentAttendanceController::class, 'todaySchedule'])->name('student.attendance.today');
    Route::post('/absen-mapel/{schedule?}', [StudentAttendanceController::class, 'submitAttendance'])->name('student.attendance.submit');
    Route::post('/absensi', [StudentAttendanceController::class, 'submitAttendance'])->name('absensi.store');
    Route::get('/riwayat-absensi-siswa', [StudentAttendanceController::class, 'myAttendanceHistory'])->name('attendance.history');
    Route::post('/absensi-undo/{attendance}', [StudentAttendanceController::class, 'undoAttendance'])->name('attendance.undo');
    Route::post('/student-absensi-undo/{attendance}', [StudentAttendanceController::class, 'undoAttendance'])->name('student.attendance.undo');

    // Jadwal UTS/UAS siswa
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/ujian/jadwal', [UjianController::class, 'jadwalUjian'])->name('ujian.jadwal');
    });

    // Ujian Siswa (hanya untuk role siswa)
    Route::prefix('ujian')->name('ujian.')->middleware('role:siswa')->group(function () {
        Route::get('/uts', [UjianController::class, 'uts'])->name('uts');
        Route::get('/uas', [UjianController::class, 'uas'])->name('uas');
        Route::post('/upload-bukti', [UjianController::class, 'uploadBukti'])->name('upload');

        Route::get('/{jenis}/{subject}', [UjianController::class, 'showExam'])
            ->whereIn('jenis', ['uts', 'uas'])
            ->name('take');
        Route::post('/{jenis}/{subject}', [UjianController::class, 'submitExam'])
            ->whereIn('jenis', ['uts', 'uas'])
            ->name('submit');
        Route::get('/{jenis}/{subject}/hasil', [UjianController::class, 'examResult'])
            ->whereIn('jenis', ['uts', 'uas'])
            ->name('result');
        Route::get('/{jenis}/{subject}/hasil/pdf', [UjianController::class, 'examResultPdf'])
            ->whereIn('jenis', ['uts', 'uas'])
            ->name('result.pdf');
    });

    /*
    |----------------------------------------------------------------------
    | TEACHER AREA
    |----------------------------------------------------------------------
    */

    Route::middleware('role:guru,teacher')->group(function () {
        Route::get('absensi-mengajar', [TeacherAttendanceController::class, 'index'])->name('teacher.attendance');

        Route::get('absensi-mengajar/{schedule}', function () {
            return redirect()->route('teacher.attendance')
                ->with('error', 'Akses langsung ke detail absensi tidak tersedia. Silakan gunakan halaman Absensi Mengajar.');
        })->name('teacher.attendance.redirect');

        Route::post('absensi-mengajar/{schedule}', [TeacherAttendanceController::class, 'submit'])->name('teacher.attendance.submit');
    });

    /*
    |----------------------------------------------------------------------
    | ADMIN + GURU (AKADEMIK)
    |----------------------------------------------------------------------
    */

    Route::middleware('role:guru,teacher')->group(function () {
        Route::get('manage-absensi', [AbsensiController::class, 'adminIndex'])->name('absensi.admin');
        Route::post('manage-absensi', [AbsensiController::class, 'store'])->name('absensi.admin.store');
        Route::patch('manage-absensi/{absensi}', [AbsensiController::class, 'update'])->name('absensi.update');
        Route::delete('manage-absensi/{absensi}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');
        Route::get('manage-absensi/{absensi}', fn() => redirect()->route('absensi.admin'));

        // Student Attendance Management
        Route::get('kelola-absensi-siswa', [StudentAttendanceController::class, 'manageAttendance'])->name('attendance.manage');
        Route::get('absensi/scan-qr', [StudentAttendanceController::class, 'scanQrView'])->name('attendance.scanQr');
        Route::post('absensi/scan-qr', [StudentAttendanceController::class, 'processQrScan'])->name('attendance.processQrScan');
        Route::patch('kelola-absensi-siswa/{attendance}', [StudentAttendanceController::class, 'updateAttendance'])->name('attendance.update');
        Route::get('absensi-json/{schedule}', [StudentAttendanceController::class, 'getAttendanceJson'])->name('attendance.json');
        Route::get('kelola-absensi-siswa/{attendance}', fn() => redirect()->route('attendance.manage'));

        Route::get('manage-nilai', [NilaiController::class, 'adminIndex'])->name('nilai.admin');
        Route::post('manage-nilai', [NilaiController::class, 'store'])->name('nilai.store');
        Route::post('manage-nilai/bulk', [NilaiController::class, 'storeBulk'])->name('nilai.bulk');
        Route::patch('manage-nilai/{nilai}', [NilaiController::class, 'update'])->name('nilai.update');
        Route::delete('manage-nilai/{nilai}', [NilaiController::class, 'destroy'])->name('nilai.destroy');
        Route::get('manage-nilai/{nilai}', fn() => redirect()->route('nilai.admin'));

        // Hasil Ujian (Nilai) for Teachers
        Route::get('hasil-ujian-siswa', HasilUjian::class)->name('guru.hasil-ujian');

        // Exam Results
        Route::get('exam-results', [ExamResultController::class, 'index'])->name('exam-results.index');
        Route::get('exam-results/api', [ExamResultController::class, 'getResults'])->name('exam-results.api');
        Route::get('exam-results/export/csv', [ExamResultController::class, 'export'])->name('exam-results.export');
        Route::get('exam-results/{attempt}', [ExamResultController::class, 'show'])->name('exam-results.show');

        // Ujian Management
        Route::get('manage-ujian', [UjianController::class, 'adminIndex'])->name('manage.ujian');
        Route::put('manage-ujian/{exam}/verify', [UjianController::class, 'verify'])->name('ujian.verify');
        Route::put('manage-ujian/{exam}/reject', [UjianController::class, 'reject'])->name('ujian.reject');
        Route::delete('manage-ujian/{exam}', [UjianController::class, 'destroy'])->name('ujian.destroy');
        Route::get('manage-ujian/{exam}', fn() => redirect()->route('manage.ujian'));
    });

    /*
    |----------------------------------------------------------------------
    | ADMIN ONLY AREA
    |----------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

        // Admin Profile
        Route::get('admin/profile/edit', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::post('admin/profile/edit', [AdminProfileController::class, 'update'])->name('admin.profile.update');
        Route::post('admin/profile/photo', [AdminProfileController::class, 'updatePhoto'])->name('admin.profile.photo');
        Route::get('admin/activity-logs', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('admin.activity-logs');

        // Monitor Absensi Guru
        Route::get('monitor-absensi-guru', [TeacherAttendanceController::class, 'monitor'])->name('teacher.attendance.monitor');

        // About CMS Editor
        Route::prefix('admin/about')->name('admin.about.')->group(function () {
            Route::get('edit', [AboutAdminController::class, 'edit'])->name('edit');
            Route::post('update', [AboutAdminController::class, 'update'])->name('update');
            Route::post('upload-image', [AboutAdminController::class, 'uploadImage'])->name('upload_image');
            Route::post('upload-gallery', [AboutAdminController::class, 'uploadGallery'])->name('upload_gallery');
            Route::post('update-gallery-item', [AboutAdminController::class, 'updateGalleryItem'])->name('update_gallery_item');
            Route::post('remove-gallery', [AboutAdminController::class, 'removeGallery'])->name('remove_gallery');
            Route::post('upload-logo', [AboutAdminController::class, 'uploadLogo'])->name('upload_logo');
            Route::post('remove-logo', [AboutAdminController::class, 'removeLogo'])->name('remove_logo');
            Route::post('upload-hero-image', [AboutAdminController::class, 'uploadHeroImage'])->name('upload_hero_image');
            Route::post('remove-hero-image', [AboutAdminController::class, 'removeHeroImage'])->name('remove_hero_image');
        });

        // Students & Users
        Route::resource('students', StudentController::class);
        Route::resource('users', UserController::class);
        Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

        // Teachers
        Route::get('teachers', [UserController::class, 'teachers'])->name('users.teachers');
        Route::get('teachers/{user}/edit', [UserController::class, 'edit'])->name('users.teachers.edit');
        Route::patch('teachers/{user}', [UserController::class, 'update'])->name('users.teachers.update');
        Route::delete('teachers/{user}', [UserController::class, 'destroy'])->name('users.teachers.destroy');

        Route::get('/admin/tagihan/create', [PembayaranController::class, 'createTagihan'])->name('admin.tagihan.create');
        Route::post('/admin/tagihan/store', [PembayaranController::class, 'storeTagihan'])->name('admin.tagihan.store');
        Route::post('/admin/tagihan/bulk', [PembayaranController::class, 'storeTagihanBulk'])->name('admin.tagihan.bulk');

        // Exam Questions
        Route::get('exam-questions', [ExamQuestionController::class, 'index'])->name('exam-questions.index');
        Route::post('exam-questions', [ExamQuestionController::class, 'store'])->name('exam-questions.store');
        Route::put('exam-questions/{examQuestion}', [ExamQuestionController::class, 'update'])->name('exam-questions.update');
        Route::delete('exam-questions/{examQuestion}', [ExamQuestionController::class, 'destroy'])->name('exam-questions.destroy');
        Route::get('exam-questions/{examQuestion}', fn() => redirect()->route('exam-questions.index'));

        // Schedule Management
        Route::get('manage-schedule', [ScheduleController::class, 'manage'])->name('schedule.manage');
        Route::post('manage-schedule/generate-weekly', [ScheduleController::class, 'generateWeeklySchedulesWeb'])->name('schedule.generate-weekly');
        Route::post('manage-schedule', [ScheduleController::class, 'store'])->name('schedule.store');
        Route::patch('manage-schedule/{schedule}', [ScheduleController::class, 'update'])->name('schedule.update');
        Route::delete('manage-schedule/{schedule}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
        Route::get('manage-schedule/{schedule}', fn() => redirect()->route('schedule.manage'));

        // Surat masuk dan surat keluar
        Route::resource('surat', SuratController::class);
        Route::post('surat/{surat}/disposisi', [SuratController::class, 'storeDisposition'])->name('surat.disposisi.store');
    });

    /*
    |----------------------------------------------------------------------
    | ADMIN + KEPALA SEKOLAH FINANCE
    |----------------------------------------------------------------------
    */

    Route::middleware('role:admin,kepala_sekolah')->group(function () {
        // Keuangan / Pembayaran
        Route::get('manage-payments', [PembayaranController::class, 'adminIndex'])->name('admin.payments');
        Route::get('payments/report', [PembayaranController::class, 'report'])->name('payments.report');
        Route::get('payments/export/tunggakan-excel', [PembayaranController::class, 'exportTunggakanExcel'])->name('payments.exportTunggakanExcel');
        Route::get('payments/export/tunggakan-pdf', [PembayaranController::class, 'exportTunggakanPdf'])->name('payments.exportTunggakanPdf');
        Route::post('payments/bulk-approve', [PembayaranController::class, 'bulkApprove'])->name('payments.bulkApprove');
        Route::patch('payments/{payment}/verify', [PembayaranController::class, 'verify'])->name('payments.verify');
        Route::patch('payments/{payment}/reject', [PembayaranController::class, 'reject'])->name('payments.reject');
    });

    /*
    |----------------------------------------------------------------------
    | KEPALA SEKOLAH ONLY
    |----------------------------------------------------------------------
    */

    Route::middleware('role:kepala_sekolah')->group(function () {
        // Pengumuman (Kepala Sekolah Only)
        Route::prefix('kepala-sekolah')->name('kepala-sekolah.')->group(function () {
            Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
            Route::get('/pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
            Route::get('/pengumuman/store', fn() => redirect()->route('kepala-sekolah.pengumuman.index'));
            Route::post('/pengumuman/store', [PengumumanController::class, 'store'])->name('pengumuman.store');
            Route::patch('/pengumuman/{pengumuman}/pin', [PengumumanController::class, 'togglePin'])->name('pengumuman.pin');
            Route::delete('/pengumuman/{pengumuman}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
        });
    });

    /*
    |----------------------------------------------------------------------
    | ADMIN ONLY
    |----------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
        Route::delete('/settings/ttd', [SettingController::class, 'hapusTTD'])->name('settings.hapus-ttd');
    });

    /*
    |----------------------------------------------------------------------
    | DEV / DEBUG ROUTES (Authenticated — Local Only)
    |----------------------------------------------------------------------
    */

    // Debug: Inspect current user's student record
    Route::get('/debug-student', function () {
        /** @var \App\Models\User $user */
        $user    = Auth::user();
        $student = \App\Models\Student::findByUser($user);

        return response()->json([
            'current_user' => [
                'id'             => $user->id,
                'name'           => $user->name,
                'email'          => $user->email,
                'role'           => $user->role,
                'student_found'  => $student ? 'YES' : 'NO',
                'student_id'     => $student?->id,
                'student_name'   => $student?->name,
                'student_class'  => $student?->class_id,
            ],
            'total_students_in_db'          => \App\Models\Student::count(),
        ], 200);
    })->name('debug.student');

    // Debug: Create student record for current user if not exists
    Route::get('/create-student-for-me', function () {
        /** @var \App\Models\User $user */
        $user    = Auth::user();
        $student = \App\Models\Student::findByUser($user);

        if ($student) {
            return response()->json(['message' => 'Student record already exists', 'student' => $student], 200);
        }

        $newStudent = \App\Models\Student::createForUser($user, [
            'class_id' => '10 A',
        ]);

        return response()->json([
            'message' => 'Student record created successfully!',
            'student' => $newStudent,
        ], 201);
    })->name('create.student');

    // Dev: Generate weekly schedules (Senin–Sabtu) with teacher assignments
    Route::get('/generate-weekly-schedules', [ScheduleController::class, 'generateWeeklySchedules'])
        ->name('schedule.generate');

    // Dev: Run SubjectSeeder via browser
    Route::get('/dev/run-subject-seeder', function () {
        if (! app()->environment('local') && request()->ip() !== '127.0.0.1') {
            abort(403, 'Forbidden');
        }

        try {
            (new \Database\Seeders\SubjectSeeder())->run();
            return response('Subject seeder executed', 200);
        } catch (\Throwable $e) {
            return response('Seeder failed: ' . $e->getMessage(), 500);
        }
    })->name('dev.seed.subject');

    // Dev: Run SubjectSeeder then regenerate schedules
    Route::get('/dev/regenerate-schedules', function () {
        if (! app()->environment('local') && request()->ip() !== '127.0.0.1') {
            abort(403, 'Forbidden');
        }

        try {
            if (class_exists(\Database\Seeders\SubjectSeeder::class)) {
                (new \Database\Seeders\SubjectSeeder())->run();
            }

            $controller = app(ScheduleController::class);
            return $controller->generateWeeklySchedules();
        } catch (\Throwable $e) {
            return response('Failed: ' . $e->getMessage(), 500);
        }
    })->name('dev.regen.schedules');
});