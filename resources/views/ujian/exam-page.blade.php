{{-- resources/views/ujian/exam-page.blade.php --}}
@push('styles')
<style>
    :root {
        --primary:        #2563eb;
        --primary-dark:   #1d4ed8;
        --primary-light:  #eff6ff;
        --primary-border: #bfdbfe;
        --line:           #e2e8f0;
        --text-main:      #0f172a;
        --text-muted:     #64748b;
        --card-bg:        #ffffff;
        --shadow-soft:    0 10px 25px -5px rgba(15, 23, 42, .06), 0 8px 10px -6px rgba(15, 23, 42, .04);
    }

    .exam-portal-wrap {
        padding: 24px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ── BREADCRUMB ── */
    .exam-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--text-muted);
        margin-bottom: 16px;
    }

    .exam-breadcrumb a {
        color: var(--text-muted);
        transition: color .15s ease;
    }

    .exam-breadcrumb a:hover {
        color: var(--primary);
    }

    /* ── HERO BANNER ── */
    .hero-exam {
        border-radius: 20px;
        padding: 28px 32px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .hero-exam.accent-blue {
        background: linear-gradient(135deg, #1e40af 0%, #2563eb 60%, #3b82f6 100%);
        box-shadow: 0 16px 36px rgba(37, 99, 235, .22);
    }

    .hero-exam.accent-purple {
        background: linear-gradient(135deg, #581c87 0%, #7c3aed 60%, #a855f7 100%);
        box-shadow: 0 16px 36px rgba(124, 58, 237, .22);
    }

    .hero-exam::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -40px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .08);
        pointer-events: none;
    }

    .hero-exam::after {
        content: '';
        position: absolute;
        bottom: -50px;
        right: 160px;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .05);
        pointer-events: none;
    }

    .hero-exam-content {
        position: relative;
        z-index: 1;
        max-width: 650px;
    }

    .hero-kicker-tag {
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

    .hero-exam-title {
        font-size: 26px;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 8px;
        letter-spacing: -.02em;
    }

    .hero-exam-sub {
        font-size: 14px;
        color: rgba(255, 255, 255, .9);
        margin: 0 0 16px;
        line-height: 1.5;
    }

    .hero-badge-row {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .hero-info-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, .18);
        border: 1px solid rgba(255, 255, 255, .25);
        border-radius: 10px;
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 700;
        color: #ffffff;
        backdrop-filter: blur(4px);
    }

    .hero-actions-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        position: relative;
        z-index: 1;
    }

    .btn-hero-white {
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

    .btn-hero-white:hover {
        background: #f8fafc;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, .16);
    }

    .btn-hero-glass {
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

    .btn-hero-glass:hover {
        background: rgba(255, 255, 255, .25);
        transform: translateY(-2px);
        color: #ffffff;
    }

    /* ── STAT GRID ── */
    .stat-grid-exam {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    @media (max-width: 992px) {
        .stat-grid-exam { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 520px) {
        .stat-grid-exam { grid-template-columns: 1fr; }
    }

    .stat-card-item {
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

    .stat-card-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 28px -4px rgba(15, 23, 42, .08);
    }

    .stat-icon-circle {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .stat-icon-circle.blue   { background: #eff6ff; color: #2563eb; }
    .stat-icon-circle.green  { background: #ecfdf5; color: #059669; }
    .stat-icon-circle.purple { background: #faf5ff; color: #7c3aed; }
    .stat-icon-circle.amber  { background: #fffbeb; color: #d97706; }

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

    /* ── STATUS / ADMIN CARD ── */
    .admin-status-banner {
        border-radius: 18px;
        padding: 18px 24px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .admin-status-banner.verified {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
    }

    .admin-status-banner.pending {
        background: #fffbeb;
        border: 1px solid #fde68a;
        color: #92400e;
    }

    .admin-status-banner.rejected {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .admin-status-banner.info {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1e40af;
    }

    .status-banner-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .status-banner-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .verified .status-banner-icon { background: #d1fae5; color: #059669; }
    .pending .status-banner-icon  { background: #fef3c7; color: #d97706; }
    .rejected .status-banner-icon { background: #fee2e2; color: #dc2626; }
    .info .status-banner-icon     { background: #dbeafe; color: #2563eb; }

    .status-banner-title {
        font-size: 14px;
        font-weight: 800;
        margin: 0 0 2px;
    }

    .status-banner-desc {
        font-size: 12.5px;
        margin: 0;
        opacity: .9;
    }

    .btn-banner-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: all .15s ease;
        white-space: nowrap;
    }

    .pending .btn-banner-action, .verified .btn-banner-action {
        background: #ffffff;
        color: var(--text-main);
        border: 1px solid rgba(0,0,0,.08);
    }

    .rejected .btn-banner-action, .info .btn-banner-action {
        background: var(--primary);
        color: #ffffff;
    }

    .btn-banner-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,.1);
    }

    /* ── FILTER TOOLBAR ── */
    .exam-toolbar {
        background: var(--card-bg);
        border: 1px solid var(--line);
        border-radius: 18px;
        padding: 16px 20px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-soft);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .filter-pills {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .filter-pill-btn {
        background: #f8fafc;
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 7px 14px;
        font-size: 12.5px;
        font-weight: 700;
        color: var(--text-muted);
        cursor: pointer;
        transition: all .15s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .filter-pill-btn:hover {
        background: #f1f5f9;
        color: var(--text-main);
    }

    .filter-pill-btn.active {
        background: var(--primary);
        border-color: var(--primary);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, .25);
    }

    .exam-search-wrap {
        position: relative;
        min-width: 240px;
        flex: 1;
        max-width: 320px;
    }

    .exam-search-wrap i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 13px;
        pointer-events: none;
    }

    .exam-search-input {
        width: 100%;
        padding: 8px 14px 8px 36px;
        border-radius: 12px;
        border: 1px solid var(--line);
        background: #f8fafc;
        font-size: 13px;
        color: var(--text-main);
        outline: none;
        transition: all .15s ease;
    }

    .exam-search-input:focus {
        background: #ffffff;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
    }

    /* ── SUBJECT CARDS GRID ── */
    .subject-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 28px;
    }

    @media (max-width: 1050px) {
        .subject-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 650px) {
        .subject-grid { grid-template-columns: 1fr; }
    }

    .subject-card {
        background: var(--card-bg);
        border: 1px solid var(--line);
        border-radius: 18px;
        padding: 20px;
        box-shadow: var(--shadow-soft);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 16px;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        position: relative;
        overflow: hidden;
    }

    .subject-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 16px 32px -4px rgba(15, 23, 42, .1);
    }

    .subject-card.is-completed {
        border-left: 4px solid #10b981;
    }

    .subject-card.is-ready {
        border-left: 4px solid var(--primary);
    }

    .subject-card.is-locked {
        border-left: 4px solid #cbd5e1;
        opacity: .85;
    }

    .subject-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }

    .subject-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .subject-icon-box.blue   { background: #eff6ff; color: #2563eb; }
    .subject-icon-box.indigo { background: #e0e7ff; color: #4f46e5; }
    .subject-icon-box.emerald{ background: #ecfdf5; color: #059669; }
    .subject-icon-box.amber  { background: #fffbeb; color: #d97706; }
    .subject-icon-box.rose   { background: #fff1f2; color: #e11d48; }
    .subject-icon-box.purple { background: #faf5ff; color: #7c3aed; }

    .subject-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 999px;
        white-space: nowrap;
    }

    .subject-badge-pill.done  { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .subject-badge-pill.ready { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
    .subject-badge-pill.lock  { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }

    .subject-info-area {
        margin-top: 4px;
    }

    .subject-title {
        font-size: 16px;
        font-weight: 800;
        color: var(--text-main);
        margin: 0 0 4px;
        line-height: 1.3;
    }

    .subject-meta-row {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 12px;
        color: var(--text-muted);
        flex-wrap: wrap;
    }

    .subject-meta-item {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    /* Score banner inside completed cards */
    .score-summary-box {
        background: #f8fafc;
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 8px;
    }

    .score-val {
        font-size: 16px;
        font-weight: 800;
        color: #059669;
    }

    .score-sub {
        font-size: 11px;
        color: var(--text-muted);
        font-weight: 600;
    }

    /* Card buttons */
    .subject-card-footer {
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
    }

    .btn-subject-action {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all .15s ease;
    }

    .btn-subject-action.primary {
        background: var(--primary);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, .25);
    }

    .btn-subject-action.primary:hover {
        background: var(--primary-dark);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-subject-action.success {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }

    .btn-subject-action.success:hover {
        background: #d1fae5;
        color: #047857;
    }

    .btn-subject-action.disabled {
        background: #f1f5f9;
        color: #94a3b8;
        cursor: not-allowed;
    }

    /* ── EMPTY STATE ── */
    .exam-empty-full {
        background: var(--card-bg);
        border: 1px dashed var(--line);
        border-radius: 20px;
        padding: 48px 24px;
        text-align: center;
        grid-column: 1 / -1;
    }

    .exam-empty-icon {
        width: 68px;
        height: 68px;
        border-radius: 20px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: #94a3b8;
        margin: 0 auto 16px;
    }

    .exam-empty-full h4 {
        font-size: 16px;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 6px;
    }

    .exam-empty-full p {
        font-size: 13px;
        color: var(--text-muted);
        max-width: 400px;
        margin: 0 auto 16px;
        line-height: 1.5;
    }

    /* ── RULES / INFO CARD ── */
    .exam-rules-card {
        background: var(--card-bg);
        border: 1px solid var(--line);
        border-radius: 20px;
        box-shadow: var(--shadow-soft);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .exam-rules-head {
        padding: 16px 22px;
        background: #f8fafc;
        border-bottom: 1px solid var(--line);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .exam-rules-head i {
        color: var(--primary);
        font-size: 16px;
    }

    .exam-rules-title {
        font-size: 14px;
        font-weight: 800;
        color: var(--text-main);
        margin: 0;
    }

    .exam-rules-grid {
        padding: 20px 24px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    @media (max-width: 768px) {
        .exam-rules-grid { grid-template-columns: 1fr; }
    }

    .exam-rule-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .exam-rule-num {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #eff6ff;
        color: var(--primary);
        font-weight: 800;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .exam-rule-text h5 {
        font-size: 13px;
        font-weight: 800;
        color: var(--text-main);
        margin: 0 0 3px;
    }

    .exam-rule-text p {
        font-size: 12px;
        color: var(--text-muted);
        margin: 0;
        line-height: 1.5;
    }

    /* ── UPLOAD MODAL ── */
    .modal-backdrop-custom {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, .6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    .modal-box-custom {
        background: #ffffff;
        border-radius: 20px;
        max-width: 520px;
        width: 100%;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, .25);
        overflow: hidden;
        animation: modalScaleUp .2s ease;
    }

    @keyframes modalScaleUp {
        from { opacity: 0; transform: scale(.95); }
        to   { opacity: 1; transform: scale(1); }
    }

    .modal-head-custom {
        padding: 20px 24px;
        border-bottom: 1px solid var(--line);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-title-custom {
        font-size: 16px;
        font-weight: 800;
        color: var(--text-main);
        margin: 0;
    }

    .modal-close-custom {
        background: none;
        border: none;
        font-size: 20px;
        color: var(--text-muted);
        cursor: pointer;
        line-height: 1;
    }

    .modal-body-custom {
        padding: 24px;
    }

    .upzone-box {
        border: 2px dashed #cbd5e1;
        border-radius: 14px;
        padding: 28px 16px;
        text-align: center;
        cursor: pointer;
        transition: all .2s ease;
        background: #f8fafc;
        margin-bottom: 16px;
    }

    .upzone-box:hover, .upzone-box.dragover {
        border-color: var(--primary);
        background: #eff6ff;
    }

    .upzone-icon {
        font-size: 32px;
        color: var(--primary);
        margin-bottom: 8px;
    }

    .upzone-title {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 4px;
    }

    .upzone-desc {
        font-size: 11.5px;
        color: var(--text-muted);
        margin: 0;
    }

    .preview-file-box {
        display: none;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 10px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        margin-bottom: 16px;
        font-size: 12.5px;
        color: #065f46;
        font-weight: 600;
    }

    .preview-file-box.show {
        display: flex;
    }

    /* ── RESPONSIVE MOBILE ── */
    @media (max-width: 768px) {
        .exam-portal-wrap { padding: 16px 12px; }
        .hero-exam { padding: 22px 18px; border-radius: 16px; }
        .hero-exam-title { font-size: 20px; }
        .hero-actions-row { width: 100%; }
        .hero-actions-row a, .hero-actions-row button { flex: 1; justify-content: center; }
        .exam-toolbar { padding: 14px 16px; flex-direction: column; align-items: stretch; }
        .exam-search-wrap { max-width: 100%; }
        .filter-pills { overflow-x: auto; padding-bottom: 4px; flex-wrap: nowrap; }
    }
</style>
@endpush

@php
    $cardCollection = collect($cards);
    $totalSubjects = $cardCollection->count();
    $completedCount = $cardCollection->filter(fn($c) => $c['isDone'])->count();
    $readyCount = $cardCollection->filter(fn($c) => $c['canTake'])->count();

    $paymentStatus = $payment?->status ?? 'belum';

    function getExamSubjectColorPill($name) {
        $norm = strtolower($name);
        if (str_contains($norm, 'matematika') || str_contains($norm, 'math')) return ['class' => 'amber', 'icon' => 'fa-calculator'];
        if (str_contains($norm, 'inggris') || str_contains($norm, 'english')) return ['class' => 'indigo', 'icon' => 'fa-language'];
        if (str_contains($norm, 'indonesia')) return ['class' => 'rose', 'icon' => 'fa-book'];
        if (str_contains($norm, 'ipa') || str_contains($norm, 'fisika') || str_contains($norm, 'biologi') || str_contains($norm, 'kimia')) return ['class' => 'emerald', 'icon' => 'fa-flask'];
        if (str_contains($norm, 'rpl') || str_contains($norm, 'komputer') || str_contains($norm, 'web') || str_contains($norm, 'informatika')) return ['class' => 'blue', 'icon' => 'fa-code'];
        if (str_contains($norm, 'agama') || str_contains($norm, 'pai')) return ['class' => 'emerald', 'icon' => 'fa-mosque'];
        if (str_contains($norm, 'pkn') || str_contains($norm, 'sejarah')) return ['class' => 'purple', 'icon' => 'fa-landmark'];
        return ['class' => 'blue', 'icon' => 'fa-graduation-cap'];
    }
@endphp

<div class="exam-portal-wrap">

    {{-- BREADCRUMB --}}
    <nav class="exam-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Beranda</a>
        <i class="fas fa-chevron-right" style="font-size: 10px; opacity: .5;"></i>
        <span>Ujian</span>
        <i class="fas fa-chevron-right" style="font-size: 10px; opacity: .5;"></i>
        <span style="color: var(--text-main); font-weight: 700;">{{ strtoupper($jenis) }}</span>
    </nav>

    {{-- HERO BANNER --}}
    <div class="hero-exam {{ $accent === 'purple' ? 'accent-purple' : 'accent-blue' }}">
        <div class="hero-exam-content">
            <div class="hero-kicker-tag">
                <i class="fas fa-file-signature"></i> {{ $pageTag }} · {{ date('Y') }}/{{ date('Y') + 1 }}
            </div>
            <h1 class="hero-exam-title">{{ $pageTitle }}</h1>
            <p class="hero-exam-sub">{{ $pageSubtitle }}</p>
            <div class="hero-badge-row">
                <div class="hero-info-chip">
                    <i class="fas fa-chalkboard-teacher"></i> Kelas: <strong>{{ $student->class_id ?? '-' }}</strong>
                </div>
                <div class="hero-info-chip">
                    <i class="fas fa-user-graduate"></i> Siswa: <strong>{{ $student->name ?? Auth::user()->name }}</strong>
                </div>
                @if(!empty($student?->nis))
                <div class="hero-info-chip">
                    <i class="fas fa-id-card"></i> NIS: <strong>{{ $student->nis }}</strong>
                </div>
                @endif
            </div>
        </div>
        <div class="hero-actions-row">
            <a href="{{ route('ujian.jadwal') }}" class="btn-hero-white">
                <i class="fas fa-calendar-alt text-primary"></i> Jadwal Ujian
            </a>
            @if($jenis === 'uts')
                <a href="{{ route('ujian.uas') }}" class="btn-hero-glass">
                    Halaman UAS <i class="fas fa-arrow-right"></i>
                </a>
            @else
                <a href="{{ route('ujian.uts') }}" class="btn-hero-glass">
                    <i class="fas fa-arrow-left"></i> Halaman UTS
                </a>
            @endif
        </div>
    </div>

    {{-- STAT METRICS GRID --}}
    <div class="stat-grid-exam">
        <div class="stat-card-item">
            <div class="stat-icon-circle blue"><i class="fas fa-book-open"></i></div>
            <div>
                <div class="stat-val-text">{{ $totalSubjects }}</div>
                <div class="stat-label-text">Total Mapel Ujian</div>
            </div>
        </div>
        <div class="stat-card-item">
            <div class="stat-icon-circle purple"><i class="fas fa-play"></i></div>
            <div>
                <div class="stat-val-text">{{ $readyCount }}</div>
                <div class="stat-label-text">Siap Dikerjakan</div>
            </div>
        </div>
        <div class="stat-card-item">
            <div class="stat-icon-circle green"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="stat-val-text">{{ $completedCount }}</div>
                <div class="stat-label-text">Sudah Dikerjakan</div>
            </div>
        </div>
        <div class="stat-card-item">
            <div class="stat-icon-circle amber"><i class="fas fa-shield-alt"></i></div>
            <div>
                <div class="stat-val-text" style="font-size: 16px; text-transform: uppercase;">
                    @if($paymentStatus === 'verified')
                        <span style="color: #059669;">Disetujui</span>
                    @elseif($paymentStatus === 'pending')
                        <span style="color: #d97706;">Pending</span>
                    @elseif($paymentStatus === 'rejected')
                        <span style="color: #dc2626;">Ditolak</span>
                    @else
                        <span style="color: #2563eb;">Tersedia</span>
                    @endif
                </div>
                <div class="stat-label-text">Status Administrasi</div>
            </div>
        </div>
    </div>

    {{-- STATUS ADMINISTRASI / VERIFIKASI BANNER --}}
    @if($paymentStatus === 'verified')
        <div class="admin-status-banner verified">
            <div class="status-banner-left">
                <div class="status-banner-icon"><i class="fas fa-shield-check"></i></div>
                <div>
                    <h5 class="status-banner-title">Administrasi Ujian Terverifikasi</h5>
                    <p class="status-banner-desc">Status administrasi {{ strtoupper($jenis) }} Anda telah disetujui. Silakan kerjakan soal ujian mata pelajaran di bawah ini.</p>
                </div>
            </div>
            <div>
                <span class="badge bg-success" style="font-size: 11px; padding: 6px 12px; border-radius: 8px;">Kartu Ujian Aktif</span>
            </div>
        </div>
    @elseif($paymentStatus === 'pending')
        <div class="admin-status-banner pending">
            <div class="status-banner-left">
                <div class="status-banner-icon"><i class="fas fa-clock"></i></div>
                <div>
                    <h5 class="status-banner-title">Pengajuan Bukti Sedang Menunggu Verifikasi Admin</h5>
                    <p class="status-banner-desc">Bukti pengajuan administrasi {{ strtoupper($jenis) }} telah diterima sistem dan sedang diperiksa oleh admin sekolah.</p>
                </div>
            </div>
            <div>
                <button type="button" class="btn-banner-action" onclick="openUploadModal()">
                    <i class="fas fa-eye"></i> Rincian Pengajuan
                </button>
            </div>
        </div>
    @elseif($paymentStatus === 'rejected')
        <div class="admin-status-banner rejected">
            <div class="status-banner-left">
                <div class="status-banner-icon"><i class="fas fa-triangle-exclamation"></i></div>
                <div>
                    <h5 class="status-banner-title">Pengajuan Ditolak: {{ $payment->catatan_admin ?? 'Bukti tidak terbaca/tidak valid.' }}</h5>
                    <p class="status-banner-desc">Silakan unggah kembali bukti pembayaran / administrasi yang jelas untuk mengaktifkan akses pengerjaan soal.</p>
                </div>
            </div>
            <div>
                <button type="button" class="btn-banner-action" onclick="openUploadModal()">
                    <i class="fas fa-upload"></i> Unggah Ulang Bukti
                </button>
            </div>
        </div>
    @else
        <div class="admin-status-banner info">
            <div class="status-banner-left">
                <div class="status-banner-icon"><i class="fas fa-info-circle"></i></div>
                <div>
                    <h5 class="status-banner-title">Portal Pengerjaan Ujian {{ strtoupper($jenis) }} Siap Digunakan</h5>
                    <p class="status-banner-desc">Pilih mata pelajaran yang aktif untuk memulai pengerjaan. Jika diperlukan bukti administrasi fisik/kartu, Anda dapat mengunggahnya di sini.</p>
                </div>
            </div>
            <div>
                <button type="button" class="btn-banner-action" onclick="openUploadModal()">
                    <i class="fas fa-file-upload"></i> Upload Bukti Administrasi
                </button>
            </div>
        </div>
    @endif

    {{-- TOOLBAR: FILTER & LIVE SEARCH --}}
    <div class="exam-toolbar">
        <div class="filter-pills" id="examFilterPills">
            <button type="button" class="filter-pill-btn active" data-filter="all">
                Semua Mapel ({{ $totalSubjects }})
            </button>
            <button type="button" class="filter-pill-btn" data-filter="ready">
                Siap Dikerjakan ({{ $readyCount }})
            </button>
            <button type="button" class="filter-pill-btn" data-filter="done">
                Sudah Selesai ({{ $completedCount }})
            </button>
            <button type="button" class="filter-pill-btn" data-filter="pending">
                Soal Belum Lengkap ({{ $totalSubjects - $readyCount - $completedCount }})
            </button>
        </div>

        <div class="exam-search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="examSubjectSearch" class="exam-search-input" placeholder="Cari mata pelajaran...">
        </div>
    </div>

    {{-- SUBJECT CARDS GRID --}}
    <div class="subject-grid" id="examGrid">
        @forelse($cards as $item)
            @php
                $pillColor = getExamSubjectColorPill($item['subject']->name);
                $isDone = $item['isDone'];
                $canTake = $item['canTake'];
                $qCount = $item['questionCount'];

                $statusCategory = 'pending';
                if ($isDone) $statusCategory = 'done';
                elseif ($canTake) $statusCategory = 'ready';
            @endphp
            <div class="subject-card {{ $isDone ? 'is-completed' : ($canTake ? 'is-ready' : 'is-locked') }}"
                 data-status="{{ $statusCategory }}"
                 data-subject="{{ strtolower($item['subject']->name) }}">
                
                <div>
                    <div class="subject-card-top">
                        <div class="subject-icon-box {{ $pillColor['class'] }}">
                            <i class="fas {{ $pillColor['icon'] }}"></i>
                        </div>
                        @if($isDone)
                            <span class="subject-badge-pill done"><i class="fas fa-check"></i> Selesai</span>
                        @elseif($canTake)
                            <span class="subject-badge-pill ready"><i class="fas fa-clock"></i> Siap Ujian</span>
                        @else
                            <span class="subject-badge-pill lock"><i class="fas fa-lock"></i> Belum Siap</span>
                        @endif
                    </div>

                    <div class="subject-info-area">
                        <h3 class="subject-title">{{ $item['subject']->name }}</h3>
                        <div class="subject-meta-row">
                            <span class="subject-meta-item">
                                <i class="fas fa-chalkboard"></i> Kelas {{ $student->class_id ?? '-' }}
                            </span>
                            <span class="subject-meta-item">
                                <i class="fas fa-list-ol"></i> {{ $qCount }} Soal
                            </span>
                        </div>

                        @if($isDone && $item['latestAttempt'])
                            <div class="score-summary-box">
                                <div>
                                    <div class="score-sub">Nilai Akhir:</div>
                                    <div class="score-val">{{ round($item['latestAttempt']->score, 1) }} <span style="font-size: 12px; color: var(--text-muted); font-weight: 500;">/ {{ round($item['latestAttempt']->max_score, 1) }}</span></div>
                                </div>
                                <div style="text-align: right;">
                                    <div class="score-sub">Pengerjaan:</div>
                                    <div style="font-size: 11.5px; font-weight: 700; color: var(--text-main);">
                                        {{ $item['latestAttempt']->submitted_at ? \Carbon\Carbon::parse($item['latestAttempt']->submitted_at)->translatedFormat('d M H:i') : 'Selesai' }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="subject-card-footer">
                    @if($isDone)
                        <a href="{{ route('ujian.result', [$jenis, $item['subject'], 'attempt' => $item['latestAttempt']->id]) }}" class="btn-subject-action success">
                            <i class="fas fa-chart-line"></i> Lihat Hasil Ujian
                        </a>
                    @elseif($canTake)
                        <a href="{{ route('ujian.take', [$jenis, $item['subject']]) }}" class="btn-subject-action primary">
                            <i class="fas fa-play"></i> Mulai Kerjakan Ujian
                        </a>
                    @elseif($qCount < 5)
                        <button type="button" disabled class="btn-subject-action disabled" title="Minimal 5 butir soal belum diunggah oleh guru mapel">
                            <i class="fas fa-lock"></i> Soal Belum Lengkap ({{ $qCount }}/5)
                        </button>
                    @else
                        <button type="button" disabled class="btn-subject-action disabled">
                            <i class="fas fa-lock"></i> Menunggu Akses
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="exam-empty-full">
                <div class="exam-empty-icon"><i class="fas fa-folder-open"></i></div>
                <h4>Belum Ada Mata Pelajaran Ujian</h4>
                <p>Mata pelajaran untuk kelas {{ $student->class_id ?? 'Anda' }} belum ditambahkan ke dalam jadwal ujian aktif.</p>
                <a href="{{ route('ujian.jadwal') }}" class="btn-banner-action" style="background: var(--primary); color: #fff;">
                    <i class="fas fa-calendar-alt"></i> Cek Jadwal Terlebih Dahulu
                </a>
            </div>
        @endforelse

        {{-- Dynamic no search results row --}}
        <div class="exam-empty-full" id="noExamSearch" style="display: none;">
            <div class="exam-empty-icon"><i class="fas fa-search-minus"></i></div>
            <h4>Mata Pelajaran Tidak Ditemukan</h4>
            <p>Tidak ada mata pelajaran yang cocok dengan filter atau kata kunci pencarian Anda.</p>
            <button type="button" class="btn-banner-action" style="background: var(--primary); color: #fff;" id="btnResetExamSearch">
                <i class="fas fa-rotate-left"></i> Reset Filter
            </button>
        </div>
    </div>

    {{-- TATA TERTIB PENGERJAAN UJIAN CARD --}}
    <div class="exam-rules-card">
        <div class="exam-rules-head">
            <i class="fas fa-info-circle"></i>
            <h4 class="exam-rules-title">Petunjuk & Tata Tertib Pengerjaan Ujian Online</h4>
        </div>
        <div class="exam-rules-grid">
            <div class="exam-rule-item">
                <div class="exam-rule-num">1</div>
                <div class="exam-rule-text">
                    <h5>Satu Kali Kesempatan Pengerjaan</h5>
                    <p>Ujian hanya dapat dikerjakan satu kali untuk tiap mata pelajaran. Pastikan waktu dan fokus Anda terjaga dengan baik.</p>
                </div>
            </div>
            <div class="exam-rule-item">
                <div class="exam-rule-num">2</div>
                <div class="exam-rule-text">
                    <h5>Penghitung Waktu Berjalan Mundur</h5>
                    <p>Setelah tombol "Mulai Ujian" ditekan, waktu pengerjaan akan terus berjalan dan jawaban otomatis terkirim saat waktu habis.</p>
                </div>
            </div>
            <div class="exam-rule-item">
                <div class="exam-rule-num">3</div>
                <div class="exam-rule-text">
                    <h5>Larangan Navigasi Eksternal</h5>
                    <p>Sistem memonitor aktivitas halaman. Dilarang berpindah tab atau memuat aplikasi lain selama ujian berlangsung.</p>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- MODAL UNGGAH BUKTI ADMINISTRASI UJIAN --}}
<div class="modal-backdrop-custom" id="uploadModal">
    <div class="modal-box-custom">
        <div class="modal-head-custom">
            <h4 class="modal-title-custom">Upload Bukti Administrasi {{ strtoupper($jenis) }}</h4>
            <button type="button" class="modal-close-custom" onclick="closeUploadModal()">&times;</button>
        </div>
        <div class="modal-body-custom">
            <form action="{{ route('ujian.upload') }}" method="POST" enctype="multipart/form-data" id="uploadBuktiForm">
                @csrf
                <input type="hidden" name="jenis" value="{{ $jenis }}">

                <div class="mb-3">
                    <label class="form-label fw-bold" style="font-size: 13px;">Tanggal Pengajuan / Ujian</label>
                    <input type="date" name="tanggal_ujian" class="form-control" value="{{ date('Y-m-d') }}" required style="border-radius: 10px; font-size: 13px;">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold" style="font-size: 13px;">Berkas Bukti / Kartu Ujian (JPG, PNG, PDF maks 5MB)</label>
                    <div class="upzone-box" id="dropZone" onclick="document.getElementById('fileBuktiInput').click()">
                        <div class="upzone-icon"><i class="fas fa-cloud-arrow-up"></i></div>
                        <div class="upzone-title">Klik atau seret file ke sini</div>
                        <p class="upzone-desc">Format yang didukung: JPG, PNG, atau PDF (Maksimal 5MB)</p>
                    </div>
                    <input type="file" name="bukti" id="fileBuktiInput" style="display: none;" accept=".jpg,.jpeg,.png,.pdf" required onchange="handleFileSelected(this)">
                    <div class="preview-file-box" id="filePreviewBox">
                        <i class="fas fa-file-check" style="font-size: 16px;"></i>
                        <span id="filePreviewName">nama_file.pdf</span>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="button" class="btn btn-light" style="border-radius: 10px; font-size: 13px; font-weight: 700;" onclick="closeUploadModal()">Batal</button>
                    <button type="submit" class="btn btn-primary" style="border-radius: 10px; font-size: 13px; font-weight: 700; background: var(--primary); border: none;">
                        <i class="fas fa-paper-plane me-1"></i> Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openUploadModal() {
        const modal = document.getElementById('uploadModal');
        if (modal) {
            modal.style.display = 'flex';
        }
    }

    function closeUploadModal() {
        const modal = document.getElementById('uploadModal');
        if (modal) {
            modal.style.display = 'none';
        }
    }

    function handleFileSelected(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const previewBox = document.getElementById('filePreviewBox');
            const previewName = document.getElementById('filePreviewName');
            if (previewBox && previewName) {
                previewName.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
                previewBox.classList.add('show');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Drag & drop handlers
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileBuktiInput');

        if (dropZone && fileInput) {
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.classList.add('dragover');
                });
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.classList.remove('dragover');
                });
            });

            dropZone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    handleFileSelected(fileInput);
                }
            });
        }

        // Search & Filter Logic
        const filterBtns = document.querySelectorAll('#examFilterPills .filter-pill-btn');
        const searchInput = document.getElementById('examSubjectSearch');
        const cards = document.querySelectorAll('.subject-card');
        const noResultBox = document.getElementById('noExamSearch');
        const resetBtn = document.getElementById('btnResetExamSearch');

        let activeFilter = 'all';
        let searchQuery = '';

        function applyFilters() {
            let visibleCount = 0;

            cards.forEach(function (card) {
                const cardStatus = card.getAttribute('data-status') || '';
                const cardSubj = card.getAttribute('data-subject') || '';

                const matchesFilter = (activeFilter === 'all') || (cardStatus === activeFilter);
                const matchesSearch = !searchQuery || cardSubj.includes(searchQuery);

                if (matchesFilter && matchesSearch) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (noResultBox) {
                if (visibleCount === 0 && cards.length > 0) {
                    noResultBox.style.display = 'block';
                } else {
                    noResultBox.style.display = 'none';
                }
            }
        }

        filterBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                activeFilter = this.getAttribute('data-filter');
                applyFilters();
            });
        });

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                searchQuery = this.value.trim().toLowerCase();
                applyFilters();
            });
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', function () {
                activeFilter = 'all';
                searchQuery = '';
                if (searchInput) searchInput.value = '';
                filterBtns.forEach(b => {
                    if (b.getAttribute('data-filter') === 'all') b.classList.add('active');
                    else b.classList.remove('active');
                });
                applyFilters();
            });
        }
    });
</script>
@endpush