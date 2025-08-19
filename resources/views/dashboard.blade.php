@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="flex min-h-screen" x-data="dashboardData()">
    <aside class="w-64 bg-gradient-to-b from-lime-400 to-lime-500 text-gray-800">
        <nav class="py-5" aria-label="Menu Utama">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center px-5 py-3 hover:bg-white/20 transition-colors duration-200" aria-current="page">
                        <img src="{{ asset('assets/picture/home.png') }}" alt="Home Icon" class="w-5 h-5 mr-3">
                        <span class="font-bold">Home</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('transactions.index') }}" class="flex items-center px-5 py-3 hover:bg-white/20 transition-colors duration-200">
                        <img src="{{ asset('assets/picture/transaction.png') }}" alt="Transaction Icon" class="w-5 h-5 mr-3">
                        <span class="font-bold">Transaksi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('categories.index') }}" class="flex items-center px-5 py-3 hover:bg-white/20 transition-colors duration-200">
                        <img src="{{ asset('assets/picture/category.png') }}" alt="Category Icon" class="w-5 h-5 mr-3">
                        <span class="font-bold">Kategori</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reports.index') }}" class="flex items-center px-5 py-3 hover:bg-white/20 transition-colors duration-200">
                        <img src="{{ asset('assets/picture/report.png') }}" alt="Report Icon" class="w-5 h-5 mr-3">
                        <span class="font-bold">Laporan</span>
                    </a>
                </li>
            </ul>
            
            <div class="mt-6">
                <button @click="kasKeluarOpen = !kasKeluarOpen" 
                        class="flex items-center justify-between w-full px-5 py-2 text-left font-semibold text-black hover:bg-white/20 transition-colors duration-200">
                    <span class="pl-8">Kas Keluar</span>
                    <svg class="w-4 h-4 transition-transform duration-300" 
                         :class="{ 'rotate-90': kasKeluarOpen }" 
                         fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div x-show="kasKeluarOpen" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="space-y-1">
                    <a href="{{ route('kas-keluar.angsuran') }}" class="block px-5 py-2 pl-16 text-sm text-gray-700 hover:bg-white/20 transition-colors duration-200">Angsuran Perusahaan</a>
                    <a href="{{ route('kas-keluar.hutang') }}" class="block px-5 py-2 pl-16 text-sm text-gray-700 hover:bg-white/20 transition-colors duration-200">Hutang Perusahaan</a>
                    <a href="{{ route('kas-keluar.besar') }}" class="block px-5 py-2 pl-16 text-sm text-gray-700 hover:bg-white/20 transition-colors duration-200">KAS Besar</a>
                    <a href="{{ route('kas-keluar.kecil') }}" class="block px-5 py-2 pl-16 text-sm text-gray-700 hover:bg-white/20 transition-colors duration-200">KAS Kecil</a>
                </div>
            </div>
            
            <!-- Kas Masuk Submenu -->
            <div class="mt-4">
                <button @click="kasMasukOpen = !kasMasukOpen" 
                        class="flex items-center justify-between w-full px-5 py-2 text-left font-semibold text-black hover:bg-white/20 transition-colors duration-200">
                    <span class="pl-8">Kas Masuk</span>
                    <svg class="w-4 h-4 transition-transform duration-300" 
                         :class="{ 'rotate-90': kasMasukOpen }" 
                         fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div x-show="kasMasukOpen" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="space-y-1">
                    <a href="{{ route('kas-masuk.cv-tiga-jaya') }}" class="block px-5 py-2 pl-16 text-sm text-gray-700 hover:bg-white/20 transition-colors duration-200">CV Tiga Jaya</a>
                    <a href="{{ route('kas-masuk.sas-sukabumi') }}" class="block px-5 py-2 pl-16 text-sm text-gray-700 hover:bg-white/20 transition-colors duration-200">SAS Sukabumi</a>
                    <a href="{{ route('kas-masuk.sas-karawang') }}" class="block px-5 py-2 pl-16 text-sm text-gray-700 hover:bg-white/20 transition-colors duration-200">SAS Karawang</a>
                </div>
            </div>
        </nav>
    </aside>

    <main class="flex-1 p-5 bg-gray-50">
        <header class="flex justify-end mb-8">
            <h1 class="text-2xl font-bold text-black">
                Office <span class="text-lime-400">Finance</span>
            </h1>
        </header>

        <section class="mb-8" aria-labelledby="saldo-title">
            <h2 id="saldo-title" class="sr-only">Informasi Saldo</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <article class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                    <h3 class="text-base text-gray-600 mb-2 font-medium">Saldo Perusahaan</h3>
                    <p class="text-xl font-bold text-gray-900">{{ 'IDR ' . number_format($saldoPerusahaan ?? 6240000000, 0, ',', '.') }}</p>
                </article>
                <article class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                    <h3 class="text-base text-gray-600 mb-2 font-medium">Saldo Giro</h3>
                    <p class="text-xl font-bold text-gray-900">{{ 'IDR ' . number_format($saldoGiro ?? 3400000000, 0, ',', '.') }}</p>
                </article>
            </div>
        </section>

        <section class="mb-12" aria-labelledby="chart-title">
            <h2 id="chart-title" class="text-xl font-semibold text-gray-900 mb-1">Grafik Keuangan Perusahaan</h2>
            <div class="bg-white p-5 rounded-xl shadow-sm max-w-4xl mx-auto" role="img" aria-label="Grafik Keuangan">
                {!! $chart->container() !!}
            </div>
        </section>

        <section class="bg-white p-5 rounded-xl shadow-sm border border-gray-200" aria-labelledby="transaksi-title">
            <h2 id="transaksi-title" class="text-xl font-semibold text-gray-900 mb-4 text-center">Transaksi Perusahaan</h2>
            <ul class="space-y-3">
                @forelse($transactions ?? [] as $transaction)
                <li class="flex justify-between items-center py-3 border-b border-gray-100 last:border-b-0">
                    <span class="text-base text-gray-900 font-medium">{{ $transaction['name'] }}</span>
                    <span class="text-base font-semibold {{ $transaction['amount'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $transaction['amount'] >= 0 ? 'Rp ' : '-Rp ' }}{{ number_format(abs($transaction['amount']), 0, ',', '.') }}
                    </span>
                </li>
                @empty
                <li class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-base text-gray-900 font-medium">CV Tiga Jaya</span>
                    <span class="text-base font-semibold text-green-600">Rp 176.000.000</span>
                </li>
                <li class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-base text-gray-900 font-medium">Kredit Mobil</span>
                    <span class="text-base font-semibold text-red-600">-Rp 100.000.000</span>
                </li>
                <li class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-base text-gray-900 font-medium">Hutang Supplier</span>
                    <span class="text-base font-semibold text-red-600">-Rp 30.000.000</span>
                </li>
                <li class="flex justify-between items-center py-3">
                    <span class="text-base text-gray-900 font-medium">SAS Sukabumi</span>
                    <span class="text-base font-semibold text-green-600">Rp 350.000.000</span>
                </li>
                @endforelse
            </ul>
        </section>
    </main>
</div>

{!! $chart->script() !!}
<script>
function dashboardData() {
    return {
        kasKeluarOpen: false,
        kasMasukOpen: false
    }
}
</script>
@endsection
