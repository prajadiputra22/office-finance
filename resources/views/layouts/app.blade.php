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
<body class="bg-[#f5f5f5] font-poppins">
    <div class="flex flex-col-reverse md:flex-row min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 min-w-0 p-4 md:p-6 bg-[#f5f5f5] pb-24 md:pb-6">
            @section('header')
                <header class="flex justify-end items-center mb-6 md:mb-8 animate-fadeIn">
                    <div class="md:ml-auto">
                        <img src="{{ asset('assets/picture/logo.png') }}" 
                            alt="Logo TigaJaya Finance"
                            class="w-16 md:w-24 lg:w-28 h-auto object-contain">
                    </div>
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="p-2 hover:bg-gray-100 rounded-lg transition">
                            <i class="fas fa-ellipsis-v text-gray-600 text-lg"></i>
                        </button>
                        
                        <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                            <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-50 transition border-b border-gray-200">
                                <i class="fas fa-user mr-3 text-gray-600"></i>
                                <span class="text-gray-700">Profile</span>
                            </a>
                            <form method="POST" action="{{ route('auth.logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-3 hover:bg-gray-50 transition text-red-600">
                                    <i class="fas fa-sign-out-alt mr-3"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </header>
            @show
            @yield('content')
        </main>
    </div>

    @vite('resources/js/app.js')
    @stack('scripts')
</body>
</html>
