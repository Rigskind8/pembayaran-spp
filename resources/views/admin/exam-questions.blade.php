@extends('layouts.app')

@section('content')
<style>
    .exam-shell{min-height:100vh;background:linear-gradient(180deg,#f8fbff 0%,#f3f7fc 100%);} 
    .hero{background:linear-gradient(135deg,#0f172a 0%,#1d4ed8 55%,#2563eb 100%);border-radius:24px;color:#fff;padding:24px 28px;box-shadow:0 18px 45px rgba(15,23,42,.14);display:flex;justify-content:space-between;gap:18px;align-items:center;}
    .hero h1{font-size:26px;font-weight:900;letter-spacing:-.03em;}
    .hero p{font-size:13px;color:rgba(255,255,255,.75);margin-top:6px;line-height:1.7;}
    .hero-actions{display:flex;gap:10px;flex-wrap:wrap;}
    .btn{display:inline-flex;align-items:center;gap:8px;padding:11px 16px;border-radius:14px;text-decoration:none;font-weight:800;border:none;cursor:pointer;}
    .btn-primary{background:#fff;color:#1d4ed8;}
    .btn-secondary{background:rgba(255,255,255,.12);color:#fff;border:1px solid rgba(255,255,255,.18);}
    .grid{display:grid;grid-template-columns:360px 1fr;gap:18px;margin-top:18px;}
    .card{background:#fff;border:1px solid #e2e8f0;border-radius:22px;box-shadow:0 14px 28px rgba(15,23,42,.06);overflow:hidden;}
    .card-head{padding:18px 20px;border-bottom:1px solid #e2e8f0;background:#fafbff;}
    .card-title{font-size:15px;font-weight:900;color:#0f172a;}
    .card-sub{font-size:12px;color:#64748b;margin-top:4px;}
    .card-body{padding:18px 20px;}
    .field{margin-bottom:14px;}
    .label{display:block;font-size:11px;font-weight:800;color:#475569;margin-bottom:6px;text-transform:uppercase;letter-spacing:.06em;}
    .input,.select,.textarea{width:100%;padding:11px 12px;border-radius:12px;border:1px solid #cbd5e1;font:inherit;color:#0f172a;background:#fff;}
    .textarea{min-height:120px;resize:vertical;}
    .input:focus,.select:focus,.textarea:focus{outline:none;border-color:#2563eb;box-shadow:0 0 0 4px rgba(37,99,235,.12);}
    .row{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;}
    .table-wrap{overflow:auto;}
    table{width:100%;border-collapse:collapse;}
    thead th{font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:#64748b;padding:12px 16px;text-align:left;background:#f8fafc;border-bottom:1px solid #e2e8f0;}
    tbody td{padding:14px 16px;border-bottom:1px solid #eef2f7;font-size:13px;vertical-align:top;}
    tbody tr:hover td{background:#fafbff;}
    .badge{display:inline-flex;align-items:center;padding:5px 10px;border-radius:999px;font-size:11px;font-weight:800;}
    .badge-blue{background:#eff6ff;color:#2563eb;}
    .badge-green{background:#ecfdf5;color:#059669;}
    .badge-amber{background:#fffbeb;color:#d97706;}
    .badge-red{background:#fef2f2;color:#dc2626;}
    .action{display:inline-flex;align-items:center;gap:6px;padding:8px 10px;border-radius:10px;border:1px solid transparent;font-size:12px;font-weight:800;cursor:pointer;text-decoration:none;}
    .action-edit{background:#eff6ff;color:#1d4ed8;border-color:#bfdbfe;}
    .action-delete{background:#fef2f2;color:#b91c1c;border-color:#fecaca;}
    .table-head{display:flex;align-items:flex-start;justify-content:space-between;gap:14px;flex-wrap:wrap;}
    .pagination-wrap{margin-top:16px;padding-top:14px;border-top:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;color:#64748b;font-size:12px;font-weight:600;}
    .pagination-wrap .pagination{margin:0;flex-wrap:wrap;gap:.35rem;}
    .pagination-wrap .page-item{margin:0;}
    .pagination-wrap .page-link{min-width:40px;padding:8px 12px;border-radius:12px!important;border:1px solid rgba(148,163,184,.35);color:#0f172a;background:#fff;}
    .modal-overlay{position:fixed;inset:0;background:rgba(15,23,42,.56);display:none;align-items:center;justify-content:center;padding:22px;z-index:60;}
    .modal-overlay.open{display:flex;}
    .modal-panel{width:min(860px,100%);max-height:90vh;overflow:auto;background:#fff;border-radius:24px;box-shadow:0 28px 70px rgba(15,23,42,.22);}
    .modal-hd{display:flex;align-items:flex-start;justify-content:space-between;gap:14px;padding:20px 22px 0;}
    .modal-close{width:38px;height:38px;border-radius:999px;border:none;background:#f1f5f9;cursor:pointer;}
    .modal-body{padding:18px 22px 22px;}
    .modal-ft{padding:0 22px 22px;display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap;}
    .alert{padding:14px 16px;border-radius:16px;font-weight:700;margin-top:14px;}
    .alert.success{background:#ecfdf5;border:1px solid #bbf7d0;color:#166534;}
    .alert.error{background:#fef2f2;border:1px solid #fecaca;color:#991b1b;}
    @media(max-width:960px){.grid{grid-template-columns:1fr;}.hero{flex-direction:column;align-items:flex-start;}}
</style>

<div class="exam-shell">
    <div class="app">
        @include('partials.sidebar')
        <div class="main">
            <div class="page">
                <div class="hero">
                    <div>
                        <h1>Bank Soal Ujian</h1>
                        <p>Kelola soal UTS/UAS sesuai mapel. Soal ini akan tampil pada halaman ujian siswa setelah pembayaran verified.</p>
                    </div>
                    <div class="hero-actions">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Dashboard</a>
                        <a href="{{ route('manage.ujian') }}" class="btn btn-primary"><i class="fas fa-file-pen"></i> Manajemen Ujian</a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert error">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="grid">
                    <div class="card">
                        <div class="card-head">
                            <div class="card-title">Tambah Soal</div>
                            <div class="card-sub">Buat soal per mapel, tipe ujian, dan jawaban benar.</div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('exam-questions.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="field">
                                        <label class="label">Mapel</label>
                                        <select name="subject_id" class="select" required>
                                            <option value="">-- Pilih --</option>
                                            @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ $subject->name }}{{ $subject->class_id ? ' ('.$subject->class_id.')' : '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="field">
                                        <label class="label">Tipe</label>
                                        <select name="type" class="select" required>
                                            <option value="uts" {{ $jenis === 'uts' ? 'selected' : '' }}>UTS</option>
                                            <option value="uas" {{ $jenis === 'uas' ? 'selected' : '' }}>UAS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Pertanyaan</label>
                                    <textarea name="question" class="textarea" required placeholder="Tulis soal di sini..."></textarea>
                                </div>
                                <div class="row">
                                    <div class="field"><label class="label">Opsi A</label><input type="text" name="option_a" class="input" required></div>
                                    <div class="field"><label class="label">Opsi B</label><input type="text" name="option_b" class="input" required></div>
                                    <div class="field"><label class="label">Opsi C</label><input type="text" name="option_c" class="input" required></div>
                                    <div class="field"><label class="label">Opsi D</label><input type="text" name="option_d" class="input" required></div>
                                </div>
                                <div class="row">
                                    <div class="field">
                                        <label class="label">Jawaban Benar</label>
                                        <select name="correct_answer" class="select" required>
                                            <option value="a">A</option>
                                            <option value="b">B</option>
                                            <option value="c">C</option>
                                            <option value="d">D</option>
                                        </select>
                                    </div>
                                    <div class="field"><label class="label">Poin</label><input type="number" name="points" class="input" min="1" value="10"></div>
                                    <div class="field"><label class="label">Urutan</label><input type="number" name="sort_order" class="input" min="0" value="0"></div>
                                    <div class="field"><label class="label">Aktif</label><select name="is_active" class="select"><option value="1" selected>Ya</option><option value="0">Tidak</option></select></div>
                                </div>
                                <button type="submit" class="btn btn-primary" style="background:#2563eb;color:#fff;margin-top:4px;"><i class="fas fa-plus"></i> Simpan Soal</button>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <div class="table-head">
                                <div>
                                    <div class="card-title">Daftar Soal</div>
                                    <div class="card-sub">Filter berdasarkan tipe ujian dan mapel.</div>
                                </div>
                                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                    <a href="{{ route('exam-questions.index', array_filter(['jenis' => 'uts', 'subject_id' => $subjectId])) }}" class="badge badge-blue" style="text-decoration:none;">UTS</a>
                                    <a href="{{ route('exam-questions.index', array_filter(['jenis' => 'uas', 'subject_id' => $subjectId])) }}" class="badge badge-green" style="text-decoration:none;">UAS</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('exam-questions.index') }}" method="GET" style="display:grid;grid-template-columns:1fr 1fr auto;gap:10px;margin-bottom:16px;">
                                <select name="jenis" class="select">
                                    <option value="uts" {{ $jenis === 'uts' ? 'selected' : '' }}>UTS</option>
                                    <option value="uas" {{ $jenis === 'uas' ? 'selected' : '' }}>UAS</option>
                                </select>
                                <select name="subject_id" class="select">
                                    <option value="">Semua Mapel</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ (int) $subjectId === $subject->id ? 'selected' : '' }}>{{ $subject->name }}{{ $subject->class_id ? ' ('.$subject->class_id.')' : '' }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary" style="background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;"><i class="fas fa-filter"></i> Filter</button>
                            </form>

                            <div class="table-wrap">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Mapel</th>
                                            <th>Tipe</th>
                                            <th>Pertanyaan</th>
                                            <th>Jawaban</th>
                                            <th>Poin</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($questions as $question)
                                            <tr>
                                                <td style="font-weight:800;">{{ $question->subject->name ?? '-' }}</td>
                                                <td><span class="badge {{ $question->type === 'uts' ? 'badge-blue' : 'badge-green' }}">{{ strtoupper($question->type) }}</span></td>
                                                <td>{{ \Illuminate\Support\Str::limit($question->question, 80) }}</td>
                                                <td>{{ strtoupper($question->correct_answer) }}</td>
                                                <td>{{ $question->points }}</td>
                                                <td><span class="badge {{ $question->is_active ? 'badge-green' : 'badge-amber' }}">{{ $question->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                                                <td>
                                                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                                        <button type="button" class="action action-edit" onclick="openEdit(this)" data-update-url="{{ route('exam-questions.update', $question) }}" data-subject-id="{{ $question->subject_id }}" data-type="{{ $question->type }}" data-question='@json($question->question)' data-options='@json($question->options)' data-correct-answer="{{ $question->correct_answer }}" data-points="{{ $question->points }}" data-sort-order="{{ $question->sort_order }}" data-is-active="{{ $question->is_active ? 1 : 0 }}"><i class="fas fa-pen"></i> Edit</button>
                                                        <form action="{{ route('exam-questions.destroy', $question) }}" method="POST" onsubmit="return confirm('Hapus soal ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="action action-delete"><i class="fas fa-trash"></i> Hapus</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="7" style="text-align:center;padding:26px;color:#64748b;">Belum ada soal yang dibuat.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="pagination-wrap">
                                <span>Menampilkan {{ $questions->firstItem() }}–{{ $questions->lastItem() }} dari {{ $questions->total() }} soal</span>
                                <div>{{ $questions->withQueryString()->links('pagination::bootstrap-5') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-overlay" id="editModal">
                <div class="modal-panel">
                    <div class="modal-hd">
                        <div>
                            <div class="card-title">Edit Soal</div>
                            <div class="card-sub">Perbarui materi, jawaban benar, atau status aktif.</div>
                        </div>
                        <button type="button" class="modal-close" onclick="closeEdit()"><i class="fas fa-xmark"></i></button>
                    </div>
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="field">
                                    <label class="label">Mapel</label>
                                    <select name="subject_id" id="edit_subject_id" class="select" required>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }}{{ $subject->class_id ? ' ('.$subject->class_id.')' : '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="field">
                                    <label class="label">Tipe</label>
                                    <select name="type" id="edit_type" class="select" required>
                                        <option value="uts">UTS</option>
                                        <option value="uas">UAS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Pertanyaan</label>
                                <textarea name="question" id="edit_question" class="textarea" required></textarea>
                            </div>
                            <div class="row">
                                <div class="field"><label class="label">Opsi A</label><input type="text" name="option_a" id="edit_option_a" class="input" required></div>
                                <div class="field"><label class="label">Opsi B</label><input type="text" name="option_b" id="edit_option_b" class="input" required></div>
                                <div class="field"><label class="label">Opsi C</label><input type="text" name="option_c" id="edit_option_c" class="input" required></div>
                                <div class="field"><label class="label">Opsi D</label><input type="text" name="option_d" id="edit_option_d" class="input" required></div>
                            </div>
                            <div class="row">
                                <div class="field"><label class="label">Jawaban Benar</label><select name="correct_answer" id="edit_correct_answer" class="select" required><option value="a">A</option><option value="b">B</option><option value="c">C</option><option value="d">D</option></select></div>
                                <div class="field"><label class="label">Poin</label><input type="number" name="points" id="edit_points" class="input" min="1"></div>
                                <div class="field"><label class="label">Urutan</label><input type="number" name="sort_order" id="edit_sort_order" class="input" min="0"></div>
                                <div class="field"><label class="label">Aktif</label><select name="is_active" id="edit_is_active" class="select"><option value="1">Ya</option><option value="0">Tidak</option></select></div>
                            </div>
                        </div>
                        <div class="modal-ft">
                            <button type="button" class="btn btn-secondary" onclick="closeEdit()">Batal</button>
                            <button type="submit" class="btn btn-primary" style="background:#2563eb;color:#fff;">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openEdit(button) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');

    form.action = button.dataset.updateUrl;
    document.getElementById('edit_subject_id').value = button.dataset.subjectId || '';
    document.getElementById('edit_type').value = button.dataset.type || 'uts';
    document.getElementById('edit_question').value = button.dataset.question || '';

    const options = JSON.parse(button.dataset.options || '{}');
    document.getElementById('edit_option_a').value = options.a || '';
    document.getElementById('edit_option_b').value = options.b || '';
    document.getElementById('edit_option_c').value = options.c || '';
    document.getElementById('edit_option_d').value = options.d || '';
    document.getElementById('edit_correct_answer').value = button.dataset.correctAnswer || 'a';
    document.getElementById('edit_points').value = button.dataset.points || 10;
    document.getElementById('edit_sort_order').value = button.dataset.sortOrder || 0;
    document.getElementById('edit_is_active').value = button.dataset.isActive || 1;

    modal.classList.add('open');
}

function closeEdit() {
    document.getElementById('editModal').classList.remove('open');
}

document.getElementById('editModal').addEventListener('click', function(event) {
    if (event.target === this) closeEdit();
});
</script>
@endsection