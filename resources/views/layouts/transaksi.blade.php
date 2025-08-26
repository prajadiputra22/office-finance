<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Office Finance')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-[Poppins] bg-gray-100">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-gradient-to-b from-lime-400 to-lime-500 text-gray-800 p-5">
            <nav class="space-y-4">
                <ul>
                    <li>
                        <a href="{{ url('dashboard') }}" class="flex items-center p-3 rounded-md hover:bg-white/20 transition">
                            <img src="{{ asset('assets/picture/home.png') }}" alt="Home Icon" class="w-5 h-5 mr-3">
                            <span class="font-bold">Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('transaksi') }}" class="flex items-center p-3 rounded-md hover:bg-white/20 transition">
                            <img src="{{ asset('assets/picture/transaction.png') }}" alt="Transaction Icon" class="w-5 h-5 mr-3">
                            <span class="font-bold">Transaksi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('kategori') }}" class="flex items-center p-3 rounded-md hover:bg-white/20 transition">
                            <img src="{{ asset('assets/picture/category.png') }}" alt="Category Icon" class="w-5 h-5 mr-3">
                            <span class="font-bold">Kategori</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-3 rounded-md hover:bg-white/20 transition">
                            <img src="{{ asset('assets/picture/report.png') }}" alt="Report Icon" class="w-5 h-5 mr-3">
                            <span class="font-bold">Laporan</span>
                        </a>
                    </li>
                </ul>

                <ul x-data="{open:false}" class="ml-4">
                    <li>
                        <button @click="open=!open" class="flex justify-between w-full p-2 font-semibold">
                            Kas Keluar
                            <img src="{{ asset('assets/picture/arrow.png') }}" class="w-3 h-3" />
                        </button>
                    </li>
                    <li x-show="open" class="pl-6"><a href="#" class="block py-1">Angsuran Perusahaan</a></li>
                    <li x-show="open" class="pl-6"><a href="#" class="block py-1">Hutang Perusahaan</a></li>
                    <li x-show="open" class="pl-6"><a href="#" class="block py-1">KAS Besar</a></li>
                    <li x-show="open" class="pl-6"><a href="#" class="block py-1">KAS Kecil</a></li>
                </ul>
                <ul x-data="{open:false}" class="ml-4">
                    <li>
                        <button @click="open=!open" class="flex justify-between w-full p-2 font-semibold">
                            Kas Masuk
                            <img src="{{ asset('assets/picture/arrow.png') }}" class="w-3 h-3" />
                        </button>
                    </li>
                    <li x-show="open" class="pl-6"><a href="#" class="block py-1">CV Tiga Jaya</a></li>
                    <li x-show="open" class="pl-6"><a href="#" class="block py-1">SAS Sukabumi</a></li>
                    <li x-show="open" class="pl-6"><a href="#" class="block py-1">SAS Karawang</a></li>
                </ul>
            </nav>
        </aside>
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    @vite('resources/js/app.js')
</body>
</html>
