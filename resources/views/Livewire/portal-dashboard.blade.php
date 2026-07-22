<div>
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-ic" style="background:var(--green-bg);color:var(--green);"><i class="fas fa-circle-check"></i></div>
            <div><div class="stat-val">{{ $lunas }}</div><div class="stat-lbl">SPP Lunas</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-ic" style="background:var(--amber-bg);color:var(--amber);"><i class="fas fa-clock"></i></div>
            <div><div class="stat-val">{{ $pending }}</div><div class="stat-lbl">Menunggu Verif</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-ic" style="background:var(--red-bg);color:var(--red);"><i class="fas fa-circle-xmark"></i></div>
            <div><div class="stat-val">{{ $belumBayar }}</div><div class="stat-lbl">Belum Bayar</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-ic" style="background:var(--blue-bg);color:var(--blue);"><i class="fas fa-coins"></i></div>
            <div>
                <div class="stat-val" style="font-size:14px;">Rp {{ number_format($totalBayar, 0, ',', '.') }}</div>
                <div class="stat-lbl">Total Terbayar</div>
            </div>
        </div>
    </div>

    <!-- Overview grid removed per request (quick-actions removed) -->
</div>
