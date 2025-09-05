@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<main class="flex-1 p-0">
    <section class="mb-8" aria-labelledby="saldo-title">
        <h2 id="saldo-title" class="sr-only">Informasi Saldo</h2>
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <article class="flex-1 bg-white p-5 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                <h3 class="text-base text-[#6b7280] mb-2 font-medium">Saldo Perusahaan</h3>
                <p class="text-[25px] font-bold text-[#1f2937]">{{ 'IDR ' . number_format($saldo ?? 0, 0,',', '.') }}</p>
            </article>
            <article class="flex-1 bg-white p-5 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                <h3 class="text-base text-[#6b7280] mb-2 font-medium">Saldo Giro</h3>
                <p class="text-[25px] font-bold text-[#1f2937]">{{ 'IDR ' . number_format($saldoGiro ?? 0, 0, ',', '.') }}</p>
            </article>
        </div>
    </section>
    <section class="mb-8" aria-labelledby="chart-title">
        <h2 id="chart-title" class="text-[20px] font-semibold mb-3 text-[#1f2937]">Grafik Keuangan Perusahaan</h2>
        <div class="bg-white p-6 rounded-xl shadow max-w-[1000px] mx-auto" role="img" aria-label="Grafik Keuangan">
            {!! $chart->container() !!}
        </div>
    </section>
    <section class="bg-white border-[#e5e7eb] p-6 rounded-xl shadow mt-8" aria-labelledby="transaksi-title">
        <h2 id="transaksi-title" class="text-[20px] font-semibold mb-3 text-center text-[#1f2937]">Transaksi Perusahaan</h2>
        <ul class="divide-y divide-gray-200">
            @forelse($recentTransactions ?? [] as $transaction)
            <li class="flex justify-between items-center py-3 border-b border-gray-100 last:border-b-0">
                <span class="text-base text-[#1f2937] font-medium">{{ $transaction['name'] }}</span>
                <span class="text-base font-semibold {{ $transaction['amount'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $transaction['amount'] >= 0 ? 'Rp ' : '-Rp ' }}{{ number_format(abs($transaction['amount']), 0, ',', '.') }}
                </span>
            </li>
            @empty
            <li class="font-medium text-gray-700">Belum ada transaksi</li>
            @endforelse
        </ul>
    </section>
</main>

@push('scripts')
<script src="{{ $chart->cdn() }}"></script>
{!! $chart->script() !!}

<script>
function dashboardData() {
    return {
        kasKeluarOpen: false,
        kasMasukOpen: false
    }
}
</script>
@endpush
@endsection
