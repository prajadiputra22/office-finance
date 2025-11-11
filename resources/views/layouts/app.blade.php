<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TigaJaya Finance')</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body x-data="{ confirmLogout: false }" class="bg-[#f5f5f5] font-poppins">
    <div class="flex flex-col-reverse md:flex-row min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 min-w-0 p-4 md:p-6 bg-[#f5f5f5] pb-24 md:pb-6 md:ml-[200px]">
            @section('header')
                <header class="flex justify-end items-center mb-6 md:mb-8 animate-fadeIn">
                    <div class="md:ml-auto">
                        <img src="{{ asset('assets/picture/logo.png') }}" 
                            alt="Logo TigaJaya Finance"
                            class="w-16 md:w-24 lg:w-28 h-auto object-contain">
                    </div>
                </header>
            @show
            @yield('content')
        </main>
    </div>
    <div x-show="confirmLogout" x-cloak x-transition class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white p-6 rounded-lg shadow-2xl w-80">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Konfirmasi Logout</h2>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin keluar?</p>
            <div class="flex justify-end space-x-3">
                <button @click="confirmLogout = false" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 font-medium transition">
                    Batal
                </button>
                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition">
                        Ya, Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    @vite('resources/js/app.js')
    @stack('scripts')
</body>
</html>
