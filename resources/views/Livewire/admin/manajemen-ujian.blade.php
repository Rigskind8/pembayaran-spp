<div>
<style>
:root {
    --amber: #d97706; --amber-bg: #fffbeb;
    --green: #059669; --green-bg: #ecfdf5;
    --red: #dc2626;   --red-bg: #fef2f2;
    --border: #e2e8f0;
    --txt2: #64748b;  --txt3: #94a3b8;
    --card: #ffffff;
}
.jb-default{background:#f1f5f9;color:#475569;}
.stb{display:inline-flex;align-items:center;gap:5px;padding:5px 11px;border-radius:99px;font-size:11px;font-weight:700;}
.stb-dot{width:6px;height:6px;border-radius:50%;background:currentColor;}
.stb-pending{background:var(--amber-bg);color:var(--amber);}
.stb-verified{background:var(--green-bg);color:var(--green);}
.stb-rejected{background:var(--red-bg);color:var(--red);}
.act-btn{width:32px;height:32px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;font-size:13px;border:1.5px solid;cursor:pointer;font-family:'Outfit',sans-serif;transition:all .15s;background:transparent;}
.act-grn{border-color:#a7f3d0;color:var(--green);}
.act-grn:hover{background:var(--green);color:white;border-color:var(--green);}
.act-red{border-color:#fecaca;color:var(--red);}
.act-red:hover{background:var(--red);color:white;border-color:var(--red);}
.uw-empty{padding:56px 24px;text-align:center;}
.uw-empty-ic{font-size:3rem;margin-bottom:12px;}
.uw-empty-txt{font-size:13px;font-weight:600;color:var(--txt3);}
.uw-pagination{padding:14px 20px;border-top:1px solid var(--border);}
.uw{padding:28px;max-width:1200px;margin:0 auto;}
.uw-title{font-size:22px;font-weight:800;color:#0f172a;margin-bottom:4px;}
.uw-sub{font-size:13px;color:var(--txt3);margin-bottom:24px;}
.uw-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px;}
.uw-stat{background:var(--card);border:1px solid var(--border);border-radius:16px;padding:20px;display:flex;flex-direction:column;gap:6px;}
.uw-stat.amb{border-left:4px solid var(--amber);}
.uw-stat.grn{border-left:4px solid var(--green);}
.uw-stat.red{border-left:4px solid var(--red);}
.uw-stat-ic{font-size:20px;}
.uw-stat-val{font-size:28px;font-weight:800;color:#0f172a;}
.uw-stat-lbl{font-size:12px;font-weight:600;color:var(--txt3);}
.uw-mid{display:grid;grid-template-columns:1fr 2fr;gap:16px;margin-bottom:24px;}
.uw-chart-card,.uw-filter-card{background:var(--card);border:1px solid var(--border);border-radius:16px;padding:20px;}
.uw-filter-card{display:flex;flex-direction:column;gap:16px;}
.uw-sec-lbl{font-size:11px;font-weight:700;color:var(--txt3);letter-spacing:.08em;text-transform:uppercase;margin-bottom:8px;}
.uw-chart-wrap{position:relative;height:160px;margin-bottom:12px;}
.uw-chart-ctr{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;pointer-events:none;}
.uw-chart-ctr-val{font-size:28px;font-weight:800;color:#0f172a;}
.uw-chart-ctr-lbl{font-size:12px;color:var(--txt3);font-weight:600;}
.uw-legend{display:flex;flex-direction:column;gap:8px;}
.uw-legend-row{display:flex;justify-content:space-between;align-items:center;font-size:12px;}
.uw-leg-dot{display:inline-block;width:8px;height:8px;border-radius:50%;margin-right:6px;}
.uw-search{display:flex;align-items:center;gap:8px;border:1px solid var(--border);border-radius:10px;padding:8px 12px;background:#f8fafc;}
.uw-search input{border:none;background:transparent;outline:none;width:100%;font-size:13px;}
.uw-search i{color:var(--txt3);font-size:13px;}
.uw-select{width:100%;border:1px solid var(--border);border-radius:10px;padding:8px 12px;font-size:13px;background:#f8fafc;outline:none;}
.uw-tabs{display:flex;gap:6px;flex-wrap:wrap;}
.uw-tab{padding:5px 12px;border-radius:99px;font-size:12px;font-weight:700;border:1.5px solid var(--border);background:transparent;cursor:pointer;transition:all .15s;color:var(--txt3);}
.uw-tab.t-all{background:#0f172a;color:#fff;border-color:#0f172a;}
.uw-tab.t-pending{background:var(--amber-bg);color:var(--amber);border-color:var(--amber);}
.uw-tab.t-verified{background:var(--green-bg);color:var(--green);border-color:var(--green);}
.uw-tab.t-rejected{background:var(--red-bg);color:var(--red);border-color:var(--red);}
.uw-tbl-card{background:var(--card);border:1px solid var(--border);border-radius:16px;overflow:hidden;}
.uw-tbl-head{display:flex;justify-content:space-between;align-items:center;padding:16px 20px;border-bottom:1px solid var(--border);}
.uw-tbl-title{font-size:15px;font-weight:800;color:#0f172a;}
.uw-tbl{width:100%;border-collapse:collapse;}
.uw-tbl thead tr{background:#f8fafc;}
.uw-tbl th{padding:10px 14px;font-size:11px;font-weight:700;color:var(--txt3);text-align:left;letter-spacing:.06em;text-transform:uppercase;border-bottom:1px solid var(--border);}
.uw-tbl td{padding:12px 14px;font-size:13px;border-bottom:1px solid var(--border);color:#0f172a;}
.uw-tbl tbody tr:last-child td{border-bottom:none;}
.uw-tbl tbody tr:hover{background:#f8fafc;}
.uw-ava{width:32px;height:32px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;flex-shrink:0;}
.jb{display:inline-flex;align-items:center;padding:3px 10px;border-radius:99px;font-size:11px;font-weight:800;}
.jb-uts{background:#eff6ff;color:#2563eb;}
.jb-uas{background:#f5f3ff;color:#7c3aed;}
@media(max-width:900px){.uw-stats{grid-template-columns:1fr 1fr;}.uw-mid{grid-template-columns:1fr;}}
@media(max-width:600px){.uw{padding:16px;}.uw-stats{grid-template-columns:1fr;}}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<div class="uw">

    <div class="uw-title">Manajemen Pengajuan Ujian</div>
    <div class="uw-sub">Kelola dan verifikasi pengajuan ujian siswa</div>

    <div class="uw-stats">
        <div class="uw-stat amb">
            <div class="uw-stat-ic"><i class="fas fa-hourglass-half" style="color:var(--amber);"></i></div>
            <div class="uw-stat-val">{{ $totalPending }}</div>
            <div class="uw-stat-lbl">Total Pending</div>
        </div>
        <div class="uw-stat grn">
            <div class="uw-stat-ic"><i class="fas fa-circle-check" style="color:var(--green);"></i></div>
            <div class="uw-stat-val">{{ $totalVerified }}</div>
            <div class="uw-stat-lbl">Diverifikasi</div>
        </div>
        <div class="uw-stat red">
            <div class="uw-stat-ic"><i class="fas fa-circle-xmark" style="color:var(--red);"></i></div>
            <div class="uw-stat-val">{{ $totalRejected }}</div>
            <div class="uw-stat-lbl">Ditolak</div>
        </div>
    </div>

    <div class="uw-mid">
        <div class="uw-chart-card">
            <div class="uw-sec-lbl">Statistik</div>
            <div class="uw-chart-wrap">
                <canvas id="ujianChart"></canvas>
                <div class="uw-chart-ctr">
                    <div class="uw-chart-ctr-val">{{ $totalPending + $totalVerified + $totalRejected }}</div>
                    <div class="uw-chart-ctr-lbl">Total</div>
                </div>
            </div>
            <div class="uw-legend">
                <div class="uw-legend-row">
                    <span style="color:var(--txt2);"><span class="uw-leg-dot" style="background:#f59e0b;"></span>Pending</span>
                    <span style="font-weight:800;color:var(--amber);">{{ $totalPending }}</span>
                </div>
                <div class="uw-legend-row">
                    <span style="color:var(--txt2);"><span class="uw-leg-dot" style="background:#059669;"></span>Diverifikasi</span>
                    <span style="font-weight:800;color:var(--green);">{{ $totalVerified }}</span>
                </div>
                <div class="uw-legend-row">
                    <span style="color:var(--txt2);"><span class="uw-leg-dot" style="background:#dc2626;"></span>Ditolak</span>
                    <span style="font-weight:800;color:var(--red);">{{ $totalRejected }}</span>
                </div>
            </div>
        </div>

        <div class="uw-filter-card">
            <div>
                <div class="uw-sec-lbl">Cari Pengajuan</div>
                <div class="uw-search">
                    <i class="fas fa-search"></i>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Nama siswa atau mata pelajaran...">
                </div>
            </div>
            <div>
                <div class="uw-sec-lbl">Filter Jenis</div>
                <select class="uw-select" wire:model.live="filterJenis">
                    <option value="">Semua Jenis</option>
                    <option value="uts">UTS</option>
                    <option value="uas">UAS</option>
                </select>
            </div>
            <div>
                <div class="uw-sec-lbl">Filter Status</div>
                <div class="uw-tabs">
                    @foreach(['all' => 'Semua', 'pending' => 'Pending', 'verified' => 'Verified', 'rejected' => 'Ditolak'] as $val => $label)
                    <button class="uw-tab {{ $filterStatus === $val ? 't-'.$val : '' }}" wire:click="setFilter('{{ $val }}')">{{ $label }}</button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="uw-tbl-card">
        <div class="uw-tbl-head">
            <div class="uw-tbl-title">Daftar Pengajuan</div>
            <span style="font-size:12px;font-weight:600;color:var(--txt3);">{{ $ujians->total() }} total data</span>
        </div>
        <table class="uw-tbl">
            <thead>
                <tr>
                    <th style="padding-left:22px;width:46px;">#</th>
                    <th>Siswa</th>
                    <th>Jenis</th>
                    <th>Mata Pelajaran</th>
                    <th>Tgl Ujian</th>
                    <th>Status</th>
                    <th>Diajukan</th>
                    <th style="text-align:center;padding-right:22px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ujians as $ujian)
                @php
                    $cols=['#3b6ef8','#7c3aed','#059669','#d97706','#dc2626','#0891b2'];
                    $c=$cols[abs(crc32($ujian->user->name??''))%count($cols)];
                    $jClass=match($ujian->jenis??''){'uts'=>'jb-uts','uas'=>'jb-uas',default=>'jb-default'};
                @endphp
                <tr wire:key="ujian-{{ $ujian->id }}">
                    <td style="padding-left:22px;color:var(--txt3);font-weight:700;font-size:12px;">{{ $ujians->firstItem()+$loop->index }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div class="uw-ava" style="background:{{ $c }}1a;color:{{ $c }};">{{ strtoupper(substr($ujian->user->name??'U',0,1)) }}</div>
                            <span style="font-weight:700;">{{ $ujian->user->name??'-' }}</span>
                        </div>
                    </td>
                    <td><span class="jb {{ $jClass }}">{{ strtoupper($ujian->jenis??'-') }}</span></td>
                    <td style="font-weight:600;">{{ $ujian->mata_pelajaran }}</td>
                    <td style="color:var(--txt2);font-size:12px;font-weight:600;">
                        @if($ujian->tanggal_ujian)
                            {{ \Carbon\Carbon::parse($ujian->tanggal_ujian)->format('d M Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($ujian->status==='pending')<span class="stb stb-pending"><span class="stb-dot"></span> Pending</span>
                        @elseif($ujian->status==='verified')<span class="stb stb-verified"><span class="stb-dot"></span> Diverifikasi</span>
                        @else<span class="stb stb-rejected"><span class="stb-dot"></span> Ditolak</span>@endif
                    </td>
                    <td style="color:var(--txt3);font-size:12px;font-weight:500;">{{ $ujian->created_at->diffForHumans() }}</td>
                    <td style="text-align:center;padding-right:22px;">
                        @if($ujian->status==='pending')
                        <div style="display:flex;gap:6px;justify-content:center;">
                            <button class="act-btn act-grn" wire:click="approve({{ $ujian->id }})" title="Setujui"><i class="fas fa-check"></i></button>
                            <button class="act-btn act-red" wire:click="reject({{ $ujian->id }})" title="Tolak"><i class="fas fa-xmark"></i></button>
                        </div>
                        @elseif($ujian->status==='verified')
                        <i class="fas fa-check-circle" style="color:var(--green);font-size:18px;"></i>
                        @else
                        <i class="fas fa-circle-xmark" style="color:var(--red);font-size:18px;"></i>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="8"><div class="uw-empty"><div class="uw-empty-ic">📭</div><div class="uw-empty-txt">Belum ada pengajuan ujian.</div></div></td></tr>
                @endforelse
            </tbody>
        </table>
        @if($ujians->hasPages())
        <div class="uw-pagination">{{ $ujians->links() }}</div>
        @endif
    </div>

</div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function initChart(){
    const ctx=document.getElementById('ujianChart');
    if(!ctx)return;
    if(ctx._ci){ctx._ci.destroy();ctx._ci=null;}
    const p={{ $totalPending }},v={{ $totalVerified }},r={{ $totalRejected }},total=p+v+r;
    ctx._ci=new Chart(ctx,{type:'doughnut',data:{labels:['Pending','Diverifikasi','Ditolak'],datasets:[{data:total===0?[1,0,0]:[p,v,r],backgroundColor:total===0?['#e4e8f0']:['#f59e0b','#059669','#dc2626'],borderWidth:0,hoverOffset:6,borderRadius:4}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false},tooltip:{enabled:total>0}},cutout:'72%'}});
}
document.addEventListener('DOMContentLoaded',initChart);
document.addEventListener('livewire:navigated',initChart);
</script>
@endpush