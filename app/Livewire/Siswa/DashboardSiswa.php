<?php

namespace App\Livewire\Siswa;

use App\Models\Notifikasi;
use App\Models\Ujian;
use App\Models\Student;
use App\Models\Subject;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class DashboardSiswa extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $filterStatus = 'all';

    // Form pengajuan ujian
    public string $jenis = '';
    public string $mata_pelajaran = '';
    public string $tanggal_ujian = '';
    public bool $showForm = false;

    /** @var \Illuminate\Support\Collection|array */
    public $subjectOptions = [];

    // ── Computed Properties ───────────────────────────────────────────────

    #[Computed]
    public function totalPending(): int
    {
        return Ujian::where('user_id', Auth::id())->where('status', 'pending')->count();
    }

    #[Computed]
    public function totalVerified(): int
    {
        return Ujian::where('user_id', Auth::id())->where('status', 'verified')->count();
    }

    #[Computed]
    public function totalRejected(): int
    {
        return Ujian::where('user_id', Auth::id())->where('status', 'rejected')->count();
    }

    #[Computed]
    public function unreadNotif(): int
    {
        return Notifikasi::where('user_id', Auth::id())->where('dibaca', false)->count();
    }

    #[On('ujianDiverifikasi')]
    public function refreshData(): void
    {
        // Fungsi kosong; Livewire 3 otomatis me-render ulang komponen saat event diterima
    }

    // ── Actions ───────────────────────────────────────────────────────────

    public function ajukanUjian(): void
    {
        $this->validate([
            'jenis'          => 'required|in:uts,uas,praktek,remedial',
            'mata_pelajaran' => 'required',
            'tanggal_ujian'  => 'required|date|after_or_equal:today',
        ], [
            'jenis.required'          => 'Jenis ujian wajib dipilih.',
            'mata_pelajaran.required' => 'Mata pelajaran wajib dipilih.',
            'tanggal_ujian.required'  => 'Tanggal ujian wajib diisi.',
            'tanggal_ujian.after_or_equal' => 'Tanggal ujian tidak boleh di masa lalu.',
        ]);

        $subject = Subject::find($this->mata_pelajaran);
        $subjectName = $subject ? $subject->name : '';

        Ujian::create([
            'user_id'        => Auth::id(),
            'jenis'          => $this->jenis,
            'mata_pelajaran' => $subjectName,
            'subject_id'     => $subject ? $subject->id : null,
            'tanggal_ujian'  => $this->tanggal_ujian,
            'status'         => 'pending',
        ]);

        $this->dispatch('ujianDiajukan')->to('admin.manajemen-ujian');

        $this->reset(['jenis', 'mata_pelajaran', 'tanggal_ujian', 'showForm']);
        session()->flash('toast', ['type' => 'success', 'msg' => 'Pengajuan ujian berhasil dikirim!']);
    }

    public function batalForm(): void
    {
        $this->reset(['jenis', 'mata_pelajaran', 'tanggal_ujian', 'showForm']);
    }

    public function setFilter(string $status): void
    {
        $this->filterStatus = $status;
        $this->resetPage();
    }

    public function tandaiDibaca(int $id): void
    {
        Notifikasi::where('id', $id)->where('user_id', Auth::id())->update(['dibaca' => true]);
    }

    public function tandaiSemuaDibaca(): void
    {
        Notifikasi::where('user_id', Auth::id())->update(['dibaca' => true]);
    }

    // ── Render ────────────────────────────────────────────────────────────

    public function render()
    {
        $query = Ujian::where('user_id', Auth::id())->latest();

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        $ujians = $query->paginate(10);

        $notifikasis = Notifikasi::where('user_id', Auth::id())
            ->where(function ($query) {
                $query->where('judul', 'not like', '%Disetujui%')
                    ->where('judul', 'not like', '%persetujuan%')
                    ->where('pesan', 'not like', '%diverifikasi%')
                    ->where('pesan', 'not like', '%disetujui%')
                    ->where('pesan', 'not like', '%persetujuan%');
            })
            ->latest()
            ->take(10)
            ->get();

        // Ambil mapel dari jadwal pelajaran aktif untuk kelas siswa
        $student = Student::findByUser(Auth::user());
        $subjectOptions = collect();
        if ($student && $student->class_id) {
            // Ambil subject_id dari schedule aktif untuk kelas siswa
            $subjectIds = \App\Models\Schedule::where('class_id', $student->class_id)
                ->active()
                ->pluck('subject_id')
                ->unique()
                ->filter()
                ->values();
            // Ambil hanya subject yang benar-benar aktif dan ada di tabel subject
            $validSubjectIds = Subject::whereIn('id', $subjectIds)
                ->where('is_active', true)
                ->pluck('id')
                ->toArray();
            $subjectOptions = Subject::whereIn('id', $validSubjectIds)
                ->orderBy('name')
                ->get();
        }
        $this->subjectOptions = $subjectOptions;

        return view('livewire.siswa.dashboard-siswa', [
            'ujians'        => $ujians,
            'notifikasis'   => $notifikasis,
            'subjectOptions'=> $subjectOptions,
        ]);
    }
}