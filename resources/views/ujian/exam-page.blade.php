<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
:root{--sb:64px;--sb-open:220px;--bg:#f4f6fa;--card:#fff;--border:#e8eaf0;--txt:#111827;--txt2:#6b7280;--txt3:#9ca3af;--blue:#2563eb;--blue-bg:#eff6ff;--green:#059669;--green-bg:#ecfdf5;--red:#dc2626;--red-bg:#fef2f2;--amber:#d97706;--amber-bg:#fffbeb;--purple:#7c3aed;--purple-bg:#f5f3ff;--sb-bg:#0f1117;--r:16px;--shadow:0 1px 3px rgba(0,0,0,.06),0 2px 8px rgba(0,0,0,.04);--shadow-md:0 4px 16px rgba(0,0,0,.08);}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg);color:var(--txt);-webkit-font-smoothing:antialiased;}
.app{display:flex;min-height:100vh;}
.main{margin-left:var(--sb);flex:1;display:flex;flex-direction:column;}
.page{padding:28px;flex:1;}
.hero{background:linear-gradient(120deg,#1e3a8a 0%,#2563eb 55%,#4f46e5 100%);border-radius:var(--r);padding:28px 32px;display:flex;align-items:center;justify-content:space-between;gap:20px;margin-bottom:24px;position:relative;overflow:hidden;box-shadow:0 6px 24px rgba(37,99,235,.18);}
.hero::before{content:'';position:absolute;right:-40px;top:-40px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,.06);}
.hero::after{content:'';position:absolute;right:100px;bottom:-50px;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,.04);}
.hl{position:relative;z-index:1;}
.hl-tag{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:99px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);font-size:10px;font-weight:700;color:rgba(255,255,255,.8);text-transform:uppercase;letter-spacing:.06em;margin-bottom:10px;}
.hl h2{font-size:24px;font-weight:800;color:white;margin-bottom:5px;}
.hl p{font-size:13px;color:rgba(255,255,255,.65);}
.hero-stats{display:flex;gap:10px;position:relative;z-index:1;flex-shrink:0;}
.hs{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);border-radius:12px;padding:14px 20px;text-align:center;min-width:92px;}
.hs-val{font-size:22px;font-weight:800;color:white;}
.hs-lbl{font-size:9px;color:rgba(255,255,255,.55);font-weight:700;text-transform:uppercase;letter-spacing:.08em;margin-top:3px;}
.info-alert{background:rgba(37,99,235,.08);border:1px solid rgba(37,99,235,.18);border-radius:12px;padding:14px 18px;display:flex;align-items:flex-start;gap:12px;margin-bottom:24px;}
.info-alert i{color:var(--blue);font-size:16px;margin-top:1px;flex-shrink:0;}
.info-alert p{font-size:12.5px;color:#1e3a8a;font-weight:600;margin-bottom:3px;}
.info-alert span{font-size:11.5px;color:#1d4ed8;line-height:1.6;}
.grid-2{display:grid;grid-template-columns:1fr;gap:20px;}
.card{background:var(--card);border:1px solid var(--border);border-radius:var(--r);box-shadow:var(--shadow);overflow:hidden;}
.card-head{padding:18px 22px;border-bottom:1px solid var(--border);background:#fafbff;display:flex;align-items:center;justify-content:space-between;gap:14px;}
.card-ttl{font-size:15px;font-weight:800;color:var(--txt);}
.card-sub{font-size:11.5px;color:var(--txt2);margin-top:2px;}
.badge-soft{display:inline-flex;align-items:center;gap:5px;padding:6px 11px;border-radius:999px;font-size:11px;font-weight:800;}
.badge-soft.blue{background:var(--blue-bg);color:var(--blue);}
.badge-soft.green{background:var(--green-bg);color:var(--green);}
.badge-soft.amber{background:var(--amber-bg);color:var(--amber);}
.badge-soft.purple{background:var(--purple-bg);color:var(--purple);}
.exam-list{display:grid;gap:14px;padding:18px;}
.exam-item{border:1px solid var(--border);border-radius:16px;padding:16px;background:#fff;display:grid;gap:12px;box-shadow:var(--shadow);}
.exam-item-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;}
.exam-title{font-size:15px;font-weight:800;color:var(--txt);}
.exam-meta{font-size:12px;color:var(--txt2);margin-top:4px;}
.exam-submeta{display:flex;flex-wrap:wrap;gap:8px;align-items:center;}
.exam-action{display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:10px 14px;border-radius:12px;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;}
.exam-action.primary{background:var(--blue);color:white;}
.exam-action.secondary{background:#f8fafc;color:var(--txt2);border:1px solid var(--border);}
.exam-action.warning{background:var(--amber-bg);color:var(--amber);border:1px solid #fde68a;}
.empty-state{padding:30px 18px;text-align:center;color:var(--txt3);border:1px dashed var(--border);border-radius:16px;background:#fff;}
.fg{margin-bottom:14px;}
.fl{font-size:11.5px;font-weight:700;color:var(--txt2);margin-bottom:5px;display:block;}
.fc{width:100%;padding:9px 12px;border:1px solid var(--border);border-radius:9px;font-size:13px;font-family:inherit;color:var(--txt);outline:none;transition:border-color .12s;background:white;}
.fc:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(37,99,235,.1);}
.fc.is-invalid{border-color:var(--red);}
.err{font-size:11px;color:var(--red);margin-top:4px;}
.upzone{border:2px dashed var(--border);border-radius:12px;padding:24px 16px;text-align:center;cursor:pointer;transition:all .18s;}
.upzone:hover,.upzone.drag{border-color:var(--blue);background:var(--blue-bg);}
.upzone-ic{font-size:26px;color:var(--blue);margin-bottom:8px;}
.upzone h5{font-size:12.5px;font-weight:700;margin-bottom:3px;}
.upzone p{font-size:11px;color:var(--txt2);}
.file-preview{display:none;align-items:center;gap:9px;padding:10px 12px;border-radius:9px;background:var(--green-bg);border:1px solid #a7f3d0;margin-top:10px;}
.file-preview.show{display:flex;}
.btn-submit{width:100%;padding:12px;background:var(--blue);color:white;border:none;border-radius:10px;font-size:14px;font-weight:700;cursor:pointer;font-family:inherit;transition:all .15s;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 4px 14px rgba(37,99,235,.3);margin-top:6px;}
.btn-submit:hover{background:#1d4ed8;transform:translateY(-1px);}
.summary{padding:18px;display:grid;gap:12px;}
.box{background:#f8fafc;border:1px solid #e2e8f0;border-radius:14px;padding:14px;}
.box .k{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.06em;color:#64748b;}
.box .v{font-size:17px;font-weight:800;margin-top:4px;}
.toasts{position:fixed;bottom:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:8px;}
.toast{display:flex;align-items:center;gap:10px;padding:12px 16px;background:white;border-radius:12px;box-shadow:var(--shadow-md);border:1px solid var(--border);min-width:260px;animation:tIn .25s ease;}
@keyframes tIn{from{opacity:0;transform:translateX(30px)}to{opacity:1;transform:none}}
.toast.hide{opacity:0;transform:translateX(30px);transition:all .25s;}
.t-ic{width:32px;height:32px;border-radius:9px;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:14px;}
.t-ic.s{background:var(--green-bg);color:var(--green);}
.t-ic.e{background:var(--red-bg);color:var(--red);}
.t-ttl{font-size:12.5px;font-weight:700;}
.t-msg{font-size:11px;color:var(--txt2);}
@media(max-width:960px){.grid-2{grid-template-columns:1fr;}.hero-stats{display:none;}}
@media(max-width:640px){.sb{display:none;}.main{margin-left:0;}.page{padding:16px;}}
</style>

<div class="toasts" id="toasts"></div>
<div class="app">
    @include('partials.sidebar')
    <div class="main">
        <div class="page">
            @if(session('success'))
                <div class="info-alert" style="background:var(--green-bg);border-color:#bbf7d0;"><i class="fas fa-circle-check" style="color:var(--green);"></i><div><p style="color:var(--green);">Berhasil</p><span style="color:var(--green);">{{ session('success') }}</span></div></div>
            @endif
            @if(session('error'))
                <div class="info-alert" style="background:var(--red-bg);border-color:#fecaca;"><i class="fas fa-triangle-exclamation" style="color:var(--red);"></i><div><p style="color:var(--red);">Gagal</p><span style="color:var(--red);">{{ session('error') }}</span></div></div>
            @endif

            <div class="grid-2">
                <div class="card">
                    <div class="card-head">
                        <div><div class="card-ttl">Mapel Tersedia</div><div class="card-sub">Soal akan muncul setelah pembayaran verified</div></div>
                        <span class="badge-soft {{ $accent ?? 'blue' }}">{{ count($cards) }} mapel</span>
                    </div>
                    <div class="exam-list">
                        @forelse($cards as $item)
                            @php
                                $paymentStatus = $item['payment']?->status ?? 'belum';
                                $statusLabel = match($paymentStatus) {
                                    'verified' => ['Disetujui', 'green'],
                                    'pending' => ['Pending', 'amber'],
                                    'rejected' => ['Ditolak', 'red'],
                                    default => ['Belum Bayar', 'blue'],
                                };
                            @endphp
                            <div class="exam-item">
                                <div class="exam-item-head">
                                    <div>
                                        <div class="exam-title">{{ $item['subject']->name }}</div>
                                        <div class="exam-meta">Kelas {{ $item['subject']->class_id ?? '-' }} · {{ $item['questionCount'] }} soal tersedia</div>
                                    </div>
                                    @if($item['isDone'])
                                        <span class="badge-soft green">Sudah Dikerjakan</span>
                                    @else
                                        <span class="badge-soft {{ $statusLabel[1] }}">{{ $statusLabel[0] }}</span>
                                    @endif
                                </div>
                                <div class="exam-submeta">
                                    <span class="badge-soft blue">{{ strtoupper($jenis) }}</span>
                                    <span class="badge-soft {{ $item['questionCount'] >= 5 ? 'green' : 'amber' }}">{{ $item['questionCount'] >= 5 ? 'Soal siap (5+)' : 'Soal belum lengkap' }}</span>
                                </div>
                                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                    @if($item['isDone'])
                                        <span class="exam-action secondary" style="cursor:default;">Kamu sudah mengerjakan ujian ini</span>
                                        <a href="{{ route('ujian.result', [$jenis, $item['subject'], 'attempt' => $item['latestAttempt']->id]) }}" class="exam-action primary"><i class="fas fa-chart-line"></i> Lihat Hasil</a>
                                    @elseif($item['canTake'])
                                        <a href="{{ route('ujian.take', [$jenis, $item['subject']]) }}" class="exam-action primary"><i class="fas fa-pen-to-square"></i> Mulai Ujian</a>
                                    @elseif($paymentStatus === 'pending')
                                        <span class="exam-action warning" style="cursor:default;">Menunggu verifikasi admin</span>
                                    @elseif($paymentStatus === 'verified' && $item['questionCount'] < 5)
                                        <span class="exam-action secondary" style="cursor:default;">Soal minimal 5 belum terpenuhi</span>
                                    @else
                                        <span class="exam-action secondary" style="cursor:default;">Bayar dulu untuk membuka soal</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div style="font-size:2.4rem;">📭</div>
                                <p style="font-size:13px;font-weight:700;color:var(--txt2);margin-top:8px;">Tidak ada mapel untuk kelas Anda.</p>
                                <p style="font-size:12px;color:var(--txt3);margin-top:6px;">Jika seharusnya ada, hubungi admin sekolah.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="toasts" id="toasts"></div>

<script>
function toast(type,title,msg){ const ic={s:'fa-check',e:'fa-times'}; const el=document.createElement('div');el.className='toast'; el.innerHTML=`<div class="t-ic ${type}"><i class="fas ${ic[type]}"></i></div><div><div class="t-ttl">${title}</div><div class="t-msg">${msg}</div></div>`; document.getElementById('toasts').appendChild(el); setTimeout(()=>{el.classList.add('hide');setTimeout(()=>el.remove(),250);},3500); }
@if(session('success')) window.addEventListener('load',()=>toast('s','Berhasil','{{ session('success') }}')); @endif
@if(session('error')) window.addEventListener('load',()=>toast('e','Error','{{ session('error') }}')); @endif
</script>