@extends('layouts.app')

@section('title', 'Laporan Pembayaran')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">Laporan Pembayaran SPP</h1>
                    <p class="text-gray-600">Ringkasan lengkap pembayaran siswa</p>
                </div>
                <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Total Pembayaran</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $payments->count() }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Lunas</h3>
                <p class="text-3xl font-bold text-green-600">{{ $paidCount }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Lunas</h3>
                <p class="text-3xl font-bold text-red-600">{{ $unpaidCount }}</p>
            </div>
        </div>

        <!-- Total Amount -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 rounded-xl shadow-lg text-white mb-8">
            <h3 class="text-xl font-semibold mb-2">Total Dana Terkumpul</h3>
            <p class="text-4xl font-bold">Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
        </div>

        <!-- Payments Table -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold text-gray-800">Detail Pembayaran</h3>
                <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Laporan
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bulan</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($payments as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-6 whitespace-nowrap font-medium">{{ $payment->student->name }}</td>
                            <td class="py-4 px-6 whitespace-nowrap">{{ $payment->month }}</td>
                            <td class="py-4 px-6 whitespace-nowrap">{{ $payment->year }}</td>
                            <td class="py-4 px-6 whitespace-nowrap font-semibold text-green-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $payment->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $payment->status == 'paid' ? 'Lunas' : 'Belum Lunas' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection