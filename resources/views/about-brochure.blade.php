<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Brosur - {{ \App\Models\Setting::get('nama_sekolah', config('app.name', 'SMA Contoh Kita')) }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #eef3fb;
      --surface: rgba(255, 255, 255, .86);
      --surface-strong: #ffffff;
      --ink: #10203d;
      --muted: #66758f;
      --line: rgba(16, 32, 61, .10);
      --brand: #123a6f;
      --brand-2: #1a56db;
      --accent: #0ea5e9;
      --shadow: 0 24px 70px rgba(16, 32, 61, .12);
      --radius-xl: 30px;
      --radius-lg: 22px;
      --radius-md: 16px;
    }

    * {
      box-sizing: border-box;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      margin: 0;
      min-height: 100vh;
      font-family: 'Plus Jakarta Sans', Arial, Helvetica, sans-serif;
      color: var(--ink);
      background:
        radial-gradient(circle at top left, rgba(26, 86, 219, .14), transparent 28%),
        radial-gradient(circle at top right, rgba(14, 165, 233, .14), transparent 32%),
        linear-gradient(180deg, #f8fbff 0%, var(--bg) 100%);
      padding: 28px;
      overflow-x: hidden;
    }

    body::before,
    body::after {
      content: '';
      position: fixed;
      width: 340px;
      height: 340px;
      border-radius: 999px;
      pointer-events: none;
      filter: blur(18px);
      opacity: .22;
      z-index: 0;
      animation: floatBlob 16s ease-in-out infinite;
    }

    body::before {
      top: -90px;
      right: -120px;
      background: radial-gradient(circle, rgba(26, 86, 219, .25), rgba(26, 86, 219, 0));
    }

    body::after {
      bottom: -100px;
      left: -120px;
      background: radial-gradient(circle, rgba(14, 165, 233, .22), rgba(14, 165, 233, 0));
      animation-delay: -7s;
    }

    @keyframes floatBlob {
      0%, 100% { transform: translate3d(0, 0, 0) scale(1); }
      50% { transform: translate3d(0, -18px, 0) scale(1.06); }
    }

    .page {
      position: relative;
      z-index: 1;
      max-width: 1160px;
      margin: 0 auto;
    }

    .card {
      background: var(--surface);
      border: 1px solid rgba(255, 255, 255, .65);
      box-shadow: var(--shadow);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
    }

    .hero {
      border-radius: var(--radius-xl);
      overflow: hidden;
      position: relative;
    }

    .hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(18, 58, 111, .96), rgba(26, 86, 219, .92) 52%, rgba(14, 165, 233, .82));
      z-index: 0;
    }

    .hero::after {
      content: '';
      position: absolute;
      inset: 0;
      background:
        radial-gradient(circle at top right, rgba(255, 255, 255, .18), transparent 25%),
        radial-gradient(circle at bottom left, rgba(255, 255, 255, .12), transparent 26%);
      z-index: 0;
    }

    .hero-inner {
      position: relative;
      z-index: 1;
      display: grid;
      grid-template-columns: 1.12fr .88fr;
      gap: 28px;
      padding: 36px;
      color: #fff;
      align-items: center;
    }

    .brand-row {
      display: flex;
      align-items: center;
      gap: 14px;
      margin-bottom: 22px;
    }

    .brand-logo {
      width: 68px;
      height: 68px;
      border-radius: 20px;
      background: rgba(255, 255, 255, .14);
      border: 1px solid rgba(255, 255, 255, .18);
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      flex-shrink: 0;
      box-shadow: 0 16px 32px rgba(0, 0, 0, .12);
    }

    .brand-logo img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      background: rgba(255, 255, 255, .92);
    }

    .brand-logo-fallback {
      font-weight: 800;
      font-size: 24px;
      letter-spacing: .04em;
    }

    .eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 14px;
      border-radius: 999px;
      background: rgba(255, 255, 255, .14);
      border: 1px solid rgba(255, 255, 255, .18);
      font-size: 12px;
      font-weight: 800;
      letter-spacing: .08em;
      text-transform: uppercase;
      margin-bottom: 18px;
    }

    .hero h1 {
      margin: 0 0 16px;
      font-size: clamp(34px, 4.4vw, 64px);
      line-height: .98;
      letter-spacing: -0.05em;
    }

    .hero p {
      margin: 0;
      max-width: 620px;
      color: rgba(255, 255, 255, .84);
      font-size: 16px;
      line-height: 1.8;
    }

    .hero-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin-top: 26px;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      padding: 13px 18px;
      border-radius: 999px;
      text-decoration: none;
      font-weight: 800;
      font-size: 14px;
      transition: transform .22s ease, box-shadow .22s ease, background .22s ease, border-color .22s ease;
      will-change: transform;
    }

    .btn:hover {
      transform: translateY(-2px);
    }

    .btn-primary {
      background: #fff;
      color: var(--brand);
      box-shadow: 0 16px 30px rgba(0, 0, 0, .18);
    }

    .btn-secondary {
      color: #fff;
      border: 1px solid rgba(255, 255, 255, .24);
      background: rgba(255, 255, 255, .08);
    }

    .btn-secondary:hover {
      background: rgba(255, 255, 255, .14);
    }

    .hero-side {
      display: grid;
      gap: 14px;
    }

    .hero-visual {
      position: relative;
      border-radius: 26px;
      overflow: hidden;
      min-height: 310px;
      box-shadow: 0 24px 50px rgba(8, 24, 50, .22);
      background: rgba(255, 255, 255, .08);
      border: 1px solid rgba(255, 255, 255, .16);
    }

    .hero-visual img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      transform: scale(1.02);
    }

    .hero-visual::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(16, 32, 61, 0) 30%, rgba(16, 32, 61, .45) 100%);
    }

    .hero-visual-caption {
      position: absolute;
      left: 18px;
      right: 18px;
      bottom: 16px;
      z-index: 1;
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      gap: 14px;
      color: #fff;
    }

    .hero-visual-caption strong {
      display: block;
      font-size: 18px;
      margin-bottom: 4px;
    }

    .hero-visual-caption span {
      font-size: 13px;
      color: rgba(255, 255, 255, .76);
    }

    .metric-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 14px;
    }

    .metric {
      border-radius: 22px;
      padding: 18px;
      background: rgba(255, 255, 255, .88);
      border: 1px solid rgba(255, 255, 255, .7);
      box-shadow: 0 14px 30px rgba(16, 32, 61, .08);
    }

    .metric-value {
      font-size: 30px;
      font-weight: 800;
      line-height: 1;
      color: var(--brand);
      margin-bottom: 6px;
    }

    .metric-label {
      font-size: 13px;
      color: var(--muted);
      line-height: 1.5;
    }

    .main {
      display: grid;
      grid-template-columns: 1.45fr .85fr;
      gap: 22px;
      margin-top: 22px;
      align-items: start;
    }

    .stack {
      display: grid;
      gap: 22px;
    }

    .panel {
      border-radius: var(--radius-xl);
      padding: 26px;
    }

    .panel h2 {
      margin: 0 0 10px;
      font-size: 22px;
      line-height: 1.15;
      letter-spacing: -0.03em;
    }

    .panel p {
      margin: 0;
      color: var(--muted);
      line-height: 1.8;
      font-size: 14px;
    }

    .intro {
      display: grid;
      grid-template-columns: 1.1fr .9fr;
      gap: 18px;
    }

    .feature-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 14px;
      margin-top: 18px;
    }

    .feature {
      border-radius: var(--radius-md);
      padding: 16px;
      border: 1px solid var(--line);
      background: var(--surface-strong);
      box-shadow: 0 12px 26px rgba(16, 32, 61, .05);
      transition: transform .22s ease, box-shadow .22s ease;
    }

    .feature:hover,
    .info-card:hover,
    .contact-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 18px 36px rgba(16, 32, 61, .09);
    }

    .feature strong,
    .info-card strong,
    .contact-card strong {
      display: block;
      margin-bottom: 6px;
      font-size: 14px;
      color: var(--ink);
    }

    .feature div,
    .info-card div,
    .contact-card div {
      color: var(--muted);
      font-size: 13px;
      line-height: 1.65;
    }

    .timeline {
      display: grid;
      gap: 14px;
      margin-top: 18px;
      position: relative;
      padding-left: 14px;
    }

    .timeline::before {
      content: '';
      position: absolute;
      left: 6px;
      top: 4px;
      bottom: 4px;
      width: 1px;
      background: linear-gradient(180deg, rgba(26, 86, 219, .25), rgba(14, 165, 233, .18));
    }

    .timeline-item {
      position: relative;
      padding: 18px 18px 18px 22px;
      border-radius: 20px;
      background: var(--surface-strong);
      border: 1px solid var(--line);
      box-shadow: 0 12px 26px rgba(16, 32, 61, .05);
      transition: transform .22s ease, box-shadow .22s ease;
    }

    .timeline-item::before {
      content: '';
      position: absolute;
      left: -2px;
      top: 24px;
      width: 12px;
      height: 12px;
      border-radius: 999px;
      background: linear-gradient(135deg, var(--brand-2), var(--accent));
      box-shadow: 0 0 0 6px rgba(26, 86, 219, .10);
    }

    .timeline-item:hover {
      transform: translateX(4px);
    }

    .timeline-year {
      font-size: 12px;
      font-weight: 800;
      letter-spacing: .12em;
      text-transform: uppercase;
      color: var(--brand-2);
      margin-bottom: 6px;
    }

    .timeline-title {
      font-size: 16px;
      font-weight: 800;
      margin-bottom: 6px;
    }

    .timeline-desc {
      color: var(--muted);
      font-size: 14px;
      line-height: 1.75;
    }

    .aside {
      display: grid;
      gap: 22px;
    }

    .info-card,
    .contact-card {
      border-radius: var(--radius-xl);
      padding: 24px;
      background: var(--surface);
      border: 1px solid rgba(255, 255, 255, .65);
      box-shadow: 0 14px 34px rgba(16, 32, 61, .08);
      transition: transform .22s ease, box-shadow .22s ease;
    }

    .contact-list {
      display: grid;
      gap: 12px;
      margin-top: 16px;
    }

    .contact-item {
      padding: 14px 0;
      border-top: 1px solid var(--line);
    }

    .contact-item:first-child {
      border-top: 0;
      padding-top: 0;
    }

    .contact-item span {
      display: block;
      color: var(--muted);
      font-size: 13px;
      margin-top: 4px;
      line-height: 1.65;
    }

    .cta-box {
      border-radius: var(--radius-xl);
      padding: 24px;
      color: #fff;
      background: linear-gradient(135deg, var(--brand), var(--brand-2) 55%, var(--accent));
      box-shadow: 0 24px 52px rgba(26, 86, 219, .26);
    }

    .cta-box p {
      color: rgba(255, 255, 255, .82);
      font-size: 14px;
      line-height: 1.8;
      margin: 10px 0 0;
    }

    .cta-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 18px;
    }

    .cta-actions .btn-primary {
      box-shadow: none;
    }

    .cta-actions .btn-secondary {
      border-color: rgba(255, 255, 255, .20);
    }

    .footer {
      text-align: center;
      color: var(--muted);
      font-size: 13px;
      padding: 24px 0 8px;
    }

    .reveal {
      opacity: 0;
      transform: translateY(24px);
      transition: opacity .7s ease, transform .7s ease;
      will-change: opacity, transform;
    }

    .reveal.is-visible {
      opacity: 1;
      transform: translateY(0);
    }

    .delay-1 { transition-delay: .08s; }
    .delay-2 { transition-delay: .16s; }
    .delay-3 { transition-delay: .24s; }
    .delay-4 { transition-delay: .32s; }

    @media (max-width: 1024px) {
      body { padding: 18px; }
      .hero-inner,
      .main,
      .intro {
        grid-template-columns: 1fr;
      }
      .hero-visual {
        min-height: 260px;
      }
    }

    @media (max-width: 720px) {
      body { padding: 14px; }
      .hero-inner,
      .panel,
      .info-card,
      .contact-card,
      .cta-box {
        padding: 20px;
      }
      .brand-row {
        align-items: flex-start;
      }
      .metric-grid,
      .feature-grid {
        grid-template-columns: 1fr;
      }
      .hero-actions,
      .cta-actions {
        width: 100%;
      }
      .btn {
        width: 100%;
      }
    }

    @media print {
      body {
        background: #fff;
        padding: 0;
      }

      body::before,
      body::after {
        display: none;
      }

      .card,
      .hero,
      .panel,
      .info-card,
      .contact-card,
      .cta-box,
      .feature,
      .timeline-item {
        box-shadow: none !important;
      }

      .btn,
      .hero-actions,
      .cta-actions {
        display: none !important;
      }
    }
  </style>
