<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <title>@yield('title', 'Sistem SPP')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">  

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;1,9..40,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html[data-theme="light"] {
            --bg-1: radial-gradient(circle at top left, rgba(59,130,246,.12), transparent 28%), radial-gradient(circle at bottom right, rgba(139,92,246,.13), transparent 32%), #eef2ff;
            --text-main: #0f172a;
            --card-bg: #ffffff;
            --card-border: rgba(148,163,184,.18);
            --input-bg: #ffffff;
            --input-text: #0f172a;
            --muted: #64748b;
            --sb-grad: linear-gradient(180deg, #232946 0%, #2563eb 60%, #7c3aed 100%);
        }
        html[data-theme="dark"] {
            --bg-1: radial-gradient(circle at top left, rgba(14,116,144,.22), transparent 32%), radial-gradient(circle at bottom right, rgba(30,41,59,.35), transparent 40%), #0b1220;
            --text-main: #e2e8f0;
            --card-bg: #111827;
            --card-border: rgba(71,85,105,.55);
            --input-bg: #0f172a;
            --input-text: #e2e8f0;
            --muted: #94a3b8;
            --sb-grad: linear-gradient(180deg, #232946 0%, #2563eb 60%, #7c3aed 100%);
        }
        body {
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            color: var(--text-main);
            background: var(--bg-1), linear-gradient(180deg, #232946 0%, #2563eb 60%, #7c3aed 100%);
        }
        html[data-theme="dark"] body {
            background: var(--bg-1);
            color: #e2e8f0;
        }
        a { color: inherit; text-decoration: none; }
        button, input, select { font: inherit; }
        .content-wrapper { min-height: 100vh; }
        .app { display: flex; min-height: 100vh; }
        .main { margin-left: var(--sb); width: calc(100% - var(--sb)); transition: margin-left .3s cubic-bezier(.4,0,.2,1), width .3s cubic-bezier(.4,0,.2,1); }
        .sb { transition: width .28s cubic-bezier(.4,0,.2,1), padding .28s ease; background: #e5e7eb !important; }
        .sb.sb-closed { width: 60px !important; }
        .main.sb-closed { margin-left: 60px !important; width: calc(100% - 60px) !important; }
    /* Pastikan .sb selalu di kiri */
    .sb { left: 0 !important; }

        @media (max-width: 900px) {
            .sb { width: 60px !important; }
            .main { margin-left: 60px !important; }
        }
        .card { border-radius: 24px; border: 1px solid var(--card-border); background: var(--card-bg); box-shadow: 0 18px 45px rgba(15,23,42,.06); }
        .form-select, .form-control { border-radius: 14px; border-color: rgba(148,163,184,.35); box-shadow: none; background: var(--input-bg); color: var(--input-text); }
        .form-select:focus, .form-control:focus { border-color: #2563eb; box-shadow: 0 0 0 0.15rem rgba(59,130,246,.15); }
        .btn-primary { background-color: #2563eb; border-color: #2563eb; border-radius: 14px; box-shadow: 0 12px 24px rgba(37,99,235,.12); }
        .btn-primary:hover, .btn-primary:focus { background-color: #1d4ed8; border-color: #1d4ed8; }
        .btn-outline-secondary { color: #0f172a; background-color: #fff; border-color: rgba(148,163,184,.35); border-radius: 14px; }
        .btn-outline-secondary:hover, .btn-outline-secondary:focus { background-color: #f8fafc; }
        .page { padding: 28px 28px 40px; }
        .page .topbar-title { letter-spacing: -.02em; }
        .page .topbar-subtitle { color: #475569; }

        :root {
            --sb: 110px;
            --sb-open: 320px;
            --sb-bg: #e5e7eb;
            --blue: #2563eb;
            --red: #ef4444;
            --gold: #e7cfa0;
        }
        .sb {
            background: #e5e7eb !important;
            width: var(--sb);
            background: var(--sb-bg) !important;
            position: fixed;
            top: 0;
            left: 0;
            min-height: 100vh;
            height: 100vh;
            z-index: 200;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 24px 14px 28px;
            transition: width .28s cubic-bezier(.4,0,.2,1), padding .28s ease;
            overflow: hidden;
            border-right: 2px solid var(--gold);
            box-shadow: 0 0 16px 0 #bfc8e655, 0 2px 8px #e6ecf599;
            backdrop-filter: blur(0px);
        }


        .sb:hover { width: var(--sb-open); }
        .sb-brand { display: flex; align-items: center; justify-content: center; gap: 0; width: 100%; padding: 10px 10px; margin-bottom: 32px; }
        .sb-mark { width: 54px; height: 54px; border-radius: 16px; background: linear-gradient(135deg, #38bdf8, #6366f1); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 22px; box-shadow: 0 4px 16px #bae6fd55; }
        .sb-name, .sb-name-text, .sb-grp, .sb-lbl, .sb-txt, .sb-u-info, .sb-brand-text { opacity: 0; max-width: 0; overflow: hidden; transition: opacity .18s ease, max-width .18s ease; pointer-events: none; white-space: nowrap; }
        .sb-nav { width: 100%; padding: 0 8px; flex: 1; display: flex; flex-direction: column; gap: 4px; }
        .sb-grp { display: block; color: #2563eb; font-size: 11px; font-weight: 700; letter-spacing: .16em; padding: 18px 0 10px; }
        .sb-a {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            padding: 16px 16px;
            border-radius: 18px;
            color: #111827;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            transition: all .18s ease;
            border: 1px solid transparent;
            background: #e5e7eb !important;
            opacity: 1 !important;
        }
        .sb-a .ic, .sb-a .sb-ic {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #111827;
            background: #e5e7eb !important;
            transition: transform .18s ease, background .18s ease, color .18s ease;
            opacity: 1 !important;
        }
                    /* Warna teks menu sidebar item selalu hitam, putih saat aktif/hover */
                    .sb-nav .sb-a .sb-lbl {
                        color: #111827 !important;
                        opacity: 1 !important;
                        transition: color .18s, opacity .18s;
                    }
                    .sb-nav .sb-a.on .sb-lbl,
                    .sb-nav .sb-a:hover .sb-lbl {
                        color: #111827 !important;
                    }
                    .sb-a.on .ic, .sb-a:hover .ic {
                        color: #111827 !important;
                        background: #e5e7eb !important;
                        opacity: 1 !important;
                    }
                    .sb-a:hover {
                        color: #111827 !important;
                        background: #e5e7eb !important;
                        border-color: #e5e7eb !important;
                    }
                    .sb-a:hover .ic, .sb-a:hover .sb-ic {
                        transform: translateX(2px);
                        background: #e5e7eb !important;
                        color: #111827 !important;
                    }
                    .sb-a.on {
                        color: #111827 !important;
                        background: #e5e7eb !important;
                        border-color: #e5e7eb !important;
                    }
                    .sb-a.on .ic, .sb-a.on .sb-ic {
                        background: #e5e7eb !important;
                        color: #111827 !important;
                        box-shadow: none !important;
                    }
        .sb-foot {
            width: 100%;
            margin-top: auto;
            padding-top: 18px;
            position: sticky;
            bottom: 0;
            background: transparent !important;
            border-top: none;
        }
        .sb-user { display: flex; align-items: center; gap: 16px; padding: 12px 0 12px 0; border-radius: 0; background: transparent; margin-bottom: 8px; }
        .sb-av { width: 48px; height: 48px; border-radius: 16px; background: #38bdf8; color: #fff; font-weight: 800; font-size: 19px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px #bae6fd55; }
        .sb-uname { font-size: 15px; font-weight: 700; color: #2563eb; }
        .sb-urole { font-size: 12px; color: #6366f1; }
        .sb-out { display: flex; align-items: center; gap: 14px; padding: 14px 0 14px 0; border-radius: 0; border: none; width: 100%; background: transparent; color: #ef4444; font-size: 15px; font-weight: 700; cursor: pointer; transition: background .18s ease; }
        .sb-out:hover { background: #fee2e2; color: #fff; }
        .sb-out .ic { width: 44px; height: 44px; border-radius: 14px; background: #fee2e2; display: flex; align-items: center; justify-content: center; color: #ef4444; }
        .sb:hover .sb-brand { justify-content: flex-start; gap: 12px; padding: 6px 14px; }
        .sb:hover .sb-name, .sb:hover .sb-name-text, .sb:hover .sb-grp, .sb:hover .sb-lbl, .sb:hover .sb-txt, .sb:hover .sb-u-info, .sb:hover .sb-brand-text {
            opacity: 1;
            max-width: 220px;
            pointer-events: auto;
        }
        .sb:hover .sb-nav { padding: 0 12px; }
        .sb:hover .sb-a { justify-content: flex-start; gap: 12px; }
        .sb:hover ~ .main { margin-left: var(--sb-open); width: calc(100% - var(--sb-open)); }
        .sb-pill { display:inline-flex; align-items:center; padding:2px 6px; border-radius:999px; margin-left:6px; font-size:9px; line-height:1.1; font-weight:800; background:#ef4444; color:#fff; box-shadow:0 0 0 2px rgba(239,68,68,.15); }
        .sb-prefs { margin-top: 12px; border-top: 1px solid rgba(148,163,184,.12); padding-top: 10px; }
        .sb-pref-row { margin-bottom: 8px; }
        .sb-pref-lbl { display: block; font-size: 10px; letter-spacing: .08em; text-transform: uppercase; color: #94a3b8; margin-bottom: 4px; font-weight: 700; }
        .sb-pref-select { width: 100%; border: 1px solid rgba(148,163,184,.35); border-radius: 10px; padding: 7px 10px; background: rgba(15,23,42,.72); color: #e2e8f0; font-size: 12px; }
        html[data-theme="dark"] .sb-pref-select { background: rgba(2,6,23,.8); color: #e2e8f0; border-color: rgba(71,85,105,.7); }
        html[data-theme="light"] .sb-pref-select { background: rgba(15,23,42,.72); color: #e2e8f0; }
        html[data-theme="dark"] .table,
        html[data-theme="dark"] .table td,
        html[data-theme="dark"] .table th { color: #e2e8f0; }
        html[data-theme="dark"] .table-light,
        html[data-theme="dark"] .table-light > th,
        html[data-theme="dark"] .table-light > td { background-color: #0f172a; color: #cbd5e1; }
        html[data-theme="dark"] .btn-outline-secondary { background: #0f172a; color: #e2e8f0; border-color: #334155; }
        html[data-theme="dark"] .text-muted { color: var(--muted) !important; }
        html[data-theme="dark"] .topbar,
        html[data-theme="dark"] .kp-topbar { background: rgba(15, 23, 42, .88) !important; border-color: #334155 !important; }
        html[data-theme="dark"] .table-card,
        html[data-theme="dark"] .tbl-card,
        html[data-theme="dark"] .kp-card,
        html[data-theme="dark"] .card,
        html[data-theme="dark"] .modal,
        html[data-theme="dark"] .modal-content { background: var(--card) !important; border-color: var(--border) !important; color: var(--txt) !important; }
        html[data-theme="dark"] table thead tr { background: rgba(30, 41, 59, .72) !important; }
        html[data-theme="dark"] table tbody tr:hover { background: rgba(51, 65, 85, .35) !important; }
        @media(max-width: 900px) { .sb { display: none; } .main { margin-left: 0; width: 100%; } }

        /* Skip link and mobile-topbar */
        .skip-link { position: absolute; left: -999px; top: auto; width:1px; height:1px; overflow:hidden }
        .skip-link:focus { position: fixed; left: 12px; top: 12px; width: auto; height: auto; padding: 8px 12px; background: #fff; color: #0f172a; border-radius: 6px; z-index: 9999; box-shadow: 0 8px 20px rgba(2,6,23,.12); }
        #mobile-topbar { display: none; }
        @media(max-width: 900px) {
            #mobile-topbar { display:flex; position: fixed; top: 0; left: 0; right: 0; height:56px; align-items: center; justify-content: space-between; padding: 8px 12px; background: var(--card); z-index: 1001; box-shadow: 0 6px 20px rgba(2,6,23,.06); }
            .content-wrapper { padding-top: 64px; }
            .open-mobile-sb .sb { display: flex !important; position: fixed; left: 0; top: 0; height: 100vh; width: var(--sb-open); z-index: 1002; }
            .open-mobile-sb .main { margin-left: var(--sb-open); width: calc(100% - var(--sb-open)); }
        }

        /* Fix Global: Menarik konten yang "kurang ke kiri" dan membuang sidebar ganda di halaman lama */
        #main-content .sb, 
        #main-content aside { display: none !important; }
        #main-content main, 
        #main-content .main,
        #main-content [class*="-main"] { margin-left: 0 !important; width: 100% !important; }
    </style>

    <style>
        .sb-nav {
            overflow-y: auto !important;
            overflow-x: hidden !important;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE 10+ */
        }
        .sb-nav::-webkit-scrollbar { width: 0; height: 0; }
        .sb-nav::-webkit-scrollbar-thumb { background: transparent; }
        .sb-nav::-webkit-scrollbar-track { background: transparent; }
        .sb { overflow: hidden !important; }
    </style>

        <style>
            .time-chip {
                background: transparent !important;
                border: 1px solid transparent !important;
            }
        </style>
        @stack('styles')
    @livewireStyles
</head>
<body>
    <a href="#main-content" class="skip-link">Lewati ke konten</a>

    <div id="mobile-topbar">
        <button id="mobile-menu-toggle" aria-controls="sidebar" aria-expanded="false" aria-label="Buka menu" style="background:transparent;border:none;font-size:20px;padding:6px;">☰</button>
        <div style="font-weight:700">@yield('title', 'Sistem SPP')</div>
        <div style="width:36px"></div>
    </div>



    @include('partials.sidebar')
    <div id="main-content" class="content-wrapper main">
        @yield('content')
    </div>

    <!-- Realtime clock (fixed top-center) - placed outside content wrapper to remain fixed during scroll -->
    <div id="realtime-clock" class="realtime-clock" aria-live="polite" title="Waktu saat ini"></div>

    <style>
        .sb, .kp-sb {
            background: var(--sb-bg, #e5e7eb) !important;
            border-right: 1px solid rgba(148,163,184,.12) !important;
            transition: width .28s cubic-bezier(.4,0,.2,1), padding .28s ease !important;
            width: var(--sb, var(--sw, 250px)) !important;
            align-items: center !important;
            padding-left: 8px !important;
            padding-right: 8px !important;
        }
        .sb:hover, .kp-sb:hover, .kp-sb.kp-open {
            width: max(var(--sb-open, var(--sw-open, 250px)), 272px) !important;
            align-items: flex-start !important;
            padding-left: 12px !important;
            padding-right: 12px !important;
        }
        .sb-brand, .kp-sb-brand {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0 !important;
            width: 100% !important;
            padding: 6px !important;
            margin-bottom: 22px !important;
        }
        .sb-mark, .kp-sb-mark {
            width: 44px !important;
            height: 44px !important;
            border-radius: 12px !important;
            background: #2563eb !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: white !important;
            font-size: 17px !important;
        }
        .sb-name, .sb-name-text, .kp-sb-name, .sb-grp, .kp-sb-grp, .sb-lbl, .kp-sb-lbl, .sb-txt, .sb-u-info, .sb-brand-text {
            opacity: 0 !important;
            max-width: 0 !important;
            overflow: hidden !important;
            transition: opacity .18s ease, max-width .18s ease !important;
            pointer-events: none !important;
            white-space: nowrap !important;
            color: #dbe7f8 !important;
        }
        .kp-sb .kp-sb-name, .kp-sb .kp-sb-grp, .kp-sb .kp-sb-lbl {
            opacity: 1 !important;
            max-width: 420px !important;
            pointer-events: auto !important;
            white-space: normal !important;
        }
        .sb:hover .sb-name, .sb:hover .sb-name-text, .sb:hover .sb-grp, .sb:hover .sb-lbl, .sb:hover .sb-txt, .sb:hover .sb-u-info, .sb:hover .sb-brand-text,
        .kp-sb:hover .kp-sb-name, .kp-sb:hover .kp-sb-grp, .kp-sb:hover .kp-sb-lbl {
            opacity: 1 !important;
            max-width: 320px !important;
            pointer-events: auto !important;
        }
        .sb-grp, .kp-sb-grp {
            color: #111827 !important;
            font-size: 12px !important;
            font-weight: 800 !important;
            letter-spacing: .08em !important;
            line-height: 1.35 !important;
            text-shadow: none !important;
            max-width: 100% !important;
            overflow: visible !important;
            background: transparent !important;
            border: none !important;
            border-radius: 0 !important;
            padding: 7px 10px !important;
            margin: 8px 0 5px !important;
        }
        .sb-lbl, .kp-sb-lbl {
            font-size: 14px !important;
            font-weight: 650 !important;
            color: #111827 !important;
            text-shadow: none !important;
        }
        .sb-a .sb-lbl, .kp-sb-a .kp-sb-lbl {
            font-size: 14px !important;
            font-weight: 700 !important;
            letter-spacing: 0 !important;
            line-height: 1.32 !important;
        }
        .sb-name, .sb-name-text, .kp-sb-name {
            color: #111827 !important;
            text-shadow: none !important;
            font-size: 14px !important;
            font-weight: 800 !important;
            color: #f8fbff !important;
        }
        .sb-nav, .kp-sb-nav {
            width: 100% !important;
            padding: 0 8px !important;
            flex: 1 !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 4px !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }
        .sb-nav::-webkit-scrollbar, .kp-sb-nav::-webkit-scrollbar {
            width: 0 !important;
            height: 0 !important;
        }
        .sb-nav::-webkit-scrollbar-thumb, .kp-sb-nav::-webkit-scrollbar-thumb { background: transparent !important; }
        .sb-nav::-webkit-scrollbar-track, .kp-sb-nav::-webkit-scrollbar-track { background: transparent !important; }
        .sb-a, .kp-sb-a {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0 !important;
            padding: 12px 14px !important;
            border-radius: 16px !important;
            color: #e2ebfa !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            text-decoration: none !important;
            transition: all .18s ease !important;
            background: transparent !important;
            line-height: 1.35 !important;
        }
        .sb-a .ic, .sb-a .sb-ic, .kp-sb-a .kp-ic {
            width: 38px !important;
            height: 38px !important;
            border-radius: 12px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 14px !important;
            color: #94a3b8 !important;
            transition: transform .18s ease, background .18s ease, color .18s ease !important;
        }
        .sb-a:hover, .kp-sb-a:hover {
            color: #ffffff !important;
            background: rgba(255,255,255,.05) !important;
        }
        .sb-a:hover .ic, .sb-a:hover .sb-ic, .kp-sb-a:hover .kp-ic {
            transform: translateX(2px) !important;
            background: rgba(255,255,255,.08) !important;
            color: #ffffff !important;
        }
        .sb-a.on, .kp-sb-a.on {
            color: #ffffff !important;
            background: rgba(37,99,235,.2) !important;
        }
        .sb-a.on .ic, .sb-a.on .sb-ic, .kp-sb-a.on .kp-ic {
            background: #2563eb !important;
            color: white !important;
            box-shadow: 0 10px 24px rgba(37,99,235,.18) !important;
        }
        .sb:hover .sb-brand, .kp-sb:hover .kp-sb-brand, .kp-sb.kp-open .kp-sb-brand {
            justify-content: flex-start !important;
            gap: 12px !important;
            padding: 6px 14px !important;
        }
        .sb:hover .sb-nav, .kp-sb:hover .kp-sb-nav, .kp-sb.kp-open .kp-sb-nav {
            padding: 0 12px !important;
        }
        .sb:hover .sb-a, .kp-sb:hover .kp-sb-a, .kp-sb.kp-open .kp-sb-a {
            justify-content: flex-start !important;
            gap: 12px !important;
        }
        .sb:hover .sb-lbl, .kp-sb:hover .kp-sb-lbl, .kp-sb.kp-open .kp-sb-lbl {
            white-space: normal !important;
            line-height: 1.35 !important;
            max-width: 320px !important;
        }
        .sb:hover .sb-name,
        .sb:hover .sb-name-text,
        .kp-sb:hover .kp-sb-name,
        .kp-sb.kp-open .kp-sb-name {
            max-width: none !important;
            overflow: visible !important;
        }
        .sb-av, .kp-sb-av {
            width: 42px !important;
            height: 42px !important;
            border-radius: 14px !important;
            background: #2563eb !important;
            color: white !important;
            font-weight: 800 !important;
            font-size: 15px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .sb-user, .kp-sb-user { background: rgba(255,255,255,.05) !important; }
        .sb-foot, .kp-sb-foot {
            width: 100% !important;
            margin-top: auto !important;
            border-top: 1px solid rgba(148,163,184,.12) !important;
            padding-top: 18px !important;
            padding-left: 8px !important;
            padding-right: 8px !important;
            background: linear-gradient(180deg, transparent 0%, rgba(15,23,42,.96) 45%, rgba(15,23,42,1) 100%) !important;
        }
        .sb-user, .kp-sb-user {
            justify-content: center !important;
        }
        .sb-out, .kp-sb-out {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 12px !important;
            padding: 12px 14px !important;
            border-radius: 16px !important;
            width: 100% !important;
            background: rgba(248,113,113,.1) !important;
            color: #fee2e2 !important;
            border: none !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            cursor: pointer !important;
            transition: background .18s ease !important;
        }
        .sb-out:hover, .kp-sb-out:hover { background: rgba(248,113,113,.18) !important; }
        .sb-out .ic, .kp-sb-out .kp-ic {
            width: 42px !important;
            height: 42px !important;
            border-radius: 12px !important;
            background: rgba(248,113,113,.18) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #f87171 !important;
            font-size: 15px !important;
        }
        .sb:hover .sb-user,
        .kp-sb:hover .kp-sb-user,
        .kp-sb.kp-open .kp-sb-user,
        .sb:hover .sb-out,
        .kp-sb:hover .kp-sb-out,
        .kp-sb.kp-open .kp-sb-out {
            justify-content: flex-start !important;
        }
        .sb:hover .sb-foot,
        .kp-sb:hover .kp-sb-foot,
        .kp-sb.kp-open .kp-sb-foot {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }
        .sb:hover .sb-brand,
        .kp-sb:hover .kp-sb-brand,
        .kp-sb.kp-open .kp-sb-brand {
            padding-left: 26px !important;
            padding-right: 14px !important;
        }
        html[data-theme="light"],
        html[data-theme="light"] .content-wrapper {
            --bg: #f4f6fa !important;
            --card: #ffffff !important;
            --border: #e2e8f0 !important;
            --txt: #0f172a !important;
            --txt2: #64748b !important;
            --txt3: #94a3b8 !important;
            --blue: #2563eb !important;
            --blue-bg: #eff6ff !important;
            --green: #059669 !important;
            --green-bg: #ecfdf5 !important;
            --red: #dc2626 !important;
            --red-bg: #fef2f2 !important;
            --amber: #d97706 !important;
            --amber-bg: #fffbeb !important;
            --orange: #ea580c !important;
            --orange-bg: #fff7ed !important;
            --purple: #7c3aed !important;
            --purple-bg: #f5f3ff !important;
        }
        html[data-theme="dark"],
        html[data-theme="dark"] .content-wrapper {
            --bg: #0b1220 !important;
            --card: #111827 !important;
            --border: #2b3648 !important;
            --txt: #e2e8f0 !important;
            --txt2: #94a3b8 !important;
            --txt3: #64748b !important;
            --blue: #60a5fa !important;
            --blue-bg: rgba(59,130,246,.18) !important;
            --green: #34d399 !important;
            --green-bg: rgba(16,185,129,.16) !important;
            --red: #f87171 !important;
            --red-bg: rgba(239,68,68,.16) !important;
            --amber: #fbbf24 !important;
            --amber-bg: rgba(251,191,36,.16) !important;
            --orange: #fb923c !important;
            --orange-bg: rgba(251,146,60,.16) !important;
            --purple: #a78bfa !important;
            --purple-bg: rgba(167,139,250,.16) !important;
        }
        html[data-theme="dark"] body {
            background: var(--bg-1) !important;
            color: #e2e8f0 !important;
        }
        html[data-theme="dark"] .topbar,
        html[data-theme="dark"] .kp-topbar {
            background: rgba(15, 23, 42, .88) !important;
            border-color: #334155 !important;
        }
        html[data-theme="dark"] .table-card,
        html[data-theme="dark"] .tbl-card,
        html[data-theme="dark"] .kp-card,
        html[data-theme="dark"] .card,
        html[data-theme="dark"] .modal,
        html[data-theme="dark"] .modal-content {
            background: var(--card) !important;
            border-color: var(--border) !important;
            color: var(--txt) !important;
        }
        html[data-theme="dark"] table thead tr { background: rgba(30, 41, 59, .72) !important; }
        html[data-theme="dark"] table tbody tr:hover { background: rgba(51, 65, 85, .35) !important; }
    </style>

    <style>
</style>

    {{-- Welcome modal for first-time post-login (cookie-based) --}}
    @auth
    <div id="welcome-modal" class="modal-overlay" role="dialog" aria-modal="true" aria-hidden="true" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1000;align-items:center;justify-content:center;">
        <div class="modal-box" role="document" style="background:white;border-radius:16px;max-width:520px;width:100%;margin:16px;overflow:hidden;">
            <div class="modal-hd">
                <div class="modal-ttl">Selamat datang, {{ Auth::user()->name }}!</div>
                <button class="modal-close" aria-label="Tutup" id="welcome-close">×</button>
            </div>
            <div class="modal-body">
                <p>Terima kasih telah masuk. Berikut beberapa link cepat untuk memulai:</p>
                <ul style="margin-top:12px;">
                    <li><a href="{{ route('siswa.pembayaran') }}">Cek Tagihan & Pembayaran</a></li>
                    <li><a href="{{ route('schedule.index') }}">Lihat Jadwal</a></li>
                    <li><a href="{{ route('dashboard') }}">Ke Dashboard</a></li>
                    <li><a href="{{ route('about') }}">Tentang Sekolah</a></li>
                </ul>
            </div>
            <div class="modal-ft">
                <button id="welcome-dismiss" class="btn-cancel">Tutup</button>
                <a href="{{ route('siswa.pembayaran') }}" class="btn-primary">Cek Pembayaran</a>
            </div>
        </div>
    </div>
    <script>
        (function(){
            try{
                const cookieName = 'school_welcome_v1';
                function getCookie(n){ const v=document.cookie.match('(^|;)\\s*'+n+'\\s*=\\s*([^;]+)'); return v?v.pop():'' }
                function setCookie(n,v,d){ const e=new Date(); e.setTime(e.getTime()+d*24*60*60*1000); document.cookie = n + '=' + v + ';path=/;expires=' + e.toUTCString(); }
                if(!getCookie(cookieName)){
                    const modal = document.getElementById('welcome-modal');
                    if(modal){ modal.style.display = 'flex'; modal.setAttribute('aria-hidden','false'); }
                    document.getElementById('welcome-close')?.addEventListener('click', ()=>{ modal.style.display='none'; modal.setAttribute('aria-hidden','true'); setCookie(cookieName,'1',30); });
                    document.getElementById('welcome-dismiss')?.addEventListener('click', ()=>{ modal.style.display='none'; modal.setAttribute('aria-hidden','true'); setCookie(cookieName,'1',30); });
                }
            }catch(e){ console.error(e); }
        })();
    </script>
    @endauth

    <style>
        .realtime-clock {
            position: fixed;
            left: 50%;
            transform: translateX(-50%);
            top: 12px;
            z-index: 9999;
            background: rgba(255,255,255,0.95);
            color: var(--text-main);
            padding: 8px 12px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(2,6,23,.12);
            font-weight: 700;
            font-size: 13px;
            text-align: center;
            min-width: 220px;
            max-width: calc(100% - 40px);
        }
        html[data-theme="dark"] .realtime-clock {
            background: rgba(6,10,20,.6);
            color: var(--text-main);
            backdrop-filter: blur(6px);
        }
        .realtime-clock .clock-date { display:block; font-size:11px; color:var(--muted); font-weight:600; }
        .realtime-clock .clock-time { display:block; font-size:16px; margin-top:2px; letter-spacing:0.02em; }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (function () {
            function updateClock() {
                var el = document.getElementById('realtime-clock');
                if (!el) return;
                var now = new Date();
                var date = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                var time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                el.innerHTML = '<span class="clock-date">' + date + '</span>' +
                               '<span class="clock-time">' + time + '</span>';
            }
            document.addEventListener('DOMContentLoaded', function () {
                updateClock();
                setInterval(updateClock, 1000);
            });
        })();
    </script>

    @livewireScripts

    <script>
        // Mobile sidebar toggle for small screens
        (function(){
            var t = document.getElementById('mobile-menu-toggle');
            if(!t) return;
            t.addEventListener('click', function(e){
                var expanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', (!expanded).toString());
                document.body.classList.toggle('open-mobile-sb');
            });

            // Close when clicking outside sidebar on mobile
            document.addEventListener('click', function(e){
                if(!document.body.classList.contains('open-mobile-sb')) return;
                var sb = document.querySelector('.sb');
                if(sb && !sb.contains(e.target) && !t.contains(e.target)){
                    document.body.classList.remove('open-mobile-sb');
                    t.setAttribute('aria-expanded','false');
                }
            });
        })();
    </script>

    @stack('scripts')
    @auth
        @if(Route::has('admin.wa'))
            <a href="{{ route('admin.wa') }}" target="_blank" rel="noopener" class="wa-float" aria-label="Chat Admin via WhatsApp">
                <i class="fab fa-whatsapp"></i>
            </a>
        @endif
    @endauth

    <style>
        .wa-float {
            position: fixed;
            right: 18px;
            bottom: 18px;
            z-index: 1400;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #25D366;
            color: #fff;
            font-size: 22px;
            box-shadow: 0 10px 28px rgba(2,6,23,.18);
            transition: transform .15s ease;
        }
        .wa-float:hover { transform: translateY(-4px); }
        @media(max-width:600px){ .wa-float{ right:12px; bottom:12px; width:48px; height:48px; font-size:20px; } }
    </style>
</body>
</html>