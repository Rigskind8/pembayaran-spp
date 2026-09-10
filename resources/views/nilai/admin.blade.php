@extends('layouts.app')

@section('title', 'Manage Nilai - SMK TRAVINA PRIMA')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
        --sb: 64px; --sb-open: 220px;
        --bg: #f4f6fa; --card: #fff; --border: #e8eaf0;
        --txt: #111827; --txt2: #6b7280; --txt3: #9ca3af;
        --blue: #2563eb; --blue-bg: #eff6ff;
        --green: #059669; --green-bg: #ecfdf5;
        --red: #dc2626; --red-bg: #fef2f2;
        --amber: #d97706; --amber-bg: #fffbeb;
        --purple: #7c3aed; --purple-bg: #f5f3ff;
        --sb-bg: #0f1117;
        --r: 16px;
        --shadow: 0 1px 3px rgba(0,0,0,.06), 0 2px 8px rgba(0,0,0,.04);
    }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--txt); -webkit-font-smoothing: antialiased; }
    .app { display: flex; min-height: 100vh; }
    .main { margin-left: var(--sb); flex: 1; display: flex; flex-direction: column; }

    .sb { width: var(--sb); background: var(--sb-bg); position: fixed; top: 0; left: 0; height: 100vh; z-index: 200; display: flex; flex-direction: column; align-items: center; padding: 16px 0 20px; transition: width .28s cubic-bezier(.4,0,.2,1); overflow: hidden; border-right: 1px solid #1a1d27; }
    .sb:hover { width: var(--sb-open); align-items: flex-start; }
    .sb-brand { display: flex; align-items: center; gap: 10px; padding: 4px 14px; width: 100%; min-height: 44px; margin-bottom: 20px; }
    .sb-mark { width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0; background: var(--blue); display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; }
    .sb-name { font-size: 13px; font-weight: 700; color: white; white-space: nowrap; opacity: 0; transition: opacity .2s; }
    .sb:hover .sb-name { opacity: 1; }
    .sb-nav { width: 100%; padding: 0 10px; flex: 1; display: flex; flex-direction: column; gap: 2px; }
    .sb-grp { font-size: 11px; font-weight: 800; letter-spacing: .1em; color: #eef4ff; text-transform: uppercase; padding: 12px 8px 4px; white-space: nowrap; opacity: 0; transition: opacity .2s; text-shadow: 0 1px 1px rgba(0,0,0,.35); }
    .sb:hover .sb-grp { opacity: 1; }
    .sb-a { display: flex; align-items: center; gap: 10px; padding: 8px 9px; border-radius: 10px; color: #6b7280; font-size: 13px; font-weight: 500; text-decoration: none; white-space: nowrap; transition: all .15s; }
    .sb-a .ic { width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 13px; color: #4b5163; transition: all .15s; }
    .sb-a:hover { color: #d1d5db; }
    .sb-a:hover .ic { background: #1c1f2e; color: #9ca3af; }
    .sb-a.on { color: white; }
    .sb-a.on .ic { background: var(--blue); color: white; box-shadow: 0 4px 10px rgba(37,99,235,.3); }
    .sb-lbl { opacity: 0; transition: opacity .18s; pointer-events: none; white-space: nowrap; }
    .sb:hover .sb-lbl { opacity: 1; pointer-events: auto; }
    .sb-foot { width: 100%; padding: 0 10px; margin-top: auto; border-top: 1px solid #1a1d27; padding-top: 14px; }
    .sb-user { display: flex; align-items: center; gap: 9px; padding: 9px; border-radius: 10px; background: rgba(255,255,255,.04); margin-bottom: 6px; }
    .sb-av { width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0; background: var(--blue); color: white; font-weight: 800; font-size: 14px; display: flex; align-items: center; justify-content: center; }
    .sb-uname { font-size: 12px; font-weight: 700; color: #f1f5f9; white-space: nowrap; }

    .topbar { display: flex; align-items: center; justify-content: space-between; padding: 10px 28px; background: rgba(244,246,250,.95); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; }
    .top-title { font-size: 18px; font-weight: 800; color: var(--txt); letter-spacing: -.3px; }
    .top-sub { font-size: 12px; color: var(--txt2); margin-top: 1px; }

    .modal-bg { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
    .modal-bg.show { display: flex; }
    .modal { background: white; border-radius: 20px; padding: 28px; width: 100%; max-width: 460px; box-shadow: 0 20px 60px rgba(0,0,0,.15); }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 11px; font-weight: 800; color: var(--txt2); margin-bottom: 6px; text-transform: uppercase; letter-spacing: .05em; }
    .form-control { width: 100%; border: 1.5px solid var(--border); border-radius: 10px; padding: 10px 14px; font-size: 13px; font-weight: 600; font-family: inherit; outline: none; transition: border-color .15s; }
    .form-control:focus { border-color: var(--blue); }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; border: none; font-family: inherit; transition: all .15s; text-decoration: none; }
    .btn-blue { background: var(--blue); color: white; }
    .btn-outline { background: white; color: var(--txt2); border: 1px solid var(--border); }

    .table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .table th { padding: 10px 14px; text-align: left; font-size: 11px; font-weight: 800; color: var(--txt2); text-transform: uppercase; border-bottom: 2px solid var(--border); }
    .table td { padding: 12px 14px; border-bottom: 1px solid var(--border); }
    .table tr:last-child td { border-bottom: none; }
    .badge { padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
    .badge-uts { background: var(--blue-bg); color: var(--blue); }
    .badge-uas { background: var(--purple-bg); color: var(--purple); }

    .nilai-list-wrap {
        padding: 16px 24px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .nilai-class-block {
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
    }
    .nilai-class-head {
        padding: 12px 16px;
        border-bottom: 1px solid var(--border);
        background: #fafbff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .nilai-class-table-wrap {
        width: 100%;
        overflow-x: auto;
    }
    .nilai-class-table {
        min-width: 960px;
        table-layout: fixed;
    }
    .nilai-class-table thead th {
        padding-top: 11px;
        padding-bottom: 11px;
    }
    .nilai-class-table tbody td {
        padding-top: 11px;
        padding-bottom: 11px;
    }
    .nilai-class-table th,
    .nilai-class-table td {
        vertical-align: middle;
    }
    .nilai-col-no { width: 52px; }
    .nilai-col-type { width: 88px; }
    .nilai-col-score { width: 88px; }
    .nilai-col-action { width: 76px; }
    .nilai-history {
        font-size: 11px;
        color: var(--txt2);
        line-height: 1.45;
        white-space: normal;
        min-width: 190px;
    }
    .nilai-cell-student,
    .nilai-cell-subject,
    .nilai-cell-note {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .nilai-list-wrap .nilai-class-block {
        margin: 0;
    }
    .nilai-list-wrap .nilai-class-block:first-child {
        margin-top: 0;
    }
    .nilai-list-wrap .nilai-class-block:last-child {
        margin-bottom: 0;
    }
</style>

<div class="app">
    @include('partials.sidebar')

    <div class="main">
        <header class="topbar" style="justify-content: flex-end;">
            <button class="btn btn-blue" onclick="openModal()"><i class="fas fa-plus"></i> Input Nilai</button>
        </header>

        <div style="padding: 18px 28px 28px;">
            @if($errors->any())
                <div style="background: var(--red-bg); color: var(--red); padding: 12px 16px; border: 1px solid rgba(220,38,38,.22); border-radius: 10px; margin-bottom: 20px; font-size: 13px;">
                    <div style="font-weight:700; margin-bottom:6px;"><i class="fas fa-triangle-exclamation"></i> Input belum berhasil:</div>
                    <ul style="margin:0 0 0 18px; padding:0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div style="background: var(--green-bg); color: var(--green); padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-weight: 600; font-size: 13px;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: var(--red-bg); color: var(--red); padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-weight: 600; font-size: 13px;">
                    <i class="fas fa-triangle-exclamation"></i> {{ session('error') }}
                </div>
            @endif

            <div style="background: white; border-radius: var(--r); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; margin-bottom: 20px;">
                <div style="padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <h3 style="font-size: 16px; font-weight: 800;">Input Nilai Cepat per Kelas</h3>
                    <span style="font-size: 12px; color: var(--txt2);">Pilih kelas + mapel, lalu isi nilai sekaligus</span>
                </div>

                <div style="padding: 18px 24px; border-bottom: 1px solid var(--border);">
                    <form method="GET" style="display:flex; gap:10px; flex-wrap: wrap; align-items: center;">
                        @php $quickType = in_array($type, ['uts', 'uas'], true) ? $type : 'uts'; @endphp
                        <select name="type" class="form-control" style="width: 140px;" required>
                            <option value="uts" {{ $quickType === 'uts' ? 'selected' : '' }}>Input UTS</option>
                            <option value="uas" {{ $quickType === 'uas' ? 'selected' : '' }}>Input UAS</option>
                        </select>
                        <select name="semester" class="form-control" style="width: 140px;" required>
                            <option value="1" {{ (string)$semester === '1' ? 'selected' : '' }}>Semester 1</option>
                            <option value="2" {{ (string)$semester === '2' ? 'selected' : '' }}>Semester 2</option>
                        </select>
                        <input type="hidden" name="tahun" value="{{ $tahun }}">
                        <input type="hidden" name="student_id" value="{{ $studentId ?? '' }}">

                        <select name="class_id" class="form-control" style="width: 180px;" required>
                            <option value="">Pilih Kelas</option>
                            @foreach($classOptions as $classItem)
                                <option value="{{ $classItem }}" {{ (string)($selectedClassId ?? '') === (string)$classItem ? 'selected' : '' }}>{{ $classItem }}</option>
                            @endforeach
                        </select>

                        <select name="subject_id" class="form-control" style="min-width: 220px;" required>
                            <option value="">Pilih Mapel</option>
                            @foreach($subjects as $sub)
                                @php $isSameClass = !$selectedClassId || (string)$sub->class_id === (string)$selectedClassId; @endphp
                                @if($isSameClass)
                                    <option value="{{ $sub->id }}" {{ (string)($selectedSubjectId ?? '') === (string)$sub->id ? 'selected' : '' }}>
                                        {{ $sub->name }} ({{ $sub->class_id ?? '-' }})
                                    </option>
                                @endif
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-outline"><i class="fas fa-arrows-rotate"></i> Muat Siswa</button>
                    </form>
                </div>

                @if(($bulkStudents ?? collect())->count() > 0 && ($selectedClassId ?? null) && ($selectedSubjectId ?? null))
                    <form action="{{ route('nilai.bulk') }}" method="POST" style="padding: 18px 24px;">
                        @csrf
                        <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
                        <input type="hidden" name="subject_id" value="{{ $selectedSubjectId }}">
                        <input type="hidden" name="type" value="{{ $quickType }}">
                        <input type="hidden" name="semester" value="{{ $semester }}">
                        <input type="hidden" name="tahun" value="{{ $tahun }}">

                        <div style="overflow:auto; border:1px solid var(--border); border-radius: 10px;">
                            <table class="table" style="margin:0; min-width: 760px;">
                                <thead>
                                    <tr>
                                        <th style="width: 48px;">#</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th style="width: 130px;">Nilai</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bulkStudents as $idx => $s)
                                        <tr>
                                            <td>{{ $idx + 1 }}</td>
                                            <td style="font-weight: 700;">{{ $s->name }}</td>
                                            <td>{{ $s->class_id }}</td>
                                            <td>
                                                <input type="hidden" name="student_ids[]" value="{{ $s->id }}">
                                                <input type="number" name="nilai[{{ $s->id }}]" min="0" max="100" step="0.01" class="form-control" placeholder="0-100" style="padding:8px 10px; font-size:12px;">
                                            </td>
                                            <td>
                                                <input type="text" name="keterangan[{{ $s->id }}]" class="form-control" placeholder="Opsional" style="padding:8px 10px; font-size:12px;">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div style="display:flex; justify-content: flex-end; margin-top: 12px;">
                            <button type="submit" class="btn btn-blue"><i class="fas fa-floppy-disk"></i> Simpan Nilai Massal</button>
                        </div>
                    </form>
                @elseif(($selectedClassId ?? null) && ($selectedSubjectId ?? null))
                    <div style="padding: 18px 24px; color: var(--txt2); font-size: 13px;">
                        Tidak ada siswa untuk kombinasi kelas dan mapel ini.
                    </div>
                @else
                    <div style="padding: 18px 24px; color: var(--txt2); font-size: 13px;">
                        Pilih kelas dan mapel dulu untuk memulai input nilai cepat.
                    </div>
                @endif
            </div>

            <div style="background: white; border-radius: var(--r); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden;">
                <div style="padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 16px; font-weight: 800;">Daftar Nilai Akademik</h3>
                    <span style="font-size: 12px; color: var(--txt2);">{{ $nilais->count() }} data</span>
                </div>

                <form method="GET" style="display: flex; gap: 10px; margin: 16px 24px 18px; flex-wrap: wrap;">
                    <select name="type" class="form-control" style="width: auto;">
                        <option value="all" {{ $type == 'all' ? 'selected' : '' }}>Semua Tipe</option>
                        <option value="uts" {{ $type == 'uts' ? 'selected' : '' }}>UTS</option>
                        <option value="uas" {{ $type == 'uas' ? 'selected' : '' }}>UAS</option>
                    </select>
                    <select name="student_id" class="form-control" style="width: 220px;">
                        <option value="">Semua Siswa</option>
                        @foreach($students as $s)
                            <option value="{{ $s->id }}" {{ (string)($studentId ?? '') === (string)$s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                    <select name="semester" class="form-control" style="width: auto;">
                        <option value="1" {{ $semester == 1 ? 'selected' : '' }}>Semester 1</option>
                        <option value="2" {{ $semester == 2 ? 'selected' : '' }}>Semester 2</option>
                    </select>
                    <input type="number" name="tahun" value="{{ $tahun }}" class="form-control" style="width: 100px;">
                    <button type="submit" class="btn btn-blue"><i class="fas fa-filter"></i> Filter</button>
                    @if($studentId)
                        <a href="{{ route('nilai.exportPdf', ['student_id' => $studentId, 'semester' => $semester, 'tahun' => $tahun]) }}" class="btn" style="background:#ecfdf5;color:#059669;border:1px solid #a7f3d0;">
                            <i class="fas fa-file-pdf"></i> Cetak Raport Digital PDF
                        </a>
                    @endif
                </form>

                @if($nilais->count() > 0)
                @php
                    $groupedNilais = $nilais->groupBy(fn($item) => $item->student->class_id ?? 'Tanpa Kelas');
                @endphp

                <div class="nilai-list-wrap">
                    @foreach($groupedNilais as $className => $classNilais)
                        <div class="nilai-class-block">
                            <div class="nilai-class-head">
                                <div style="font-size: 13px; font-weight: 800; color: var(--txt);">
                                    Kelas {{ $className }}
                                </div>
                                <div style="font-size: 12px; color: var(--txt2);">
                                    {{ $classNilais->count() }} data nilai
                                </div>
                            </div>

                            <div class="nilai-class-table-wrap">
                                <table class="table nilai-class-table">
                                    <colgroup>
                                        <col style="width: 56px;">
                                        <col style="width: 190px;">
                                        <col style="width: 190px;">
                                        <col style="width: 90px;">
                                        <col style="width: 100px;">
                                        <col style="width: 170px;">
                                        <col style="width: 230px;">
                                        <col style="width: 128px;">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th class="nilai-col-no">#</th>
                                            <th>Siswa</th>
                                            <th>Mata Pelajaran</th>
                                            <th class="nilai-col-type">Tipe</th>
                                            <th class="nilai-col-score">Nilai</th>
                                            <th>Keterangan</th>
                                            <th>Riwayat Input</th>
                                            <th class="nilai-col-action">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($classNilais->values() as $i => $n)
                                        <tr>
                                            <td style="color: var(--txt2);">{{ $i + 1 }}</td>
                                            <td class="nilai-cell-student" style="font-weight: 700;">{{ $n->student->name ?? '-' }}</td>
                                            <td class="nilai-cell-subject">{{ $n->subject->name ?? '-' }}</td>
                                            <td><span class="badge badge-{{ $n->type }}">{{ strtoupper($n->type) }}</span></td>
                                            <td style="font-weight: 800; font-size: 15px;">{{ $n->nilai }}</td>
                                            <td class="nilai-cell-note" style="color: var(--txt2);">{{ $n->keterangan ?? '-' }}</td>
                                            <td class="nilai-history">
                                                <div>Dibuat: {{ $n->created_at?->format('d M Y H:i') ?? '-' }}</div>
                                                <div>Diubah: {{ $n->updated_at?->format('d M Y H:i') ?? '-' }}</div>
                                            </td>
                                            <td>
                                                <div style="display:flex; align-items:center; gap:6px;">
                                                    <button
                                                        type="button"
                                                        onclick="openEditNilai(this)"
                                                        data-id="{{ $n->id }}"
                                                        data-nilai="{{ $n->nilai }}"
                                                        data-keterangan="{{ $n->keterangan ?? '' }}"
                                                        style="background: var(--amber-bg); color: var(--amber); border: none; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer;"
                                                        title="Edit nilai"
                                                    >
                                                        <i class="fas fa-pen"></i>
                                                    </button>
                                                    <form action="{{ route('nilai.destroy', $n->id) }}" method="POST" onsubmit="return confirm('Hapus nilai ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" style="background: var(--red-bg); color: var(--red); border: none; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer;" title="Hapus nilai">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                <div style="padding: 40px; text-align: center; color: var(--txt2);">
                    <i class="fas fa-inbox" style="font-size: 32px; margin-bottom: 10px; display: block; opacity: .3;"></i>
                    Belum ada data nilai. Klik "Input Nilai" untuk menambahkan.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal-bg" id="modalBg">
    <div class="modal">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
            <div style="width: 36px; height: 36px; background: var(--blue-bg); color: var(--blue); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-plus-circle"></i>
            </div>
            <h3 style="font-size: 18px; font-weight: 800;">Input Nilai</h3>
        </div>

        <form action="{{ route('nilai.store') }}" method="POST">
            @csrf
            <input type="hidden" name="form_source" value="create">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label>Siswa</label>
                    <select name="student_id" class="form-control" required>
                        <option value="">Pilih Siswa</option>
                        @foreach($students as $s)
                            <option value="{{ $s->id }}" {{ (string) old('student_id') === (string) $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Mata Pelajaran</label>
                    <select name="subject_id" class="form-control" required>
                        <option value="">Pilih Mapel</option>
                        @foreach($subjects as $sub)
                            <option value="{{ $sub->id }}" {{ (string) old('subject_id') === (string) $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label>Tipe Ujian</label>
                    <select name="type" class="form-control" required>
                        <option value="uts" {{ old('type', 'uts') === 'uts' ? 'selected' : '' }}>UTS</option>
                        <option value="uas" {{ old('type') === 'uas' ? 'selected' : '' }}>UAS</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nilai (0-100)</label>
                    <input type="number" name="nilai" class="form-control" placeholder="90" min="0" max="100" value="{{ old('nilai') }}" required>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label>Semester</label>
                    <select name="semester" class="form-control" required>
                        <option value="1" {{ (string) old('semester', '1') === '1' ? 'selected' : '' }}>Semester 1</option>
                        <option value="2" {{ (string) old('semester') === '2' ? 'selected' : '' }}>Semester 2</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="{{ old('tahun', date('Y')) }}" required>
                </div>
            </div>
            <div class="form-group">
                <label>Keterangan (Opsional)</label>
                <input type="text" name="keterangan" class="form-control" placeholder="Lulus, Remedial, dll" value="{{ old('keterangan') }}">
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 10px;">
                <button type="button" class="btn btn-outline" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn btn-blue"><i class="fas fa-save"></i> Simpan Nilai</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-bg" id="editModalBg">
    <div class="modal">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
            <div style="width: 36px; height: 36px; background: var(--amber-bg); color: var(--amber); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-pen"></i>
            </div>
            <h3 style="font-size: 18px; font-weight: 800;">Edit Nilai</h3>
        </div>

        <form id="editNilaiForm" action="#" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="form_source" value="edit">
            <input type="hidden" name="nilai_id" id="edit_nilai_id" value="">

            <div class="form-group">
                <label>Nilai (0-100)</label>
                <input type="number" name="nilai" id="edit_nilai" class="form-control" min="0" max="100" step="0.01" required>
            </div>

            <div class="form-group">
                <label>Keterangan (Opsional)</label>
                <input type="text" name="keterangan" id="edit_keterangan" class="form-control" placeholder="Lulus, Remedial, dll">
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 10px;">
                <button type="button" class="btn btn-outline" onclick="closeEditNilai()">Batal</button>
                <button type="submit" class="btn btn-blue"><i class="fas fa-save"></i> Update Nilai</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() { document.getElementById('modalBg').classList.add('show'); }
    function closeModal() { document.getElementById('modalBg').classList.remove('show'); }

    const editRouteTemplate = @json(route('nilai.update', ['nilai' => '__ID__']));

    function openEditNilai(button) {
        const id = button.getAttribute('data-id');
        const nilai = button.getAttribute('data-nilai') || '';
        const keterangan = button.getAttribute('data-keterangan') || '';

        document.getElementById('edit_nilai_id').value = id;
        document.getElementById('edit_nilai').value = nilai;
        document.getElementById('edit_keterangan').value = keterangan;
        document.getElementById('editNilaiForm').action = editRouteTemplate.replace('__ID__', id);
        document.getElementById('editModalBg').classList.add('show');
    }

    function openEditNilaiWithValues(id, nilai, keterangan) {
        document.getElementById('edit_nilai_id').value = id || '';
        document.getElementById('edit_nilai').value = nilai || '';
        document.getElementById('edit_keterangan').value = keterangan || '';
        if (id) {
            document.getElementById('editNilaiForm').action = editRouteTemplate.replace('__ID__', id);
        }
        document.getElementById('editModalBg').classList.add('show');
    }

    function closeEditNilai() {
        document.getElementById('editModalBg').classList.remove('show');
    }

    document.getElementById('editModalBg')?.addEventListener('click', function (e) {
        if (e.target === this) closeEditNilai();
    });

    @if($errors->any())
    window.addEventListener('load', function () {
        @if(old('form_source') === 'edit')
            openEditNilaiWithValues(
                @json(old('nilai_id')),
                @json(old('nilai')),
                @json(old('keterangan'))
            );
        @else
            openModal();
        @endif
    });
    @endif
</script>
@endsection
