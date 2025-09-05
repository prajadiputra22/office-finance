@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<main class="flex-1 p-0" x-data="{ openAddTransaksi: false }">
    @section('header')
    <header class="flex justify-between items-center mb-8 flex-wrap gap-4 animate-fadeIn">
        <div class="relative flex-1 max-w-[600px] bg-white p-4 rounded-xl shadow">
            <svg class="absolute left-7 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-500" fill="none" stroke="currentColor">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input type="text" placeholder="Cari riwayat pemasukan yang ingin kamu cari"
            class="w-full pl-12 pr-4 py-2 border-2 border-[#e1e5e9] rounded-lg bg-[#f8f9fa] focus:border-[#84cc16] focus:bg-white outline-none text-sm">
        </div>
        <div class="ml-5 flex-shrink-0">
            <h1 class="text-2xl font-bold"> Office <span class="text-[#B6F500]">Finance</span></h1>
        </div>
    </header>
    @endsection
    
    <div class="flex gap-5 mb-8 flex-wrap animate-fadeIn">
        <button
        type="button"
        @click="openAddTransaksi = true"
        class="flex items-center px-6 py-4 bg-white border-2 border-[#e1e5e9] rounded-xl font-semibold text-gray-700 hover:bg-[#84cc16] hover:border-[#84cc16] hover:text-white hover-translate shadow">
            <span class="mr-2 font-bold text-xl">+</span>
            Tambahkan Pemasukan
        </button>
        
        <div class="flex gap-5 flex-1 flex-wrap">
            <div class="flex-1 p-6 bg-white border border-[#e1e5e9] rounded-xl shadow hover:shadow-lg transition animate-slideInLeft">
                <h3 class="text-[#6b7280] font-medium">Pemasukan</h3>
                <p class="text-[25px] font-bold text-[#1f2937]">{{'IDR'. number_format($income ?? 0, 0,',', '.') }}</p>
            </div>
            <div class="flex-1 p-6 bg-white border border-[#e1e5e9] rounded-xl shadow hover:shadow-lg transition animate-slideInLeft">
                <h3 class="text-[#6b7280] font-medium">Pengeluaran</h3>
                <p class="text-[25px] font-bold text-[#1f2937]">{{'IDR'. number_format($expenditure ?? 0, 0,',', '.') }}</p>
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
                        <th class="p-4 font-semibold text-[#333]">Jumlah</th>
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
                    <td class="p-4 font-semibold text-gray-800">
                        {{ 'IDR ' . number_format($trx->amount, 0, ',', '.') }} 
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
    <div 
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    x-show="openAddTransaksi"
    x-transition.opacity
    style="display: none;"
>
<div class="bg-white p-6 rounded-xl w-full max-w-md shadow-lg" @click.outside="openAddTransaksi = false">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Tambah Transaksi</h2>
        <button 
        type="button"
        class="text-gray-500 hover:text-gray-800"
        @click="openAddTransaksi = false">
        ✕
    </button>
</div>
<form action="{{ route('transaction.store') }}" method="POST">
    @csrf
    <div x-data="{ kategori: '' }">
        <div class="mb-3">
            <label class="block text-sm font-medium">Kategori</label>
            <select name="kategori" x-model="kategori"
            class="w-full p-2 border rounded focus:ring focus:ring-[#84cc16]">
            <option value="">-- Pilih Kategori --</option>
            <option value="keluar">Kas Keluar</option>
            <option value="masuk">Kas Masuk</option>
        </select>
    </div>
    <div class="mb-3" x-show="kategori === 'keluar'" x-transition>
        <label class="block text-sm font-medium">Sub Kategori (Kas Keluar)</label>
        <select name="subkategori" class="w-full p-2 border rounded focus:ring focus:ring-[#84cc16]">
            <option value="">-- Pilih Sub Kategori --</option>
            <option value="angsuran">Angsuran Perusahaan</option>
            <option value="hutang">Hutang Perusahaan</option>
            <option value="kasbesar">KAS Besar</option>
            <option value="kaskecil">KAS Kecil</option>
        </select>
    </div>
    <div class="mb-3" x-show="kategori === 'masuk'" x-transition>
        <label class="block text-sm font-medium">Sub Kategori (Kas Masuk)</label>
        <select name="subkategori" class="w-full p-2 border rounded focus:ring focus:ring-[#84cc16]">
            <option value="">-- Pilih Sub Kategori --</option>
            <option value="cvtiga">CV Tiga Jaya</option>
            <option value="sassu">SAS Sukabumi</option>
            <option value="saska">SAS Karawang</option>
        </select>
    </div>
</div>
<div class="mb-3">
    <label class="block text-sm font-medium">Status</label>
    <select name="type" class="w-full p-2 border rounded focus:ring focus:ring-[#84cc16]">
        <option value="income">Pemasukan</option>
        <option value="expenditure">Pengeluaran</option>
    </select>
</div>
<div class="mb-3">
    <label class="block text-sm font-medium">Jumlah</label>
    <input type="number" name="amount" class="w-full p-2 border rounded focus:ring focus:ring-[#84cc16]">
</div>
<div class="mb-3">
    <label class="block text-sm font-medium">Keterangan</label>
    <textarea name="description" class="w-full p-2 border rounded focus:ring focus:ring-[#84cc16]"></textarea>
</div>
<div class="flex justify-end gap-2 mt-4">
    <button type="reset" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
    <button type="button" 
    @click="openAddTransaksi = false" 
    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Simpan</button>
</div>
</form>
</div>
</div>
</main>
@endsection
