@extends('layouts.app')

@section('title', 'Edit Surat')

@section('content')
<style>
.surat-page{max-width:1100px;margin:0 auto;padding:28px}.surat-card{background:#fff;border:1px solid #e5e7eb;border-radius:18px;padding:24px;box-shadow:0 8px 24px rgba(15,23,42,.06)}.surat-head{display:flex;justify-content:space-between;gap:16px;align-items:center;margin-bottom:22px}.surat-head h1{margin:0;font-size:25px;color:#0f172a}.surat-head p{margin:6px 0 0;color:#64748b;font-size:13px}.form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px;margin-bottom:20px}.form-grid label{display:grid;gap:7px;font-size:12px;font-weight:800;color:#334155}.form-grid .full{grid-column:1/-1}.form-grid input,.form-grid select,.form-grid textarea{width:100%;border:1px solid #cbd5e1;border-radius:10px;padding:10px 12px;font:inherit;font-size:13px;color:#0f172a;background:#fff}.form-grid textarea{resize:vertical}.form-grid small{font-weight:500;color:#64748b}.form-grid a{color:#2563eb}.btn-primary,.btn-secondary{display:inline-block;border:0;border-radius:10px;padding:11px 16px;font-weight:800;font-size:13px;text-decoration:none;cursor:pointer}.btn-primary{background:#2563eb;color:#fff}.btn-secondary{background:#f1f5f9;color:#334155;margin-left:8px}.errors{background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;border-radius:10px;padding:11px;margin-bottom:16px;font-size:13px}@media(max-width:700px){.surat-page{padding:16px}.form-grid{grid-template-columns:1fr}.form-grid .full{grid-column:auto}.surat-head{align-items:flex-start;flex-direction:column}}
</style>
<div class="surat-page"><div class="surat-card"><div class="surat-head"><div><h1>Edit Surat</h1><p>Perbarui data surat dan status pengarsipannya.</p></div><a class="btn-secondary" href="{{ route('surat.index') }}">Kembali</a></div><form action="{{ route('surat.update', $surat) }}" method="POST" enctype="multipart/form-data">@include('surat._form')</form></div></div>
@endsection
