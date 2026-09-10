<?php

namespace App\Http\Controllers; // Pastikan namespace-nya cuma ini

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->paginate(10)->setPath('/students');
        // Kita panggil view, bukan response json
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string|unique:students,nis',
            'email' => 'required|email|unique:students,email',
            'class_id' => 'required|string|max:50',
            'tahun_ajaran' => 'nullable|string|max:20',
            'gender' => 'required|in:L,P',
            'beasiswa_type' => 'nullable|string|in:reguler,beasiswa_prestasi,kurang_mampu,anak_yatim',
            'potongan_spp' => 'nullable|numeric|min:0',
        ]);

        Student::create($validated);
        return redirect()->route('students.index')->with('success', 'Siswa berhasil ditambah!');
    }

    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string|unique:students,nis,'.$student->id,
            'email' => 'required|email|unique:students,email,'.$student->id,
            'class_id' => 'required|string|max:50',
            'tahun_ajaran' => 'nullable|string|max:20',
            'gender' => 'required|in:L,P',
            'beasiswa_type' => 'nullable|string|in:reguler,beasiswa_prestasi,kurang_mampu,anak_yatim',
            'potongan_spp' => 'nullable|numeric|min:0',
        ]);

        $student->update($validated);
        return redirect()->route('students.index')->with('success', 'Siswa berhasil diupdate!');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Siswa berhasil dihapus!');
    }
}