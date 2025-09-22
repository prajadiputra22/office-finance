@extends('layouts.app')

@section('title', 'Laporan')

@section('header')
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
        
        <div class="bg-white rounded-xl p-6 text-center shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
            <h2 class="font-semibold text-lg mb-4">Pemasukan per Kategori</h2>
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
            
            @if(isset($incomePercentages) && count($incomePercentages) > 0)
                <div class="mt-4 text-left">
                    <h3 class="font-semibold text-sm mb-2">Detail per Kategori:</h3>
                    @foreach($incomePercentages as $item)
                        <div class="flex justify-between items-center py-2 text-sm border-b border-gray-100 last:border-b-0">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full border-2 border-white shadow-sm" 
                                     style="background-color: {{ $item['color'] }}"></div>
                                <span class="font-medium">{{ $item['category'] }}</span>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold text-green-600">{{ $item['percentage'] }}%</div>
                                <div class="text-xs text-gray-600">Rp {{ number_format($item['amount'], 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="bg-white rounded-xl p-6 text-center shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
            <h2 class="font-semibold text-lg mb-4">Pengeluaran per Kategori</h2>
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
            
            @if(isset($expenditurePercentages) && count($expenditurePercentages) > 0)
                <div class="mt-4 text-left">
                    <h3 class="font-semibold text-sm mb-2">Detail per Kategori:</h3>
                    @foreach($expenditurePercentages as $item)
                        <div class="flex justify-between items-center py-2 text-sm border-b border-gray-100 last:border-b-0">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full border-2 border-white shadow-sm" 
                                     style="background-color: {{ $item['color'] }}"></div>
                                <span class="font-medium">{{ $item['category'] }}</span>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold text-red-600">{{ $item['percentage'] }}%</div>
                                <div class="text-xs text-gray-600">Rp {{ number_format($item['amount'], 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="mt-10">
        <button class="flex items-center gap-2 px-3 py-2 bg-white border-2 border-gray-200 rounded-lg text-sm font-semibold hover:bg-[#0B3B9F] hover:text-white hover:border-[#0B3B9F] transition">
            <img src="{{ asset('assets/picture/download.png') }}" alt="download" class="w-5 h-5 filter invert-0 hover:invert transition">
            Unduh laporan
        </button>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
{!! $incomeChart->script() !!}
{!! $expenditureChart->script() !!}
@endpush
