<?php

namespace App\Http\Controllers;

use App\Models\ExamQuestion;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExamQuestionController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->get('jenis', 'uts');
        if (! in_array($jenis, ['uts', 'uas'], true)) {
            $jenis = 'uts';
        }

        $subjectId = $request->integer('subject_id') ?: null;

        $subjects = Subject::active()
            ->orderBy('class_id')
            ->orderBy('name')
            ->get();

        $query = ExamQuestion::with('subject')->orderBy('subject_id')->orderBy('type')->orderBy('sort_order')->latest();

        $query->where('type', $jenis);

        if ($subjectId) {
            $query->where('subject_id', $subjectId);
        }

        $questions = $query->paginate(15)->withQueryString();

        return view('admin.exam-questions', compact('questions', 'subjects', 'jenis', 'subjectId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id'      => 'required|exists:subjects,id',
            'type'            => 'required|in:uts,uas',
            'question'        => 'required|string|min:5',
            'option_a'        => 'required|string|max:255',
            'option_b'        => 'required|string|max:255',
            'option_c'        => 'required|string|max:255',
            'option_d'        => 'required|string|max:255',
            'correct_answer'  => 'required|in:a,b,c,d',
            'points'          => 'nullable|integer|min:1|max:100',
            'sort_order'      => 'nullable|integer|min:0',
            'is_active'       => 'nullable|boolean',
        ]);

        ExamQuestion::create([
            'subject_id'     => $validated['subject_id'],
            'type'           => $validated['type'],
            'question'       => $validated['question'],
            'options'        => [
                'a' => $validated['option_a'],
                'b' => $validated['option_b'],
                'c' => $validated['option_c'],
                'd' => $validated['option_d'],
            ],
            'correct_answer' => $validated['correct_answer'],
            'points'         => $validated['points'] ?? 10,
            'sort_order'     => $validated['sort_order'] ?? 0,
            'is_active'      => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Soal ujian berhasil ditambahkan.');
    }

    public function update(Request $request, ExamQuestion $examQuestion)
    {
        $validated = $request->validate([
            'subject_id'      => 'required|exists:subjects,id',
            'type'            => 'required|in:uts,uas',
            'question'        => 'required|string|min:5',
            'option_a'        => 'required|string|max:255',
            'option_b'        => 'required|string|max:255',
            'option_c'        => 'required|string|max:255',
            'option_d'        => 'required|string|max:255',
            'correct_answer'  => 'required|in:a,b,c,d',
            'points'          => 'nullable|integer|min:1|max:100',
            'sort_order'      => 'nullable|integer|min:0',
            'is_active'       => 'nullable|boolean',
        ]);

        $examQuestion->update([
            'subject_id'     => $validated['subject_id'],
            'type'           => $validated['type'],
            'question'       => $validated['question'],
            'options'        => [
                'a' => $validated['option_a'],
                'b' => $validated['option_b'],
                'c' => $validated['option_c'],
                'd' => $validated['option_d'],
            ],
            'correct_answer' => $validated['correct_answer'],
            'points'         => $validated['points'] ?? 10,
            'sort_order'     => $validated['sort_order'] ?? 0,
            'is_active'      => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Soal ujian berhasil diperbarui.');
    }

    public function destroy(ExamQuestion $examQuestion)
    {
        $examQuestion->delete();

        return back()->with('success', 'Soal ujian berhasil dihapus.');
    }
}