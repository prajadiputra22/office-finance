@extends('layouts.app')

@section('title', 'Laporan')

@section('header')
<header class="relative text-center mb-10">
    <h1 class="text-xl font-bold">
        Transaksi Bulan {{ $selectedMonthName }} {{ $selectedYear }}
    </h1>
    <div class="absolute right-0 top-0">
       <img src="{{ asset('assets/picture/logo.png') }}" 
        alt="Logo TigaJaya Finance"
        class="w-20 md:w-28 lg:w-28 h-auto object-contain"> 
    </div>
</header>
@endsection

@section('content')
 <div class="mb-8">
        <h3 class="font-semibold text-lg mb-1">Filter Laporan</h3>
        <form method="GET" action="{{ route('report.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1">
                <label for="month" class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                <select name="month" id="month"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B3B9F]">
                    @php
                        $months = [
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember',
                        ];
                    @endphp
                    @foreach ($months as $monthNum => $monthName)
                        <option value="{{ $monthNum }}"
                            {{ request('month', now()->month) == $monthNum ? 'selected' : '' }}>
                            {{ $monthName }}
                        </option>
                    @endforeach
                </select>
            </div>
        <div class="flex-1">
            <label for="year" class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
            <select name="year" id="year"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B3B9F]">
                @forelse ($availableYears as $y)
                    <option value="{{ $y }}" {{ request('year', now()->year) == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @empty
                    <option value="{{ now()->year }}" selected>{{ now()->year }}</option>
                @endforelse
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-[#0B3B9F] text-white rounded-lg text-sm font-semibold hover:bg-blue-800 transition">
                Terapkan Filter
            </button>
            <a href="{{ route('report.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-300 transition">
                Reset
            </a>
        </div>
    </form>
</div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl p-6 text-center shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
            <h2 class="font-semibold text-lg mb-4">Pemasukan Bulan {{ $selectedMonthName }} {{ $selectedYear }} </h2>
            <div class="bg-gray-100 py-3 rounded-lg text-xl font-bold text-blue-600 mb-4">
                @if ($income == 0)
                    <span class="text-gray-500">Belum ada pemasukan</span>
                @else
                    Rp {{ number_format($income, 0, ',', '.') }}
                @endif
            </div>
            <div style="min-height: 300px;">
                {!! $incomeChart->container() !!}
            </div>

            @if (isset($incomePercentages) && count($incomePercentages) > 0)
                <div class="mt-4 text-left">
                    <h3 class="font-semibold text-sm mb-2">Detail per Kategori:</h3>
                    @foreach ($incomePercentages as $item)
                        <div
                            class="flex justify-between items-center py-2 text-sm border-b border-gray-100 last:border-b-0">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full border-2 border-white shadow-sm"
                                    style="background-color: {{ $item['color'] }}"></div>
                                <span class="font-medium">{{ $item['category'] }}</span>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold text-green-600">{{ $item['percentage'] }}%</div>
                                <div class="text-xs text-gray-600">Rp {{ number_format($item['amount'], 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="bg-white rounded-xl p-6 text-center shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
            <h2 class="font-semibold text-lg mb-4">Pengeluaran Bulan {{ $selectedMonthName }} {{ $selectedYear }} </h2>
            <div class="bg-gray-100 py-3 rounded-lg text-xl font-bold text-red-600 mb-4">
                @if ($expenditure == 0)
                    <span class="text-gray-500">Belum ada pengeluaran</span>
                @else
                    -Rp {{ number_format($expenditure, 0, ',', '.') }}
                @endif
            </div>

            <div style="min-height: 300px;">
                {!! $expenditureChart->container() !!}
            </div>

            @if (isset($expenditurePercentages) && count($expenditurePercentages) > 0)
                <div class="mt-4 text-left">
                    <h3 class="font-semibold text-sm mb-2">Detail per Kategori:</h3>
                    @foreach ($expenditurePercentages as $item)
                        <div class="flex justify-between items-center py-2 text-sm border-b border-gray-100 last:border-b-0">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full border-2 border-white shadow-sm"
                                    style="background-color: {{ $item['color'] }}"></div>
                                <span class="font-medium">{{ $item['category'] }}</span>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold text-red-600">{{ $item['percentage'] }}%</div>
                                <div class="text-semibold text-gray-600">Rp {{ number_format($item['amount'], 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="mt-10">
        <a href="{{ route('reports.export', ['month' => request('month', now()->month), 'year' => request('year', now()->year)]) }}"
            class="inline-flex items-center gap-2 px-3 py-2 bg-white border-2 border-gray-200 rounded-lg text-sm font-semibold hover:bg-[#0B3B9F] hover:text-white hover:border-[#0B3B9F] transition">
            <img src="{{ asset('assets/picture/download.png') }}" alt="download" class="w-5 h-5 filter invert-0 hover:invert transition">
            Unduh Laporan Transaksi
        </a>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    {{ $incomeChart->script() }}
    {{ $expenditureChart->script() }}
@endpush