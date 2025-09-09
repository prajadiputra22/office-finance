<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Office Finance')</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Added Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-[#f5f5f5] font-poppins">

    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 bg-[#f5f5f5] relative ml-[250px]">
            <!-- Header selalu nempel pojok kanan atas main -->
            <h1 class="absolute top-4 right-4 z-20 text-2xl font-bold text-black">
                Office <span class="text-[#B6F500]">Finance</span>
            </h1>

            <div class="pr-9 px-3">
                @yield('content')
            </div>
        </main>
    </div>

    @vite('resources/js/app.js')
</body>

</html>
