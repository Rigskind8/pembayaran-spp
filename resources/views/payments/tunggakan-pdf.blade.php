<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tunggakan Siswa</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; color: #1e293b; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #0f172a; padding-bottom: 15px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 20px; color: #0f172a; text-transform: uppercase; }
        .header p { margin: 4px 0 0; font-size: 13px; color: #64748b; }
        .meta { margin-bottom: 15px; font-size: 13px; display: flex; justify-content: space-between; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px 10px; text-align: left; }
        th { background-color: #f1f5f9; color: #334155; font-weight: bold; text-transform: uppercase; font-size: 11px; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row { font-weight: bold; background-color: #e2e8f0; }
        .footer { margin-top: 30px; text-align: right; font-size: 12px; }
    </style>
</head>
<body>

<div class="header">
    <h2>{{ $namaSekolah }}</h2>
    <p>LAPORAN REKAPITULASI TUNGGAKAN PEMBAYARAN SISWA</p>
</div>

<div class="meta">
    <div><strong>Kelas:</strong> {{ $kelas ? $kelas : 'Semua Kelas' }}</div>
    <div><strong>Tanggal Cetak:</strong> {{ date('d F Y') }}</div>
</div>

<table>
    <thead>
        <tr>
            <th class="text-center" style="width: 30px;">#</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Kategori</th>
            <th>Jenis Tagihan</th>
            <th>Bulan / Tahun</th>
            <th class="text-right">Potongan</th>
            <th class="text-right">Total Tagihan</th>
            <th class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($tunggakan as $index => $item)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $item->student->nis ?? '-' }}</td>
            <td>{{ $item->student->name ?? '-' }}</td>
            <td>{{ $item->student->class_id ?? '-' }}</td>
            <td>{{ ucwords(str_replace('_', ' ', $item->student->beasiswa_type ?? 'reguler')) }}</td>
            <td>{{ $item->jenis_tagihan ?? $item->type ?? 'SPP' }}</td>
            <td>{{ ($item->month ? $item->month . ' ' : '') . $item->year }}</td>
            <td class="text-right">Rp {{ number_format($item->discount_amount ?? 0, 0, ',', '.') }}</td>
            <td class="text-right">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
            <td class="text-center" style="color: #b91c1c; font-weight: bold;">{{ ucfirst($item->status) }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="10" class="text-center" style="padding: 20px;">Tidak ada data tunggakan.</td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="8" class="text-right">TOTAL TUNGGAKAN:</td>
            <td class="text-right">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</td>
            <td></td>
        </tr>
    </tfoot>
</table>

<div class="footer">
    <p>Dicetak otomatis oleh Sistem Pembayaran Sekolah pada {{ date('d/m/Y H:i') }}</p>
</div>

</body>
</html>

