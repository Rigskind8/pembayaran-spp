@extends('layouts.app')

@section('title', 'Hasil Ujian - Paramount')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root { --sb: 64px; --sb-open: 220px; --bg: #f4f6fa; --card: #fff; --border: #e8eaf0; --txt: #111827; --txt2: #6b7280; --txt3: #9ca3af; --blue: #2563eb; --blue-bg: #eff6ff; --green: #059669; --green-bg: #ecfdf5; --red: #dc2626; --red-bg: #fef2f2; --amber: #d97706; --purple: #7c3aed; --purple-bg: #f5f3ff; --sb-bg: #0f1117; --r: 16px; --shadow: 0 1px 3px rgba(0,0,0,.06), 0 2px 8px rgba(0,0,0,.04); }
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
.header-section { margin-bottom: 28px; }
.header-section h1 { font-size: 26px; font-weight: 800; margin-bottom: 4px; }
.header-section p { font-size: 13px; color: var(--txt2); }

.filter-box { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); padding: 16px; margin-bottom: 20px; display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap; box-shadow: var(--shadow); }
.filter-group { display: flex; flex-direction: column; gap: 6px; }
.filter-group label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--txt3); }
.filter-group select { padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px; color: var(--txt); background: white; }
.btn { padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; border: none; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
.btn-blue { background: var(--blue); color: white; }
.btn-green { background: var(--green); color: white; }

.results-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); box-shadow: var(--shadow); overflow: hidden; }
.results-header { padding: 16px 20px; background: #fafbff; border-bottom: 1px solid var(--border); }
.results-title { font-size: 14px; font-weight: 700; color: var(--txt); margin-bottom: 4px; }
.results-subtitle { font-size: 12px; color: var(--txt2); }

.table-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; }
thead th { font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--txt3); padding: 12px 16px; text-align: left; background: #fafbff; border-bottom: 1px solid var(--border); }
tbody td { padding: 12px 16px; font-size: 13px; color: var(--txt); border-bottom: 1px solid #f5f5f7; vertical-align: middle; }
tbody tr:hover td { background: #f9fbff; }

.badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; }
.badge-blue { background: var(--blue-bg); color: var(--blue); }
.badge-green { background: var(--green-bg); color: var(--green); }
.badge-amber { background: #fffbeb; color: var(--amber); }
.badge-red { background: var(--red-bg); color: var(--red); }

.score-box { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 6px; background: #f0f9ff; color: var(--blue); font-weight: 600; font-size: 12px; }
.avatar { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: white; }

.student-info { display: flex; align-items: center; gap: 10px; }
.student-name { font-weight: 600; font-size: 13px; }
.student-email { font-size: 12px; color: var(--txt3); }

.no-data { text-align: center; padding: 40px; color: var(--txt3); }
.no-data i { font-size: 28px; margin-bottom: 10px; color: var(--border); }

.auto-refresh { position: fixed; bottom: 20px; right: 20px; background: var(--green); color: white; padding: 10px 14px; border-radius: 999px; font-size: 12px; font-weight: 600; box-shadow: 0 4px 12px rgba(0,0,0,.15); z-index: 100; }
.auto-refresh.pulse { animation: pulse 1.5s infinite; }
@keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }

@media(max-width:768px) { .filter-box { flex-direction: column; align-items: stretch; } .filter-group select { width: 100%; } }
</style>

<div class="app">
    @include('partials.sidebar')

    <div class="main">
        <header class="topbar">
            <div>
                <div style="font-size:18px; font-weight:800;">Hasil Ujian</div>
                <div style="font-size:12px; color:var(--txt2);">Pantau hasil ujian siswa secara real-time</div>
            </div>
            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                <span id="last-update" style="font-size:11px; color:var(--txt3);">Memperbarui...</span>
                <button class="btn btn-green" id="refresh-btn" onclick="refreshResults()" title="Muat ulang data">
                    <i class="fas fa-sync-alt"></i> Segarkan
                </button>
            </div>
        </header>

        <div class="page">
            <div class="header-section">
                <h1>📊 Hasil Ujian Siswa</h1>
                <p>Lihat hasil ujian per mapel dengan skor dan waktu pengerjaan</p>
            </div>

            <!-- Filter -->
            <div class="filter-box">
                <div class="filter-group" style="flex:1; min-width:250px;">
                    <label>Pilih Mapel</label>
                        <select id="subject-filter" onchange="changeSubject(this.value)">
                            <option value="0" {{ (isset($hasParam) && $hasParam && $subjectId == 0) ? 'selected' : '' }}>-- Semua Mapel --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ $subjectId == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}{{ $subject->class_id ? ' ('.$subject->class_id.')' : '' }}
                                </option>
                            @endforeach
                        </select>
                </div>
                <div class="filter-group" style="flex:1; min-width:150px;">
                    <label>Pilih Kelas</label>
                    <select id="class-filter" onchange="changeClass(this.value)">
                        <option value="">-- Semua Kelas --</option>
                        @foreach($classOptions ?? [] as $cls)
                            <option value="{{ $cls }}" {{ $classId == $cls ? 'selected' : '' }}>{{ $cls }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group" style="flex:1; min-width:250px;">
                    <label>Cari Nama Siswa</label>
                    <div style="display:flex; gap:8px;">
                        <input type="text" id="student-search" placeholder="Ketik nama atau email siswa..." style="flex:1; padding:8px 12px; border:1px solid var(--border); border-radius:8px; font-size:13px; color:var(--txt);">
                        <button class="btn btn-blue" onclick="refreshResults()" title="Cari">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <button class="btn btn-blue" onclick="exportResults()">
                    <i class="fas fa-download"></i> Export CSV
                </button>
            </div>

            <!-- Results -->
            <div class="results-card">
                <div class="results-header">
                    <div class="results-title">Daftar Ujian Siswa</div>
                    <div class="results-subtitle">Hasil ujian muncul otomatis saat siswa selesai mengerjakan</div>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Email</th>
                                <th>Kelas</th>
                                <th>Mapel</th>
                                <th>Tipe</th>
                                <th>Skor</th>
                                <th>Benar / Total</th>
                                <th>Waktu Selesai</th>
                            </tr>
                        </thead>
                        <tbody id="results-body">
                            @if($attempts->isEmpty())
                            <tr>
                                <td colspan="8">
                                    <div class="no-data">
                                        <div><i class="fas fa-inbox"></i></div>
                                        <div>Belum ada hasil ujian</div>
                                        <div style="font-size:11px; margin-top:6px;">Hasil ujian siswa akan muncul di sini setelah mereka selesai mengerjakan</div>
                                    </div>
                                </td>
                            </tr>
                            @else
                                @foreach($attempts as $attempt)
                                <tr>
                                    <td>
                                        <div class="student-info">
                                            <div class="avatar" style="background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                {{ strtoupper(substr($attempt->user?->name ?? 'S', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="student-name">{{ $attempt->user?->name ?? 'Unknown' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $attempt->user?->email ?? '-' }}</td>
                                    <td>
                                        <div style="font-weight: 600; font-size: 13px;">{{ $attempt->user?->student?->class_id ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600; font-size: 13px;">{{ $attempt->subject?->name ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $attempt->type === 'uts' ? 'badge-blue' : 'badge-green' }}">
                                            <i class="fas {{ $attempt->type === 'uts' ? 'fa-book' : 'fa-graduation-cap' }}"></i>
                                            {{ strtoupper($attempt->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="score-box">
                                            {{ $attempt->score }} / {{ $attempt->max_score }}
                                            <span style="font-size:11px; opacity:.7;">({{ round(($attempt->score / $attempt->max_score) * 100, 1) }}%)</span>
                                        </div>
                                    </td>
                                    <td>{{ $attempt->correct_count }} / {{ $attempt->total_questions }}</td>
                                    <td>
                                        <span title="{{ $attempt->submitted_at?->format('d M Y H:i:s') }}">
                                            {{ $attempt->submitted_at?->diffForHumans() ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($attempts->hasPages())
            <div style="margin-top:20px; display:flex; justify-content:center;">
                {{ $attempts->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Auto-refresh indicator -->
<div class="auto-refresh pulse" id="auto-refresh-indicator">
    🔄 Auto-refresh aktif
</div>

<script>
const subjectId = {{ $subjectId ?? 0 }};
let autoRefreshInterval;

// Auto search saat ketik di input search
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('student-search');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('keyup', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                refreshResults();
            }, 500);
        });
    }
});

function changeSubject(value) {
    const url = new URL(window.location);
    // Always set subject_id (use '0' for Semua Mapel)
    url.searchParams.set('subject_id', value);
    window.location = url.toString();
}

function changeClass(value) {
    const url = new URL(window.location);
    url.searchParams.set('class_id', value);
    window.location = url.toString();
}

function refreshResults() {
    const searchInput = document.getElementById('student-search').value;
    const subjectFilter = document.getElementById('subject-filter').value;
    const classFilter = document.getElementById('class-filter').value;
    const currentSubjectId = subjectFilter ? subjectFilter : 0;
    
    let url = `{{ route('exam-results.api') }}?subject_id=${currentSubjectId}&class_id=${encodeURIComponent(classFilter)}`;
    if (searchInput) {
        url += `&search=${encodeURIComponent(searchInput)}`;
    }

    fetch(url)
        .then(res => res.json())
        .then(data => {
            if (data.data && data.data.length > 0) {
                updateResultsTable(data.data);
                updateLastUpdate();
            } else {
                const tbody = document.getElementById('results-body');
                tbody.innerHTML = `<tr><td colspan="8"><div class="no-data"><div><i class="fas fa-inbox"></i></div><div>Tidak ada hasil yang cocok</div></div></td></tr>`;
            }
        })
        .catch(err => console.error('Error fetching results:', err));
}

function updateResultsTable(results) {
    const tbody = document.getElementById('results-body');
    
    if (results.length === 0) {
        tbody.innerHTML = `<tr><td colspan="8"><div class="no-data"><div><i class="fas fa-inbox"></i></div><div>Belum ada hasil ujian</div></div></td></tr>`;
        return;
    }

    tbody.innerHTML = results.map(attempt => `
        <tr>
            <td>
                <div class="student-info">
                    <div class="avatar" style="background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        ${attempt.student_name.charAt(0).toUpperCase()}
                    </div>
                    <div>
                        <div class="student-name">${attempt.student_name}</div>
                    </div>
                </div>
            </td>
            <td>${attempt.student_email}</td>
            <td>
                <div style="font-weight: 600; font-size: 13px;">${attempt.class}</div>
            </td>
            <td>
                <div style="font-weight: 600; font-size: 13px;">${attempt.subject}</div>
            </td>
            <td>
                <span class="badge ${attempt.type === 'UTS' ? 'badge-blue' : 'badge-green'}">
                    <i class="fas ${attempt.type === 'UTS' ? 'fa-book' : 'fa-graduation-cap'}"></i>
                    ${attempt.type}
                </span>
            </td>
            <td>
                <div class="score-box">
                    ${attempt.score} / ${attempt.max_score}
                    <span style="font-size:11px; opacity:.7;">(${attempt.percentage}%)</span>
                </div>
            </td>
            <td>${attempt.correct} / ${attempt.total}</td>
            <td title="${attempt.submitted_at}">${attempt.submitted_relative}</td>
        </tr>
    `).join('');
}

function updateLastUpdate() {
    const now = new Date();
    const time = now.toLocaleTimeString('id-ID');
    document.getElementById('last-update').textContent = `Update terakhir: ${time}`;
}

function exportResults() {
    const subjectFilter = document.getElementById('subject-filter').value;
    const classFilter = document.getElementById('class-filter').value;
    const currentSubjectId = subjectFilter ? subjectFilter : 0;
    const searchInput = document.getElementById('student-search').value;
    let url = `{{ route('exam-results.export') }}?subject_id=${currentSubjectId}&class_id=${encodeURIComponent(classFilter)}`;
    if (searchInput) {
        url += `&search=${encodeURIComponent(searchInput)}`;
    }
    window.location.href = url;
}

// Auto-refresh every 10 seconds
function startAutoRefresh() {
    autoRefreshInterval = setInterval(() => {
        refreshResults();
    }, 10000); // 10 seconds
}

// Start auto-refresh when page loads
document.addEventListener('DOMContentLoaded', () => {
    startAutoRefresh();
    updateLastUpdate();
});

// Clean up interval on page unload
window.addEventListener('beforeunload', () => {
    if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
    }
});
</script>
@endsection
