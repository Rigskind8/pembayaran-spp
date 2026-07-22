@extends('layouts.app')

@section('title', 'Hasil Ujian ' . strtoupper($jenis) . ' - ' . $subject->name)

@section('content')
<style>
    body{background:#f4f6fa;color:#111827;}
    .app{display:flex;min-height:100vh;}
    .main{margin-left:var(--sb,250px);flex:1;display:flex;flex-direction:column;}
    .page{padding:28px;display:grid;gap:18px;}
    .hero{background:linear-gradient(135deg,#0f172a 0%,#1d4ed8 55%,#2563eb 100%);color:#fff;border-radius:18px;padding:24px 26px;display:flex;justify-content:space-between;gap:16px;align-items:center;box-shadow:0 12px 28px rgba(15,23,42,.16);}
    .hero h1{font-size:24px;font-weight:900;letter-spacing:-.02em;}
    .hero p{font-size:13px;color:rgba(255,255,255,.76);margin-top:4px;}
    .pill{display:inline-flex;align-items:center;gap:7px;padding:8px 12px;border-radius:999px;background:rgba(255,255,255,.14);font-size:12px;font-weight:800;}
    .grid{display:grid;grid-template-columns:360px 1fr;gap:18px;}
    .card{background:#fff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.06),0 2px 8px rgba(0,0,0,.04);}
    .card-head{padding:16px 18px;border-bottom:1px solid #e2e8f0;background:#fafbff;}
    .card-title{font-size:15px;font-weight:900;}
    .card-sub{font-size:11.5px;color:#64748b;margin-top:4px;}
    .card-body{padding:18px;display:grid;gap:12px;}
    .metric{background:#f8fafc;border:1px solid #e2e8f0;border-radius:14px;padding:14px;}
    .metric .k{font-size:11px;font-weight:800;letter-spacing:.06em;color:#64748b;text-transform:uppercase;}
    .metric .v{font-size:24px;font-weight:900;margin-top:6px;}
    .metric .sub{font-size:12px;color:#475569;margin-top:6px;}
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:11px 14px;border-radius:12px;font-size:13px;font-weight:800;text-decoration:none;border:1px solid transparent;}
    .btn-primary{background:#2563eb;color:#fff;}
    .btn-secondary{background:#fff;color:#0f172a;border-color:#cbd5e1;}
    .question{border:1px solid #e2e8f0;border-radius:14px;padding:14px;display:grid;gap:10px;}
    .q-head{display:flex;justify-content:space-between;gap:12px;align-items:flex-start;}
    .q-no{font-size:12px;font-weight:800;color:#2563eb;}
    .q-text{font-size:14px;font-weight:700;line-height:1.6;}
    .badge{display:inline-flex;align-items:center;padding:5px 10px;border-radius:999px;font-size:11px;font-weight:800;}
    .badge.green{background:#ecfdf5;color:#059669;}
    .badge.red{background:#fef2f2;color:#dc2626;}
    .answer-grid{display:grid;gap:8px;}
    .answer-box{border:1px solid #e2e8f0;border-radius:12px;padding:10px 12px;font-size:13px;line-height:1.5;background:#fff;}
    .answer-box.correct{border-color:#86efac;background:#f0fdf4;}
    .answer-box.selected{border-color:#93c5fd;background:#eff6ff;}
    @media(max-width:960px){.grid{grid-template-columns:1fr;} .hero{flex-direction:column;align-items:flex-start;}}
    @media(max-width:900px){.main{margin-left:0;}}
    @media(max-width:640px){.page{padding:16px;}}
</style>

<div class="app">
    @include('partials.sidebar')
    <div class="main">
        <div class="page">
            <div class="hero">
                <div>
                    <div class="pill"><i class="fas fa-square-poll-vertical"></i> Hasil Ujian {{ strtoupper($jenis) }}</div>
                    <h1>{{ $subject->name }}</h1>
                    <p>Hasil dikirim pada {{ $attempt->submitted_at?->format('d M Y H:i') ?? '-' }}</p>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <span class="btn btn-secondary" style="cursor:default;"><i class="fas fa-lock"></i> Sudah Dikerjakan</span>
                    <a href="{{ route('ujian.result.pdf', [$jenis, $subject, 'attempt' => $attempt->id]) }}" class="btn btn-secondary"><i class="fas fa-file-pdf"></i> Download PDF</a>
                    <a href="{{ route('ujian.' . $jenis) }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </div>

            <div class="grid">
                <div class="card">
                    <div class="card-head">
                        <div class="card-title">Ringkasan Nilai</div>
                        <div class="card-sub">Skor dan statistik jawaban</div>
                    </div>
                    <div class="card-body">
                        <div class="metric">
                            <div class="k">Skor</div>
                            <div class="v">{{ number_format((float) $attempt->score, 1) }} / {{ number_format((float) $attempt->max_score, 1) }}</div>
                            <div class="sub">Persentase {{ $attempt->max_score > 0 ? number_format(((float) $attempt->score / (float) $attempt->max_score) * 100, 1) : '0' }}%</div>
                        </div>
                        <div class="metric">
                            <div class="k">Jawaban Benar</div>
                            <div class="v">{{ $attempt->correct_count }} / {{ $attempt->total_questions }}</div>
                            <div class="sub">{{ $attempt->total_questions > 0 ? number_format(($attempt->correct_count / $attempt->total_questions) * 100, 1) : '0' }}% akurasi</div>
                        </div>
                        <div class="metric">
                            <div class="k">Status</div>
                            <div class="v" style="font-size:18px;">{{ $attempt->score >= (($attempt->max_score ?? 0) * 0.75) ? 'Sangat Baik' : ($attempt->score >= (($attempt->max_score ?? 0) * 0.6) ? 'Cukup' : 'Perlu Perbaikan') }}</div>
                            <div class="sub">Evaluasi otomatis dari sistem</div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <div class="card-title">Detail Jawaban</div>
                        <div class="card-sub">Benar/salah per soal</div>
                    </div>
                    <div class="card-body">
                        @forelse($details as $index => $detail)
                            @php
                                $q = $detail['question'];
                                $selected = $detail['selected'];
                                $correct = $detail['correct'];
                            @endphp
                            <div class="question">
                                <div class="q-head">
                                    <div>
                                        <div class="q-no">Soal {{ $index + 1 }}</div>
                                        <div class="q-text">{{ $q->question }}</div>
                                    </div>
                                    <span class="badge {{ $detail['is_correct'] ? 'green' : 'red' }}">{{ $detail['is_correct'] ? 'Benar' : 'Salah' }}</span>
                                </div>

                                <div class="answer-grid">
                                    @foreach(['a', 'b', 'c', 'd'] as $optionKey)
                                        @php
                                            $classes = ['answer-box'];
                                            if ($correct === $optionKey) {
                                                $classes[] = 'correct';
                                            }
                                            if ($selected === $optionKey) {
                                                $classes[] = 'selected';
                                            }
                                        @endphp
                                        <div class="{{ implode(' ', $classes) }}">
                                            <strong>{{ strtoupper($optionKey) }}.</strong>
                                            {{ $q->options[$optionKey] ?? '-' }}
                                            @if($selected === $optionKey)
                                                <span style="font-size:11px;color:#1d4ed8;font-weight:800;">(Jawaban kamu)</span>
                                            @endif
                                            @if($correct === $optionKey)
                                                <span style="font-size:11px;color:#166534;font-weight:800;">(Kunci)</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div style="text-align:center;color:#64748b;padding:24px;">Detail jawaban tidak tersedia.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
