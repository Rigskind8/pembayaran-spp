<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', config('app.name', 'Pembayaran SPP'))</title>

  <meta name="description" content="@yield('meta_description','SMA Contoh Kita — pendidikan berkarakter, fasilitas modern, dan pembelajaran berkualitas.')">
  <meta name="theme-color" content="#0ea5e9">

  <!-- Open Graph / Twitter -->
  <meta property="og:title" content="@yield('meta_title', config('app.name','SMA Contoh Kita'))">
  <meta property="og:description" content="@yield('meta_description','SMA Contoh Kita — pendidikan berkarakter, fasilitas modern, dan pembelajaran berkualitas.')">
  <meta property="og:image" content="@yield('meta_image', asset('images/about-hero.svg'))">
  <meta property="og:url" content="@yield('meta_url', url()->current())">
  <meta property="og:type" content="@yield('meta_type','website')">
  <meta name="twitter:card" content="@yield('meta_twitter_card','summary_large_image')">

  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

  @if (file_exists(public_path('build/manifest.json')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @else
    {{-- Vite manifest not found (public/build/manifest.json). --}}
    {{-- Build assets with `npm install && npm run build` or run dev server `npm run dev` to enable @vite. --}}
  @endif

  <style>
    .bg-gradient-animated { background: linear-gradient(135deg,#0ea5e9 0%, #a78bfa 50%, #34d399 100%); background-size: 200% 200%; animation: gradientShift 8s ease infinite; }
    @keyframes gradientShift { 0%{background-position:0% 50%} 50%{background-position:100% 50%} 100%{background-position:0% 50%} }

    /* Accessibility: skip link (visible on focus) */
    .skip-link { position: absolute; left: -999px; top: auto; width: 1px; height: 1px; overflow: hidden; }
    .skip-link:focus { position: fixed; left: 12px; top: 12px; width: auto; height: auto; padding: 8px 12px; background: #ffffff; color: #0f172a; border-radius: 6px; z-index: 9999; box-shadow: 0 8px 20px rgba(2,6,23,.12); }

    /* Mobile menu fallback if Tailwind isn't loaded yet */
    .mobile-menu { display: none; }
    .mobile-menu.open { display: block; }
    @media (max-width: 768px) {
      .desktop-nav { display: none; }
      .mobile-toggle { display: inline-flex; }
    }
  </style>
  @stack('styles')
</head>
<body class="antialiased bg-gray-50 text-slate-900">

  <a href="#main-content" class="skip-link">Lewati ke konten</a>

  @unless(request()->routeIs('about'))
    <header class="w-full">
      <nav class="max-w-6xl mx-auto px-6 py-5 flex items-center justify-between relative">
        <div class="flex items-center gap-4">
          <a href="{{ url('/') }}" class="font-semibold text-lg">@yield('brand', config('app.name','SMA Contoh Kita'))</a>
        </div>

        <div class="flex items-center gap-3">
          <button id="mobile-menu-button" class="mobile-toggle md:hidden p-2 rounded-md" aria-controls="mobile-menu" aria-expanded="false" aria-label="Buka menu" style="display:none">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>

          <div class="desktop-nav flex items-center gap-3">
            @auth
              <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-md text-sm bg-white shadow">Dashboard</a>
            @else
              <a href="{{ route('login') }}" class="px-4 py-2 rounded-md text-sm">Masuk</a>
              @if (Route::has('register'))
                <a href="{{ route('register') }}" class="px-4 py-2 rounded-md text-sm bg-blue-600 text-white">Daftar</a>
              @endif
            @endauth
          </div>
        </div>
      </nav>

      <div id="mobile-menu" class="mobile-menu fixed inset-0 bg-white z-50 p-6" aria-hidden="true">
        <div class="flex items-center justify-between mb-6">
          <a href="{{ url('/') }}" class="font-semibold text-lg">@yield('brand', config('app.name','SMA Contoh Kita'))</a>
          <button id="mobile-menu-close" aria-label="Tutup menu" class="p-2 rounded-md">×</button>
        </div>
        <nav class="flex flex-col gap-4 text-lg">
          @auth
            <a href="{{ route('dashboard') }}" class="font-medium">Dashboard</a>
          @else
            <a href="{{ route('login') }}" class="font-medium">Masuk</a>
            @if (Route::has('register'))
              <a href="{{ route('register') }}" class="font-medium">Daftar</a>
            @endif
          @endauth
          <a href="{{ route('about') }}" class="font-medium">Tentang</a>
        </nav>
      </div>
    </header>
  @endunless

  <main id="main-content" class="min-h-screen">
    @yield('content')
  </main>

  @unless(request()->routeIs('about'))
    <footer class="mt-12 bg-white">
      <div class="max-w-6xl mx-auto px-6 py-6 text-sm text-slate-600 flex items-center justify-between">
        <div>© {{ date('Y') }} SMA Contoh Kita</div>
        <div>Alamat • Telepon • Email</div>
      </div>
    </footer>
  @endunless

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if(entry.isIntersecting){
            entry.target.classList.remove('opacity-0','translate-y-6');
            entry.target.classList.add('opacity-100','translate-y-0','transition','duration-700','ease-out');
            observer.unobserve(entry.target);
          }
        });
      }, {threshold: 0.15});
      document.querySelectorAll('.reveal').forEach(el => {
        el.classList.add('opacity-0','translate-y-6');
        observer.observe(el);
      });

      const hero = document.querySelector('.hero-parallax');
      if(hero){
        hero.addEventListener('mousemove', e => {
          const rect = hero.getBoundingClientRect();
          const x = (e.clientX - rect.left) / rect.width - 0.5;
          const y = (e.clientY - rect.top) / rect.height - 0.5;
          hero.style.transform = `translate3d(${x * 12}px, ${y * 8}px, 0)`;
        });
        hero.addEventListener('mouseleave', () => hero.style.transform = '');
      }
    });
  </script>

    <script>
      // Mobile menu toggle (fallback)
      (function(){
        function show(el){ el.classList.add('open'); el.setAttribute('aria-hidden','false'); }
        function hide(el){ el.classList.remove('open'); el.setAttribute('aria-hidden','true'); }
        var btn = document.getElementById('mobile-menu-button');
        var closeBtn = document.getElementById('mobile-menu-close');
        var menu = document.getElementById('mobile-menu');
        if(btn && menu){
          btn.style.display = 'inline-flex';
          btn.addEventListener('click', function(){
            var expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', (!expanded).toString());
            show(menu);
          });
        }
        if(closeBtn && menu){
          closeBtn.addEventListener('click', function(){ hide(menu); document.getElementById('mobile-menu-button')?.setAttribute('aria-expanded','false'); });
        }
        // close on escape
        document.addEventListener('keydown', function(e){ if(e.key==='Escape'){ hide(menu); btn?.setAttribute('aria-expanded','false'); } });
      })();
    </script>

</body>
@stack('scripts')
</html>
