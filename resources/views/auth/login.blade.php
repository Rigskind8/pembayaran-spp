<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMK Travina Prima</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}

        :root{
            --bg:#f4f6f9;--surface:#ffffff;--surface2:#f1f3f6;--surface3:#e8ebf0;
            --border:#dfe2e8;--border-h:#c8cdd6;
            --txt:#111827;--txt2:#6b7280;--txt3:#9ca3af;--txt4:#c9cdd4;
            --accent:#0694a2;--accent-h:#057a85;--accent-bg:rgba(6,148,162,.06);--accent-bdr:rgba(6,148,162,.18);
            --err:#dc2626;--err-bg:#fef2f2;--err-bdr:#fecaca;
            --sh-sm:0 1px 2px rgba(0,0,0,.03);
            --sh:0 1px 3px rgba(0,0,0,.05),0 1px 2px rgba(0,0,0,.03);
            --sh-md:0 4px 12px rgba(0,0,0,.06);
            --left-bg:linear-gradient(160deg,#eef5ff 0%,#f3eeff 30%,#fdf2f8 60%,#fff5ee 100%);
            --left-grid:rgba(0,0,0,.02);
            --feat-bg:#ffffff;--feat-bdr:#eef0f4;
            --input-bg:#f7f8fa;--input-focus-bg:#ffffff;
            --chk-bdr:#c8cdd6;
            --overlay-bg:rgba(255,255,255,.92);
            --orb1:rgba(6,148,162,.08);--orb2:rgba(139,92,246,.06);--orb3:rgba(245,158,11,.06);
            --clr1-bg:rgba(6,148,162,.06);--clr1:#0694a2;
            --clr2-bg:rgba(5,150,105,.06);--clr2:#059669;
            --clr3-bg:rgba(217,119,6,.06);--clr3:#d97706;
            --anim-accent:#0694a2;
        }

        [data-theme="dark"]{
            --bg:#09090b;--surface:#111113;--surface2:#1a1a1e;--surface3:#222228;
            --border:rgba(255,255,255,.07);--border-h:rgba(255,255,255,.13);
            --txt:#f4f4f5;--txt2:#a1a1aa;--txt3:#71717a;--txt4:#52525b;
            --accent:#0ab0bf;--accent-h:#0cc4d4;--accent-bg:rgba(10,176,191,.08);--accent-bdr:rgba(10,176,191,.2);
            --err:#f87171;--err-bg:rgba(239,68,68,.06);--err-bdr:rgba(239,68,68,.15);
            --sh-sm:0 1px 2px rgba(0,0,0,.2);
            --sh:0 1px 3px rgba(0,0,0,.3);
            --sh-md:0 4px 12px rgba(0,0,0,.35);
            --left-bg:linear-gradient(160deg,#0c1525 0%,#10101e 30%,#150d1e 60%,#12100d 100%);
            --left-grid:rgba(255,255,255,.015);
            --feat-bg:#18181b;--feat-bdr:rgba(255,255,255,.06);
            --input-bg:#0c0c0e;--input-focus-bg:#111113;
            --chk-bdr:#52525b;
            --overlay-bg:rgba(9,9,11,.95);
            --orb1:rgba(10,176,191,.06);--orb2:rgba(139,92,246,.04);--orb3:rgba(251,191,36,.04);
            --clr1-bg:rgba(10,176,191,.08);--clr1:#0ab0bf;
            --clr2-bg:rgba(52,211,153,.06);--clr2:#34d399;
            --clr3-bg:rgba(251,191,36,.06);--clr3:#fbbf24;
            --anim-accent:#0ab0bf;
        }

        html,body{height:100%}
        body{font-family:'Inter',-apple-system,sans-serif;background:var(--bg);color:var(--txt);-webkit-font-smoothing:antialiased;overflow:hidden;transition:background .4s,color .4s}
        .layout{display:flex;min-height:100vh}

        /* ═══ LEFT ═══ */
        .side{flex:1;display:flex;flex-direction:column;justify-content:space-between;padding:44px;position:relative;overflow:hidden;background:var(--left-bg);transition:background .4s}
        .side::after{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 60% 50% at 50% 40%,var(--accent-bg),transparent);pointer-events:none}
        .grid-bg{position:absolute;inset:0;background-image:linear-gradient(var(--left-grid) 1px,transparent 1px),linear-gradient(90deg,var(--left-grid) 1px,transparent 1px);background-size:48px 48px;mask-image:radial-gradient(ellipse 80% 70% at 50% 50%,black 20%,transparent 70%);-webkit-mask-image:radial-gradient(ellipse 80% 70% at 50% 50%,black 20%,transparent 70%);pointer-events:none}

        .side-top{position:relative;z-index:2}
        .logo{display:flex;align-items:center;gap:11px}
        .logo-mark{width:38px;height:38px;border-radius:11px;background:var(--accent);display:flex;align-items:center;justify-content:center;color:#fff;font-size:15px;box-shadow:0 4px 12px rgba(6,148,162,.25)}
        .logo-text{font-size:15px;font-weight:700;color:var(--txt);letter-spacing:-.2px;transition:color .4s}

        .side-center{position:relative;z-index:2;flex:1;display:flex;flex-direction:column;justify-content:center;align-items:center;max-width:440px;margin:0 auto;text-align:center}
        .side-label{display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:600;color:var(--accent);text-transform:uppercase;letter-spacing:.12em;margin-bottom:20px}
        .side-label::before{content:'';width:18px;height:1.5px;background:var(--accent);border-radius:1px}

        /* ═══ ANIMATED SCENE ═══ */
        .anim-scene{width:220px;height:220px;margin:0 auto 24px;position:relative}

        /* Outer orbit ring */
        .orbit-ring{
            position:absolute;inset:0;border-radius:50%;
            border:1.5px dashed var(--accent-bdr);
            animation:orbitSpin 25s linear infinite;
        }
        .orbit-ring.r2{inset:-14px;border-color:rgba(139,92,246,.12);animation-direction:reverse;animation-duration:35s}
        .orbit-ring.r3{inset:-28px;border-color:rgba(245,158,11,.08);animation-duration:45s}
        @keyframes orbitSpin{to{transform:rotate(360deg)}}

        /* Orbiting dots */
        .orbit-dot{
            position:absolute;width:7px;height:7px;border-radius:50%;
            top:50%;left:50%;margin:-3.5px 0 0 -3.5px;
        }
        .orbit-dot.d1{
            background:var(--anim-accent);
            animation:orbitDot1 8s linear infinite;
            box-shadow:0 0 8px rgba(6,148,162,.3);
        }
        .orbit-dot.d2{
            background:#8b5cf6;
            animation:orbitDot2 12s linear infinite;
            box-shadow:0 0 8px rgba(139,92,246,.3);
        }
        .orbit-dot.d3{
            background:#f59e0b;
            animation:orbitDot3 16s linear infinite reverse;
            box-shadow:0 0 8px rgba(245,158,11,.3);
        }
        @keyframes orbitDot1{0%{transform:rotate(0deg) translateX(96px) rotate(0deg)}100%{transform:rotate(360deg) translateX(96px) rotate(-360deg)}}
        @keyframes orbitDot2{0%{transform:rotate(120deg) translateX(110px) rotate(-120deg)}100%{transform:rotate(480deg) translateX(110px) rotate(-480deg)}}
        @keyframes orbitDot3{0%{transform:rotate(240deg) translateX(124px) rotate(-240deg)}100%{transform:rotate(600deg) translateX(124px) rotate(-600deg)}}

        /* Center icon */
        .center-icon{
            position:absolute;top:50%;left:50%;
            transform:translate(-50%,-50%);
            width:80px;height:80px;border-radius:22px;
            background:var(--accent);
            display:flex;align-items:center;justify-content:center;
            color:#fff;font-size:30px;
            box-shadow:0 8px 32px rgba(6,148,162,.25);
            animation:centerPulse 3s ease-in-out infinite;
            z-index:3;
        }
        @keyframes centerPulse{0%,100%{box-shadow:0 8px 32px rgba(6,148,162,.25)}50%{box-shadow:0 8px 48px rgba(6,148,162,.35)}}

        /* Glow behind center */
        .center-glow{
            position:absolute;top:50%;left:50%;
            transform:translate(-50%,-50%);
            width:120px;height:120px;border-radius:50%;
            background:var(--anim-accent);
            opacity:.06;filter:blur(20px);
            animation:glowPulse 3s ease-in-out infinite;
            z-index:1;
        }
        @keyframes glowPulse{0%,100%{opacity:.06;transform:translate(-50%,-50%) scale(1)}50%{opacity:.1;transform:translate(-50%,-50%) scale(1.15)}}

        /* Floating particles */
        .particles{position:absolute;inset:0;z-index:2;pointer-events:none}
        .particle{
            position:absolute;width:3px;height:3px;border-radius:50%;
            background:var(--anim-accent);opacity:0;
        }
        .particle.p1{top:15%;left:20%;animation:particleFloat 6s 0s ease-in-out infinite}
        .particle.p2{top:25%;right:15%;animation:particleFloat 7s 1s ease-in-out infinite}
        .particle.p3{bottom:20%;left:25%;animation:particleFloat 5s 2s ease-in-out infinite}
        .particle.p4{bottom:30%;right:20%;animation:particleFloat 8s .5s ease-in-out infinite}
        .particle.p5{top:50%;left:5%;animation:particleFloat 6.5s 1.5s ease-in-out infinite}
        .particle.p6{top:10%;right:35%;animation:particleFloat 7.5s 3s ease-in-out infinite}
        .particle.p7{bottom:10%;left:40%;animation:particleFloat 5.5s 2.5s ease-in-out infinite}
        .particle.p8{top:40%;right:5%;animation:particleFloat 6s 4s ease-in-out infinite}
        @keyframes particleFloat{
            0%,100%{opacity:0;transform:translateY(0) scale(.5)}
            20%{opacity:.5}
            50%{opacity:.7;transform:translateY(-20px) scale(1)}
            80%{opacity:.4}
        }

        /* Floating mini icons */
        .float-icon{
            position:absolute;font-size:11px;color:var(--anim-accent);
            opacity:.2;z-index:2;pointer-events:none;
        }
        .float-icon.fi1{top:12%;left:30%;animation:floatIcon 7s 0s ease-in-out infinite}
        .float-icon.fi2{top:18%;right:25%;animation:floatIcon 8s 1.5s ease-in-out infinite;color:#8b5cf6;opacity:.15}
        .float-icon.fi3{bottom:18%;left:35%;animation:floatIcon 6s 3s ease-in-out infinite;color:#f59e0b;opacity:.15}
        .float-icon.fi4{bottom:25%;right:30%;animation:floatIcon 9s 2s ease-in-out infinite}
        @keyframes floatIcon{0%,100%{transform:translateY(0) rotate(0deg);opacity:.2}25%{transform:translateY(-8px) rotate(5deg);opacity:.35}50%{transform:translateY(-12px) rotate(-3deg);opacity:.25}75%{transform:translateY(-5px) rotate(2deg);opacity:.3}}

        .school-name{font-size:22px;font-weight:800;letter-spacing:-.4px;color:var(--txt);margin-bottom:3px;transition:color .4s}
        .school-type{font-size:12px;color:var(--txt3);font-weight:500;letter-spacing:.05em;margin-bottom:22px;transition:color .4s}
        .side-h{font-size:clamp(17px,2vw,22px);font-weight:700;line-height:1.35;letter-spacing:-.3px;color:var(--txt);transition:color .4s}
        .side-h span{background:linear-gradient(135deg,var(--accent),#8b5cf6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}

        .side-bottom{position:relative;z-index:2}
        .side-features{display:flex;flex-direction:column;gap:10px}
        .feat{display:flex;align-items:center;gap:14px;padding:13px 16px;border-radius:10px;background:var(--feat-bg);border:1px solid var(--feat-bdr);box-shadow:var(--sh-sm);transition:all .25s}
        .feat:hover{box-shadow:var(--sh);transform:translateY(-1px)}
        .feat-ic{width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0}
        .feat-ic.i1{background:var(--clr1-bg);color:var(--clr1)}
        .feat-ic.i2{background:var(--clr2-bg);color:var(--clr2)}
        .feat-ic.i3{background:var(--clr3-bg);color:var(--clr3)}
        .feat-txt{font-size:12.5px;font-weight:500;color:var(--txt);transition:color .4s}
        .feat-txt small{display:block;font-size:10.5px;color:var(--txt3);font-weight:400;margin-top:1px;transition:color .4s}

        /* ═══ RIGHT ═══ */
        .form-panel{flex:0 0 480px;display:flex;flex-direction:column;justify-content:center;padding:48px;border-left:1px solid var(--border);background:var(--surface);position:relative;transition:background .4s,border-color .4s}
        .form-inner{width:100%;max-width:340px;margin:0 auto;position:relative;z-index:2}

        .top-bar{display:flex;align-items:center;justify-content:flex-end;gap:6px;margin-bottom:32px}
        .top-btn{width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;background:var(--surface2);border:1px solid var(--border);color:var(--txt3);font-size:13px;cursor:pointer;transition:all .2s}
        .top-btn:hover{background:var(--surface3);color:var(--txt2);border-color:var(--border-h)}
        .top-btn.active{background:var(--accent-bg);color:var(--accent);border-color:var(--accent-bdr)}

        .f-brand{display:none;margin-bottom:28px}
        .f-brand-mark{width:42px;height:42px;border-radius:12px;background:var(--accent);display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;margin-bottom:12px;box-shadow:0 4px 12px rgba(6,148,162,.25)}
        .f-brand-name{font-size:16px;font-weight:700;letter-spacing:-.2px}
        .f-brand-type{font-size:11px;color:var(--txt3);font-weight:500}

        .f-h{font-size:20px;font-weight:700;letter-spacing:-.3px;margin-bottom:4px;transition:color .4s}
        .f-sub{font-size:13px;color:var(--txt3);margin-bottom:28px;line-height:1.5;transition:color .4s}

        .f-err{display:none;padding:10px 14px;border-radius:10px;background:var(--err-bg);border:1px solid var(--err-bdr);color:var(--err);font-size:12.5px;font-weight:500;margin-bottom:20px;align-items:center;gap:8px;animation:shakeIn .4s ease}
        .f-err.show{display:flex}
        .f-err i{flex-shrink:0;font-size:13px}
        @keyframes shakeIn{0%{transform:translateX(-8px);opacity:0}25%{transform:translateX(6px)}50%{transform:translateX(-4px)}75%{transform:translateX(2px)}100%{transform:none;opacity:1}}

        .f-group{margin-bottom:18px}
        .f-label{display:block;font-size:12px;font-weight:600;color:var(--txt2);margin-bottom:6px;transition:color .4s}
        .f-wrap{position:relative}
        .f-icon-l{position:absolute;left:0;width:40px;display:flex;align-items:center;justify-content:center;font-size:13px;color:var(--txt4);pointer-events:none;transition:color .2s}
        .f-input{width:100%;padding:11px 14px 11px 40px;border:1.5px solid var(--border);border-radius:10px;font-size:13.5px;font-weight:500;color:var(--txt);background:var(--input-bg);font-family:inherit;transition:all .2s;outline:none}
        .f-input::placeholder{color:var(--txt4);font-weight:400}
        .f-input:hover{border-color:var(--border-h);background:var(--input-focus-bg)}
        .f-input:focus{border-color:var(--accent);background:var(--input-focus-bg);box-shadow:0 0 0 3px var(--accent-bg)}
        .f-input:focus~.f-icon-l{color:var(--accent)}
        .f-input.err{border-color:var(--err);box-shadow:0 0 0 3px var(--err-bg)}
        .f-input.err~.f-icon-l{color:var(--err)}

        .f-toggle{position:absolute;right:2px;width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:none;border:none;color:var(--txt4);cursor:pointer;transition:all .15s;font-size:13px}
        .f-toggle:hover{color:var(--txt2);background:var(--surface2)}

        .f-opts{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px}
        .f-chk{display:flex;align-items:center;gap:8px;cursor:pointer;-webkit-user-select:none;user-select:none}
        .f-chk input{display:none}
        .f-chk-box{width:16px;height:16px;border-radius:4px;border:1.5px solid var(--chk-bdr);display:flex;align-items:center;justify-content:center;transition:all .15s;flex-shrink:0;background:var(--surface2)}
        .f-chk-box svg{width:10px;height:10px;opacity:0;transform:scale(.5);transition:all .15s}
        .f-chk input:checked~.f-chk-box{background:var(--accent);border-color:var(--accent)}
        .f-chk input:checked~.f-chk-box svg{opacity:1;transform:scale(1)}
        .f-chk span{font-size:12.5px;color:var(--txt3);font-weight:400;transition:color .4s}

        .f-btn{width:100%;padding:12px 20px;border:none;border-radius:10px;background:var(--accent);color:#fff;font-size:14px;font-weight:600;font-family:inherit;cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 2px 8px rgba(6,148,162,.2);position:relative;overflow:hidden}
        .f-btn::after{content:'';position:absolute;inset:0;background:linear-gradient(90deg,transparent,rgba(255,255,255,.1),transparent);transform:translateX(-100%);transition:none}
        .f-btn:hover::after{transform:translateX(100%);transition:transform .6s}
        .f-btn:hover{background:var(--accent-h);transform:translateY(-.5px);box-shadow:0 4px 16px rgba(6,148,162,.25)}
        .f-btn:active{transform:translateY(0)}
        .f-btn:disabled{opacity:.5;cursor:not-allowed;transform:none!important}
        .f-btn .spin{width:16px;height:16px;border:2px solid rgba(255,255,255,.25);border-top-color:#fff;border-radius:50%;animation:spin .5s linear infinite;display:none}
        .f-btn.loading .spin{display:block}
        .f-btn.loading .f-btn-t{opacity:0;width:0;overflow:hidden}
        @keyframes spin{to{transform:rotate(360deg)}}

        .f-foot{text-align:center;margin-top:28px;padding-top:24px;border-top:1px solid var(--border);transition:border-color .4s}
        .f-foot p{font-size:12px;color:var(--txt3);line-height:1.6;transition:color .4s}
        .f-foot strong{color:var(--txt2);font-weight:500}
        .f-copy{position:absolute;bottom:16px;left:0;right:0;text-align:center;font-size:10.5px;color:var(--txt4);transition:color .4s}

        /* ═══ LOGIN OVERLAY ═══ */
        .login-overlay{position:fixed;inset:0;z-index:999;display:flex;flex-direction:column;align-items:center;justify-content:center;background:var(--overlay-bg);opacity:0;pointer-events:none;transition:opacity .4s;backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px)}
        .login-overlay.active{opacity:1;pointer-events:auto}
        .lo-loader{width:48px;height:48px;border-radius:14px;background:var(--accent);display:flex;align-items:center;justify-content:center;color:#fff;font-size:20px;animation:loPulse 1.2s ease-in-out infinite;box-shadow:0 8px 32px rgba(6,148,162,.3)}
        @keyframes loPulse{0%,100%{transform:scale(1);box-shadow:0 8px 32px rgba(6,148,162,.3)}50%{transform:scale(1.08);box-shadow:0 12px 40px rgba(6,148,162,.4)}}
        .lo-text{margin-top:20px;font-size:14px;font-weight:600;color:var(--txt);letter-spacing:-.2px;animation:loFade .6s .2s ease forwards;opacity:0}
        @keyframes loFade{to{opacity:1}}
        .lo-dots{display:flex;gap:6px;margin-top:12px;animation:loFade .6s .35s ease forwards;opacity:0}
        .lo-dot{width:6px;height:6px;border-radius:50%;background:var(--accent);opacity:.3;animation:loDotBounce 1.4s ease-in-out infinite}
        .lo-dot:nth-child(2){animation-delay:.15s}
        .lo-dot:nth-child(3){animation-delay:.3s}
        @keyframes loDotBounce{0%,80%,100%{opacity:.3;transform:scale(1)}40%{opacity:1;transform:scale(1.3)}}

        @media(max-width:960px){.side{display:none}.form-panel{flex:1;border-left:none;min-height:100vh}.f-brand{display:block}}
        @media(max-width:480px){.form-panel{padding:32px 20px}.form-inner{max-width:100%}}
        .anim{opacity:0;transform:translateY(10px);animation:fadeUp .5s ease forwards}
        @keyframes fadeUp{to{opacity:1;transform:none}}
        .d1{animation-delay:.05s}.d2{animation-delay:.1s}.d3{animation-delay:.15s}.d4{animation-delay:.2s}.d5{animation-delay:.25s}.d6{animation-delay:.3s}.d7{animation-delay:.35s}.d8{animation-delay:.4s}
    </style>
</head>
<body>
<div class="layout">

    <div class="side">
        <div class="grid-bg"></div>
        <div class="side-top anim d1">
            <div class="logo">
                <div class="logo-mark"><i class="fas fa-school"></i></div>
                <div class="logo-text">Travina Prima</div>
            </div>
        </div>

        <div class="side-center">
            <div class="side-label anim d2" data-i18n="sys_label">Sistem Informasi Sekolah</div>

            <!-- ═══ ANIMATED SCENE ═══ -->
            <div class="anim-scene anim d3">
                <div class="orbit-ring"></div>
                <div class="orbit-ring r2"></div>
                <div class="orbit-ring r3"></div>

                <div class="orbit-dot d1"></div>
                <div class="orbit-dot d2"></div>
                <div class="orbit-dot d3"></div>

                <div class="center-glow"></div>
                <div class="center-icon"><i class="fas fa-school"></i></div>

                <div class="particles">
                    <div class="particle p1"></div>
                    <div class="particle p2"></div>
                    <div class="particle p3"></div>
                    <div class="particle p4"></div>
                    <div class="particle p5"></div>
                    <div class="particle p6"></div>
                    <div class="particle p7"></div>
                    <div class="particle p8"></div>
                </div>

                <i class="fas fa-graduation-cap float-icon fi1"></i>
                <i class="fas fa-book float-icon fi2"></i>
                <i class="fas fa-pencil float-icon fi3"></i>
                <i class="fas fa-calculator float-icon fi4"></i>
            </div>

            <div class="school-name anim d4">SMK Travina Prima</div>
            <div class="school-type anim d4">Sekolah Menengah Kejuruan</div>

            <h1 class="side-h anim d5"><span data-i18n="side_h">Satu sistem untuk semua kebutuhan sekolah.</span></h1>
        </div>

        <div class="side-bottom">
            <div class="side-features">
                <div class="feat anim d6">
                    <div class="feat-ic i1"><i class="fas fa-wallet"></i></div>
                    <div class="feat-txt" data-i18n="feat1_t">Pembayaran SPP Digital<small data-i18n="feat1_d">Bayar kapan saja, langsung tercatat otomatis</small></div>
                </div>
                <div class="feat anim d7">
                    <div class="feat-ic i2"><i class="fas fa-users-gear"></i></div>
                    <div class="feat-txt" data-i18n="feat2_t">Multi-Akses Pengguna<small data-i18n="feat2_d">Kepsek, guru, TU, siswa — masing-masing punya hak akses</small></div>
                </div>
                <div class="feat anim d8">
                    <div class="feat-ic i3"><i class="fas fa-chart-column"></i></div>
                    <div class="feat-txt" data-i18n="feat3_t">Rekap Instan<small data-i18n="feat3_d">Nilai, absensi, dan keuangan tersedia tanpa delay</small></div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-panel">
        <div class="form-inner">

            <div class="f-brand anim d1">
                <div class="f-brand-mark"><i class="fas fa-school"></i></div>
                <div class="f-brand-name">Travina Prima</div>
                <div class="f-brand-type">SMK</div>
            </div>

            <div class="top-bar anim d2">
            </div>

            <h2 class="f-h anim d3" data-i18n="form_h">Masuk ke akun Anda</h2>
            <p class="f-sub anim d4" data-i18n="form_sub">Gunakan kredensial yang telah diberikan admin</p>

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <div class="f-err" id="errBox">
                    <i class="fas fa-circle-exclamation"></i>
                    <span id="errText"></span>
                </div>

                <div class="f-group anim d5">
                    <label class="f-label" for="email" data-i18n="lbl_email">Email</label>
                    <div class="f-wrap">
                        <input type="email" id="email" name="email"
                            class="f-input {{ $errors->has('email') ? 'err' : '' }}"
                            value="{{ old('email') }}"
                            placeholder="nama@sekolah.id"
                            required autocomplete="email" autofocus>
                        <i class="fas fa-at f-icon-l"></i>
                    </div>
                </div>

                <div class="f-group anim d6">
                    <label class="f-label" for="password" data-i18n="lbl_pw">Kata Sandi</label>
                    <div class="f-wrap">
                        <input type="password" id="password" name="password"
                            class="f-input {{ $errors->has('password') ? 'err' : '' }}"
                            placeholder="••••••••"
                            required autocomplete="current-password">
                        <i class="fas fa-lock f-icon-l"></i>
                        <button type="button" class="f-toggle" id="togglePw" aria-label="Toggle password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="f-opts anim d7">
                    <label class="f-chk">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <div class="f-chk-box">
                            <svg viewBox="0 0 12 12" fill="none"><path d="M2 6l3 3 5-5" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <span data-i18n="remember">Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="f-btn anim d8" id="btnSubmit">
                    <span class="f-btn-t" data-i18n="btn_login">Masuk</span>
                    <span class="spin"></span>
                </button>
            </form>

            <div class="f-foot anim d8">
                <p data-i18n="footer">Belum punya akun? <strong>Hubungi administrator.</strong></p>
            </div>
        </div>
        <div class="f-copy">&copy; {{ date('Y') }} SMK Travina Prima</div>
    </div>
</div>

<div class="login-overlay" id="loginOverlay">
    <div class="lo-loader"><i class="fas fa-school"></i></div>
    <div class="lo-text" data-i18n="loading_text">Memproses login...</div>
    <div class="lo-dots"><div class="lo-dot"></div><div class="lo-dot"></div><div class="lo-dot"></div></div>
</div>

<script>
(function(){
    var T={
        id:{sys_label:'Sistem Informasi Sekolah',side_h:'Satu sistem untuk semua kebutuhan sekolah.',form_h:'Masuk ke akun Anda',form_sub:'Gunakan kredensial yang telah diberikan admin',lbl_email:'Email',lbl_pw:'Kata Sandi',remember:'Ingat saya',btn_login:'Masuk',footer:'Belum punya akun? <strong>Hubungi administrator.</strong>',loading_text:'Memproses login...',err_empty:'Email dan kata sandi wajib diisi.',err_creds:'Email atau kata sandi salah.',err_throttle:'Terlalu banyak percobaan. Coba lagi dalam :seconds detik.',feat1_t:'Pembayaran SPP Digital',feat1_d:'Bayar kapan saja, langsung tercatat otomatis',feat2_t:'Multi-Akses Pengguna',feat2_d:'Kepsek, guru, TU, siswa — masing-masing punya hak akses',feat3_t:'Rekap Instan',feat3_d:'Nilai, absensi, dan keuangan tersedia tanpa delay'},
        en:{sys_label:'School Information System',side_h:'One system for all your school needs.',form_h:'Sign in to your account',form_sub:'Use the credentials provided by the administrator',lbl_email:'Email',lbl_pw:'Password',remember:'Remember me',btn_login:'Sign In',footer:'Don\'t have an account? <strong>Contact administrator.</strong>',loading_text:'Signing in...',err_empty:'Email and password are required.',err_creds:'These credentials do not match our records.',err_throttle:'Too many login attempts. Try again in :seconds seconds.',feat1_t:'Digital SPP Payments',feat1_d:'Pay anytime, recorded automatically',feat2_t:'Multi-User Access',feat2_d:'Principal, teachers, admin, students — each has their own access',feat3_t:'Instant Reports',feat3_d:'Grades, attendance, and finance available without delay'}
    };

    var lang='id',currentMsg='';

    var pw=document.getElementById('password'),tog=document.getElementById('togglePw');
    if(tog&&pw)tog.addEventListener('click',function(){var s=pw.type==='password';pw.type=s?'text':'password';this.innerHTML=s?'<i class="fas fa-eye-slash"></i>':'<i class="fas fa-eye"></i>'});

    var errBox=document.getElementById('errBox'),errText=document.getElementById('errText');
    function showError(msg){currentMsg=msg;if(!msg){errBox.classList.remove('show');return}if(msg.indexOf('credentials')!==-1||msg.indexOf('kata sandi salah')!==-1)msg=T[lang].err_creds;if(msg.indexOf('many')!==-1||msg.indexOf('banyak')!==-1){msg=T[lang].err_throttle;var m=msg.match(/(\d+)/);if(m)msg=msg.replace(':seconds',m[1])}errText.textContent=msg;errBox.classList.add('show')}

    var srvMsg=[];
    @if($errors->any())srvMsg.push('{{ addslashes($errors->first()) }}');@endif
    @if(session('error'))srvMsg.push('{{ addslashes(session("error")) }}');@endif
    if(srvMsg.length)showError(srvMsg[0]);

    document.querySelectorAll('.f-input').forEach(function(i){i.addEventListener('input',function(){this.classList.remove('err');errBox.classList.remove('show');currentMsg=''})});

    var overlay=document.getElementById('loginOverlay'),form=document.getElementById('loginForm'),btn=document.getElementById('btnSubmit');
    if(form&&btn)form.addEventListener('submit',function(e){
        var em=document.getElementById('email').value.trim(),ps=document.getElementById('password').value.trim();
        if(!em||!ps){e.preventDefault();showError(T[lang].err_empty);return}
        e.preventDefault();btn.classList.add('loading');btn.disabled=true;
        setTimeout(function(){overlay.classList.add('active')},300);
        setTimeout(function(){form.submit()},1200);
    });
})();
</script>
</body>
</html>