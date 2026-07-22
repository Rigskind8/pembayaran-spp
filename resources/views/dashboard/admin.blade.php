@extends('layouts.app')

@section('title', 'Dashboard Admin - Travina Prima')

@section('content')

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --sw: 62px; --sw-open: 230px;
    --sb: var(--sw);
    --sb-open: var(--sw-open);
    --bg: #f4f7fc; --card: #ffffff; --border: #e2e8f3; --border2: #c8d2e3;
    --txt: #0f172a; --txt2: #566176; --txt3: #8b97ad;
    --blue: #1d4ed8; --blue-lt: #edf3ff; --blue-md: #bfd2fb;
    --green: #0c8a5a; --green-lt: #eaf9f2; --green-md: #9de2c5;
    --red: #d32f2f; --red-lt: #fff1f1; --red-md: #ffc8c8;
    --amber: #b86f08; --amber-lt: #fff8ec; --amber-md: #f8d79f;
    --purple: #4f46e5; --purple-lt: #eef0ff; --purple-md: #c7ccff;
    --cyan: #0c7ea0; --cyan-lt: #ebf9ff; --cyan-md: #a9e8fb;
    --sb-bg: #0d1117; --sb-border: #1e2330;
    --r: 16px; --r-lg: 22px;
    --sh: 0 2px 8px rgba(15,23,42,.05), 0 8px 24px rgba(15,23,42,.04);
    --sh-md: 0 10px 28px rgba(15,23,42,.10);
    --sh-lg: 0 16px 46px rgba(15,23,42,.14);
    --bg-hover: #f3f7ff; --bg-head: #f8fbff; --bg-input: #eef3fb;
    --bg-muted: #f6f8fe; --border-light: #f1f3f9;
}

/* ═══ DARK THEME ═══ */
[data-theme="dark"] {
    --bg: #0b0b10; --card: #13131c; --border: rgba(255,255,255,.07); --border2: rgba(255,255,255,.13);
    --txt: #e8e8ec; --txt2: #9698ac; --txt3: #55566a;
    --blue: #5b8af5; --blue-lt: rgba(91,138,245,.08); --blue-md: rgba(91,138,245,.18);
    --green: #34d399; --green-lt: rgba(52,211,153,.08); --green-md: rgba(52,211,153,.18);
    --red: #f87171; --red-lt: rgba(248,113,113,.08); --red-md: rgba(248,113,113,.18);
    --amber: #fbbf24; --amber-lt: rgba(251,191,36,.08); --amber-md: rgba(251,191,36,.18);
    --purple: #a78bfa; --purple-lt: rgba(167,139,250,.08); --purple-md: rgba(167,139,250,.18);
    --cyan: #22d3ee; --cyan-lt: rgba(34,211,238,.08); --cyan-md: rgba(34,211,238,.18);
    --sb-bg: #07070b; --sb-border: rgba(255,255,255,.04);
    --sh: 0 1px 3px rgba(0,0,0,.2); --sh-md: 0 4px 20px rgba(0,0,0,.3); --sh-lg: 0 12px 40px rgba(0,0,0,.4);
    --bg-hover: rgba(255,255,255,.03); --bg-head: rgba(255,255,255,.03);
    --bg-input: rgba(255,255,255,.06); --bg-muted: rgba(255,255,255,.04);
    --border-light: rgba(255,255,255,.06);
}

body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--txt); -webkit-font-smoothing: antialiased; transition: background .3s, color .3s; }
.app { display: flex; min-height: 100vh; }
.main { margin-left: var(--sb); flex: 1; display: flex; flex-direction: column; min-width: 0; width: calc(100% - var(--sb)); }

/* ══ TOPBAR ══ */
.topbar { display: flex; align-items: center; justify-content: space-between; padding: 13px 26px; background: color-mix(in srgb, var(--bg) 84%, #ffffff 16%); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; gap: 12px; transition: background .3s, border-color .3s; backdrop-filter: blur(8px); }
.top-ttl { font-family: 'Syne', sans-serif; font-size: 17px; font-weight: 800; color: var(--txt); letter-spacing: -.3px; }
.top-sub { font-size: 11.5px; color: var(--txt2); margin-top: 2px; }
.top-r { display: flex; align-items: center; gap: 7px; flex-wrap: wrap; }
.top-btn { width: 36px; height: 36px; border-radius: 9px; display: flex; align-items: center; justify-content: center; background: var(--card); border: 1px solid var(--border); color: var(--txt2); font-size: 13px; cursor: pointer; transition: all .15s; flex-shrink: 0; }
.top-btn:hover { background: var(--bg-head); color: var(--txt); border-color: var(--border2); }
.chip { display: inline-flex; align-items: center; gap: 5px; padding: 5px 11px; border-radius: 99px; border: 1px solid var(--border); background: var(--card); font-size: 11px; font-weight: 600; color: var(--txt2); white-space: nowrap; transition: background .3s, border-color .3s, color .3s; }
.chip.warn { background: var(--red-lt); border-color: var(--red-md); color: var(--red); }
.search-wrap { position: relative; }
.search-inp { padding: 7px 12px 7px 32px; border: 1px solid var(--border); border-radius: 9px; background: var(--card); font-size: 12px; font-family: inherit; color: var(--txt); outline: none; width: 190px; transition: all .15s; }
.search-inp:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(36,99,235,.1); width: 230px; }
.search-ic { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--txt3); font-size: 11px; pointer-events: none; }

/* ══ BODY ══ */
.body { padding: 20px 26px; flex: 1; }

