<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ExamAttempt;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamResultController extends Controller
{
    private function getAllowedSubjectIds($user) {
        if ($user->role !== 'guru' && $user->role !== 'teacher') {
            return null; // Admin/Kepala Sekolah bisa akses semua
        }
        $scheduleSubjectIds = \App\Models\Schedule::where('teacher_id', $user->id)->pluck('subject_id')->toArray();
        $subjectIdsFromName = Subject::where('teacher', $user->name)->orWhere('teacher', $user->email)->pluck('id')->toArray();
        return array_unique(array_merge($scheduleSubjectIds, $subjectIdsFromName));
    }

    /**
     * Display exam results for a specific subject (Teacher View)
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Detect whether subject_id was present in the query string
        $hasParam = $request->has('subject_id');
        $subjectId = $request->integer('subject_id'); // may be null or 0
        $classId = $request->string('class_id');

        $subjectsQuery = Subject::active()->orderBy('class_id')->orderBy('name');

        $allowedSubjectIds = $this->getAllowedSubjectIds($user);
        if ($allowedSubjectIds !== null) {
            $subjectsQuery->whereIn('id', $allowedSubjectIds);
        }

        $subjects = $subjectsQuery->get();

        $classOptions = Student::select('class_id')
            ->whereNotNull('class_id')
            ->distinct()
            ->orderBy('class_id')
            ->pluck('class_id');

        // Default ke subject pertama hanya jika param subject_id TIDAK disertakan
        if (!$subjects->isEmpty() && !$hasParam) {
            $subjectId = $subjects->first()->id;
        }

        $query = ExamAttempt::with(['user.student', 'subject'])->latest('submitted_at');
        
        if ($subjectId && $subjectId > 0) {
            if ($allowedSubjectIds !== null && !in_array($subjectId, $allowedSubjectIds)) {
                $query->where('id', -1); // Blokir akses jika bukan mapel yang diajar
            } else {
                $query->where('subject_id', $subjectId);
            }
        } else {
            if ($allowedSubjectIds !== null) {
                $query->whereIn('subject_id', $allowedSubjectIds);
            }
        }

        if ($classId) {
            $query->whereHas('user.student', function ($q) use ($classId) {
                $q->where('class_id', $classId);
            });
        }

        $attempts = $query->paginate(20);

        return view('exam-results.index', compact('subjects', 'subjectId', 'attempts', 'hasParam', 'classOptions', 'classId'));
    }

    /**
     * Get exam results via API for real-time updates
     */
    public function getResults(Request $request)
    {
        $user = Auth::user();
        $subjectId = $request->integer('subject_id');
        $search = $request->string('search')->trim();
        $classId = $request->string('class_id');
        $limit = $request->integer('limit', 20);
        
        $query = ExamAttempt::with(['user.student', 'subject']);
        $allowedSubjectIds = $this->getAllowedSubjectIds($user);
        
        // Filter by subject jika ada subject_id > 0
        if ($subjectId && $subjectId > 0) {
            if ($allowedSubjectIds !== null && !in_array($subjectId, $allowedSubjectIds)) {
                $query->where('id', -1);
            } else {
                $query->where('subject_id', $subjectId);
            }
        } else {
            if ($allowedSubjectIds !== null) {
                $query->whereIn('subject_id', $allowedSubjectIds);
            }
        }

        if ($classId) {
            $query->whereHas('user.student', function ($q) use ($classId) {
                $q->where('class_id', $classId);
            });
        }
        
        if ($search !== '') {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        
        $attempts = $query->latest('submitted_at')
            ->limit($limit)
            ->get()
            ->map(function ($attempt) {
                return [
                    'id' => $attempt->id,
                    'student_name' => $attempt->user?->name ?? 'Unknown',
                    'student_email' => $attempt->user?->email ?? '-',
                    'class' => $attempt->user?->student?->class_id ?? '-',
                    'subject' => $attempt->subject?->name ?? '-',
                    'type' => strtoupper($attempt->type),
                    'score' => $attempt->score,
                    'max_score' => $attempt->max_score,
                    'percentage' => round(($attempt->score / $attempt->max_score) * 100, 2),
                    'correct' => $attempt->correct_count,
                    'total' => $attempt->total_questions,
                    'submitted_at' => $attempt->submitted_at?->format('d M Y H:i:s') ?? '-',
                    'submitted_relative' => $attempt->submitted_at?->diffForHumans() ?? '-',
                ];
            });
        
        return response()->json(['data' => $attempts, 'total' => $attempts->count()]);
    }

    /**
     * Show exam attempt details
     */
    public function show(ExamAttempt $attempt)
    {
        $user = Auth::user();
        $allowedSubjectIds = $this->getAllowedSubjectIds($user);
        
        if ($allowedSubjectIds !== null && !in_array($attempt->subject_id, $allowedSubjectIds)) {
            abort(403, 'Anda tidak memiliki akses untuk melihat hasil ujian mapel ini.');
        }

        $attempt->load(['user', 'subject']);
        
        return view('exam-results.show', compact('attempt'));
    }

    /**
     * Export exam results to CSV
     */
    public function export(Request $request)
    {
        $user = Auth::user();
        $subjectId = $request->integer('subject_id');
        $classId = $request->string('class_id');
        $search = $request->string('search')->trim();
        
        $filename = 'hasil_ujian_';
        
        // Jika ada subject_id, gunakan nama subject. Jika tidak, gunakan "semua_mapel"
        if ($subjectId && $subjectId > 0) {
            $subject = Subject::find($subjectId);
            if (!$subject) {
                return back()->with('error', 'Mapel tidak ditemukan');
            }
            $filename .= str_replace(' ', '_', $subject->name) . '_';
        } else {
            $filename .= 'semua_mapel_';
        }
        
        $filename .= now()->format('Y-m-d') . '.csv';
        
        $query = ExamAttempt::with(['user.student', 'subject']);
        
        if ($subjectId && $subjectId > 0) {
            $query->where('subject_id', $subjectId);
        }

        if ($classId) {
            $query->whereHas('user.student', function ($q) use ($classId) {
                $q->where('class_id', $classId);
            });
        }
        
        if ($search !== '') {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        
        $attempts = $query->latest('submitted_at')->get();
        
        
        return response()->streamDownload(function () use ($attempts) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
            
            // Header
            fputcsv($handle, ['Nama Siswa', 'Email', 'Kelas', 'Mapel', 'Tipe Ujian', 'Skor', 'Skor Maksimal', 'Persentase', 'Benar', 'Total Soal', 'Waktu Selesai']);
            
            // Data
            foreach ($attempts as $attempt) {
                fputcsv($handle, [
                    $attempt->user?->name ?? 'Unknown',
                    $attempt->user?->email ?? '-',
                    $attempt->user?->student?->class_id ?? '-',
                    $attempt->subject?->name ?? '-',
                    strtoupper($attempt->type),
                    $attempt->score,
                    $attempt->max_score,
                    round(($attempt->score / $attempt->max_score) * 100, 2) . '%',
                    $attempt->correct_count,
                    $attempt->total_questions,
                    $attempt->submitted_at?->format('d M Y H:i:s') ?? '-',
                ]);
            }
            
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=utf-8']);
    }
}
