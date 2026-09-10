<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ExamAttempt;
use App\Models\ExamQuestion;
use App\Models\Nilai;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Notifikasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Ujian;
use Illuminate\Support\Collection;

class UjianController extends Controller
{

    private const EXAM_QUESTION_LIMIT = 5;

    /**
     * Show formatted UTS/UAS schedule for the current student/class
     */
    public function jadwalUjian(Request $request)
    {
        $user = Auth::user();
        $student = $user ? Student::findByUser($user) : null;
        if (!$student && $user?->role === 'siswa') {
            $student = Student::createForUser($user);
        }

        // Jika bukan siswa atau belum ada data siswa, ambil siswa pertama sebagai fallback (misal saat admin preview)
        if (!$student) {
            $student = Student::first();
        }

        $classId = $student ? $student->class_id : null;

        // Ambil semua jadwal aktif untuk kelas siswa, diurutkan menurut hari kerja (Senin s.d. Minggu) dan jam mulai
        $schedulesQuery = \App\Models\Schedule::active();
        if ($classId) {
            $schedulesQuery->where('class_id', $classId);
        }

        $schedules = $schedulesQuery
            ->orderByRaw("FIELD(LOWER(day), 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu')")
            ->orderBy('start_time')
            ->with(['subject', 'teacher'])
            ->get();

        // Format jadwal untuk tampilan
        $scheduleList = $schedules->map(function($sch) {
            $startTime = $sch->start_time ? \Carbon\Carbon::parse($sch->start_time) : null;
            $endTime = $sch->end_time ? \Carbon\Carbon::parse($sch->end_time) : null;
            $durationMinutes = ($startTime && $endTime) ? $startTime->diffInMinutes($endTime) : null;

            return [
                'id'       => $sch->id,
                'day'      => ucfirst($sch->day),
                'date'     => '', // Bisa diisi tanggal khusus UTS/UAS
                'time'     => ($startTime ? $startTime->format('H:i') : '-') . ' - ' . ($endTime ? $endTime->format('H:i') : '-'),
                'duration' => $durationMinutes ? $durationMinutes . ' Menit' : null,
                'subject'  => $sch->subject->name ?? '-',
                'subject_id' => $sch->subject_id ?? null,
                'teacher'  => $sch->teacher->name ?? '-',
                'room'     => $sch->room ?? '-',
                'class_id' => $sch->class_id ?? '-',
            ];
        });

        return view('ujian.schedule', [
            'student'      => $student,
            'scheduleList' => $scheduleList,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ================= SISWA AREA =================
    |--------------------------------------------------------------------------
    */

    public function uts()
    {
        return $this->renderPaymentPage('uts');
    }

    public function uas()
    {
        return $this->renderPaymentPage('uas');
    }

    public function uploadBukti(Request $request)
    {
        $request->validate([
            'jenis'         => 'required|in:uts,uas',
            'tanggal_ujian' => 'required|date',
            'bukti'         => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $userId = Auth::id();
        $jenis = $request->jenis;

        // Cek jika sudah ada pengajuan untuk jenis ujian ini
        $existing = Ujian::where('user_id', $userId)
            ->where('jenis', $jenis)
            ->first();
        if ($existing) {
            return back()->with('error', 'Pengajuan untuk ' . strtoupper($jenis) . ' sudah ada. Menunggu verifikasi admin.');
        }

        $path = $request->file('bukti')->store('bukti_ujian', 'public');

        Ujian::create([
            'user_id'        => $userId,
            'jenis'          => $jenis,
            'tanggal_ujian'  => $request->tanggal_ujian,
            'bukti'          => $path,
            'status'         => 'pending',
        ]);

        return back()->with('success', 'Pengajuan ujian berhasil dikirim. Menunggu verifikasi admin.');
    }

    /*
    |--------------------------------------------------------------------------
    | ================= ADMIN AREA =================
    |--------------------------------------------------------------------------
    */

    public function adminIndex()
    {
        return view('admin.manage-ujian');
    }

    public function verify(Ujian $exam)
    {
        $update = [
            'status'      => 'verified',
            'verified_at' => now(),
        ];

        // If submitted with freeform mata_pelajaran, try a fuzzy match to attach subject_id
        if (empty($exam->subject_id) && !empty($exam->mata_pelajaran)) {
            $mpNorm = $this->normalizeText($exam->mata_pelajaran);
            $found = null;

            foreach (Subject::active()->get() as $subject) {
                $sNorm = $this->normalizeText($subject->name);
                if ($sNorm === '') {
                    continue;
                }

                if (($mpNorm !== '' && strpos($mpNorm, $sNorm) !== false) || ($sNorm !== '' && strpos($sNorm, $mpNorm) !== false)) {
                    $found = $subject;
                    break;
                }
            }

            if ($found) {
                $update['subject_id'] = $found->id;
            }
        }

        $exam->update($update);

        // Create notification for the student
        try {
            Notifikasi::create([
                'user_id' => $exam->user_id,
                'ujian_id' => $exam->id,
                'judul' => 'Pengajuan Ujian Disetujui',
                'pesan' => 'Pengajuan ujian untuk ' . ($exam->mata_pelajaran ?? '-') . ' telah diverifikasi oleh admin.',
                'tipe' => 'ujian',
                'dibaca' => false,
            ]);
        } catch (\Throwable $e) {
            // ignore notification failures
        }

        return back();
    }

    public function reject(Request $request, Ujian $exam)
    {
        $request->validate([
            'catatan_admin' => 'required|string|max:255',
        ]);

        $exam->update([
            'status'        => 'rejected',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Pengajuan berhasil ditolak.');
    }

    public function destroy(Ujian $exam)
    {
        if ($exam->bukti && Storage::disk('public')->exists($exam->bukti)) {
            Storage::disk('public')->delete($exam->bukti);
        }

        $exam->delete();

        return back()->with('success', 'Data ujian berhasil dihapus.');
    }

    public function showExam(string $jenis, Subject $subject)
    {
        $jenis = $this->normalizeJenis($jenis);
        if (!$jenis) {
            abort(404);
        }

        $latestAttempt = ExamAttempt::where('user_id', Auth::id())
            ->where('type', $jenis)
            ->where('subject_id', $subject->id)
            ->latest('submitted_at')
            ->first();

        if ($latestAttempt) {
            return redirect()
                ->route('ujian.result', [$jenis, $subject, 'attempt' => $latestAttempt->id])
                ->with('success', 'Ujian ' . strtoupper($jenis) . ' untuk mapel ini sudah dikerjakan.');
        }

        $payment = $this->verifiedExamPayment($jenis, $subject->id);
        $questions = ExamQuestion::active()
            ->with('subject')
            ->where('type', $jenis)
            ->where('subject_id', $subject->id)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        if ($questions->isEmpty()) {
            return redirect()
                ->route('ujian.' . $jenis)
                ->with('error', 'Soal untuk mapel ini belum tersedia.');
        }

        if ($questions->count() < self::EXAM_QUESTION_LIMIT) {
            return redirect()
                ->route('ujian.' . $jenis)
                ->with('error', 'Soal ' . strtoupper($jenis) . ' untuk mapel ini belum lengkap. Minimal ' . self::EXAM_QUESTION_LIMIT . ' soal.');
        }

        $sessionData = $this->prepareExamSession($jenis, $subject, $questions);
        $now = now();
        $timeExpired = $now->greaterThanOrEqualTo($sessionData['ends_at']);

        $orderedQuestions = collect($sessionData['question_order'])
            ->map(fn ($id) => $questions->firstWhere('id', (int) $id))
            ->filter()
            ->values();

        if ($orderedQuestions->isEmpty()) {
            $orderedQuestions = $questions->values();
        }

        $durationMinutes = $sessionData['duration_minutes'];
        $startedAt = $sessionData['started_at'];
        $endsAt = $sessionData['ends_at'];
        $optionOrders = $sessionData['option_orders'];

        return view('ujian.soal', [
            'jenis' => $jenis,
            'subject' => $subject,
            'questions' => $orderedQuestions,
            'payment' => $payment,
            'latestAttempt' => $latestAttempt,
            'durationMinutes' => $durationMinutes,
            'startedAt' => $startedAt,
            'endsAt' => $endsAt,
            'optionOrders' => $optionOrders,
            'timeExpired' => $timeExpired,
        ]);
    }

    public function submitExam(Request $request, string $jenis, Subject $subject)
    {
        $jenis = $this->normalizeJenis($jenis);
        if (!$jenis) {
            abort(404);
        }

        $latestAttempt = ExamAttempt::where('user_id', Auth::id())
            ->where('type', $jenis)
            ->where('subject_id', $subject->id)
            ->latest('submitted_at')
            ->first();

        if ($latestAttempt) {
            return redirect()
                ->route('ujian.result', [$jenis, $subject, 'attempt' => $latestAttempt->id])
                ->with('success', 'Ujian ' . strtoupper($jenis) . ' untuk mapel ini sudah pernah dikirim.');
        }

        $payment = $this->verifiedExamPayment($jenis, $subject->id);
        $questions = ExamQuestion::active()
            ->where('type', $jenis)
            ->where('subject_id', $subject->id)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        if ($questions->isEmpty()) {
            return redirect()
                ->route('ujian.' . $jenis)
                ->with('error', 'Soal untuk mapel ini belum tersedia.');
        }

        if ($questions->count() < self::EXAM_QUESTION_LIMIT) {
            return redirect()
                ->route('ujian.' . $jenis)
                ->with('error', 'Soal ' . strtoupper($jenis) . ' untuk mapel ini belum lengkap. Minimal ' . self::EXAM_QUESTION_LIMIT . ' soal.');
        }

        $sessionData = $this->getExamSession($jenis, $subject);
        if (!$sessionData) {
            return redirect()
                ->route('ujian.take', [$jenis, $subject])
                ->with('error', 'Sesi ujian tidak ditemukan. Silakan muat ulang halaman ujian.');
        }

        if (now()->greaterThanOrEqualTo($sessionData['ends_at'])) {
            $this->clearExamSession($jenis, $subject);

            return redirect()
                ->route('ujian.take', [$jenis, $subject])
                ->with('error', 'Waktu ujian telah habis. Jawaban tidak dapat dikirim lagi.');
        }

        $validated = $request->validate([
            'answers'      => 'nullable|array',
            'is_violation' => 'nullable',
        ]);

        $isViolation = $request->boolean('is_violation');
        $answers = $validated['answers'] ?? [];
        $correctCount = 0;
        $maxScore = 0;
        $score = 0;

        $orderedQuestions = collect($sessionData['question_order'])
            ->map(fn ($id) => $questions->firstWhere('id', (int) $id))
            ->filter()
            ->values();

        if ($orderedQuestions->isEmpty()) {
            $orderedQuestions = $questions->values();
        }

        $storedAnswers = [];

        foreach ($orderedQuestions as $question) {
            $maxScore += (int) $question->points;

            // Jika siswa tidak menjawab atau mengosongkan, selected TETAP NULL (KOSONG)
            $rawSelected = $answers[$question->id] ?? null;
            $selected = ($rawSelected !== null && $rawSelected !== '') ? (string) $rawSelected : null;
            
            // Jawaban benar hanya jika siswa memang menjawab dan cocok, serta tidak ada pelanggaran
            $isCorrect = (!$isViolation && $selected !== null) ? ($selected === $question->correct_answer) : false;

            $storedAnswers[(string) $question->id] = [
                'selected'      => $selected,
                'correct'       => $question->correct_answer,
                'is_correct'    => $isCorrect,
                'is_unanswered' => ($selected === null),
            ];

            if ($isCorrect) {
                $correctCount++;
                $score += (int) $question->points;
            }
        }

        // Jika terdeteksi kecurangan/pelanggaran, skor dan jumlah benar wajib 0
        if ($isViolation) {
            $score = 0;
            $correctCount = 0;
        }

        $storedAnswers['_meta'] = [
            'is_violation'     => $isViolation,
            'violation_reason' => $isViolation ? 'Terdeteksi keluar dari fullscreen / berpindah aplikasi sebanyak 3 kali' : null,
        ];

        $attempt = ExamAttempt::create([
            'user_id'         => Auth::id(),
            'subject_id'      => $subject->id,
            'type'            => $jenis,
            'answers'         => $storedAnswers,
            'score'           => $score,
            'max_score'       => $maxScore,
            'correct_count'   => $correctCount,
            'total_questions' => $orderedQuestions->count(),
            'submitted_at'    => now(),
        ]);

        $this->syncAttemptToNilai($attempt, $subject);

        $this->clearExamSession($jenis, $subject);

        $msg = $isViolation
            ? 'Ujian diakhiri karena pelanggaran aturan. Nilai: 0'
            : 'Jawaban berhasil dikirim. Nilai kamu: ' . $score . ' / ' . $maxScore;

        return redirect()
            ->route('ujian.result', [$jenis, $subject, 'attempt' => $attempt->id])
            ->with($isViolation ? 'error' : 'success', $msg);
    }

    public function examResult(Request $request, string $jenis, Subject $subject)
    {
        [$jenis, $attempt, $details, $isViolation, $meta] = $this->resolveExamResultData($request, $jenis, $subject);

        if (!$attempt) {
            return redirect()
                ->route('ujian.take', [$jenis, $subject])
                ->with('error', 'Belum ada hasil ujian untuk mapel ini.');
        }

        return view('ujian.hasil', compact('jenis', 'subject', 'attempt', 'details', 'isViolation', 'meta'));
    }

    public function examResultPdf(Request $request, string $jenis, Subject $subject)
    {
        [$jenis, $attempt, $details, $isViolation, $meta] = $this->resolveExamResultData($request, $jenis, $subject);

        if (!$attempt) {
            return redirect()
                ->route('ujian.take', [$jenis, $subject])
                ->with('error', 'Belum ada hasil ujian untuk mapel ini.');
        }

        $attempt->loadMissing('user');
        $attemptUser = $attempt->user;
        $student = $attemptUser ? Student::findByUser($attemptUser) : null;

        $studentName = $student?->name ?? $attemptUser?->name ?? '-';
        $studentNis = $student?->nis ?? '-';
        $studentClass = $student?->class_id ?? '-';

        $pdf = Pdf::loadView('ujian.hasil-pdf', compact(
            'jenis',
            'subject',
            'attempt',
            'details',
            'studentName',
            'studentNis',
            'studentClass',
            'isViolation',
            'meta'
        ))
            ->setPaper('a4', 'portrait');

        $safeSubject = preg_replace('/[^A-Za-z0-9_\-]/', '_', (string) $subject->name);

        return $pdf->download('Hasil_' . strtoupper($jenis) . '_' . $safeSubject . '_Attempt_' . $attempt->id . '.pdf');
    }

    private function resolveExamResultData(Request $request, string $jenis, Subject $subject): array
    {
        $jenis = $this->normalizeJenis($jenis);
        if (!$jenis) {
            abort(404);
        }

        $attemptId = $request->integer('attempt');

        $attemptQuery = ExamAttempt::where('user_id', Auth::id())
            ->where('type', $jenis)
            ->where('subject_id', $subject->id)
            ->latest('submitted_at');

        if ($attemptId) {
            $attemptQuery->where('id', $attemptId);
        }

        $attempt = $attemptQuery->first();
        if (!$attempt) {
            return [$jenis, null, collect(), false, []];
        }

        $rawAnswers = (array) ($attempt->answers ?? []);
        $meta = (array) ($rawAnswers['_meta'] ?? []);
        $isViolation = !empty($meta['is_violation']);

        $answerData = collect($rawAnswers)->except('_meta');
        $questionIds = $answerData->keys()->map(fn ($id) => (int) $id)->filter(fn ($id) => $id > 0)->values();

        $questions = ExamQuestion::with('subject')
            ->whereIn('id', $questionIds)
            ->get()
            ->keyBy('id');

        $details = $questionIds->map(function (int $questionId) use ($answerData, $questions) {
            $question = $questions->get($questionId);
            if (!$question) {
                return null;
            }

            $data = $answerData->get((string) $questionId, []);
            $rawSelected = $data['selected'] ?? null;
            $selected = ($rawSelected !== null && $rawSelected !== '') ? (string) $rawSelected : null;

            return [
                'question'      => $question,
                'selected'      => $selected,
                'correct'       => $data['correct'] ?? $question->correct_answer,
                'is_correct'    => (bool) ($data['is_correct'] ?? false),
                'is_unanswered' => ($selected === null),
            ];
        })->filter()->values();

        return [$jenis, $attempt, $details, $isViolation, $meta];
    }

    private function renderPaymentPage(string $jenis)
    {
        $student = Student::findByUser(Auth::user());

        // Auto-create a student profile for the authenticated user if missing
        // (helps when seed/data does not include a linked student record).
        if (!$student && Auth::user()?->role === 'siswa') {
            $student = Student::createForUser(Auth::user());
        }

        $subjects = $this->availableSubjectsForCurrentUser($student);

        $latestAttemptsBySubject = ExamAttempt::where('user_id', Auth::id())
            ->where('type', $jenis)
            ->latest('submitted_at')
            ->get()
            ->groupBy('subject_id')
            ->map(fn (Collection $items) => $items->first());

        // Ambil hanya 1 pembayaran UTS/UAS (bukan per mapel)
        $payment = Ujian::where('user_id', Auth::id())
            ->where('jenis', $jenis)
            ->latest()
            ->first();

        $cards = $subjects->map(function (Subject $subject) use ($jenis, $payment, $latestAttemptsBySubject) {
            $latestAttempt = $latestAttemptsBySubject->get($subject->id);
            $questionCount = ExamQuestion::active()
                ->where('subject_id', $subject->id)
                ->where('type', $jenis)
                ->count();

            return [
                'subject'       => $subject,
                'payment'       => $payment,
                'latestAttempt' => $latestAttempt,
                'isDone'        => (bool) $latestAttempt,
                'questionCount' => $questionCount,
                'canTake'       => !$latestAttempt && $questionCount >= self::EXAM_QUESTION_LIMIT,
            ];
        })->values();

        return view('ujian.' . $jenis, compact('payment', 'subjects', 'student', 'cards', 'jenis'));
    }

    private function availableSubjectsForCurrentUser(?Student $student)
    {
        // If student and class_id are available, filter by schedule
        if ($student && !empty($student->class_id)) {
            // Get all active schedules for the student's class
            $scheduleSubjectIds = \App\Models\Schedule::active()
                ->where('class_id', $student->class_id)
                ->pluck('subject_id')
                ->unique()
                ->toArray();

            // Return only active subjects that are in the schedule
            return Subject::active()
                ->whereIn('id', $scheduleSubjectIds)
                ->orderBy('name')
                ->get();
        }

        // Fallback: return all active subjects (should rarely happen)
        return Subject::active()->orderBy('name')->get();
    }

    private function verifiedExamPayment(string $jenis, int $subjectId): ?Ujian
    {
        $userId = Auth::id();

        if (!$userId) {
            return null;
        }

        // Karena sistem sekarang satu kali bayar UTS/UAS untuk semua mapel,
        // kita hapus filter berdasarkan subject_id.
        return Ujian::where('user_id', $userId)
            ->where('jenis', $jenis)
            ->where('status', 'verified')
            ->latest('verified_at')
            ->first();
    }

    private function normalizeText(?string $text): string
    {
        return preg_replace('/[^a-z0-9]/', '', mb_strtolower(trim((string) $text)));
    }

    private function normalizeJenis(string $jenis): ?string
    {
        return in_array($jenis, ['uts', 'uas'], true) ? $jenis : null;
    }

    private function syncAttemptToNilai(ExamAttempt $attempt, Subject $subject): void
    {
        $user = Auth::user();
        if (!$user) {
            return;
        }

        $student = Student::findByUser($user);
        if (!$student) {
            return;
        }

        $rawAnswers = (array) ($attempt->answers ?? []);
        $meta = (array) ($rawAnswers['_meta'] ?? []);
        $isViolation = !empty($meta['is_violation']);

        $maxScore = (float) $attempt->max_score;
        $rawScore = (float) $attempt->score;
        $finalScore = ($maxScore > 0 && !$isViolation)
            ? round(($rawScore / $maxScore) * 100, 2)
            : 0.00;

        $submittedAt = $attempt->submitted_at ?? now();
        $semester = ((int) $submittedAt->month >= 7) ? 1 : 2;
        $tahun = (int) $submittedAt->year;

        $keterangan = $isViolation
            ? 'Diskualifikasi - Pelanggaran Ujian Online (Keluar Layar Penuh/Pindah Tab)'
            : 'Auto dari hasil ' . strtoupper((string) $attempt->type);

        Nilai::updateOrCreate(
            [
                'student_id' => $student->id,
                'subject_id' => $subject->id,
                'type'       => $attempt->type,
                'semester'   => $semester,
                'tahun'      => $tahun,
            ],
            [
                'nilai'      => $finalScore,
                'keterangan' => $keterangan,
            ]
        );
    }

    private function examSessionKey(string $jenis, Subject $subject): string
    {
        return 'exam_session.' . Auth::id() . '.' . $jenis . '.' . $subject->id;
    }

    private function prepareExamSession(string $jenis, Subject $subject, Collection $questions): array
    {
        $sessionKey = $this->examSessionKey($jenis, $subject);
        $existing = session($sessionKey);

        if (is_array($existing) && isset($existing['started_at'], $existing['question_order'])) {
            $startedAt = Carbon::parse($existing['started_at']);
            $duration = (int) ($existing['duration_minutes'] ?? ($this->examDurationMinutes($jenis)));
            $endsAt = $startedAt->copy()->addMinutes($duration);
            $questionOrder = collect($existing['question_order'])
                ->map(fn ($id) => (int) $id)
                ->take(self::EXAM_QUESTION_LIMIT)
                ->values()
                ->all();

            $optionOrders = [];
            foreach ($questionOrder as $qid) {
                $optionOrders[$qid] = ['a', 'b', 'c', 'd'];
            }

            return [
                'started_at' => $startedAt,
                'ends_at' => $endsAt,
                'duration_minutes' => $duration,
                'question_order' => $questionOrder,
                'option_orders' => $optionOrders,
            ];
        }

        $questionOrder = $questions->take(self::EXAM_QUESTION_LIMIT)->pluck('id')->values()->all();
        $optionOrders = [];
        foreach ($questionOrder as $questionId) {
            $optionOrders[$questionId] = ['a', 'b', 'c', 'd'];
        }

        $startedAt = now();
        $duration = $this->examDurationMinutes($jenis);

        session([
            $sessionKey => [
                'started_at' => $startedAt->toIso8601String(),
                'duration_minutes' => $duration,
                'question_order' => $questionOrder,
                'option_orders' => $optionOrders,
            ],
        ]);

        return [
            'started_at' => $startedAt,
            'ends_at' => $startedAt->copy()->addMinutes($duration),
            'duration_minutes' => $duration,
            'question_order' => $questionOrder,
            'option_orders' => $optionOrders,
        ];
    }

    private function getExamSession(string $jenis, Subject $subject): ?array
    {
        $sessionKey = $this->examSessionKey($jenis, $subject);
        $data = session($sessionKey);

        if (!is_array($data) || empty($data['started_at'])) {
            return null;
        }

        $startedAt = Carbon::parse($data['started_at']);
        $duration = (int) ($data['duration_minutes'] ?? $this->examDurationMinutes($jenis));
        $questionOrder = collect($data['question_order'] ?? [])->map(fn ($id) => (int) $id)->values()->all();
        $optionOrders = [];
        foreach ($questionOrder as $qid) {
            $optionOrders[$qid] = ['a', 'b', 'c', 'd'];
        }

        return [
            'started_at' => $startedAt,
            'ends_at' => $startedAt->copy()->addMinutes($duration),
            'duration_minutes' => $duration,
            'question_order' => $questionOrder,
            'option_orders' => $optionOrders,
        ];
    }

    private function clearExamSession(string $jenis, Subject $subject): void
    {
        session()->forget($this->examSessionKey($jenis, $subject));
    }

    private function examDurationMinutes(string $jenis): int
    {
        $default = $jenis === 'uas' ? 90 : 60;
        return (int) \App\Models\Setting::get('exam_duration_' . $jenis, $default);
    }
}
