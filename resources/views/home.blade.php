<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracer Alumni | UIN Raden Mas Said Surakarta</title>

    <link rel="icon" type="image/png" href="{{ asset('img/uin.png') }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; scroll-behavior: smooth; }

        .hero-section {
            background: radial-gradient(circle at 10% 10%, #d1fae5 0%, #f8fafc 100%);
        }

        /* Orbit Background - Animasi Dihapus (Static) */
        .orbit-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 350px;
        }

        @media (min-width: 768px) {
            .orbit-container { height: 500px; }
        }

        .orbit-circle {
            position: absolute;
            border: 1px dashed rgba(6, 95, 70, 0.15);
            border-radius: 50%;
            /* Animation Removed */
        }

        .circle-1 { width: 260px; height: 260px; }
        .circle-2 { width: 380px; height: 380px; }

        /* Floating Card - Animasi Dihapus (Static) */
        .floating-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            /* Animation Removed */
        }

        .btn-emerald {
            background-color: #064e3b;
            transition: all 0.3s ease;
        }
        .btn-emerald:hover {
            background-color: #065f46;
            transform: translateY(-2px);
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }
    </style>
</head>
<body class="antialiased text-slate-900">

    <nav class="fixed top-0 w-full z-[100] glass-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/uin.png') }}" class="w-10 h-10 object-contain" alt="Logo">
                <div class="hidden sm:block">
                    <span class="block font-extrabold text-emerald-900 leading-none uppercase tracking-tighter text-sm">Tracer Study</span>
                    <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest">UIN Raden Mas Said</span>
                </div>
            </div>

            <div class="flex items-center gap-3 sm:gap-4">
                <a href="{{ route('login') }}" class="text-[11px] font-bold uppercase tracking-widest text-emerald-900 px-4 py-2 rounded-xl hover:bg-emerald-50 transition-all">Masuk</a>
                <a href="{{ route('register') }}" class="btn-emerald text-white text-[11px] font-bold uppercase tracking-widest px-5 py-2.5 rounded-xl shadow-md text-center">Daftar</a>
            </div>
        </div>
    </nav>

    <div id="beranda" class="hero-section min-h-screen flex items-center pt-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <div class="relative z-20 order-2 lg:order-1 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-extrabold uppercase tracking-widest mb-6 border border-emerald-200">
                    Portal Resmi Alumni
                </div>

                <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 leading-tight tracking-tighter mb-6">
                    Kontribusi Nyata <br>
                    Untuk <span class="text-emerald-700">Almamater</span>
                </h1>

                <p class="text-slate-500 text-base md:text-lg leading-relaxed max-w-lg mx-auto lg:mx-0 mb-10 font-medium">
                    Partisipasi Anda dalam Tracer Study membantu pengembangan mutu pendidikan dan akreditasi universitas.
                </p>

                <div class="flex justify-center lg:justify-start mb-12">
                    <a href="{{ route('register') }}" class="btn-emerald text-white px-8 py-4 rounded-xl font-bold text-xs uppercase tracking-widest flex items-center gap-2 shadow-lg">
                        Mulai Sekarang <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-8 border-t border-slate-200 pt-8 max-w-sm mx-auto lg:mx-0">
                    <div>
                        <p class="text-3xl font-extrabold text-emerald-900">5.000+</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Total Alumni</p>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-emerald-900">A</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Akreditasi</p>
                    </div>
                </div>
            </div>

            <div class="relative order-1 lg:order-2 flex items-center justify-center">
                <div class="orbit-container">
                    <div class="orbit-circle circle-1"></div>
                    <div class="orbit-circle circle-2"></div>

                    <div class="relative z-10 w-56 h-56 md:w-72 md:h-72 bg-white rounded-3xl shadow-xl flex items-center justify-center p-10 border-8 border-emerald-50/50">
                        <img src="{{ asset('img/uin.png') }}" class="w-full h-full object-contain" alt="UIN RMS">
                    </div>

                    <div class="floating-card absolute top-10 right-10 p-3 rounded-xl">
                        <i data-lucide="graduation-cap" class="w-6 h-6 text-emerald-600"></i>
                    </div>
                    <div class="floating-card absolute bottom-10 left-10 p-3 rounded-xl">
                        <i data-lucide="briefcase" class="w-6 h-6 text-emerald-700"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="manfaat" class="max-w-7xl mx-auto px-6 py-20">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-extrabold text-slate-900 uppercase tracking-tight">Manfaat Bergabung</h2>
            <div class="w-16 h-1 bg-emerald-600 mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm transition-all hover:shadow-md">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-6">
                    <i data-lucide="database" class="w-6 h-6"></i>
                </div>
                <h3 class="text-lg font-extrabold text-slate-900 mb-3 uppercase tracking-tight">Database Resmi</h3>
                <p class="text-slate-500 text-sm leading-relaxed font-medium">Data Anda tersimpan aman sebagai acuan pengembangan universitas.</p>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm transition-all hover:shadow-md">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-6">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <h3 class="text-lg font-extrabold text-slate-900 mb-3 uppercase tracking-tight">Jejaring Alumni</h3>
                <p class="text-slate-500 text-sm leading-relaxed font-medium">Mempermudah koneksi profesional antar lulusan UIN Raden Mas Said.</p>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm transition-all hover:shadow-md">
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-6">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <h3 class="text-lg font-extrabold text-slate-900 mb-3 uppercase tracking-tight">Validitas Data</h3>
                <p class="text-slate-500 text-sm leading-relaxed font-medium">Informasi resmi yang digunakan untuk keperluan akreditasi program studi.</p>
            </div>
        </div>
    </section>

    <section id="faq" class="max-w-3xl mx-auto px-6 py-20 border-t border-slate-100">
        <h2 class="text-center text-2xl font-extrabold uppercase tracking-widest mb-12">Informasi Umum</h2>
        <div class="space-y-4">
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <h4 class="font-extrabold text-slate-800 text-xs uppercase tracking-widest">Keamanan Data</h4>
                <p class="text-slate-500 text-[11px] mt-3 leading-relaxed font-medium uppercase italic">Data hanya digunakan untuk kepentingan pelaporan statistik akreditasi universitas.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <h4 class="font-extrabold text-slate-800 text-xs uppercase tracking-widest">Proses Pengisian</h4>
                <p class="text-slate-500 text-[11px] mt-3 leading-relaxed font-medium uppercase italic">Kuesioner dirancang singkat dan dapat diselesaikan dalam waktu kurang dari 5 menit.</p>
            </div>
        </div>
    </section>

    <footer class="bg-white pt-16 pb-8 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-start gap-12 pb-12">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('img/uin.png') }}" class="w-8 h-8 object-contain" alt="">
                        <span class="font-extrabold text-slate-900 tracking-tighter uppercase text-sm leading-none">UIN RMS Surakarta</span>
                    </div>
                    <p class="text-slate-400 text-[10px] leading-relaxed max-w-xs uppercase font-bold tracking-widest">Jl. Pandawa, Pucangan, Kartasura, Sukoharjo, Jawa Tengah.</p>
                </div>

                <div class="grid grid-cols-2 gap-12">
                    <div>
                        <h4 class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-emerald-700 mb-4">Navigasi</h4>
                        <ul class="space-y-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            <li><a href="#" class="hover:text-emerald-600 transition-all">Beranda</a></li>
                            <li><a href="#" class="hover:text-emerald-600 transition-all">Statistik</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-emerald-700 mb-4">Kontak</h4>
                        <ul class="space-y-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            <li class="italic font-medium">tracer@uinsaid.ac.id</li>
                            <li class="italic font-medium">(0271) 678901</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-50 text-center md:text-left flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-[9px] font-extrabold uppercase tracking-[0.3em] text-slate-300">&copy; {{ date('Y') }} Tracer Alumni Team.</p>
                <div class="flex gap-4">
                    <a href="#" class="text-slate-300 hover:text-emerald-600 transition-all"><i data-lucide="instagram" class="w-4 h-4"></i></a>
                    <a href="#" class="text-slate-300 hover:text-emerald-600 transition-all"><i data-lucide="facebook" class="w-4 h-4"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
