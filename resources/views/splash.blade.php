<!DOCTYPE html>
<<<<<<< HEAD
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Finance</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex items-center justify-center h-screen bg-white">

    <h1 class="font-poppins font-bold text-4xl splash-animation flex space-x-2">
        <span class="text-[#0B3B9F] splash-animation">Tigajaya</span>
        <span class="text-[#F20E0F] splash-animation">Finance</span>
    </h1>

    <script>
        setTimeout(function(){
            window.location.href = "{{ Auth::guard('admin')->check() ? route('transactions.index') : route('auth.login') }}";
        }, 3000); 
    </script>

</body>

=======
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TigaJaya Finance')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-screen flex items-center justify-center font-poppins bg-white">
    <h1 class="font-bold text-4xl splash-animation flex space-x-2">
        <span class="text-[#F20E0F] splash-animation">TigaJaya</span>
        <span class="text-[#0B3B9F] splash-animation">Finance</span>
    </h1>

<script>
setTimeout(function(){
    window.location.href = "{{ Auth::guard('admin')->check() ? route('home') : route('auth.login') }}";
}, 3000);
</script>
</body>
>>>>>>> origin/ui-ux
</html>
