<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TigaJaya Finance</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<style>
    input[type="checkbox"]:checked::after {
        content: "✔";
        color: rgb(255, 254, 254);
        font-size: 10px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>

<body class="min-h-screen flex items-center justify-center font-poppins bg-cover bg-center bg-no-repeat bg-fixed"
    style="background-image: linear-gradient(rgba(255,255,255,0.9), rgba(251,252,255,0.85)), url('/assets/picture/background.png');">
    <main class="flex items-center justify-center w-full h-screen">
        <section
            class="bg-white/90 backdrop-blur-md p-6 md:p-8 rounded-xl shadow-lg flex flex-col items-center w-[90%] max-w-sm animate-fadeIn">
            <div class="mb-1 flex flex-col items-center justify-center">
                <img src="{{ asset('assets/picture/logo.png') }}" alt="logo TigaJaya Finance"
                    class="w-36 md:w-40 lg:w-40 mb-6 object-contain">
            </div>

            <div class="flex flex-col items-center">
                @if ($errors->any())
                    <div id="serverErrors"
                        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 w-80 text-left">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="loginForm" method="POST" action="{{ route('login') }}"
                    class="flex flex-col w-80 items-center">
                    @csrf
                    <div id="username" class="w-full mt-2">
                        <label for="usernameInput" class="sr-only">Username</label>
                        <input id="usernameInput" name="username" type="text" placeholder="Username"
                            value="{{ old('username') }}" autofocus
                            class="w-full px-4 py-3 border-2 border-[#0B3B9F] rounded-lg mb-4 outline-none focus:border-[#0B3B9F] focus:ring-2 focus:ring-[#0B3B9F] focus:ring-opacity-30">
                        <div id="usernameError" class="hidden mt-1 mb-4">
                            <p class="text-red-500 text-xs italic text-left">Username is required.</p>
                        </div>

                        @error('username')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="password" class="w-full">
                        <label for="passwordInput" class="sr-only">Password</label>
                        <input id="passwordInput" name="password" type="password" placeholder="Password"
                            class="w-full px-4 py-3 border-2 border-[#0B3B9F] rounded-lg mb-4 outline-none focus:border-[#0B3B9F] focus:ring-2 focus:ring-[#0B3B9F] focus:ring-opacity-30">
                        <div id="passwordError" class="hidden mt-1 mb-3">
                            <p class="text-red-500 text-xs italic text-left">Password is required.</p>
                        </div>

                        @error('password')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="emptyFieldsError" class="hidden mt-1 mb-4 w-full text-left">
                        <p class="text-red-500 text-sm font-medium">Username dan password tidak boleh kosong</p>
                    </div>

                    <div class="flex items-center justify-between mt-2 mb-4 w-full">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember"
                                class="w-4 h-4 mr-2 appearance-none rounded border border-gray-400 checked:bg-[#0B3B9F] checked:border-[#0B3B9F] relative">
                            <label for="remember" class="text-sm text-gray-700">Ingat saya</label>
                        </div>
                    </div>

                    <div id="button" class="mt-2 w-full">
                        <button type="submit"
                            class="w-full text-md bg-[#F20E0F] text-white py-3 rounded-lg font-bold transition duration-300 hover:bg-[#0B3B9F] hover:text-white active:scale-95">
                            Login
                        </button>
                    </div>

                    <p class="mt-3 text-sm text-center whitespace-nowrap justify-center">
                        Belum punya akun? <a href="{{ route('register') }}"
                            class="text-[#F20E0F] hover:underline">daftar</a>
                        disini.
                    </p>
                </form>
            </div>
        </section>

        <script>
            let isFormDisabled = false;

            function toggleInputs(disabled) {
                const usernameInput = document.getElementById('usernameInput');
                const passwordInput = document.getElementById('passwordInput');

                usernameInput.readOnly = disabled;
                passwordInput.readOnly = disabled;

                if (disabled) {
                    usernameInput.style.pointerEvents = 'none';
                    passwordInput.style.pointerEvents = 'none';
                    usernameInput.style.opacity = '0.6';
                    passwordInput.style.opacity = '0.6';
                } else {
                    usernameInput.style.pointerEvents = 'auto';
                    passwordInput.style.pointerEvents = 'auto';
                    usernameInput.style.opacity = '1';
                    passwordInput.style.opacity = '1';
                }

                isFormDisabled = disabled;
            }

            document.getElementById('loginForm').addEventListener('submit', function(e) {
                const username = document.getElementById('usernameInput').value.trim();
                const password = document.getElementById('passwordInput').value.trim();
                const emptyFieldsError = document.getElementById('emptyFieldsError');
                const usernameError = document.getElementById('usernameError');
                const passwordError = document.getElementById('passwordError');
                const usernameInput = document.getElementById('usernameInput');
                const passwordInput = document.getElementById('passwordInput');
                const serverErrors = document.getElementById('serverErrors');

                emptyFieldsError.classList.add('hidden');
                usernameError.classList.add('hidden');
                passwordError.classList.add('hidden');

                if (serverErrors) {
                    serverErrors.classList.add('hidden');
                }

                usernameInput.classList.remove('border-red-500');
                passwordInput.classList.remove('border-red-500');

                let hasError = false;

                if (username === '' && password === '') {
                    e.preventDefault();
                    emptyFieldsError.classList.remove('hidden');
                    usernameInput.classList.add('border-red-500');
                    passwordInput.classList.add('border-red-500');

                    toggleInputs(true);
                    hasError = true;
                } else {
                    if (username === '') {
                        e.preventDefault();
                        usernameError.classList.remove('hidden');
                        usernameInput.classList.add('border-red-500');
                        hasError = true;
                    }
                    if (password === '') {
                        e.preventDefault();
                        passwordError.classList.remove('hidden');
                        passwordInput.classList.add('border-red-500');
                        hasError = true;
                    }

                    if (hasError) {
                        toggleInputs(true);
                    }
                }

                if (hasError) {
                    return false;
                }
            });

            document.getElementById('loginForm').addEventListener('click', function(e) {
                if (isFormDisabled) {
                    toggleInputs(false);

                    document.getElementById('emptyFieldsError').classList.add('hidden');
                    document.getElementById('usernameError').classList.add('hidden');
                    document.getElementById('passwordError').classList.add('hidden');

                    const serverErrors = document.getElementById('serverErrors');
                    if (serverErrors) {
                        serverErrors.classList.add('hidden');
                    }

                    document.getElementById('usernameInput').classList.remove('border-red-500');
                    document.getElementById('passwordInput').classList.remove('border-red-500');

                    const usernameInput = document.getElementById('usernameInput');
                    const passwordInput = document.getElementById('passwordInput');

                    if (usernameInput.value.trim() === '') {
                        setTimeout(() => usernameInput.focus(), 10);
                    } else if (passwordInput.value.trim() === '') {
                        setTimeout(() => passwordInput.focus(), 10);
                    }
                }
            });

            document.getElementById('usernameInput').addEventListener('input', function() {
                if (isFormDisabled) return;

                const usernameError = document.getElementById('usernameError');
                const emptyFieldsError = document.getElementById('emptyFieldsError');
                const serverErrors = document.getElementById('serverErrors');

                if (this.value.trim() !== '') {
                    usernameError.classList.add('hidden');
                    this.classList.remove('border-red-500');

                    if (serverErrors) {
                        serverErrors.classList.add('hidden');
                    }

                    const password = document.getElementById('passwordInput').value.trim();
                    if (password !== '') {
                        emptyFieldsError.classList.add('hidden');
                        document.getElementById('passwordInput').classList.remove('border-red-500');
                    }
                }
            });

            function startLockoutCountdown() {
                const serverErrors = document.getElementById('serverErrors');
                if (!serverErrors) return;

                const errorText = serverErrors.textContent;
                if (!errorText.includes('terkunci') && !errorText.includes('percobaan')) return;

                let seconds = 60;
                const updateMessage = () => {
                    const updatedText = errorText.replace(/\d+ detik/, `${seconds} detik`);
                    const listItems = serverErrors.querySelectorAll('li');
                    if (listItems.length > 0) {
                        listItems[0].textContent = updatedText;
                    }
                    
                    if (seconds > 0) {
                        seconds--;
                        setTimeout(updateMessage, 1000);
                    }
                };
                setTimeout(updateMessage, 1000);
            }

            window.addEventListener('DOMContentLoaded', startLockoutCountdown);

            document.getElementById('passwordInput').addEventListener('input', function() {
                if (isFormDisabled) return;

                const passwordError = document.getElementById('passwordError');
                const emptyFieldsError = document.getElementById('emptyFieldsError');
                const serverErrors = document.getElementById('serverErrors');

                if (this.value.trim() !== '') {
                    passwordError.classList.add('hidden');
                    this.classList.remove('border-red-500');

                    if (serverErrors) {
                        serverErrors.classList.add('hidden');
                    }

                    const username = document.getElementById('usernameInput').value.trim();
                    if (username !== '') {
                        emptyFieldsError.classList.add('hidden');
                        document.getElementById('usernameInput').classList.remove('border-red-500');
                    }
                }
            });

            document.getElementById('usernameInput').addEventListener('keydown', function(e) {
                if (isFormDisabled) {
                    e.preventDefault();
                }
            });

            document.getElementById('passwordInput').addEventListener('keydown', function(e) {
                if (isFormDisabled) {
                    e.preventDefault();
                }
            });
        </script>
    </main>
</body>

</html>
