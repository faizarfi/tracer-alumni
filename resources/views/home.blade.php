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

        /* Orbit Background Statis (Batas Jelas) */
        .orbit-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 350px;
        }
        @media (min-width: 768px) { .orbit-container { height: 500px; } }

        .orbit-circle {
            position: absolute;
            border: 1px dashed rgba(6, 95, 70, 0.15);
            border-radius: 50%;
        }
        .circle-1 { width: 280px; height: 280px; }
        .circle-2 { width: 420px; height: 420px; }

        /* Floating Card Statis */
        .floating-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .btn-emerald-deep {
            background-color: #064e3b;
            transition: all 0.3s ease;
        }
        .btn-emerald-deep:hover {
            background-color: #065f46;
            transform: translateY(-2px);
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
        }
    </style>
</head>
<body class="antialiased text-slate-900">

    <nav class="fixed top-0 w-full z-[100] glass-nav">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/uin.png') }}" class="w-10 h-10 object-contain" alt="Logo">
                <div class="hidden sm:block">
                    <span class="block font-black text-emerald-900 leading-none uppercase tracking-tighter text-sm">Tracer Study</span>
                    <span class="text-[9px] font-bold text-emerald-600 uppercase tracking-widest">UIN Raden Mas Said</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-[11px] font-black uppercase tracking-[0.2em] text-emerald-900 px-5 py-2.5 rounded-xl hover:bg-emerald-50 transition-all">Masuk</a>
                <a href="{{ route('register') }}" class="btn-emerald-deep text-white text-[11px] font-black uppercase tracking-[0.2em] px-7 py-3 rounded-2xl shadow-lg">Daftar</a>
            </div>
        </div>
    </nav>

    <div id="beranda" class="hero-section min-h-screen flex items-center pt-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <div class="relative z-20 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-emerald-50 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-[0.2em] mb-8 border border-emerald-100">
                    Portal Resmi Alumni
                </div>

                <h1 class="text-4xl md:text-6xl font-black text-slate-900 leading-tight tracking-tighter mb-8">
                    Kontribusi Nyata <br>
                    Untuk <span class="text-emerald-700">SEMUA</span>
                </h1>

                <p class="text-slate-500 text-lg leading-relaxed max-w-lg mx-auto lg:mx-0 mb-12 font-medium opacity-80">
                    Partisipasi Anda dalam Tracer Study membantu pengembangan mutu pendidikan dan akreditasi universitas.
                </p>

                <div class="flex justify-center lg:justify-start mb-16">
                    <a href="{{ route('register') }}" class="btn-emerald-deep text-white px-10 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] flex items-center gap-3 shadow-xl">
                        Mulai Sekarang <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-8 border-t border-slate-200 pt-10 max-w-sm mx-auto lg:mx-0">
                    <div>
                        <p class="text-3xl font-black text-emerald-900">5K+</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Total Alumni</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-emerald-900">A</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Akreditasi</p>
                    </div>
                </div>
            </div>

            <div class="relative flex items-center justify-center">
                <div class="orbit-container">
                    <div class="orbit-circle circle-1"></div>
                    <div class="orbit-circle circle-2"></div>

                    <div class="relative z-10 w-64 h-64 md:w-80 md:h-80 bg-white rounded-[3.5rem] shadow-2xl flex items-center justify-center p-12 border-[12px] border-emerald-50/50 backdrop-blur-sm">
                        <img src="{{ asset('img/uin.png') }}" class="w-full h-full object-contain" alt="UIN RMS">
                    </div>

                    <div class="floating-card absolute top-5 right-5 md:top-10 md:right-20 p-4 rounded-2xl">
                        <i data-lucide="check-circle-2" class="w-6 h-6 text-emerald-600"></i>
                    </div>
                    <div class="floating-card absolute bottom-10 left-5 md:bottom-20 md:left-10 p-4 rounded-2xl">
                        <i data-lucide="graduation-cap" class="w-8 h-8 text-emerald-500"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="manfaat" class="max-w-7xl mx-auto px-6 py-24">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Manfaat Bergabung</h2>
            <div class="w-16 h-1 bg-emerald-600 mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm transition-all hover:shadow-md">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-6">
                    <i data-lucide="database" class="w-6 h-6"></i>
                </div>
                <h3 class="text-lg font-black text-slate-900 mb-3 uppercase tracking-tight">Database Resmi</h3>
                <p class="text-slate-500 text-sm leading-relaxed font-medium">Data Anda tersimpan aman sebagai acuan pengembangan universitas.</p>
            </div>

            <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm transition-all hover:shadow-md">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-6">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <h3 class="text-lg font-black text-slate-900 mb-3 uppercase tracking-tight">Jejaring Alumni</h3>
                <p class="text-slate-500 text-sm leading-relaxed font-medium">Mempermudah koneksi profesional antar lulusan UIN Raden Mas Said.</p>
            </div>

            <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm transition-all hover:shadow-md">
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-6">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <h3 class="text-lg font-black text-slate-900 mb-3 uppercase tracking-tight">Validitas Data</h3>
                <p class="text-slate-500 text-sm leading-relaxed font-medium">Informasi resmi yang digunakan untuk keperluan akreditasi program studi.</p>
            </div>
        </div>
    </section>

    <footer class="bg-gradient-to-r from-green-900 to-emerald-800 text-white pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-12 pb-16 border-b border-white/10">
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('img/uin.png') }}" class="w-10 h-10 object-contain" alt="">
                    <span class="font-black text-white tracking-tighter uppercase text-lg">UIN RMS Surakarta</span>
                </div>
                <p class="text-green-100 text-xs leading-relaxed max-w-xs uppercase font-bold tracking-widest opacity-70">
                    Jl. Pandawa, Pucangan, Kartasura, Sukoharjo, Jawa Tengah 57168.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-8 md:col-span-2">
                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-green-300 mb-6 italic">Quick Navigation</h4>
                    <ul class="space-y-3 text-[10px] font-bold text-green-100 uppercase tracking-widest opacity-80">
                        <li><a href="#" class="hover:text-white">Beranda</a></li>
                        <li><a href="#manfaat" class="hover:text-white">Manfaat</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-[0.3em] text-green-300 mb-6 italic">Contact Us</h4>
                    <ul class="space-y-3 text-[10px] font-bold text-green-100 uppercase tracking-widest opacity-80">
                        <li class="italic font-medium">tracer@uinsaid.ac.id</li>
                        <li class="italic font-medium">(0271) 678901</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 pt-10 flex flex-col md:flex-row justify-between items-center gap-4 text-center">
            <p class="text-[9px] font-black uppercase tracking-[0.4em] text-green-400 opacity-60">
                &copy; {{ date('Y') }} Tracer Alumnus Team. UIN Raden Mas Said Surakarta.
            </p>
            <div class="flex gap-6">
                <a href="#" class="text-green-400 hover:text-white transition-all"><i data-lucide="instagram" class="w-4 h-4"></i></a>
                <a href="#" class="text-green-400 hover:text-white transition-all"><i data-lucide="facebook" class="w-4 h-4"></i></a>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
