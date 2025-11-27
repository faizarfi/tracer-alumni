<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login - Tracer Alumni UIN Raden Mas Said</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="{{ asset('img/uin.png') }}" />

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        /* Base font for body */
        body {
            font-family: 'Inter', sans-serif;
            @apply text-gray-800; /* Default text color */
        }
        /* Poppins for headings and strong elements */
        h1, h2, h3, h4, .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        /* Custom transitions for input fields */
        .input-field {
            transition: all 0.3s ease-in-out;
            @apply focus:ring-green-500 focus:border-green-500; /* Consistent focus style */
        }

        /* Custom transitions for submit button */
        .btn-submit {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); /* More refined cubic-bezier */
        }
        .btn-submit:hover {
            transform: translateY(-2px) scale(1.01); /* Slight lift and scale */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow on hover */
        }
        .btn-submit:active {
            transform: translateY(0) scale(0.98); /* Slight press effect */
        }

        /* Eye icon hover effect */
        .eye-icon {
            cursor: pointer;
            transition: color 0.2s ease-in-out;
        }
        .eye-icon:hover {
            color: #047857; /* Darker green on hover */
        }

        /* Animation for the login card */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-slide-in-up {
            animation: slideInUp 0.7s ease-out forwards;
        }

        /* Background image subtle animation */
        @keyframes pulse-bg {
            0% { background-position: 0% 0%; }
            100% { background-position: 100% 100%; }
        }
        .animate-bg-pulse {
            animation: pulse-bg 30s infinite alternate;
            background-size: 200% 200%; /* Make background larger to allow movement */
        }
        /* Optional: Add a backdrop-filter for a blurred background behind the card */
        .backdrop-blur-sm {
            backdrop-filter: blur(2px); /* Adjust blur value as needed */
            -webkit-backdrop-filter: blur(2px); /* Safari support */
        }
    </style>
</head>

<body class="bg-gradient-to-br from-green-100 via-white to-green-100 min-h-screen flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8">

    <div class="absolute inset-0 bg-cover bg-center opacity-15 animate-bg-pulse"
        style="background-image: url('https://uinsaid.ac.id/files/post/cover/profil-universitas-1708058171.jpeg');"></div>

    <div class="z-10 bg-white rounded-3xl shadow-2xl flex flex-col md:flex-row overflow-hidden max-w-4xl w-full animate-slide-in-up">
        <div class="relative bg-gradient-to-br from-green-800 to-emerald-700 md:w-1/2 flex flex-col items-center justify-center p-8 text-white text-center">
            <img src="{{ asset('img/uin.png') }}" alt="UIN Logo" class="w-32 h-32 md:w-40 md:h-40 object-contain rounded-full bg-white p-2 shadow-lg mb-4 transform hover:scale-105 transition-transform duration-300">
            <h1 class="text-3xl md:text-4xl font-bold font-poppins mb-2 tracking-tight">Tracer Alumni</h1>
            <p class="text-green-200 text-lg md:text-xl font-medium">UIN Raden Mas Said Surakarta</p>
            <div class="absolute bottom-4 left-0 right-0 text-xs text-green-300">
                Membangun Jejaring, Menginspirasi Masa Depan
            </div>
        </div>

        <form action="{{ route('login') }}" method="POST" class="form-container w-full md:w-1/2 p-8 sm:p-10 lg:p-12 space-y-5">
            @csrf
            <h2 class="text-3xl font-bold text-center text-green-700 font-poppins mb-6">Selamat Datang Kembali!</h2>

            @if(session('error'))
                <div class="text-red-700 text-sm mb-4 bg-red-100 border border-red-300 p-3 rounded-lg flex items-center gap-2 shadow-sm animate-fade-in-down">
                    <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div>
                <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                <div class="relative">
                    <i data-lucide="mail" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        placeholder="nama@example.com"
                        class="input-field w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none text-gray-800"
                        value="{{ old('email') }}"
                        required
                    >
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                <div class="relative">
                    <i data-lucide="lock" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="••••••••"
                        class="input-field w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none text-gray-800"
                        required
                    >
                    <button type="button" id="togglePassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-green-600 hover:text-green-800 focus:outline-none eye-icon p-1">
                        <i id="eyeIcon" data-lucide="eye" class="w-5 h-5"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Removed "Forgot Password?" link to avoid undefined route error --}}
            {{--
            <div class="flex justify-end text-sm">
                <a href="{{ route('password.request') }}" class="text-green-600 hover:underline font-medium">Lupa Password?</a>
            </div>
            --}}

            <button
                type="submit"
                class="btn-submit w-full py-3 text-white bg-green-600 rounded-lg hover:bg-green-700 font-semibold text-lg shadow-md focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2"
            >
                Masuk
            </button>

            <p class="mt-6 text-center text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-green-700 hover:underline font-medium">Daftar di sini</a>
            </p>
        </form>
    </div>

    <script>
        lucide.createIcons(); // Initialize all Lucide icons on the page

        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon'); // Reference to the actual icon element

        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';

            // Change the icon dynamically
            if (isPassword) {
                eyeIcon.innerHTML = '<i data-lucide="eye-off" class="w-5 h-5"></i>';
            } else {
                eyeIcon.innerHTML = '<i data-lucide="eye" class="w-5 h-5"></i>';
            }
            lucide.createIcons(); // Re-render Lucide icon after changing innerHTML
        });

        // Initialize eye icon state on page load
        // Ensure the correct icon is displayed based on the initial input type (which is 'password' by default)
        eyeIcon.innerHTML = '<i data-lucide="eye" class="w-5 h-5"></i>';
        lucide.createIcons(); // Ensure it's rendered on load
    </script>

</body>

</html>
