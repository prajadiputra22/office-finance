@extends('layouts.app')

@section('title', 'Kas Keluar - ' . $category->category_name)

@section('header')
    <header class="relative text-left mb-10">
        <h1 class="text-3xl font-bold text-[#F20E0F]">
            {{ $category->category_name }}
        </h1>
        <div class="absolute right-0 top-0">
            <img src="{{ asset('assets/picture/logo.png') }}" alt="Logo TigaJaya Finance"
                class="w-20 md:w-28 lg:w-28 h-auto object-contain">
        </div>
    </header>
@endsection

@section('content')
    <div class="mb-6">
        <div class="flex justify-end items-center">
            <div class="flex items-center gap-2">
                <label for="yearFilter" class="text-sm font-medium text-gray-700">Filter Tahun :</label>
                <select id="yearFilter"
                    class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#0B3B9F]"
                    onchange="filterByYear(this.value)">
                    @foreach ($availableYears as $availableYear)
                        <option value="{{ $availableYear }}" {{ $availableYear == $year ? 'selected' : '' }}>
                            {{ $availableYear }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 mb-8">
        <div
            class="bg-gradient-to-br from-[#F20E0F] to-[#ff3d2f] rounded-lg shadow-md p-6 text-white
        hover:shadow-lg hover:from-[#ff1f1f] hover:to-[#ff5a4f]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Total Transaksi</p>
                    <p class="text-3xl font-bold mt-2">{{ $recentTransactions->count() }}</p>
                </div>
                <i class="fas fa-list text-4xl opacity-30"></i>
            </div>
        </div>

        <div
            class="bg-gradient-to-br from-[#F20E0F] to-[#ff3d2f] rounded-lg shadow-md p-6 text-white
         hover:shadow-lg hover:from-[#ff1f1f] hover:to-[#ff5a4f]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Total Pengeluaran</p>
                    <p class="text-2xl font-bold mt-2">Rp
                        {{ number_format($recentTransactions->sum('amount'), 0, ',', '.') }}</p>
                </div>
                <i class="fas fa-arrow-down text-4xl opacity-30"></i>
            </div>
        </div>

        <div
            class="bg-gradient-to-br from-[#F20E0F] to-[#ff3d2f] rounded-lg shadow-md p-6 text-white
         hover:shadow-lg hover:from-[#ff1f1f] hover:to-[#ff5a4f]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Rata-rata</p>
                    <p class="text-2xl font-bold mt-2">
                        Rp
                        {{ $recentTransactions->count() > 0 ? number_format($recentTransactions->avg('amount'), 0, ',', '.') : '0' }}
                    </p>
                </div>
                <i class="fas fa-chart-line text-4xl opacity-30"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl text-center font-semibold text-[#F20E0F] mb-4">Transaksi per Bulan Tahun {{ $year }}
            </h3>
            <div class="w-full overflow-hidden">
                <div class="chart-responsive-wrapper">
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold text-[#F20E0F] mb-4">Transaksi Terbaru</h3>
            <div class="overflow-x-auto">
                @if ($recentTransactions->count() > 0)
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-2 text-sm font-semibold text-gray-700">Tanggal</th>
                                <th class="text-left py-3 px-2 text-sm font-semibold text-gray-700">Keterangan</th>
                                <th class="text-right py-3 px-2 text-sm font-semibold text-gray-700">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentTransactions as $transaction)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="py-3 px-2 text-sm text-gray-600">
                                        {{ $transaction->date ? $transaction->date->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="py-3 px-2">
                                        <div class="text-sm font-medium text-gray-800">
                                            {{ $transaction->description ?? '-' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ ucfirst($transaction->payment ?? 'Tidak Diketahui') }}
                                        </div>
                                    </td>
                                    <td class="py-3 px-2 text-right text-sm font-semibold text-[#F20E0F]">
                                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3"></i>
                        <p>Belum ada transaksi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-10">
        <a href="{{ route('categories.expenditure.export', ['slug' => $category->slug, 'year' => $year]) }}"
            class="inline-flex items-center gap-2 px-3 py-2 bg-white border-2 border-gray-200 rounded-lg text-sm font-semibold hover:bg-[#F20E0F] hover:text-white hover:border-[#F20E0F] transition">
            <img src="{{ asset('assets/picture/download.png') }}" alt="download"
                class="w-5 h-5 filter invert-0 hover:invert transition">
            Unduh laporan {{ $category->category_name }} Tahun {{ $year }}
        </a>
    </div>

    @push('scripts')
        <script src="{{ $chart->cdn() }}"></script>
        {{ $chart->script() }}

        <script src="{{ $chart->cdn() }}"></script>
        {{ $chart->script() }}

        <script>
            function filterByYear(selectedYear) {
                const slug = '{{ $category->slug }}';

                if (!slug) {
                    alert('Kategori tidak ditemukan. Silakan pilih kategori terlebih dahulu.');
                    return;
                }

                window.location.href = `{{ route('category.expenditure', ['slug' => ':slug']) }}`.replace(':slug', slug) +
                    `?year=${selectedYear}`;
            }
        </script>
    @endpush
@endsection