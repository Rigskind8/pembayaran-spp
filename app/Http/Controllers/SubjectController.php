<?php
namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display list of subjects
     */
    public function index()
    {
        $subjects = Subject::with('schedules')
                          ->active()
                          ->orderBy('name')
                          ->paginate(15);
        
        return view('subjects.index', compact('subjects'));
    }

    /**
     * Store a new subject
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'code'           => 'required|unique:subjects,code|string|max:50',
            'class_id'       => 'nullable|string|max:50',
            'hours_per_week' => 'nullable|integer|min:1|max:20',
            'teacher'        => 'nullable|string|max:255',
            'description'    => 'nullable|string|max:500',
        ]);

        Subject::create($validated + ['is_active' => true]);
        
        return back()->with('success', '✓ Mata pelajaran berhasil ditambahkan.');
    }

    /**
     * Update a subject
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'code'           => 'required|unique:subjects,code,' . $subject->id . '|string|max:50',
            'class_id'       => 'nullable|string|max:50',
            'hours_per_week' => 'nullable|integer|min:1|max:20',
            'teacher'        => 'nullable|string|max:255',
            'description'    => 'nullable|string|max:500',
            'is_active'      => 'boolean',
        ]);

        $subject->update($validated);
        
        return back()->with('success', '✓ Mata pelajaran berhasil diupdate.');
    }

    /**
     * Delete a subject
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        
        return back()->with('success', '✓ Mata pelajaran berhasil dihapus.');
    }
}