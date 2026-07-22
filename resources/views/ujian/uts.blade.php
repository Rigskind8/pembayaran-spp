@extends('layouts.app')
@section('title', 'Pembayaran UTS - Paramount')
@section('content')
    @include('ujian.exam-page', ['jenis' => 'uts', 'pageTitle' => 'Pengajuan UTS', 'pageSubtitle' => 'Ujian Tengah Semester · ' . date('Y') . '/' . (date('Y') + 1), 'pageTag' => 'Ujian Tengah Semester', 'accent' => 'blue'])
@endsection