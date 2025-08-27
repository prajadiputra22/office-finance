@extends('layouts.splash')

@section('title', 'Splash Screen')

@section('content')
    <h1 class="font-bold text-4xl splash-animation flex space-x-2">
        <span class="text-black splash-animation">Office</span>
        <span class="text-[#B6F500] splash-animation" style="animation-delay: 0.3s">Finance</span>
    </h1>
@endsection

@section('scripts')
<script>
    setTimeout(function(){
        window.location.href = "/login";
    }, 3000);
</script>
@endsection
