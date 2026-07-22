<!DOCTYPE html>
<html>
<head>
    <title>Hasil Ujian Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        h2 { text-align: center; margin-bottom: 5px; }
        p { text-align: center; margin-top: 0; margin-bottom: 20px; color: #555; }
        .info-table { margin-bottom: 15px; width: 100%; }
        .info-table td { padding: 3px 0; border: none; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th, .data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .data-table th { background-color: #f4f6f9; font-weight: bold; text-align: center; }
        .text-center { text-align: center !important; }
    </style>
</head>
<body>
    <h2>Laporan Hasil Ujian Siswa</h2>
    <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>

    <table class="info-table">
        <tr>
            <td width="10%"><strong>Kelas</strong></td>
            <td width="2%">:</td>
            <td>{{ $kelas }}</td>
        </tr>
        <tr>
            <td><strong>Murid</strong></td>
            <td>:</td>
            <td>{{ $murid }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Nama Murid</th>
                <th width="15%">Kelas</th>
                <th width="30%">Mapel Ujian</th>
                <th width="15%">Nilai</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hasilUjian as $i => $hasil)
                <tr>
                    <td class="text-center">{{ $i+1 }}</td>
                    <td>{{ $hasil->student->name ?? $hasil->student->nama ?? '-' }}</td>
                    <td class="text-center">{{ $hasil->student->class_id ?? '-' }}</td>
                    <td>{{ $hasil->subject->name ?? '-' }} {{ $hasil->type ? '('.strtoupper($hasil->type).')' : '' }}</td>
                    <td class="text-center">{{ $hasil->nilai ?? $hasil->score ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data nilai ujian untuk filter ini</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>