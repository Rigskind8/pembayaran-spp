<?php

namespace App\Livewire\Guru;

use Livewire\Component;
use App\Models\Schedule; // Add this import
use App\Models\Student;
use App\Models\Ujian;
use App\Models\Nilai;
use Illuminate\Support\Facades\Auth;

class HasilUjian extends Component
{
    public $kelas_id = '';
    public $murid_id = '';
    public $listKelas = [];
    public $listMurid = [];
    public $hasilUjian = [];

    public function mount()
    {
        // Ambil kelas yang diajar oleh guru dari jadwal
        $guru = Auth::user();
        $this->listKelas = Schedule::where('teacher_id', $guru->id)
                                   ->pluck('class_id')
                                   ->unique()
                                   ->values()
                                   ->toArray();
        // Jika guru hanya mengajar satu kelas, otomatis pilih kelas tersebut
        if (count($this->listKelas) === 1) {
            $this->kelas_id = $this->listKelas[0];
        }
        $this->updateMurid();
        $this->updateHasil();
    }

    public function updatedKelasId()
    {
        $this->murid_id = '';
        $this->updateMurid();
        $this->updateHasil();
    }

    public function updatedMuridId()
    {
        $this->updateHasil();
    }

    public function updateMurid()
    {
        if ($this->kelas_id) {
            $this->listMurid = Student::where('class_id', $this->kelas_id)->get();
        } else {
            $this->listMurid = collect();
        }
    }

    public function updateHasil()
    {
        $query = Nilai::query();
        if ($this->kelas_id) {
            $query->whereHas('student', function($q) {
                $q->where('class_id', $this->kelas_id);
            });
        }
        if ($this->murid_id) {
            $query->where('student_id', $this->murid_id);
        }
        $this->hasilUjian = $query->with(['student', 'subject'])->get(); // Eager load 'subject' instead of 'ujian'
    }

    public function exportPdf()
    {
        $query = Nilai::query();
        if ($this->kelas_id) {
            $query->whereHas('student', function($q) {
                $q->where('class_id', $this->kelas_id);
            });
        }
        if ($this->murid_id) {
            $query->where('student_id', $this->murid_id);
        }
        $dataExport = $query->with(['student', 'subject'])->get();

        $murid = $this->murid_id ? Student::find($this->murid_id) : null;
        $namaMurid = $murid ? ($murid->name ?? $murid->nama) : 'Semua Murid';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.hasil-ujian', [
            'hasilUjian' => $dataExport,
            'kelas' => $this->kelas_id ?: 'Semua Kelas',
            'murid' => $namaMurid
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Hasil_Ujian_Siswa_' . now()->format('Ymd_His') . '.pdf');
    }

    public function render()
    {
        return view('livewire.guru.hasil-ujian')
            ->extends('layouts.app')
            ->section('content');
    }
}
