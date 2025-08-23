@extends('layouts.transaksi')

@section('title', 'Transaksi')

@section('content')
<header class="flex justify-between items-center mb-6 animate-fadeIn">
    <div class="relative flex-1 max-w-xl">
        <input type="text" placeholder="Cari riwayat pemasukan..." 
               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500">
        <svg class="w-5 h-5 text-gray-500 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.35-4.35"></path>
        </svg>
    </div>
    <div class="ml-4">
        <span class="text-2xl font-bold">Office <span class="text-lime-500">Finance</span></span>
    </div>
</header>

<div class="flex gap-4 mb-6 animate-fadeIn">
    <button class="flex items-center px-5 py-3 bg-white border border-gray-300 rounded-lg shadow hover:bg-lime-500 hover:text-white transition">
        <span class="mr-2 font-bold text-xl">+</span>
        Tambahkan Pemasukan
    </button>

    <div class="flex gap-4 flex-1">
        <div class="flex-1 p-4 bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg transition animate-slideInLeft">
            <h3 class="text-gray-500 font-medium">Pemasukan</h3>
            <p class="text-xl font-semibold text-gray-800">IDR 500.000.000</p>
        </div>
        <div class="flex-1 p-4 bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg transition animate-slideInLeft">
            <h3 class="text-gray-500 font-medium">Pengeluaran</h3>
            <p class="text-xl font-semibold text-gray-800">IDR 25.000.000</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-4 animate-fadeIn">
    <h2 class="text-lg font-semibold mb-4">Riwayat Transaksi</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full text-left border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Tanggal Transaksi</th>
                    <th class="px-4 py-2">Kategori</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Keterangan</th>
                    <th class="px-4 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t animate-slideInLeft">
                    <td class="px-4 py-2">27 Juli 2025</td>
                    <td class="px-4 py-2">CV Tiga Jaya</td>
                    <td class="px-4 py-2">
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">Pemasukan</span>
                    </td>
                    <td class="px-4 py-2"></td>
                    <td class="px-4 py-2 flex justify-end gap-2">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-sm">✎</button>
                        <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-sm">⃠</button>
                    </td>
                </tr>
                <tr class="border-t animate-slideInLeft">
                    <td class="px-4 py-2">31 Juli 2025</td>
                    <td class="px-4 py-2">Angsuran perusahaan</td>
                    <td class="px-4 py-2">
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">Pengeluaran</span>
                    </td>
                    <td class="px-4 py-2"></td>
                    <td class="px-4 py-2 flex justify-end gap-2">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-sm">✎</button>
                        <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-sm">⃠</button>
                    </td>
                </tr>
                <tr class="border-t animate-slideInLeft">
                    <td class="px-4 py-2">1 Agustus 2025</td>
                    <td class="px-4 py-2">KAS Kecil</td>
                    <td class="px-4 py-2">
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">Pengeluaran</span>
                    </td>
                    <td class="px-4 py-2"></td>
                    <td class="px-4 py-2 flex justify-end gap-2">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-sm">✎</button>
                        <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-sm">⃠</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
