<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Finance</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex items-center justify-center h-screen bg-white">
=======
@extends('layouts.splash')
>>>>>>> origin/ui-ux

@section('title', 'Splash Screen')

@section('content')
    <h1 class="font-bold text-4xl splash-animation flex space-x-2">
        <span class="text-black splash-animation">Office</span>
        <span class="text-[#B6F500] splash-animation">Finance</span>
    </h1>
@endsection

<<<<<<< HEAD
    <script>
        setTimeout(function(){
            window.location.href = "{{ Auth::guard('admin')->check() ? route('welcome') : route('admin.login') }}";
        }, 3000); 
    </script>

</body>
</html>
=======
@section('scripts')
<script>
    setTimeout(function(){
        window.location.href = "/login";
    }, 3000);
</script>
@endsection
>>>>>>> origin/ui-ux
