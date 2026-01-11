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
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        .input-field {
            transition: all 0.3s ease-in-out;
        }

        .btn-submit {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-card {
            animation: slideInUp 0.8s ease-out forwards;
        }

        @keyframes bgScroll {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }
        .bg-animate {
            animation: bgScroll 40s linear infinite alternate;
            background-size: 150% 150%;
        }
    </style>
</head>

<body class="bg-green-50 min-h-screen relative overflow-x-hidden overflow-y-auto">

    <div class="fixed inset-0 z-0 bg-animate opacity-10 pointer-events-none"
        style="background-image: url('https://uinsaid.ac.id/files/post/cover/profil-universitas-1708058171.jpeg'); background-repeat: no-repeat; background-size: cover;">
    </div>

    <div class="relative z-10 min-h-screen w-full flex items-center justify-center p-4 py-10 md:py-20">

        <div class="bg-white rounded-3xl shadow-2xl flex flex-col md:flex-row overflow-hidden max-w-4xl w-full animate-card">

            <div class="relative bg-gradient-to-br from-green-800 to-emerald-700 md:w-5/12 flex flex-col items-center justify-center p-8 md:p-10 text-white text-center">
                <div class="bg-white p-3 rounded-full shadow-2xl mb-6 transform hover:scale-110 transition-transform duration-500">
                    <img src="{{ asset('img/uin.png') }}" alt="UIN Logo" class="w-20 h-20 md:w-32 md:h-32 object-contain">
                </div>
                <h1 class="text-xl md:text-3xl font-bold mb-2 tracking-tight">Tracer Alumni</h1>
                <p class="text-green-100 text-xs md:text-sm font-light leading-relaxed">
                    UIN Raden Mas Said Surakarta
                </p>

                <div class="hidden md:block mt-8 pt-8 border-t border-green-600/50 text-[11px] text-green-300 uppercase tracking-widest">
                    Membangun Jejaring <br> Menginspirasi Masa Depan
                </div>
            </div>

            <div class="w-full md:w-7/12 p-6 sm:p-10 lg:p-12">
                <div class="mb-8 text-center md:text-left">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Selamat Datang</h2>
                    <p class="text-gray-500 text-sm">Silakan masuk ke akun Anda</p>
                </div>

                @if(session('error'))
                    <div class="flex items-center gap-3 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg mb-6 text-red-700 text-xs animate-pulse">
                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="space-y-2">
                        <label for="email" class="text-sm font-semibold text-gray-700 ml-1">Alamat Email</label>
                        <div class="relative group">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-green-600 transition-colors">
                                <i data-lucide="mail" class="w-4 h-4 md:w-5 md:h-5"></i>
                            </div>
                            <input id="email" name="email" type="email" placeholder="nama@email.com"
                                class="input-field w-full pl-11 pr-4 py-2.5 md:py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none text-sm text-gray-800"
                                value="{{ old('email') }}" required>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-[10px] mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="text-sm font-semibold text-gray-700 ml-1">Kata Sandi</label>
                        <div class="relative group">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-green-600 transition-colors">
                                <i data-lucide="lock" class="w-4 h-4 md:w-5 md:h-5"></i>
                            </div>
                            <input id="password" name="password" type="password" placeholder="••••••••"
                                class="input-field w-full pl-11 pr-12 py-2.5 md:py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none text-sm text-gray-800"
                                required>
                            <button type="button" id="togglePassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 p-2 text-gray-400 hover:text-green-600 transition-colors">
                                <i id="eyeIcon" data-lucide="eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-[10px] mt-1 ml-1">{{ $message }}</p>
                        @enderror
                        <div class="flex justify-end mt-2">
                            <a href="{{ route('password.request') }}" class="text-sm text-green-700 font-medium hover:underline">Lupa Kata Sandi?</a>
                        </div>
                    </div>

                    <button type="submit"
                        class="btn-submit w-full py-3 md:py-4 bg-green-600 text-white rounded-xl font-bold text-base md:text-lg shadow-lg shadow-green-200 hover:bg-green-700 focus:ring-4 focus:ring-green-200 outline-none">
                        Masuk Sekarang
                    </button>

                    <div class="mt-6 text-center">
                        <p class="text-gray-500 text-sm">
                            Belum memiliki akun? <br class="md:hidden">
                            <a href="{{ route('register') }}" class="text-green-700 font-bold hover:underline">Daftar Akun Baru</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.setAttribute('data-lucide', isPassword ? 'eye-off' : 'eye');
            lucide.createIcons();
        });
    </script>
</body>
</html>
