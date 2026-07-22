@extends('layouts.app')

@section('title', 'Laporan Pembayaran SPP - Travina Prima')

@push('styles')
<style>
    .page {
        padding: 28px 28px 40px;
        min-height: calc(100vh - 36px);
    }
    .topbar-card {
        border-radius: 16px;
        border: 1px solid rgba(148,163,184,.24);
        background: #ffffff;
        box-shadow: 0 10px 28px rgba(15,23,42,.06);
    }
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }
    .summary-card {
        border-radius: 22px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        padding: 22px 24px;
        box-shadow: 0 15px 35px rgba(15,23,42,.06);
    }
    .summary-card h3 {
        margin-bottom: 12px;
        font-size: 12px;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: #64748b;
    }
    .summary-value {
        font-size: 34px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 10px;
    }
    .summary-meta {
        font-size: 13px;
        color: #64748b;
        line-height: 1.7;
    }
    .table-card {
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 18px 48px rgba(15,23,42,.05);
    }
    .table-card .card-head {
        padding: 22px 24px;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
    }
    .table-card .card-head h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 800;
        color: #111827;
    }
    .table-responsive {
        overflow: auto;
    }
    .dt {
        width: 100%;
        min-width: 620px;
        border-collapse: collapse;
    }
    .dt th,
    .dt td {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        text-align: left;
        vertical-align: middle;
    }
    .dt th {
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
    }
    .dt td {
        color: #0f172a;
        font-size: 14px;
    }
    .dt tbody tr:hover {
        background: #f8fafc;
    }
    .status-chip {
        display: inline-flex;
        align-items: center;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .01em;
    }
    .status-paid { background: #dcfce7; color: #166534; }
    .status-approved { background: #dbeafe; color: #1d4ed8; }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-unpaid { background: #fee2e2; color: #991b1b; }
    .empty-state {
        padding: 42px 30px;
        text-align: center;
        color: #64748b;
        background: #f8fafc;
    }
    .empty-state h4 {
        margin-bottom: 10px;
        color: #0f172a;
        font-size: 16px;
    }
    @media(max-width: 900px) {
        .page { padding: 20px 18px 32px; }
    }
</style>
@endpush

@section('content')
<div class="app">
    @include('partials.sidebar')

    <div class="main">
        <div class="page">
            <div class="card topbar-card mb-4">
                <div class="card-body d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center">
                    <form method="GET" action="{{ route('payments.report') }}" class="d-flex gap-2 flex-wrap align-items-center">
                        <span style="font-size:11px;font-weight:700;color:#64748b;letter-spacing:.08em;text-transform:uppercase;">Tahun Laporan</span>
                        <select name="tahun" class="form-select" style="min-width: 170px; max-width: 220px;">
                            @foreach(range(date('Y'), date('Y') - 5) as $year)
                                <option value="{{ $year }}" {{ $year == $tahun ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-outline-secondary">Tampilkan</button>
                    </form>
                    <a href="{{ route('admin.payments') }}" class="btn btn-primary px-4">Kembali ke Pembayaran</a>
                </div>
            </div>

            <div class="summary-grid">
                <div class="summary-card">
                    <h3>Total Transaksi</h3>
                    <div class="summary-value">{{ $payments->count() }}</div>
                    <div class="summary-meta">Jumlah pembayaran terverifikasi di tahun {{ $tahun }}.</div>
                </div>
                <div class="summary-card">
                    <h3>Total Pemasukan</h3>
                    <div class="summary-value">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
                    <div class="summary-meta">Total pemasukan bersih dari pembayaran terverifikasi.</div>
                </div>
                <div class="summary-card">
                    <h3>Periode</h3>
                    <div class="summary-value">{{ $tahun }}</div>
                    <div class="summary-meta">Laporan ini hanya menampilkan pembayaran pada tahun pilihan.</div>
                </div>
            </div>

            <div class="table-card">
                <div class="card-head">
                    <h4>Daftar Pembayaran</h4>
                </div>
                @if($payments->isEmpty())
                    <div class="empty-state">
                        <h4>Tidak ada data pembayaran.</h4>
                        <p>Coba pilih tahun lain atau pastikan ada pembayaran yang terverifikasi.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="dt">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $index => $payment)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $payment->student->name ?? '-' }}</td>
                                        <td>{{ optional($payment->created_at)->format('d M Y') }}</td>
                                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                        <td><span class="status-chip status-{{ $payment->status }}">{{ ucfirst($payment->status) }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
