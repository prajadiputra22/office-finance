<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<<<<<<< HEAD
    <title>@yield('title', 'Office Finance')</title>
=======
    <title>@yield('title', 'TigaJaya Finance')</title>
>>>>>>> origin/ui-ux
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<<<<<<< HEAD
=======
    <style>
        [x-cloak] { display: none !important; }
    </style>
>>>>>>> origin/ui-ux
</head>

<body class="bg-[#f5f5f5] font-poppins">

    <div class="flex min-h-screen">
        @include('layouts.sidebar')

<<<<<<< HEAD
        <main class="flex-1 bg-[#f5f5f5] relative ml-[250px]">
            <h1 class="absolute top-4 right-10 z-20 text-2xl font-bold text-[#F20E0F]">
                Tigajaya <span class="text-[#0B3B9F]">Finance</span>
            </h1>

            <div class="px-9">
                @yield('content')
            </div>
=======
        <main class="flex-1 min-w-0 p-6 bg-[#f5f5f5]">
            @section('header')
                <header class="flex justify-end mb-8 animate-fadeIn">
                    <h1 class="text-2xl font-bold text-[#F20E0F]"> TigaJaya <span class="text-[#0B3B9F]">Finance</span></h1>
                </header>
            @show
            @yield('content')
>>>>>>> origin/ui-ux
        </main>
    </div>

    @vite('resources/js/app.js')
    @stack('scripts')
</body>

</html>
