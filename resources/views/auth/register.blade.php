<!DOCTYPE html>
<<<<<<< HEAD
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ofiice Finance</title>
=======
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TigaJaya Finance')</title>
>>>>>>> origin/ui-ux
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<style>
    input[type="checkbox"]:checked::after {
        content: "✓";
<<<<<<< HEAD
        color: black;             
=======
        color: white;             
>>>>>>> origin/ui-ux
        font-size: 10px;         
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>

<body class="h-screen flex items-center justify-center font-poppins">
<<<<<<< HEAD
    <main class="flex w-full h-screen">
        <section class="flex flex-col justify-center items-center flex-1 bg-white fade-in">
            <div class="mb-4">
                <h1 class="text-4xl font-bold justify-center">
                    <span class="text-black font-bold">Office</span>
                    <span class="text-[#F20E0F] font-bold">Finance</span>
=======
    <main class="flex w-full h-screen font-poppins">
        <section class="flex flex-col justify-center items-center flex-1 bg-white fade-in px-6">
            <div class="mb-3">
                <h1 class="text-2xl font-bold justify-center">
                    <span class="text-[#F20E0F]">TigaJaya</span>
                    <span class="text-[#0B3B9F]">Finance</span>
>>>>>>> origin/ui-ux
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

<<<<<<< HEAD
                <form id="registerForm" method="POST" action="{{ route('auth.register') }}">
=======
                <form id="registerForm" method="POST" action="{{ route('auth.register') }}"  class="flex flex-col w-64">
>>>>>>> origin/ui-ux
                    @csrf
                    <div id="username" class="mt-2">
                        <label for="usernameInput" class="sr-only">Username</label>
                        <input id="usernameInput" name="username" type="text" placeholder="Username"
                            value="{{ old('username') }}" autofocus
<<<<<<< HEAD
                            class="w-full px-6 py-1 border border-[#0B3B9F] rounded-full mb-2 outline-none focus:border-[#0B3B9F] focus:shadow-[0_0_5px_rgba(180,229,13,0.7)]">
=======
                            class="w-full px-4 py-2 border border-[#F20E0F] rounded-full mb-2 outline-none focus:border-[#0B3B9F]">
>>>>>>> origin/ui-ux
                        <div id="usernameError" class="hidden mt-1 mb-4">
                            <p class="text-red-500 text-xs italic">Username is required.</p>
                        </div>

                        @error('username')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="password" class="mt-4">
                        <label for="passwordInput" class="sr-only">Password</label>
                        <input id="passwordInput" name="password" type="password" placeholder="Password"
<<<<<<< HEAD
                            class="w-full px-6 py-1 border border-[#0B3B9F] rounded-full mb-2 outline-none focus:border-[#0B3B9F] focus:shadow-[0_0_5px_rgba(180,229,13,0.7)]">
=======
                            class="w-full px-4 py-2 border border-[#0B3B9F] rounded-full mb-2 outline-none focus:border-[#F20E0F]">
>>>>>>> origin/ui-ux
                        <div id="passwordError" class="hidden mt-1 mb-3">
                            <p class="text-red-500 text-xs italic">Password is required.</p>
                        </div>

                        @error('password')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="confirmPassword" class="mt-4">
                        <label for="confirmPasswordInput" class="sr-only">Confirm Password</label>
                        <input id="confirmPasswordInput" name="password_confirmation" type="password" placeholder="Confirm Password"
<<<<<<< HEAD
                            class="w-full px-6 py-1 border border-[#0B3B9F] rounded-full mb-2 outline-none focus:border-[#0B3B9F] focus:shadow-[0_0_5px_rgba(180,229,13,0.7)]">
=======
                            class="w-full px-4 py-2 border border-[#F20E0F] rounded-full mb-2 outline-none focus:border-[#0B3B9F]">
>>>>>>> origin/ui-ux
                        <div id="confirmPasswordError" class="hidden mt-1 mb-3">
                            <p class="text-red-500 text-xs italic">Confirm password is required.</p>
                        </div>
                        <div id="passwordMismatchError" class="hidden mt-1 mb-3">
                            <p class="text-red-500 text-xs italic">Passwords do not match.</p>
                        </div>

                        @error('password_confirmation')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="emptyFieldsError" class="hidden mt-1 mb-4">
                        <p class="text-red-500 text-sm font-medium">All fields are required</p>
                    </div>

                    <div class="flex items-center justify-between mt-2 mb-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="terms" id="terms"
<<<<<<< HEAD
                                class="w-5 h-5 mr-2 appearance-none rounded border border-gray-400 checked:bg-[#0B3B9F] checked:border-[#0B3B9F] relative">
=======
                                class="w-5 h-5 mr-2 appearance-none rounded border border-gray-400 checked:bg-[#0B3B9F] checked:border-[#B6F500] relative">
>>>>>>> origin/ui-ux
                            <label for="terms" class="text-sm text-gray-700">Saya setuju dengan syarat & ketentuan</label>
                        </div>
                    </div>
                    <div id="termsError" class="hidden mt-1 mb-4">
                        <p class="text-red-500 text-xs italic">You must agree to the terms and conditions.</p>
                    </div>

                    <div id="button">
                        <button type="submit"
<<<<<<< HEAD
                            class="w-64 text-md bg-black text-white py-1 rounded-full transition duration-300 hover:bg-[#0B3B9F] hover:text-black active:scale-95">
=======
                            class="w-64 text-md bg-[#F20E0F] text-white py-2 rounded-full font-bold transition duration-300 hover:bg-[#0B3B9F] hover:text-white active:scale-95">
>>>>>>> origin/ui-ux
                            Daftar
                        </button>
                    </div>

                    <p class="mt-3 text-sm text-center whitespace-nowrap">
                        Sudah punya akun? <a href="{{ route('auth.login') }}" class="text-[#0B3B9F]">login</a> disini.
                    </p>
                </form>
            </div>
        </section>
        <aside class="flex-1 bg-[#0B3B9F] hidden md:flex justify-center items-center">
            <img src="{{ asset('assets/picture/LoginAnimation.png') }}" alt="Finance Illustration"
                class="w-3/4 max-w-md">
        </aside>

        <script>
            let isFormDisabled = false;

            function toggleInputs(disabled) {
                const usernameInput = document.getElementById('usernameInput');
                const passwordInput = document.getElementById('passwordInput');
                const confirmPasswordInput = document.getElementById('confirmPasswordInput');
                const termsCheckbox = document.getElementById('terms');

                const inputs = [usernameInput, passwordInput, confirmPasswordInput];

                inputs.forEach(input => {
                    input.readOnly = disabled;
                    if (disabled) {
                        input.style.pointerEvents = 'none';
                        input.style.opacity = '0.6';
                    } else {
                        input.style.pointerEvents = 'auto';
                        input.style.opacity = '1';
                    }
                });

                termsCheckbox.disabled = disabled;
                if (disabled) {
                    termsCheckbox.style.pointerEvents = 'none';
                    termsCheckbox.style.opacity = '0.6';
                } else {
                    termsCheckbox.style.pointerEvents = 'auto';
                    termsCheckbox.style.opacity = '1';
                }

                isFormDisabled = disabled;
            }

            document.getElementById('registerForm').addEventListener('submit', function(e) {
                const username = document.getElementById('usernameInput').value.trim();
                const password = document.getElementById('passwordInput').value.trim();
                const confirmPassword = document.getElementById('confirmPasswordInput').value.trim();
                const termsChecked = document.getElementById('terms').checked;

                const emptyFieldsError = document.getElementById('emptyFieldsError');
                const usernameError = document.getElementById('usernameError');
                const passwordError = document.getElementById('passwordError');
                const confirmPasswordError = document.getElementById('confirmPasswordError');
                const passwordMismatchError = document.getElementById('passwordMismatchError');
                const termsError = document.getElementById('termsError');
                const serverErrors = document.getElementById('serverErrors');

                const usernameInput = document.getElementById('usernameInput');
                const passwordInput = document.getElementById('passwordInput');
                const confirmPasswordInput = document.getElementById('confirmPasswordInput');

                emptyFieldsError.classList.add('hidden');
                usernameError.classList.add('hidden');
                passwordError.classList.add('hidden');
                confirmPasswordError.classList.add('hidden');
                passwordMismatchError.classList.add('hidden');
                termsError.classList.add('hidden');

                if (serverErrors) {
                    serverErrors.classList.add('hidden');
                }

                usernameInput.classList.remove('border-red-500');
                passwordInput.classList.remove('border-red-500');
                confirmPasswordInput.classList.remove('border-red-500');

                let hasError = false;

                // Cek semua field kosong
                if (username === '' && password === '' && confirmPassword === '') {
                    e.preventDefault();
                    emptyFieldsError.classList.remove('hidden');
                    usernameInput.classList.add('border-red-500');
                    passwordInput.classList.add('border-red-500');
                    confirmPasswordInput.classList.add('border-red-500');
                    toggleInputs(true);
                    hasError = true;
                } else {
                    // Cek masing-masing fields
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
                    if (confirmPassword === '') {
                        e.preventDefault();
                        confirmPasswordError.classList.remove('hidden');
                        confirmPasswordInput.classList.add('border-red-500');
                        hasError = true;
                    } else if (password !== confirmPassword && password !== '') {
                        e.preventDefault();
                        passwordMismatchError.classList.remove('hidden');
                        passwordInput.classList.add('border-red-500');
                        confirmPasswordInput.classList.add('border-red-500');
                        hasError = true;
                    }

                    if (hasError) {
                        toggleInputs(true);
                    }
                }

                // Cek terms and conditions
                if (!termsChecked && !hasError) {
                    e.preventDefault();
                    termsError.classList.remove('hidden');
                    hasError = true;
                    toggleInputs(true);
                }

                if (hasError) {
                    return false;
                }
            });

            document.getElementById('registerForm').addEventListener('click', function(e) {
                if (isFormDisabled) {
                    toggleInputs(false);

                    // Menyembunyakan pesan error
                    document.getElementById('emptyFieldsError').classList.add('hidden');
                    document.getElementById('usernameError').classList.add('hidden');
                    document.getElementById('passwordError').classList.add('hidden');
                    document.getElementById('confirmPasswordError').classList.add('hidden');
                    document.getElementById('passwordMismatchError').classList.add('hidden');
                    document.getElementById('termsError').classList.add('hidden');

                    const serverErrors = document.getElementById('serverErrors');
                    if (serverErrors) {
                        serverErrors.classList.add('hidden');
                    }

                    // Remove error styling
                    document.getElementById('usernameInput').classList.remove('border-red-500');
                    document.getElementById('passwordInput').classList.remove('border-red-500');
                    document.getElementById('confirmPasswordInput').classList.remove('border-red-500');

                    // Focus pada input yang pertama kosong
                    const usernameInput = document.getElementById('usernameInput');
                    const passwordInput = document.getElementById('passwordInput');
                    const confirmPasswordInput = document.getElementById('confirmPasswordInput');

                    if (usernameInput.value.trim() === '') {
                        setTimeout(() => usernameInput.focus(), 10);
                    } else if (passwordInput.value.trim() === '') {
                        setTimeout(() => passwordInput.focus(), 10);
                    } else if (confirmPasswordInput.value.trim() === '') {
                        setTimeout(() => confirmPasswordInput.focus(), 10);
                    }
                }
            });

            // Event listeners untuk input fields
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

                    // Check if all fields are filled to hide empty fields error
                    const password = document.getElementById('passwordInput').value.trim();
                    const confirmPassword = document.getElementById('confirmPasswordInput').value.trim();
                    if (password !== '' && confirmPassword !== '') {
                        emptyFieldsError.classList.add('hidden');
                        document.getElementById('passwordInput').classList.remove('border-red-500');
                        document.getElementById('confirmPasswordInput').classList.remove('border-red-500');
                    }
                }
            });

            document.getElementById('passwordInput').addEventListener('input', function() {
                if (isFormDisabled) return;

                const passwordError = document.getElementById('passwordError');
                const passwordMismatchError = document.getElementById('passwordMismatchError');
                const emptyFieldsError = document.getElementById('emptyFieldsError');
                const serverErrors = document.getElementById('serverErrors');
                const confirmPasswordInput = document.getElementById('confirmPasswordInput');

                if (this.value.trim() !== '') {
                    passwordError.classList.add('hidden');
                    this.classList.remove('border-red-500');

                    if (serverErrors) {
                        serverErrors.classList.add('hidden');
                    }

                    // Check password match
                    const confirmPassword = confirmPasswordInput.value.trim();
                    if (confirmPassword !== '' && this.value !== confirmPassword) {
                        passwordMismatchError.classList.remove('hidden');
                        this.classList.add('border-red-500');
                        confirmPasswordInput.classList.add('border-red-500');
                    } else if (confirmPassword !== '' && this.value === confirmPassword) {
                        passwordMismatchError.classList.add('hidden');
                        this.classList.remove('border-red-500');
                        confirmPasswordInput.classList.remove('border-red-500');
                    }

                    // Check if all fields are filled to hide empty fields error
                    const username = document.getElementById('usernameInput').value.trim();
                    if (username !== '' && confirmPassword !== '') {
                        emptyFieldsError.classList.add('hidden');
                        document.getElementById('usernameInput').classList.remove('border-red-500');
                        confirmPasswordInput.classList.remove('border-red-500');
                    }
                }
            });

            document.getElementById('confirmPasswordInput').addEventListener('input', function() {
                if (isFormDisabled) return;

                const confirmPasswordError = document.getElementById('confirmPasswordError');
                const passwordMismatchError = document.getElementById('passwordMismatchError');
                const emptyFieldsError = document.getElementById('emptyFieldsError');
                const serverErrors = document.getElementById('serverErrors');
                const passwordInput = document.getElementById('passwordInput');

                if (this.value.trim() !== '') {
                    confirmPasswordError.classList.add('hidden');
                    this.classList.remove('border-red-500');

                    if (serverErrors) {
                        serverErrors.classList.add('hidden');
                    }

                    // Check password match
                    const password = passwordInput.value.trim();
                    if (password !== '' && this.value !== password) {
                        passwordMismatchError.classList.remove('hidden');
                        this.classList.add('border-red-500');
                        passwordInput.classList.add('border-red-500');
                    } else if (password !== '' && this.value === password) {
                        passwordMismatchError.classList.add('hidden');
                        this.classList.remove('border-red-500');
                        passwordInput.classList.remove('border-red-500');
                    }

                    // Check if all fields are filled to hide empty fields error
                    const username = document.getElementById('usernameInput').value.trim();
                    if (username !== '' && password !== '') {
                        emptyFieldsError.classList.add('hidden');
                        document.getElementById('usernameInput').classList.remove('border-red-500');
                        passwordInput.classList.remove('border-red-500');
                    }
                }
            });

            // Prevent typing ketika form disabled
            ['usernameInput', 'passwordInput', 'confirmPasswordInput'].forEach(id => {
                document.getElementById(id).addEventListener('keydown', function(e) {
                    if (isFormDisabled) {
                        e.preventDefault();
                    }
                });
            });
        </script>
    </main>
</body>

</html>