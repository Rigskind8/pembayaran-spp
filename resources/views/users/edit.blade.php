@extends('layouts.app')

@section('title', 'Edit User - Travina Prima')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f4f6fa; color: #111827; }
.card { background: #fff; padding: 24px; border-radius: 16px; box-shadow: 0 4px 16px rgba(0,0,0,.04); max-width: 600px; margin: 40px auto; border: 1px solid #e8eaf0; }
.form-group { margin-bottom: 16px; }
.form-group label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px; }
.form-input { width: 100%; padding: 12px; border: 1.5px solid #e8eaf0; border-radius: 10px; font-family: inherit; font-size: 14px; outline:none; background:#fff; }
.form-input:focus { border-color: #2563eb; }
.btn-submit { background: #2563eb; color: white; border: none; padding: 12px 20px; border-radius: 10px; font-weight: 700; cursor: pointer; width: 100%; font-size:14px; margin-top: 10px; }
.btn-back { display:inline-flex; align-items:center; gap:6px; color:#6b7280; text-decoration:none; font-size:13px; font-weight:700; }
.alert { background:#fef2f2; color:#dc2626; padding:12px; border-radius:8px; margin-bottom:16px; font-size:13px; }
</style>

<div>
    <div class="card">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; border-bottom:1px solid #e8eaf0; padding-bottom:16px; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:12px;">
                <a href="{{ route('users.index') }}" class="btn-back"><i class="fas fa-arrow-left"></i></a>
                <h2 style="font-size: 18px;">Edit User</h2>
            </div>
            <div style="font-size:12px; color:#6b7280; font-weight:700;">{{ $user->name }}</div>
        </div>

        @if($errors->any())
        <div class="alert">
            <ul style="margin-left:20px;">
                @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-input" placeholder="Cth: Budi Santoso" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" name="email" class="form-input" placeholder="budi@paramount.com" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group">
                <label>Role / Hak Akses</label>
                <select name="role_id" class="form-input" required>
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $role)
                        @php
                            $normalized = strtolower(trim((string) $role->name));
                            $currentRole = strtolower(trim((string) $user->role));
                            $isSelected = old('role_id')
                                ? old('role_id') == $role->id
                                : in_array($currentRole, [$normalized, str_replace(' ', '_', $normalized)], true);
                        @endphp
                        <option value="{{ $role->id }}" {{ $isSelected ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="background:#f8fafc; border:1px solid #e8eaf0; border-radius:12px; padding:12px 14px;">
                <div style="font-size:12px; font-weight:700; color:#334155; margin-bottom:6px;">Informasi</div>
                <div style="font-size:12px; color:#64748b; line-height:1.5;">Perubahan nama, email, dan role akan langsung dipakai sistem. Kalau role diubah ke siswa, data siswa akan ikut disinkronkan.</div>
            </div>

            <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection