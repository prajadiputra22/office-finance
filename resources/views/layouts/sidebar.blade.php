<aside class="fixed top-0 left-0 w-[220px] h-screen bg-[#B6F500] text-black p-5 flex flex-col shadow-md overflow-y-auto">
    <nav class="space-y-2">
        <!-- Menu Utama -->
            <a href="" class="flex items-center p-2 rounded hover:bg-[#9ED400] cursor-pointer transition">
                <img src="{{ asset('assets/picture/home.png') }}" alt="Home Icon" class="w-5 h-5 mr-3">
                <span class="font-medium">Home</span>
            </a>
            <a href="" class="flex items-center p-2 rounded hover:bg-[#9ED400] cursor-pointer transition">
                <img src="{{ asset('assets/picture/transaction.png') }}" alt="Transaction Icon" class="w-5 h-5 mr-3">
                <span class="font-medium">Transaksi</span>
            </a>
            <a href="category" class="flex items-center p-2 rounded hover:bg-[#9ED400] cursor-pointer transition">
                <img src="{{ asset('assets/picture/category.png') }}" alt="Category Icon" class="w-5 h-5 mr-3">
                <span class="font-medium">Kategori</span>
            </a>
            <a herf="" class="flex items-center p-2 rounded hover:bg-[#9ED400] cursor-pointer transition">
                <img src="{{ asset('assets/picture/report.png') }}" alt="Report Icon" class="w-5 h-5 mr-3">
                <span class="font-medium">Laporan</span>
            </a>

            <!-- Kas Masuk -->
            <div class="mt-6" x-data="{ open: true }">
                <button @click="open = !open"
                class="flex items-center justify-between w-full p-2 rounded hover:bg-[#9ED400] text-left transition">
                <span class="font-semibold">Kas Masuk</span>
                <i :class="open ? 'fa fa-chevron-up' : 'fa fa-chevron-down'" class="text-sm"></i>
            </button>
            <div x-show="open" x-transition class="ml-4 mb-3 space-y-1">
                <div class="text-sm text-gray-700 py-1 cursor-pointer hover:text-black">CV Tiga Jaya</div>
                <div class="text-sm text-gray-700 py-1 cursor-pointer hover:text-black">SAS Sukalaumi</div>
                <div class="text-sm text-gray-700 py-1 cursor-pointer hover:text-black">SAS Karawang</div>
            </div>

            <!-- Kas Keluar -->
            <div class="mt-2" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center justify-between w-full p-2 rounded hover:bg-[#9ED400] text-left transition">
                    <span class="font-semibold">Kas Keluar</span>
                    <i :class="open ? 'fa fa-chevron-up' : 'fa fa-chevron-down'" class="text-sm"></i>
                </button>
                <div x-show="open" x-transition class="ml-4 space-y-1">
                    <div class="text-sm text-gray-700 py-1 cursor-pointer hover:text-black">Angsuran Perusahaan</div>
                    <div class="text-sm text-gray-700 py-1 cursor-pointer hover:text-black">Hutang Perusahaan</div>
                    <div class="text-sm text-gray-700 py-1 cursor-pointer hover:text-black">KAS Besar</div>
                    <div class="text-sm text-gray-700 py-1 cursor-pointer hover:text-black">KAS Kecil</div>
                </div>
            </div>
        </div>
    </nav>
</aside>
