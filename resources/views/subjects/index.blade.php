@extends('layouts.app')

@section('title', 'Mata Pelajaran - SMK TRAVINA PRIMA')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
    --sw: 62px; --sw-open: 230px;
    --bg: #f2f4f8; --card: #ffffff; --border: #e6e9f0;
    --txt: #0d1321; --txt2: #5a6274; --txt3: #9099ab;
    --blue: #2463eb; --blue-lt: #eff4ff; --blue-md: #c7d9fd;
    --green: #0a9060; --green-lt: #edfaf4; --green-md: #a3e6cb;
    --red: #d42b2b; --red-lt: #fff0f0; --red-md: #ffc4c4;
    --amber: #c97a00; --amber-lt: #fff8ed; --amber-md: #fddca0;
    --purple: #6d36e0; --purple-lt: #f4f0ff; --purple-md: #c9b8f8;
    --sb-bg: #0d1117; --sb-border: #1e2330;
    --r: 14px; --sh: 0 1px 2px rgba(0,0,0,.04), 0 2px 8px rgba(0,0,0,.04); --sh-md: 0 4px 20px rgba(0,0,0,.08);
}
body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--txt); -webkit-font-smoothing: antialiased; }
.app { display: flex; min-height: 100vh; }
.main { margin-left: var(--sw); flex: 1; display: flex; flex-direction: column; }

