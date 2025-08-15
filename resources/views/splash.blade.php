<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Splash</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css','resources/css/Splash.css'])
</head>
<body class="flex items-center justify-center h-screen bg-white">

    <h1 class="font-poppins font-bold text-4xl splash-animation flex space-x-2">
        <span class="text-black splash-animation">Office</span>
        <span class="text-[#B6F500] splash-animation" style="animation-delay: 0.3s">Finance</span>
    </h1>

    <script>
        setTimeout(function(){
            window.location.href = "/login";
        }, 3000); 
    </script>

</body>
</html>
