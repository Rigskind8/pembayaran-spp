@extends('layouts.app')
@section('title', 'Edit Profil Admin')
@section('content')
<div class="main page" style="display:flex;justify-content:center;align-items:center;min-height:100vh;">
    <div class="card mx-auto" style="max-width:420px;">
    <div class="card-header">Edit Profil Admin</div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 text-center">
                @if($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" class="rounded-circle mb-2" width="100" height="100">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff" alt="Foto Profil" class="rounded-circle mb-2" width="100" height="100">
                @endif
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Foto Profil</label>
                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                @error('photo')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
