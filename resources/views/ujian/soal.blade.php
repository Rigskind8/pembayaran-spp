@extends('layouts.app')

@section('title', 'Soal Ujian ' . strtoupper($jenis) . ' - Paramount')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
body{font-family:'Plus Jakarta Sans',sans-serif;background:#f4f6fa;color:#111827;}
.app{display:flex;min-height:100vh;}
.main{margin-left:var(--sb,250px);flex:1;display:flex;flex-direction:column;}
.page{padding:28px;}
.hero{background:linear-gradient(120deg,#0f172a,#1d4ed8 55%,#4f46e5);color:#fff;border-radius:18px;padding:24px 28px;display:flex;justify-content:space-between;gap:16px;align-items:center;margin-bottom:20px;box-shadow:0 10px 26px rgba(37,99,235,.16);}
.hero h1{font-size:24px;font-weight:800;}
.hero p{font-size:13px;color:rgba(255,255,255,.7);margin-top:4px;}
.pill{display:inline-flex;align-items:center;gap:6px;padding:7px 12px;border-radius:999px;background:rgba(255,255,255,.12);font-size:12px;font-weight:700;}
.grid{display:grid;grid-template-columns:1fr 360px;gap:18px;}
.card{background:#fff;border:1px solid #e8eaf0;border-radius:16px;box-shadow:0 1px 3px rgba(0,0,0,.06),0 2px 8px rgba(0,0,0,.04);overflow:hidden;}
.card-head{padding:16px 18px;border-bottom:1px solid #e8eaf0;background:#fafbff;display:flex;justify-content:space-between;align-items:flex-start;gap:10px;}
.card-title{font-size:15px;font-weight:800;}
.card-sub{font-size:11.5px;color:#6b7280;margin-top:3px;}
.content{padding:18px;display:grid;gap:14px;}
.question{border:1px solid #e8eaf0;border-radius:14px;padding:16px;background:#fff;}
.q-top{display:flex;justify-content:space-between;gap:10px;align-items:center;margin-bottom:10px;}
.q-no{font-size:12px;font-weight:800;color:#2563eb;}
.q-text{font-size:14px;font-weight:700;line-height:1.6;margin-bottom:12px;}
.opt{display:grid;gap:8px;}
.opt label{display:flex;gap:10px;align-items:flex-start;padding:10px 12px;border:1px solid #e8eaf0;border-radius:12px;cursor:pointer;transition:.15s;}
.opt label:hover{border-color:#bfdbfe;background:#eff6ff;}
.opt input{margin-top:3px;}
.opt .text{font-size:13px;color:#111827;line-height:1.5;}
.summary{padding:18px;display:grid;gap:12px;}
.box{background:#f8fafc;border:1px solid #e2e8f0;border-radius:14px;padding:14px;}
.box .k{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.06em;color:#64748b;}
.box .v{font-size:17px;font-weight:800;margin-top:4px;}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;border:none;border-radius:12px;padding:12px 16px;font-size:13px;font-weight:800;cursor:pointer;text-decoration:none;}
.btn-primary{background:#2563eb;color:#fff;}
.btn-secondary{background:#fff;color:#0f172a;border:1px solid #cbd5e1;}
.alert{padding:14px 16px;border-radius:14px;margin-bottom:18px;font-weight:700;}
.alert.success{background:#ecfdf5;border:1px solid #bbf7d0;color:#166534;}
.alert.error{background:#fef2f2;border:1px solid #fecaca;color:#991b1b;}
.result{background:#eff6ff;border:1px solid #bfdbfe;border-radius:14px;padding:14px;}
.result .t{font-size:12px;font-weight:800;color:#2563eb;text-transform:uppercase;letter-spacing:.06em;}
.result .n{font-size:26px;font-weight:900;color:#1d4ed8;margin-top:4px;}
.timer-box{display:inline-flex;align-items:center;gap:8px;padding:10px 14px;border-radius:12px;background:#fffbeb;border:1px solid #fde68a;color:#b45309;font-weight:800;font-size:13px;}
.timer-box.expired{background:#fef2f2;border-color:#fecaca;color:#b91c1c;}
@media(max-width:960px){.grid{grid-template-columns:1fr;} .hero{flex-direction:column;align-items:flex-start;} }
@media(max-width:900px){.main{margin-left:0;}}
@media(max-width:640px){.page{padding:16px;}}
</style>

<div class="app">
    @include('partials.sidebar')
    <div class="main">
        <div class="page">
            <div class="hero">
                <div>
                    <div class="pill"><i class="fas fa-pen-to-square"></i> Soal Ujian {{ strtoupper($jenis) }}</div>
                    <h1>{{ $subject->name }}</h1>
                    <p>{{ $subject->class_id ? 'Kelas ' . $subject->class_id : 'Soal umum' }} · {{ $questions->count() }} pertanyaan</p>
                </div>
                <div class="pill"><i class="fas fa-receipt"></i> Pembayaran verified</div>
            </div>

            @if(session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert error">{{ session('error') }}</div>
            @endif
            @if($timeExpired)
                <div class="alert error">Waktu ujian telah habis. Kamu tidak bisa mengirim jawaban lagi dari sesi ini.</div>
            @endif

                        @if($latestAttempt)
                            <div class="alert success">Ujian ini sudah kamu kerjakan. Sistem tidak mengizinkan pengerjaan ulang untuk mapel dan tipe ujian yang sama.</div>
                        @endif

            <div class="grid">
                <div class="card">
                    <div class="card-head">
                        <div>
                            <div class="card-title">Kerjakan Soal</div>
                            <div class="card-sub">Pilih jawaban yang paling benar. Jawaban akan dinilai otomatis.</div>
                        </div>
                        <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center; justify-content:flex-end;">
                            <div class="timer-box {{ $timeExpired ? 'expired' : '' }}" id="timerBox" data-ends-at="{{ $endsAt->toIso8601String() }}">
                                <i class="fas fa-stopwatch"></i>
                                <span id="timerText">{{ $timeExpired ? 'Waktu habis' : 'Menghitung...' }}</span>
                            </div>
                            <a href="{{ route('ujian.' . $jenis) }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                        </div>
                    </div>
                    <form id="examForm" action="{{ route('ujian.submit', [$jenis, $subject]) }}" method="POST">
                        @csrf
                        <div class="content">
                            @foreach($questions as $index => $question)
                                @php
                                    $optionOrder = $optionOrders[$question->id] ?? ['a', 'b', 'c', 'd'];
                                @endphp
                                <div class="question">
                                    <div class="q-top">
                                        <div class="q-no">Soal {{ $index + 1 }}</div>
                                        <span class="pill" style="background:#eff6ff;color:#2563eb;"><i class="fas fa-star"></i> {{ (int) $question->points }} poin</span>
                                    </div>
                                    <div class="q-text">{{ $question->question }}</div>
                                    <div class="opt">
                                        @foreach($optionOrder as $key)
                                            <label>
                                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}" {{ $timeExpired ? 'disabled' : '' }}>
                                                <div class="text"><strong>{{ strtoupper($key) }}.</strong> {{ $question->options[$key] ?? '-' }}</div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            <button type="submit" class="btn btn-primary" id="submitExamBtn" {{ $timeExpired ? 'disabled' : '' }}><i class="fas fa-paper-plane"></i> Kirim Jawaban</button>
                        </div>
                    </form>
                </div>

                <div class="card">
                    <div class="card-head">
                        <div>
                            <div class="card-title">Ringkasan Ujian</div>
                            <div class="card-sub">Status pembayaran dan hasil terbaru</div>
                        </div>
                    </div>
                    <div class="summary">
                        <div class="box"><div class="k">Status Pembayaran</div><div class="v">{{ ucfirst($payment->status) }}</div></div>
                        <div class="box"><div class="k">Tanggal Bayar</div><div class="v" style="font-size:15px;">{{ $payment->verified_at?->format('d M Y H:i') ?? $payment->created_at->format('d M Y H:i') }}</div></div>
                        <div class="box"><div class="k">Bukti</div><div class="v" style="font-size:15px;">{{ $payment->bukti ? 'Tersedia' : 'Tidak ada' }}</div></div>

                        @if($latestAttempt)
                            <div class="result">
                                <div class="t">Nilai Terakhir</div>
                                <div class="n">{{ number_format((float) $latestAttempt->score, 1) }} / {{ number_format((float) $latestAttempt->max_score, 1) }}</div>
                                <div style="margin-top:8px;font-size:12px;color:#1d4ed8;line-height:1.6;">Benar {{ $latestAttempt->correct_count }} dari {{ $latestAttempt->total_questions }} soal.</div>
                                <a href="{{ route('ujian.result', [$jenis, $subject, 'attempt' => $latestAttempt->id]) }}" class="btn btn-secondary" style="margin-top:10px;">Lihat Hasil Detail</a>
                            </div>
                        @else
                            <div class="box"><div class="k">Hasil Terakhir</div><div class="v" style="font-size:15px;">Belum ada pengiriman jawaban</div></div>
                        @endif

                        <div class="box" style="background:#f8fafc;"><div class="k">Petunjuk</div><div style="font-size:13px;line-height:1.6;color:#334155;margin-top:6px;">Pastikan semua jawaban terpilih sebelum mengirim. Setelah submit, sistem akan menghitung nilai secara otomatis.</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
    (function () {
        // --- PRELOAD AUDIO BIAR GAK TELAT/ERROR ---
        const audioKelar = new Audio('{{ asset("audio/prabowo.mp3") }}');
        const audioCurang = new Audio('{{ asset("audio/antek-asing.mp3") }}');
        audioKelar.load(); // Paksa browser download duluan di background
        audioCurang.load();

        const timerBox = document.getElementById('timerBox');
        const timerText = document.getElementById('timerText');
        const submitBtn = document.getElementById('submitExamBtn');
        const form = document.getElementById('examForm');

        if (!timerBox || !timerText || !submitBtn) {
            return;
        }

        const endAtRaw = timerBox.dataset.endsAt;
        if (!endAtRaw) {
            return;
        }

        const endAt = new Date(endAtRaw).getTime();
        if (Number.isNaN(endAt)) {
            return;
        }

        function pad(value) {
            return String(value).padStart(2, '0');
        }

        function updateTimer() {
            const now = Date.now();
            const diff = endAt - now;

            if (diff <= 0) {
                timerText.textContent = 'Waktu habis';
                timerBox.classList.add('expired');
                submitBtn.disabled = true;

                const inputs = form.querySelectorAll('input[type="radio"]');
                inputs.forEach((input) => {
                    input.disabled = true;
                });

                return false;
            }

            const totalSeconds = Math.floor(diff / 1000);
            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;
            timerText.textContent = `${pad(minutes)}:${pad(seconds)}`;

            return true;
        }

        if (updateTimer()) {
            const interval = setInterval(() => {
                if (!updateTimer()) {
                    clearInterval(interval);
                }
            }, 1000);
        }

        // --- SUARA SAAT KELAR UJIAN ---
        form.addEventListener('submit', function(e) {
            // Cegah double submit
            if (form.dataset.submitting) return;
            e.preventDefault();
            form.dataset.submitting = 'true';

            // Matikan Suara Robot
            // let msg = new SpeechSynthesisUtterance("sori yeee... omon omon omon");
            // msg.lang = 'id-ID';
            // window.speechSynthesis.speak(msg);

            // MEMAKAI FILE MP3 SUARA ASLI PRABOWO:
            audioKelar.play().catch(e => {
                console.error("Browser memblokir suara selesai ujian: ", e);
                alert("Gagal putar MP3. Cek console (F12) untuk detailnya.");
            });

            // Tembakkan Confetti 🎉
            if (typeof confetti === 'function') {
                confetti({
                    particleCount: 250,
                    spread: 100,
                    origin: { y: 0.6 }
                });
            }

            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
            
            // Beri jeda 3 detik agar suara selesai diucapkan sebelum pindah halaman
            setTimeout(() => {
                form.submit();
            }, 3000); 
        });

        // --- SISTEM ANTI-CHEAT (Mencegah Kecurangan) ---
        let violationCount = 0;
        const maxViolations = 3; // Batas maksimal toleransi pindah tab

        // Fungsi untuk memutar suara peringatan "hei antek-antek asing"
        function playCheatAlarm() {
            // Matikan Suara Robot
            // let msg = new SpeechSynthesisUtterance("Hei! Antek-antek asing! Jangan mencoba curang!");
            // msg.lang = 'id-ID';
            // window.speechSynthesis.speak(msg);
            
            // MEMAKAI FILE MP3 ASLI:
            audioCurang.play().catch(e => {
                console.error("Browser memblokir suara curang: ", e);
            });
        }

        // 1. Auto Fullscreen pada klik pertama & Deteksi Keluar Fullscreen
        document.addEventListener('click', function() {
            if (!document.fullscreenElement && !submitBtn.disabled) {
                document.documentElement.requestFullscreen().catch(err => {});
            }
        });

        document.addEventListener('fullscreenchange', function() {
            if (!document.fullscreenElement && !submitBtn.disabled) {
                violationCount++;
                playCheatAlarm(); // Putar alarm suara
                
                setTimeout(() => { // Beri jeda 1.2 detik agar suara nyaring duluan sebelum alert membekukan browser
                    if (violationCount >= maxViolations) {
                        alert("🚨 KECURANGAN TERDETEKSI! 🚨\n\nAnda telah keluar dari mode Fullscreen sebanyak " + maxViolations + " kali. Ujian diakhiri dan jawaban Anda dikirim secara otomatis.");
                        form.submit();
                    } else {
                        alert("⚠️ PERINGATAN KECURANGAN (" + violationCount + "/" + maxViolations + ") ⚠️\n\nAnda terdeteksi keluar dari mode Fullscreen (Menekan ESC)! Klik OK untuk kembali ke layar ujian.");
                        document.documentElement.requestFullscreen().catch(e => {});
                    }
                }, 1200); 
            }
        });

        // 2. Deteksi Pindah Tab / Pindah Aplikasi
        document.addEventListener('visibilitychange', function() {
            if (document.hidden && !submitBtn.disabled) {
                violationCount++;
                playCheatAlarm(); // Putar alarm suara
                
                setTimeout(() => { // Beri jeda 1.2 detik agar suara nyaring duluan sebelum alert membekukan browser
                    if (violationCount >= maxViolations) {
                        alert("🚨 KECURANGAN TERDETEKSI! 🚨\n\nAnda telah meninggalkan halaman ujian sebanyak " + maxViolations + " kali. Ujian diakhiri dan jawaban Anda dikirim secara otomatis.");
                        form.submit();
                    } else {
                        alert("⚠️ PERINGATAN KECURANGAN (" + violationCount + "/" + maxViolations + ") ⚠️\n\nAnda terdeteksi pindah tab atau mengecilkan browser! Jangan tinggalkan halaman ini, atau ujian Anda akan diakhiri secara otomatis!");
                    }
                }, 1200);
            }
        });

        // 2. Mencegah Klik Kanan, Copy, dan Cut
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('copy', e => e.preventDefault());
        document.addEventListener('cut', e => e.preventDefault());
    })();
</script>
@endsection