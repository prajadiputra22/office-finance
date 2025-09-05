@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
<main class="flex-1 p-0" x-data="{ openAddKategori: false }">
    <section class="flex justify-between items-center gap-4 mb-8 flex-wrap">
        <button
        type="button"
        @click="openAddKategori = true"
        class="flex items-center px-6 py-4 bg-white border-2 border-[#e1e5e9] rounded-xl font-semibold text-gray-700 hover:bg-[#84cc16] hover:border-[#84cc16] hover:text-white hover-translate shadow">
        <span class="mr-2 font-bold text-xl">+</span>
        Tambah Kategori Pemasukan
    </button>
    
    <div class="flex gap-2">
        <input type="text" placeholder="Cari kategori..." class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:border-lime-500 focus:ring focus:ring-lime-200">
        <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:border-lime-500 focus:ring focus:ring-lime-200">
            <option value="">Filter</option>
            <option value="income">Pemasukan</option>
            <option value="expenditure">Pengeluaran</option>
            <option value="terbaru">Terbaru</option>
            <option value="terlama">Terlama</option>
        </select>
    </div>
</section>

<section>
    <h2 class="text-2xl font-semibold text-center mt-12 mb-8 animate-fadeIn">Daftar Kategori</h2>
    <div class="bg-white rounded-xl shadow p-5">
        <table class="w-full border-collapse text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left font-bold">Kategori</th>
                    <th class="px-4 py-3 text-left font-bold">Tipe</th>
                    <th class="px-4 py-3 font-bold">Edit</th>
                    <th class="px-4 py-3 font-bold">Delete</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($categories as $category)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $category->category_name }}</td>
                    <td class="px-4 py-3">
                        @if($category->type === 'income')
                        <span class="text-green-600 font-semibold">Pemasukan</span>
                        @else
                        <span class="text-red-600 font-semibold">Pengeluaran</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('categories.edit', $category->id) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-2.5 py-2 rounded text-base">
                            ✎
                        </a>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-base">
                                 ⃠
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
<div 
class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
x-show="openAddKategori"
x-transition.opacity
style="display: none;"
>
<div class="bg-white p-6 rounded-xl w-full max-w-md shadow-lg" @click.outside="openAddKategori = false">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Tambah Kategori</h2>
        <button 
        type="button"
        class="text-gray-500 hover:text-gray-800"
        @click="openAddKategori = false">
        ✕
    </button>
</div>
<form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <div x-data="{ category: '' }">
        <div class="mb-3">
            <label class="block text-sm font-medium">Kategori</label>
            <select name="category" x-model="category"
            class="w-full p-2 border rounded focus:ring focus:ring-[#84cc16]">
            <option value="">-- Pilih Kategori --</option>
            <option value="keluar">Kas Keluar</option>
            <option value="masuk">Kas Masuk</option>
        </select>
    </div>
    <div class="mb-3" x-show="category === 'keluar'" x-transition>
        <label class="block text-sm font-medium">Sub Kategori (Kas Keluar)</label>
        <select name="subcategory" class="w-full p-2 border rounded focus:ring focus:ring-[#84cc16]">
            <option value="">-- Pilih Sub Kategori --</option>
            <option value="angsuran">Angsuran Perusahaan</option>
            <option value="hutang">Hutang Perusahaan</option>
            <option value="kasbesar">KAS Besar</option>
            <option value="kaskecil">KAS Kecil</option>
        </select>
    </div>
    <div class="mb-3" x-show="category === 'masuk'" x-transition>
        <label class="block text-sm font-medium">Sub Kategori (Kas Masuk)</label>
        <select name="subcategory" class="w-full p-2 border rounded focus:ring focus:ring-[#84cc16]">
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
<div class="flex justify-end gap-2 mt-4">
    <button type="reset" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
    <button type="button" 
    @click="openAddKategori = false" 
    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Simpan</button>
</div>
</form>
</div>
</div>
</main>
@endsection
