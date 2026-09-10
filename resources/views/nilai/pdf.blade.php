<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai {{ $student->name }} - Semester {{ $semester }} {{ $tahun }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #1a1a2e; background: white; }

        /* HEADER */
        .header { text-align: center; padding: 20px 0 16px; border-bottom: 3px solid #2563eb; margin-bottom: 20px; }
        .header-top { display: flex; align-items: center; justify-content: center; gap: 14px; margin-bottom: 8px; }
        .logo-box { width: 50px; height: 50px; background: #2563eb; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 22px; font-weight: 900; flex-shrink: 0; }
        .school-name { font-size: 18px; font-weight: 900; color: #1e3a8a; letter-spacing: -.3px; }
        .school-sub { font-size: 10px; color: #6b7280; margin-top: 2px; }
        .doc-title { font-size: 14px; font-weight: 800; color: #2563eb; margin-top: 10px; text-transform: uppercase; letter-spacing: .1em; }
        .doc-sub { font-size: 10px; color: #6b7280; margin-top: 3px; }

        /* STUDENT INFO */
        .info-box { background: #f8faff; border: 1px solid #dbeafe; border-radius: 10px; padding: 14px 18px; margin-bottom: 20px; }
        .info-row { display: flex; gap: 0; }
        .info-col { flex: 1; }
        .info-item { display: flex; margin-bottom: 6px; }
        .info-item:last-child { margin-bottom: 0; }
        .info-label { font-size: 10px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .06em; width: 110px; flex-shrink: 0; }
        .info-val { font-size: 11px; font-weight: 700; color: #111827; }

        /* STATS */
        .stats-row { display: flex; gap: 12px; margin-bottom: 20px; }
        .stat-box { flex: 1; background: white; border: 1.5px solid #e8eaf0; border-radius: 10px; padding: 12px 14px; text-align: center; }
        .stat-num { font-size: 20px; font-weight: 900; color: #2563eb; }
        .stat-lbl { font-size: 9px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: .06em; margin-top: 2px; }
        .stat-box.green .stat-num { color: #059669; }
        .stat-box.red .stat-num { color: #dc2626; }
        .stat-box.purple .stat-num { color: #7c3aed; }

        /* SECTION TITLE */
        .sec-title { font-size: 13px; font-weight: 800; color: #1e3a8a; margin-bottom: 10px; padding-bottom: 6px; border-bottom: 2px solid #e8eaf0; display: flex; align-items: center; gap: 6px; }
        .sec-badge { display: inline-block; padding: 2px 8px; border-radius: 99px; font-size: 9px; font-weight: 800; text-transform: uppercase; }
        .badge-uts { background: #f5f3ff; color: #7c3aed; }
        .badge-uas { background: #ecfeff; color: #0891b2; }

        /* TABLE */
        table { width: 100%; border-collapse: collapse; margin-bottom: 22px; }
        thead th { background: #1e3a8a; color: white; padding: 9px 12px; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; text-align: left; }
        thead th:last-child { text-align: center; }
        tbody td { padding: 9px 12px; font-size: 11px; color: #374151; border-bottom: 1px solid #f0f2f8; }
        tbody tr:nth-child(even) td { background: #fafbff; }
        tbody tr:last-child td { border-bottom: none; }
        .td-center { text-align: center; }
        .td-bold { font-weight: 800; font-size: 13px; }
        .grade { display: inline-block; padding: 2px 8px; border-radius: 99px; font-size: 10px; font-weight: 800; }
        .grade-a { background: #ecfdf5; color: #059669; }
        .grade-b { background: #eff6ff; color: #2563eb; }
        .grade-c { background: #fffbeb; color: #d97706; }
        .grade-d { background: #fef2f2; color: #dc2626; }
        .no-data { padding: 24px; text-align: center; color: #9ca3af; font-style: italic; font-size: 11px; }

        /* FOOTER */
        .footer { margin-top: 30px; border-top: 1px solid #e8eaf0; padding-top: 16px; }
        .sign-row { display: flex; justify-content: flex-end; }
        .sign-box { text-align: center; }
        .sign-place { font-size: 10px; color: #6b7280; margin-bottom: 50px; }
        .sign-name { font-size: 11px; font-weight: 800; color: #111827; border-top: 1.5px solid #374151; padding-top: 5px; min-width: 140px; }
        .sign-role { font-size: 9px; color: #6b7280; margin-top: 2px; }
        .print-note { font-size: 9px; color: #9ca3af; margin-top: 12px; text-align: center; }

        @page { margin: 20mm 18mm; }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <div class="header-top">
            <div class="logo-box">TP</div>
            <div>
                <div class="school-name">SMK TRAVINA PRIMA</div>
                <div class="school-sub">Jalan Raya Kaliabang Tengah No.10, Perwira, Bekasi Utara, RT.005/RW.008, Perwira, Kec. Bekasi Utara, Kota Bks, Jawa Barat 17125 &bull; Telp. (021) 8887-9616</div>
            </div>
        </div>
        <div class="doc-title">Laporan Nilai UTS & UAS</div>
        <div class="doc-sub">Semester {{ $semester == 1 ? 'Ganjil' : 'Genap' }} · Tahun Ajaran {{ $tahun }}/{{ $tahun + 1 }}</div>
    </div>

    {{-- STUDENT INFO --}}
    <div class="info-box">
        <div class="info-row">
            <div class="info-col">
                <div class="info-item">
                    <span class="info-label">Nama Siswa</span>
                    <span class="info-val">: {{ $student->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">NIS</span>
                    <span class="info-val">: {{ $student->nis }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Kelas</span>
                    <span class="info-val">: {{ $student->class_id }}</span>
                </div>
            </div>
            <div class="info-col">
                <div class="info-item">
                    <span class="info-label">Semester</span>
                    <span class="info-val">: {{ $semester == 1 ? '1 (Ganjil)' : '2 (Genap)' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tahun Ajaran</span>
                    <span class="info-val">: {{ $tahun }}/{{ $tahun + 1 }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Cetak</span>
                    <span class="info-val">: {{ date('d F Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- STATS --}}
    @php
        $all = $nilaiUTS->merge($nilaiUAS);
        $avg = $all->avg('nilai') ?? 0;
        $highest = $all->max('nilai') ?? 0;
        $lowest  = $all->min('nilai') ?? 0;
    @endphp
    <div class="stats-row">
        <div class="stat-box">
            <div class="stat-num">{{ number_format($avg, 1) }}</div>
            <div class="stat-lbl">Rata-rata</div>
        </div>
        <div class="stat-box green">
            <div class="stat-num">{{ number_format($highest, 1) }}</div>
            <div class="stat-lbl">Tertinggi</div>
        </div>
        <div class="stat-box red">
            <div class="stat-num">{{ number_format($lowest, 1) }}</div>
            <div class="stat-lbl">Terendah</div>
        </div>
        <div class="stat-box purple">
            <div class="stat-num">{{ $all->count() }}</div>
            <div class="stat-lbl">Total Mapel</div>
        </div>
    </div>

    {{-- NILAI UTS --}}
    <div class="sec-title">
        Nilai UTS <span class="sec-badge badge-uts">Ujian Tengah Semester</span>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width:30px;">#</th>
                <th>Mata Pelajaran</th>
                <th style="width:80px;">Nilai</th>
                <th style="width:60px;text-align:center;">Grade</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($nilaiUTS as $i => $n)
            @php
                $v = $n->nilai;
                $grade = $v >= 90 ? 'A' : ($v >= 80 ? 'B' : ($v >= 70 ? 'C' : 'D'));
                $gc    = $v >= 90 ? 'grade-a' : ($v >= 80 ? 'grade-b' : ($v >= 70 ? 'grade-c' : 'grade-d'));
            @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $n->subject->name ?? '-' }}</td>
                <td class="td-bold">{{ number_format($v, 1) }}</td>
                <td class="td-center"><span class="grade {{ $gc }}">{{ $grade }}</span></td>
                <td style="color:#6b7280;">{{ $n->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="no-data">Belum ada nilai UTS untuk semester ini.</td></tr>
            @endforelse
            @if($nilaiUTS->count() > 0)
            <tr style="background:#f0f4ff;">
                <td colspan="2" style="font-weight:800;font-size:11px;color:#1e3a8a;">Rata-rata UTS</td>
                <td class="td-bold" style="color:#2563eb;">{{ number_format($nilaiUTS->avg('nilai'), 1) }}</td>
                <td colspan="2"></td>
            </tr>
            @endif
        </tbody>
    </table>

    {{-- NILAI UAS --}}
    <div class="sec-title">
        Nilai UAS <span class="sec-badge badge-uas">Ujian Akhir Semester</span>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width:30px;">#</th>
                <th>Mata Pelajaran</th>
                <th style="width:80px;">Nilai</th>
                <th style="width:60px;text-align:center;">Grade</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($nilaiUAS as $i => $n)
            @php
                $v = $n->nilai;
                $grade = $v >= 90 ? 'A' : ($v >= 80 ? 'B' : ($v >= 70 ? 'C' : 'D'));
                $gc    = $v >= 90 ? 'grade-a' : ($v >= 80 ? 'grade-b' : ($v >= 70 ? 'grade-c' : 'grade-d'));
            @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $n->subject->name ?? '-' }}</td>
                <td class="td-bold">{{ number_format($v, 1) }}</td>
                <td class="td-center"><span class="grade {{ $gc }}">{{ $grade }}</span></td>
                <td style="color:#6b7280;">{{ $n->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="no-data">Belum ada nilai UAS untuk semester ini.</td></tr>
            @endforelse
            @if($nilaiUAS->count() > 0)
            <tr style="background:#ecfeff;">
                <td colspan="2" style="font-weight:800;font-size:11px;color:#0e7490;">Rata-rata UAS</td>
                <td class="td-bold" style="color:#0891b2;">{{ number_format($nilaiUAS->avg('nilai'), 1) }}</td>
                <td colspan="2"></td>
            </tr>
            @endif
        </tbody>
    </table>

    {{-- ABSENSI SUMMARY --}}
    @if(isset($absensiStats))
    <div class="sec-title" style="margin-top:15px;">
        Rekap Kehadiran Siswa
    </div>
    <table style="margin-bottom: 20px;">
        <thead>
            <tr>
                <th style="width:25%;">Sakit</th>
                <th style="width:25%;">Izin</th>
                <th style="width:25%;">Tanpa Keterangan (Alpha)</th>
                <th style="width:25%;">Total Hadir</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align:center;font-weight:bold;">{{ $absensiStats['sakit'] ?? 0 }} hari</td>
                <td style="text-align:center;font-weight:bold;">{{ $absensiStats['izin'] ?? 0 }} hari</td>
                <td style="text-align:center;font-weight:bold;color:#dc2626;">{{ $absensiStats['alpha'] ?? 0 }} hari</td>
                <td style="text-align:center;font-weight:bold;color:#059669;">{{ $absensiStats['hadir'] ?? 0 }} hari</td>
            </tr>
        </tbody>
    </table>
    @endif

    {{-- FOOTER --}}
    <div class="footer">
        <div class="sign-row" style="display: flex; justify-content: space-between; width: 100%;">
            <div class="sign-box" style="float: left; width: 45%;">
                <div class="sign-place">&nbsp;</div>
                <div style="height: 60px;"></div>
                <div class="sign-name">Orang Tua / Wali Murid</div>
                <div class="sign-role">Tanda Tangan</div>
            </div>
            <div class="sign-box" style="float: right; width: 45%;">
                <div class="sign-place">Bekasi, {{ date('d F Y') }}</div>
                @if(!empty($ttdImage))
                    <div style="height: 60px; text-align: center;">
                        <img src="{{ $ttdImage }}" style="max-height: 55px;" alt="TTD Digital">
                    </div>
                @else
                    <div style="height: 60px;"></div>
                @endif
                <div class="sign-name">{{ $namaKepalaSekolah ?? 'Kepala Sekolah' }}</div>
                <div class="sign-role">{{ $namaSekolah ?? 'SMK TRAVINA PRIMA' }}</div>
            </div>
            <div style="clear: both;"></div>
        </div>
        <div class="print-note" style="margin-top: 25px;">Dokumen ini dicetak secara otomatis oleh sistem Portal Akademik {{ $namaSekolah ?? 'SMK Travina Prima' }}</div>
    </div>

</body>
</html>