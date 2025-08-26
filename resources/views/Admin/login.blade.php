<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Finance</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<style>
    input[type="checkbox"]:checked::after {
        content: "✔";
        color: black;             
        font-size: 10px;         
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>

<body class="h-screen flex items-center justify-center font-poppins">
    <main class="flex w-full h-screen">
        <section class="flex flex-col justify-center items-center flex-1 bg-white fade-in">
            <div class="mb-3">
                <h1 class="text-4xl font-bold justify-center">
                    <span class="text-black font-bold">Office</span>
                    <span class="text-[#B6F500] font-bold">Finance</span>
                </h1>
            </div>

            <div class="flex flex-col w-64">
                @if ($errors->any())
                    <div id="serverErrors" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="loginForm" method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div id="username" class="mt-2">
                        <label for="usernameInput" class="sr-only">Username</label>
                        <input id="usernameInput" name="username" type="text" placeholder="Username"
                            value="{{ old('username') }}" autofocus
                            class="w-full px-6 py-1 border border-[#B6F500] rounded-full mb-2 outline-none focus:border-[#B4E50D] focus:shadow-[0_0_5px_rgba(180,229,13,0.7)]">
                        <div id="usernameError" class="hidden mt-1 mb-4">
                            <p class="text-red-500 text-xs italic">Username is required.</p>
                        </div>

                        @error('username')
                            @if ($message !== 'Incorrect username or password.')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @endif
                        @enderror
                    </div>

                    <div id="password" class="mt-4">
                        <label for="passwordInput" class="sr-only">Password</label>
                        <input id="passwordInput" name="password" type="password" placeholder="Password"
                            class="w-full px-6 py-1 border border-[#B6F500] rounded-full mb-2 outline-none focus:border-[#B4E50D] focus:shadow-[0_0_5px_rgba(180,229,13,0.7)]">
                        <div id="passwordError" class="hidden mt-1 mb-3">
                            <p class="text-red-500 text-xs italic">Password is required.</p>
                        </div>

                        @error('password')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="emptyFieldsError" class="hidden mt-1 mb-4">
                        <p class="text-red-500 text-sm font-medium">Username and password cannot be empty</p>
                    </div>

                    <div class="flex items-center justify-between mt-2 mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember"
                                class="w-4 h-4 mr-2 appearance-none rounded border border-gray-400 checked:bg-[#B6F500] checked:border-[#B6F500] relative">
                            <label for="remember" class="text-sm text-gray-700">Remember me</label>
                        </div>
                    </div>

                    <div id="button">
                        <button type="submit"
                            class="w-64 text-md bg-black text-white py-1 rounded-full transition duration-300 hover:bg-[#B4E50D] hover:text-black active:scale-95">
                            Login
                        </button>
                    </div>

                    <p class="mt-3 text-sm text-center whitespace-nowrap">
                        Belum punya akun? <a href="{{ route('admin.register') }}" class="text-[#B6F500]">daftar</a> disini.
                    </p>
                </form>
            </div>
        </section>
        <aside class="flex-1 bg-[#B4E50D] hidden md:flex justify-center items-center">
            <img src="{{ asset('assets/picture/LoginAnimation.png') }}" alt="Finance Illustration"
                class="w-3/4 max-w-md">
        </aside>

        <script>
            let isFormDisabled = false;

            // Fungsi untuk disable/enable input fields
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

            // Event listener untuk form submission
            document.getElementById('loginForm').addEventListener('submit', function(e) {
                const username = document.getElementById('usernameInput').value.trim();
                const password = document.getElementById('passwordInput').value.trim();
                const emptyFieldsError = document.getElementById('emptyFieldsError');
                const usernameError = document.getElementById('usernameError');
                const passwordError = document.getElementById('passwordError');
                const usernameInput = document.getElementById('usernameInput');
                const passwordInput = document.getElementById('passwordInput');
                const serverErrors = document.getElementById('serverErrors');

                // Hide all error messages initially
                emptyFieldsError.classList.add('hidden');
                usernameError.classList.add('hidden');
                passwordError.classList.add('hidden');

                // Hide server errors when client-side validation fails
                if (serverErrors) {
                    serverErrors.classList.add('hidden');
                }

                // Remove error styling from inputs
                usernameInput.classList.remove('border-red-500');
                passwordInput.classList.remove('border-red-500');

                let hasError = false;

                // Cek Halaman Form Kosong
                if (username === '' && password === '') {
                    e.preventDefault();
                    emptyFieldsError.classList.remove('hidden');
                    usernameInput.classList.add('border-red-500');
                    passwordInput.classList.add('border-red-500');

                    // Disable inputs setelah error
                    toggleInputs(true);
                    hasError = true;
                } else {
                    // Cek username kosong
                    if (username === '') {
                        e.preventDefault();
                        usernameError.classList.remove('hidden');
                        usernameInput.classList.add('border-red-500');
                        hasError = true;
                    }
                    // Cek password kosong
                    if (password === '') {
                        e.preventDefault();
                        passwordError.classList.remove('hidden');
                        passwordInput.classList.add('border-red-500');
                        hasError = true;
                    }

                    // Disable inputs jika ada error
                    if (hasError) {
                        toggleInputs(true);
                    }
                }

                if (hasError) {
                    return false;
                }
            });

            // Event listener untuk mengaktifkan kembali form ketika diklik
            document.getElementById('loginForm').addEventListener('click', function(e) {
                if (isFormDisabled) {
                    // Reset form state
                    toggleInputs(false);

                    // Hide all error messages
                    document.getElementById('emptyFieldsError').classList.add('hidden');
                    document.getElementById('usernameError').classList.add('hidden');
                    document.getElementById('passwordError').classList.add('hidden');

                    const serverErrors = document.getElementById('serverErrors');
                    if (serverErrors) {
                        serverErrors.classList.add('hidden');
                    }

                    // Remove error styling
                    document.getElementById('usernameInput').classList.remove('border-red-500');
                    document.getElementById('passwordInput').classList.remove('border-red-500');

                    // Focus pada input yang pertama kosong
                    const usernameInput = document.getElementById('usernameInput');
                    const passwordInput = document.getElementById('passwordInput');

                    if (usernameInput.value.trim() === '') {
                        setTimeout(() => usernameInput.focus(), 10);
                    } else if (passwordInput.value.trim() === '') {
                        setTimeout(() => passwordInput.focus(), 10);
                    }
                }
            });

            // Event listener untuk username input (tetap berfungsi normal ketika tidak disabled)
            document.getElementById('usernameInput').addEventListener('input', function() {
                if (isFormDisabled) return; // Tidak berfungsi jika form disabled

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

            // Event listener untuk password input (tetap berfungsi normal ketika tidak disabled)
            document.getElementById('passwordInput').addEventListener('input', function() {
                if (isFormDisabled) return; // Tidak berfungsi jika form disabled

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

            // Prevent typing ketika form disabled
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
