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
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 min-w-0 p-6 bg-[#f5f5f5]">
            @section('header')
                <header class="flex justify-end items-center mb-8 animate-fadeIn">
                    <img src="{{ asset('assets/picture/logo.png') }}" 
                        alt="Logo TigaJaya Finance"
                        class="w-20 md:w-28 lg:w-28 h-auto object-contain"> 
                </header>
            @show
            @yield('content')
        </main>
    </div>

    @vite('resources/js/app.js')
    @stack('scripts')
</body>
</html>