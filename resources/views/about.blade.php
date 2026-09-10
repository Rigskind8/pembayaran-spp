@extends('layouts.premium')

@php
    $schoolName = $schoolName ?? 'SMK Travina Prima';
    $logoRaw = $logoSekolah ?? null;
    $isAbsoluteLogo = is_string($logoRaw) && (str_starts_with($logoRaw, 'http://') || str_starts_with($logoRaw, 'https://'));
    $schoolLogoSrc = !empty($logoRaw)
        ? ($isAbsoluteLogo ? $logoRaw : asset('storage/' . ltrim((string) $logoRaw, '/')))
        : asset('images/about-hero.svg');

    $waNumber = \App\Models\Setting::get('wa_admin_number', '6281388796229');
    $waAdminUrl = 'https://wa.me/' . preg_replace('/\D+/', '', (string) $waNumber) . '?text=' . rawurlencode('Halo Admin ' . $schoolName . ', saya ingin daftar sekarang.');

    $visualImages = [
        asset('images/about-hero.svg'),
        asset('images/gallery-1.svg'),
        asset('images/facility-lab.svg'),
        asset('images/facility-library.svg'),
        asset('images/about-hero.svg'),
    ];

    $defaultGallery = [
        ['url' => $visualImages[0], 'label' => 'Gedung SMK Travina Prima'],
        ['url' => $visualImages[1], 'label' => 'Kegiatan Sekolah'],
        ['url' => $visualImages[2], 'label' => 'Praktik TKJ'],
        ['url' => $visualImages[3], 'label' => 'Perpustakaan'],
        ['url' => $visualImages[4], 'label' => 'Suasana Sekolah'],
    ];

    $about = is_array($about ?? null) ? $about : [];
    $rawGallery = $about['gallery'] ?? [];
    $gallery = [];

    if (is_array($rawGallery)) {
        foreach ($rawGallery as $item) {
            if (is_string($item) && trim($item) !== '') {
                $gallery[] = ['url' => $item, 'label' => null];
                continue;
            }

            if (is_array($item) && !empty($item['url']) && is_string($item['url'])) {
                $gallery[] = [
                    'url' => $item['url'],
                    'label' => isset($item['label']) && is_string($item['label']) && trim($item['label']) !== ''
                        ? trim($item['label'])
                        : null,
                ];
            }
        }
    }

    if (count($gallery) === 0) {
        $gallery = $defaultGallery;
    }

    $defaultWebImages = array_column($gallery, 'url');
    $galleryTableNames = array_map(function ($item, $index) use ($defaultGallery) {
        if (!empty($item['label'])) {
            return $item['label'];
        }

        return $defaultGallery[$index % count($defaultGallery)]['label'] ?? 'Foto Sekolah';
    }, $gallery, array_keys($gallery));

    $studentCount = 0;
    $teacherCount = 0;

    $schoolData = [
        'NPSN' => '20223090',
        'Status' => 'Swasta',
        'Akreditasi' => 'A',
        'Tahun Berdiri' => '2001',
        'Kepala Sekolah' => 'Sabaruddin Sinulingga',
        'Alamat' => 'Jl. Kali Abang No. 10, Perwira, Bekasi Utara, Kota Bekasi, Jawa Barat',
        'Telepon' => '02188880097',
        'Email' => 'travinaprima_bekasi@yahoo.com',
    ];

    $schoolDirection = [
        [
            'label' => 'Visi',
            'title' => 'Menjadi sekolah kejuruan yang unggul dan berkarakter',
            'description' => 'Mewujudkan lulusan yang siap kerja, siap lanjut studi, dan siap bersaing dengan bekal kompetensi serta etika yang kuat.',
        ],
        [
            'label' => 'Misi',
            'title' => 'Pembelajaran yang aplikatif dan terarah',
            'description' => 'Menguatkan praktik TKR dan TKJ, membiasakan disiplin belajar, serta menumbuhkan budaya kerja yang tertib dan bertanggung jawab.',
        ],
        [
            'label' => 'Nilai',
            'title' => 'Disiplin, kompeten, dan berintegritas',
            'description' => 'Nilai ini menjadi dasar setiap proses belajar, kegiatan praktik, dan pembentukan karakter siswa di sekolah.',
        ],
    ];

    $schoolFacilities = [
        [
            'icon' => 'fa-laptop-code',
            'title' => 'Laboratorium TKJ',
            'description' => 'Ruang praktik untuk instalasi jaringan, perakitan komputer, dan pembelajaran teknis yang lebih langsung.',
        ],
        [
            'icon' => 'fa-gear',
            'title' => 'Bengkel TKR',
            'description' => 'Tempat latihan perawatan kendaraan, sistem mesin, dan kelistrikan dasar yang relevan dengan dunia otomotif.',
        ],
        [
            'icon' => 'fa-chalkboard-user',
            'title' => 'Ruang kelas nyaman',
            'description' => 'Kelas yang mendukung pembelajaran harian agar siswa lebih fokus, tertib, dan nyaman mengikuti pelajaran.',
        ],
        [
            'icon' => 'fa-screwdriver-wrench',
            'title' => 'Sarana praktik',
            'description' => 'Peralatan praktik disiapkan untuk membantu siswa belajar secara bertahap dari teori ke keterampilan langsung.',
        ],
    ];

    $schoolAchievements = [
        [
            'badge' => 'A',
            'title' => 'Bukti mutu Akreditasi A',
            'description' => 'Menjadi penegas kualitas layanan pendidikan, tata kelola, dan pembelajaran yang layak dipercaya.',
        ],
        [
            'badge' => '2001',
            'title' => 'Pengalaman sejak 2001',
            'description' => 'Perjalanan panjang sekolah menunjukkan konsistensi dalam membina siswa dari generasi ke generasi.',
        ],
        [
            'badge' => '2',
            'title' => 'Dua jurusan inti unggulan',
            'description' => 'Fokus pada TKR dan TKJ memberi arah pembelajaran yang lebih jelas, praktis, dan relevan untuk dunia kerja.',
        ],
        [
            'badge' => 'Bekasi',
            'title' => 'Lokasi strategis di Bekasi',
            'description' => 'Berada di Bekasi Utara sehingga mudah dijangkau dan nyaman untuk kebutuhan belajar sehari-hari.',
        ],
    ];

    $schoolAchievementMetrics = [
        ['value' => 'A', 'label' => 'Akreditasi'],
        ['value' => '2001', 'label' => 'Berdiri sejak'],
        ['value' => '2', 'label' => 'Jurusan inti'],
        ['value' => 'Bekasi Utara', 'label' => 'Lokasi'],
    ];

    $schoolAchievementProofs = [
        [
            'year' => '2018',
            'title' => 'Raih Akreditasi A',
            'detail' => 'SMK Travina Prima meraih Akreditasi A berdasarkan SK BAN-SM 1214/BAN-SM/SK/2018.',
        ],
        [
            'year' => '2001',
            'title' => 'Operasional resmi sekolah',
            'detail' => 'Sekolah resmi berdiri dan beroperasi pada 9 Januari 2001 sebagai lembaga pendidikan kejuruan.',
        ],
        [
            'year' => '2026',
            'title' => 'Penguatan program TKR dan TKJ',
            'detail' => 'Arah pembelajaran dipertegas pada dua jurusan inti agar lebih fokus, aplikatif, dan relevan.',
        ],
    ];

    $schoolTestimonials = [
        [
            'role' => 'Kepala sekolah',
            'name' => 'Pimpinan sekolah',
            'quote' => 'Kami menempatkan disiplin, karakter, dan kesiapan kerja sebagai satu kesatuan dalam proses pendidikan.',
        ],
        [
            'role' => 'Guru produktif',
            'name' => 'Pengajar TKR dan TKJ',
            'quote' => 'Pembelajaran praktik yang terarah membuat siswa lebih cepat paham dan lebih percaya diri di kelas kejuruan.',
        ],
        [
            'role' => 'Alumni',
            'name' => 'Lulusan sekolah',
            'quote' => 'Fokus jurusan dan suasana belajar yang tertib membuat saya lebih siap melangkah ke tahap berikutnya.',
        ],
        [
            'role' => 'Orang tua',
            'name' => 'Wali siswa',
            'quote' => 'Informasi sekolah yang jelas dan komunikatif membuat kami lebih yakin dengan arah pendidikan anak.',
        ],
    ];

    $mapsQuery = rawurlencode($schoolData['Alamat']);
    $mapsEmbedUrl = 'https://www.google.com/maps?q=' . $mapsQuery . '&output=embed';
    $mapsLink = 'https://www.google.com/maps/search/?api=1&query=' . $mapsQuery;

    $heroOverlayLeftTitle = !empty($about['hero_overlay_left_title'])
        ? (string) $about['hero_overlay_left_title']
        : 'Lingkungan belajar yang rapi';
    $heroOverlayLeftSubtitle = !empty($about['hero_overlay_left_subtitle'])
        ? (string) $about['hero_overlay_left_subtitle']
        : 'Visual utama sekolah dan nuansa modern.';
    $heroOverlayRightTitle = !empty($about['hero_overlay_right_title'])
        ? (string) $about['hero_overlay_right_title']
        : 'TKR + TKJ';
    $heroOverlayRightSubtitle = !empty($about['hero_overlay_right_subtitle'])
        ? (string) $about['hero_overlay_right_subtitle']
        : 'Fokus jurusan utama.';

    $heroOverlayImage = isset($about['hero_overlay_image']) && is_string($about['hero_overlay_image'])
        ? trim($about['hero_overlay_image'])
        : '';
    $heroImage = $heroOverlayImage !== ''
        ? $heroOverlayImage
        : (count($gallery) >= 2 ? $gallery[1]['url'] : $visualImages[1]);
