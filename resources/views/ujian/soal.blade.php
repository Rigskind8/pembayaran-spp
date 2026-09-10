{{-- resources/views/ujian/soal.blade.php --}}
@extends('layouts.app')

@section('title', 'Pengerjaan Ujian ' . strtoupper($jenis) . ' - ' . $subject->name)

@push('styles')
<style>
    /* ── FULL SCREEN DISTRACTION-FREE CBT OVERRIDES ── */
    .sb, #mobile-topbar, #realtime-clock, .wa-float, .skip-link, #welcome-modal {
        display: none !important;
    }
    body {
        background: #f8fafc !important;
        color: #0f172a !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow-x: hidden;
        user-select: none;
        -webkit-user-select: none;
    }
    #main-content, .main {
        margin-left: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 !important;
        transition: none !important;
    }

    /* ── CBT TOPBAR ── */
    .cbt-topbar {
        position: sticky;
        top: 0;
        z-index: 1000;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(15, 23, 42, .06);
        padding: 12px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .cbt-brand {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .cbt-brand-badge {
        background: {{ $jenis === 'uas' ? '#7c3aed' : '#2563eb' }};
        color: #ffffff;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
        padding: 5px 12px;
        border-radius: 8px;
    }

    .cbt-subject-name {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        line-height: 1.2;
    }

    .cbt-subject-meta {
        font-size: 12px;
        color: #64748b;
        margin-top: 2px;
    }

    /* Timer in Topbar */
    .cbt-timer-container {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 6px 16px;
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
    }

    .cbt-timer-container.warning {
        background: #fffbeb;
        border-color: #fde68a;
        color: #b45309;
        animation: pulseTimer 1.5s infinite;
    }

    .cbt-timer-container.expired {
        background: #fef2f2;
        border-color: #fecaca;
        color: #dc2626;
    }

    @keyframes pulseTimer {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
    }

    .timer-icon {
        font-size: 16px;
        color: {{ $jenis === 'uas' ? '#7c3aed' : '#2563eb' }};
    }

    .timer-val {
        font-family: 'DM Mono', monospace, sans-serif;
        font-size: 17px;
        letter-spacing: .04em;
    }

    /* Topbar Right Actions */
    .cbt-topbar-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .cbt-progress-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1d4ed8;
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
    }

    .btn-finish-exam {
        background: #10b981;
        color: #ffffff;
        border: none;
        border-radius: 10px;
        padding: 8px 18px;
        font-size: 13px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all .15s ease;
        box-shadow: 0 4px 12px rgba(16, 185, 129, .25);
    }

    .btn-finish-exam:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    /* ── CBT LAYOUT (QUESTIONS & PALETTE) ── */
    .cbt-body-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 24px;
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 24px;
        align-items: flex-start;
    }

    @media (max-width: 992px) {
        .cbt-body-container {
            grid-template-columns: 1fr;
            padding: 16px;
        }
    }

    /* ── QUESTION CARD ── */
    .question-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .q-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 24px 28px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, .04);
        scroll-margin-top: 90px;
        transition: border-color .2s ease;
    }

    .q-card.answered {
        border-left: 5px solid #10b981;
    }

    .q-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .q-number-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
    }

    .q-points-badge {
        font-size: 11px;
        font-weight: 700;
        background: #f1f5f9;
        color: #475569;
        padding: 3px 10px;
        border-radius: 6px;
    }

    .q-text-body {
        font-size: 15px;
        font-weight: 600;
        color: #1e293b;
        line-height: 1.7;
        margin-bottom: 20px;
        word-break: break-word;
    }

    /* OPTIONS (PILIHAN JAWABAN) */
    .options-grid {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .option-item-label {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 14px 18px;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        background: #ffffff;
        cursor: pointer;
        transition: all .15s ease;
    }

    .option-item-label:hover {
        border-color: #93c5fd;
        background: #f8fbff;
        transform: translateX(2px);
    }

    .option-item-label.selected {
        border-color: #2563eb;
        background: #eff6ff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, .08);
    }

    .option-radio {
        display: none;
    }

    .option-key-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #334155;
        font-weight: 800;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all .15s ease;
    }

    .option-item-label.selected .option-key-circle {
        background: #2563eb;
        color: #ffffff;
    }

    .option-text {
        font-size: 14px;
        font-weight: 500;
        color: #1e293b;
        line-height: 1.6;
        padding-top: 4px;
        flex: 1;
    }

    .option-item-label.selected .option-text {
        color: #0f172a;
        font-weight: 600;
    }

    /* ── QUESTION PALETTE (STICKY SIDEBAR) ── */
    .cbt-palette-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 20px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, .04);
        position: sticky;
        top: 86px;
    }

    .palette-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .palette-title {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .palette-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 8px;
        margin-bottom: 20px;
    }

    .palette-btn {
        width: 100%;
        aspect-ratio: 1;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        font-size: 13px;
        font-weight: 800;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all .15s ease;
    }

    .palette-btn:hover {
        border-color: #2563eb;
        color: #2563eb;
        background: #eff6ff;
    }

    .palette-btn.done {
        background: #10b981;
        border-color: #10b981;
        color: #ffffff;
    }

    .palette-legend {
        display: flex;
        align-items: center;
        justify-content: space-around;
        gap: 8px;
        font-size: 11.5px;
        font-weight: 600;
        color: #64748b;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 3px;
    }

    .legend-dot.done { background: #10b981; }
    .legend-dot.undone { background: #e2e8f0; border: 1px solid #cbd5e1; }

    /* ── FULLSCREEN ENTRY GATE OVERLAY ── */
    .fs-gate-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, .92);
        backdrop-filter: blur(8px);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .fs-gate-card {
        background: #ffffff;
        border-radius: 24px;
        max-width: 520px;
        width: 100%;
        padding: 36px 32px;
        text-align: center;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, .5);
        animation: gateFadeUp .3s ease;
    }

    @keyframes gateFadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .fs-gate-icon {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        margin: 0 auto 20px;
    }

    .fs-gate-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
    }

    .fs-gate-sub {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 24px;
    }

    .fs-gate-rules {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
        text-align: left;
        margin-bottom: 24px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        font-size: 12.5px;
        color: #334155;
    }

    .btn-enter-fs {
        width: 100%;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #ffffff;
        border: none;
        border-radius: 14px;
        padding: 14px 24px;
        font-size: 15px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        box-shadow: 0 10px 24px rgba(37, 99, 235, .3);
        transition: all .2s ease;
    }

    .btn-enter-fs:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(37, 99, 235, .4);
    }

    /* ── CONFIRM SUBMIT MODAL ── */
    .modal-submit-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, .75);
        backdrop-filter: blur(4px);
        z-index: 100000;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-submit-box {
        background: #ffffff;
        border-radius: 20px;
        max-width: 460px;
        width: 100%;
        padding: 28px;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0,0,0,.3);
    }

    .modal-submit-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        background: #ecfdf5;
        color: #10b981;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        margin: 0 auto 16px;
    }

    .modal-submit-box h4 {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .modal-submit-box p {
        font-size: 13.5px;
        color: #64748b;
        margin-bottom: 24px;
        line-height: 1.5;
    }
</style>
@endpush

@section('content')

{{-- 1. FULLSCREEN ENTRY GATE (Wajib Klik untuk mengaktifkan Fullscreen Browser) --}}
<div id="fullscreenGate" class="fs-gate-overlay">
    <div class="fs-gate-card">
        <div class="fs-gate-icon">
            <i class="fas fa-expand"></i>
        </div>
        <h2 class="fs-gate-title">Ujian Siap Dimulai</h2>
        <p class="fs-gate-sub">
            {{ $subject->name }} · {{ strtoupper($jenis) }} (Kelas {{ $subject->class_id ?? '-' }})
        </p>

        <div class="fs-gate-rules">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-check-circle text-success"></i>
                <span>Tampilan akan otomatis beralih ke <strong>Layar Penuh (Full Screen)</strong>.</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-eye-slash text-primary"></i>
                <span>Hanya menampilkan <strong>soal dan pilihan jawaban</strong> tanpa gangguan menu.</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-triangle-exclamation text-danger"></i>
                <span>Dilarang menekan tombol keluar (ESC), membuka tab lain, atau membuka aplikasi luar.</span>
            </div>
        </div>

        <button type="button" id="btnEnterFullscreen" class="btn-enter-fs">
            <i class="fas fa-play"></i> Mulai Ujian & Masuk Layar Penuh
        </button>
    </div>
</div>

{{-- 2. STICKY CBT HEADER (Fokus, Bersih, Menampilkan Timer & Status) --}}
<div class="cbt-topbar">
    <div class="cbt-brand">
        <span class="cbt-brand-badge">{{ strtoupper($jenis) }}</span>
        <div>
            <h1 class="cbt-subject-name">{{ $subject->name }}</h1>
            <div class="cbt-subject-meta">
                Kelas {{ $subject->class_id ?? '-' }} · {{ $questions->count() }} Butir Soal
            </div>
        </div>
    </div>

    {{-- SISA WAKTU / COUNTDOWN TIMER --}}
    <div class="cbt-timer-container {{ $timeExpired ? 'expired' : '' }}" id="cbtTimerContainer" data-ends-at="{{ $endsAt->toIso8601String() }}">
        <i class="fas fa-stopwatch timer-icon"></i>
        <span>Sisa Waktu:</span>
        <span class="timer-val" id="cbtTimerVal">{{ $timeExpired ? '00:00' : 'Memuat...' }}</span>
    </div>

    {{-- KANAN: PROGRESS & TOMBOL SELESAI --}}
    <div class="cbt-topbar-actions">
        <div class="cbt-progress-pill">
            <i class="fas fa-check-circle"></i>
            <span>Terjawab: <strong id="answeredCountText">0</strong> / {{ $questions->count() }}</span>
        </div>
        <button type="button" class="btn-finish-exam" id="btnOpenSubmitModal" {{ $timeExpired ? 'disabled' : '' }}>
            <i class="fas fa-paper-plane"></i> Kirim Jawaban
        </button>
    </div>
</div>

{{-- 3. CBT BODY: HANYA SOAL & PILIHAN JAWABAN + PALET NOMOR --}}
<div class="cbt-body-container">
    {{-- AREA SOAL & PILIHAN --}}
    <div class="cbt-questions-area">
        @if(session('error'))
            <div class="alert alert-danger" style="border-radius: 14px; font-weight: 700; margin-bottom: 20px;">
                <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            </div>
        @endif
        @if($timeExpired)
            <div class="alert alert-danger" style="border-radius: 14px; font-weight: 700; margin-bottom: 20px;">
                <i class="fas fa-clock me-2"></i> Waktu pengerjaan telah berakhir. Jawaban Anda tidak dapat dikirim lagi.
            </div>
        @endif

        <form id="examSubmitForm" action="{{ route('ujian.submit', [$jenis, $subject]) }}" method="POST">
            @csrf
            <div class="question-list">
                @foreach($questions as $index => $question)
                    @php
                        $optionOrder = $optionOrders[$question->id] ?? ['a', 'b', 'c', 'd'];
                    @endphp
                    <div class="q-card" id="questionCard_{{ $question->id }}" data-qid="{{ $question->id }}" data-index="{{ $index + 1 }}">
                        <div class="q-card-head">
                            <div class="q-number-badge">
                                <span>Nomor {{ $index + 1 }}</span>
                            </div>
                            <span class="q-points-badge">{{ (int) $question->points }} Poin</span>
                        </div>

                        {{-- Teks Soal --}}
                        <div class="q-text-body">
                            {!! nl2br(e($question->question)) !!}
                        </div>

                        {{-- Pilihan Jawaban --}}
                        <div class="options-grid">
                            @foreach($optionOrder as $key)
                                <label class="option-item-label" id="optionLabel_{{ $question->id }}_{{ $key }}">
                                    <input type="radio" 
                                           class="option-radio" 
                                           name="answers[{{ $question->id }}]" 
                                           value="{{ $key }}" 
                                           data-qid="{{ $question->id }}"
                                           data-index="{{ $index + 1 }}"
                                           {{ $timeExpired ? 'disabled' : '' }}>
                                    <div class="option-key-circle">{{ strtoupper($key) }}</div>
                                    <div class="option-text">{{ $question->options[$key] ?? '-' }}</div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Tombol Bawah --}}
            <div class="d-flex justify-content-between align-items-center mt-4 p-3 bg-white border rounded-4 shadow-sm">
                <span class="text-muted" style="font-size: 13px; font-weight: 600;">
                    <i class="fas fa-shield-alt text-primary me-1"></i> Pastikan seluruh soal telah Anda jawab dengan teliti.
                </span>
                <button type="button" class="btn-finish-exam" onclick="document.getElementById('btnOpenSubmitModal').click()" {{ $timeExpired ? 'disabled' : '' }}>
                    <i class="fas fa-paper-plane"></i> Selesai & Kirim Ujian
                </button>
            </div>
        </form>
    </div>

    {{-- PALET NOMOR SOAL (STICKY DI KANAN) --}}
    <div class="cbt-sidebar-area">
        <div class="cbt-palette-card">
            <div class="palette-head">
                <h3 class="palette-title"><i class="fas fa-th me-2 text-primary"></i> Palet Nomor Soal</h3>
                <span class="badge bg-light text-secondary border" style="font-size: 11px;">{{ $questions->count() }} Soal</span>
            </div>

            <div class="palette-grid">
                @foreach($questions as $index => $question)
                    <button type="button" 
                            class="palette-btn" 
                            id="paletteBtn_{{ $question->id }}" 
                            onclick="scrollToQuestion('{{ $question->id }}')" 
                            title="Lompat ke Soal Nomor {{ $index + 1 }}">
                        {{ $index + 1 }}
                    </button>
                @endforeach
            </div>

            <div class="palette-legend">
                <div class="legend-item">
                    <span class="legend-dot done"></span>
                    <span>Sudah Dijawab</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot undone"></span>
                    <span>Belum</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI PENGIRIMAN JAWABAN --}}
