@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<main class="flex-1 p-0">
<header class="flex justify-between items-center mb-8 flex-wrap gap-4 animate-fadeIn">
    <div class="relative flex-1 max-w-[600px] bg-white p-4 rounded-xl shadow">
        <svg class="absolute left-10 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500" fill="none" stroke="currentColor">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.35-4.35"></path>
        </svg>
        <input type="text" placeholder="Cari riwayat pemasukan yang ingin kamu cari"
        class="w-full pl-12 pr-4 py-2 border-2 border-[#e1e5e9] rounded-lg bg-[#f8f9fa] focus:border-[#84cc16] focus:bg-white outline-none text-sm">
    </div>
    <div class="ml-5">
        <span class="text-2xl font-bold text-black">Office <span class="text-[#B6F500]">Finance</span></span>
    </div>
</header>

<div class="flex gap-5 mb-8 flex-wrap animate-fadeIn">
    <a href="{{ route('transaction.create') }}" class="flex items-center px-6 py-4 bg-white border-2 border-[#e1e5e9] rounded-xl font-semibold text-gray-700 hover:bg-[#84cc16] hover:border-[#84cc16] hover:text-white hover-translate shadow">
        <span class="mr-2 font-bold text-xl">+</span>
        Tambahkan Pemasukan
    </a>

    <div class="flex gap-5 flex-1 flex-wrap">
        <div class="flex-1 p-6 bg-white border border-[#e1e5e9] rounded-xl shadow hover:shadow-lg transition animate-slideInLeft">
            <h3 class="text-[#6b7280] font-medium">Pemasukan</h3>
            <p class="text-[25px] font-bold text-[#1f2937]">{{'IDR'. number_format($income ?? 0, 0,',', '.') }}</p>
        </div>
        <div class="flex-1 p-6 bg-white border border-[#e1e5e9] rounded-xl shadow hover:shadow-lg transition animate-slideInLeft">
            <h3 class="text-[#6b7280] font-medium">Pengeluaran</h3>
            <p class="text-[25px] font-bold text-[#1f2937]">{{'IDR'. number_format($income ?? 0, 0,',', '.') }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-6 animate-fadeIn">
    <h2 class="text-lg font-bold mb-5 text-[#333]">Riwayat Transaksi</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-left border border-[#e1e5e9] rounded-lg overflow-hidden text-sm">
            <thead class="bg-[#f8f9fa]">
                <tr>
                    <th class="p-4 font-semibold text-[#333]">Tanggal Transaksi</th>
                    <th class="p-4 font-semibold text-[#333]">Kategori</th>
                    <th class="p-4 font-semibold text-[#333]">Status</th>
                    <th class="p-4 font-semibold text-[#333]">Keterangan</th>
                    <th class="p-4 font-semibold text-[#333] text-right"></th>
                </tr>
            </thead>
            @foreach($transactions as $trx)
            <tr>
                <td class="p-4">{{ $trx->date }}</td>
                <td class="p-4">{{ $trx->customer }}</td>
                <td class="p-4">
                    <span class="{{ $trx->type == 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} px-3 py-1 rounded-full text-sm">
                        {{ $trx->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                    </span>
                </td>
                <td class="px-4 py-2">{{ $trx->description }}</td>
                <td class="px-4 py-2 flex justify-end gap-2">
                    <a href="{{ route('transaction.edit', $trx->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-sm">✎</a>
                    <form action="{{ route('transaction.destroy', $trx->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus?')">
                        @csrf
                        @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-sm">⃠</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection