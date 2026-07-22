<?php

namespace App\Livewire\Admin;

use App\Models\Ujian;
use App\Models\Subject;
use App\Models\Notifikasi;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class ManajemenUjian extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $filterStatus  = 'all';
    public string $filterJenis   = '';
    public string $search        = '';

    // ── Computed Properties ───────────────────────────────────────────────

    #[Computed]
    public function totalPending(): int
    {
        return Ujian::where('status', 'pending')->count();
    }

    #[Computed]
    public function totalVerified(): int
    {
        return Ujian::where('status', 'verified')->count();
    }

    #[Computed]
    public function totalRejected(): int
    {
        return Ujian::where('status', 'rejected')->count();
    }

    #[On('ujianDiajukan')]
    public function refreshData(): void
    {
        // Fungsi kosong; Livewire 3 otomatis me-render ulang komponen saat event diterima
    }

    // ── Actions ───────────────────────────────────────────────────────────

    public function approve(int $id): void
    {
        $ujian = Ujian::with('user')->findOrFail($id);

        if ($ujian->status !== 'pending') {
            return;
        }

        $update = [
            'status'      => 'verified',
            'verified_at' => now(),
        ];

        if (empty($ujian->subject_id) && !empty($ujian->mata_pelajaran)) {
            $mpNorm = $this->normalizeText($ujian->mata_pelajaran);
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

        $ujian->update($update);

        try {
            Notifikasi::create([
                'user_id' => $ujian->user_id,
                'ujian_id' => $ujian->id,
                'judul' => 'Pengajuan Ujian Disetujui',
                'pesan' => 'Pengajuan ujian untuk ' . ($ujian->mata_pelajaran ?? '-') . ' telah diverifikasi oleh admin.',
                'tipe' => 'ujian',
                'dibaca' => false,
            ]);
        } catch (\Throwable $e) {
            // non-fatal
        }

        $this->dispatch('ujianDiverifikasi')->to('siswa.dashboard-siswa');
    }

    private function normalizeText(?string $text): string
    {
        return preg_replace('/[^a-z0-9]/', '', mb_strtolower(trim((string) $text)));
    }

    public function reject(int $id): void
    {
        $ujian = Ujian::with('user')->findOrFail($id);

        if ($ujian->status !== 'pending') {
            return;
        }

        $ujian->update([
            'status'        => 'rejected',
            'catatan_admin' => null,
        ]);
    }

    public function setFilter(string $status): void
    {
        $this->filterStatus = $status;
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilterJenis(): void
    {
        $this->resetPage();
    }

    // ── Render ────────────────────────────────────────────────────────────

    public function render()
    {
        $query = Ujian::with('user')->latest();

        if ($this->search !== '') {
            $search = trim($this->search);
            $query->where(function ($builder) use ($search) {
                $builder->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%');
                })->orWhere('mata_pelajaran', 'like', '%' . $search . '%');
            });
        }

        if ($this->filterJenis !== '') {
            $query->where('jenis', $this->filterJenis);
        }

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        $ujians = $query->paginate(10);

        return view('livewire.admin.manajemen-ujian', [
            'ujians'        => $ujians,
            'totalPending'  => $this->totalPending,
            'totalVerified' => $this->totalVerified,
            'totalRejected' => $this->totalRejected,
        ]);
    }
}