@endphp

@section('title', $schoolName . ' - Tentang Kami')

@section('content')
<style>
    :root {
        --bg: #eef3fb;
        --bg-soft: #f8fbff;
        --ink: #0d1b34;
        --muted: #60708d;
        --line: rgba(13, 27, 52, 0.08);
        --primary: #123a6f;
        --primary-soft: #dbeafe;
        --accent: #1d4ed8;
        --accent-2: #0ea5e9;
        --accent-3: #06b6d4;
        --radius: 20px;
        --radius-lg: 28px;
    }

    .about-wrap {
        position: relative;
        background:
            radial-gradient(circle at top left, rgba(29, 78, 216, 0.14), transparent 28%),
            radial-gradient(circle at top right, rgba(14, 165, 233, 0.16), transparent 32%),
            linear-gradient(180deg, #ffffff 0%, #eef3fb 100%);
        color: var(--ink);
        font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
        overflow: hidden;
    }
    .scroll-progress {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 3px;
        background: rgba(13, 27, 52, 0.08);
        z-index: 120;
        pointer-events: none;
    }
    .scroll-progress-bar {
        width: 100%;
        height: 100%;
        transform-origin: left center;
        transform: scaleX(0);
        background: linear-gradient(90deg, var(--accent), var(--accent-2), var(--accent-3));
        transition: transform .08s linear;
    }
    .skip-link {
        position: absolute;
        top: -100px;
        left: 24px;
        background: var(--primary);
        color: #fff;
        padding: 10px 18px;
        border-radius: 999px;
        z-index: 9999;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        box-shadow: 0 10px 24px rgba(0,0,0,.2);
        transition: top 0.2s ease;
    }
    .skip-link:focus {
        top: 16px;
    }
    .about-wrap::before,
    .about-wrap::after {
        content: '';
        position: fixed;
        inset: auto;
        width: 360px;
        height: 360px;
        border-radius: 999px;
        filter: blur(18px);
        opacity: .28;
        pointer-events: none;
        z-index: 0;
        animation: floatBlob 14s ease-in-out infinite;
    }
    .about-wrap::before {
        top: 6rem;
        right: -110px;
        background: radial-gradient(circle, rgba(26,86,219,.22), rgba(26,86,219,0));
    }
    .about-wrap::after {
        bottom: 5rem;
        left: -120px;
        background: radial-gradient(circle, rgba(14,165,233,.18), rgba(14,165,233,0));
        animation-delay: -7s;
    }
    @keyframes floatBlob {
        0%, 100% { transform: translate3d(0, 0, 0) scale(1); }
        50% { transform: translate3d(0, -18px, 0) scale(1.04); }
    }
    .about-shell { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
    .about-shell > * { position: relative; z-index: 1; }
    .about-nav {
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap: 20px;
        padding: 18px 0;
        border-bottom: 1px solid rgba(13, 27, 52, 0.08);
        backdrop-filter: blur(10px);
    }
    .brand { display:flex; align-items:center; gap: 12px; min-width: 0; }
    .brand-mark {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        background: linear-gradient(135deg, #ffffff, #f0f6ff);
        display:flex;
        align-items:center;
        justify-content:center;
        color:#fff;
        font-weight:800;
        flex-shrink:0;
        border:1px solid var(--line);
        box-shadow: 0 14px 32px rgba(15,31,61,.10);
        overflow:hidden;
    }
    .brand-mark img { width:100%; height:100%; object-fit:contain; image-rendering:-webkit-optimize-contrast; filter: contrast(1.12) saturate(1.08); }
    .brand-title { font-size: 15px; font-weight: 800; line-height: 1.2; }
    .brand-sub { font-size: 12px; color: var(--muted); }
    .nav-links { display:flex; flex-wrap:wrap; gap: 6px; justify-content:center; }
    .nav-links a {
        text-decoration:none;
        color: var(--muted);
        font-size: 13px;
        padding: 8px 12px;
        border-radius: 999px;
        transition: all .2s ease;
        border: 1px solid transparent;
    }
    .nav-links a:hover {
        background: rgba(29,78,216,.09);
        color: var(--ink);
        border-color: rgba(29,78,216,.14);
        transform: translateY(-1px);
    }
    .nav-links a.is-active {
        background: rgba(29,78,216,.14);
        color: var(--ink);
        border-color: rgba(29,78,216,.2);
        box-shadow: 0 8px 16px rgba(29,78,216,.10);
    }
    .nav-actions { display:flex; gap: 10px; flex-shrink: 0; }
    .btn {
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        padding: 11px 18px;
        border-radius: 999px;
        text-decoration:none;
        font-size: 14px;
        font-weight: 700;
        border: 1px solid transparent;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
        will-change: transform;
    }
    .btn:hover { transform: translateY(-2px); }
    .btn-primary { background: linear-gradient(135deg, var(--primary), var(--accent), var(--accent-3)); color: #fff; box-shadow: 0 18px 32px rgba(29,78,216,.18); }
    .btn-primary:hover { box-shadow: 0 22px 36px rgba(29,78,216,.24); }
    .btn-secondary { background: #fff; color: var(--primary); border-color: rgba(13,27,52,.10); box-shadow: 0 12px 22px rgba(15,31,61,.06); }
    .btn-secondary:hover { background: #f8fbff; }

    .hero {
        display:grid;
        grid-template-columns: 1.05fr .95fr;
        gap: 28px;
        align-items:stretch;
        padding: 56px 0 32px;
    }
    .pill {
        display:inline-flex;
        align-items:center;
        gap: 8px;
        padding: 6px 12px;
        border-radius: 999px;
        background: linear-gradient(135deg, rgba(29,78,216,.12), rgba(14,165,233,.12));
        color: var(--primary);
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 18px;
        border: 1px solid rgba(29,78,216,.12);
        box-shadow: 0 12px 24px rgba(29,78,216,.08);
    }
    .hero h1 { font-size: clamp(36px, 4.2vw, 64px); line-height: 0.98; letter-spacing: -0.05em; margin: 0 0 16px; }
    .hero p { font-size: 16px; color: var(--muted); line-height: 1.8; max-width: 620px; margin: 0 0 26px; }
    .hero-actions { display:flex; flex-wrap:wrap; gap: 12px; }
    .hero-badges { display:flex; flex-wrap:wrap; gap: 10px; margin-top: 18px; }
    .hero-badge {
        display:inline-flex;
        align-items:center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(255,255,255,.72);
        border: 1px solid rgba(13,27,52,.08);
        color: var(--ink);
        font-size: 12px;
        font-weight: 700;
        box-shadow: 0 12px 20px rgba(15,31,61,.06);
    }
    .hero-card {
        background: linear-gradient(180deg, #f5f9ff 0%, #ffffff 100%);
        border: 1px solid rgba(13,27,52,.08);
        border-radius: 30px;
        padding: 18px;
        box-shadow: 0 24px 68px rgba(15,31,61,.10);
        transform-style: preserve-3d;
        overflow:hidden;
        position:relative;
    }
    .hero-card::after {
        content: '';
        position:absolute;
        inset:auto -30px -30px auto;
        width: 160px;
        height: 160px;
        border-radius: 999px;
        background: radial-gradient(circle, rgba(29,78,216,.14), transparent 68%);
        pointer-events:none;
    }
    .hero-grid { display:grid; grid-template-columns: 1fr; gap: 12px; height:100%; }
    .hero-img, .mini-card, .info-card, .timeline-item, .program-card, .contact-card, .stat-card { border-radius: var(--radius); border: 1px solid var(--line); background: #fff; }
    .hero-img {
        overflow:hidden;
        min-height: 320px;
        background-size: cover;
        background-position: center;
        position: relative;
        border-radius: var(--radius-lg);
        box-shadow: inset 0 0 0 1px rgba(255,255,255,.16);
        transition: transform .15s linear;
        will-change: transform;
    }
    .hero-img::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(15,31,61,.05), rgba(15,31,61,.44));
    }
    .hero-overlay {
        position:absolute;
        inset:auto 18px 18px 18px;
        z-index:2;
        display:flex;
        align-items:flex-end;
        justify-content:space-between;
        gap: 12px;
        color:#fff;
    }
    .hero-overlay strong { display:block; font-size: 18px; line-height: 1.15; margin-bottom: 4px; }
    .hero-overlay span { font-size: 12px; color: rgba(255,255,255,.76); }
    .hero-panel { display:grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .mini-card {
        padding: 16px;
        min-height: 128px;
        box-shadow: 0 12px 30px rgba(15,31,61,.06);
        transition: transform .2s ease, box-shadow .2s ease;
        position:relative;
        overflow:hidden;
    }
    .mini-card:hover { transform: translateY(-2px); box-shadow: 0 16px 36px rgba(15,31,61,.08); }
    .mini-num { font-size: 28px; font-weight: 800; color: var(--primary); line-height: 1; }
    .mini-label { font-size: 12px; color: var(--muted); margin-top: 6px; }
    .stats { display:grid; grid-template-columns: repeat(4, 1fr); gap: 14px; padding: 0 0 18px; }
    .stat-card {
        padding: 20px;
        box-shadow: 0 14px 32px rgba(15,31,61,.06);
        transition: transform .2s ease, box-shadow .2s ease;
        position:relative;
        overflow:hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--accent), var(--accent-2), var(--accent-3));
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 18px 34px rgba(15,31,61,.08); }
    .stat-top { display:flex; align-items:center; gap: 12px; margin-bottom: 14px; }
    .icon-badge { width: 42px; height: 42px; border-radius: 14px; display:flex; align-items:center; justify-content:center; background: linear-gradient(135deg, rgba(29,78,216,.10), rgba(14,165,233,.10)); color: var(--primary); flex-shrink:0; font-weight: 800; }
    .stat-num { font-size: 26px; font-weight: 800; line-height: 1; }
    .stat-label { font-size: 13px; color: var(--muted); margin-top: 4px; }
    .section { padding: 54px 0; }
    .section.alt { background: linear-gradient(180deg, rgba(248,251,255,.78), rgba(238,243,251,.94)); margin-left: -24px; margin-right: -24px; padding-left: 24px; padding-right: 24px; border-top: 1px solid rgba(13,27,52,.05); border-bottom: 1px solid rgba(13,27,52,.05); }
    .section-head {
        margin-bottom: 28px;
        padding-left: 18px;
        border-left: 4px solid rgba(29,78,216,.18);
    }
    .eyebrow { display:inline-flex; padding: 6px 12px; border-radius: 999px; background: rgba(29,78,216,.08); color: var(--accent); font-size: 12px; font-weight: 800; margin-bottom: 12px; letter-spacing: .04em; }
    .title { font-size: clamp(26px, 2.8vw, 40px); line-height: 1.08; margin: 0 0 10px; letter-spacing: -0.03em; }
    .subtitle { max-width: 720px; font-size: 15px; line-height: 1.75; color: var(--muted); margin: 0; }
    .two-col { display:grid; grid-template-columns: 1fr 1fr; gap: 28px; align-items:start; }
    .info-card {
        padding: 22px;
        box-shadow: 0 16px 34px rgba(15,31,61,.06);
        transition: transform .2s ease, box-shadow .2s ease;
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }
    .info-card:hover { transform: translateY(-2px); box-shadow: 0 18px 34px rgba(15,31,61,.08); }
    .info-list { display:grid; gap: 12px; margin-top: 18px; }
    .info-row { display:flex; justify-content:space-between; gap: 16px; padding: 12px 0; border-bottom: 1px solid var(--line); font-size: 14px; }
    .info-row:last-child { border-bottom: 0; }
    .info-key { color: var(--muted); }
    .info-val { font-weight: 800; color: var(--ink); text-align:right; }
    .timeline { display:grid; gap: 14px; }
    .timeline-item {
        position:relative;
        padding: 18px 18px 18px 22px;
        box-shadow: 0 12px 28px rgba(15,31,61,.06);
        transition: transform .2s ease, box-shadow .2s ease;
        border-left: 4px solid rgba(29,78,216,.18);
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }
    .timeline-item:hover { transform: translateX(4px); box-shadow: 0 18px 34px rgba(15,31,61,.08); }
    .timeline-item::before { content: ''; position:absolute; left: -7px; top: 22px; width: 14px; height: 14px; border-radius: 50%; background: linear-gradient(135deg, var(--accent), var(--accent-2)); box-shadow: 0 0 0 6px rgba(29,78,216,.12); }
    .timeline-year { color: var(--accent); font-size: 12px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; margin-bottom: 6px; }
    .timeline-title { font-size: 16px; font-weight: 800; margin-bottom: 6px; }
    .timeline-desc { font-size: 14px; color: var(--muted); line-height: 1.7; }
    .program-grid { display:grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
    .program-card {
        padding: 22px;
        box-shadow: 0 14px 32px rgba(15,31,61,.06);
        transition: transform .2s ease, box-shadow .2s ease;
        overflow:hidden;
        position:relative;
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
        transform-style: preserve-3d;
        will-change: transform;
    }
    .program-card:hover { transform: translateY(-3px); box-shadow: 0 20px 38px rgba(29,78,216,.16); }
    .program-top { display:flex; align-items:center; justify-content:space-between; gap: 16px; margin-bottom: 14px; }
    .program-name { font-size: 20px; font-weight: 800; margin: 0 0 10px; }
    .program-desc { font-size: 14px; color: var(--muted); line-height: 1.7; margin: 0 0 14px; }
    .tag-list { display:flex; flex-wrap:wrap; gap: 8px; }
    .tag { padding: 6px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; background: var(--bg-soft); color: var(--ink); }
    .gallery-grid { display:grid; grid-template-columns: 1.2fr .8fr .8fr; gap: 14px; }
    .gallery-card { overflow:hidden; min-height: 220px; position:relative; background-size: cover; background-position: center; cursor:pointer; box-shadow: 0 14px 32px rgba(15,31,61,.10); border-radius: 24px; }
    .gallery-card.big { grid-row: span 2; min-height: 454px; }
    .gallery-overlay { position:absolute; inset:0; background: linear-gradient(180deg, rgba(15,31,61,.02), rgba(15,31,61,.50)); opacity: .85; transition: opacity .2s ease; }
    .gallery-card:hover .gallery-overlay { opacity: 1; }
    .gallery-label { position:absolute; left: 14px; bottom: 14px; color:#fff; font-size: 13px; font-weight: 800; background: rgba(15,31,61,.58); padding: 6px 10px; border-radius: 999px; backdrop-filter: blur(10px); }
    .cta-card { padding: 28px; background: linear-gradient(135deg, #0f172a 0%, #123a6f 50%, #1d4ed8 100%); color:#fff; display:flex; align-items:center; justify-content:space-between; gap: 20px; border-radius: 28px; box-shadow: 0 22px 50px rgba(29,78,216,.22); }
    .cta-card p { color: rgba(255,255,255,.82); margin: 8px 0 0; line-height: 1.7; }
    .cta-actions { display:flex; flex-wrap:wrap; gap: 10px; }
    .cta-card .btn-secondary { border-color: rgba(255,255,255,.2); color:#fff; background: transparent; }
    .cta-card .btn-secondary:hover { background: rgba(255,255,255,.08); }
    .cta-card .btn-primary { background:#fff; color: var(--primary); }
    .contact-grid { display:grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .contact-card { padding: 22px; box-shadow: 0 14px 32px rgba(15,31,61,.06); }
    .contact-line { display:flex; gap: 12px; margin-bottom: 12px; color: var(--muted); font-size: 14px; line-height: 1.6; }
    .contact-line strong { color: var(--ink); }
    .feature-grid { display:grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
    .direction-intro {
        margin-bottom: 18px;
        padding: 18px 20px;
        border-radius: 22px;
        background: linear-gradient(135deg, rgba(29,78,216,.06), rgba(14,165,233,.08));
        border: 1px solid rgba(29,78,216,.10);
        box-shadow: 0 14px 32px rgba(15,31,61,.05);
    }
    .direction-intro-title { font-size: 18px; font-weight: 800; margin: 0 0 8px; color: var(--ink); }
    .direction-intro-text { font-size: 14px; line-height: 1.75; color: var(--muted); margin: 0 0 14px; }
    .direction-chips { display:flex; flex-wrap:wrap; gap: 8px; }
    .direction-chip {
        display:inline-flex;
        align-items:center;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(255,255,255,.9);
        color: var(--ink);
        font-size: 12px;
        font-weight: 700;
        border: 1px solid rgba(13,27,52,.08);
        box-shadow: 0 8px 18px rgba(15,31,61,.04);
    }
    .feature-card {
        padding: 22px;
        box-shadow: 0 14px 32px rgba(15,31,61,.06);
        transition: transform .2s ease, box-shadow .2s ease;
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
        border: 1px solid rgba(13,27,52,.06);
    }
    .feature-card:hover { transform: translateY(-3px); box-shadow: 0 18px 34px rgba(15,31,61,.08); }
    .feature-icon {
        width: 46px;
        height: 46px;
        border-radius: 16px;
        display:flex;
        align-items:center;
        justify-content:center;
        background: linear-gradient(135deg, rgba(29,78,216,.10), rgba(14,165,233,.12));
        color: var(--primary);
        font-weight: 800;
        font-size: 15px;
        margin-bottom: 12px;
    }
    .feature-title { font-size: 18px; font-weight: 800; line-height: 1.25; margin: 0 0 10px; }
    .feature-desc { font-size: 14px; line-height: 1.7; color: var(--muted); margin: 0; }
    .testimonial-grid { display:grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
    .testimonial-card {
        padding: 22px;
        box-shadow: 0 14px 32px rgba(15,31,61,.06);
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
        border: 1px solid rgba(13,27,52,.06);
    }
    .achievement-strip {
        display:grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 18px;
    }
    .achievement-metric {
        padding: 18px 16px;
        border-radius: 20px;
        background: linear-gradient(135deg, rgba(255,255,255,.96), rgba(238,243,251,.96));
        border: 1px solid rgba(13,27,52,.06);
        box-shadow: 0 12px 24px rgba(15,31,61,.05);
        text-align: center;
    }
    .achievement-value { font-size: 26px; font-weight: 900; line-height: 1; color: var(--primary); margin-bottom: 6px; }
    .achievement-label { font-size: 12px; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; color: var(--muted); }
    .achievement-strip .achievement-metric:nth-child(1) .achievement-value { color: var(--accent); }
    .achievement-strip .achievement-metric:nth-child(2) .achievement-value { color: var(--primary); }
    .achievement-strip .achievement-metric:nth-child(3) .achievement-value { color: var(--accent-2); }
    .achievement-strip .achievement-metric:nth-child(4) .achievement-value { color: var(--accent-3); }
    .achievement-list {
        margin-top: 14px;
        display: grid;
        gap: 12px;
    }
    .achievement-item {
        padding: 16px 18px;
        border-radius: 18px;
        background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        border: 1px solid rgba(13,27,52,.06);
        box-shadow: 0 10px 22px rgba(15,31,61,.05);
    }
    .achievement-item-top {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 6px;
    }
    .achievement-year {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 56px;
        padding: 5px 10px;
        border-radius: 999px;
        background: rgba(29,78,216,.10);
        color: var(--accent);
        font-size: 12px;
        font-weight: 800;
    }
    .achievement-item-title { font-size: 16px; font-weight: 800; color: var(--ink); }
    .achievement-item-desc { font-size: 14px; line-height: 1.7; color: var(--muted); margin: 0; }
    .testimonial-role { font-size: 12px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; color: var(--accent); margin-bottom: 10px; }
    .testimonial-quote { font-size: 14px; line-height: 1.75; color: var(--muted); margin: 0 0 14px; }
    .testimonial-name { font-size: 14px; font-weight: 800; color: var(--ink); }
    .location-grid { display:grid; grid-template-columns: 1fr 1.15fr; gap: 16px; align-items: stretch; }
    .map-frame { width: 100%; min-height: 340px; border: 0; border-radius: 22px; }
    .footer { padding: 28px 0 50px; color: var(--muted); font-size: 13px; }
    .footer-top { display:flex; justify-content:space-between; gap: 20px; padding-top: 20px; border-top: 1px solid rgba(13,27,52,.08); }
    .footer-links { display:flex; flex-wrap:wrap; gap: 10px 16px; }
    .footer-links a { color: var(--muted); text-decoration:none; }
    .footer-links a:hover { color: var(--ink); }
    .lightbox {
        position:fixed;
        inset:0;
        background: rgba(0,0,0,.82);
        display:flex;
        align-items:center;
        justify-content:center;
        z-index: 9999;
        padding: 24px;
        backdrop-filter: blur(6px);
        opacity: 0;
        visibility: hidden;
        transition: opacity .24s ease, visibility .24s ease;
    }
    .lightbox.is-open {
        opacity: 1;
        visibility: visible;
    }
    .lightbox img {
        max-width: 95vw;
        max-height: 92vh;
        border-radius: 18px;
        box-shadow: 0 25px 80px rgba(0,0,0,.45);
        transform: scale(.94);
        opacity: 0;
        transition: transform .24s ease, opacity .24s ease;
    }
    .lightbox.is-open img {
        transform: scale(1);
        opacity: 1;
    }
    .reveal {
        opacity: 0;
        transform: translateY(22px);
        transition: opacity .75s ease, transform .75s ease;
        will-change: opacity, transform;
    }
    .reveal.is-visible {
        opacity: 1;
        transform: translateY(0);
    }
    .reveal.delay-1 { transition-delay: .08s; }
    .reveal.delay-2 { transition-delay: .16s; }
    .reveal.delay-3 { transition-delay: .24s; }
    .reveal.delay-4 { transition-delay: .32s; }
    .pulse-cta {
        animation: pulseCta 4s ease-in-out infinite;
    }
    @keyframes pulseCta {
        0%, 78%, 100% { box-shadow: 0 18px 32px rgba(29,78,216,.18); }
        86% { box-shadow: 0 24px 40px rgba(29,78,216,.34); }
    }
    .section-head .eyebrow { box-shadow: 0 8px 18px rgba(29,78,216,.06); }
    @media (max-width: 1024px) { .hero, .two-col, .contact-grid, .program-grid, .gallery-grid, .stats, .feature-grid, .testimonial-grid, .location-grid, .achievement-strip { grid-template-columns: 1fr 1fr; } .hero { grid-template-columns: 1fr; } .about-nav { flex-wrap: wrap; } .hero-panel { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 768px) { .about-shell { padding: 0 18px; } .hero, .stats, .two-col, .program-grid, .gallery-grid, .contact-grid, .footer-top, .feature-grid, .testimonial-grid, .location-grid, .achievement-strip { grid-template-columns: 1fr; } .hero-panel { grid-template-columns: 1fr; } .gallery-card.big { min-height: 260px; grid-row: auto; } .cta-card { flex-direction: column; align-items:flex-start; } .nav-actions { width:100%; } .hero-img { min-height: 260px; } .map-frame { min-height: 280px; } }
</style>

<div class="about-wrap">
    <a href="#main-content" class="skip-link">Lewati ke konten</a>
    <div class="scroll-progress" aria-hidden="true"><div class="scroll-progress-bar" id="about-scroll-progress"></div></div>
    <div class="about-shell">
        <header class="about-nav reveal is-visible">
            <div class="brand">
                <div class="brand-mark">
                    @if(!empty($schoolLogoSrc))
                        <img src="{{ $schoolLogoSrc }}" alt="Logo {{ $schoolName }}">
                    @else
                        TP
                    @endif
                </div>
                <div>
                    <div class="brand-title">{{ $schoolName }}</div>
                    <div class="brand-sub">Bekasi Utara, Kota Bekasi</div>
                </div>
            </div>

            <nav class="nav-links">
                <a href="#profil">Profil</a>
                <a href="#visi-misi">Visi Misi</a>
                <a href="#prestasi">Prestasi</a>
                <a href="#testimoni">Testimoni</a>
                <a href="#sejarah">Sejarah</a>
                <a href="#jurusan">Jurusan</a>
                <a href="#fasilitas">Fasilitas</a>
                <a href="#galeri">Galeri</a>
                <a href="#lokasi">Lokasi</a>
                <a href="#kontak">Kontak</a>
            </nav>

            <div class="nav-actions">
                <a class="btn btn-secondary" href="{{ route('about.brochure') }}">Download Brosur</a>
                @auth
                    <a class="btn btn-secondary" href="{{ route('login') }}">Login</a>
                @else
                    <a class="btn btn-secondary" href="{{ route('login') }}">Login</a>
                @endauth
                <a class="btn btn-primary pulse-cta" href="{{ $waAdminUrl }}" target="_blank" rel="noopener">Daftar Sekarang</a>
            </div>
        </header>

        <section class="hero reveal is-visible" id="main-content" tabindex="-1">
            <div>
                <div class="pill">Akreditasi A - {{ $schoolName }}</div>
                <h1>Membentuk lulusan siap kerja, siap lanjut, dan siap bersaing.</h1>
                <p>{{ $schoolName }} adalah sekolah menengah kejuruan swasta di Jl. Kali Abang No. 10, Perwira, Bekasi Utara, Kota Bekasi. Fokus utama kami ada pada jurusan Teknik Kendaraan Ringan (TKR) dan Teknik Komputer dan Jaringan (TKJ).</p>
                <div class="hero-actions">
                    <a class="btn btn-primary pulse-cta" href="{{ $waAdminUrl }}" target="_blank" rel="noopener">Daftar Sekarang</a>
                    <a class="btn btn-secondary" href="#jurusan">Lihat Jurusan</a>
                </div>
                <div class="hero-badges">
                    <span class="hero-badge"><i class="fas fa-shield-heart" style="color:var(--accent);"></i> Lingkungan belajar aman</span>
                    <span class="hero-badge"><i class="fas fa-graduation-cap" style="color:var(--accent-2);"></i> Fokus TKR dan TKJ</span>
                    <span class="hero-badge"><i class="fas fa-circle-check" style="color:var(--accent-3);"></i> Pendaftaran lebih jelas</span>
                </div>
            </div>

            <div class="hero-card reveal delay-1">
                <div class="hero-grid">
                    <div class="hero-img" style="background-image:url('{{ $heroImage }}')">
                        <div class="hero-overlay">
                            <div>
                                <strong>{{ $heroOverlayLeftTitle }}</strong>
                                <span>{{ $heroOverlayLeftSubtitle }}</span>
                            </div>
                            <div style="text-align:right;">
                                <strong>{{ $heroOverlayRightTitle }}</strong>
                                <span>{{ $heroOverlayRightSubtitle }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="hero-panel">
                        <div class="mini-card" style="background: linear-gradient(135deg, #0f172a 0%, #123a6f 100%); color:#fff;">
                            <div class="mini-num" style="color:#fff;">02</div>
                            <div class="mini-label" style="color:rgba(255,255,255,.78);">Jurusan unggulan</div>
                            <div style="margin-top:12px;font-size:12px;color:rgba(255,255,255,.7);line-height:1.6;">Tampilan ini menonjolkan TKR dan TKJ sebagai pilihan utama agar calon siswa lebih cepat mengenal fokus keahlian sekolah.</div>
                        </div>
                        <div class="mini-card" style="background: linear-gradient(135deg, #ffffff 0%, #edf4ff 100%);">
                            <div class="mini-num">A</div>
                            <div class="mini-label">Profil {{ $schoolName }} yang jelas</div>
                            <div style="margin-top:12px;font-size:12px;color:var(--muted);line-height:1.6;">Menampilkan akreditasi, alamat, dan jurusan utama agar calon siswa cepat mengenal sekolah.</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="stats reveal" id="profil">
            @foreach([
                ['N', $schoolData['NPSN'], 'Nomor pokok sekolah'],
                ['A', $schoolData['Akreditasi'], 'Status akreditasi'],
                ['S', $schoolData['Status'], 'Status sekolah'],
                ['20', $schoolData['Tahun Berdiri'], 'Tahun berdiri'],
            ] as [$badge, $value, $label])
                <div class="stat-card reveal delay-{{ $loop->index % 4 }}">
                    <div class="stat-top">
                        <div class="icon-badge">{{ $badge }}</div>
                        <div>
                            <div class="stat-num" @if(is_numeric($value)) data-count="{{ (int) $value }}" @endif>{{ $value }}</div>
                            <div class="stat-label">{{ $label }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>

        <section class="section alt reveal">
            <div class="section-head reveal delay-1">
                <div class="eyebrow">Data Sekolah</div>
                <h2 class="title">Profil singkat sekolah</h2>
                <p class="subtitle">Informasi inti {{ $schoolName }} ditampilkan ringkas agar mudah dibaca oleh calon siswa dan orang tua.</p>
            </div>

            <div class="two-col">
                <div class="info-card reveal delay-1">
                    <div class="info-list">
                        @foreach($schoolData as $key => $value)
                            <div class="info-row"><div class="info-key">{{ $key }}</div><div class="info-val">{{ $value }}</div></div>
                        @endforeach
                    </div>
                </div>

                <div class="info-card reveal delay-2">
                    <div class="eyebrow">Ringkasan</div>
                    <h3 class="title" style="font-size: 28px; margin-bottom: 12px;">Yang paling dibutuhkan calon siswa</h3>
                    <p class="subtitle" style="margin-bottom: 18px;">Ringkasan ini menampilkan jurusan aktif, lokasi, dan kontak sekolah sebagai informasi awal yang paling sering dicari.</p>
                    <div class="info-list" style="margin-top: 0;">
                        <div class="info-row"><div class="info-key">Jurusan aktif</div><div class="info-val">TKR dan TKJ</div></div>
                        <div class="info-row"><div class="info-key">Lokasi</div><div class="info-val">Bekasi Utara</div></div>
                        <div class="info-row"><div class="info-key">Kontak</div><div class="info-val">02188880097</div></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section reveal" id="visi-misi">
            <div class="section-head reveal delay-1">
                <div class="eyebrow">Arah Pendidikan</div>
                <h2 class="title">Visi, misi, dan nilai sekolah</h2>
                <p class="subtitle">Visi, misi, dan nilai sekolah dirangkum untuk menunjukkan arah pembelajaran serta pembinaan karakter siswa.</p>
            </div>

            <div class="direction-intro reveal delay-2">
                <div class="direction-intro-title">Membangun lulusan yang siap kerja, siap lanjut, dan siap bersaing</div>
                <p class="direction-intro-text">Melalui tiga poin ini, pengunjung dapat memahami tujuan pendidikan sekolah, cara pembelajaran dijalankan, dan nilai yang ditanamkan kepada siswa.</p>
                <div class="direction-chips">
                    <span class="direction-chip">Siap kerja</span>
                    <span class="direction-chip">Siap lanjut studi</span>
                    <span class="direction-chip">Disiplin dan berkarakter</span>
                </div>
            </div>

            <div class="feature-grid">
                @foreach($schoolDirection as $item)
                    <div class="feature-card reveal delay-{{ ($loop->index % 4) + 1 }}">
                        <div class="feature-icon"><i class="fas fa-book-open" aria-hidden="true"></i></div>
                        <div class="eyebrow" style="margin-bottom: 10px;">{{ $item['label'] }}</div>
                        <div class="feature-title">{{ $item['title'] }}</div>
                        <p class="feature-desc">{{ $item['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="section reveal" id="prestasi">
            <div class="section-head reveal delay-1">
                <div class="eyebrow">Prestasi & Pencapaian</div>
                <h2 class="title">Capaian yang memperkuat kepercayaan</h2>
                <p class="subtitle">Prestasi ditampilkan secara ringkas melalui capaian utama sekolah yang mudah dipahami pengunjung.</p>
            </div>

            <div class="achievement-strip reveal delay-2">
                @foreach($schoolAchievementMetrics as $metric)
                    <div class="achievement-metric">
                        <div class="achievement-value">{{ $metric['value'] }}</div>
                        <div class="achievement-label">{{ $metric['label'] }}</div>
                    </div>
                @endforeach
            </div>

            <div class="feature-grid">
                @foreach($schoolAchievements as $item)
                    <div class="feature-card reveal delay-{{ ($loop->index % 4) + 1 }}">
                        <div class="feature-icon">{{ $item['badge'] }}</div>
                        <div class="feature-title">{{ $item['title'] }}</div>
                        <p class="feature-desc">{{ $item['description'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="achievement-list">
                @foreach($schoolAchievementProofs as $item)
                    <div class="achievement-item reveal delay-{{ ($loop->index % 3) + 1 }}">
                        <div class="achievement-item-top">
                            <span class="achievement-year">{{ $item['year'] }}</span>
                            <div class="achievement-item-title">{{ $item['title'] }}</div>
                        </div>
                        <p class="achievement-item-desc">{{ $item['detail'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="section alt reveal" id="testimoni">
            <div class="section-head reveal delay-1">
                <div class="eyebrow">Testimoni</div>
                <h2 class="title">Kesan singkat dari lingkungan sekolah</h2>
                <p class="subtitle">Testimoni singkat ini memberikan gambaran suasana belajar, kualitas pembinaan, dan kepercayaan warga sekolah.</p>
            </div>

            <div class="testimonial-grid">
                @foreach($schoolTestimonials as $item)
                    <div class="testimonial-card reveal delay-{{ ($loop->index % 4) + 1 }}">
                        <div class="testimonial-role">{{ $item['role'] }}</div>
                        <p class="testimonial-quote">“{{ $item['quote'] }}”</p>
                        <div class="testimonial-name">{{ $item['name'] }}</div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="section reveal" id="sejarah">
            <div class="section-head reveal delay-1">
                <div class="eyebrow">Sejarah Sekolah</div>
                <h2 class="title">Berdiri sejak 2001 dan terus berkembang</h2>
                <p class="subtitle">Perjalanan {{ $schoolName }} dirangkum dari masa awal berdiri hingga perkembangan sekolah saat ini.</p>
            </div>

            <div class="timeline">
                <div class="timeline-item reveal delay-1"><div class="timeline-year">1999</div><div class="timeline-title">Mulai dikenal sebagai {{ $schoolName }}</div><div class="timeline-desc">Nama sekolah mulai dikenal sejak Juli 1999 sebagai bagian dari langkah awal pengembangan pendidikan di Bekasi.</div></div>
                <div class="timeline-item reveal delay-2"><div class="timeline-year">2001</div><div class="timeline-title">Pendirian dan operasional resmi</div><div class="timeline-desc">Pada 9 Januari 2001, sekolah resmi berdiri dan mulai beroperasi sebagai lembaga pendidikan kejuruan.</div></div>
                <div class="timeline-item reveal delay-3"><div class="timeline-year">2018</div><div class="timeline-title">Akreditasi A</div><div class="timeline-desc">{{ $schoolName }} meraih akreditasi A dengan SK BAN-SM 1214/BAN-SM/SK/2018.</div></div>
                <div class="timeline-item reveal delay-4"><div class="timeline-year">2026</div><div class="timeline-title">Fokus jurusan TKR dan TKJ</div><div class="timeline-desc">Saat ini, profil sekolah menonjolkan TKR dan TKJ sebagai dua jurusan inti yang menjadi kekuatan utama.</div></div>
            </div>
        </section>

        <section class="section alt reveal" id="jurusan">
            <div class="section-head reveal delay-1">
                <div class="eyebrow">Jurusan</div>
                <h2 class="title">Hanya TKR dan TKJ</h2>
                <p class="subtitle">Dua jurusan ini ditampilkan sebagai fokus utama agar calon siswa lebih mudah menentukan pilihan sesuai minatnya.</p>
            </div>

            <div class="program-grid">
                <div class="program-card reveal delay-1">
                    <div class="program-top"><div class="eyebrow" style="margin:0;">TKR</div><div class="tag">Otomotif</div></div>
                    <h3 class="program-name">Teknik Kendaraan Ringan</h3>
                    <p class="program-desc">Membekali siswa dengan keterampilan dasar otomotif, perawatan kendaraan, sistem mesin, kelistrikan, dan praktik bengkel yang terarah.</p>
                    <div class="tag-list"><span class="tag">Servis mesin</span><span class="tag">Kelistrikan kendaraan</span><span class="tag">Bengkel praktik</span></div>
                </div>

                <div class="program-card reveal delay-2">
                    <div class="program-top"><div class="eyebrow" style="margin:0;">TKJ</div><div class="tag">Jaringan</div></div>
                    <h3 class="program-name">Teknik Komputer dan Jaringan</h3>
                    <p class="program-desc">Fokus pada komputer, instalasi jaringan, perangkat lunak, administrasi sistem, dan keterampilan digital yang relevan untuk industri modern.</p>
                    <div class="tag-list"><span class="tag">Jaringan LAN</span><span class="tag">Perakitan komputer</span><span class="tag">Administrasi server</span></div>
                </div>
            </div>
        </section>

        <section class="section alt reveal" id="fasilitas">
            <div class="section-head reveal delay-1">
                <div class="eyebrow">Fasilitas Unggulan</div>
                <h2 class="title">Lab, bengkel, ruang kelas, dan sarana praktik</h2>
                <p class="subtitle">Fasilitas utama sekolah ditampilkan untuk memberi gambaran lingkungan belajar dan kegiatan praktik siswa.</p>
            </div>

            <div class="feature-grid">
                @foreach($schoolFacilities as $item)
                    <div class="feature-card reveal delay-{{ ($loop->index % 4) + 1 }}">
                        <div class="feature-icon"><i class="fas {{ $item['icon'] }}" aria-hidden="true"></i></div>
                        <div class="feature-title">{{ $item['title'] }}</div>
                        <p class="feature-desc">{{ $item['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="section reveal" id="galeri">
            <div class="section-head reveal delay-1">
                <div class="eyebrow">Galeri</div>
                <h2 class="title">Suasana sekolah dalam satu tampilan</h2>
                <p class="subtitle">Galeri ini menampilkan suasana belajar, aktivitas siswa, dan fasilitas sekolah dalam satu rangkaian visual.</p>
            </div>

            @php
                $galleryItems = array_values(array_filter($gallery, function ($item) {
                    return !empty($item['url']);
                }));

                $usedUrls = array_column($galleryItems, 'url');
                $fallbackPool = array_values(array_filter($defaultGallery, function ($item) use ($usedUrls) {
                    return !in_array($item['url'], $usedUrls, true);
                }));
                $fallbackIndex = 0;

                while (count($galleryItems) < 5) {
                    if (isset($fallbackPool[$fallbackIndex])) {
                        $galleryItems[] = $fallbackPool[$fallbackIndex];
                        $fallbackIndex++;
                        continue;
                    }

                    $index = count($galleryItems) % count($defaultGallery);
                    $galleryItems[] = $defaultGallery[$index];
                }
            @endphp

            <div class="gallery-grid">
                <div class="gallery-card big reveal delay-1" data-src="{{ $galleryItems[0]['url'] }}" style="background-image:url('{{ $galleryItems[0]['url'] }}')"><div class="gallery-overlay"></div><div class="gallery-label">{{ $galleryItems[0]['label'] ?? $galleryTableNames[0] }}</div></div>
                <div class="gallery-card reveal delay-2" data-src="{{ $galleryItems[1]['url'] }}" style="background-image:url('{{ $galleryItems[1]['url'] }}')"><div class="gallery-overlay"></div><div class="gallery-label">{{ $galleryItems[1]['label'] ?? $galleryTableNames[1] }}</div></div>
                <div class="gallery-card reveal delay-3" data-src="{{ $galleryItems[2]['url'] }}" style="background-image:url('{{ $galleryItems[2]['url'] }}')"><div class="gallery-overlay"></div><div class="gallery-label">{{ $galleryItems[2]['label'] ?? $galleryTableNames[2] }}</div></div>
                <div class="gallery-card reveal delay-2" data-src="{{ $galleryItems[3]['url'] }}" style="background-image:url('{{ $galleryItems[3]['url'] }}')"><div class="gallery-overlay"></div><div class="gallery-label">{{ $galleryItems[3]['label'] ?? $galleryTableNames[3] }}</div></div>
                <div class="gallery-card reveal delay-4" data-src="{{ $galleryItems[4]['url'] }}" style="background-image:url('{{ $galleryItems[4]['url'] }}')"><div class="gallery-overlay"></div><div class="gallery-label">{{ $galleryItems[4]['label'] ?? $galleryTableNames[4] }}</div></div>
            </div>
        </section>

        <section class="section reveal" id="lokasi">
            <div class="section-head reveal delay-1">
                <div class="eyebrow">Lokasi</div>
                <h2 class="title">Alamat dan arah menuju sekolah</h2>
                <p class="subtitle">Tambahan peta membantu calon siswa dan orang tua menemukan lokasi sekolah dengan lebih cepat dan jelas.</p>
            </div>

            <div class="location-grid">
                <div class="contact-card reveal delay-1">
                    <div class="contact-line"><strong>Alamat:</strong> {{ $schoolData['Alamat'] }}</div>
                    <div class="contact-line"><strong>Telepon:</strong> {{ $schoolData['Telepon'] }}</div>
                    <div class="contact-line"><strong>Email:</strong> {{ $schoolData['Email'] }}</div>
                    <div class="contact-line"><strong>Akses cepat:</strong> Buka rute di Google Maps untuk melihat arah perjalanan langsung.</div>
                    <div class="cta-actions" style="margin-top: 16px;">
                        <a class="btn btn-primary pulse-cta" href="{{ $mapsLink }}" target="_blank" rel="noopener">Buka di Google Maps</a>
                        <a class="btn btn-secondary" href="{{ $waAdminUrl }}" target="_blank" rel="noopener">Tanya Admin</a>
                    </div>
                </div>

                <div class="contact-card reveal delay-2" style="padding: 14px;">
                    <iframe
                        class="map-frame"
                        src="{{ $mapsEmbedUrl }}"
                        title="Lokasi {{ $schoolName }}"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen
                    ></iframe>
                </div>
            </div>
        </section>

        <section class="section alt reveal" id="kontak">
            <div class="section-head reveal delay-1">
                <div class="eyebrow">Kontak</div>
                <h2 class="title">Hubungi sekolah</h2>
                <p class="subtitle">Untuk informasi lebih lanjut, silakan hubungi sekolah melalui kontak resmi berikut.</p>
            </div>

            <div class="contact-grid">
                <div class="contact-card reveal delay-1">
                    <div class="contact-line"><strong>Alamat:</strong> {{ $schoolData['Alamat'] }}</div>
                    <div class="contact-line"><strong>Telepon:</strong> {{ $schoolData['Telepon'] }}</div>
                    <div class="contact-line"><strong>Email:</strong> {{ $schoolData['Email'] }}</div>
                    <div class="contact-line"><strong>Kepala sekolah:</strong> {{ $schoolData['Kepala Sekolah'] }}</div>
                </div>

                <div class="contact-card reveal delay-2">
                    <div class="contact-line"><strong>Aksi cepat:</strong> Daftar sekarang, download brosur, atau lihat detail jurusan TKR dan TKJ.</div>
                    <div class="cta-actions" style="margin-top: 16px;">
                        <a class="btn btn-primary pulse-cta" href="{{ $waAdminUrl }}" target="_blank" rel="noopener">Daftar Sekarang</a>
                        <a class="btn btn-secondary" href="{{ route('about.brochure') }}">Brosur PDF</a>
                    </div>
                </div>
            </div>

        </section>

        <footer class="footer">
            <div class="footer-top">
                <div>Copyright {{ date('Y') }} {{ $schoolName }}.</div>
                <div class="footer-links">
                    <a href="#profil">Profil</a>
                    <a href="#visi-misi">Visi Misi</a>
                    <a href="#prestasi">Prestasi</a>
                    <a href="#testimoni">Testimoni</a>
                    <a href="#sejarah">Sejarah</a>
                    <a href="#jurusan">Jurusan</a>
                    <a href="#fasilitas">Fasilitas</a>
                    <a href="#galeri">Galeri</a>
                    <a href="#lokasi">Lokasi</a>
                    <a href="#kontak">Kontak</a>
                </div>
            </div>
        </footer>
    </div>

    <div class="lightbox" id="about-lightbox" aria-hidden="true">
        <img src="" alt="" id="about-lightbox-img">
    </div>
</div>

@php
    $structuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'EducationalOrganization',
        'name' => $schoolName,
        'url' => url('/about'),
        'telephone' => $schoolData['Telepon'],
        'email' => $schoolData['Email'],
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Jl. Kali Abang No. 10',
            'addressLocality' => 'Bekasi Utara',
            'addressRegion' => 'Jawa Barat',
            'addressCountry' => 'ID',
        ],
    ];
@endphp

<script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const progressBar = document.getElementById('about-scroll-progress');
    const navLinks = Array.from(document.querySelectorAll('.nav-links a[href^="#"]'));
    const sectionIds = navLinks.map((link) => link.getAttribute('href')).filter(Boolean);
    const sectionElements = sectionIds
        .map((id) => document.querySelector(id))
        .filter((node) => node);

    function updateScrollProgress() {
        if (!progressBar) return;
        const scrollTop = window.scrollY || window.pageYOffset;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const ratio = docHeight > 0 ? Math.min(scrollTop / docHeight, 1) : 0;
        progressBar.style.transform = `scaleX(${ratio})`;
    }

    function markActiveSection(id) {
        navLinks.forEach((link) => {
            const isActive = link.getAttribute('href') === id;
            link.classList.toggle('is-active', isActive);
        });
    }

    if ('IntersectionObserver' in window && sectionElements.length > 0) {
        const navObserver = new IntersectionObserver((entries) => {
            const visible = entries
                .filter((entry) => entry.isIntersecting)
                .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];

            if (visible && visible.target && visible.target.id) {
                markActiveSection(`#${visible.target.id}`);
            }
        }, { threshold: [0.25, 0.45, 0.7], rootMargin: '-18% 0px -45% 0px' });

        sectionElements.forEach((section) => navObserver.observe(section));
    }

    updateScrollProgress();
    window.addEventListener('scroll', updateScrollProgress, { passive: true });

    const revealElements = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.14, rootMargin: '0px 0px -8% 0px' });

        revealElements.forEach((element) => revealObserver.observe(element));
    } else {
        revealElements.forEach((element) => element.classList.add('is-visible'));
    }

    // Stagger reveal per group for more premium sequencing.
    const staggerGroups = ['.stats .stat-card', '.feature-grid .feature-card', '.timeline .timeline-item', '.program-grid .program-card', '.gallery-grid .gallery-card', '.testimonial-grid .testimonial-card'];
    staggerGroups.forEach((selector) => {
        document.querySelectorAll(selector).forEach((element, index) => {
            if (!element.classList.contains('reveal')) {
                element.classList.add('reveal');
            }
            element.style.transitionDelay = `${Math.min(index, 6) * 90}ms`;
        });
    });

    // Count-up animation for numeric stats.
    const countTargets = Array.from(document.querySelectorAll('.stat-num[data-count]'));
    const runCountUp = (el) => {
        const endValue = Number(el.getAttribute('data-count'));
        if (!Number.isFinite(endValue)) return;
        const duration = 1200;
        const start = performance.now();

        const tick = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            const ease = 1 - Math.pow(1 - progress, 3);
            const current = Math.round(endValue * ease);
            el.textContent = String(current);
            if (progress < 1) {
                requestAnimationFrame(tick);
            }
        };

        requestAnimationFrame(tick);
    };

    if ('IntersectionObserver' in window && countTargets.length > 0) {
        const countObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    runCountUp(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        countTargets.forEach((target) => countObserver.observe(target));
    }

    // Subtle parallax on hero image.
    const heroImage = document.querySelector('.hero-img');
    const updateHeroParallax = () => {
        if (!heroImage) return;
        const rect = heroImage.getBoundingClientRect();
        const viewportMid = window.innerHeight / 2;
        const distance = rect.top + rect.height / 2 - viewportMid;
        const translate = Math.max(Math.min(distance * -0.035, 14), -14);
        heroImage.style.transform = `translate3d(0, ${translate}px, 0)`;
    };

    updateHeroParallax();
    window.addEventListener('scroll', updateHeroParallax, { passive: true });

    // Light tilt for program cards.
    const programCards = document.querySelectorAll('.program-card');
    programCards.forEach((card) => {
        card.addEventListener('mousemove', (event) => {
            const rect = card.getBoundingClientRect();
            const x = (event.clientX - rect.left) / rect.width;
            const y = (event.clientY - rect.top) / rect.height;
            const rotateY = (x - 0.5) * 5.5;
            const rotateX = (0.5 - y) * 4.5;
            card.style.transform = `translateY(-3px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = '';
        });
    });

    const items = document.querySelectorAll('[data-src]');
    const lightbox = document.getElementById('about-lightbox');
    const lightboxImg = document.getElementById('about-lightbox-img');

    function openLightbox(src) {
        lightboxImg.src = src;
        lightbox.classList.add('is-open');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.classList.remove('is-open');
        lightbox.setAttribute('aria-hidden', 'true');
        setTimeout(() => {
            if (!lightbox.classList.contains('is-open')) {
                lightboxImg.src = '';
            }
        }, 240);
        document.body.style.overflow = '';
    }

    items.forEach((item) => {
        item.addEventListener('click', function () {
            const src = this.getAttribute('data-src');
            if (src) openLightbox(src);
        });
    });

    lightbox.addEventListener('click', closeLightbox);
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') closeLightbox();
    });
});
</script>
@endpush

@endsection