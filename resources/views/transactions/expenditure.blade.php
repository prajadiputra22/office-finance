@extends('layouts.app')

@section('title', 'Kas Keluar - ' . $category->category_name)

@section('content')
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-[#F20E0F]">{{ $category->category_name }}</h2>
        <p class="text-gray-600 mt-1">Kategori Kas Keluar</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 mb-8">
        <div class="bg-gradient-to-br from-[#F20E0F] to-[#ff3d2f] rounded-lg shadow-md p-6 text-white
        hover:shadow-lg hover:from-[#ff1f1f] hover:to-[#ff5a4f]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Total Transaksi</p>
                    <p class="text-3xl font-bold mt-2">{{ $recentTransactions->count() }}</p>
                </div>
                <i class="fas fa-list text-4xl opacity-30"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-[#F20E0F] to-[#ff3d2f] rounded-lg shadow-md p-6 text-white
         hover:shadow-lg hover:from-[#ff1f1f] hover:to-[#ff5a4f]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Total Pengeluaran</p>
                    <p class="text-2xl font-bold mt-2">Rp {{ number_format($recentTransactions->sum('amount'), 0, ',', '.') }}</p>
                </div>
                <i class="fas fa-arrow-down text-4xl opacity-30"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-[#F20E0F] to-[#ff3d2f] rounded-lg shadow-md p-6 text-white
         hover:shadow-lg hover:from-[#ff1f1f] hover:to-[#ff5a4f]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Rata-rata</p>
                    <p class="text-2xl font-bold mt-2">
                        Rp {{ $recentTransactions->count() > 0 ? number_format($recentTransactions->avg('amount'), 0, ',', '.') : '0' }}
                    </p>
                </div>
                <i class="fas fa-chart-line text-4xl opacity-30"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold text-[#F20E0F] mb-4">Transaksi per Metode Pembayaran</h3>
            <div class="flex justify-center items-center">
                {!! $chart->container() !!}
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold text-[#F20E0F] mb-4">Transaksi Terbaru</h3>
            <div class="overflow-x-auto">
                @if($recentTransactions->count() > 0)
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-2 text-sm font-semibold text-gray-700">Tanggal</th>
                                <th class="text-left py-3 px-2 text-sm font-semibold text-gray-700">Keterangan</th>
                                <th class="text-right py-3 px-2 text-sm font-semibold text-gray-700">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTransactions as $transaction)
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

    <div class="mt-4">
        <a href="{{ route('categories.expenditure.export', ['category_id' => $category->id]) }}"
           class="inline-flex items-center px-4 py-2 rounded-md bg-[#F20E0F] text-white hover:bg-[#ff1f1f] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F20E0F]">
            <i class="fas fa-file-excel mr-2"></i> Unduh Laporan Excel
        </a>
    </div>

@push('scripts')
<script src="{{ $chart->cdn() }}"></script>
{{ $chart->script() }}
@endpush
@endsection
