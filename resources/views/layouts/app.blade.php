<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Office Finance')</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-[#f5f5f5] font-poppins">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 p-6">
            @hasSection('header')
            @yield('header')
            @else
            @include('layouts.header')
            @endif
            
            @yield('content')
        </main>
    </div>

    @vite('resources/js/app.js')
    @yield('scripts')
</body>
</html>
