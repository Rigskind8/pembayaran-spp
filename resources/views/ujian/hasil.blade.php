{{-- resources/views/ujian/hasil.blade.php --}}
@extends('layouts.app')

@section('title', 'Hasil Ujian ' . strtoupper($jenis) . ' - ' . $subject->name)

@push('styles')
<style>
    :root {
        --primary:        #2563eb;
        --primary-dark:   #1d4ed8;
        --primary-light:  #eff6ff;
        --line:           #e2e8f0;
        --text-main:      #0f172a;
        --text-muted:     #64748b;
        --card-bg:        #ffffff;
        --shadow-soft:    0 10px 25px -5px rgba(15, 23, 42, .06), 0 8px 10px -6px rgba(15, 23, 42, .04);
    }

    .exam-result-wrap {
        padding: 24px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ── BREADCRUMB ── */
    .result-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--text-muted);
        margin-bottom: 16px;
    }

    .result-breadcrumb a {
        color: var(--text-muted);
        transition: color .15s ease;
    }

    .result-breadcrumb a:hover {
        color: var(--primary);
    }

    /* ── HERO BANNER ── */
    .hero-result {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #2563eb 100%);
        border-radius: 20px;
        padding: 28px 32px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 16px 36px rgba(15, 23, 42, .2);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .hero-result-content {
        position: relative;
        z-index: 1;
        max-width: 650px;
    }

    .hero-pill-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, .9);
        background: rgba(255, 255, 255, .16);
        padding: 4px 12px;
        border-radius: 999px;
        margin-bottom: 10px;
        backdrop-filter: blur(4px);
    }

    .hero-result-title {
        font-size: 26px;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 6px;
        letter-spacing: -.02em;
    }

    .hero-result-sub {
        font-size: 13.5px;
        color: rgba(255, 255, 255, .85);
        margin: 0;
        line-height: 1.5;
    }

    .hero-result-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }

    .btn-action-white {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        color: var(--text-main);
        border: none;
        border-radius: 12px;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(0, 0, 0, .12);
        transition: all .2s ease;
        white-space: nowrap;
    }

    .btn-action-white:hover {
        background: #f8fafc;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, .16);
    }

    .btn-action-glass {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, .15);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, .3);
        border-radius: 12px;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        backdrop-filter: blur(4px);
        transition: all .2s ease;
        white-space: nowrap;
    }

    .btn-action-glass:hover {
        background: rgba(255, 255, 255, .25);
        transform: translateY(-2px);
        color: #ffffff;
    }

    /* ── VIOLATION WARNING BANNER ── */
    .violation-banner {
        background: #fef2f2;
        border: 1.5px solid #fca5a5;
        border-radius: 18px;
        padding: 18px 24px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 14px rgba(220, 38, 38, .08);
    }

    .violation-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: #fee2e2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .violation-title {
        font-size: 15px;
        font-weight: 800;
        color: #991b1b;
        margin: 0 0 3px;
    }

    .violation-desc {
        font-size: 13px;
        color: #b91c1c;
        margin: 0;
        line-height: 1.5;
    }

    /* ── STAT METRICS GRID ── */
    .stat-grid-result {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    @media (max-width: 992px) {
        .stat-grid-result { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 520px) {
        .stat-grid-result { grid-template-columns: 1fr; }
    }

    .stat-card-res {
        background: var(--card-bg);
        border: 1px solid var(--line);
        border-radius: 18px;
        padding: 18px 20px;
        box-shadow: var(--shadow-soft);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .stat-card-res:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 28px -4px rgba(15, 23, 42, .08);
    }

    .stat-icon-res {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .stat-icon-res.blue   { background: #eff6ff; color: #2563eb; }
    .stat-icon-res.green  { background: #ecfdf5; color: #059669; }
    .stat-icon-res.red    { background: #fef2f2; color: #dc2626; }
    .stat-icon-res.gray   { background: #f1f5f9; color: #64748b; }

    .stat-val-text {
        font-size: 22px;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 4px;
        color: var(--text-main);
    }

    .stat-label-text {
        font-size: 11px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    /* ── MAIN DETAIL CARD ── */
    .result-detail-card {
        background: var(--card-bg);
        border: 1px solid var(--line);
        border-radius: 20px;
        box-shadow: var(--shadow-soft);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .result-detail-head {
        padding: 18px 24px;
        background: #f8fafc;
        border-bottom: 1px solid var(--line);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .result-detail-title {
        font-size: 16px;
        font-weight: 800;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .result-question-list {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .res-q-box {
        border: 1px solid var(--line);
        border-radius: 16px;
        padding: 20px;
        background: #ffffff;
        box-shadow: 0 2px 8px rgba(15, 23, 42, .03);
    }

    .res-q-box.correct-box {
        border-left: 5px solid #10b981;
    }

    .res-q-box.wrong-box {
        border-left: 5px solid #ef4444;
    }

    .res-q-box.empty-box {
        border-left: 5px solid #94a3b8;
        background: #fafafa;
    }

    .res-q-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 14px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f1f5f9;
    }

    .res-q-number {
        font-size: 14px;
        font-weight: 800;
        color: var(--text-main);
    }

    .res-q-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 800;
        white-space: nowrap;
    }

    .res-q-badge.correct { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .res-q-badge.wrong   { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .res-q-badge.empty   { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }

    .res-q-text {
        font-size: 14.5px;
        font-weight: 600;
        color: #1e293b;
        line-height: 1.65;
        margin-bottom: 16px;
    }

    /* Notice for unanswered questions */
    .unanswered-banner {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 16px;
    }

    /* Option choices list */
    .res-options-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .res-option-row {
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        font-size: 13.5px;
        background: #ffffff;
    }

    .res-option-row.is-selected-wrong {
        border-color: #fca5a5;
        background: #fef2f2;
    }

    .res-option-row.is-selected-correct {
        border-color: #86efac;
        background: #f0fdf4;
    }

    .res-option-row.is-key-answer {
        border-color: #86efac;
        background: #f0fdf4;
    }

    .opt-tag-label {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
        white-space: nowrap;
        margin-left: 8px;
    }

    .opt-tag-label.tag-your-wrong { background: #fee2e2; color: #dc2626; }
    .opt-tag-label.tag-your-correct { background: #dcfce7; color: #166534; }
    .opt-tag-label.tag-key { background: #dcfce7; color: #166534; }
</style>
@endpush

@php
    $unansweredCount = $details->filter(fn($d) => $d['is_unanswered'])->count();
    $wrongCount = $details->filter(fn($d) => !$d['is_unanswered'] && !$d['is_correct'])->count();
    $correctCount = $attempt->correct_count;
@endphp

@section('content')
<div class="exam-result-wrap">

    {{-- BREADCRUMB --}}
    <nav class="result-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Beranda</a>
        <i class="fas fa-chevron-right" style="font-size: 10px; opacity: .5;"></i>
        <a href="{{ route('ujian.' . $jenis) }}">{{ strtoupper($jenis) }}</a>
        <i class="fas fa-chevron-right" style="font-size: 10px; opacity: .5;"></i>
        <span style="color: var(--text-main); font-weight: 700;">Hasil Ujian</span>
    </nav>

    {{-- HERO BANNER --}}
    <div class="hero-result">
        <div class="hero-result-content">
            <div class="hero-pill-tag">
                <i class="fas fa-award"></i> Lembar Hasil Ujian {{ strtoupper($jenis) }}
            </div>
            <h1 class="hero-result-title">{{ $subject->name }}</h1>
            <p class="hero-result-sub">
                Hasil pengerjaan dikirim pada {{ $attempt->submitted_at ? $attempt->submitted_at->translatedFormat('d F Y · H:i') : '-' }} WIB.
            </p>
        </div>
        <div class="hero-result-actions">
            <a href="{{ route('ujian.result.pdf', [$jenis, $subject, 'attempt' => $attempt->id]) }}" class="btn-action-white">
                <i class="fas fa-file-pdf text-danger"></i> Unduh PDF Hasil
            </a>
            <a href="{{ route('ujian.' . $jenis) }}" class="btn-action-glass">
                <i class="fas fa-arrow-left"></i> Kembali ke Portal {{ strtoupper($jenis) }}
            </a>
        </div>
    </div>

    {{-- VIOLATION ALERT BANNER --}}
    @if($isViolation)
        <div class="violation-banner">
            <div class="violation-icon"><i class="fas fa-triangle-exclamation"></i></div>
            <div>
                <h4 class="violation-title">Ujian Didiskualifikasi karena Pelanggaran Aturan</h4>
                <p class="violation-desc">
                    Sistem mendeteksi Anda keluar dari mode layar penuh atau berpindah aplikasi/tab browser sebanyak 3 kali saat ujian berlangsung. Nilai otomatis diberikan <strong>0.0 (Nol)</strong> dan soal yang tidak dijawab tetap tercatat sebagai <strong>Kosong</strong>.
                </p>
            </div>
        </div>
    @endif

    {{-- 4 STAT METRICS GRID --}}
    <div class="stat-grid-result">
        <div class="stat-card-res">
            <div class="stat-icon-res blue"><i class="fas fa-star"></i></div>
            <div>
                <div class="stat-val-text">{{ number_format((float) $attempt->score, 1) }} <span style="font-size: 13px; color: var(--text-muted); font-weight: 600;">/ {{ number_format((float) $attempt->max_score, 1) }}</span></div>
                <div class="stat-label-text">Skor Akhir Siswa</div>
            </div>
        </div>
        <div class="stat-card-res">
            <div class="stat-icon-res green"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="stat-val-text">{{ $correctCount }} <span style="font-size: 13px; color: var(--text-muted); font-weight: 600;">/ {{ $attempt->total_questions }}</span></div>
                <div class="stat-label-text">Jawaban Benar</div>
            </div>
        </div>
        <div class="stat-card-res">
            <div class="stat-icon-res red"><i class="fas fa-times-circle"></i></div>
            <div>
                <div class="stat-val-text">{{ $wrongCount }}</div>
                <div class="stat-label-text">Jawaban Salah</div>
            </div>
        </div>
        <div class="stat-card-res">
            <div class="stat-icon-res gray"><i class="fas fa-minus-circle"></i></div>
            <div>
                <div class="stat-val-text">{{ $unansweredCount }}</div>
                <div class="stat-label-text">Tidak Dijawab (Kosong)</div>
            </div>
        </div>
    </div>

    {{-- DETAIL PERTANYAAN & JAWABAN CARD --}}
    <div class="result-detail-card">
        <div class="result-detail-head">
            <div class="result-detail-title">
                <i class="fas fa-list-check text-primary"></i>
                <span>Detail Jawaban Setiap Soal</span>
            </div>
            <div style="font-size: 12.5px; color: var(--text-muted); font-weight: 600;">
                Total: {{ $attempt->total_questions }} Soal
            </div>
        </div>

        <div class="result-question-list">
            @forelse($details as $index => $detail)
                @php
                    $q = $detail['question'];
                    $selected = $detail['selected'];
                    $correct = $detail['correct'];
                    $isUnanswered = $detail['is_unanswered'];
                    $isCorrect = $detail['is_correct'];

                    $boxClass = 'empty-box';
                    if (!$isUnanswered) {
                        $boxClass = $isCorrect ? 'correct-box' : 'wrong-box';
                    }
                @endphp

                <div class="res-q-box {{ $boxClass }}">
                    <div class="res-q-head">
                        <div class="res-q-number">
                            <span>Nomor {{ $index + 1 }}</span>
                            <span style="font-size: 12px; color: var(--text-muted); font-weight: 600; margin-left: 8px;">({{ (int) $q->points }} Poin)</span>
                        </div>

                        <div>
                            @if($isUnanswered)
                                <span class="res-q-badge empty">
                                    <i class="fas fa-minus-circle"></i> Tidak Dijawab (Kosong)
                                </span>
                            @elseif($isCorrect)
                                <span class="res-q-badge correct">
                                    <i class="fas fa-check-circle"></i> Benar
                                </span>
                            @else
                                <span class="res-q-badge wrong">
                                    <i class="fas fa-times-circle"></i> Salah
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Pertanyaan --}}
                    <div class="res-q-text">
                        {!! nl2br(e($q->question)) !!}
                    </div>

                    {{-- Banner Jika Tidak Dijawab --}}
                    @if($isUnanswered)
                        <div class="unanswered-banner">
                            <i class="fas fa-info-circle text-secondary"></i>
                            <span>Anda tidak menjawab soal ini saat ujian berlangsung (tetap kosong).</span>
                        </div>
                    @endif

                    {{-- Pilihan Jawaban --}}
                    <div class="res-options-list">
                        @foreach(['a', 'b', 'c', 'd'] as $optionKey)
                            @php
                                $isThisSelected = ($selected === $optionKey);
                                $isThisKey = ($correct === $optionKey);

                                $rowClass = '';
                                if ($isThisSelected && $isCorrect) {
                                    $rowClass = 'is-selected-correct';
                                } elseif ($isThisSelected && !$isCorrect) {
                                    $rowClass = 'is-selected-wrong';
                                } elseif ($isThisKey && !$isUnanswered) {
                                    $rowClass = 'is-key-answer';
                                }
                            @endphp

                            <div class="res-option-row {{ $rowClass }}">
                                <div>
                                    <strong style="margin-right: 6px;">{{ strtoupper($optionKey) }}.</strong>
                                    <span>{{ $q->options[$optionKey] ?? '-' }}</span>
                                </div>

                                <div>
                                    @if($isThisSelected && $isCorrect)
                                        <span class="opt-tag-label tag-your-correct">
                                            <i class="fas fa-check"></i> Jawaban kamu (Benar)
                                        </span>
                                    @elseif($isThisSelected && !$isCorrect)
                                        <span class="opt-tag-label tag-your-wrong">
                                            <i class="fas fa-times"></i> Jawaban kamu (Salah)
                                        </span>
                                    @elseif($isThisKey)
                                        <span class="opt-tag-label tag-key">
                                            <i class="fas fa-key"></i> Kunci Jawaban
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div style="text-align: center; color: var(--text-muted); padding: 36px;">
                    Detail lembar jawaban tidak tersedia.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
