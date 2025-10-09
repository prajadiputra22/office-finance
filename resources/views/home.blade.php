@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <main class="flex-1 py-20">
        <section class="mb-8" aria-labelledby="saldo-title">
            <h2 id="saldo-title" class="sr-only">Informasi Saldo</h2>
            <div class="grid md:grid-cols-3 gap-6 mb-6">
                <article
                    class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full {{ ($balance ?? 0) >= 0 ? 'bg-green-100' : 'bg-red-100' }} mr-4">
                            <i class="fas fa-wallet {{ $balance >= 0 ? 'text-green-600' : 'text-red-600' }} text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-600 mb-1">Sisa Saldo</h3>
                            <p class="text-2xl font-bold {{ $balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                Rp {{ number_format($balance ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </article>

                <article
                    class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 mr-4">
                            <i class="fas fa-arrow-up text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-600 mb-1">Total Pemasukan</h3>
                            <p class="text-2xl font-bold text-blue-600">
                                Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </article>

                <article
                    class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 mr-4">
                            <i class="fas fa-arrow-down text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-600 mb-1">Total Pengeluaran</h3>
                            <p class="text-2xl font-bold text-red-600">
                                Rp {{ number_format($totalExpenditure ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <section class="mb-8" aria-labelledby="chart-title">
            <h2 id="chart-title" class="text-xl font-semibold mb-4 text-gray-800">Grafik Transaksi Bulanan</h2>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200" role="img"
                aria-label="Grafik Keuangan">
                <div class="mb-4">
                </div>
                {!! $chart->container() !!}
            </div>
        </section>

        <section class="bg-white border border-gray-200 p-6 rounded-xl shadow-sm" aria-labelledby="transaksi-title">
            <h2 id="transaksi-title" class="text-xl font-semibold mb-4 text-gray-800">Transaksi Terbaru</h2>

            @if (isset($recentTransactions) && $recentTransactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kategori
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tipe
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jumlah
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Keterangan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($recentTransactions as $transaction)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $transaction->category->category_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $transaction->type == 'income' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $transaction->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium 
                                {{ $transaction->type == 'income' ? 'text-blue-600' : 'text-red-600' }}">
                                        {{ $transaction->type == 'income' ? '+' : '-' }} Rp
                                        {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate"
                                        title="{{ $transaction->description ?? '-' }}">
                                        {{ $transaction->description ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 text-center">
                    <a href="{{ route('transactions.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i class="fas fa-list mr-2"></i>
                        Lihat Semua Transaksi
                    </a>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-receipt text-gray-400 text-5xl mb-4"></i>
                    <p class="text-gray-500 text-lg">Belum ada transaksi</p>
                    <p class="text-gray-400 text-sm mt-2">Transaksi yang Anda buat akan muncul di sini</p>
                </div>
            @endif
        </section>
    </main>

    @push('scripts')
        <script src="{{ $chart->cdn() }}"></script>
        {!! $chart->script() !!}
    @endpush
@endsection