</head>
@php
  $schoolName = \App\Models\Setting::get('nama_sekolah', config('app.name', 'SMA Contoh Kita'));
  $logoPath = \App\Models\Setting::get('logo_sekolah');
  $schoolLogoSrc = null;

  if (!empty($logoPath)) {
      $isAbsoluteLogo = str_starts_with($logoPath, 'http://') || str_starts_with($logoPath, 'https://');
      $schoolLogoSrc = $isAbsoluteLogo ? $logoPath : asset('storage/' . ltrim($logoPath, '/'));
  }

  $aboutImage = asset('images/about-hero.svg');
@endphp
<body>
  <div class="page">
    <section class="hero card reveal is-visible">
      <div class="hero-inner">
        <div>
          <div class="brand-row">
            <div class="brand-logo">
              @if(!empty($schoolLogoSrc))
                <img src="{{ $schoolLogoSrc }}" alt="Logo {{ $schoolName }}">
              @else
                <div class="brand-logo-fallback">{{ strtoupper(mb_substr($schoolName, 0, 1)) }}</div>
              @endif
            </div>
            <div>
              <div style="font-size:13px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;opacity:.84">Brosur Sekolah</div>
              <div style="font-size:15px;font-weight:700;opacity:.92;margin-top:4px">{{ $schoolName }}</div>
            </div>
          </div>

          <div class="eyebrow">Profil Singkat</div>
          <h1>Desain brosur yang lebih bersih, modern, dan enak dibaca saat scroll.</h1>
          <p>Halaman ini menampilkan identitas sekolah, program utama, fasilitas, dan kontak dalam satu tampilan yang lebih rapi. Efek reveal muncul saat Anda menggulir agar tiap bagian terasa hidup tanpa berlebihan.</p>

          <div class="hero-actions">
            <a href="{{ route('about') }}" class="btn btn-primary">Kunjungi Halaman Tentang</a>
            <a href="#kontak" class="btn btn-secondary">Lihat Kontak</a>
          </div>
        </div>

        <div class="hero-side">
          <div class="hero-visual reveal delay-1">
            <img src="{{ $aboutImage }}" alt="Ilustrasi brosur {{ $schoolName }}">
            <div class="hero-visual-caption">
              <div>
                <strong>Visual Premium</strong>
                <span>Kontras tinggi, bersih, dan responsif</span>
              </div>
              <div style="text-align:right">
                <strong>Scroll Reveal</strong>
                <span>Animasi lembut saat masuk viewport</span>
              </div>
            </div>
          </div>

          <div class="metric-grid">
            <div class="metric reveal delay-2">
              <div class="metric-value">2</div>
              <div class="metric-label">Jurusan utama yang ditonjolkan</div>
            </div>
            <div class="metric reveal delay-3">
              <div class="metric-value">A</div>
              <div class="metric-label">Fokus pada tampilan bersih dan mudah dibaca</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="main">
      <div class="stack">
        <section class="panel card reveal delay-1">
          <div class="eyebrow" style="background: rgba(26,86,219,.10); color: var(--brand); border-color: rgba(26,86,219,.10);">Visi</div>
          <h2>Menjadi sekolah yang unggul dan relevan untuk masa depan siswa.</h2>
          <p>Konten ini dibuat lebih tegas secara visual supaya pesan utama langsung terbaca. Layout tetap ringan dan bisa dipakai ulang untuk halaman brosur lain tanpa banyak penyesuaian.</p>
        </section>

        <section class="panel card reveal delay-2">
          <div class="eyebrow" style="background: rgba(14,165,233,.10); color: var(--accent); border-color: rgba(14,165,233,.10);">Program Unggulan</div>
          <div class="feature-grid">
            <div class="feature">
              <strong>Laboratorium Terpadu</strong>
              <div>Fasilitas praktik yang mendukung pembelajaran berbasis proyek.</div>
            </div>
            <div class="feature">
              <strong>Perpustakaan Modern</strong>
              <div>Ruang belajar yang nyaman untuk literasi dan riset mandiri.</div>
            </div>
            <div class="feature">
              <strong>Ekstrakurikuler</strong>
              <div>Wadah pengembangan karakter, disiplin, dan bakat siswa.</div>
            </div>
            <div class="feature">
              <strong>Bimbingan Karir</strong>
              <div>Membantu siswa lebih siap memasuki dunia kerja atau studi lanjut.</div>
            </div>
          </div>
        </section>

        <section class="panel card reveal delay-3">
          <div class="eyebrow" style="background: rgba(26,86,219,.10); color: var(--brand); border-color: rgba(26,86,219,.10);">Misi</div>
          <div class="timeline">
            <div class="timeline-item">
              <div class="timeline-year">01</div>
              <div class="timeline-title">Pendidikan berkualitas</div>
              <div class="timeline-desc">Fokus pada kemampuan akademik, praktik, dan kebiasaan belajar yang kuat.</div>
            </div>
            <div class="timeline-item">
              <div class="timeline-year">02</div>
              <div class="timeline-title">Pembinaan karakter</div>
              <div class="timeline-desc">Menanamkan disiplin, tanggung jawab, dan budaya kerja yang baik.</div>
            </div>
            <div class="timeline-item">
              <div class="timeline-year">03</div>
              <div class="timeline-title">Keterampilan vokasional</div>
              <div class="timeline-desc">Menjaga materi tetap relevan dengan kebutuhan industri dan dunia kerja.</div>
            </div>
          </div>
        </section>
      </div>

      <aside class="aside">
        <section class="info-card reveal delay-1">
          <div class="eyebrow" style="background: rgba(255,255,255,.55); color: var(--brand); border-color: var(--line);">Informasi Cepat</div>
          <strong>Identitas Sekolah</strong>
          <div class="contact-list">
            <div class="contact-item">
              <strong>Alamat</strong>
              <span>Jalan Contoh No.1, Jakarta</span>
            </div>
            <div class="contact-item">
              <strong>Telepon</strong>
              <span>(021) 123-456</span>
            </div>
            <div class="contact-item">
              <strong>Email</strong>
              <span>info@sekolahcontoh.id</span>
            </div>
            <div class="contact-item">
              <strong>Website</strong>
              <span>{{ url('/') }}</span>
            </div>
          </div>
        </section>

        <section class="contact-card reveal delay-2" id="kontak">
          <div class="eyebrow" style="background: rgba(255,255,255,.55); color: var(--brand); border-color: var(--line);">Akses Cepat</div>
          <strong>Langsung ke halaman utama</strong>
          <div>Gunakan tombol berikut untuk kembali ke halaman About atau membuka brosur dalam alur yang lebih sederhana.</div>
          <div class="cta-actions">
            <a href="{{ route('about') }}" class="btn btn-primary">Tentang Kami</a>
            <a href="{{ url('/') }}" class="btn btn-secondary">Beranda</a>
          </div>
        </section>

        <section class="cta-box reveal delay-3">
          <div class="eyebrow" style="background: rgba(255,255,255,.12); color: #fff; border-color: rgba(255,255,255,.18);">Pendaftaran</div>
          <h2 style="margin:0;font-size:24px;line-height:1.12;letter-spacing:-0.03em">Brosur yang lebih hidup, tanpa terasa ramai.</h2>
          <p>Scroll reveal dipasang hanya pada elemen penting supaya transisinya halus dan tidak mengganggu pembacaan. Cocok untuk tampilan sekolah yang formal namun tetap modern.</p>
          <div class="cta-actions">
            <a href="{{ route('about') }}" class="btn btn-primary">Lihat About</a>
            <a href="#" onclick="window.print(); return false;" class="btn btn-secondary">Cetak Brosur</a>
          </div>
        </section>
      </aside>
    </div>

    <div class="footer">© {{ date('Y') }} {{ $schoolName }} • Brosur digital sekolah</div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const revealElements = document.querySelectorAll('.reveal');
      if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries, observerInstance) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.add('is-visible');
              observerInstance.unobserve(entry.target);
            }
          });
        }, { threshold: 0.16, rootMargin: '0px 0px -8% 0px' });

        revealElements.forEach((element) => observer.observe(element));
      } else {
        revealElements.forEach((element) => element.classList.add('is-visible'));
      }
    });
  </script>
</body>
</html>
