@extends('layouts.app')
@section('title', 'Pembayaran UAS - SMK TRAVINA PRIMA  ')
@section('content')
    @include('ujian.exam-page', [
        'jenis' => 'uas',
        'pageTitle' => 'Pengajuan UAS',
        'pageSubtitle' => 'Ujian Akhir Semester · ' . date('Y') . '/' . (date('Y') + 1),
        'pageTag' => 'Ujian Akhir Semester',
        'accent' => 'purple',
    ])
@endsection
