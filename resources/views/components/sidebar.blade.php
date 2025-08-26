<!-- Sticky Sidebar -->
<nav class="w-64 bg-gradient-to-b from-lime-400 to-lime-500 text-gray-800 p-5"
    :class="{ 'transform translate-y-0': showNavbar, 'transform -translate-y-full': !showNavbar }"
    x-data="{ isOpen: false }">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex-shrink-0">
            <a href="/dashboard" class="flex items-center">
                <span class="text-black splash-animation">Office</span>
                <span class="text-white splash-animation">Finance</span>
            </a>
        </div>

        <div class="hidden md:block flex-grow">
            <div class="flex flex-col items-start space-x-4">
                <!-- Dashboard -->
                <a href="/dashboard"
                    class="rounded-md px-3 py-2 text-sm {{ request()->is('/dashboard') ? 'font-bold text-amber-500' : 'font-medium text-gray-950 hover:bg-gray-100 hover:text-gray-900' }}"
                    aria-current="page">Home</a>

                <!-- Transaksi -->
                <a href="/transaksi"
                    class="rounded-md px-3 py-2 text-sm {{ request()->is('transaksi') ? 'font-bold text-amber-500' : 'font-medium text-gray-950 hover:bg-gray-100 hover:text-gray-900' }}"
                    aria-current="page">Transaksi</a>

                <!-- Kategori -->
                <a href="/kategori"
                    class="rounded-md px-3 py-2 text-sm {{ request()->is('kategori') ? 'font-bold text-amber-500' : 'font-medium text-gray-950 hover:bg-gray-100 hover:text-gray-900' }}"
                    aria-current="page">Kategori</a>

                <!-- Laporan -->
                <a href="/laporan"
                    class="rounded-md px-3 py-2 text-sm {{ request()->is('laporan') ? 'font-bold text-amber-500' : 'font-medium text-gray-950 hover:bg-gray-100 hover:text-gray-900' }}"
                    aria-current="page">Laporan</a>

                <!-- Sub Menu Kas Masuk-->
                <div x-data="{ open: false }" class="w-full">
                    <button @click="open = !open"
                        class="w-full text-left rounded-md px-3 py-2 text-sm font-medium text-gray-950 hover:bg-gray-100 hover:text-gray-900 flex justify-between items-center">
                        Kas Masuk
                        <svg :class="{ 'rotate-90': open }" class="w-4 h-4 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="ml-6 mt-1 flex flex-col space-y-1">
                        <a href="/kas-masuk/harian"
                            class="px-3 py-1 text-sm text-gray-700 hover:text-amber-500">Harian</a>
                        <a href="/kas-masuk/bulanan"
                            class="px-3 py-1 text-sm text-gray-700 hover:text-amber-500">Bulanan</a>
                        <a href="/kas-masuk/tahunan"
                            class="px-3 py-1 text-sm text-gray-700 hover:text-amber-500">Tahunan</a>
                    </div>
                </div>

                <!-- Sub Menu Kas Keluar  -->
                <div x-data="{ open: false }" class="w-full">
                    <button @click="open = !open"
                        class="w-full text-left rounded-md px-3 py-2 text-sm font-medium text-gray-950 hover:bg-gray-100 hover:text-gray-900 flex justify-between items-center">
                        Kas Keluar
                        <svg :class="{ 'rotate-90': open }" class="w-4 h-4 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="ml-6 mt-1 flex flex-col space-y-1">
                        <a href="/kas-keluar/harian"
                            class="px-3 py-1 text-sm text-gray-700 hover:text-amber-500">Harian</a>
                        <a href="/kas-keluar/bulanan"
                            class="px-3 py-1 text-sm text-gray-700 hover:text-amber-500">Bulanan</a>
                        <a href="/kas-keluar/tahunan"
                            class="px-3 py-1 text-sm text-gray-700 hover:text-amber-500">Tahunan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
