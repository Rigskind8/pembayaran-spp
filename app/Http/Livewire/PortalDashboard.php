<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Payment;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;

class PortalDashboard extends Component
{
    public $studentId;
    public $payments;
    public $announcements;
    public $lunas = 0;
    public $pending = 0;
    public $belumBayar = 0;
    public $totalBayar = 0;

    public function mount($studentId = null)
    {
        $this->studentId = $studentId ?? optional(Auth::user()->student)->id;
        $this->loadData();
    }

    public function loadData()
    {
        if (!$this->studentId) {
            $this->payments = collect();
            $this->announcements = collect();
            return;
        }

        $payments = Payment::where('student_id', $this->studentId)->orderBy('created_at', 'desc')->get();
        $this->payments = $payments;

        // Exclude specific announcements from student dashboard (case-insensitive)
        $excludeTitles = [
            'libur idul adha',
        ];

        $this->announcements = Pengumuman::latest()->get()
            ->filter(function ($a) use ($excludeTitles) {
                return !in_array(strtolower(trim($a->title)), $excludeTitles, true);
            })
            ->values()
            ->take(5);

        $this->lunas = $payments->whereIn('status', ['approved', 'paid'])->count();
        $this->pending = $payments->where('status', 'pending')->count();
        $this->belumBayar = $payments->where('status', 'unpaid')->count();
        $this->totalBayar = $payments->whereIn('status', ['approved', 'paid'])->sum('amount');
    }

    public function refresh()
    {
        $this->loadData();
        $this->dispatchBrowserEvent('portal:refreshed');
    }

    public function render()
    {
        return view('livewire.portal-dashboard');
    }
}
