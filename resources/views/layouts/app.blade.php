<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Office Finance')</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-Poppins bg-[#f5f5f5]">
    <div class="flex min-h-screen">
        <aside class="w-[250px] bg-gradient-to-b from-[#a3e635] to-[#84cc16] text-[#1f2937] p-5">
            <nav>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}" 
                        class="flex items-center px-4 py-2 rounded-lg 
                        {{ request()->is('dashboard') ?  : 'hover:bg-white/20 transition transform hover:translate-x-1' }}">
                         <img src="{{ asset('assets/picture/home.png') }}" alt="Home Icon" class="w-5 h-5 mr-3">
                         <span class="font-bold">Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('transaction.index') }}" 
                        class="flex items-center px-4 py-2 rounded-lg 
                        {{ request()->is('transaksi') ?  : 'hover:bg-white/20 transition transform hover:translate-x-1' }}">
                         <img src="{{ asset('assets/picture/transaction.png') }}" alt="Transaction Icon" class="w-5 h-5 mr-3">
                         <span class="font-bold">Transaksi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}" 
                        class="flex items-center px-4 py-2 rounded-md 
                        {{ request()->is('kategori') ? : 'hover:bg-white/20 transition transform hover:translate-x-1' }}">
                         <img src="{{ asset('assets/picture/category.png') }}" alt="Category Icon" class="w-5 h-5 mr-3">
                         <span class="font-bold">Kategori</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('laporan') }}" 
                        class="flex items-center px-4 py-2 rounded-md 
                        {{ request()->is('laporan') ? : 'hover:bg-white/20 transition transform hover:translate-x-1' }}">
                         <img src="{{ asset('assets/picture/report.png') }}" alt="Report Icon" class="w-5 h-5 mr-3">
                         <span class="font-bold">Laporan</span>
                        </a>
                    </li>
                </ul>

                <div x-data="{open:false}" class="pl-4">
                    <button @click="open=!open" class="flex justify-between w-full items-center p-2 font-semibold hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">
                        Kas Keluar
                        <img src="{{ asset('assets/picture/arrow.png') }}" :class="{'rotate-180': open}" class="w-4 h-4 transition-transform" />
                    </button>
                    <ul x-show="open ">
                        <li x-show="open" class="pl-6"><a href="#" class="block py-1 text-sm hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">Angsuran Perusahaan</a></li>
                        <li x-show="open" class="pl-6"><a href="#" class="block py-1 text-sm hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">Hutang Perusahaan</a></li>
                        <li x-show="open" class="pl-6"><a href="#" class="block py-1 text-sm hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">KAS Besar</a></li>
                        <li x-show="open" class="pl-6"><a href="#" class="block py-1 text-sm hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">KAS Kecil</a></li>
                    </ul>
                </div> 
                <div x-data="{open:false}" class="pl-4">
                    <button @click="open=!open" class="flex justify-between w-full items-center p-2 font-semibold hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">
                        Kas Masuk
                        <img src="{{ asset('assets/picture/arrow.png') }}" :class="{'rotate-180': open}" class="w-4 h-4 transition-transform" />
                    </button>
                    <ul x-show="open">
                        <li x-show="open" class="pl-6"><a href="#" class="block py-1 text-sm hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">CV Tiga Jaya</a></li>
                        <li x-show="open" class="pl-6"><a href="#" class="block py-1 text-sm hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">SAS Sukabumi</a></li>
                        <li x-show="open" class="pl-6"><a href="#" class="block py-1 text-sm hover:bg-white/20 transition transform hover:translate-x-1 rounded-lg">SAS Karawang</a></li>
                    </ul>
                </div>
            </nav>
        </aside>
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    @vite('resources/js/app.js')
</body>
</html>
