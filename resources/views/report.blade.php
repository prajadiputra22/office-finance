@extends('layouts.app')

@section('title', 'Laporan')

@section('header')
<header class="relative text-center mb-10">
    <h1 class="text-xl font-bold">Transaksi setiap bulan</h1>
    <h2 class="absolute right-0 top-0 text-2xl font-bold text-[#F20E0F]">
        TigaJaya <span class="text-[#0B3B9F]">Finance</span>
    </h2>
</header>
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div class="bg-white rounded-xl p-6 text-center shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
            <h2 class="font-semibold text-lg mb-4">Pemasukan setiap bulan</h2>
            <div class="bg-gray-100 py-3 rounded-lg text-xl font-bold text-blue-600 mb-4">
                @if ($income == 0)
                    <span class="text-gray-500">Belum ada pemasukan</span>
                @else
                    Rp {{ number_format($income, 0, ',', '.') }}
                @endif
            </div>
            {!! $incomeChart->container() !!}
        </div>

        <div class="bg-white rounded-xl p-6 text-center shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
            <h2 class="font-semibold text-lg mb-4">Pengeluaran setiap bulan</h2>
            <div class="bg-gray-100 py-3 rounded-lg text-xl font-bold text-red-600 mb-4">
                @if ($expenditure == 0)
                    <span class="text-gray-500">Belum ada pengeluaran</span>
                @else
                    -Rp {{ number_format($expenditure, 0, ',', '.') }}
                @endif
            </div>
            {!! $expenditureChart->container() !!}
        </div>
    </div>

    <div class="mt-10">
        <button class="flex items-center gap-2 px-3 py-2 bg-white border-2 border-gray-200 rounded-lg text-sm font-semibold hover:bg-[#0B3B9F] hover:text-white hover:border-[#0B3B9F] transition">
            <img src="{{ asset('assets/picture/download.png') }}" alt="download" class="w-5 h-5 filter invert-0 hover:invert transition">
            Unduh laporan
        </button>
    </div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    {{ $incomeChart->script() }}
    {{ $expenditureChart->script() }}
    @endpush
@endsection
