<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Office Finance')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/Splash.css'])
</head>
<body class="font-poppins bg-white h-screen flex items-center justify-center">
    @yield('content')
    @yield('scripts')

</body>
</html>
