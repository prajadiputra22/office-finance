@extends('layouts.login')

@section('title', 'Login')

@section('content')
<main class="flex w-full h-screen font-poppins">
    <section class="flex flex-col justify-center items-center flex-1 bg-white fade-in px-6">
        <h1 class="text-2xl mb-5 font-bold">
            <span class="text-black">Office</span>
            <span class="text-[#B6F500]">Finance</span>
        </h1>

        <form action="{{ route('login') }}" method="POST" class="flex flex-col w-64">
            @csrf
            <label for="username" class="sr-only">Username</label>
            <input id="username" name="username" type="text" placeholder="Username"
                class="px-4 py-2 border border-[#B6F500] rounded-full mb-4 outline-none focus:border-[#B4E50D] focus:shadow-[0_0_5px_rgba(180,229,13,0.7)]">

            <label for="password" class="sr-only">Password</label>
            <input id="password" name="password" type="password" placeholder="Password"
                class="px-4 py-2 border border-[#B6F500] rounded-full mb-4 outline-none focus:border-[#B4E50D] focus:shadow-[0_0_5px_rgba(180,229,13,0.7)]">

            <button type="submit"
                class="bg-black text-white py-2 rounded-full font-bold transition duration-300 hover:bg-[#B4E50D] hover:text-black active:scale-95">
                Login
            </button>

            <p class="mt-3 text-sm text-center whitespace-nowrap">
                Belum punya akun? <a href="{{ route('register') }}" class="text-[#B6F500] hover:underline">daftar</a> disini.
            </p>
        </form>
    </section>

    <aside class="flex-1 bg-[#B4E50D] hidden md:flex justify-center items-center fade-in">
        <img src="{{ asset('assets/picture/LoginAnimation.png') }}" alt="Finance Illustration" class="w-3/4 max-w-md">
    </aside>
</main>
@endsection