<div class="modal-submit-overlay" id="confirmSubmitModal">
    <div class="modal-submit-box">
        <div class="modal-submit-icon">
            <i class="fas fa-clipboard-check"></i>
        </div>
        <h4>Kirim Lembar Jawaban?</h4>
        <p id="confirmSubmitDesc">
            Anda telah menjawab <strong id="confirmAnsweredCount">0</strong> dari <strong>{{ $questions->count() }}</strong> soal. Jawaban yang telah dikirim tidak dapat diubah kembali.
        </p>
        <div class="d-flex justify-content-center gap-2">
            <button type="button" class="btn btn-light px-4 py-2" style="border-radius: 12px; font-weight: 700; font-size: 13px;" onclick="closeConfirmModal()">
                Periksa Kembali
            </button>
            <button type="button" class="btn btn-success px-4 py-2" id="btnFinalSubmit" style="border-radius: 12px; font-weight: 800; font-size: 13px; background: #10b981; border: none;">
                <i class="fas fa-check me-1"></i> Ya, Kirim Sekarang
            </button>
        </div>
    </div>
</div>

{{-- CONFETTI & AUDIO PRELOAD --}}
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

@push('scripts')
<script>
    (function () {
        // --- AUDIO PRELOAD ---
        const audioKelar = new Audio('{{ asset("audio/prabowo.mp3") }}');
        const audioCurang = new Audio('{{ asset("audio/antek-asing.mp3") }}');
        audioKelar.load();
        audioCurang.load();

        const form = document.getElementById('examSubmitForm');
        const timerContainer = document.getElementById('cbtTimerContainer');
        const timerVal = document.getElementById('cbtTimerVal');
        const answeredCountText = document.getElementById('answeredCountText');
        const fsGate = document.getElementById('fullscreenGate');
        const btnEnterFs = document.getElementById('btnEnterFullscreen');
        const confirmModal = document.getElementById('confirmSubmitModal');
        const btnOpenSubmit = document.getElementById('btnOpenSubmitModal');
        const btnFinalSubmit = document.getElementById('btnFinalSubmit');
        const totalQuestions = {{ $questions->count() }};

        // --- FULLSCREEN FUNCTION ---
        function requestFullScreenMode() {
            const elem = document.documentElement;
            if (elem.requestFullscreen) {
                elem.requestFullscreen().catch(err => {
                    console.log('Fullscreen rejected or handled:', err);
                });
            } else if (elem.webkitRequestFullscreen) {
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            }
            if (fsGate) {
                fsGate.style.display = 'none';
            }
        }

        if (btnEnterFs) {
            btnEnterFs.addEventListener('click', function () {
                requestFullScreenMode();
            });
        }

        // --- COUNTDOWN TIMER ---
        const endAtRaw = timerContainer ? timerContainer.dataset.endsAt : null;
        let timerInterval = null;

        if (endAtRaw && timerVal) {
            const endAt = new Date(endAtRaw).getTime();

            function pad(n) { return String(n).padStart(2, '0'); }

            function updateTimer() {
                const now = Date.now();
                const diff = endAt - now;

                if (diff <= 0) {
                    timerVal.textContent = '00:00';
                    timerContainer.classList.add('expired');
                    if (btnOpenSubmit) btnOpenSubmit.disabled = true;

                    // Disable inputs
                    const inputs = form.querySelectorAll('input[type="radio"]');
                    inputs.forEach(i => i.disabled = true);

                    clearInterval(timerInterval);
                    alert("Waktu ujian telah habis. Lembar jawaban Anda otomatis dikirim ke sistem.");
                    form.submit();
                    return;
                }

                const totalSec = Math.floor(diff / 1000);
                const hours = Math.floor(totalSec / 3600);
                const minutes = Math.floor((totalSec % 3600) / 60);
                const seconds = totalSec % 60;

                if (totalSec <= 300) { // Sisa 5 menit
                    timerContainer.classList.add('warning');
                }

                if (hours > 0) {
                    timerVal.textContent = `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
                } else {
                    timerVal.textContent = `${pad(minutes)}:${pad(seconds)}`;
                }
            }

            updateTimer();
            timerInterval = setInterval(updateTimer, 1000);
        }

        // --- RADIO ANSWER TRACKING & PALETTE SYNC ---
        function updateAnswerStatus() {
            const answeredQids = new Set();
            const checkedRadios = form.querySelectorAll('input[type="radio"]:checked');

            // Reset labels highlight
            form.querySelectorAll('.option-item-label').forEach(label => {
                label.classList.remove('selected');
            });

            checkedRadios.forEach(radio => {
                answeredQids.add(radio.dataset.qid);
                const parentLabel = radio.closest('.option-item-label');
                if (parentLabel) {
                    parentLabel.classList.add('selected');
                }
            });

            // Update card border & palette button
            document.querySelectorAll('.q-card').forEach(card => {
                const qid = card.dataset.qid;
                const paletteBtn = document.getElementById('paletteBtn_' + qid);
                if (answeredQids.has(qid)) {
                    card.classList.add('answered');
                    if (paletteBtn) paletteBtn.classList.add('done');
                } else {
                    card.classList.remove('answered');
                    if (paletteBtn) paletteBtn.classList.remove('done');
                }
            });

            if (answeredCountText) {
                answeredCountText.textContent = answeredQids.size;
            }

            const confirmCount = document.getElementById('confirmAnsweredCount');
            if (confirmCount) {
                confirmCount.textContent = answeredQids.size;
            }
        }

        form.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', updateAnswerStatus);
        });

        // Initialize state
        updateAnswerStatus();

        // Smooth scroll to question
        window.scrollToQuestion = function (qid) {
            const card = document.getElementById('questionCard_' + qid);
            if (card) {
                card.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        };

        // --- CONFIRM SUBMIT MODAL ---
        if (btnOpenSubmit && confirmModal) {
            btnOpenSubmit.addEventListener('click', function () {
                confirmModal.style.display = 'flex';
            });
        }

        window.closeConfirmModal = function () {
            if (confirmModal) {
                confirmModal.style.display = 'none';
            }
        };

        // Final submit with Audio & Confetti
        if (btnFinalSubmit) {
            btnFinalSubmit.addEventListener('click', function () {
                if (form.dataset.submitting) return;
                form.dataset.submitting = 'true';

                btnFinalSubmit.disabled = true;
                btnFinalSubmit.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Mengirim Jawaban...';

                // Play Audio
                audioKelar.play().catch(e => console.log('Audio blocked:', e));

                // Confetti
                if (typeof confetti === 'function') {
                    confetti({
                        particleCount: 200,
                        spread: 90,
                        origin: { y: 0.6 }
                    });
                }

                // Delay 2.5 detik agar suara selesai lalu submit form
                setTimeout(() => {
                    form.submit();
                }, 2500);
            });
        }

        // --- SISTEM ANTI-CHEAT (FULLSCREEN & TAB VISIBILITY) ---
        let violationCount = 0;
        const maxViolations = 3;

        function playCheatAlarm() {
            audioCurang.play().catch(e => console.log('Audio curang blocked:', e));
        }

        // 1. Deteksi keluar Fullscreen
        document.addEventListener('fullscreenchange', function () {
            // Hanya deteksi jika gate sudah ditutup dan ujian belum selesai
            if (fsGate && fsGate.style.display === 'none' && !form.dataset.submitting) {
                if (!document.fullscreenElement) {
                    violationCount++;
                    playCheatAlarm();

                    setTimeout(() => {
                        if (violationCount >= maxViolations) {
                            alert("🚨 KECURANGAN TERDETEKSI! 🚨\n\nAnda telah keluar dari layar penuh sebanyak " + maxViolations + " kali. Lembar jawaban Anda dikirim otomatis.");
                            form.submit();
                        } else {
                            alert("⚠️ PERINGATAN KECURANGAN (" + violationCount + "/" + maxViolations + ") ⚠️\n\nAnda terdeteksi keluar dari Fullscreen (Menekan ESC)! Klik OK untuk kembali ke mode layar penuh.");
                            requestFullScreenMode();
                        }
                    }, 1000);
                }
            }
        });

        // 2. Deteksi pindah tab / aplikasi
        document.addEventListener('visibilitychange', function () {
            if (document.hidden && !form.dataset.submitting && fsGate && fsGate.style.display === 'none') {
                violationCount++;
                playCheatAlarm();

                setTimeout(() => {
                    if (violationCount >= maxViolations) {
                        alert("🚨 KECURANGAN TERDETEKSI! 🚨\n\nAnda telah berpindah tab sebanyak " + maxViolations + " kali. Ujian diakhiri otomatis.");
                        form.submit();
                    } else {
                        alert("⚠️ PERINGATAN KECURANGAN (" + violationCount + "/" + maxViolations + ") ⚠️\n\nAnda terdeteksi berpindah tab atau mengecilkan browser! Dilarang meninggalkan halaman ujian.");
                    }
                }, 1000);
            }
        });

        // 3. Mencegah Klik Kanan, Copy, Cut, dan Shortcut Pengembang
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('copy', e => e.preventDefault());
        document.addEventListener('cut', e => e.preventDefault());
        document.addEventListener('keydown', function (e) {
            // Cegah F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U
            if (e.key === 'F12' || 
               (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C')) || 
               (e.ctrlKey && e.key === 'u')) {
                e.preventDefault();
            }
        });
    })();
</script>
@endpush
@endsection