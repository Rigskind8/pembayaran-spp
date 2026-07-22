<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Brosur - {{ $schoolName }}</title>
    <style>
        @page { margin: 16px; }
        body {
            margin: 0;
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #0f2345;
            font-size: 10px;
            line-height: 1.35;
        }

        .sheet {
            width: 100%;
            border: 1px solid #d8e2f1;
            border-radius: 10px;
            padding: 10px;
            box-sizing: border-box;
        }

        .header {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            border: 1px solid #d8e2f1;
            border-radius: 8px;
            overflow: hidden;
        }
        .header td {
            border: 0;
            vertical-align: middle;
            padding: 8px;
        }
        .header-left {
            width: 54px;
            background: #123a6f;
            text-align: center;
        }
        .logo {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            overflow: hidden;
            margin: 0 auto;
            background: rgba(255,255,255,.15);
            color: #fff;
            line-height: 40px;
            font-size: 15px;
            font-weight: 800;
        }
        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #fff;
            display: block;
        }
        .header-right {
            background: #f7faff;
        }
        .title {
            margin: 0;
            font-size: 16px;
            color: #123a6f;
            line-height: 1.1;
        }
        .subtitle {
            margin: 3px 0 0;
            color: #5a6b87;
            font-size: 9.5px;
        }

        .meta {
            margin-top: 4px;
        }
        .badge {
            display: inline-block;
            font-size: 8.5px;
            font-weight: 700;
            color: #123a6f;
            background: #eaf2ff;
            border: 1px solid #cfe0ff;
            border-radius: 999px;
            padding: 2px 7px;
            margin: 0 4px 4px 0;
        }

        .section {
            margin-bottom: 7px;
            border: 1px solid #dfe8f5;
            border-radius: 8px;
            overflow: hidden;
        }
        .section-head {
            background: #f4f8ff;
            border-bottom: 1px solid #dfe8f5;
            padding: 5px 8px;
            font-size: 10px;
            font-weight: 700;
            color: #123a6f;
        }
        .section-body {
            padding: 7px 8px;
        }
        .section-body p {
            margin: 0;
            color: #4d607e;
            font-size: 9.5px;
        }

        table.clean {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        table.clean th,
        table.clean td {
            border: 1px solid #dfe8f5;
            padding: 5px;
            vertical-align: top;
        }
        table.clean th {
            background: #f7faff;
            color: #123a6f;
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: .03em;
        }
        table.clean td {
            color: #3f5271;
            font-size: 9px;
        }

        .flow-table th:nth-child(1),
        .flow-table td:nth-child(1) {
            width: 30%;
        }
        .flow-table th:nth-child(2),
        .flow-table td:nth-child(2) {
            width: 70%;
        }
        .flow-title {
            display: inline-block;
            vertical-align: middle;
            font-weight: 700;
        }
        .step {
            display: inline-block;
            min-width: 15px;
            height: 15px;
            line-height: 15px;
            text-align: center;
            border-radius: 999px;
            margin-right: 6px;
            vertical-align: middle;
            background: #123a6f;
            color: #fff;
            font-size: 8px;
            font-weight: 700;
        }

        .fee-table th:nth-child(1),
        .fee-table td:nth-child(1) {
            width: 27%;
        }
        .fee-table th:nth-child(2),
        .fee-table td:nth-child(2) {
            width: 22%;
            text-align: right;
            white-space: nowrap;
        }
        .fee-table th:nth-child(3),
        .fee-table td:nth-child(3) {
            width: 51%;
        }
        .fee-table td:nth-child(2) {
            font-weight: 700;
            color: #0d2e63;
            background: #fbfdff;
        }

        .two-col {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        .two-col td {
            border: 0;
            vertical-align: top;
            padding: 0;
        }
        .two-col .col-left { width: 62%; padding-right: 6px; }
        .two-col .col-right { width: 38%; padding-left: 6px; }

        .contact td {
            border: 0;
            padding: 2px 0;
            font-size: 9px;
        }
        .contact .k {
            width: 56px;
            font-weight: 700;
            color: #123a6f;
        }

        .note {
            margin-top: 5px;
            font-size: 8.8px;
            color: #657894;
        }

        .footer {
            margin-top: 4px;
            text-align: center;
            font-size: 8.5px;
            color: #6b7280;
        }
    </style>
</head>
<body>
@php
    $paymentMethods = collect($paymentMethods ?? []);
    $schoolInitial = strtoupper(substr($schoolName, 0, 1));
@endphp

<div class="sheet">
    <table class="header">
        <tr>
            <td class="header-left">
                <div class="logo">
                    @if(!empty($schoolLogoSrc))
                        <img src="{{ $schoolLogoSrc }}" alt="Logo {{ $schoolName }}">
                    @else
                        {{ $schoolInitial }}
                    @endif
                </div>
            </td>
            <td class="header-right">
                <h1 class="title">{{ $schoolName }}</h1>
                <p class="subtitle">Brosur resmi sekolah: profil singkat, alur pendaftaran, dan rincian biaya pendidikan.</p>
                <div class="meta">
                    <span class="badge">Akreditasi A</span>
                    <span class="badge">Jurusan TKR</span>
                    <span class="badge">Jurusan TKJ</span>
                    <span class="badge">Bekasi Utara</span>
                </div>
            </td>
        </tr>
    </table>

    <div class="section">
        <div class="section-head">Profil Singkat</div>
        <div class="section-body">
            <p>SMK Travina Prima menyiapkan siswa agar siap kerja, siap lanjut, dan siap bersaing melalui dua jurusan inti: Teknik Kendaraan Ringan (TKR) dan Teknik Komputer dan Jaringan (TKJ).</p>
        </div>
    </div>

    <table class="two-col">
        <tr>
            <td class="col-left">
                <div class="section">
                    <div class="section-head">Alur Pendaftaran</div>
                    <div class="section-body" style="padding:0;">
                        <table class="clean flow-table">
                            <thead>
                                <tr>
                                    <th>Tahap</th>
                                    <th>Penjelasan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="step">1</span><span class="flow-title">Konsultasi</span></td>
                                    <td>Hubungi admin untuk informasi syarat, jadwal, dan pilihan jurusan.</td>
                                </tr>
                                <tr>
                                    <td><span class="step">2</span><span class="flow-title">Pendaftaran</span></td>
                                    <td>Lengkapi formulir dan dokumen calon siswa sesuai arahan sekolah.</td>
                                </tr>
                                <tr>
                                    <td><span class="step">3</span><span class="flow-title">Pembayaran</span></td>
                                    <td>Lakukan pembayaran komponen biaya dan simpan bukti transaksi.</td>
                                </tr>
                                <tr>
                                    <td><span class="step">4</span><span class="flow-title">Verifikasi</span></td>
                                    <td>Admin memverifikasi data dan bukti pembayaran hingga status dinyatakan valid.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </td>

            <td class="col-right">
                <div class="section">
                    <div class="section-head">Kontak Sekolah</div>
                    <div class="section-body" style="padding-top:6px;">
                        <table class="contact">
                            <tr><td class="k">Alamat</td><td>: Jl. Kali Abang No. 10, Perwira, Bekasi Utara</td></tr>
                            <tr><td class="k">Telepon</td><td>: 02188880097</td></tr>
                            <tr><td class="k">Email</td><td>: travinaprima_bekasi@yahoo.com</td></tr>
                            <tr><td class="k">Website</td><td>: {{ url('/') }}</td></tr>
                        </table>
                    </div>
                </div>

                <div class="section">
                    <div class="section-head">Metode Pembayaran Aktif</div>
                    <div class="section-body">
                        @forelse($paymentMethods->take(5) as $method)
                            <span class="badge">{{ $method->name }}{{ $method->bank ? ' - ' . $method->bank : '' }}</span>
                        @empty
                            <span class="badge">Tunai</span>
                            <span class="badge">Transfer Bank</span>
                            <span class="badge">QRIS</span>
                        @endforelse
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div class="section" style="margin-top: 6px;">
        <div class="section-head">Rincian Biaya Pendidikan</div>
        <div class="section-body" style="padding:0;">
            <table class="clean fee-table">
                <thead>
                    <tr>
                        <th>Komponen</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sewa Gedung</td>
                        <td>Rp 1.500.000</td>
                        <td>Dibayarkan sekali pada saat daftar ulang siswa baru.</td>
                    </tr>
                    <tr>
                        <td>SPP Bulanan</td>
                        <td>Rp 250.000</td>
                        <td>Pembayaran rutin setiap bulan selama tahun ajaran berjalan.</td>
                    </tr>
                    <tr>
                        <td>Seragam</td>
                        <td>Rp 850.000</td>
                        <td>Biaya paket seragam sekolah sesuai ketentuan lembaga.</td>
                    </tr>
                    <tr>
                        <td>Ulangan/Ujian</td>
                        <td>Rp 300.000</td>
                        <td>Biaya evaluasi belajar untuk kebutuhan ulangan dan ujian semester.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="note">Catatan: nominal biaya di atas merupakan acuan informasi dan dapat menyesuaikan kebijakan sekolah pada tahun ajaran berjalan.</div>
    <div class="footer">Brosur {{ date('Y') }} {{ $schoolName }} - Satu halaman ringkas untuk informasi pendaftaran.</div>
</div>
</body>
</html>
