@extends('layouts.app')

@section('title', 'Kas Masuk - ' . $category->category_name)

@section('header')
<header class="relative text-left mb-6 md:mb-10">
    <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-[#F20E0F]">
        {{ $category->category_name }}
    </h1>
    <div class="absolute right-0 top-0">
       <img src="{{ asset('assets/picture/logo.png') }}" 
        alt="Logo TigaJaya Finance"
        class="w-16 md:w-24 lg:w-28 h-auto object-contain"> 
    </div>
</header>
@endsection

@section('content')
    <div class="mb-4 md:mb-6">
        <div class="md:hidden flex items-end gap-2 mb-4">
            <div class="flex-1">
                <label for="categoryFilter" class="block text-xs font-medium text-gray-700 mb-1">Kategori :</label>
                <select id="categoryFilter" class="w-full px-2 py-2 border border-gray-300 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-[#F20E0F]" 
                    onchange="filterByCategory(this.value)">
                    @if(isset($sidebarExpenditureCategories) && $sidebarExpenditureCategories->count() > 0)
                        <optgroup label="Kas Keluar">
                            @foreach($sidebarExpenditureCategories as $cat)
                                <option value="{{ $cat->id }}" {{ $category->id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->category_name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endif
                </select>
            </div>
            <div class="flex-1">
                <label for="yearFilter" class="block text-xs font-medium text-gray-700 mb-1">Tahun :</label>
                <select id="yearFilter" class="w-full px-2 py-2 border border-gray-300 rounded-md text-xs focus:outline-none focus:ring-2 focus:ring-[#F20E0F]" 
                    onchange="filterByYear(this.value)">
                    @foreach($availableYears as $availableYear)
                        <option value="{{ $availableYear }}" {{ $availableYear == $year ? 'selected' : '' }}>
                            {{ $availableYear }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="hidden md:flex justify-end items-center">
            <div class="flex items-center gap-2 flex-col sm:flex-row sm:gap-3">
                <label for="yearFilterDesktop" class="text-xs sm:text-sm font-medium text-gray-700">Tahun :</label>
                <select id="yearFilterDesktop" class="px-2 sm:px-3 py-2 border border-gray-300 rounded-md text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#F20E0F]" 
                    onchange="filterByYear(this.value)">
                    @foreach($availableYears as $availableYear)
                        <option value="{{ $availableYear }}" {{ $availableYear == $year ? 'selected' : '' }}>
                            {{ $availableYear }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6 mt-4 md:mt-6 mb-6 md:mb-8">
        <div class="bg-gradient-to-br from-[#F20E0F] to-[#ff3d2f] rounded-lg shadow-md p-4 md:p-6 text-white
        hover:shadow-lg hover:from-[#ff1f1f] hover:to-[#ff5a4f] transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm opacity-90">Total Transaksi</p>
                    <p class="text-xl md:text-3xl font-bold mt-1 md:mt-2">{{ $recentTransactions->count() }}</p>
                </div>
                <i class="fas fa-list text-2xl md:text-4xl opacity-30"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-[#F20E0F] to-[#ff3d2f] rounded-lg shadow-md p-4 md:p-6 text-white
        hover:shadow-lg hover:from-[#ff1f1f] hover:to-[#ff5a4f] transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm opacity-90">Total Pengeluaran</p>
                    <p class="text-lg md:text-2xl font-bold mt-1 md:mt-2">Rp {{ number_format($recentTransactions->sum('amount'), 0, ',', '.') }}</p>
                </div>
                <i class="fas fa-arrow-up text-2xl md:text-4xl opacity-30"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-[#F20E0F] to-[#ff3d2f] rounded-lg shadow-md p-4 md:p-6 text-white
        hover:shadow-lg hover:from-[#ff1f1f] hover:to-[#ff5a4f] transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm opacity-90">Rata-rata</p>
                    <p class="text-lg md:text-2xl font-bold mt-1 md:mt-2">
                        Rp {{ $recentTransactions->count() > 0 ? number_format($recentTransactions->avg('amount'), 0, ',', '.') : '0' }}
                    </p>
                </div>
                <i class="fas fa-chart-line text-2xl md:text-4xl opacity-30"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
        <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
            <h3 class="text-lg md:text-xl text-center font-semibold text-[#F20E0F] mb-4">Transaksi per Bulan Tahun {{ $year }}</h3>
            <div class="w-full overflow-auto">
                <div class="chart-responsive-wrapper min-h-[300px] md:min-h-[400px]">
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
            <h3 class="text-lg md:text-xl font-semibold text-[#F20E0F] mb-4">Transaksi Terbaru</h3>
            
            @if($recentTransactions->count() > 0)
                <div class="overflow-x-auto hidden sm:block">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-2 text-xs sm:text-sm font-semibold text-gray-700">Tanggal</th>
                                <th class="text-left py-3 px-2 text-xs sm:text-sm font-semibold text-gray-700">Keterangan</th>
                                <th class="text-right py-3 px-2 text-xs sm:text-sm font-semibold text-gray-700">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTransactions as $transaction)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="py-3 px-2 text-xs sm:text-sm text-gray-600">
                                        {{ $transaction->date ? $transaction->date->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="py-3 px-2">
                                        <div class="text-xs sm:text-sm font-medium text-gray-800">
                                            {{ $transaction->description ?? '-' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ ucfirst($transaction->payment ?? 'Tidak Diketahui') }}
                                        </div>
                                    </td>
                                    <td class="py-3 px-2 text-right text-xs sm:text-sm font-semibold text-[#F20E0F]">
                                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="space-y-3 sm:hidden">
                    @foreach($recentTransactions as $transaction)
                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-200 hover:border-[#F20E0F] transition">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="text-xs text-gray-500">{{ $transaction->date ? $transaction->date->format('d/m/Y') : '-' }}</p>
                                    <p class="text-sm font-medium text-gray-800">{{ $transaction->description ?? '-' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-[#F20E0F]">
                                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ ucfirst($transaction->payment ?? 'Tidak Diketahui') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-3xl md:text-4xl mb-3"></i>
                    <p class="text-sm md:text-base">Belum ada transaksi</p>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-6 md:mt-10">
        <a href="{{ route('categories.income.export', ['category_id' => $category->id, 'year' => $year]) }}"
            class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-3 sm:px-4 py-2 sm:py-3 bg-white border-2 border-gray-200 rounded-lg text-xs sm:text-sm font-semibold hover:bg-[#F20E0F] hover:text-white hover:border-[#F20E0F] transition">
            <img src="{{ asset('assets/picture/download.png') }}" alt="download" class="w-4 sm:w-5 h-4 sm:h-5 filter invert-0 hover:invert transition">
            <span class="truncate">Unduh laporan {{ $category->category_name }} Tahun {{ $year }}</span>
        </a>
    </div>

@push('scripts')
<script src="{{ $chart->cdn() }}"></script>
{{ $chart->script() }}

<script>
    function filterByYear(selectedYear) {
        const categoryId = new URLSearchParams(window.location.search).get('category_id') || {{ $category->id }};
        window.location.href = `{{ route('category.expenditure') }}?category_id=${categoryId}&year=${selectedYear}`;
    }

    function filterByCategory(categoryId) {
        if (!categoryId) {
            alert('Pilih kategori terlebih dahulu.');
            return;
        }
        
        const year = new URLSearchParams(window.location.search).get('year') || {{ $year }};
        window.location.href = `{{ route('category.expenditure') }}?category_id=${categoryId}&year=${year}`;
    }
</script>
@endpush
@endsection