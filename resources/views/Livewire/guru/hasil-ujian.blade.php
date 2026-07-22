<div class="page">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="topbar-title fw-bold mb-0">Hasil Ujian Siswa</h4>
            <p class="topbar-subtitle mb-0">Filter dan unduh nilai ujian murid berdasarkan kelas</p>
        </div>
        <button wire:click="exportPdf" wire:loading.attr="disabled" class="btn btn-primary">
            <i class="fas fa-file-pdf me-2"></i> <span wire:loading.remove wire:target="exportPdf">Export PDF</span><span wire:loading wire:target="exportPdf">Memproses...</span>
        </button>
    </div>

    <div class="card table-card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label text-muted fw-bold" style="font-size: 13px;">Filter Kelas</label>
                    <select wire:model.live="kelas_id" class="form-select">
                        <option value="">Pilih Kelas</option>
                        @foreach($listKelas as $kls)
                            <option value="{{ $kls }}">{{ $kls }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted fw-bold" style="font-size: 13px;">Filter Murid</label>
                    <select wire:model.live="murid_id" class="form-select">
                        <option value="">Semua Murid</option>
                        @foreach($listMurid as $murid)
                            <option value="{{ $murid->id }}">{{ $murid->nama ?? $murid->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr class="table-light">
                            <th class="text-center" width="50">No</th>
                            <th>Nama Murid</th>
                            <th class="text-center">Kelas</th>
                            <th>Mapel Ujian</th>
                            <th class="text-center">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilUjian as $i => $hasil)
                            <tr>
                                <td class="text-center">{{ $i+1 }}</td>
                                <td>{{ $hasil->student->name ?? $hasil->student->nama ?? '-' }}</td>
                                <td class="text-center">{{ $hasil->student->class_id ?? '-' }}</td>
                                <td>{{ $hasil->subject->name ?? '-' }} {{ $hasil->type ? '('.strtoupper($hasil->type).')' : '' }}</td>
                                <td class="text-center fw-bold">{{ $hasil->nilai ?? $hasil->score ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Tidak ada data hasil ujian</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>