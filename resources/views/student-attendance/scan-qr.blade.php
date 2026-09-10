@extends('layouts.app')

@section('title', 'Scan QR Code Absensi Siswa - SMK TRAVINA PRIMA')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
:root{--sb:64px;--sb-open:220px;--bg:#f4f6fa;--card:#fff;--border:#e8eaf0;--txt:#111827;--txt2:#6b7280;--green:#059669;--green-bg:#ecfdf5;--red:#dc2626;--red-bg:#fef2f2;--blue:#2563eb;--sb-bg:#0f1117;--r:16px;--shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.04);}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg);color:var(--txt);-webkit-font-smoothing:antialiased;}
.app{display:flex;min-height:100vh;}
.main{margin-left:var(--sb);flex:1;display:flex;flex-direction:column;}
.topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 28px;background:rgba(244,246,250,.95);backdrop-filter:blur(10px);border-bottom:1px solid var(--border);position:sticky;top:0;z-index:100;}
.top-title{font-size:18px;font-weight:800;color:var(--txt);letter-spacing:-.3px;}
.top-sub{font-size:12px;color:var(--txt2);margin-top:1px;}
.page{padding:28px;flex:1;max-width:900px;margin:0 auto;width:100%;}
.scan-card{background:var(--card);border:1px solid var(--border);border-radius:var(--r);box-shadow:var(--shadow);overflow:hidden;margin-bottom:24px;}
.scan-card-head{padding:20px 24px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
.scan-card-head h6{font-size:16px;font-weight:800;display:flex;align-items:center;gap:8px;}
#reader{width:100%;border:none!important;border-radius:12px;overflow:hidden;}
#reader video{border-radius:12px;}
.manual-input{padding:20px 24px;background:#f8fafc;border-top:1px solid var(--border);display:flex;gap:10px;align-items:center;}
.manual-input input{flex:1;padding:12px 16px;border:1px solid var(--border);border-radius:10px;font-size:14px;font-family:inherit;outline:none;}
.manual-input input:focus{border-color:var(--blue);background:white;}
.btn{display:inline-flex;align-items:center;gap:8px;padding:12px 20px;border-radius:10px;font-size:13px;font-weight:700;border:none;cursor:pointer;font-family:inherit;transition:all .15s;text-decoration:none;}
.btn-blue{background:var(--blue);color:white;}
.btn-blue:hover{background:#1d4ed8;}
.result-banner{display:none;padding:18px 24px;border-radius:var(--r);margin-bottom:24px;animation:slideDown .3s ease;}
.result-success{background:var(--green-bg);border:1.5px solid #a7f3d0;color:#065f46;}
.result-error{background:var(--red-bg);border:1.5px solid #fecaca;color:#991b1b;}
@keyframes slideDown{from{opacity:0;transform:translateY(-10px);}to{opacity:1;transform:translateY(0);}}
.res-name{font-size:18px;font-weight:800;margin-bottom:4px;}
.res-detail{font-size:13px;opacity:.9;}
@media(max-width:640px){.main{margin-left:0;}.page{padding:16px;}}
</style>

<div class="app">
    @include('partials.sidebar')

    <div class="main">
        <header class="topbar">
            <div>
                <div class="top-title">Scan QR Code Absensi Siswa</div>
                <div class="top-sub">Arahkan Kamera ke QR Code Siswa atau Kartu Pelajar</div>
            </div>
            <a href="{{ route('attendance.manage') }}" class="btn btn-blue">
                <i class="fas fa-list"></i> Lihat Rekap Absensi
            </a>
        </header>

        <div class="page">

            <!-- Result Banner -->
            <div id="resultBanner" class="result-banner">
                <div style="display:flex;align-items:center;gap:14px;">
                    <div id="resIcon" style="font-size:32px;"></div>
                    <div>
                        <div id="resName" class="res-name"></div>
                        <div id="resDetail" class="res-detail"></div>
                    </div>
                </div>
            </div>

            <!-- Scanner Card -->
            <div class="scan-card">
                <div class="scan-card-head">
                    <h6><i class="fas fa-qrcode" style="color:var(--blue);"></i> Scanner Kamera Presensi</h6>
                    <span style="font-size:12px;color:var(--txt2);"><i class="fas fa-circle" style="color:#10b981;font-size:8px;"></i> Kamera Aktif</span>
                </div>

                <div style="padding:20px;background:#0f172a;">
                    <div id="reader"></div>
                </div>

                <div class="manual-input">
                    <input type="text" id="manualNis" placeholder="Atau ketik NIS / ID Siswa di sini..." onkeypress="if(event.key==='Enter') processManualScan()">
                    <button class="btn btn-blue" onclick="processManualScan()">
                        <i class="fas fa-paper-plane"></i> Absenkan
                    </button>
                </div>
            </div>

            <!-- List Log Absen Hari Ini -->
            <div class="scan-card">
                <div class="scan-card-head">
                    <h6><i class="fas fa-history" style="color:var(--green);"></i> Log Absensi Scan Terkini</h6>
                </div>
                <div style="padding:0;">
                    <table style="width:100%;border-collapse:collapse;font-size:13px;">
                        <thead>
                            <tr style="background:#f8fafc;border-bottom:1px solid var(--border);">
                                <th style="padding:10px 18px;text-align:left;font-size:10px;text-transform:uppercase;color:var(--txt2);">Waktu</th>
                                <th style="padding:10px 18px;text-align:left;font-size:10px;text-transform:uppercase;color:var(--txt2);">NIS</th>
                                <th style="padding:10px 18px;text-align:left;font-size:10px;text-transform:uppercase;color:var(--txt2);">Nama Siswa</th>
                                <th style="padding:10px 18px;text-align:left;font-size:10px;text-transform:uppercase;color:var(--txt2);">Kelas</th>
                                <th style="padding:10px 18px;text-align:center;font-size:10px;text-transform:uppercase;color:var(--txt2);">Status</th>
                            </tr>
                        </thead>
                        <tbody id="scanLogBody">
                            <tr>
                                <td colspan="5" style="padding:20px;text-align:center;color:var(--txt2);">Belum ada siswa yang discan pada sesi ini.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
let lastScannedNis = null;
let isProcessing = false;

function onScanSuccess(decodedText, decodedResult) {
    if (isProcessing || decodedText === lastScannedNis) return;
    isProcessing = true;
    lastScannedNis = decodedText;

    sendAttendanceRequest(decodedText);

    setTimeout(() => {
        isProcessing = false;
        lastScannedNis = null;
    }, 3000);
}

function processManualScan() {
    const nis = document.getElementById('manualNis').value.trim();
    if (!nis) return;
    sendAttendanceRequest(nis);
    document.getElementById('manualNis').value = '';
}

function sendAttendanceRequest(nis) {
    fetch("{{ route('attendance.processQrScan') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ nis: nis })
    })
    .then(res => res.json())
    .then(data => {
        showResultBanner(data);
        if (data.success && data.student) {
            addScanLog(data.student);
        }
    })
    .catch(err => {
        showResultBanner({ success: false, message: "Terjadi kesalahan jaringan." });
    });
}

function showResultBanner(data) {
    const banner = document.getElementById('resultBanner');
    const icon = document.getElementById('resIcon');
    const name = document.getElementById('resName');
    const detail = document.getElementById('resDetail');

    banner.className = 'result-banner ' + (data.success ? 'result-success' : 'result-error');
    banner.style.display = 'block';

    if (data.success) {
        icon.innerHTML = '<i class="fas fa-circle-check"></i>';
        name.textContent = data.student ? data.student.name : 'Berhasil';
        detail.textContent = data.message;
    } else {
        icon.innerHTML = '<i class="fas fa-circle-xmark"></i>';
        name.textContent = 'Gagal Absen';
        detail.textContent = data.message;
    }

    setTimeout(() => {
        banner.style.display = 'none';
    }, 4000);
}

function addScanLog(student) {
    const tbody = document.getElementById('scanLogBody');
    if (tbody.children.length === 1 && tbody.children[0].cells.length === 1) {
        tbody.innerHTML = '';
    }

    const row = document.createElement('tr');
    row.style.borderBottom = '1px solid var(--border)';
    row.innerHTML = `
        <td style="padding:10px 18px;font-weight:700;">${student.time || new Date().toLocaleTimeString('id-ID')}</td>
        <td style="padding:10px 18px;color:var(--txt2);">${student.nis}</td>
        <td style="padding:10px 18px;font-weight:700;">${student.name}</td>
        <td style="padding:10px 18px;"><span style="background:#eff6ff;color:#2563eb;padding:3px 8px;border-radius:6px;font-size:11px;font-weight:700;">${student.class_id}</span></td>
        <td style="padding:10px 18px;text-align:center;"><span style="background:#dcfce7;color:#166534;padding:3px 8px;border-radius:99px;font-size:11px;font-weight:700;">HADIR</span></td>
    `;

    tbody.insertBefore(row, tbody.firstChild);
}

// Initialize Html5QrcodeScanner
document.addEventListener("DOMContentLoaded", function() {
    const html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: { width: 250, height: 250 } },
        /* verbose= */ false
    );
    html5QrcodeScanner.render(onScanSuccess);
});
</script>
@endsection

