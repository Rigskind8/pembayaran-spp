@extends('layouts.app')

@section('title', 'Detail Hasil Ujian - Paramount')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root { --sb: 64px; --sb-open: 220px; --bg: #f4f6fa; --card: #fff; --border: #e8eaf0; --txt: #111827; --txt2: #6b7280; --txt3: #9ca3af; --blue: #2563eb; --blue-bg: #eff6ff; --green: #059669; --green-bg: #ecfdf5; --red: #dc2626; --red-bg: #fef2f2; --sb-bg: #0f1117; --r: 16px; --shadow: 0 1px 3px rgba(0,0,0,.06), 0 2px 8px rgba(0,0,0,.04); }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--txt); }
.app { display: flex; min-height: 100vh; }
.main { margin-left: var(--sb); flex: 1; display: flex; flex-direction: column; }

/* SIDEBAR */
.sb { width: var(--sb); background: var(--sb-bg); position: fixed; top: 0; left: 0; height: 100vh; z-index: 200; display: flex; flex-direction: column; align-items: center; padding: 16px 0 20px; transition: width .28s; overflow: hidden; border-right: 1px solid #1a1d27; }
.sb:hover { width: var(--sb-open); align-items: flex-start; }
.sb-brand { display: flex; align-items: center; gap: 10px; padding: 4px 14px; width: 100%; min-height: 44px; margin-bottom: 20px; }
.sb-mark { width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0; background: var(--blue); display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; }
.sb-name { font-size: 13px; font-weight: 700; color: white; white-space: nowrap; opacity: 0; transition: opacity .2s; }
.sb:hover .sb-name { opacity: 1; }
.sb-nav { width: 100%; padding: 0 10px; flex: 1; display: flex; flex-direction: column; gap: 2px; }
.sb-grp { font-size: 11px; font-weight: 800; letter-spacing: .1em; color: #eef4ff; text-transform: uppercase; padding: 12px 8px 4px; white-space: nowrap; opacity: 0; text-shadow: 0 1px 1px rgba(0,0,0,.35); }
.sb:hover .sb-grp { opacity: 1; }
.sb-a { display: flex; align-items: center; gap: 10px; padding: 8px 9px; border-radius: 10px; color: #6b7280; font-size: 13px; font-weight: 500; text-decoration: none; white-space: nowrap; }
.sb-a .ic { width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 13px; color: #4b5163; }
.sb-a.on { color: white; }
.sb-a.on .ic { background: var(--blue); color: white; box-shadow: 0 4px 10px rgba(37,99,235,.3); }
.sb-lbl { opacity: 0; transition: opacity .18s; pointer-events: none; white-space: nowrap; }
.sb:hover .sb-lbl { opacity: 1; pointer-events: auto; }

/* LAYOUT */
.topbar { display: flex; justify-content: space-between; padding: 14px 28px; background: rgba(244,246,250,.95); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border); }
.page { padding: 28px; flex: 1; overflow-y: auto; }
.btn { padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; border: none; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
.btn-blue { background: var(--blue); color: white; }

.card { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); box-shadow: var(--shadow); overflow: hidden; margin-bottom: 20px; }
.card-head { padding: 16px 20px; background: #fafbff; border-bottom: 1px solid var(--border); }
.card-title { font-size: 14px; font-weight: 700; }

.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 20px; }
.stat-box { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); padding: 16px; text-align: center; box-shadow: var(--shadow); }
.stat-value { font-size: 28px; font-weight: 800; color: var(--blue); }
.stat-label { font-size: 12px; color: var(--txt3); margin-top: 6px; text-transform: uppercase; font-weight: 600; }

.question-item { border: 1px solid var(--border); border-radius: 8px; padding: 16px; margin-bottom: 12px; background: var(--card); }
.question-num { font-size: 12px; font-weight: 700; color: var(--txt3); text-transform: uppercase; margin-bottom: 4px; }
.question-text { font-size: 14px; font-weight: 600; margin-bottom: 12px; color: var(--txt); }
.option { padding: 8px 12px; border-radius: 6px; margin-bottom: 8px; font-size: 13px; border: 1px solid var(--border); }
.option.selected { border-color: var(--blue); background: var(--blue-bg); color: var(--blue); font-weight: 600; }
.option.correct { border-color: var(--green); background: var(--green-bg); color: var(--green); font-weight: 600; }
.option.incorrect { border-color: var(--red); background: var(--red-bg); color: var(--red); font-weight: 600; }

.badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; }
.badge-blue { background: var(--blue-bg); color: var(--blue); }
.badge-green { background: var(--green-bg); color: var(--green); }

@media(max-width:768px) { .stats-grid { grid-template-columns: 1fr; } }
</style>

<div class="app">
    @include('partials.sidebar')

    <div class="main">
        <header class="topbar">
            <div>
                <div style="font-size:18px; font-weight:800;">Detail Hasil Ujian</div>
                <div style="font-size:12px; color:var(--txt2);">Review jawaban siswa secara detail</div>
            </div>
            <a href="{{ route('exam-results.index') }}" class="btn btn-blue">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </header>

        <div class="page">
            <!-- Student Info -->
            <div class="card">
                <div class="card-head">
                    <div class="card-title">📋 Informasi Siswa</div>
                </div>
                <div style="padding: 20px;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                        <div>
                            <div style="font-size:11px; color:var(--txt3); font-weight:700; margin-bottom:4px;">Nama</div>
                            <div style="font-size:14px; font-weight:600;">{{ $attempt->user?->name ?? 'Unknown' }}</div>
                        </div>
                        <div>
                            <div style="font-size:11px; color:var(--txt3); font-weight:700; margin-bottom:4px;">Email</div>
                            <div style="font-size:14px; font-weight:600;">{{ $attempt->user?->email ?? '-' }}</div>
                        </div>
                        <div>
                            <div style="font-size:11px; color:var(--txt3); font-weight:700; margin-bottom:4px;">Mapel</div>
                            <div style="font-size:14px; font-weight:600;">{{ $attempt->subject?->name ?? '-' }}</div>
                        </div>
                        <div>
                            <div style="font-size:11px; color:var(--txt3); font-weight:700; margin-bottom:4px;">Tipe Ujian</div>
                            <span class="badge {{ $attempt->type === 'uts' ? 'badge-blue' : 'badge-green' }}">
                                {{ strtoupper($attempt->type) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-value">{{ $attempt->score }}/{{ $attempt->max_score }}</div>
                    <div class="stat-label">Total Skor</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">{{ round(($attempt->score / $attempt->max_score) * 100, 1) }}%</div>
                    <div class="stat-label">Persentase</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">{{ $attempt->correct_count }}/{{ $attempt->total_questions }}</div>
                    <div class="stat-label">Jawaban Benar</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">{{ $attempt->submitted_at?->format('d M Y') ?? '-' }}</div>
                    <div class="stat-label">Waktu Selesai</div>
                </div>
            </div>

            <!-- Questions & Answers -->
            <div class="card">
                <div class="card-head">
                    <div class="card-title">🎯 Riwayat Jawaban</div>
                </div>
                <div style="padding: 20px;">
                    @php
                        $answers = $attempt->answers ?? [];
                    @endphp

                    @if(empty($answers))
                        <div style="text-align: center; padding: 40px; color: var(--txt3);">
                            <i class="fas fa-inbox" style="font-size: 28px; margin-bottom: 10px; color: var(--border);"></i>
                            <div>Tidak ada data jawaban</div>
                        </div>
                    @else
                        @foreach($answers as $questionId => $answerData)
                            <div class="question-item">
                                <div class="question-num">Soal #{{ $loop->iteration }}</div>
                                <div class="question-text">
                                    (ID: {{ $questionId }})
                                </div>

                                <div style="margin-top: 12px;">
                                    <div style="font-size: 11px; color: var(--txt3); font-weight: 700; margin-bottom: 8px;">JAWABAN SISWA:</div>
                                    @if($answerData['selected'])
                                        <div class="option {{ $answerData['is_correct'] ? 'correct' : 'incorrect' }}">
                                            <i class="fas {{ $answerData['is_correct'] ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                            {{ strtoupper($answerData['selected']) }} {{ $answerData['is_correct'] ? '✓ Benar' : '✗ Salah' }}
                                        </div>
                                    @else
                                        <div class="option" style="background: #fef2f2; color: var(--red); border-color: var(--red);">
                                            <i class="fas fa-circle-question"></i> Tidak dijawab
                                        </div>
                                    @endif

                                    @if(!$answerData['is_correct'])
                                        <div style="font-size: 11px; color: var(--txt3); font-weight: 700; margin-top: 8px;">JAWABAN BENAR:</div>
                                        <div class="option correct">
                                            <i class="fas fa-check-circle"></i>
                                            {{ strtoupper($answerData['correct']) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
