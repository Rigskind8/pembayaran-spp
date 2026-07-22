<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Ujian {{ strtoupper($jenis) }} - {{ $subject->name }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; }
        .header { border-bottom: 2px solid #1d4ed8; padding-bottom: 10px; margin-bottom: 14px; }
        .title { font-size: 18px; font-weight: 700; color: #1e3a8a; }
        .sub { font-size: 11px; color: #64748b; margin-top: 4px; }
        .meta { margin: 10px 0 14px; }
        .meta td { padding: 3px 0; vertical-align: top; }
        .meta .label { width: 120px; color: #6b7280; }
        .summary { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        .summary th, .summary td { border: 1px solid #d1d5db; padding: 7px 8px; }
        .summary th { background: #eff6ff; text-align: left; }
        .section-title { font-size: 13px; font-weight: 700; color: #1e3a8a; margin: 8px 0; }
        .detail { width: 100%; border-collapse: collapse; }
        .detail th, .detail td { border: 1px solid #d1d5db; padding: 6px 7px; vertical-align: top; }
        .detail th { background: #f3f4f6; font-size: 11px; }
        .ok { color: #059669; font-weight: 700; }
        .bad { color: #dc2626; font-weight: 700; }
        .footer { margin-top: 16px; font-size: 10px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Hasil Ujian {{ strtoupper($jenis) }}</div>
        <div class="sub">SMK Travina Prima</div>
    </div>

    <table class="meta">
        <tr><td class="label">Nama Siswa</td><td>: {{ $studentName }}</td></tr>
        <tr><td class="label">NIS</td><td>: {{ $studentNis }}</td></tr>
        <tr><td class="label">Kelas</td><td>: {{ $studentClass }}</td></tr>
        <tr><td class="label">Mata Pelajaran</td><td>: {{ $subject->name }}</td></tr>
        <tr><td class="label">Tanggal Submit</td><td>: {{ $attempt->submitted_at?->format('d M Y H:i') ?? '-' }}</td></tr>
        <tr><td class="label">Attempt ID</td><td>: {{ $attempt->id }}</td></tr>
        <tr><td class="label">Jenis Ujian</td><td>: {{ strtoupper($jenis) }}</td></tr>
    </table>

    <table class="summary">
        <thead>
            <tr>
                <th>Skor</th>
                <th>Benar</th>
                <th>Total Soal</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ number_format((float) $attempt->score, 1) }} / {{ number_format((float) $attempt->max_score, 1) }}</td>
                <td>{{ $attempt->correct_count }}</td>
                <td>{{ $attempt->total_questions }}</td>
                <td>{{ $attempt->max_score > 0 ? number_format(((float) $attempt->score / (float) $attempt->max_score) * 100, 1) : '0' }}%</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">Detail Jawaban</div>
    <table class="detail">
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th>Pertanyaan</th>
                <th style="width: 70px;">Jawaban</th>
                <th style="width: 70px;">Kunci</th>
                <th style="width: 80px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($details as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail['question']->question }}</td>
                    <td>{{ strtoupper((string) ($detail['selected'] ?? '-')) }}</td>
                    <td>{{ strtoupper((string) ($detail['correct'] ?? '-')) }}</td>
                    <td class="{{ $detail['is_correct'] ? 'ok' : 'bad' }}">{{ $detail['is_correct'] ? 'Benar' : 'Salah' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Detail jawaban tidak tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Dicetak otomatis pada {{ now()->format('d M Y H:i') }}</div>
</body>
</html>
