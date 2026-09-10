@extends('layouts.app')
@section('title', 'Edit Siswa - SMK TRAVINA PRIMA')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
:root{--sb:64px;--sb-open:220px;--bg:#f4f6fa;--card:#fff;--border:#e8eaf0;--txt:#111827;--txt2:#6b7280;--red:#dc2626;--orange:#ea580c;--orange-bg:#fff7ed;--blue:#2563eb;--sb-bg:#0f1117;--r:16px;--shadow:0 1px 3px rgba(0,0,0,.06),0 2px 8px rgba(0,0,0,.04);}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg);color:var(--txt);-webkit-font-smoothing:antialiased;}
.app{display:flex;min-height:100vh;}
.main{margin-left:var(--sb);flex:1;display:flex;flex-direction:column;}
.sb{width:var(--sb);background:var(--sb-bg);position:fixed;top:0;left:0;height:100vh;z-index:200;display:flex;flex-direction:column;align-items:center;padding:16px 0 20px;transition:width .28s cubic-bezier(.4,0,.2,1);overflow:hidden;border-right:1px solid #1a1d27;}
.sb:hover{width:var(--sb-open);align-items:flex-start;}
.sb-brand{display:flex;align-items:center;gap:10px;padding:4px 14px;width:100%;min-height:44px;margin-bottom:20px;}
.sb-mark{width:32px;height:32px;border-radius:9px;flex-shrink:0;background:var(--blue);display:flex;align-items:center;justify-content:center;color:white;font-size:14px;}
.sb-name{font-size:13px;font-weight:700;color:white;white-space:nowrap;opacity:0;transition:opacity .2s;}
.sb:hover .sb-name{opacity:1;}
.sb-nav{width:100%;padding:0 10px;flex:1;display:flex;flex-direction:column;gap:2px;}
.sb-grp{font-size:9px;font-weight:700;letter-spacing:.14em;color:#374151;text-transform:uppercase;padding:12px 8px 4px;white-space:nowrap;opacity:0;transition:opacity .2s;}
.sb:hover .sb-grp{opacity:1;}
.sb-a{display:flex;align-items:center;gap:10px;padding:8px 9px;border-radius:10px;color:#6b7280;font-size:13px;font-weight:500;text-decoration:none;white-space:nowrap;transition:all .15s;}
.sb-a .ic{width:34px;height:34px;border-radius:9px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:13px;color:#4b5163;transition:all .15s;}
.sb-a:hover{color:#d1d5db;}
.sb-a:hover .ic{background:#1c1f2e;color:#9ca3af;}
.sb-a.on{color:white;}
.sb-a.on .ic{background:var(--orange);color:white;box-shadow:0 4px 10px rgba(234,88,12,.3);}
.sb-lbl{opacity:0;transition:opacity .18s;pointer-events:none;white-space:nowrap;}
.sb:hover .sb-lbl{opacity:1;pointer-events:auto;}
.sb-foot{width:100%;padding:0 10px;margin-top:auto;border-top:1px solid #1a1d27;padding-top:14px;}
.sb-user{display:flex;align-items:center;gap:9px;padding:9px;border-radius:10px;background:rgba(255,255,255,.04);margin-bottom:6px;}
.sb-av{width:32px;height:32px;border-radius:9px;flex-shrink:0;background:var(--orange);color:white;font-weight:800;font-size:14px;display:flex;align-items:center;justify-content:center;}
.sb-uname{font-size:12px;font-weight:700;color:#f1f5f9;}
.sb-urole{font-size:10px;color:#6b7280;}
.sb-out{display:flex;align-items:center;gap:10px;padding:9px;border-radius:10px;background:transparent;border:none;color:#ef4444;font-size:12px;font-weight:600;cursor:pointer;width:100%;font-family:inherit;white-space:nowrap;transition:background .15s;}
.sb-out:hover{background:rgba(239,68,68,.1);}
.sb-out .ic{width:34px;height:34px;border-radius:9px;background:rgba(239,68,68,.08);display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;}
.topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 28px;background:rgba(244,246,250,.95);backdrop-filter:blur(10px);border-bottom:1px solid var(--border);position:sticky;top:0;z-index:100;}
.top-left{display:flex;align-items:center;gap:10px;}
.back-btn{width:34px;height:34px;border-radius:9px;background:var(--card);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--txt2);text-decoration:none;transition:all .15s;}
.back-btn:hover{background:var(--orange-bg);color:var(--orange);border-color:var(--orange);}
.top-title{font-size:18px;font-weight:800;color:var(--txt);letter-spacing:-.3px;}
.top-sub{font-size:12px;color:var(--txt2);margin-top:1px;}
.page{padding:28px;flex:1;}
.form-card{background:var(--card);border:1px solid var(--border);border-radius:var(--r);box-shadow:var(--shadow);max-width:600px;}
.form-card-head{padding:20px 24px;border-bottom:1px solid var(--border);}
.form-card-head h6{font-size:15px;font-weight:800;}
.form-body{padding:24px;}
.form-group{margin-bottom:18px;}
.form-group label{display:block;font-size:11px;font-weight:700;color:var(--txt2);text-transform:uppercase;letter-spacing:.08em;margin-bottom:7px;}
.form-group input,.form-group select{width:100%;padding:11px 14px;border:1px solid var(--border);border-radius:10px;font-size:13px;font-family:inherit;background:var(--bg);color:var(--txt);outline:none;transition:border .15s;}
.form-group input:focus,.form-group select:focus{border-color:var(--orange);background:white;}
.form-group .err{font-size:11px;color:var(--red);margin-top:5px;font-weight:600;}
.btn{display:inline-flex;align-items:center;gap:7px;padding:11px 20px;border-radius:10px;font-size:13px;font-weight:700;border:none;cursor:pointer;font-family:inherit;transition:all .15s;text-decoration:none;}
.btn-orange{background:var(--orange);color:white;}
.btn-orange:hover{background:#c2410c;}
.btn-ghost{background:transparent;color:var(--txt2);border:1px solid var(--border);}
.btn-ghost:hover{background:#f3f4f6;}
@media(max-width:640px){.sb{display:none;}.main{margin-left:0;}.page{padding:16px;}}
</style>

<div class="app">
    @include('partials.sidebar')

    <div class="main">
        <header class="topbar">
            <div class="top-left">
                <a href="{{ route('students.index') }}" class="back-btn"><i class="fas fa-arrow-left"></i></a>
                <div>
                    <div class="top-title">Edit Siswa</div>
                    <div class="top-sub">{{ $student->name }}</div>
                </div>
            </div>
        </header>

        <div class="page">
            <div class="form-card">
                <div class="form-card-head">
                    <h6>✏️ Edit Data Siswa</h6>
                </div>
                <div class="form-body">
                    <form action="{{ route('students.update', $student->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $student->name) }}" required>
                            @error('name')<div class="err">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" name="nis" value="{{ old('nis', $student->nis) }}" required>
                            @error('nis')<div class="err">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email', $student->email) }}" required>
                            @error('email')<div class="err">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="class_id" value="{{ old('class_id', $student->class_id) }}" placeholder="Contoh: X-A, XI-IPA-1" required>
                            @error('class_id')<div class="err">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', $student->tahun_ajaran) }}" placeholder="Contoh: 2025/2026" maxlength="20">
                            @error('tahun_ajaran')<div class="err">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="gender" required>
                                <option value="">Pilih jenis kelamin</option>
                                <option value="L" {{ old('gender', $student->gender) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender', $student->gender) === 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')<div class="err">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Kategori Beasiswa / Diskon</label>
                            <select name="beasiswa_type">
                                <option value="reguler" {{ old('beasiswa_type', $student->beasiswa_type) === 'reguler' ? 'selected' : '' }}>Reguler (Tanpa Beasiswa)</option>
                                <option value="beasiswa_prestasi" {{ old('beasiswa_type', $student->beasiswa_type) === 'beasiswa_prestasi' ? 'selected' : '' }}>Beasiswa Prestasi</option>
                                <option value="kurang_mampu" {{ old('beasiswa_type', $student->beasiswa_type) === 'kurang_mampu' ? 'selected' : '' }}>Kurang Mampu (KIP)</option>
                                <option value="anak_yatim" {{ old('beasiswa_type', $student->beasiswa_type) === 'anak_yatim' ? 'selected' : '' }}>Anak Yatim / Piatu</option>
                            </select>
                            @error('beasiswa_type')<div class="err">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Potongan SPP per Bulan (Rp)</label>
                            <input type="number" name="potongan_spp" value="{{ old('potongan_spp', $student->potongan_spp ?? 0) }}" placeholder="Contoh: 50000" min="0" step="1000">
                            @error('potongan_spp')<div class="err">{{ $message }}</div>@enderror
                        </div>
                        <div style="display:flex;gap:10px;margin-top:8px;">
                            <button type="submit" class="btn btn-orange">
                                <i class="fas fa-save"></i> Update
                            </button>
                            <a href="{{ route('students.index') }}" class="btn btn-ghost">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
