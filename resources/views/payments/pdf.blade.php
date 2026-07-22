<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pembayaran - {{ $student->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 13px; color: #333; padding: 30px; }

        .header { text-align: center; margin-bottom: 25px; padding-bottom: 12px; }
        .header .sekolah { font-size: 22px; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; color: #1a1a2e; }
        .header .alamat { font-size: 11px; color: #666; margin: 3px 0 8px; }
        .header .garis-tebal { width: 100%; height: 3px; background: #2c3e50; }
        .header .garis-tipis { width: 100%; height: 1px; background: #2c3e50; margin-top: 2px; margin-bottom: 8px; }
        .header .judul { font-size: 15px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; margin-top: 8px; }
        .header .waktu { font-size: 11px; color: #666; margin-top: 4px; }

        .info-box { margin-bottom: 20px; border: 1px solid #ddd; padding: 10px 14px; border-radius: 4px; background: #f9f9f9; }
        .info-box table { width: 100%; }
        .info-box td { padding: 3px 8px; font-size: 13px; }
        .info-box td:first-child { width: 140px; font-weight: bold; }

        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th { background: #2c3e50; color: white; padding: 8px 10px; text-align: left; font-size: 12px; }
        table.data td { padding: 7px 10px; border-bottom: 1px solid #e0e0e0; font-size: 12px; }
        table.data tr:nth-child(even) { background: #f8f9fa; }

        .badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: bold; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-danger  { background: #f8d7da; color: #721c24; }

        .total-box { margin-top: 20px; text-align: right; }
        .total-box table { display: inline-table; border: 1px solid #ddd; border-radius: 4px; overflow: hidden; }
        .total-box td { padding: 7px 16px; }
        .total-box .label { font-weight: bold; background: #f0f0f0; }
        .total-box .value { font-weight: bold; color: #2c3e50; }

        .ttd-section { margin-top: 50px; display: flex; justify-content: flex-end; }
        .ttd-box { text-align: center; font-size: 12px; width: 220px; }
        .ttd-box img { width: 180px; height: 80px; object-fit: contain; display: block; margin: 0 auto 4px; }
        .ttd-box .ttd-kosong { width: 180px; height: 80px; display: block; margin: 0 auto 4px; }
        .ttd-line { border-top: 1px solid #333; padding-top: 4px; margin-top: 4px; }

        .footer { margin-top: 30px; font-size: 11px; color: #999; text-align: center; border-top: 1px solid #ddd; padding-top: 10px; }

        @media print {
            .no-print { display: none !important; }
            body { padding: 10px; }
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <div class="sekolah">{{ $namaSekolah }}</div>
        <div class="alamat">Jalan Raya Kaliabang Tengah No.10, Perwira, Bekasi Utara, RT.005/RW.008, Perwira, Kec. Bekasi Utara, Kota Bks, Jawa Barat 17125 &bull; Telp. (021) 8887-9616</div>
        <div class="garis-tebal"></div>
        <div class="garis-tipis"></div>
        <div class="judul">Bukti Riwayat Pembayaran</div>
        <div class="waktu">Dicetak pada <span id="waktu-cetak"></span> WIB</div>
    </div>

    {{-- INFO SISWA --}}
    <div class="info-box">
        <table>
            <tr>
                <td>Nama Siswa</td>
                <td>: <strong>{{ $student->name }}</strong></td>
            </tr>
            <tr>
                <td>Email</td>
                <td>: {{ $student->email }}</td>
            </tr>
            @if(isset($student->nis))
            <tr><td>NIS</td><td>: {{ $student->nis }}</td></tr>
            @endif
            @if(isset($student->kelas))
            <tr><td>Kelas</td><td>: {{ $student->kelas }}</td></tr>
            @endif
        </table>
    </div>

    {{-- TABEL DATA --}}
    @if($payments->isEmpty())
        <p style="text-align:center; color:#999; margin-top:40px;">Belum ada data pembayaran yang lunas.</p>
    @else
        <table class="data">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Jenis</th>
                    <th>Keterangan</th>
                    <th>Bulan / Tahun</th>
                    <th>Metode</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->jenis_tagihan ?? $p->type ?? '-' }}</td>
                    <td>{{ $p->keterangan ?? '-' }}</td>
                    <td>{{ $p->month }} / {{ $p->year }}</td>
                    <td>{{ $p->payment_method ?? '-' }}</td>
                    <td>Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                    <td>
                        @if(in_array($p->status, ['approved','paid']))
                            <span class="badge badge-success">Lunas</span>
                        @elseif($p->status === 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @else
                            <span class="badge badge-danger">{{ $p->status }}</span>
                        @endif
                    </td>
                    <td>{{ $p->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-box">
            <table>
                <tr>
                    <td class="label">Total Pembayaran</td>
                    <td class="value">Rp {{ number_format($payments->sum('amount'), 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    @endif

    {{-- TANDA TANGAN --}}
    <div class="ttd-section">
        <div class="ttd-box">
            <div>Mengetahui,</div>
            <div>{{ $namaSekolah }}</div>
            <img src="{{ $ttdImage ?? asset('ttd.png') }}" alt="TTD Kepala Sekolah">
            <div class="ttd-line">( {{ $namaKepalaSekolah }} )</div>
        </div>
    </div>

    {{-- TOMBOL PRINT --}}
    <div class="no-print" style="text-align:center; margin-top:30px;">
        <button onclick="window.print()" style="padding:8px 24px; background:#2c3e50; color:white; border:none; border-radius:4px; cursor:pointer; font-size:14px;">
            🖨️ Print / Save PDF
        </button>
        <a href="{{ route('siswa.pembayaran') }}" style="margin-left:12px; font-size:13px; color:#666;">← Kembali</a>
    </div>

    <div class="footer">
        Dokumen ini digenerate otomatis oleh sistem &bull; {{ $namaSekolah }} &bull; Harap simpan sebagai bukti pembayaran.
    </div>

<script>
function updateWaktu() {
    const now = new Date();
    const bulan = ['Januari','Februari','Maret','April','Mei','Juni',
                   'Juli','Agustus','September','Oktober','November','Desember'];
    const tgl = now.getDate(), bln = bulan[now.getMonth()], thn = now.getFullYear();
    const jam = String(now.getHours()).padStart(2,'0');
    const mnt = String(now.getMinutes()).padStart(2,'0');
    const dtk = String(now.getSeconds()).padStart(2,'0');
    document.getElementById('waktu-cetak').textContent =
        tgl + ' ' + bln + ' ' + thn + ', ' + jam + ':' + mnt + ':' + dtk;
}
updateWaktu();
setInterval(updateWaktu, 1000);
</script>
</body>
</html>