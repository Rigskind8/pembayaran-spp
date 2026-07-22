@extends('layouts.app')

@section('title', 'Pembayaran - SMK TRAVINA PRIMA')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --sidebar-w: 72px;
        --bg: #f0f2f7;
        --sidebar-bg: #0d1117;
        --accent: #2563eb;
        --accent2: #7c3aed;
        --card: #ffffff;
        --border: #e2e8f0;
        --txt: #0f172a;
        --txt2: #64748b;
        --green: #059669;
        --green-bg: #ecfdf5;
        --green-bd: #a7f3d0;
        --red: #dc2626;
        --red-bg: #fff1f2;
        --red-bd: #fecdd3;
        --amber: #d97706;
        --amber-bg: #fffbeb;
        --amber-bd: #fde68a;
        --blue-bg: #eff6ff;
        --radius: 18px;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        --shadow-md: 0 4px 16px rgba(0,0,0,0.07);
        --shadow-lg: 0 10px 40px rgba(0,0,0,0.12);
    }

    html, body { height: 100%; font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--txt); -webkit-font-smoothing: antialiased; overflow-x: hidden; }
    .wrap { display: flex; min-height: 100vh; }

    /* ─── SIDEBAR ─── */
    .sidebar { width: var(--sidebar-w); background: var(--sidebar-bg); position: fixed; top: 0; left: 0; height: 100vh; z-index: 200; display: flex; flex-direction: column; align-items: center; padding: 20px 0 24px; transition: width 0.3s cubic-bezier(0.4,0,0.2,1); overflow: hidden; }
    .sidebar:hover { width: 240px; align-items: flex-start; }
    .sidebar::after { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--accent), var(--accent2)); }
    .sb-logo { display: flex; align-items: center; gap: 12px; padding: 6px 18px; width: 100%; min-height: 52px; margin-bottom: 28px; flex-shrink: 0; }
    .sb-logo-icon { width: 36px; height: 36px; border-radius: 11px; background: linear-gradient(135deg, var(--accent), var(--accent2)); display: flex; align-items: center; justify-content: center; color: white; font-size: 16px; flex-shrink: 0; box-shadow: 0 4px 14px rgba(37,99,235,0.45); }
    .sb-nav { display: flex; flex-direction: column; gap: 2px; width: 100%; padding: 0 10px; flex: 1; }
    .sb-section-label { font-size: 9px; font-weight: 700; letter-spacing: 0.16em; color: #374151; text-transform: uppercase; padding: 12px 8px 6px; white-space: nowrap; opacity: 0; transition: opacity 0.2s; }
    .sidebar:hover .sb-section-label { opacity: 1; }
    .sb-link { display: flex; align-items: center; gap: 12px; padding: 11px 10px; border-radius: 12px; color: #6b7280; font-size: 13px; font-weight: 600; text-decoration: none; white-space: nowrap; transition: all 0.18s ease; position: relative; }
    .sb-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0; background: rgba(255,255,255,0.04); transition: all 0.18s; }
    .sb-link:hover { color: #e2e8f0; background: rgba(255,255,255,0.05); }
    .sb-link:hover .sb-icon { background: rgba(37,99,235,0.15); color: #93c5fd; }
    .sb-link.active { color: #fff; background: rgba(37,99,235,0.12); }
    .sb-link.active .sb-icon { background: linear-gradient(135deg, var(--accent), var(--accent2)); color: white; box-shadow: 0 4px 12px rgba(37,99,235,0.4); }
    .sb-link.active::before { content: ''; position: absolute; left: -10px; top: 50%; transform: translateY(-50%); width: 3px; height: 24px; background: linear-gradient(180deg, var(--accent), var(--accent2)); border-radius: 0 3px 3px 0; }
    .sb-footer { width: 100%; padding: 0 10px; margin-top: auto; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 16px; }
    .sb-user { display: flex; align-items: center; gap: 10px; padding: 10px; border-radius: 12px; background: rgba(255,255,255,0.04); margin-bottom: 8px; }
    .sb-avatar { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, var(--accent), var(--accent2)); color: white; font-weight: 800; font-size: 15px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .sb-user-name { font-size: 12.5px; font-weight: 700; color: #f1f5f9; line-height: 1.3; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .sb-user-role { font-size: 10px; color: #6b7280; }
    .sb-logout { display: flex; align-items: center; gap: 12px; padding: 10px; border-radius: 12px; background: transparent; border: none; color: #ef4444; font-size: 13px; font-weight: 600; cursor: pointer; width: 100%; font-family: inherit; white-space: nowrap; transition: background 0.18s; }
    .sb-logout:hover { background: rgba(239,68,68,0.1); }
    .sb-logout .sb-icon { background: rgba(239,68,68,0.08); font-size: 14px; }
    .sb-text { opacity: 0; pointer-events: none; transition: opacity 0.2s ease; white-space: nowrap; }
    .sidebar:hover .sb-text { opacity: 1; pointer-events: auto; }

    /* ─── MAIN ─── */
    .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

    /* ─── TOPBAR ─── */
    .topbar { display: flex; align-items: center; justify-content: space-between; padding: 16px 32px; background: rgba(240,242,247,0.85); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; gap: 16px; }
    .topbar-left h1 { font-size: 20px; font-weight: 800; color: var(--txt); letter-spacing: -0.4px; }
    .topbar-left p { font-size: 12.5px; color: var(--txt2); margin-top: 1px; }
    .topbar-right { display: flex; align-items: center; gap: 8px; }
    .pill { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 999px; border: 1px solid var(--border); background: var(--card); font-size: 11.5px; font-weight: 600; color: var(--txt2); box-shadow: var(--shadow-sm); white-space: nowrap; }
    .pill i { font-size: 10px; color: var(--accent); }
    .pill.dark { background: var(--sidebar-bg); color: #94a3b8; border-color: transparent; }
    .pill.dark i { color: #475569; }

    /* ─── BODY ─── */
    .body { padding: 28px 32px; flex: 1; }

    .alert-success-custom { display: flex; align-items: center; gap: 12px; padding: 14px 20px; border-radius: 14px; background: var(--green-bg); border: 1px solid var(--green-bd); color: var(--green); font-size: 13px; font-weight: 600; margin-bottom: 20px; }
    .alert-success-custom i { font-size: 16px; }

    .page-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .ph-left h2 { font-size: 22px; font-weight: 800; color: var(--txt); letter-spacing: -0.4px; line-height: 1.2; }
    .ph-left p { font-size: 13px; color: var(--txt2); margin-top: 3px; }

    .btn-primary-add { display: inline-flex; align-items: center; gap: 8px; padding: 11px 22px; background: linear-gradient(135deg, var(--accent), var(--accent2)); color: white; border-radius: 13px; font-size: 13px; font-weight: 700; text-decoration: none; letter-spacing: 0.02em; box-shadow: 0 4px 14px rgba(37,99,235,0.35); transition: all 0.18s ease; white-space: nowrap; }
    .btn-primary-add:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(37,99,235,0.4); color: white; }

    /* Summary chips */
    .summary-row { display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; }
    .sum-chip { display: flex; align-items: center; gap: 10px; padding: 12px 18px; border-radius: 14px; background: var(--card); border: 1px solid var(--border); box-shadow: var(--shadow-sm); flex: 1; min-width: 140px; }
    .sum-chip-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0; }
    .sum-chip-val { font-size: 18px; font-weight: 800; color: var(--txt); line-height: 1; }
    .sum-chip-label { font-size: 10.5px; font-weight: 600; color: var(--txt2); text-transform: uppercase; letter-spacing: 0.08em; margin-top: 1px; }

    /* Table card */
    .table-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow-sm); }
    .tc-head { display: flex; align-items: center; justify-content: space-between; padding: 20px 28px; border-bottom: 1px solid var(--border); background: #fafbff; gap: 12px; flex-wrap: wrap; }
    .tc-title { font-size: 15px; font-weight: 800; color: var(--txt); letter-spacing: -0.3px; }
    .tc-sub { font-size: 12px; color: var(--txt2); margin-top: 2px; }

    .dt { width: 100%; border-collapse: collapse; }
    .dt thead tr { background: #f8fafc; border-bottom: 1px solid var(--border); }
    .dt th { padding: 13px 20px; font-size: 9.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.18em; color: var(--txt2); }
    .dt th:first-child { padding-left: 28px; }
    .dt th:last-child { padding-right: 28px; }
    .dt tbody tr { border-bottom: 1px solid #f1f5f9; transition: background 0.15s; }
    .dt tbody tr:last-child { border-bottom: none; }
    .dt tbody tr:hover { background: #f8faff; }
    .dt td { padding: 15px 20px; font-size: 13.5px; color: var(--txt); vertical-align: middle; }
    .dt td:first-child { padding-left: 28px; }
    .dt td:last-child { padding-right: 28px; }

    .no-cell { width: 32px; height: 32px; border-radius: 9px; background: #f1f5f9; color: var(--txt2); font-size: 11px; font-weight: 800; display: flex; align-items: center; justify-content: center; }
    .student-cell { display: flex; align-items: center; gap: 10px; }
    .student-avatar { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, var(--accent), var(--accent2)); color: white; font-size: 13px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .student-name { font-weight: 700; font-size: 13.5px; color: var(--txt); }
    .date-cell { color: var(--txt2); font-weight: 500; font-size: 13px; }
    .amount-cell { font-weight: 800; font-size: 14px; color: var(--txt); font-variant-numeric: tabular-nums; }

    /* Keterangan tagihan */
    .ket-tag { display: inline-flex; align-items: center; gap: 5px; padding: 3px 9px; background: #f1f5f9; border-radius: 6px; font-size: 10.5px; font-weight: 600; color: var(--txt2); margin-top: 3px; }

    /* Alasan tolak */
    .reject-box { display: flex; align-items: flex-start; gap: 8px; padding: 8px 12px; background: var(--red-bg); border: 1px solid var(--red-bd); border-radius: 9px; margin-top: 6px; }
    .reject-box i { color: var(--red); font-size: 12px; flex-shrink: 0; margin-top: 1px; }
    .reject-box-text { font-size: 11.5px; font-weight: 600; color: var(--red); line-height: 1.4; }
    .reject-box-label { font-size: 9.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: var(--red); margin-bottom: 1px; }

    .badge { display: inline-flex; align-items: center; gap: 5px; padding: 5px 13px; border-radius: 8px; font-size: 10px; font-weight: 800; letter-spacing: 0.06em; text-transform: uppercase; }
    .badge.paid { background: var(--green-bg); color: var(--green); border: 1px solid var(--green-bd); }
    .badge.unpaid { background: var(--amber-bg); color: var(--amber); border: 1px solid var(--amber-bd); }
    .badge.pending { background: var(--blue-bg); color: var(--accent); border: 1px solid #bfdbfe; }
    .badge.rejected { background: var(--red-bg); color: var(--red); border: 1px solid var(--red-bd); }

    .action-group { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
    .btn-act { display: inline-flex; align-items: center; gap: 5px; padding: 7px 13px; border-radius: 9px; font-size: 11px; font-weight: 700; border: none; cursor: pointer; text-decoration: none; transition: all 0.15s ease; white-space: nowrap; font-family: inherit; }
    .btn-act.info { background: var(--blue-bg); color: var(--accent); }
    .btn-act.info:hover { background: #dbeafe; }
    .btn-act.warn { background: var(--amber-bg); color: var(--amber); }
    .btn-act.warn:hover { background: #fde68a; }
    .btn-act.danger { background: var(--red-bg); color: var(--red); }
    .btn-act.danger:hover { background: #fecdd3; }
    .btn-act.pay { background: linear-gradient(135deg, var(--accent), var(--accent2)); color: white; box-shadow: 0 2px 8px rgba(37,99,235,0.3); }
    .btn-act.pay:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,99,235,0.4); }
    .btn-act.reupload { background: linear-gradient(135deg, var(--red), #b91c1c); color: white; box-shadow: 0 2px 8px rgba(220,38,38,0.3); }
    .btn-act.reupload:hover { transform: translateY(-1px); }

    .empty { padding: 56px 24px; text-align: center; }
    .empty-icon { width: 64px; height: 64px; border-radius: 18px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 28px; color: #cbd5e1; margin: 0 auto 14px; }
    .empty p { font-size: 14px; font-weight: 600; color: var(--txt2); }
    .empty span { font-size: 12px; color: #94a3b8; }

    .pagination-wrap { padding: 16px 28px; border-top: 1px solid var(--border); background: #fafbff; }
    .pagination-wrap .pagination { margin: 0; }
    .pagination-wrap .page-link { border-radius: 9px !important; border-color: var(--border); color: var(--txt2); font-size: 12px; font-weight: 600; margin: 0 2px; }
    .pagination-wrap .page-item.active .page-link { background: var(--accent); border-color: var(--accent); }

    /* ═══ MODAL ═══ */
    .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.55); backdrop-filter: blur(6px); z-index: 1000; display: none; align-items: center; justify-content: center; padding: 20px; }
    .modal-overlay.open { display: flex; }
    .modal { background: white; border-radius: 24px; width: 560px; max-width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: var(--shadow-lg); animation: modalIn 0.28s cubic-bezier(0.34,1.56,0.64,1); }
    @keyframes modalIn { from { opacity: 0; transform: scale(0.92) translateY(16px); } to { opacity: 1; transform: scale(1) translateY(0); } }
    .modal-head { padding: 24px 28px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 12px; position: sticky; top: 0; background: white; z-index: 10; border-radius: 24px 24px 0 0; }
    .modal-head-left { display: flex; align-items: center; gap: 12px; }
    .modal-head-icon { width: 44px; height: 44px; border-radius: 13px; background: linear-gradient(135deg, var(--accent), var(--accent2)); display: flex; align-items: center; justify-content: center; color: white; font-size: 18px; box-shadow: 0 4px 12px rgba(37,99,235,0.35); }
    .modal-head h3 { font-size: 18px; font-weight: 800; color: var(--txt); line-height: 1.2; }
    .modal-head p { font-size: 12px; color: var(--txt2); margin-top: 2px; }
    .modal-close { width: 36px; height: 36px; border-radius: 10px; background: #f1f5f9; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px; color: var(--txt2); transition: all 0.15s; flex-shrink: 0; }
    .modal-close:hover { background: var(--red-bg); color: var(--red); }
    .modal-body { padding: 24px 28px; }
    .modal-footer { padding: 20px 28px; border-top: 1px solid var(--border); display: flex; gap: 10px; justify-content: flex-end; background: #fafbff; border-radius: 0 0 24px 24px; }

    /* Steps */
    .steps { display: flex; align-items: center; gap: 0; margin-bottom: 28px; padding: 0 4px; }
    .step { display: flex; align-items: center; gap: 8px; flex: 1; position: relative; }
    .step:not(:last-child)::after { content: ''; position: absolute; left: 32px; top: 16px; width: calc(100% - 32px); height: 2px; background: var(--border); z-index: 0; transition: background 0.3s; }
    .step.done:not(:last-child)::after { background: var(--green); }
    .step-circle { width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800; z-index: 1; transition: all 0.3s; background: #f1f5f9; color: var(--txt2); border: 2px solid var(--border); }
    .step.active .step-circle { background: var(--accent); color: white; border-color: var(--accent); box-shadow: 0 0 0 4px rgba(37,99,235,0.15); }
    .step.done .step-circle { background: var(--green); color: white; border-color: var(--green); }
    .step-label { font-size: 10px; font-weight: 700; color: var(--txt2); display: none; }
    .step.active .step-label { color: var(--accent); }
    .step.done .step-label { color: var(--green); }

    /* Tagihan box */
    .tagihan-box { background: linear-gradient(135deg, #1e3a8a, #2563eb); border-radius: 16px; padding: 20px 22px; margin-bottom: 24px; display: flex; align-items: center; gap: 16px; }
    .tagihan-box-icon { width: 48px; height: 48px; border-radius: 14px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 20px; color: white; flex-shrink: 0; }
    .tagihan-box-month { font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 3px; }
    .tagihan-box-keterangan { font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.8); margin-bottom: 4px; }
    .tagihan-box-amount { font-size: 26px; font-weight: 800; color: white; letter-spacing: -0.5px; line-height: 1; }
    .tagihan-box-deadline { font-size: 11px; color: rgba(255,255,255,0.6); margin-top: 4px; }

    /* Metode */
    .metode-title { font-size: 12px; font-weight: 700; color: var(--txt2); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 12px; }
    .metode-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 20px; }
    .metode-card { border: 2px solid var(--border); border-radius: 14px; padding: 14px 16px; cursor: pointer; transition: all 0.18s; display: flex; align-items: center; gap: 12px; background: white; }
    .metode-card:hover { border-color: var(--accent); background: #f0f7ff; }
    .metode-card.selected { border-color: var(--accent); background: #eff6ff; box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
    .metode-card input[type="radio"] { display: none; }
    .metode-icon { width: 40px; height: 40px; border-radius: 11px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 18px; }
    .metode-name { font-size: 12.5px; font-weight: 700; color: var(--txt); line-height: 1.3; }
    .metode-sub { font-size: 10.5px; color: var(--txt2); margin-top: 1px; }

    /* Bank list */
    .bank-list { display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin-top: 12px; }
    .bank-chip { display: flex; align-items: center; gap: 8px; padding: 10px 12px; border: 1.5px solid var(--border); border-radius: 10px; cursor: pointer; transition: all 0.15s; background: white; }
    .bank-chip:hover { border-color: var(--accent); background: #f0f7ff; }
    .bank-chip.selected { border-color: var(--accent); background: #eff6ff; }
    .bank-chip input { display: none; }
    .bank-logo { width: 32px; height: 20px; border-radius: 5px; display: flex; align-items: center; justify-content: center; font-size: 9px; font-weight: 900; color: white; letter-spacing: 0.05em; flex-shrink: 0; }
    .bank-chip-name { font-size: 11.5px; font-weight: 700; color: var(--txt); }
    .bank-chip-acc { font-size: 10px; color: var(--txt2); }

    /* Instruksi */
    .instruksi-panel { display: none; }
    .instruksi-panel.show { display: block; }
    .instruksi-header { display: flex; align-items: center; gap: 12px; padding: 16px 18px; border-radius: 14px; margin-bottom: 16px; }
    .instruksi-step-list { display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px; }
    .instruksi-step-item { display: flex; align-items: flex-start; gap: 12px; padding: 12px 14px; background: #f8fafc; border-radius: 12px; border: 1px solid var(--border); }
    .instruksi-num { width: 24px; height: 24px; border-radius: 7px; flex-shrink: 0; background: var(--accent); color: white; font-size: 11px; font-weight: 800; display: flex; align-items: center; justify-content: center; }
    .instruksi-text { font-size: 12.5px; color: var(--txt); font-weight: 500; line-height: 1.5; }
    .instruksi-text strong { font-weight: 700; color: var(--txt); }

    /* Rekening box */
    .rekening-box { background: var(--sidebar-bg); border-radius: 14px; padding: 18px 20px; margin-bottom: 16px; position: relative; }
    .rekening-label { font-size: 10px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.12em; margin-bottom: 4px; }
    .rekening-bank { font-size: 13px; font-weight: 700; color: #94a3b8; margin-bottom: 2px; }
    .rekening-number { font-size: 24px; font-weight: 800; color: white; letter-spacing: 0.08em; }
    .rekening-name { font-size: 12px; color: #64748b; margin-top: 4px; }
    .copy-btn { position: absolute; top: 16px; right: 16px; padding: 6px 12px; border-radius: 8px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12); color: #94a3b8; font-size: 11px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 5px; transition: all 0.15s; font-family: inherit; }
    .copy-btn:hover { background: rgba(255,255,255,0.15); color: white; }

    /* QR */
    .qr-box { display: flex; flex-direction: column; align-items: center; gap: 12px; padding: 24px; background: white; border: 2px solid var(--border); border-radius: 16px; margin-bottom: 16px; }
    .qr-placeholder { width: 160px; height: 160px; background: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 48px; color: #cbd5e1; }
    .qr-amount { font-size: 20px; font-weight: 800; color: var(--txt); }
    .qr-note { font-size: 11px; color: var(--txt2); text-align: center; }

    /* Upload */
    .upload-area { border: 2px dashed var(--border); border-radius: 14px; padding: 28px 20px; text-align: center; cursor: pointer; transition: all 0.2s; }
    .upload-area:hover { border-color: var(--accent); background: #f0f7ff; }
    .upload-area.has-file { border-color: var(--green); background: var(--green-bg); border-style: solid; }
    .upload-icon { font-size: 28px; color: var(--accent); margin-bottom: 8px; }
    .upload-area.has-file .upload-icon { color: var(--green); }
    .upload-area h4 { font-size: 13px; font-weight: 700; color: var(--txt); margin-bottom: 3px; }
    .upload-area p { font-size: 11px; color: var(--txt2); }

    .form-ctrl { width: 100%; padding: 10px 14px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 13px; font-family: inherit; color: var(--txt); outline: none; transition: border-color 0.15s; resize: none; }
    .form-ctrl:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }

    /* Sukses */
    .success-wrap { text-align: center; padding: 20px 0; }
    .success-icon { width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 16px; background: var(--green-bg); border: 3px solid var(--green-bd); display: flex; align-items: center; justify-content: center; font-size: 36px; color: var(--green); animation: popIn 0.4s cubic-bezier(0.34,1.56,0.64,1); }
    @keyframes popIn { from { transform: scale(0); } to { transform: scale(1); } }
    .success-wrap h3 { font-size: 20px; font-weight: 800; color: var(--txt); margin-bottom: 6px; }
    .success-wrap p { font-size: 13px; color: var(--txt2); line-height: 1.6; }

    /* Buttons */
    .btn-outline { display: inline-flex; align-items: center; gap: 7px; padding: 10px 20px; background: white; color: var(--txt); border: 1.5px solid var(--border); border-radius: 12px; font-size: 12.5px; font-weight: 700; cursor: pointer; font-family: inherit; transition: all 0.15s; }
    .btn-outline:hover { background: #f8fafc; }
    .btn-submit { display: inline-flex; align-items: center; gap: 7px; padding: 10px 22px; background: linear-gradient(135deg, var(--accent), var(--accent2)); color: white; border: none; border-radius: 12px; font-size: 12.5px; font-weight: 700; cursor: pointer; font-family: inherit; box-shadow: 0 4px 14px rgba(37,99,235,0.35); transition: all 0.18s; }
    .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(37,99,235,0.4); }
    .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

    /* Toast */
    .toast-container { position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 8px; }
    .toast { display: flex; align-items: center; gap: 12px; padding: 14px 20px; background: white; border-radius: 14px; box-shadow: var(--shadow-lg); border: 1px solid var(--border); min-width: 280px; animation: toastIn 0.3s ease; }
    @keyframes toastIn { from { opacity: 0; transform: translateX(40px); } to { opacity: 1; transform: translateX(0); } }
    .toast.hide { opacity: 0; transform: translateX(40px); transition: all 0.3s; }
    .toast-icon { width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 16px; }
    .toast-icon.success { background: var(--green-bg); color: var(--green); }
    .toast-icon.error { background: var(--red-bg); color: var(--red); }
    .toast-icon.info { background: #eff6ff; color: var(--accent); }
    .toast-content p { font-size: 13px; font-weight: 700; color: var(--txt); }
    .toast-content span { font-size: 11px; color: var(--txt2); }

    @media (max-width: 768px) {
        .sidebar { display: none; }
        .main { margin-left: 0; }
        .body { padding: 18px; }
        .topbar { padding: 14px 18px; }
        .metode-grid { grid-template-columns: 1fr; }
        .bank-list { grid-template-columns: 1fr; }
        .summary-row { flex-direction: column; }
    }
</style>

<div class="toast-container" id="toastContainer"></div>

{{-- ══ PAYMENT MODAL ══ --}}
<div class="modal-overlay" id="payModal">
    <div class="modal">
        <div class="modal-head">
            <div class="modal-head-left">
                <div class="modal-head-icon"><i class="fas fa-credit-card"></i></div>
                <div>
                    <h3 id="modalTitle">Bayar Tagihan</h3>
                    <p id="modalSub">Pilih metode pembayaran</p>
                </div>
            </div>
            <button class="modal-close" onclick="closePayModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="steps">
                <div class="step active" id="step-ind-1"><div class="step-circle">1</div><span class="step-label">Metode</span></div>
                <div class="step" id="step-ind-2"><div class="step-circle">2</div><span class="step-label">Instruksi</span></div>
                <div class="step" id="step-ind-3"><div class="step-circle">3</div><span class="step-label">Upload</span></div>
                <div class="step" id="step-ind-4"><div class="step-circle"><i class="fas fa-check" style="font-size:10px;"></i></div><span class="step-label">Selesai</span></div>
            </div>

            {{-- STEP 1 --}}
            <div id="step1">
                <div class="tagihan-box">
                    <div class="tagihan-box-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                    <div>
                        <div class="tagihan-box-month" id="tagihanMonth">—</div>
                        <div class="tagihan-box-keterangan" id="tagihanKeterangan" style="display:none;"></div>
                        <div class="tagihan-box-amount" id="tagihanAmount">Rp 0</div>
                        <div class="tagihan-box-deadline"><i class="fas fa-clock" style="margin-right:4px;"></i>Deadline: tanggal 10 setiap bulan</div>
                    </div>
                </div>
                <div class="metode-title">Pilih Metode Pembayaran</div>
                <div class="metode-grid">
                    <label class="metode-card" onclick="selectMetode(this, 'transfer')">
                        <input type="radio" name="metode" value="transfer">
                        <div class="metode-icon" style="background:#eff6ff; color:#1d4ed8; font-size:22px;">🏦</div>
                        <div><div class="metode-name">Transfer Bank</div><div class="metode-sub">BCA, Mandiri, BNI, BRI</div></div>
                    </label>
                    <label class="metode-card" onclick="selectMetode(this, 'va')">
                        <input type="radio" name="metode" value="va">
                        <div class="metode-icon" style="background:#f5f3ff; color:#7c3aed; font-size:22px;">💳</div>
                        <div><div class="metode-name">Virtual Account</div><div class="metode-sub">Bayar lewat ATM/m-banking</div></div>
                    </label>
                    <label class="metode-card" onclick="selectMetode(this, 'qris')">
                        <input type="radio" name="metode" value="qris">
                        <div class="metode-icon" style="background:#f0fdf4; color:#059669; font-size:22px;">📱</div>
                        <div><div class="metode-name">QRIS</div><div class="metode-sub">Scan QR dari app apapun</div></div>
                    </label>
                    <label class="metode-card" onclick="selectMetode(this, 'ewallet')">
                        <input type="radio" name="metode" value="ewallet">
                        <div class="metode-icon" style="background:#fff7ed; color:#ea580c; font-size:22px;">📲</div>
                        <div><div class="metode-name">E-Wallet</div><div class="metode-sub">GoPay, OVO, Dana</div></div>
                    </label>
                </div>
                <div id="bankSubPicker" style="display:none;">
                    <div class="metode-title" style="margin-top:4px;">Pilih Bank Tujuan</div>
                    <div class="bank-list">
                        <label class="bank-chip" onclick="selectBank(this, 'bca', '1234567890', 'Yayasan Travina Prima')"><input type="radio" name="bank" value="bca"><div class="bank-logo" style="background:#005ea7;">BCA</div><div><div class="bank-chip-name">BCA</div><div class="bank-chip-acc">1234-567-890</div></div></label>
                        <label class="bank-chip" onclick="selectBank(this, 'mandiri', '1400012345678', 'Yayasan Travina Prima')"><input type="radio" name="bank" value="mandiri"><div class="bank-logo" style="background:#003d7a;">MND</div><div><div class="bank-chip-name">Mandiri</div><div class="bank-chip-acc">1400-0123-45678</div></div></label>
                        <label class="bank-chip" onclick="selectBank(this, 'bni', '0123456789', 'Yayasan Travina Prima')"><input type="radio" name="bank" value="bni"><div class="bank-logo" style="background:#f37021;">BNI</div><div><div class="bank-chip-name">BNI</div><div class="bank-chip-acc">0123-456-789</div></div></label>
                        <label class="bank-chip" onclick="selectBank(this, 'bri', '0987654321', 'Yayasan Travina Prima')"><input type="radio" name="bank" value="bri"><div class="bank-logo" style="background:#00529b;">BRI</div><div><div class="bank-chip-name">BRI</div><div class="bank-chip-acc">0987-6543-21</div></div></label>
                    </div>
                </div>
                <div id="ewalletSubPicker" style="display:none;">
                    <div class="metode-title" style="margin-top:4px;">Pilih E-Wallet</div>
                    <div class="bank-list">
                        <label class="bank-chip" onclick="selectBank(this, 'gopay', '081234567890', 'Yayasan Travina Prima')"><input type="radio" name="ewallet" value="gopay"><div class="bank-logo" style="background:#00AED6;">GP</div><div><div class="bank-chip-name">GoPay</div><div class="bank-chip-acc">0812-3456-7890</div></div></label>
                        <label class="bank-chip" onclick="selectBank(this, 'ovo', '081234567890', 'Yayasan Travina Prima')"><input type="radio" name="ewallet" value="ovo"><div class="bank-logo" style="background:#4C3494;">OVO</div><div><div class="bank-chip-name">OVO</div><div class="bank-chip-acc">0812-3456-7890</div></div></label>
                        <label class="bank-chip" onclick="selectBank(this, 'dana', '081234567890', 'Yayasan Travina Prima')"><input type="radio" name="ewallet" value="dana"><div class="bank-logo" style="background:#118EEA;">DN</div><div><div class="bank-chip-name">Dana</div><div class="bank-chip-acc">0812-3456-7890</div></div></label>
                    </div>
                </div>
            </div>

            {{-- STEP 2 --}}
            <div id="step2" style="display:none;">
                <div class="instruksi-panel" id="instruksi-transfer">
                    <div class="instruksi-header" style="background:#eff6ff; border:1px solid #bfdbfe;">
                        <div style="width:40px;height:40px;border-radius:11px;background:#1d4ed8;display:flex;align-items:center;justify-content:center;color:white;font-size:18px;flex-shrink:0;">🏦</div>
                        <div><div style="font-size:14px;font-weight:800;color:#1e3a8a;">Transfer Bank</div><div style="font-size:11px;color:#3b82f6;" id="instruksiBankName">—</div></div>
                    </div>
                    <div class="rekening-box">
                        <div class="rekening-label">Rekening Tujuan</div>
                        <div class="rekening-bank" id="rekBank">-</div>
                        <div class="rekening-number" id="rekNomor">-</div>
                        <div class="rekening-name" id="rekNama">a/n -</div>
                        <button class="copy-btn" onclick="copyRekening()"><i class="fas fa-copy"></i> Salin</button>
                    </div>
                    <div class="instruksi-step-list">
                        <div class="instruksi-step-item"><div class="instruksi-num">1</div><div class="instruksi-text">Buka <strong>aplikasi mobile banking</strong> atau <strong>ATM</strong>.</div></div>
                        <div class="instruksi-step-item"><div class="instruksi-num">2</div><div class="instruksi-text">Pilih menu <strong>Transfer</strong> → rekening <span id="instruksiBankName2">bank tujuan</span>.</div></div>
                        <div class="instruksi-step-item"><div class="instruksi-num">3</div><div class="instruksi-text">Masukkan nomor rekening <strong id="instruksiBankNum">—</strong>.</div></div>
                        <div class="instruksi-step-item"><div class="instruksi-num">4</div><div class="instruksi-text">Nominal <strong id="instruksiBankAmt">—</strong>. Simpan bukti, lalu upload.</div></div>
                    </div>
                </div>
                <div class="instruksi-panel" id="instruksi-va">
                    <div class="instruksi-header" style="background:#f5f3ff; border:1px solid #ddd6fe;">
                        <div style="width:40px;height:40px;border-radius:11px;background:#7c3aed;display:flex;align-items:center;justify-content:center;color:white;font-size:18px;flex-shrink:0;">💳</div>
                        <div><div style="font-size:14px;font-weight:800;color:#4c1d95;">Virtual Account</div><div style="font-size:11px;color:#7c3aed;">Nomor VA khusus tagihan ini</div></div>
                    </div>
                    <div class="rekening-box">
                        <div class="rekening-label">Nomor Virtual Account</div>
                        <div class="rekening-bank">Bank BCA / Mandiri</div>
                        <div class="rekening-number" id="vaNumber">8800-1234-5678-9012</div>
                        <div class="rekening-name">Berlaku 24 jam</div>
                        <button class="copy-btn" onclick="copyText(document.getElementById('vaNumber').textContent)"><i class="fas fa-copy"></i> Salin</button>
                    </div>
                    <div class="instruksi-step-list">
                        <div class="instruksi-step-item"><div class="instruksi-num">1</div><div class="instruksi-text">Buka <strong>m-banking / ATM</strong>.</div></div>
                        <div class="instruksi-step-item"><div class="instruksi-num">2</div><div class="instruksi-text">Pilih <strong>Transfer → Virtual Account</strong>, masukkan nomor VA di atas.</div></div>
                        <div class="instruksi-step-item"><div class="instruksi-num">3</div><div class="instruksi-text">Konfirmasi, lalu upload bukti.</div></div>
                    </div>
                </div>
                <div class="instruksi-panel" id="instruksi-qris">
                    <div class="instruksi-header" style="background:#f0fdf4; border:1px solid #bbf7d0;">
                        <div style="width:40px;height:40px;border-radius:11px;background:#059669;display:flex;align-items:center;justify-content:center;color:white;font-size:18px;flex-shrink:0;">📱</div>
                        <div><div style="font-size:14px;font-weight:800;color:#065f46;">QRIS</div><div style="font-size:11px;color:#059669;">Scan dari GoPay, OVO, Dana, dll</div></div>
                    </div>
                    <div class="qr-box">
                        <div class="qr-placeholder"><i class="fas fa-qrcode"></i></div>
                        <div class="qr-amount" id="qrisAmount">Rp 0</div>
                        <div class="qr-note">Scan QR menggunakan e-wallet atau m-banking apapun</div>
                    </div>
                    <div class="instruksi-step-list">
                        <div class="instruksi-step-item"><div class="instruksi-num">1</div><div class="instruksi-text">Buka e-wallet atau m-banking, pilih <strong>Scan QR</strong>.</div></div>
                        <div class="instruksi-step-item"><div class="instruksi-num">2</div><div class="instruksi-text">Nominal <strong id="qrisAmountInstr">—</strong> otomatis terisi. Konfirmasi.</div></div>
                        <div class="instruksi-step-item"><div class="instruksi-num">3</div><div class="instruksi-text">Screenshot bukti, lalu upload.</div></div>
                    </div>
                </div>
                <div class="instruksi-panel" id="instruksi-ewallet">
                    <div class="instruksi-header" style="background:#fff7ed; border:1px solid #fed7aa;">
                        <div style="width:40px;height:40px;border-radius:11px;background:#ea580c;display:flex;align-items:center;justify-content:center;color:white;font-size:18px;flex-shrink:0;">📲</div>
                        <div><div style="font-size:14px;font-weight:800;color:#7c2d12;">E-Wallet</div><div style="font-size:11px;color:#ea580c;" id="instruksiWalletName">GoPay / OVO / Dana</div></div>
                    </div>
                    <div class="rekening-box">
                        <div class="rekening-label">Nomor Tujuan</div>
                        <div class="rekening-bank" id="ewalletBankName">-</div>
                        <div class="rekening-number" id="ewalletNomor">-</div>
                        <div class="rekening-name" id="ewalletNama">a/n -</div>
                        <button class="copy-btn" onclick="copyText(document.getElementById('ewalletNomor').textContent)"><i class="fas fa-copy"></i> Salin</button>
                    </div>
                    <div class="instruksi-step-list">
                        <div class="instruksi-step-item"><div class="instruksi-num">1</div><div class="instruksi-text">Buka aplikasi <strong id="instruksiWalletApp">e-wallet</strong>.</div></div>
                        <div class="instruksi-step-item"><div class="instruksi-num">2</div><div class="instruksi-text">Pilih <strong>Kirim / Transfer</strong>, nomor <strong id="instruksiWalletNum">—</strong>, nominal <strong id="instruksiWalletAmt">—</strong>.</div></div>
                        <div class="instruksi-step-item"><div class="instruksi-num">3</div><div class="instruksi-text">Screenshot bukti, lalu upload.</div></div>
                    </div>
                </div>
            </div>

            {{-- STEP 3 --}}
            <div id="step3" style="display:none;">
                <div style="margin-bottom:16px;padding:14px 16px;background:#eff6ff;border-radius:12px;border:1px solid #bfdbfe;display:flex;align-items:center;gap:10px;">
                    <i class="fas fa-circle-info" style="color:var(--accent);font-size:16px;flex-shrink:0;"></i>
                    <div style="font-size:12.5px;font-weight:600;color:#1e40af;">Upload screenshot atau foto bukti transfer. Admin memverifikasi dalam 1×24 jam.</div>
                </div>
                <label style="font-size:12px;font-weight:700;margin-bottom:8px;display:block;">Bukti Transfer / Screenshot *</label>
                <div class="upload-area" id="uploadAreaMain" onclick="document.getElementById('buktiFile').click()">
                    <div class="upload-icon" id="uploadIcon"><i class="fas fa-cloud-arrow-up"></i></div>
                    <h4 id="uploadTitle">Klik atau drag file ke sini</h4>
                    <p id="uploadDesc">JPG, PNG, PDF — Maks. 5MB</p>
                </div>
                <input type="file" id="buktiFile" accept="image/*,.pdf" style="display:none" onchange="handleFile(this)">
                <label style="font-size:12px;font-weight:700;margin-top:12px;margin-bottom:6px;display:block;">Catatan <span style="font-weight:400;color:var(--txt2);">(opsional)</span></label>
                <textarea class="form-ctrl" id="catatanBayar" rows="2" placeholder="Contoh: Transfer via BCA mobile jam 10:30 WIB"></textarea>
                <div style="margin-top:14px;padding:12px 14px;background:#f8fafc;border-radius:10px;border:1px solid var(--border);">
                    <div style="font-size:11px;font-weight:700;color:var(--txt2);text-transform:uppercase;letter-spacing:.1em;margin-bottom:8px;">Ringkasan Pembayaran</div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:4px;"><span style="font-size:12px;color:var(--txt2);">Tagihan</span><span style="font-size:12.5px;font-weight:700;" id="sumTagihan">—</span></div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:4px;"><span style="font-size:12px;color:var(--txt2);">Metode</span><span style="font-size:12.5px;font-weight:700;" id="sumMetode">—</span></div>
                    <div style="display:flex;justify-content:space-between;border-top:1px solid var(--border);padding-top:8px;margin-top:4px;"><span style="font-size:13px;font-weight:700;">Total</span><span style="font-size:15px;font-weight:800;color:var(--accent);" id="sumTotal">—</span></div>
                </div>
            </div>

            {{-- STEP 4 --}}
            <div id="step4" style="display:none;">
                <div class="success-wrap">
                    <div class="success-icon"><i class="fas fa-check"></i></div>
                    <h3>Bukti Dikirim! 🎉</h3>
                    <p>Bukti pembayaran sudah diterima.<br>Admin memverifikasi dalam <strong>1×24 jam</strong>.<br>Status berubah <strong>Lunas</strong> setelah disetujui.</p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-outline" id="btnBack" onclick="stepBack()" style="display:none;"><i class="fas fa-arrow-left"></i> Kembali</button>
            <button class="btn-outline" id="btnCancel" onclick="closePayModal()"><i class="fas fa-times"></i> Batal</button>
            <button class="btn-submit" id="btnNext" onclick="stepNext()" disabled>Lanjut <i class="fas fa-arrow-right"></i></button>
        </div>
    </div>
</div>

{{-- MODAL: BULK APPROVE --}}
<div class="modal-overlay" id="mBulk">
    <div class="modal">
        <div class="modal-head">
            <div class="modal-head-left">
                <div class="modal-head-icon" style="background:linear-gradient(135deg,var(--amber),#f59e0b);"><i class="fas fa-check-double"></i></div>
                <div><h3>Setujui Semua</h3><p>Approve semua pembayaran pending sekaligus</p></div>
            </div>
            <button class="modal-close" onclick="tutupModal('mBulk')"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <p style="font-size:13.5px;margin-bottom:12px;">Semua pembayaran berstatus <strong>Menunggu</strong> yang sudah memiliki bukti akan disetujui sekaligus.</p>
            <div style="padding:14px 16px;background:var(--amber-bg);border:1px solid var(--amber-bd);border-radius:12px;font-size:12.5px;color:var(--amber);font-weight:600;">
                <i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i>Tindakan ini tidak dapat dibatalkan.
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-outline" onclick="tutupModal('mBulk')">Batal</button>
            <form action="{{ route('payments.bulkApprove') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-submit"><i class="fas fa-check-double"></i> Ya, Setujui Semua</button>
            </form>
        </div>
    </div>
</div>

{{-- ═══════════ SIDEBAR ═══════════ --}}
<aside class="sidebar">
    <div class="sb-logo">
        <div class="sb-logo-icon"><i class="fas fa-graduation-cap"></i></div>
    </div>
    <nav class="sb-nav">
        <span class="sb-section-label sb-text">Navigasi</span>
        <a href="{{ route('dashboard') }}" class="sb-link">
            <div class="sb-icon"><i class="fas fa-house"></i></div>
            <span class="sb-text">Dashboard</span>
        </a>
        <a href="{{ route('siswa.pembayaran') }}" class="sb-link active">
            <div class="sb-icon"><i class="fas fa-wallet"></i></div>
            <span class="sb-text">Pembayaran</span>
        </a>
        <a href="{{ route('admin.wa') }}" class="sb-link">
            <div class="sb-icon"><i class="fab fa-whatsapp"></i></div>
            <span class="sb-text">Chat Admin</span>
        </a>
    </nav>
    <div class="sb-footer">
        <div class="sb-user">
            <div class="sb-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
            <div class="sb-text" style="overflow:hidden;">
                <div class="sb-user-name">{{ auth()->user()->name }}</div>
                <div class="sb-user-role">{{ auth()->user()->isAdmin() ? 'Administrator' : 'Siswa' }}</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="sb-logout">
                <div class="sb-icon"><i class="fas fa-power-off"></i></div>
                <span class="sb-text">Keluar</span>
            </button>
        </form>
    </div>
</aside>

{{-- ═══════════ MAIN ═══════════ --}}
<div class="main">
    <header class="topbar">
        <div class="topbar-left">
            <h1>{{ auth()->user()->isAdmin() ? 'Manajemen Pembayaran' : 'Pembayaran SPP' }}</h1>
            <p>{{ auth()->user()->isAdmin() ? 'Kelola dan verifikasi data pembayaran siswa.' : 'Riwayat dan status pembayaran SPP kamu.' }}</p>
        </div>
        <div class="topbar-right">
            <div class="pill dark"><i class="fas fa-calendar-days"></i> {{ date('d M Y') }}</div>
        </div>
    </header>

    <div class="body">

        @if(session('success'))
        <div class="alert-success-custom"><i class="fas fa-circle-check"></i> {{ session('success') }}</div>
        @endif

        <div class="page-header">
            <div class="ph-left">
                <h2>
                    <i class="fas fa-{{ auth()->user()->isAdmin() ? 'table-list' : 'receipt' }}" style="color:var(--accent); font-size:18px; margin-right:6px;"></i>
                    {{ auth()->user()->isAdmin() ? 'Data Pembayaran' : 'Riwayat Pembayaran' }}
                </h2>
                <p>{{ auth()->user()->isAdmin() ? 'Total '.$payments->total().' data pembayaran siswa.' : 'Pantau dan bayar tagihan SPP kamu di sini.' }}</p>
            </div>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('payments.create') }}" class="btn-primary-add">
                <i class="fas fa-plus"></i> Tambah Pembayaran
            </a>
            @endif
        </div>

        @if(auth()->user()->isAdmin())
        <div class="summary-row">
            <div class="sum-chip">
                <div class="sum-chip-icon" style="background:#eff6ff; color:var(--accent);"><i class="fas fa-layer-group"></i></div>
                <div><div class="sum-chip-val">{{ $payments->total() }}</div><div class="sum-chip-label">Total Data</div></div>
            </div>
            <div class="sum-chip">
                <div class="sum-chip-icon" style="background:var(--green-bg); color:var(--green);"><i class="fas fa-circle-check"></i></div>
                <div><div class="sum-chip-val" style="color:var(--green);">{{ $payments->where('status','paid')->count() }}</div><div class="sum-chip-label">Lunas</div></div>
            </div>
            <div class="sum-chip">
                <div class="sum-chip-icon" style="background:var(--amber-bg); color:var(--amber);"><i class="fas fa-clock"></i></div>
                <div><div class="sum-chip-val" style="color:var(--amber);">{{ $payments->where('status','unpaid')->count() }}</div><div class="sum-chip-label">Belum Bayar</div></div>
            </div>
        </div>
        @endif

        <div class="table-card">
            <div class="tc-head">
                <div>
                    <div class="tc-title">{{ auth()->user()->isAdmin() ? 'Semua Transaksi' : 'Transaksi Saya' }}</div>
                    <div class="tc-sub">
                        @if(!auth()->user()->isAdmin())
                            Klik <strong>Bayar</strong> pada tagihan yang belum dibayar.
                        @else
                            Klik baris untuk melihat detail pembayaran.
                        @endif
                    </div>
                </div>
            </div>

            <div style="overflow-x:auto;">
                <table class="dt">
                    <thead>
                        <tr>
                            <th>No</th>
                            @if(auth()->user()->isAdmin())<th>Siswa</th>@endif
                            <th>Tagihan</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        @php $s = strtolower($payment->status); $isRejected = $s === 'unpaid' && !empty($payment->catatan_reject); @endphp
                        <tr>
                            <td><div class="no-cell">{{ $loop->iteration }}</div></td>

                            @if(auth()->user()->isAdmin())
                            <td>
                                <div class="student-cell">
                                    <div class="student-avatar">{{ substr($payment->student->name ?? 'U', 0, 1) }}</div>
                                    <div class="student-name">{{ $payment->student->name ?? '-' }}</div>
                                </div>
                            </td>
                            @endif

                            {{-- Kolom Tagihan: tampilkan periode + keterangan + alasan tolak --}}
                            <td>
                                <div class="date-cell">
                                    <i class="fas fa-calendar-day" style="color:#94a3b8; font-size:11px; margin-right:5px;"></i>
                                    {{ $payment->type ? $payment->type.' · ' : '' }}{{ $payment->month }} {{ $payment->year }}
                                </div>
                                @if($payment->keterangan)
                                <div class="ket-tag">
                                    <i class="fas fa-tag" style="font-size:9px;"></i>
                                    {{ $payment->keterangan }}
                                </div>
                                @endif
                                @if(!auth()->user()->isAdmin() && $isRejected && $payment->catatan_reject)
                                <div class="reject-box">
                                    <i class="fas fa-circle-xmark"></i>
                                    <div>
                                        <div class="reject-box-label">Alasan Penolakan</div>
                                        <div class="reject-box-text">{{ $payment->catatan_reject }}</div>
                                    </div>
                                </div>
                                @endif
                            </td>

                            <td class="amount-cell">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>

                            <td>
                                @if($s === 'paid' || $s === 'approved')
                                    <span class="badge paid"><i class="fas fa-check-circle"></i> Lunas</span>
                                @elseif($s === 'pending')
                                    <span class="badge pending"><i class="fas fa-hourglass-half"></i> Menunggu</span>
                                @elseif($isRejected)
                                    <span class="badge rejected"><i class="fas fa-times-circle"></i> Ditolak</span>
                                @else
                                    <span class="badge unpaid"><i class="fas fa-clock"></i> Belum Bayar</span>
                                @endif
                            </td>

                            <td>
                                <div class="action-group">
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('payments.show', $payment->id) }}" class="btn-act info"><i class="fas fa-eye"></i> Detail</a>
                                        <a href="{{ route('payments.edit', $payment->id) }}" class="btn-act warn"><i class="fas fa-pen"></i> Edit</a>
                                        <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-act danger"><i class="fas fa-trash"></i> Hapus</button>
                                        </form>
                                    @else
                                        @if($s === 'paid' || $s === 'approved')
                                            <span style="font-size:11px; color:var(--green); font-weight:700;"><i class="fas fa-check"></i> Lunas</span>
                                        @elseif($s === 'pending')
                                            <span style="font-size:11px; color:var(--accent); font-weight:700;"><i class="fas fa-hourglass-half"></i> Menunggu verifikasi...</span>
                                        @elseif($isRejected)
                                            {{-- Upload ulang setelah ditolak --}}
                                            <button class="btn-act reupload"
                                                onclick="openPayModal(
                                                    {{ $payment->id }},
                                                    '{{ $payment->type ? $payment->type.' · ' : '' }}{{ $payment->month }} {{ $payment->year }}',
                                                    'Rp {{ number_format($payment->amount, 0, ',', '.') }}',
                                                    '{{ addslashes($payment->keterangan ?? '') }}'
                                                )">
                                                <i class="fas fa-rotate-right"></i> Upload Ulang
                                            </button>
                                        @else
                                            <button class="btn-act pay"
                                                onclick="openPayModal(
                                                    {{ $payment->id }},
                                                    '{{ $payment->type ? $payment->type.' · ' : '' }}{{ $payment->month }} {{ $payment->year }}',
                                                    'Rp {{ number_format($payment->amount, 0, ',', '.') }}',
                                                    '{{ addslashes($payment->keterangan ?? '') }}'
                                                )">
                                                <i class="fas fa-bolt"></i> Bayar
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() ? 6 : 5 }}">
                                <div class="empty">
                                    <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                                    <p>Tidak ada data pembayaran</p>
                                    <span>{{ auth()->user()->isAdmin() ? 'Tambahkan pembayaran baru.' : 'Data akan muncul setelah admin membuat tagihan.' }}</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($payments, 'hasPages') && $payments->hasPages())
            <div class="pagination-wrap">{{ $payments->links() }}</div>
            @endif
        </div>
    </div>
</div>

<script>
let currentStep = 1;
let selectedMetode = null;
let selectedBank = null;
let currentPaymentData = {};
let selectedFile = null;

function openPayModal(paymentId, month, amount, keterangan = '') {
    currentPaymentData = { paymentId, month, amount, keterangan };
    currentStep = 1;
    selectedMetode = null;
    selectedBank = null;
    selectedFile = null;

    document.querySelectorAll('.metode-card').forEach(c => c.classList.remove('selected'));
    document.querySelectorAll('.bank-chip').forEach(c => c.classList.remove('selected'));
    document.getElementById('bankSubPicker').style.display = 'none';
    document.getElementById('ewalletSubPicker').style.display = 'none';

    resetUploadArea();
    document.getElementById('buktiFile').value = '';
    document.getElementById('catatanBayar').value = '';

    document.getElementById('tagihanMonth').textContent = month;
    document.getElementById('tagihanAmount').textContent = amount;

    // Tampilkan keterangan jika ada
    const ketEl = document.getElementById('tagihanKeterangan');
    if (keterangan) {
        ketEl.textContent = '📌 ' + keterangan;
        ketEl.style.display = 'block';
    } else {
        ketEl.style.display = 'none';
    }

    renderStep();
    document.getElementById('payModal').classList.add('open');
}

function resetUploadArea() {
    const area = document.getElementById('uploadAreaMain');
    area.classList.remove('has-file');
    document.getElementById('uploadIcon').innerHTML = '<i class="fas fa-cloud-arrow-up"></i>';
    document.getElementById('uploadTitle').textContent = 'Klik atau drag file ke sini';
    document.getElementById('uploadTitle').style.color = '';
    document.getElementById('uploadDesc').textContent = 'JPG, PNG, PDF — Maks. 5MB';
}

function closePayModal() { document.getElementById('payModal').classList.remove('open'); }
function tutupModal(id) { document.getElementById(id).classList.remove('open'); }

document.getElementById('payModal').addEventListener('click', function(e) {
    if (e.target === this) closePayModal();
});

function stepNext() {
    if (currentStep === 1) {
        if (!selectedMetode) { showToast('error','Pilih metode','Pilih metode pembayaran terlebih dahulu'); return; }
        if ((selectedMetode === 'transfer' || selectedMetode === 'ewallet') && !selectedBank) {
            showToast('error','Pilih bank','Pilih bank/wallet tujuan terlebih dahulu'); return;
        }
    }
    if (currentStep === 3) {
        if (!selectedFile) { showToast('error','Upload dulu','Upload bukti transfer terlebih dahulu'); return; }
        submitBukti();
        return;
    }
    if (currentStep === 4) { closePayModal(); location.reload(); return; }
    currentStep++;
    renderStep();
}

function stepBack() { if (currentStep > 1) { currentStep--; renderStep(); } }

function renderStep() {
    ['step1','step2','step3','step4'].forEach((id,i) => {
        document.getElementById(id).style.display = i+1 === currentStep ? 'block' : 'none';
    });
    for (let i = 1; i <= 4; i++) {
        const el = document.getElementById('step-ind-'+i);
        el.className = 'step';
        if (i < currentStep) el.classList.add('done');
        else if (i === currentStep) el.classList.add('active');
    }
    const btnBack   = document.getElementById('btnBack');
    const btnNext   = document.getElementById('btnNext');
    const btnCancel = document.getElementById('btnCancel');
    btnBack.style.display   = currentStep > 1 && currentStep < 4 ? 'inline-flex' : 'none';
    btnCancel.style.display = currentStep === 4 ? 'none' : 'inline-flex';
    if (currentStep === 4) {
        btnNext.innerHTML = '<i class="fas fa-check"></i> Tutup';
        btnNext.disabled  = false;
    } else if (currentStep === 3) {
        btnNext.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Bukti';
        btnNext.disabled  = false;
    } else {
        btnNext.innerHTML = 'Lanjut <i class="fas fa-arrow-right"></i>';
        btnNext.disabled  = currentStep === 1 && (!selectedMetode || ((selectedMetode==='transfer'||selectedMetode==='ewallet') && !selectedBank));
    }
    if (currentStep === 2) {
        document.querySelectorAll('.instruksi-panel').forEach(p => p.classList.remove('show'));
        const panel = document.getElementById('instruksi-'+selectedMetode);
        if (panel) panel.classList.add('show');
        document.getElementById('qrisAmount').textContent      = currentPaymentData.amount;
        document.getElementById('qrisAmountInstr').textContent = currentPaymentData.amount;
    }
    if (currentStep === 3) {
        const metodeName = { transfer: 'Transfer Bank', va: 'Virtual Account', qris: 'QRIS', ewallet: 'E-Wallet' };
        const sub = selectedBank ? ` — ${selectedBank.name.toUpperCase()}` : '';
        document.getElementById('sumTagihan').textContent = currentPaymentData.month;
        document.getElementById('sumMetode').textContent  = (metodeName[selectedMetode] || selectedMetode) + sub;
        document.getElementById('sumTotal').textContent   = currentPaymentData.amount;
    }
}

function selectMetode(card, metode) {
    document.querySelectorAll('.metode-card').forEach(c => c.classList.remove('selected'));
    card.classList.add('selected');
    selectedMetode = metode;
    selectedBank   = null;
    document.getElementById('bankSubPicker').style.display    = metode === 'transfer' ? 'block' : 'none';
    document.getElementById('ewalletSubPicker').style.display = metode === 'ewallet'  ? 'block' : 'none';
    document.querySelectorAll('.bank-chip').forEach(c => c.classList.remove('selected'));
    document.getElementById('btnNext').disabled = metode === 'transfer' || metode === 'ewallet';
}

function selectBank(chip, bankKey, noRek, namaRek) {
    const parentId = selectedMetode === 'ewallet' ? 'ewalletSubPicker' : 'bankSubPicker';
    document.querySelectorAll('#'+parentId+' .bank-chip').forEach(c => c.classList.remove('selected'));
    chip.classList.add('selected');
    selectedBank = { name: bankKey, noRek, namaRek };
    if (selectedMetode === 'transfer') {
        document.getElementById('rekBank').textContent           = bankKey.toUpperCase();
        document.getElementById('rekNomor').textContent          = noRek;
        document.getElementById('rekNama').textContent           = 'a/n ' + namaRek;
        document.getElementById('instruksiBankName').textContent  = bankKey.toUpperCase();
        document.getElementById('instruksiBankName2').textContent = bankKey.toUpperCase();
        document.getElementById('instruksiBankNum').textContent   = noRek;
        document.getElementById('instruksiBankAmt').textContent   = currentPaymentData.amount;
    } else if (selectedMetode === 'ewallet') {
        document.getElementById('ewalletBankName').textContent     = bankKey.toUpperCase();
        document.getElementById('ewalletNomor').textContent        = noRek;
        document.getElementById('ewalletNama').textContent         = 'a/n ' + namaRek;
        document.getElementById('instruksiWalletName').textContent = bankKey.toUpperCase();
        document.getElementById('instruksiWalletApp').textContent  = bankKey.charAt(0).toUpperCase()+bankKey.slice(1);
        document.getElementById('instruksiWalletNum').textContent  = noRek;
        document.getElementById('instruksiWalletAmt').textContent  = currentPaymentData.amount;
    }
    document.getElementById('btnNext').disabled = false;
}

function copyRekening() { copyText(document.getElementById('rekNomor').textContent); }
function copyText(text) {
    navigator.clipboard.writeText(text).then(() => {
        showToast('success', 'Disalin!', text + ' berhasil disalin');
    });
}

function handleFile(input) {
    if (input.files && input.files.length > 0) {
        selectedFile = input.files[0];
        const area = document.getElementById('uploadAreaMain');
        area.classList.add('has-file');
        document.getElementById('uploadIcon').innerHTML   = '<i class="fas fa-file-check"></i>';
        document.getElementById('uploadTitle').textContent = selectedFile.name;
        document.getElementById('uploadTitle').style.color = 'var(--green)';
        document.getElementById('uploadDesc').textContent  = 'Siap diupload · ' + (selectedFile.size/1024/1024).toFixed(2) + ' MB';
    }
}

async function submitBukti() {
    const btn = document.getElementById('btnNext');
    if (!selectedFile) { showToast('error', 'Upload dulu', 'Upload bukti transfer terlebih dahulu'); return; }
    btn.disabled  = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('payment_id', currentPaymentData.paymentId);
    formData.append('proof', selectedFile);
    formData.append('payment_method', buildMetodeLabel());
    formData.append('catatan', document.getElementById('catatanBayar').value);
    try {
        const res  = await fetch('{{ route("siswa.upload-bukti") }}', { method: 'POST', body: formData });
        const data = await res.json();
        if (res.ok && data.success) {
            currentStep = 4;
            renderStep();
            showToast('success', 'Berhasil!', data.message);
        } else {
            showToast('error', 'Gagal', data.message || 'Terjadi kesalahan, coba lagi.');
            btn.disabled  = false;
            btn.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Bukti';
        }
    } catch (e) {
        showToast('error', 'Error', 'Koneksi gagal. Periksa internet kamu.');
        btn.disabled  = false;
        btn.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Bukti';
    }
}

function buildMetodeLabel() {
    const labels = { transfer: 'Transfer Bank', va: 'Virtual Account', qris: 'QRIS', ewallet: 'E-Wallet' };
    const base   = labels[selectedMetode] || selectedMetode;
    return selectedBank ? base + ' - ' + selectedBank.name.toUpperCase() : base;
}

function showToast(type, title, msg) {
    const icons = { success: 'fa-check', error: 'fa-times', info: 'fa-info' };
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `<div class="toast-icon ${type}"><i class="fas ${icons[type]}"></i></div><div class="toast-content"><p>${title}</p><span>${msg}</span></div>`;
    document.getElementById('toastContainer').appendChild(toast);
    setTimeout(() => { toast.classList.add('hide'); setTimeout(() => toast.remove(), 300); }, 3500);
}
</script>

@endsection