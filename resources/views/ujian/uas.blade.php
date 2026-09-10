{{-- resources/views/ujian/uas.blade.php --}}
@extends('layouts.app')

@section('title', 'Ujian Akhir Semester (UAS) - ' . config('app.name', 'SMK TRAVINA PRIMA'))

@section('content')
    @include('ujian.exam-page', [
        'jenis'        => 'uas',
        'pageTitle'    => 'Ujian Akhir Semester (UAS)',
        'pageSubtitle' => 'Portal Pengerjaan Soal UAS · Tahun Pelajaran ' . date('Y') . '/' . (date('Y') + 1),
        'pageTag'      => 'Ujian Akhir Semester',
        'accent'       => 'purple',
    ])
@endsection
