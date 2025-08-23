@extends('layouts.kategori')

@section('title', 'Kategori')

@section('content')
<header class="flex justify-end mb-6 animate-fadeIn">
    <h1 class="text-2xl font-bold">
        Office <span class="text-lime-500">Finance</span>
    </h1>
</header>

<section class="mb-6 animate-fadeIn">
    <button class="flex items-center px-5 py-3 bg-white border border-gray-300 rounded-lg shadow hover:bg-lime-500 hover:text-white transition">
        <span class="mr-2 font-bold text-xl">+</span>
        Tambah Kategori Pemasukan
    </button>
</section>

<section>
    <h2 class="text-2xl font-semibold text-center mb-6 animate-fadeIn">
        Daftar Kategori
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="animate-slideInUp">
            <h3 class="text-lg font-semibold text-center mb-4">Pemasukan</h3>
            <table class="w-full bg-white rounded-lg shadow border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Sumber Pemasukan</th>
                        <th class="px-4 py-2 text-left">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">CV Tiga Jaya</td>
                        <td class="px-4 py-2 text-green-600 font-semibold">IDR 100.000.000</td>
                    </tr>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">CV Tiga Jaya</td>
                        <td class="px-4 py-2 text-green-600 font-semibold">IDR 100.000.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="animate-slideInUp">
            <h3 class="text-lg font-semibold text-center mb-4">Pengeluaran</h3>
            <table class="w-full bg-white rounded-lg shadow border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Sumber Pengeluaran</th>
                        <th class="px-4 py-2 text-left">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">Angsuran Perusahaan</td>
                        <td class="px-4 py-2 text-red-600 font-semibold">IDR 100.000.000</td>
                    </tr>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">Angsuran Perusahaan</td>
                        <td class="px-4 py-2 text-red-600 font-semibold">IDR 100.000.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
