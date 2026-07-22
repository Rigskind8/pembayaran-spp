@extends('layouts.app')

@section('title', 'Tambah User - Travina Prima')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* ... (Bisa pakai style yang sama dengan file create pembayaran lo sebelumnya biar konsisten) ... */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f4f6fa; color: #111827; }
.card { background: #fff; padding: 24px; border-radius: 16px; box-shadow: 0 4px 16px rgba(0,0,0,.04); max-width: 600px; margin: 40px auto; border: 1px solid #e8eaf0;}
.form-group { margin-bottom: 16px; }
.form-group label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px; }
.form-input { width: 100%; padding: 12px; border: 1.5px solid #e8eaf0; border-radius: 10px; font-family: inherit; font-size: 14px; outline:none;}
.form-input:focus { border-color: #2563eb; }
.btn-submit { background: #2563eb; color: white; border: none; padding: 12px 20px; border-radius: 10px; font-weight: 700; cursor: pointer; width: 100%; font-size:14px; margin-top: 10px;}
</style>

<div>
    <div class="card">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; border-bottom:1px solid #e8eaf0; padding-bottom:16px;">
            <a href="{{ route('users.index') }}" style="color:#6b7280; text-decoration:none;"><i class="fas fa-arrow-left"></i></a>
            <h2 style="font-size: 18px;">Tambah User Baru</h2>
        </div>

        @if($errors->any())
        <div style="background:#fef2f2; color:#dc2626; padding:12px; border-radius:8px; margin-bottom:16px; font-size:13px;">
            <ul style="margin-left:20px;">
                @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-input" placeholder="Cth: Budi Santoso" value="{{ old('name') }}" required>
            </div>
            
            <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" name="email" class="form-input" placeholder="budi@paramount.com" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label>Role / Hak Akses</label>
                <select name="role_id" class="form-input" required>
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Password Awal</label>
                <input type="text" name="password" class="form-input" placeholder="Minimal 6 karakter" required>
                <small style="color:#6b7280; font-size:11px; margin-top:4px; display:block;">Saran: Kasih password standar seperti 'paramount123', nanti user bisa ganti sendiri.</small>
            </div>

            <button type="submit" class="btn-submit"><i class="fas fa-user-plus"></i> Simpan Akun Baru</button>
        </form>
    </div>
</div>
@endsection