/* SIDEBAR */
.sb { width: var(--sw); background: var(--sb-bg); position: fixed; top: 0; left: 0; height: 100vh; z-index: 300; display: flex; flex-direction: column; align-items: center; padding: 16px 0 20px; transition: width .25s cubic-bezier(.4,0,.2,1); overflow: hidden; border-right: 1px solid var(--sb-border); }
.sb:hover { width: var(--sw-open); align-items: flex-start; }
.sb-brand { display: flex; align-items: center; gap: 10px; padding: 4px 13px; width: 100%; min-height: 42px; margin-bottom: 22px; }
.sb-mark { width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0; background: var(--blue); display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; }
.sb-name-text { font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 700; color: white; white-space: nowrap; opacity: 0; transition: opacity .18s; }
.sb:hover .sb-name-text { opacity: 1; }
.sb-nav { width: 100%; padding: 0 9px; flex: 1; display: flex; flex-direction: column; gap: 1px; overflow-y: auto; }
.sb-grp { font-size: 8px; font-weight: 700; letter-spacing: .16em; color: #3d4556; text-transform: uppercase; padding: 14px 9px 4px; white-space: nowrap; opacity: 0; transition: opacity .15s; }
.sb:hover .sb-grp { opacity: 1; }
.sb-a { display: flex; align-items: center; gap: 9px; padding: 7px 9px; border-radius: 9px; color: #5e697a; font-size: 12.5px; font-weight: 500; text-decoration: none; white-space: nowrap; transition: all .14s; }
.sb-a .ic { width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 12px; color: #4b5163; transition: all .14s; }
.sb-a:hover { color: #c8cdd8; }
.sb-a:hover .ic { background: #1c2130; color: #8b95a8; }
.sb-a.on { color: white; }
.sb-a.on .ic { background: var(--blue); color: white; box-shadow: 0 3px 10px rgba(36,99,235,.3); }
.sb-a.hl .ic { background: linear-gradient(135deg, var(--blue), var(--purple)); color: white; }
.sb-a.hl { color: #8daef5; }
.sb-lbl { opacity: 0; transition: opacity .15s; pointer-events: none; white-space: nowrap; }
.sb:hover .sb-lbl { opacity: 1; pointer-events: auto; }
.sb-foot { width: 100%; padding: 0 9px; margin-top: auto; border-top: 1px solid var(--sb-border); padding-top: 12px; }
.sb-user { display: flex; align-items: center; gap: 8px; padding: 8px; border-radius: 9px; background: rgba(255,255,255,.04); margin-bottom: 5px; }
.sb-av { width: 30px; height: 30px; border-radius: 8px; flex-shrink: 0; background: var(--blue); color: white; font-weight: 700; font-size: 12px; display: flex; align-items: center; justify-content: center; }
.sb-uname { font-size: 11.5px; font-weight: 700; color: #eef0f4; }
.sb-urole { font-size: 9.5px; color: #5a6477; }
.sb-out { display: flex; align-items: center; gap: 9px; padding: 8px; border-radius: 9px; background: transparent; border: none; color: #e55; font-size: 12px; font-weight: 600; cursor: pointer; width: 100%; font-family: inherit; white-space: nowrap; transition: background .13s; }
.sb-out:hover { background: rgba(220,50,50,.1); }
.sb-out .ic { width: 30px; height: 30px; border-radius: 8px; background: rgba(220,50,50,.08); display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0; }

/* TOPBAR */
.topbar { display: flex; align-items: center; justify-content: space-between; padding: 12px 26px; background: rgba(242,244,248,.94); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; }
.top-ttl { font-family: 'Syne', sans-serif; font-size: 17px; font-weight: 800; color: var(--txt); }
.top-sub { font-size: 11.5px; color: var(--txt2); margin-top: 1px; }
.top-r { display: flex; align-items: center; gap: 7px; }
.btn-blue { display: inline-flex; align-items: center; gap: 5px; padding: 8px 16px; background: var(--blue); color: white; border-radius: 9px; font-size: 12px; font-weight: 700; text-decoration: none; border: none; cursor: pointer; font-family: inherit; transition: all .13s; box-shadow: 0 2px 8px rgba(36,99,235,.22); }
.btn-blue:hover { background: #1a55d8; color: white; transform: translateY(-1px); }
.btn-cancel { display: inline-flex; align-items: center; gap: 5px; padding: 8px 14px; background: white; color: var(--txt); border: 1px solid var(--border); border-radius: 9px; font-size: 12px; font-weight: 700; cursor: pointer; font-family: inherit; transition: all .11s; }
.btn-cancel:hover { background: #f6f8fc; }
.btn-del { display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; border-radius: 7px; font-size: 10px; font-weight: 700; border: none; cursor: pointer; font-family: inherit; transition: all .13s; background: var(--red-lt); color: var(--red); }
.btn-del:hover { background: var(--red); color: white; }
.btn-edit { display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; border-radius: 7px; font-size: 10px; font-weight: 700; border: none; cursor: pointer; font-family: inherit; transition: all .13s; background: var(--amber-lt); color: var(--amber); }
.btn-edit:hover { background: var(--amber); color: white; }

/* BODY */
.body { padding: 24px 26px; flex: 1; }

/* CARD */
.card { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); overflow: hidden; box-shadow: var(--sh); margin-bottom: 16px; }
.card-head { display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; border-bottom: 1px solid var(--border); background: #fafbfe; }
.card-ttl { font-family: 'Syne', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--txt); }
.card-sub { font-size: 11px; color: var(--txt2); margin-top: 1px; }

/* FORM */
.form-grid { display: grid; grid-template-columns: repeat(3,1fr) auto; gap: 10px; align-items: end; padding: 16px 20px; }
.fg { display: flex; flex-direction: column; gap: 5px; }
.fl { font-size: 11px; font-weight: 700; color: var(--txt); }
.fc { padding: 8px 11px; border: 1px solid var(--border); border-radius: 8px; font-size: 12.5px; font-family: inherit; color: var(--txt); outline: none; transition: border-color .11s; background: white; }
.fc:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(36,99,235,.1); }

/* TABLE */
.dt { width: 100%; border-collapse: collapse; }
.dt thead tr { background: #f8f9fd; border-bottom: 1px solid var(--border); }
.dt th { padding: 10px 16px; font-size: 8.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .15em; color: var(--txt2); text-align: left; }
.dt th:first-child { padding-left: 20px; }
.dt th:last-child { padding-right: 20px; text-align: center; }
.dt tbody tr { border-bottom: 1px solid #f1f3f9; transition: background .1s; }
.dt tbody tr:last-child { border-bottom: none; }
.dt tbody tr:hover { background: #f7f9ff; }
.dt td { padding: 12px 16px; font-size: 12.5px; color: var(--txt); vertical-align: middle; }
.dt td:first-child { padding-left: 20px; }
.dt td:last-child { padding-right: 20px; text-align: center; }
.acts { display: flex; gap: 5px; justify-content: center; }

/* BADGE */
.bdg { display: inline-flex; align-items: center; padding: 3px 9px; border-radius: 6px; font-size: 9px; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; font-family: 'DM Mono', monospace; background: var(--purple-lt); color: var(--purple); border: 1px solid var(--purple-md); }

/* MODAL */
.overlay { position: fixed; inset: 0; background: rgba(0,0,0,.45); backdrop-filter: blur(4px); z-index: 1000; display: none; align-items: center; justify-content: center; }
.overlay.open { display: flex; }
.modal { background: white; border-radius: 16px; width: 460px; max-width: 95vw; box-shadow: 0 12px 40px rgba(0,0,0,.13); animation: mIn .2s ease; }
@keyframes mIn { from { opacity:0; transform:scale(.96) translateY(6px); } to { opacity:1; transform:none; } }
.m-head { padding: 18px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
.m-head h3 { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 800; color: var(--txt); }
.m-close { width: 28px; height: 28px; border-radius: 7px; background: #f0f2f8; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 12px; color: var(--txt2); transition: all .11s; }
.m-close:hover { background: var(--red-lt); color: var(--red); }
.m-body { padding: 18px 20px; display: flex; flex-direction: column; gap: 12px; }
.m-foot { padding: 14px 20px; border-top: 1px solid var(--border); display: flex; gap: 7px; justify-content: flex-end; }

/* EMPTY */
.empty { padding: 48px 20px; text-align: center; }
.empty-ic { width: 52px; height: 52px; border-radius: 14px; background: #f0f2f8; display: flex; align-items: center; justify-content: center; font-size: 22px; color: #c4c9d8; margin: 0 auto 12px; }
.empty p { font-size: 14px; font-weight: 700; color: var(--txt2); }
.empty span { font-size: 12px; color: var(--txt3); display: block; margin-top: 3px; }

/* TOAST */
.toasts { position: fixed; bottom: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 7px; }
.toast { display: flex; align-items: center; gap: 10px; padding: 12px 16px; background: white; border-radius: 12px; box-shadow: 0 12px 40px rgba(0,0,0,.13); border: 1px solid var(--border); min-width: 250px; animation: tIn .25s ease; }
@keyframes tIn { from{opacity:0;transform:translateX(30px)} to{opacity:1;transform:none} }
.toast.hide { opacity:0; transform:translateX(30px); transition:all .25s; }
.t-ic { width: 30px; height: 30px; border-radius: 8px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 13px; }
.t-ic.s { background: var(--green-lt); color: var(--green); }
.t-ic.e { background: var(--red-lt); color: var(--red); }
.t-ttl { font-size: 12.5px; font-weight: 700; color: var(--txt); }
.t-msg { font-size: 10.5px; color: var(--txt2); }

@media(max-width:640px) { .sb{display:none;} .main{margin-left:0;} .body{padding:14px;} .form-grid{grid-template-columns:1fr;} }
</style>

<div class="toasts" id="toasts"></div>

{{-- MODAL EDIT --}}
<div class="overlay" id="mEdit">
    <div class="modal">
        <div class="m-head">
            <h3><i class="fas fa-pen" style="color:var(--amber);margin-right:7px;"></i>Edit Mata Pelajaran</h3>
            <button class="m-close" onclick="closeM('mEdit')"><i class="fas fa-times"></i></button>
        </div>
        <form id="fEdit" method="POST">
            @csrf @method('PATCH')
            <div class="m-body">
                <div class="fg">
                    <label class="fl">Nama Mata Pelajaran</label>
                    <input type="text" name="name" id="editName" class="fc" required>
                </div>
                <div class="fg">
                    <label class="fl">Kode</label>
                    <input type="text" name="code" id="editCode" class="fc" required>
                </div>
                <div class="fg">
                    <label class="fl">Kelas</label>
                    <input type="text" name="class_id" id="editClass" class="fc" placeholder="Contoh: X, XI, XII">
                </div>
                <div class="fg">
                    <label class="fl">Jam/Minggu</label>
                    <input type="number" name="hours_per_week" id="editHours" class="fc" min="1" max="20">
                </div>
                <div class="fg">
                    <label class="fl">Nama Guru</label>
                    <input type="text" name="teacher" id="editTeacher" class="fc" placeholder="Nama guru pengampu">
                </div>
            </div>
            <div class="m-foot">
                <button type="button" class="btn-cancel" onclick="closeM('mEdit')">Batal</button>
                <button type="submit" class="btn-blue"><i class="fas fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

<div class="app">
    {{-- SIDEBAR --}}
    @include('partials.sidebar')

    <div class="main">
        <header class="topbar">
            <div>
                <div class="top-ttl">Mata Pelajaran 📚</div>
                <div class="top-sub">Kelola daftar mata pelajaran · {{ $subjects->count() }} mapel terdaftar</div>
            </div>
            <div class="top-r">
                <a href="{{ route('dashboard') }}" class="btn-cancel"><i class="fas fa-arrow-left"></i> Dashboard</a>
                <button class="btn-blue" onclick="openM('mEdit');resetForm()"><i class="fas fa-plus"></i> Tambah Mapel</button>
            </div>
        </header>

        <div class="body">

            {{-- FORM TAMBAH --}}
            <div class="card">
                <div class="card-head">
                    <div>
                        <div class="card-ttl"><i class="fas fa-plus-circle" style="color:var(--blue);margin-right:6px;"></i>Tambah Mata Pelajaran</div>
                        <div class="card-sub">Isi form di bawah untuk menambahkan mata pelajaran baru</div>
                    </div>
                </div>
                <form action="{{ route('subjects.store') }}" method="POST">
                    @csrf
                    <div class="form-grid">
                        <div class="fg">
                            <label class="fl">Nama Mata Pelajaran <span style="color:var(--red)">*</span></label>
                            <input type="text" name="name" class="fc" placeholder="Contoh: Matematika" required value="{{ old('name') }}">
                        </div>
                        <div class="fg">
                            <label class="fl">Kode <span style="color:var(--red)">*</span></label>
                            <input type="text" name="code" class="fc" placeholder="Contoh: MTK" required value="{{ old('code') }}">
                        </div>
                        <div class="fg">
                            <label class="fl">Kelas</label>
                            <input type="text" name="class_id" class="fc" placeholder="X / XI / XII" value="{{ old('class_id') }}">
                        </div>
                        <div class="fg">
                            <label class="fl">Jam/Minggu</label>
                            <input type="number" name="hours_per_week" class="fc" placeholder="2" min="1" max="20" value="{{ old('hours_per_week', 2) }}">
                        </div>
                        <div class="fg">
                            <label class="fl">Nama Guru</label>
                            <input type="text" name="teacher" class="fc" placeholder="Nama guru pengampu" value="{{ old('teacher') }}">
                        </div>
                        <div class="fg">
                            <button type="submit" class="btn-blue" style="height:38px;"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </div>
                    @if($errors->any())
                    <div style="padding:0 20px 14px;">
                        @foreach($errors->all() as $err)
                        <div style="color:var(--red);font-size:11.5px;margin-top:4px;"><i class="fas fa-exclamation-circle"></i> {{ $err }}</div>
                        @endforeach
                    </div>
                    @endif
                </form>
            </div>

            {{-- TABLE --}}
            <div class="card">
                <div class="card-head">
                    <div>
                        <div class="card-ttl"><i class="fas fa-list" style="color:var(--blue);margin-right:6px;"></i>Daftar Mata Pelajaran</div>
                        <div class="card-sub">{{ $subjects->count() }} mata pelajaran terdaftar</div>
                    </div>
                </div>
                @if($subjects->isEmpty())
                <div class="empty">
                    <div class="empty-ic"><i class="fas fa-book-open"></i></div>
                    <p>Belum ada mata pelajaran</p>
                    <span>Tambahkan mata pelajaran menggunakan form di atas.</span>
                </div>
                @else
                <div style="overflow-x:auto;">
                    <table class="dt">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Mata Pelajaran</th>
                                <th>Kode</th>
                                <th>Kelas</th>
                                <th>Jam/Minggu</th>
                                <th>Guru Pengampu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $i => $s)
                            <tr>
                                <td style="color:var(--txt3);font-size:11px;">{{ $i + 1 }}</td>
                                <td>
                                    <div style="font-weight:700;">{{ $s->name }}</div>
                                </td>
                                <td><span class="bdg">{{ $s->code }}</span></td>
                                <td style="color:var(--txt2);">{{ $s->class_id ?? '—' }}</td>
                                <td style="font-family:'DM Mono',monospace;font-size:12px;">{{ $s->hours_per_week }} jam</td>
                                <td style="color:var(--txt2);">{{ $s->teacher ?? '—' }}</td>
                                <td>
                                    <div class="acts">
                                        <button class="btn-edit"
                                            onclick="openEdit({{ $s->id }},'{{ addslashes($s->name) }}','{{ $s->code }}','{{ $s->class_id }}',{{ $s->hours_per_week }},'{{ addslashes($s->teacher ?? '') }}')">
                                            <i class="fas fa-pen"></i> Edit
                                        </button>
                                        <form action="{{ route('subjects.destroy', $s->id) }}" method="POST" style="display:inline;"
                                            onsubmit="return confirm('Hapus mata pelajaran {{ addslashes($s->name) }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-del"><i class="fas fa-trash"></i> Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

<script>
function openM(id)  { document.getElementById(id).classList.add('open'); }
function closeM(id) { document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.overlay').forEach(el =>
    el.addEventListener('click', function(e) { if (e.target === this) this.classList.remove('open'); })
);

function openEdit(id, name, code, classId, hours, teacher) {
    document.getElementById('editName').value    = name;
    document.getElementById('editCode').value    = code;
    document.getElementById('editClass').value   = classId;
    document.getElementById('editHours').value   = hours;
    document.getElementById('editTeacher').value = teacher;
    document.getElementById('fEdit').action      = '/subjects/' + id;
    openM('mEdit');
}

function toast(type, title, msg) {
    const ic = {s:'fa-check',e:'fa-times'};
    const el = document.createElement('div');
    el.className = 'toast';
    el.innerHTML = `<div class="t-ic ${type}"><i class="fas ${ic[type]}"></i></div><div><div class="t-ttl">${title}</div><div class="t-msg">${msg}</div></div>`;
    document.getElementById('toasts').appendChild(el);
    setTimeout(() => { el.classList.add('hide'); setTimeout(() => el.remove(), 250); }, 3200);
}

@if(session('success')) window.addEventListener('load', () => toast('s', 'Berhasil', '{{ session('success') }}')); @endif
@if(session('error'))   window.addEventListener('load', () => toast('e', 'Error', '{{ session('error') }}')); @endif
</script>
@endsection
