<aside class="w-[200px] bg-[#0B3B9F] text-white p-5 flex flex-col shadow-md overflow-y-auto">
    <nav>
        <ul class="space-y-2">
            <li>
                <a href="home"
                class="flex items-center p-3 mb-2 rounded-lg hover:text-[#F20E0F] cursor-pointer transition group
                {{ request()->is('home') ? 'bg-white/30 font-bold' : 'hover:bg-white/20 transition transform hover:translate-x-1' }}">
                 <img src="{{ asset('assets/picture/home.png') }}" alt="Home Icon" class="w-5 h-5 mr-3 filter invert brightness-0 duration-300 group-hover:invert group-hover:red group-hover:saturate-200 group-hover:hue-rotate-0 group-hover:brightness-100 group-hover:contrast-200">
                 <span class="font-bold">Beranda</span>
                </a>
            </li>
            <li>
                <a href="transactions" 
                class="flex items-center p-3 mb-2 rounded-lg hover:text-[#F20E0F] cursor-pointer transition group
                {{ request()->is('transaksi') ? 'bg-white/30 font-bold' : 'hover:bg-white/20 transition transform hover:translate-x-1' }}">
                 <img src="{{ asset('assets/picture/transaction.png') }}" alt="Transaction Icon" class="w-5 h-5 mr-3 filter invert brightness-0 ">
                 <span class="font-bold">Transaksi</span>
                </a>
            </li>
            <li>
                <a href="category" 
                class="flex items-center p-3 mb-2 rounded-lg hover:text-[#F20E0F] cursor-pointer transition group
                {{ request()->is('kategori') ? 'bg-white/30 font-bold' : 'hover:bg-white/20 transition transform hover:translate-x-1' }}">
                 <img src="{{ asset('assets/picture/category.png') }}" alt="Category Icon" class="w-5 h-5 mr-3 filter invert brightness-0">
                 <span class="font-bold">Kategori</span>
                </a>
            </li>
            <li>
                <a href="report" 
                class="flex items-center p-3 mb-2 rounded-lg hover:text-[#F20E0F] cursor-pointer transition group
                {{ request()->is('laporan') ? 'bg-white/30 font-bold' : 'hover:bg-white/20 transition transform hover:translate-x-1' }}">
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
                    <li x-show="open"><a href="#" class="block px-3 py-1 text-sm hover:text-[#F20E0F] cursor-pointer transition group hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">CV Tiga Jaya</a></li>
                    <li x-show="open"><a href="#" class="block px-3 py-1 text-sm hover:text-[#F20E0F] cursor-pointer transition group hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">SAS Sukabumi</a></li>
                    <li x-show="open"><a href="#" class="block px-3 py-1 text-sm hover:text-[#F20E0F] cursor-pointer transition group hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">SAS Karawang</a></li>
                </ul>
            </div>
            <div x-data="{open:false}" class="mt-4">
                <button @click="open=!open" class="flex justify-between w-full items-center px-4 py-2 font-semibold text-left hover:text-[#F20E0F] cursor-pointer transition group hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">
                    Kas Keluar
                    <img src="{{ asset('assets/picture/arrow.png') }}" :class="{'rotate-180': open}" class="w-4 h-4 transition-transform filter invert brightness-0" />
                </button>
                <ul x-show="open" x-transition class="ml-6 mt-2 space-y-1 text-sm">
                    <li x-show="open"><a href="#" class="block px-3 py-1 text-sm hover:text-[#F20E0F] cursor-pointer transition group hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">Angsuran Perusahaan</a></li>
                    <li x-show="open"><a href="#" class="block px-3 py-1 text-sm hover:text-[#F20E0F] cursor-pointer transition group hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">Hutang Perusahaan</a></li>
                    <li x-show="open"><a href="#" class="block px-3 py-1 text-sm hover:text-[#F20E0F] cursor-pointer transition group hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">KAS Besar</a></li>
                    <li x-show="open"><a href="#" class="block px-3 py-1 text-sm hover:text-[#F20E0F] cursor-pointer transition group hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">KAS Kecil</a></li>
                </ul>
            </div>
        </ul>
    </nav>
</aside>