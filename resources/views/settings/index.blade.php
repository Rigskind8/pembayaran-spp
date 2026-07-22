{{-- resources/views/settings/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-1 fw-bold">Pengaturan</h2>
    <p class="text-muted mb-4">Kelola info sekolah, nomor WhatsApp admin, dan tanda tangan bendahara untuk dokumen cetak.</p>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- FORM PENGATURAN --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-semibold py-3">⚙️ Info Dokumen</div>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Sekolah</label>
                            <input type="text" name="nama_sekolah" class="form-control"
                                value="{{ old('nama_sekolah', $namaSekolah) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Bendahara</label>
                            <input type="text" name="nama_bendahara" class="form-control"
                                value="{{ old('nama_bendahara', $namaBendahara) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nomor WhatsApp Admin</label>
                            <input type="text" name="wa_admin_number" class="form-control"
                                value="{{ old('wa_admin_number', $waAdminNumber ?? '6281388796229') }}" required>
                            <small class="text-muted">Format internasional tanpa spasi, contoh: 6281388796229</small>
                        </div>

                        <hr class="text-muted my-4">
                        <h6 class="fw-bold mb-3">⏱️ Pengaturan Waktu Ujian</h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Durasi UTS (Menit)</label>
                                <input type="number" name="exam_duration_uts" class="form-control"
                                    value="{{ old('exam_duration_uts', $examDurationUts ?? 60) }}" min="1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Durasi UAS (Menit)</label>
                                <input type="number" name="exam_duration_uas" class="form-control"
                                    value="{{ old('exam_duration_uas', $examDurationUas ?? 90) }}" min="1">
                            </div>
                        </div>
                        <hr class="text-muted my-4">

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Logo Sekolah</label>
                            <input type="file" name="logo_sekolah" class="form-control"
                                accept="image/png,image/jpg,image/jpeg,image/webp">
                            <small class="text-muted">Disarankan PNG transparan. Ukuran ideal minimal 512x512 agar tampil jernih.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Upload Tanda Tangan Bendahara</label>
                            <input type="file" name="ttd_bendahara" class="form-control"
                                accept="image/png,image/jpg,image/jpeg"
                                onchange="previewTTD(this)">
                            <small class="text-muted">Format: PNG/JPG. Gunakan background transparan (PNG) untuk hasil terbaik. Maks 2MB.</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">💾 Simpan Pengaturan</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- PREVIEW TTD --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-semibold py-3">👁️ Preview Tanda Tangan</div>
                <div class="card-body text-center">
                    @if($ttd)
                        <p class="text-muted small mb-2">Tanda tangan yang akan muncul di dokumen cetak:</p>
                        <div style="border: 1px dashed #ccc; border-radius:6px; padding:10px; display:inline-block; background:#f9f9f9; min-width:200px; min-height:80px;">
                            <img src="{{ asset('storage/' . $ttd) }}" alt="TTD Bendahara"
                                style="max-width:200px; max-height:100px; object-fit:contain;">
                        </div>
                        @if(!empty($logoSekolah))
                            @php
                                $isAbsoluteLogo = str_starts_with($logoSekolah, 'http://') || str_starts_with($logoSekolah, 'https://');
                                $logoPreviewUrl = $isAbsoluteLogo ? $logoSekolah : asset('storage/' . ltrim($logoSekolah, '/'));
                            @endphp
                            <p class="text-muted small mb-2 mt-3">Logo sekolah yang tampil di halaman About:</p>
                            <div style="border: 1px dashed #ccc; border-radius:6px; padding:10px; display:inline-block; background:#fff; min-width:120px; min-height:120px;">
                                <img src="{{ $logoPreviewUrl }}" alt="Logo Sekolah"
                                    style="max-width:120px; max-height:120px; object-fit:contain; image-rendering:-webkit-optimize-contrast;">
                            </div>
                        @endif
                        <div class="mt-3">
                            <form action="{{ route('settings.hapus-ttd') }}" method="POST"
                                onsubmit="return confirm('Hapus tanda tangan?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Hapus Tanda Tangan</button>
                            </form>
                        </div>
                    @else
                        <div id="previewWrap" style="display:none; border: 1px dashed #ccc; border-radius:6px; padding:10px; display:none; background:#f9f9f9;">
                            <img id="previewImg" src="" style="max-width:200px; max-height:100px; object-fit:contain;">
                        </div>
                        <div id="emptyState" class="py-4 text-muted">
                            <div class="fs-1">✍️</div>
                            <div class="mt-2">Belum ada tanda tangan.<br>Upload di form sebelah kiri.</div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- TIPS --}}
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <div class="fw-semibold mb-2">💡 Tips upload TTD terbaik:</div>
                    <ul class="small text-muted mb-0" style="padding-left:16px;">
                        <li>Gunakan file <strong>PNG dengan background transparan</strong> agar TTD tidak ada kotak putih</li>
                        <li>Tanda tangan di kertas putih, foto/scan, lalu hapus background pakai <a href="https://remove.bg" target="_blank">remove.bg</a> (gratis)</li>
                        <li>Ukuran ideal: lebar 300–500px</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function previewTTD(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const wrap = document.getElementById('previewWrap');
            const img  = document.getElementById('previewImg');
            const empty = document.getElementById('emptyState');
            if (wrap) { wrap.style.display = 'inline-block'; img.src = e.target.result; }
            if (empty) empty.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection