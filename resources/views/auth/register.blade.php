<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar - Tracer Alumni UIN Raden Mas Said</title>
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
                <h1 class="text-xl md:text-3xl font-bold mb-2 tracking-tight leading-tight">Tracer Alumni</h1>
                <p class="text-green-100 text-xs md:text-sm font-light leading-relaxed">
                    UIN Raden Mas Said Surakarta
                </p>

                <div class="hidden md:block mt-8 pt-8 border-t border-green-600/50 text-[10px] text-green-300 uppercase tracking-widest leading-relaxed">
                    Membangun Jejaring <br> Menginspirasi Masa Depan
                </div>
            </div>

            <form method="POST" action="{{ route('register') }}" class="w-full md:w-7/12 p-6 sm:p-10 lg:p-12 space-y-4">
                @csrf
                <div class="mb-6 text-center md:text-left">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Daftar Akun</h2>
                    <p class="text-gray-500 text-sm">Lengkapi data Anda untuk bergabung</p>
                </div>

                <div class="space-y-1">
                    <label for="name" class="block text-gray-700 text-sm font-semibold ml-1">Nama Lengkap</label>
                    <div class="relative group">
                        <i data-lucide="user" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4 group-focus-within:text-green-600"></i>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            placeholder="Nama lengkap Anda"
                            class="input-field w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none text-sm text-gray-800">
                    </div>
                    @error('name') <p class="text-red-500 text-[10px] mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1">
                    <label for="email" class="block text-gray-700 text-sm font-semibold ml-1">Email Kampus</label>
                    <div class="relative group">
                        <i data-lucide="mail" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4 group-focus-within:text-green-600"></i>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            placeholder="nama@student.uin.ac.id"
                            class="input-field w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none text-sm text-gray-800">
                    </div>
                    @error('email') <p class="text-red-500 text-[10px] mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1">
                    <label for="password" class="block text-gray-700 text-sm font-semibold ml-1">Password</label>
                    <div class="relative group">
                        <i data-lucide="lock" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4 group-focus-within:text-green-600"></i>
                        <input type="password" name="password" id="password" required
                            placeholder="Min. 8 karakter"
                            class="input-field w-full pl-10 pr-12 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none text-sm text-gray-800">
                        <button type="button" class="toggle-password absolute right-3 top-1/2 -translate-y-1/2 p-2 text-gray-400 hover:text-green-600 transition-colors" data-input="password">
                            <i data-lucide="eye" class="w-4 h-4 eye-icon"></i>
                        </button>
                    </div>
                    @error('password') <p class="text-red-500 text-[10px] mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-semibold ml-1">Konfirmasi Password</label>
                    <div class="relative group">
                        <i data-lucide="check-circle" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4 group-focus-within:text-green-600"></i>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            placeholder="Ulangi password"
                            class="input-field w-full pl-10 pr-12 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none text-sm text-gray-800">
                        <button type="button" class="toggle-password absolute right-3 top-1/2 -translate-y-1/2 p-2 text-gray-400 hover:text-green-600 transition-colors" data-input="password_confirmation">
                            <i data-lucide="eye" class="w-4 h-4 eye-icon"></i>
                        </button>
                    </div>
                    @error('password_confirmation') <p class="text-red-500 text-[10px] mt-1 ml-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit"
                    class="btn-submit w-full py-3.5 bg-green-600 text-white rounded-xl font-bold text-base shadow-lg shadow-green-200 hover:bg-green-700 focus:ring-4 focus:ring-green-200 outline-none transition-all">
                    Daftar Sekarang
                </button>

                <p class="text-center text-sm text-gray-500 pt-2">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}" class="text-green-700 font-bold hover:underline">Login di sini</a>
                </p>
            </form>
        </div>
    </div>

    <script>
        // Inisialisasi awal ikon Lucide
        lucide.createIcons();

        // Logika Toggle Password yang lebih bersih dan mendukung banyak input
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const inputId = this.getAttribute('data-input');
                const input = document.getElementById(inputId);
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.setAttribute('data-lucide', 'eye-off');
                } else {
                    input.type = 'password';
                    icon.setAttribute('data-lucide', 'eye');
                }

                // Render ulang hanya ikon yang berubah agar efisien
                lucide.createIcons();
            });
        });
    </script>

</body>
</html>