/* ══ ALERT BAR ══ */
.alert-bar { background: #7f1d1d; border-radius: var(--r); padding: 12px 18px; margin-bottom: 16px; display: flex; align-items: center; gap: 12px; box-shadow: 0 4px 16px rgba(180,30,30,.22); }
.alert-ic { width: 36px; height: 36px; border-radius: 9px; background: rgba(255,255,255,.14); display: flex; align-items: center; justify-content: center; font-size: 15px; color: white; flex-shrink: 0; }
.alert-bar h4 { font-size: 13px; font-weight: 700; color: white; }
.alert-bar p { font-size: 11px; color: rgba(255,255,255,.65); margin-top: 1px; }
.alert-btn { margin-left: auto; padding: 7px 14px; background: white; color: var(--red); border-radius: 8px; font-size: 11px; font-weight: 800; text-decoration: none; white-space: nowrap; flex-shrink: 0; transition: all .13s; border: none; cursor: pointer; font-family: inherit; }
.alert-btn:hover { box-shadow: 0 3px 10px rgba(0,0,0,.18); }

/* ══ BANNER ══ */
.banner { background: linear-gradient(120deg, #0f2c6b 0%, #1d4ed8 50%, #0f766e 100%); border-radius: var(--r-lg); padding: 22px 26px; margin-bottom: 16px; position: relative; overflow: hidden; box-shadow: 0 10px 28px rgba(29,78,216,.26); display: flex; align-items: center; justify-content: space-between; gap: 20px; border: 1px solid rgba(255,255,255,.10); }
.banner::before { content: ''; position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; border-radius: 50%; background: rgba(255,255,255,.04); pointer-events: none; }
.banner::after  { content: ''; position: absolute; bottom: -30px; left: 200px; width: 120px; height: 120px; border-radius: 50%; background: rgba(255,255,255,.03); pointer-events: none; }
.bn-left { position: relative; z-index: 1; }
.bn-title { font-family: 'Syne', sans-serif; font-size: 19px; font-weight: 800; color: white; letter-spacing: -.3px; line-height: 1.3; margin-bottom: 3px; }
.bn-sub { font-size: 12px; color: rgba(255,255,255,.55); }
.bn-right { display: flex; gap: 8px; flex-shrink: 0; position: relative; z-index: 1; }
.btn-wh { display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; background: white; color: var(--blue); border-radius: 10px; font-size: 12px; font-weight: 700; text-decoration: none; box-shadow: 0 6px 18px rgba(0,0,0,.16); transition: all .14s; white-space: nowrap; border: none; cursor: pointer; font-family: inherit; }
.btn-wh:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(0,0,0,.18); }
.btn-ghost-w { display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; background: rgba(255,255,255,.11); color: white; border: 1px solid rgba(255,255,255,.22); border-radius: 9px; font-size: 12px; font-weight: 700; text-decoration: none; transition: all .14s; white-space: nowrap; }
.btn-ghost-w:hover { background: rgba(255,255,255,.18); color: white; }

/* ══ STAT CARDS ══ */
.stats5 { display: grid; grid-template-columns: repeat(5,1fr); gap: 12px; margin-bottom: 18px; }
.sc { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); padding: 16px 18px; box-shadow: var(--sh); position: relative; overflow: hidden; transition: transform .18s, box-shadow .18s, background .3s, border-color .3s; }
.sc:hover { transform: translateY(-3px); box-shadow: var(--sh-md); border-color: var(--border2); }
.sc::after { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; border-radius: var(--r) var(--r) 0 0; }
.sc.b::after { background: linear-gradient(90deg, var(--blue), #60a5fa); }
.sc.g::after { background: linear-gradient(90deg, var(--green), #34d399); }
.sc.a::after { background: linear-gradient(90deg, var(--amber), #fbbf24); }
.sc.r::after { background: linear-gradient(90deg, var(--red), #fb7185); }
.sc.p::after { background: linear-gradient(90deg, var(--purple), #a78bfa); }
.sc-ic { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 14px; margin-bottom: 10px; }
.sc-lbl { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: var(--txt2); margin-bottom: 3px; }
.sc-val { font-family: 'Syne', sans-serif; font-size: 24px; font-weight: 800; line-height: 1; letter-spacing: -1px; }
.sc-note { font-size: 10px; color: var(--txt3); margin-top: 5px; }
.sc-badge { display: inline-flex; align-items: center; gap: 3px; font-size: 9px; font-weight: 700; padding: 2px 6px; border-radius: 5px; margin-top: 6px; }
.sc-badge.up   { background: var(--green-lt); color: var(--green); }
.sc-badge.warn { background: var(--red-lt);   color: var(--red);   }
.sc-badge.neu  { background: var(--bg-muted);  color: var(--txt2); }

/* ══ GRID ══ */
.content-grid { display: grid; grid-template-columns: 1fr 300px; gap: 14px; margin-bottom: 14px; }
.full-width { margin-bottom: 14px; }

/* ══ CARD ══ */
.card { background: var(--card); border: 1px solid var(--border); border-radius: var(--r); overflow: hidden; box-shadow: var(--sh); transition: background .3s, border-color .3s, box-shadow .3s; }
.card:hover { box-shadow: var(--sh-md); }
.card-head { display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; border-bottom: 1px solid var(--border); background: linear-gradient(180deg, color-mix(in srgb, var(--bg-head) 92%, #ffffff 8%), var(--bg-head)); gap: 10px; flex-wrap: wrap; transition: background .3s, border-color .3s; }
.card-ttl { font-family: 'Syne', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--txt); }
.card-sub { font-size: 11px; color: var(--txt2); margin-top: 1px; }
.btn-blue { display: inline-flex; align-items: center; gap: 5px; padding: 7px 14px; background: var(--blue); color: white; border-radius: 8px; font-size: 11px; font-weight: 700; text-decoration: none; box-shadow: 0 2px 8px rgba(36,99,235,.22); transition: all .13s; white-space: nowrap; border: none; cursor: pointer; font-family: inherit; }
.btn-blue:hover { background: #1a55d8; color: white; transform: translateY(-1px); }

/* ══ TABLE ══ */
.dt { width: 100%; border-collapse: collapse; }
.dt thead tr { background: var(--bg-head); border-bottom: 1px solid var(--border); transition: background .3s; }
.dt th { padding: 10px 16px; font-size: 8.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .15em; color: var(--txt2); }
.dt th:first-child { padding-left: 20px; }
.dt th:last-child  { padding-right: 20px; text-align: center; }
.dt th.r { text-align: right; }
.dt tbody tr { border-bottom: 1px solid var(--border-light); transition: background .1s; }
.dt tbody tr:last-child { border-bottom: none; }
.dt tbody tr:hover { background: var(--bg-hover); }
.dt td { padding: 11px 16px; font-size: 12.5px; color: var(--txt); vertical-align: middle; }
.dt td:first-child { padding-left: 20px; }
.dt td:last-child  { padding-right: 20px; text-align: center; }
.stu-cell { display: flex; align-items: center; gap: 9px; }
.stu-av   { width: 32px; height: 32px; border-radius: 8px; background: var(--blue); color: white; font-size: 11.5px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.stu-name { font-weight: 700; font-size: 12.5px; }
.stu-meta { font-size: 10px; color: var(--txt2); margin-top: 1px; }
.amt { font-weight: 800; font-size: 12.5px; text-align: right; font-family: 'DM Mono', monospace; }

/* ══ BADGES ══ */
.bdg { display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px; border-radius: 6px; font-size: 9px; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; }
.bdg.paid, .bdg.approved { background: var(--green-lt); color: var(--green); border: 1px solid var(--green-md); }
.bdg.unpaid   { background: var(--amber-lt); color: var(--amber); border: 1px solid var(--amber-md); }
.bdg.pending  { background: var(--blue-lt);  color: var(--blue);  border: 1px solid var(--blue-md);  }
.bdg.rejected { background: var(--red-lt);   color: var(--red);   border: 1px solid var(--red-md);   }

/* ══ ROW ACTIONS ══ */
.acts { display: flex; gap: 4px; justify-content: center; }
.act { display: inline-flex; align-items: center; gap: 3px; padding: 4px 9px; border-radius: 6px; font-size: 10px; font-weight: 700; border: 1px solid var(--border); background: var(--card); cursor: pointer; font-family: inherit; transition: all .11s; }
.act.v { color: var(--blue); }
.act.v:hover { background: var(--blue); color: white; border-color: var(--blue); }
.act.e { color: var(--amber); }
.act.e:hover { background: var(--amber); color: white; border-color: var(--amber); }
.act.d { color: var(--red); }
.act.d:hover { background: var(--red); color: white; border-color: var(--red); }

/* ══ FILTER TABS ══ */
.ftabs { display: flex; gap: 4px; padding: 11px 16px; border-bottom: 1px solid var(--border); overflow-x: auto; transition: border-color .3s; }
.ftabs::-webkit-scrollbar { display: none; }
.ftab { padding: 4px 12px; border-radius: 7px; font-size: 11px; font-weight: 600; color: var(--txt2); cursor: pointer; border: none; background: transparent; font-family: inherit; transition: all .11s; white-space: nowrap; }
.ftab.on { background: var(--blue); color: white; }
.ftab:hover:not(.on) { background: var(--bg-muted); color: var(--txt); }

/* ══ SIDE PANEL ══ */
.side-stack { display: flex; flex-direction: column; gap: 14px; }
.prog-body { padding: 15px 18px; }
.prog-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; }
.prog-lbl { font-size: 11px; font-weight: 600; color: var(--txt2); }
.prog-val { font-size: 11px; font-weight: 800; color: var(--txt); }
.prog-bar { height: 6px; background: var(--bg-input); border-radius: 99px; overflow: hidden; margin-bottom: 13px; transition: background .3s; }
.prog-fill { height: 100%; border-radius: 99px; transition: width 1.1s ease; }
.prog-fill.g { background: linear-gradient(90deg, var(--green), #34d399); }
.prog-fill.b { background: linear-gradient(90deg, var(--blue), #60a5fa); }
.prog-fill.a { background: linear-gradient(90deg, var(--amber), #fbbf24); }
.prog-summary { display: grid; grid-template-columns: repeat(3,1fr); gap: 8px; margin-top: 4px; }
.prog-sum-item { background: var(--bg-muted); border-radius: 9px; padding: 9px; text-align: center; border: 1px solid var(--border); transition: background .3s, border-color .3s; }
.prog-sum-val { font-family: 'Syne', sans-serif; font-size: 17px; font-weight: 800; line-height: 1; }
.prog-sum-lbl { font-size: 9.5px; color: var(--txt2); margin-top: 2px; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; }

/* ══ QUICK ACTIONS ══ */
.qa-list { padding: 10px 12px; display: flex; flex-direction: column; gap: 6px; }
.qa-item { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; border: 1px solid var(--border); text-decoration: none; transition: all .13s; background: var(--card); }
.qa-item:hover { border-color: var(--blue); background: var(--blue-lt); transform: translateX(3px); box-shadow: 0 8px 18px rgba(29,78,216,.08); }
.qa-ic  { width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0; }
.qa-ttl { font-size: 12.5px; font-weight: 700; color: var(--txt); }
.qa-dsc { font-size: 10px; color: var(--txt2); }
.qa-arr { margin-left: auto; color: var(--txt3); font-size: 10px; transition: all .13s; }
.qa-item:hover .qa-arr { color: var(--blue); transform: translateX(2px); }

/* ══ VERIF PANEL ══ */
.verif-item { display: flex; align-items: center; gap: 12px; padding: 13px 20px; border-bottom: 1px solid var(--border-light); transition: background .11s; }
.verif-item:last-child { border-bottom: none; }
.verif-item:hover { background: var(--bg-hover); }
.verif-av { width: 36px; height: 36px; border-radius: 9px; background: linear-gradient(135deg, var(--blue), var(--purple)); color: white; font-size: 13px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.verif-thumb { width: 36px; height: 36px; border-radius: 7px; background: var(--bg-input); border: 1px solid var(--border); overflow: hidden; flex-shrink: 0; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all .13s; }
.verif-thumb img { width: 100%; height: 100%; object-fit: cover; }
.verif-thumb:hover { transform: scale(1.1); box-shadow: var(--sh-md); }
.verif-info { flex: 1; min-width: 0; }
.verif-name { font-size: 12.5px; font-weight: 700; color: var(--txt); }
.verif-meta { font-size: 10.5px; color: var(--txt2); margin-top: 2px; }
.verif-amt  { font-size: 12.5px; font-weight: 800; color: var(--txt); white-space: nowrap; font-family: 'DM Mono', monospace; }
.verif-btns { display: flex; gap: 5px; flex-shrink: 0; }
.vbtn { display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; border-radius: 7px; font-size: 10px; font-weight: 700; border: none; cursor: pointer; font-family: inherit; transition: all .13s; white-space: nowrap; }
.vbtn.ok  { background: var(--green-lt); color: var(--green); }
.vbtn.ok:hover  { background: var(--green); color: white; }
.vbtn.no  { background: var(--red-lt); color: var(--red); }
.vbtn.no:hover  { background: var(--red); color: white; }
.vbtn.see { background: var(--blue-lt); color: var(--blue); }
.vbtn.see:hover { background: var(--blue); color: white; }

/* ══ REKAP KELAS ══ */
.klass-row { display: flex; align-items: center; gap: 10px; padding: 10px 20px; border-bottom: 1px solid var(--border-light); transition: background .11s; }
.klass-row:last-child { border-bottom: none; }
.klass-row:hover { background: var(--bg-hover); }
.klass-name { width: 64px; font-size: 12.5px; font-weight: 700; color: var(--txt); flex-shrink: 0; }
.klass-bar-wrap { flex: 1; height: 7px; background: var(--bg-input); border-radius: 99px; overflow: hidden; transition: background .3s; }
.klass-bar-fill { height: 100%; border-radius: 99px; transition: width 1s ease; }
.klass-pct   { width: 38px; text-align: right; font-size: 11px; font-weight: 800; color: var(--txt2); font-family: 'DM Mono', monospace; }
.klass-count { width: 52px; text-align: right; font-size: 11px; color: var(--txt3); font-family: 'DM Mono', monospace; }

/* ══ ACTIVITY FEED ══ */
.feed-list { padding: 8px 6px; }
.feed-item { display: flex; align-items: flex-start; gap: 10px; padding: 10px 12px; border-radius: 9px; transition: background .11s; }
.feed-item:hover { background: var(--bg-hover); }
.feed-dot { width: 30px; height: 30px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 11px; flex-shrink: 0; margin-top: 1px; }
.feed-txt  { font-size: 12px; color: var(--txt); line-height: 1.45; }
.feed-txt strong { font-weight: 700; }
.feed-time { font-size: 10px; color: var(--txt3); margin-top: 2px; }

/* ══ MODALS ══ */
.overlay { position: fixed; inset: 0; background: rgba(0,0,0,.55); z-index: 1000; display: none; align-items: center; justify-content: center; }
.overlay.open { display: flex; }
.modal { background: var(--card); border-radius: 16px; width: 420px; max-width: 95vw; box-shadow: var(--sh-lg); animation: mIn .2s ease; transition: background .3s; }
@keyframes mIn { from { opacity:0; transform:scale(.96) translateY(6px); } to { opacity:1; transform:none; } }
.m-head { padding: 18px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; transition: border-color .3s; }
.m-head h3 { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 800; color: var(--txt); }
.m-close { width: 28px; height: 28px; border-radius: 7px; background: var(--bg-muted); border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 12px; color: var(--txt2); transition: all .11s; }
.m-close:hover { background: var(--red-lt); color: var(--red); }
.m-body { padding: 16px 20px; }
.m-foot { padding: 14px 20px; border-top: 1px solid var(--border); display: flex; gap: 7px; justify-content: flex-end; transition: border-color .3s; }
.fg { margin-bottom: 12px; }
.fl { font-size: 11px; font-weight: 700; color: var(--txt); margin-bottom: 4px; display: block; }
.fc { width: 100%; padding: 8px 11px; border: 1px solid var(--border); border-radius: 8px; font-size: 12.5px; font-family: inherit; color: var(--txt); outline: none; background: var(--card); transition: border-color .11s, background .3s, color .3s; }
.fc:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(36,99,235,.1); }
.btn-cancel    { display: inline-flex; align-items: center; gap: 5px; padding: 8px 15px; background: var(--card); color: var(--txt); border: 1px solid var(--border); border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer; font-family: inherit; transition: all .11s; }
.btn-cancel:hover { background: var(--bg-head); }
.btn-approve   { display: inline-flex; align-items: center; gap: 5px; padding: 8px 15px; background: var(--green); color: white; border: none; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer; font-family: inherit; box-shadow: 0 3px 10px rgba(10,144,96,.25); transition: all .11s; }
.btn-approve:hover { background: #087850; }
.btn-reject-btn { display: inline-flex; align-items: center; gap: 5px; padding: 8px 15px; background: var(--red); color: white; border: none; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer; font-family: inherit; box-shadow: 0 3px 10px rgba(212,43,43,.25); transition: all .11s; }
.btn-reject-btn:hover { background: #b82020; }

/* ══ LIGHTBOX ══ */
.lightbox { position: fixed; inset: 0; background: rgba(0,0,0,.88); z-index: 9999; display: none; align-items: center; justify-content: center; }
.lightbox.open { display: flex; }
.lightbox img { max-width: 90vw; max-height: 86vh; border-radius: 10px; box-shadow: 0 20px 60px rgba(0,0,0,.5); }
.lb-close { position: absolute; top: 18px; right: 18px; width: 38px; height: 38px; background: white; border-radius: 50%; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px; color: var(--txt); }

/* ══ TOAST ══ */
.toasts { position: fixed; bottom: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 7px; }
.toast { display: flex; align-items: center; gap: 10px; padding: 12px 16px; background: var(--card); border-radius: 12px; box-shadow: var(--sh-lg); border: 1px solid var(--border); min-width: 250px; animation: tIn .25s ease; transition: background .3s, border-color .3s; }
@keyframes tIn { from { opacity:0; transform:translateX(30px); } to { opacity:1; transform:none; } }
.toast.hide { opacity: 0; transform: translateX(30px); transition: all .25s; }
.t-ic { width: 30px; height: 30px; border-radius: 8px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 13px; }
.t-ic.s { background: var(--green-lt); color: var(--green); }
.t-ic.e { background: var(--red-lt);   color: var(--red);   }
.t-ttl { font-size: 12.5px; font-weight: 700; color: var(--txt); }
.t-msg { font-size: 10.5px; color: var(--txt2); }

/* ══ EMPTY ══ */
.empty { padding: 36px 20px; text-align: center; }
.empty-ic { width: 46px; height: 46px; border-radius: 12px; background: var(--bg-input); display: flex; align-items: center; justify-content: center; font-size: 18px; color: var(--txt3); margin: 0 auto 9px; transition: background .3s; }
.empty p    { font-size: 13px; font-weight: 600; color: var(--txt2); }
.empty span { font-size: 11px; color: var(--txt3); display: block; margin-top: 2px; }

/* ══ RESPONSIVE ══ */
@media (max-width:1200px) { .stats5 { grid-template-columns: repeat(3,1fr); } }
@media (max-width:1100px) { .content-grid { grid-template-columns: 1fr; } .side-stack { display: grid; grid-template-columns: 1fr 1fr; } }
@media (max-width:960px)  { .stats5 { grid-template-columns: repeat(2,1fr); } }
@media (max-width:640px)  {
    .main { margin-left: 0; width: 100%; }
    .stats5 { grid-template-columns: 1fr; }
    .body { padding: 14px; } .topbar { padding: 10px 14px; }
    .side-stack { grid-template-columns: 1fr; }
}
</style>

<div class="toasts" id="toasts"></div>

<div class="lightbox" id="lb" onclick="this.classList.remove('open')">
    <button class="lb-close" onclick="event.stopPropagation();document.getElementById('lb').classList.remove('open')"><i class="fas fa-times"></i></button>
    <img id="lbImg" src="" alt="Bukti">
</div>

<div class="overlay" id="mApprove">
    <div class="modal">
        <div class="m-head">
            <h3><i class="fas fa-circle-check" style="color:var(--green);margin-right:7px;"></i><span data-i18n="m_app_title">Verifikasi Pembayaran</span></h3>
            <button class="m-close" onclick="closeM('mApprove')"><i class="fas fa-times"></i></button>
        </div>
        <div class="m-body">
            <p style="font-size:13px;color:var(--txt);margin-bottom:14px;" data-i18n-html="m_app_desc">Konfirmasi pembayaran dari <strong id="appName">—</strong> sebesar <strong id="appAmt">—</strong>?</p>
            <div style="background:var(--green-lt);border:1px solid var(--green-md);border-radius:10px;padding:12px;display:flex;align-items:center;gap:9px;">
                <i class="fas fa-info-circle" style="color:var(--green);font-size:14px;flex-shrink:0;"></i>
                <span style="font-size:11.5px;color:var(--green);font-weight:600;" data-i18n-html="m_app_info">Status akan diubah ke <strong>Lunas</strong>.</span>
            </div>
        </div>
        <div class="m-foot">
            <button class="btn-cancel" onclick="closeM('mApprove')" data-i18n="m_cancel">Batal</button>
            <form id="fApprove" method="POST" style="display:inline;">@csrf @method('PATCH')
                <button type="submit" class="btn-approve"><i class="fas fa-check"></i> <span data-i18n="m_confirm">Ya, Verifikasi</span></button>
            </form>
        </div>
    </div>
</div>

<div class="overlay" id="mReject">
    <div class="modal">
        <div class="m-head">
            <h3><i class="fas fa-circle-xmark" style="color:var(--red);margin-right:7px;"></i><span data-i18n="m_rej_title">Tolak Pembayaran</span></h3>
            <button class="m-close" onclick="closeM('mReject')"><i class="fas fa-times"></i></button>
        </div>
        <div class="m-body">
            <p style="font-size:13px;color:var(--txt);margin-bottom:12px;" data-i18n-html="m_rej_desc">Tolak pembayaran dari <strong id="rejName">—</strong>?</p>
            <div class="fg">
                <label class="fl" data-i18n="m_rej_label">Alasan penolakan (opsional)</label>
                <textarea class="fc" id="rejReason" rows="3" data-i18n-placeholder="m_rej_ph" placeholder="Contoh: Bukti tidak jelas, nominal tidak sesuai..." style="resize:none;"></textarea>
            </div>
            <div style="background:var(--red-lt);border:1px solid var(--red-md);border-radius:10px;padding:11px;display:flex;align-items:center;gap:8px;">
                <i class="fas fa-triangle-exclamation" style="color:var(--red);font-size:13px;flex-shrink:0;"></i>
                <span style="font-size:11.5px;color:var(--red);font-weight:600;" data-i18n-html="m_rej_info">Status akan kembali ke <strong>Belum Bayar</strong>.</span>
            </div>
        </div>
        <div class="m-foot">
            <button class="btn-cancel" onclick="closeM('mReject')" data-i18n="m_cancel">Batal</button>
            <form id="fReject" method="POST" style="display:inline;">@csrf @method('PATCH')
                <input type="hidden" name="reason" id="rejReasonVal">
                <button type="submit" class="btn-reject-btn" onclick="document.getElementById('rejReasonVal').value=document.getElementById('rejReason').value"><i class="fas fa-ban"></i> <span data-i18n="m_rej_btn">Tolak</span></button>
            </form>
        </div>
    </div>
</div>

<div class="overlay" id="mBulk">
    <div class="modal">
        <div class="m-head">
            <h3><i class="fas fa-bolt" style="color:var(--amber);margin-right:7px;"></i><span data-i18n="m_bulk_title">Approve Semua Pending</span></h3>
            <button class="m-close" onclick="closeM('mBulk')"><i class="fas fa-times"></i></button>
        </div>
        <div class="m-body">
            <p style="font-size:13px;color:var(--txt);margin-bottom:14px;" data-i18n-html="m_bulk_desc">Verifikasi semua <strong id="bulkCount">0</strong> pembayaran pending sekaligus?</p>
            <div style="background:var(--amber-lt);border:1px solid var(--amber-md);border-radius:10px;padding:12px;display:flex;align-items:center;gap:9px;">
                <i class="fas fa-triangle-exclamation" style="color:var(--amber);font-size:14px;flex-shrink:0;"></i>
                <span style="font-size:11.5px;color:var(--amber);font-weight:600;" data-i18n="m_bulk_warn">Tindakan ini tidak dapat dibatalkan.</span>
            </div>
        </div>
        <div class="m-foot">
            <button class="btn-cancel" onclick="closeM('mBulk')" data-i18n="m_cancel">Batal</button>
            @if(Route::has('payments.bulkApprove'))
            <form action="{{ route('payments.bulkApprove') }}" method="POST" style="display:inline;">@csrf
                <button type="submit" class="btn-approve" style="background:var(--amber);box-shadow:0 3px 10px rgba(201,122,0,.25);"><i class="fas fa-check-double"></i> <span data-i18n="m_bulk_btn">Approve Semua</span></button>
            </form>
            @endif
        </div>
    </div>
</div>

<div class="app">

    @include('partials.sidebar')

<div class="main">
    <header class="topbar">
        <div>
            <div class="top-ttl" data-i18n="top_title">Pusat Kendali Admin</div>
            <div class="top-sub"><span data-i18n="top_welcome">Selamat datang</span>, {{ auth()->user()->name }} · {{ date('d M Y') }}</div>
        </div>
        <div class="top-r">
            <div class="search-wrap">
                <i class="fas fa-search search-ic"></i>
                <input type="text" class="search-inp" id="globalSearch" data-i18n-placeholder="search_ph" placeholder="Cari siswa, transaksi...">
            </div>
            @if(($pendingCount ?? 0) > 0)
            <div class="chip warn"><i class="fas fa-bell"></i> {{ $pendingCount }} <span data-i18n="chip_pending">Pending</span></div>
            @endif
            @if(Route::has('admin.tagihan.create'))
            <a href="{{ route('admin.tagihan.create') }}" class="btn-blue"><i class="fas fa-plus"></i> <span data-i18n="btn_bill">Tagihan</span></a>
            @endif
        </div>
    </header>

    <div class="body">

        @if(($pendingCount ?? 0) > 0)
        <div class="alert-bar">
            <div class="alert-ic"><i class="fas fa-bell"></i></div>
            <div>
                <h4 data-i18n-html="alert_title">{{ $pendingCount }} bukti pembayaran menunggu verifikasi</h4>
                <p data-i18n="alert_desc">Siswa sudah upload bukti transfer — segera periksa.</p>
            </div>
            @if($pendingCount > 1)
            <button class="alert-btn" onclick="openBulk()"><i class="fas fa-bolt"></i> <span data-i18n="btn_approve_all">Approve Semua</span></button>
            @endif
            <a href="#panel-verif" class="alert-btn" style="margin-left:4px;"><i class="fas fa-arrow-down"></i> <span data-i18n="btn_see">Lihat</span></a>
        </div>
        @endif

        @php
            $totalS = $totalStudents ?? 0; $paidC = $paidCount ?? 0; $pendC = $pendingCount ?? 0;
            $unpaidC = max(0, $totalS - $paidC - $pendC);
            $paidPct = $totalS > 0 ? round($paidC / $totalS * 100) : 0;
            $pendPct = $totalS > 0 ? round($pendC / $totalS * 100) : 0;
            $unpaidPct = max(0, 100 - $paidPct - $pendPct);
        @endphp
        <div class="dm-progress-source" data-progress="{{ $paidPct }}" data-progress-label="SPP Lunas" style="display:none;"></div>
        <div class="stats5">
            <div class="sc b">
                <div class="sc-ic" style="background:var(--blue-lt);color:var(--blue);"><i class="fas fa-user-graduate"></i></div>
                <div class="sc-lbl" data-i18n="s_total">Total Siswa</div>
                <div class="sc-val">{{ $totalS }}</div>
                <div class="sc-note" data-i18n="s_total_note">Siswa terdaftar aktif</div>
                <div class="sc-badge neu"><i class="fas fa-users"></i> <span data-i18n="s_total_bd">Terdaftar</span></div>
            </div>
            <div class="sc g">
                <div class="sc-ic" style="background:var(--green-lt);color:var(--green);"><i class="fas fa-coins"></i></div>
                <div class="sc-lbl" style="color:var(--green);" data-i18n="s_revenue">Dana Masuk</div>
                <div class="sc-val" style="color:var(--green);font-size:16px;letter-spacing:-.5px;">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
                <div class="sc-note" data-i18n="s_rev_note">Total SPP terkumpul</div>
                <div class="sc-badge up"><i class="fas fa-arrow-trend-up"></i> <span data-i18n="s_rev_bd">Terkumpul</span></div>
            </div>
            <div class="sc a">
                <div class="sc-ic" style="background:var(--amber-lt);color:var(--amber);"><i class="fas fa-receipt"></i></div>
                <div class="sc-lbl" style="color:var(--amber);" data-i18n="s_trans">Total Transaksi</div>
                <div class="sc-val">{{ $totalPayments ?? 0 }}</div>
                <div class="sc-note" data-i18n="s_trans_note">Semua status pembayaran</div>
                <div class="sc-badge neu"><i class="fas fa-layer-group"></i> <span data-i18n="s_trans_bd">Semua</span></div>
            </div>
            <div class="sc r">
                <div class="sc-ic" style="background:var(--red-lt);color:var(--red);"><i class="fas fa-hourglass-half"></i></div>
                <div class="sc-lbl" style="color:var(--red);" data-i18n="s_pending">Menunggu Verif</div>
                <div class="sc-val" style="color:var(--red);">{{ $pendC }}</div>
                <div class="sc-note" data-i18n="s_pend_note">Bukti belum diverifikasi</div>
                <div class="sc-badge warn"><i class="fas fa-exclamation"></i> <span data-i18n="s_pend_bd">Perlu Aksi</span></div>
            </div>
            <div class="sc p">
                <div class="sc-ic" style="background:var(--purple-lt);color:var(--purple);"><i class="fas fa-book-open"></i></div>
                <div class="sc-lbl" style="color:var(--purple);">Jadwal Hari Ini</div>
                <div class="sc-val" style="color:var(--purple);">{{ $todayScheduleCount ?? 0 }}</div>
                <div class="sc-note">Jumlah mapel sesuai jadwal hari ini</div>
                <div class="sc-badge neu"><i class="fas fa-calendar-check"></i> Jadwal</div>
            </div>
        </div>

        <div class="content-grid">
            <div class="card">
                <div class="card-head">
                    <div><div class="card-ttl" data-i18n="tbl_title">Transaksi Terbaru</div><div class="card-sub" data-i18n="tbl_sub">10 pembayaran terakhir</div></div>
                    @if(Route::has('admin.payments'))
                    <a href="{{ route('admin.payments') }}" class="btn-blue"><i class="fas fa-arrow-right"></i> <span data-i18n="btn_see_all">Lihat Semua</span></a>
                    @endif
                </div>
                <div class="ftabs">
                    <button class="ftab on" onclick="filterT('all',this)" data-i18n="f_all">Semua</button>
                    <button class="ftab" onclick="filterT('paid',this)" data-i18n="f_paid">Lunas</button>
                    <button class="ftab" onclick="filterT('approved',this)">Approved</button>
                    <button class="ftab" onclick="filterT('pending',this)">Pending</button>
                    <button class="ftab" onclick="filterT('unpaid',this)" data-i18n="f_unpaid">Belum Bayar</button>
                </div>
                <div style="overflow-x:auto;">
                    <table class="dt">
                        <thead><tr><th data-i18n="th_student">Siswa</th><th data-i18n="th_month">Bulan / Tahun</th><th class="r" data-i18n="th_amount">Jumlah</th><th data-i18n="th_status">Status</th><th data-i18n="th_action">Aksi</th></tr></thead>
                        <tbody id="tRecent">
                            @forelse($recentPayments ?? [] as $pay)
                            @php $s = strtolower($pay->status); @endphp
                            <tr data-status="{{ $s }}">
                                <td><div class="stu-cell"><div class="stu-av">{{ substr($pay->student->name ?? 'U', 0, 1) }}</div><div><div class="stu-name">{{ $pay->student->name ?? '—' }}</div><div class="stu-meta">{{ $pay->student->class_id ?? '' }}</div></div></div></td>
                                <td style="color:var(--txt2);font-size:12px;">{{ $pay->month ?? '—' }} {{ $pay->year ?? '' }}</td>
                                <td class="amt">Rp {{ number_format($pay->amount, 0, ',', '.') }}</td>
                                <td>
                                    @if(in_array($s, ['paid','approved']))<span class="bdg paid"><i class="fas fa-check-circle"></i> <span data-i18n="b_paid">Lunas</span></span>
                                    @elseif($s === 'pending')<span class="bdg pending"><i class="fas fa-hourglass-half"></i> Pending</span>
                                    @elseif($s === 'rejected')<span class="bdg rejected"><i class="fas fa-ban"></i> <span data-i18n="b_rejected">Ditolak</span></span>
                                    @else<span class="bdg unpaid"><i class="fas fa-clock"></i> <span data-i18n="f_unpaid">Belum Bayar</span></span>@endif
                                </td>
                                <td><div class="acts">
                                    @if(Route::has('payments.edit'))<a href="{{ route('payments.edit', $pay->id) }}" class="act e" title="Edit"><i class="fas fa-pen"></i></a>@endif
                                    @if($s === 'pending')
                                    <button class="act v" title="Approve" onclick="doApprove({{ $pay->id }},'{{ addslashes($pay->student->name ?? '') }}','Rp {{ number_format($pay->amount,0,',','.') }}')"><i class="fas fa-check"></i></button>
                                    <button class="act d" title="Tolak" onclick="doReject({{ $pay->id }},'{{ addslashes($pay->student->name ?? '') }}')"><i class="fas fa-times"></i></button>
                                    @endif
                                </div></td>
                            </tr>
                            @empty
                            <tr><td colspan="5"><div class="empty"><div class="empty-ic"><i class="fas fa-inbox"></i></div><p data-i18n="e_trans">Belum ada transaksi</p></div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="side-stack">
                <div class="card">
                    <div class="card-head"><div><div class="card-ttl" data-i18n="prog_title">Progress Bulan Ini</div><div class="card-sub">{{ date('F Y') }}</div></div></div>
                    <div class="prog-body">
                        <div class="prog-row"><span class="prog-lbl" data-i18n="prog_paid">Lunas</span><span class="prog-val" style="color:var(--green);">{{ $paidC }} / {{ $totalS }}</span></div>
                        <div class="prog-bar"><div class="prog-fill g" style="width:{{ $paidPct }}%;"></div></div>
                        <div class="prog-row"><span class="prog-lbl" data-i18n="prog_pending">Pending Verif</span><span class="prog-val" style="color:var(--blue);">{{ $pendC }}</span></div>
                        <div class="prog-bar"><div class="prog-fill b" style="width:{{ $pendPct }}%;"></div></div>
                        <div class="prog-row"><span class="prog-lbl" data-i18n="f_unpaid">Belum Bayar</span><span class="prog-val" style="color:var(--amber);">{{ $unpaidC }}</span></div>
                        <div class="prog-bar"><div class="prog-fill a" style="width:{{ $unpaidPct }}%;"></div></div>
                        <div class="prog-summary">
                            <div class="prog-sum-item"><div class="prog-sum-val" style="color:var(--green);">{{ $paidPct }}%</div><div class="prog-sum-lbl" data-i18n="prog_paid">Lunas</div></div>
                            <div class="prog-sum-item"><div class="prog-sum-val" style="color:var(--blue);">{{ $pendPct }}%</div><div class="prog-sum-lbl" data-i18n="prog_pending">Pending</div></div>
                            <div class="prog-sum-item"><div class="prog-sum-val" style="color:var(--amber);">{{ $unpaidPct }}%</div><div class="prog-sum-lbl" data-i18n="f_unpaid">Belum</div></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-head"><div class="card-ttl" data-i18n="qa_title">Aksi Cepat</div></div>
                    <div class="qa-list">
                        @if(Route::has('payments.create'))
                        <a href="{{ route('payments.create') }}" class="qa-item"><div class="qa-ic" style="background:var(--blue-lt);color:var(--blue);"><i class="fas fa-plus-circle"></i></div><div><div class="qa-ttl" data-i18n="qa_add_pay">Tambah Pembayaran</div><div class="qa-dsc" data-i18n="qa_add_pay_d">Input transaksi manual</div></div><i class="fas fa-chevron-right qa-arr"></i></a>
                        @endif
                        @if(Route::has('admin.tagihan.create'))
                        <a href="{{ route('admin.tagihan.create') }}" class="qa-item"><div class="qa-ic" style="background:var(--green-lt);color:var(--green);"><i class="fas fa-file-invoice-dollar"></i></div><div><div class="qa-ttl" data-i18n="btn_create_bill">Buat Tagihan</div><div class="qa-dsc" data-i18n="qa_bill_d">Generate tagihan siswa</div></div><i class="fas fa-chevron-right qa-arr"></i></a>
                        @endif
                        @if(Route::has('students.create'))
                        <a href="{{ route('students.create') }}" class="qa-item"><div class="qa-ic" style="background:var(--purple-lt);color:var(--purple);"><i class="fas fa-user-plus"></i></div><div><div class="qa-ttl" data-i18n="nav_add_student">Tambah Siswa</div><div class="qa-dsc" data-i18n="qa_student_d">Daftarkan siswa baru</div></div><i class="fas fa-chevron-right qa-arr"></i></a>
                        @endif
                        @if(Route::has('users.index'))
                        <a href="{{ route('users.index') }}" class="qa-item"><div class="qa-ic" style="background:var(--cyan-lt);color:var(--cyan);"><i class="fas fa-users-gear"></i></div><div><div class="qa-ttl" data-i18n="nav_users">Manajemen User</div><div class="qa-dsc" data-i18n="qa_users_d">Kelola akun pengguna</div></div><i class="fas fa-chevron-right qa-arr"></i></a>
                        @endif
                        @if(Route::has('payments.report'))
                        <a href="{{ route('payments.report') }}" class="qa-item"><div class="qa-ic" style="background:var(--amber-lt);color:var(--amber);"><i class="fas fa-chart-bar"></i></div><div><div class="qa-ttl" data-i18n="nav_report">Laporan SPP</div><div class="qa-dsc" data-i18n="qa_report_d">Rekap keuangan</div></div><i class="fas fa-chevron-right qa-arr"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="content-grid">
            <div class="card">
                <div class="card-head"><div><div class="card-ttl"><i class="fas fa-chart-bar" style="color:var(--blue);margin-right:6px;"></i><span data-i18n="rk_title">Rekapitulasi per Kelas</span></div><div class="card-sub" data-i18n="rk_sub">Persentase pembayaran tiap kelas bulan ini</div></div></div>
                @php $classStats = $classStats ?? []; @endphp
                @if(count($classStats) > 0)
                <div style="padding:8px 0;">
                    @foreach($classStats as $klass)
                    @php $kPct = ($klass['total'] ?? 0) > 0 ? round(($klass['paid'] ?? 0) / $klass['total'] * 100) : 0; @endphp
                    <div class="klass-row"><div class="klass-name">{{ $klass['name'] ?? '—' }}</div><div class="klass-bar-wrap"><div class="klass-bar-fill" style="width:{{ $kPct }}%;background:{{ $kPct >= 80 ? 'var(--green)' : ($kPct >= 50 ? 'var(--blue)' : 'var(--amber)') }};"></div></div><div class="klass-pct">{{ $kPct }}%</div><div class="klass-count">{{ $klass['paid'] ?? 0 }}/{{ $klass['total'] ?? 0 }}</div></div>
                    @endforeach
                </div>
                @else
                <div class="empty"><div class="empty-ic"><i class="fas fa-chart-bar"></i></div><p data-i18n="e_class">Belum ada data kelas</p></div>
                @endif
            </div>
            <div class="card">
                <div class="card-head"><div><div class="card-ttl"><i class="fas fa-bolt" style="color:var(--amber);margin-right:6px;"></i><span data-i18n="act_title">Aktivitas Terbaru</span></div><div class="card-sub" data-i18n="act_sub">Log 5 transaksi terkini</div></div></div>
                <div class="feed-list">
                    @forelse(($recentPayments ?? collect())->take(5) as $p)
                    @php $s = strtolower($p->status); $isOk = in_array($s, ['paid','approved']); @endphp
                    <div class="feed-item"><div class="feed-dot" style="background:{{ $isOk ? 'var(--green-lt)' : ($s === 'pending' ? 'var(--blue-lt)' : 'var(--amber-lt)') }};color:{{ $isOk ? 'var(--green)' : ($s === 'pending' ? 'var(--blue)' : 'var(--amber)') }};"><i class="fas {{ $isOk ? 'fa-check' : ($s === 'pending' ? 'fa-hourglass-half' : 'fa-clock') }}"></i></div><div><div class="feed-txt"><strong>{{ $p->student->name ?? '—' }}</strong> · {{ $p->month }} {{ $p->year }}</div><div class="feed-time">Rp {{ number_format($p->amount, 0, ',', '.') }} · {{ $isOk ? 'Lunas' : ($s === 'pending' ? 'Pending' : 'Belum Bayar') }}</div></div></div>
                    @empty
                    <div class="empty"><div class="empty-ic"><i class="fas fa-history"></i></div><p data-i18n="e_act">Belum ada aktivitas</p></div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="card full-width" id="panel-verif">
            <div class="card-head">
                <div><div class="card-ttl"><i class="fas fa-file-circle-check" style="color:var(--blue);margin-right:6px;"></i><span data-i18n="v_title">Verifikasi Bukti Pembayaran</span></div><div class="card-sub" data-i18n="v_sub">Periksa dan approve / tolak bukti transfer siswa</div></div>
                <div style="display:flex;gap:7px;align-items:center;">
                    @if(($pendingCount ?? 0) > 0)
                    <span class="bdg pending" style="font-size:10px;padding:5px 12px;">{{ $pendingCount }} <span data-i18n="v_waiting">Menunggu</span></span>
                    @if($pendingCount > 1)
                    <button class="btn-blue" onclick="openBulk()"><i class="fas fa-bolt"></i> <span data-i18n="btn_approve_all">Approve Semua</span></button>
                    @endif
                    @endif
                </div>
            </div>
            @php $pendingPayments = $pendingPayments ?? collect(); @endphp
            @if($pendingPayments->isEmpty())
            <div class="empty"><div class="empty-ic"><i class="fas fa-check-double"></i></div><p data-i18n="v_empty">Semua pembayaran sudah diverifikasi</p><span data-i18n="v_empty_sub">Tidak ada bukti yang perlu diperiksa.</span></div>
            @else
            <div id="verifList">
                @foreach($pendingPayments as $p)
                <div class="verif-item" id="vrow-{{ $p->id }}">
                    <div class="verif-av">{{ substr($p->student->name ?? 'U', 0, 1) }}</div>
                    <div class="verif-thumb" @if($p->proof && !str_ends_with(strtolower($p->proof), '.pdf')) onclick="openLb('{{ Storage::url($p->proof) }}')" @endif>
                        @if($p->proof)
                            @if(str_ends_with(strtolower($p->proof), '.pdf'))<i class="fas fa-file-pdf" style="color:var(--red);font-size:16px;"></i>
                            @else<img src="{{ Storage::url($p->proof) }}" alt="Bukti">@endif
                        @else<i class="fas fa-image" style="color:var(--txt3);font-size:16px;"></i>@endif
                    </div>
                    <div class="verif-info"><div class="verif-name">{{ $p->student->name ?? 'Siswa' }}</div><div class="verif-meta"><i class="fas fa-calendar" style="font-size:9px;"></i> {{ $p->month }} {{ $p->year }}@if($p->jenis_tagihan ?? null) &nbsp;·&nbsp;<i class="fas fa-tag" style="font-size:9px;"></i> {{ $p->jenis_tagihan }}@endif @if($p->payment_method) &nbsp;·&nbsp;<i class="fas fa-credit-card" style="font-size:9px;"></i> {{ $p->payment_method }}@endif</div>@if($p->catatan)<div style="font-size:10px;color:var(--txt3);margin-top:2px;"><i class="fas fa-comment" style="font-size:9px;"></i> {{ $p->catatan }}</div>@endif</div>
                    <div class="verif-amt">Rp {{ number_format($p->amount, 0, ',', '.') }}</div>
                    <div class="verif-btns">
                        @if($p->proof)
                            @if(str_ends_with(strtolower($p->proof), '.pdf'))<a href="{{ Storage::url($p->proof) }}" target="_blank" class="vbtn see"><i class="fas fa-file-pdf"></i> PDF</a>
                            @else<button class="vbtn see" onclick="openLb('{{ Storage::url($p->proof) }}')"><i class="fas fa-eye"></i> <span data-i18n="v_see">Lihat</span></button>@endif
                        @endif
                        <button class="vbtn ok" onclick="doApprove({{ $p->id }},'{{ addslashes($p->student->name ?? '') }}','Rp {{ number_format($p->amount,0,',','.') }}')"><i class="fas fa-check"></i> <span data-i18n="v_approve">Approve</span></button>
                        <button class="vbtn no" onclick="doReject({{ $p->id }},'{{ addslashes($p->student->name ?? '') }}')"><i class="fas fa-times"></i> <span data-i18n="v_reject">Tolak</span></button>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

    </div>
</div>
</div>

<script>
var T = {
    id: {
        sb_name:'Admin Panel', nav_main:'Utama', nav_dashboard:'Dashboard', nav_master:'Data Master',
        nav_students:'Data Siswa', nav_users:'Manajemen User', nav_subjects:'Mata Pelajaran',
        nav_finance:'Keuangan', nav_payments:'Pembayaran SPP', nav_exams:'Pembayaran Ujian',
        nav_reports:'Laporan', nav_report:'Laporan SPP', nav_quick:'Aksi Cepat',
        nav_create_bill:'Buat Tagihan', nav_add_student:'Tambah Siswa', nav_logout:'Keluar',
        role_admin:'Administrator', top_title:'Pusat Kendali Admin', top_welcome:'Selamat datang',
        search_ph:'Cari siswa, transaksi...', chip_pending:'Pending', btn_bill:'Tagihan',
        alert_desc:'Siswa sudah upload bukti transfer — segera periksa.',
        btn_approve_all:'Approve Semua', btn_see:'Lihat',
        bn_title:'Kelola data siswa &<br>seluruh pembayaran.', bn_sub:'Pantau semua transaksi & akademik secara real-time.',
        btn_report:'Laporan', btn_create_bill:'Buat Tagihan',
        s_total:'Total Siswa', s_total_note:'Siswa terdaftar aktif', s_total_bd:'Terdaftar',
        s_revenue:'Dana Masuk', s_rev_note:'Total SPP terkumpul', s_rev_bd:'Terkumpul',
        s_trans:'Total Transaksi', s_trans_note:'Semua status pembayaran', s_trans_bd:'Semua',
        s_pending:'Menunggu Verif', s_pend_note:'Bukti belum diverifikasi', s_pend_bd:'Perlu Aksi',
        s_subjects:'Mata Pelajaran', s_subj_note:'Total mapel terdaftar', s_subj_bd:'Mapel',
        tbl_title:'Transaksi Terbaru', tbl_sub:'10 pembayaran terakhir', btn_see_all:'Lihat Semua',
        f_all:'Semua', f_paid:'Lunas', f_unpaid:'Belum Bayar',
        th_student:'Siswa', th_month:'Bulan / Tahun', th_amount:'Jumlah', th_status:'Status', th_action:'Aksi',
        b_paid:'Lunas', b_rejected:'Ditolak', e_trans:'Belum ada transaksi',
        prog_title:'Progress Bulan Ini', prog_paid:'Lunas', prog_pending:'Pending Verif',
        qa_title:'Aksi Cepat', qa_add_pay:'Tambah Pembayaran', qa_add_pay_d:'Input transaksi manual',
        qa_bill_d:'Generate tagihan siswa', qa_student_d:'Daftarkan siswa baru',
        qa_users_d:'Kelola akun pengguna', qa_report_d:'Rekap keuangan',
        rk_title:'Rekapitulasi per Kelas', rk_sub:'Persentase pembayaran tiap kelas bulan ini',
        act_title:'Aktivitas Terbaru', act_sub:'Log 5 transaksi terkini', e_act:'Belum ada aktivitas', e_class:'Belum ada data kelas',
        v_title:'Verifikasi Bukti Pembayaran', v_sub:'Periksa dan approve / tolak bukti transfer siswa',
        v_waiting:'Menunggu', v_empty:'Semua pembayaran sudah diverifikasi',
        v_empty_sub:'Tidak ada bukti yang perlu diperiksa.', v_see:'Lihat', v_approve:'Approve', v_reject:'Tolak',
        m_app_title:'Verifikasi Pembayaran', m_app_desc:'Konfirmasi pembayaran dari <strong id="appName">—</strong> sebesar <strong id="appAmt">—</strong>?',
        m_app_info:'Status akan diubah ke <strong>Lunas</strong>.', m_cancel:'Batal', m_confirm:'Ya, Verifikasi',
        m_rej_title:'Tolak Pembayaran', m_rej_desc:'Tolak pembayaran dari <strong id="rejName">—</strong>?',
        m_rej_label:'Alasan penolakan (opsional)', m_rej_ph:'Contoh: Bukti tidak jelas, nominal tidak sesuai...',
        m_rej_info:'Status akan kembali ke <strong>Belum Bayar</strong>.', m_rej_btn:'Tolak',
        m_bulk_title:'Approve Semua Pending', m_bulk_desc:'Verifikasi semua <strong id="bulkCount">0</strong> pembayaran pending sekaligus?',
        m_bulk_warn:'Tindakan ini tidak dapat dibatalkan.', m_bulk_btn:'Approve Semua',
        t_ok:'Berhasil!', t_err:'Error'
    },
    en: {
        sb_name:'Admin Panel', nav_main:'Main', nav_dashboard:'Dashboard', nav_master:'Master Data',
        nav_students:'Students', nav_users:'User Management', nav_subjects:'Subjects',
        nav_finance:'Finance', nav_payments:'SPP Payments', nav_exams:'Exam Payments',
        nav_reports:'Reports', nav_report:'SPP Report', nav_quick:'Quick Actions',
        nav_create_bill:'Create Bill', nav_add_student:'Add Student', nav_logout:'Logout',
        role_admin:'Administrator', top_title:'Admin Control Center', top_welcome:'Welcome',
        search_ph:'Search student, transaction...', chip_pending:'Pending', btn_bill:'Bill',
        alert_desc:'Student uploaded proof of transfer — please check immediately.',
        btn_approve_all:'Approve All', btn_see:'View',
        bn_title:'Manage student data &<br>all payments.', bn_sub:'Monitor all transactions & academics in real-time.',
        btn_report:'Report', btn_create_bill:'Create Bill',
        s_total:'Total Students', s_total_note:'Active registered students', s_total_bd:'Registered',
        s_revenue:'Revenue', s_rev_note:'Total SPP collected', s_rev_bd:'Collected',
        s_trans:'Total Transactions', s_trans_note:'All payment statuses', s_trans_bd:'All',
        s_pending:'Pending Verify', s_pend_note:'Proof not yet verified', s_pend_bd:'Needs Action',
        s_subjects:'Subjects', s_subj_note:'Total registered subjects', s_subj_bd:'Subjects',
        tbl_title:'Recent Transactions', tbl_sub:'Last 10 payments', btn_see_all:'View All',
        f_all:'All', f_paid:'Paid', f_unpaid:'Unpaid',
        th_student:'Student', th_month:'Month / Year', th_amount:'Amount', th_status:'Status', th_action:'Action',
        b_paid:'Paid', b_rejected:'Rejected', e_trans:'No transactions yet',
        prog_title:'This Month Progress', prog_paid:'Paid', prog_pending:'Pending Verify',
        qa_title:'Quick Actions', qa_add_pay:'Add Payment', qa_add_pay_d:'Manual transaction input',
        qa_bill_d:'Generate student bills', qa_student_d:'Register new student',
        qa_users_d:'Manage user accounts', qa_report_d:'Financial recap',
        rk_title:'Recap by Class', rk_sub:'Payment percentage per class this month',
        act_title:'Recent Activity', act_sub:'Last 5 transaction logs', e_act:'No activity yet', e_class:'No class data',
        v_title:'Verify Payment Proof', v_sub:'Review and approve / reject student transfer proof',
        v_waiting:'Waiting', v_empty:'All payments verified',
        v_empty_sub:'No proof to review.', v_see:'View', v_approve:'Approve', v_reject:'Reject',
        m_app_title:'Verify Payment', m_app_desc:'Confirm payment from <strong id="appName">—</strong> for <strong id="appAmt">—</strong>?',
        m_app_info:'Status will be changed to <strong>Paid</strong>.', m_cancel:'Cancel', m_confirm:'Yes, Verify',
        m_rej_title:'Reject Payment', m_rej_desc:'Reject payment from <strong id="rejName">—</strong>?',
        m_rej_label:'Rejection reason (optional)', m_rej_ph:'e.g.: Proof unclear, amount mismatch...',
        m_rej_info:'Status will revert to <strong>Unpaid</strong>.', m_rej_btn:'Reject',
        m_bulk_title:'Approve All Pending', m_bulk_desc:'Verify all <strong id="bulkCount">0</strong> pending payments at once?',
        m_bulk_warn:'This action cannot be undone.', m_bulk_btn:'Approve All',
        t_ok:'Success!', t_err:'Error'
    }
};

var lang = @json($uiLocale ?? session('ui_locale', 'id'));
var theme = @json($uiTheme ?? session('ui_theme', 'light'));

function applyTheme() {
    document.documentElement.setAttribute('data-theme', theme);
    var ic = document.getElementById('themeIcon');
    if (ic) ic.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
}

function applyLang() {
    var d = T[lang] || T.id;
    document.querySelectorAll('[data-i18n]').forEach(function(el) {
        var k = el.getAttribute('data-i18n');
        if (d[k]) el.textContent = d[k];
    });
    document.querySelectorAll('[data-i18n-html]').forEach(function(el) {
        var k = el.getAttribute('data-i18n-html');
        if (d[k]) el.innerHTML = d[k];
    });
    document.querySelectorAll('[data-i18n-placeholder]').forEach(function(el) {
        var k = el.getAttribute('data-i18n-placeholder');
        if (d[k]) el.placeholder = d[k];
    });
    var lbl = document.getElementById('langLabel');
    if (lbl) lbl.textContent = lang.toUpperCase();
}

applyTheme();
applyLang();

function openM(id) { document.getElementById(id).classList.add('open'); }
function closeM(id) { document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.overlay').forEach(function(el) {
    el.addEventListener('click', function(e) { if (e.target === this) this.classList.remove('open'); });
});
function openLb(url) { document.getElementById('lbImg').src = url; document.getElementById('lb').classList.add('open'); }
function doApprove(id, name, amount) {
    document.getElementById('appName').textContent = name;
    document.getElementById('appAmt').textContent = amount;
    document.getElementById('fApprove').action = '/payments/' + id + '/verify';
    applyLang();
    openM('mApprove');
}
function doReject(id, name) {
    document.getElementById('rejName').textContent = name;
    document.getElementById('fReject').action = '/payments/' + id + '/reject';
    document.getElementById('rejReason').value = '';
    applyLang();
    openM('mReject');
}
function openBulk() {
    document.getElementById('bulkCount').textContent = {{ $pendingCount ?? 0 }};
    applyLang();
    openM('mBulk');
}
function filterT(status, btn) {
    document.querySelectorAll('.ftab').forEach(function(b) { b.classList.remove('on'); });
    btn.classList.add('on');
    document.querySelectorAll('#tRecent tr[data-status]').forEach(function(r) {
        r.style.display = (status === 'all' || r.dataset.status === status) ? '' : 'none';
    });
}
document.getElementById('globalSearch').addEventListener('input', function() {
    var q = this.value.toLowerCase().trim();
    document.querySelectorAll('#tRecent tr[data-status]').forEach(function(r) {
        r.style.display = (!q || r.textContent.toLowerCase().includes(q)) ? '' : 'none';
    });
    document.querySelectorAll('.verif-item').forEach(function(item) {
        item.style.display = (!q || item.textContent.toLowerCase().includes(q)) ? '' : 'none';
    });
});
function toast(type, title, msg) {
    var d = T[lang] || T.id;
    var icons = { s: 'fa-check', e: 'fa-times' };
    var el = document.createElement('div');
    el.className = 'toast';
    el.innerHTML = '<div class="t-ic ' + type + '"><i class="fas ' + icons[type] + '"></i></div><div><div class="t-ttl">' + title + '</div><div class="t-msg">' + msg + '</div></div>';
    document.getElementById('toasts').appendChild(el);
    setTimeout(function() { el.classList.add('hide'); setTimeout(function() { el.remove(); }, 250); }, 3500);
}
window.addEventListener('load', function() {
    var d = T[lang] || T.id;
    @if(session('success'))toast('s', d.t_ok, '{{ addslashes(session("success")) }}');@endif
    @if(session('error'))toast('e', d.t_err, '{{ addslashes(session("error")) }}');@endif
});
</script>

@include('partials.dashboard-motion')
@endsection