{{-- resources/views/ujian/uts.blade.php --}}
@extends('layouts.app')

@section('title', 'Ujian Tengah Semester (UTS) - ' . config('app.name', 'SMK TRAVINA PRIMA'))

@section('content')
    @include('ujian.exam-page', [
        'jenis'        => 'uts',
        'pageTitle'    => 'Ujian Tengah Semester (UTS)',
        'pageSubtitle' => 'Portal Pengerjaan Soal UTS · Tahun Pelajaran ' . date('Y') . '/' . (date('Y') + 1),
        'pageTag'      => 'Ujian Tengah Semester',
        'accent'       => 'blue',
    ])
@endsection