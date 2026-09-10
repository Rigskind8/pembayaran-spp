@csrf
@if($surat->exists)
    @method('PUT')
@endif

<div class="form-grid">
    <label>Jenis Surat
        <select name="type" id="suratType" required>
            <option value="masuk" @selected(old('type', $surat->type) === 'masuk')>Surat Masuk</option>
            <option value="keluar" @selected(old('type', $surat->type) === 'keluar')>Surat Keluar</option>
        </select>
    </label>
    <label>Status
        <select name="status" required>
            @foreach(['baru' => 'Baru', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'arsip' => 'Arsip'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $surat->status) === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </label>
    <label>Prioritas
        <select name="priority" required>
            @foreach(['biasa' => 'Biasa', 'penting' => 'Penting', 'segera' => 'Segera'] as $value => $label)
                <option value="{{ $value }}" @selected(old('priority', $surat->priority ?: 'biasa') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </label>
    <label>Nomor Surat
        <input type="text" name="number" id="suratNumber" value="{{ old('number', $surat->number) }}" required maxlength="120">
    </label>
    <label>Tanggal Surat
        <input type="date" name="letter_date" value="{{ old('letter_date', optional($surat->letter_date)->format('Y-m-d')) }}" required>
    </label>
    <label>Pengirim
        <input type="text" name="sender" value="{{ old('sender', $surat->sender) }}" maxlength="180">
    </label>
    <label>Penerima
        <input type="text" name="recipient" value="{{ old('recipient', $surat->recipient) }}" maxlength="180">
    </label>
    <label class="full">Perihal
        <input type="text" name="subject" value="{{ old('subject', $surat->subject) }}" required maxlength="255">
    </label>
    <label class="full">Ringkasan / Isi
        <textarea name="description" rows="4">{{ old('description', $surat->description) }}</textarea>
    </label>
    <label class="full">Catatan
        <textarea name="notes" rows="3">{{ old('notes', $surat->notes) }}</textarea>
    </label>
    <label class="full">Disposisi / Instruksi Tindak Lanjut
        <textarea name="disposition" rows="3" placeholder="Contoh: Teruskan ke wakil kepala sekolah untuk ditindaklanjuti.">{{ old('disposition', $surat->disposition) }}</textarea>
        <small>Gunakan untuk mencatat arahan pimpinan, terutama pada surat masuk.</small>
    </label>
    <label class="full">Lampiran (PDF, DOC, DOCX, JPG, PNG; maksimal 10 MB)
        <input type="file" name="attachment" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
        @if($surat->attachment)
            <small>Lampiran saat ini: <a href="{{ Storage::url($surat->attachment) }}" target="_blank">Lihat file</a></small>
        @endif
    </label>
</div>

@if($errors->any())
    <div class="errors">{{ $errors->first() }}</div>
@endif

<button class="btn-primary" type="submit">{{ $surat->exists ? 'Simpan Perubahan' : 'Simpan Surat' }}</button>
<a class="btn-secondary" href="{{ route('surat.index') }}">Batal</a>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('suratType');
    const numberInput = document.getElementById('suratNumber');
    const nextNumber = @json($nextNumber ?? '');
    const originalNumber = @json(old('number', $surat->number) ?? '');

    function handleTypeChange() {
        if (typeSelect.value === 'keluar') {
            // Hanya isi jika form masih baru (tidak sedang edit atau ada old value)
            if (!originalNumber) {
                numberInput.value = nextNumber;
            }
        }
    }

    typeSelect.addEventListener('change', handleTypeChange);
    handleTypeChange(); // Jalankan saat halaman dimuat
});
</script>
@endpush
