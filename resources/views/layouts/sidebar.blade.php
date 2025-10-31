<aside class="w-[200px] bg-[#0B3B9F] text-white p-5 flex flex-col shadow-md overflow-y-auto">
    <nav>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('home') }}"
                class="flex items-center p-3 mb-2 rounded-lg hover:text-[#F20E0F] cursor-pointer transition group
                {{ request()->is('home') ? 'bg-white/30 font-bold' : 'hover:bg-white/20 transition transform hover:translate-x-1' }}">
                 <img src="{{ asset('assets/picture/home.png') }}" alt="Home Icon" class="w-5 h-5 mr-3 filter invert brightness-0">
                 <span class="font-bold">Beranda</span>
                </a>
            </li>
            <li>
                <a href="{{ route('transactions.index') }}" 
                class="flex items-center p-3 mb-2 rounded-lg hover:text-[#F20E0F] cursor-pointer transition group
                {{ request()->is('transactions') ? 'bg-white/30 font-bold' : 'hover:bg-white/20 transition transform hover:translate-x-1' }}">
                 <img src="{{ asset('assets/picture/transaction.png') }}" alt="Transaction Icon" class="w-5 h-5 mr-3 filter invert brightness-0 ">
                 <span class="font-bold">Transaksi</span>
                </a>
            </li>
            <li>
                <a href="{{ route('category.index') }}" 
                class="flex items-center p-3 mb-2 rounded-lg hover:text-[#F20E0F] cursor-pointer transition group
                {{ request()->is('category') ? 'bg-white/30 font-bold' : 'hover:bg-white/20 transition transform hover:translate-x-1' }}">
                 <img src="{{ asset('assets/picture/category.png') }}" alt="Category Icon" class="w-5 h-5 mr-3 filter invert brightness-0">
                 <span class="font-bold">Kategori</span>
                </a>
            </li>
            <li>
                <a href="{{ route('report.index') }}" 
                class="flex items-center p-3 mb-2 rounded-lg hover:text-[#F20E0F] cursor-pointer transition group
                {{ request()->is('report') ? 'bg-white/30 font-bold' : 'hover:bg-white/20 transition transform hover:translate-x-1' }}">
                 <img src="{{ asset('assets/picture/report.png') }}" alt="Report Icon" class="w-5 h-5 mr-3 filter invert brightness-0">
                 <span class="font-bold">Laporan</span>
                </a>
            </li>
        </ul>
            <div x-data="{open:false}" class="mt-4">
                <button @click="open=!open" class="flex justify-between w-full items-center px-4 py-2 font-semibold text-left hover:text-[#F20E0F] cursor-pointer transition group hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">
                    Kas Masuk
                    <img src="{{ asset('assets/picture/arrow.png') }}" :class="{'rotate-180': open}" class="w-4 h-4 transition-transform filter invert brightness-0" />
                </button>
                <ul x-show="open"  x-transition class="ml-6 mt-2 space-y-1 text-sm">
                    @if(isset($sidebarIncomeCategories) && $sidebarIncomeCategories->count() > 0)
                        @foreach($sidebarIncomeCategories as $category)
                            <a href="{{ route('category.income', ['category_id' => $category->id]) }}" 
                                class="block px-3 py-1 text-sm hover:text-[#F20E0F] cursor-pointer transition group hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">
                                {{ $category->category_name }}
                            </a>
                        @endforeach
                    @else
                        <div class="text-sm text-gray-400 py-1">Belum ada kategori kas masuk</div>
                    @endif
                </ul>
            </div>
            <div x-data="{open:false}" class="mt-4">
                <button @click="open=!open" class="flex justify-between w-full items-center px-4 py-2 font-semibold text-left hover:text-[#F20E0F] cursor-pointer transition group hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">
                    Kas Keluar
                    <img src="{{ asset('assets/picture/arrow.png') }}" :class="{'rotate-180': open}" class="w-4 h-4 transition-transform filter invert brightness-0" />
                </button>
                <ul x-show="open" x-transition class="ml-6 mt-2 space-y-1 text-sm">
                    @if(isset($sidebarExpenditureCategories) && $sidebarExpenditureCategories->count() > 0)
                        @foreach($sidebarExpenditureCategories as $category)
                            <a href="{{ route('category.expenditure', ['category_id' => $category->id]) }}" 
                                class="block px-3 py-1 text-sm hover:text-[#F20E0F] cursor-pointer transition group hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">
                                {{ $category->category_name }}
                            </a>
                        @endforeach
                    @else
                        <div class="text-sm text-gray-400 py-1">Belum ada kategori kas keluar</div>
                    @endif
                </ul>
            </div>
        </ul>
        <div x-data="{confirm:false}" class="mt-auto">
        <button @click="confirm=true"
            class="flex items-center w-full px-4 py-2 mt-6 bg-red-600 hover:bg-red-700 rounded-lg font-semibold text-white transition">
            <img src="{{ asset('assets/picture/logout.png') }}" alt="Logout Icon" class="w-5 h-5 mr-3 filter invert">
            Logout
        </button>
        <div x-show="confirm" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-80">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Konfirmasi Logout</h2>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin keluar?</p>
                <div class="flex justify-end space-x-3">
                    <button @click="confirm=false" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                        Batal
                    </button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Ya, Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </nav> 
</aside>