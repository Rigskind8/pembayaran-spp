<div class="p-6 space-y-6">

    {{-- Toast --}}
    @if (session('toast'))
        <div class="alert alert-{{ session('toast')['type'] === 'success' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
            {{ session('toast')['msg'] }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="fw-bold mb-0">Dashboard Siswa</h4>
        <button class="btn btn-primary" wire:click="$set('showForm', true)">
            + Ajukan Ujian
        </button>
    </div>

    {{-- Stats --}}
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body">
                    <div class="text-muted small">Pending</div>
                    <div class="fs-3 fw-bold text-warning">{{ $this->totalPending }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body">
                    <div class="text-muted small">Diverifikasi</div>
                    <div class="fs-3 fw-bold text-success">{{ $this->totalVerified }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-body">
                    <div class="text-muted small">Ditolak</div>
                    <div class="fs-3 fw-bold text-danger">{{ $this->totalRejected }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Pengajuan --}}
    @if ($showForm)
    <div class="card shadow-sm">
        <div class="card-header fw-semibold">Form Pengajuan Ujian</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Jenis Ujian</label>
                    <select class="form-select @error('jenis') is-invalid @enderror" wire:model="jenis">
                        <option value="">-- Pilih --</option>
                        <option value="uts">UTS</option>
                        <option value="uas">UAS</option>
                        <option value="praktek">Praktek</option>
                        <option value="remedial">Remedial</option>
                    </select>
                    @error('jenis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Mata Pelajaran</label>
                    <select class="form-select @error('mata_pelajaran') is-invalid @enderror" wire:model="mata_pelajaran">
                        <option value="">-- Pilih Mapel --</option>
                        @foreach($subjectOptions as $sub)
                            <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                        @endforeach
                    </select>
                    @error('mata_pelajaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Ujian</label>
                    <input type="date"
                        class="form-control @error('tanggal_ujian') is-invalid @enderror"
                        wire:model="tanggal_ujian">
                    @error('tanggal_ujian') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="mt-3 d-flex gap-2">
                <button class="btn btn-primary" wire:click="ajukanUjian" wire:loading.attr="disabled">
                    <span wire:loading wire:target="ajukanUjian" class="spinner-border spinner-border-sm me-1"></span>
                    Kirim Pengajuan
                </button>
                <button class="btn btn-secondary" wire:click="batalForm">Batal</button>
            </div>
        </div>
    </div>
    @endif

    {{-- Filter --}}
    <div class="d-flex gap-2">
        @foreach(['all' => 'Semua', 'pending' => 'Pending', 'verified' => 'Diverifikasi', 'rejected' => 'Ditolak'] as $val => $label)
        <button class="btn btn-sm {{ $filterStatus === $val ? 'btn-primary' : 'btn-outline-secondary' }}"
            wire:click="setFilter('{{ $val }}')">
            {{ $label }}
        </button>
        @endforeach
    </div>



    {{-- Notifikasi --}}
    @if ($notifikasis->count())
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-semibold">
                Notifikasi
                @if ($this->unreadNotif > 0)
                    <span class="badge bg-danger ms-1">{{ $this->unreadNotif }}</span>
                @endif
            </span>
            <button class="btn btn-sm btn-outline-secondary" wire:click="tandaiSemuaDibaca">
                Tandai semua dibaca
            </button>
        </div>
        <ul class="list-group list-group-flush">
            @foreach ($notifikasis as $notif)
            <li class="list-group-item {{ !$notif->dibaca ? 'bg-light' : '' }}"
                wire:click="tandaiDibaca({{ $notif->id }})"
                style="cursor:pointer">
                <div class="d-flex justify-content-between align-items-start">
                    <span class="fw-semibold">{{ $notif->judul }}</span>
                    <small class="text-muted ms-2 text-nowrap">{{ $notif->created_at->diffForHumans() }}</small>
                </div>
                <div class="text-muted small mt-1">{{ $notif->pesan }}</div>
            </li>
            @endforeach
        </ul>
    </div>
    @endif

</div>