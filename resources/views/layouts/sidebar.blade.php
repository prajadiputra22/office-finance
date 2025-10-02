<aside class="fixed top-0 left-0 w-[250px] h-screen bg-[#0B3B9F] text-white p-5 flex flex-col shadow-md overflow-y-auto">
    <nav class="space-y-2">

        <a href="{{ route('home') }}" class="flex items-center p-2 rounded hover:text-[#F20E0F] cursor-pointer transition group">
            <img src="{{ asset('assets/picture/home.png') }}" alt="Home Icon"
                class="w-5 h-5 mr-3 filter invert brightness-0 duration-300 group-hover:invert group-hover:red group-hover:saturate-200 group-hover:hue-rotate-0 group-hover:brightness-100 group-hover:contrast-200">
            <span class="font-medium">Home</span>
        </a>

        <a href="{{ route('transactions.index') }}" class="flex items-center p-2 rounded hover:text-[#F20E0F] cursor-pointer transition">
            <img src="{{ asset('assets/picture/transaction.png') }}" alt="Transaction Icon"
                class="w-5 h-5 mr-3 filter invert brightness-0">
            <span class="font-medium">Transaksi</span>
        </a>

        <a href="{{ route('category.index') }}" class="flex items-center p-2 rounded hover:text-[#F20E0F] cursor-pointer transition">
            <img src="{{ asset('assets/picture/category.png') }}" alt="Category Icon"
                class="w-5 h-5 mr-3 filter invert brightness-0">
            <span class="font-medium">Kategori</span>
        </a>

        <a href="{{ route('report') }}" class="flex items-center p-2 rounded hover:text-[#F20E0F] cursor-pointer transition">
            <img src="{{ asset('assets/picture/report.png') }}" alt="Report Icon"
                class="w-5 h-5 mr-3 filter invert brightness-0">
            <span class="font-bold">Laporan</span>
        </a>

        {{-- Kas Masuk --}} 
        <div class="mt-6" x-data="{ open: true }">
            <div class="mt-2" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center justify-between w-full p-2 rounded hover:text-[#F20E0F] text-left transition">
                    <span class="font-sm">Kas Masuk</span>
                    <i :class="open ? 'fa fa-chevron-up' : 'fa fa-chevron-down'" class="text-sm"></i>
                </button>
                <div x-show="open" x-transition class="ml-4 space-y-1">
                    @if(isset($sidebarIncomeCategories) && $sidebarIncomeCategories->count() > 0)
                        @foreach($sidebarIncomeCategories as $category)
                            <a href="{{ route('category.income', ['category_id' => $category->id]) }}" 
                               class="block text-sm text-gray-200 py-1 cursor-pointer hover:text-[#F20E0F] transition">
                                {{ $category->category_name }}
                            </a>
                        @endforeach
                    @else
                        <div class="text-sm text-gray-400 py-1">Belum ada kategori kas masuk</div>
                    @endif
                </div>
            </div>

            {{-- Kas Keluar --}} 
            <div class="mt-2" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center justify-between w-full p-2 rounded hover:text-[#F20E0F] text-left transition">
                    <span class="font-sm">Kas Keluar</span>
                    <i :class="open ? 'fa fa-chevron-up' : 'fa fa-chevron-down'" class="text-sm"></i>
                </button>
                <div x-show="open" x-transition class="ml-4 space-y-1">
                    
                    @if(isset($sidebarExpenditureCategories) && $sidebarExpenditureCategories->count() > 0)
                        @foreach($sidebarExpenditureCategories as $category)
                            <a href="{{ route('category.expenditure', ['category_id' => $category->id]) }}" 
                               class="block text-sm text-gray-200 py-1 cursor-pointer hover:text-[#F20E0F] transition">
                                {{ $category->category_name }}
                            </a>
                        @endforeach
                    @else
                        <div class="text-sm text-gray-400 py-1">Belum ada kategori kas keluar</div>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</aside>
