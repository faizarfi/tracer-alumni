<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracer Alumni | UIN Raden Mas Said Surakarta</title>

    <link rel="icon" type="image/png" href="{{ asset('img/uin.png') }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }

        .hero-section {
            background: radial-gradient(circle at 10% 10%, #d1fae5 0%, #f8fafc 100%);
        }

        /* Glassmorphism identik dengan Dashboard */
        .glass-card-premium {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(16, 185, 129, 0.1);
        }

        /* Orbit Background Statis */
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

        /* Responsive hero heading */
        .hero-section h1 { font-size: clamp(1.6rem, 4.5vw, 3.5rem); }

        /* Visible skip link on focus */
        .skip-link { position: absolute; left: 1rem; top: 0.75rem; background: #064e3b; color: #fff; padding: 0.35rem 0.75rem; border-radius: 6px; z-index: 60; transform: translateY(-120%); transition: transform .15s ease; }
        .skip-link:focus { transform: translateY(0%); outline: 3px solid rgba(6,78,59,0.25); }
    </style>
</head>
<body class="antialiased text-slate-900">

    <a href="#beranda" class="skip-link">Skip to content</a>
    <nav class="w-full glass-nav">
        <div class="max-w-7xl mx-auto px-6 h-20 grid grid-cols-2 md:grid-cols-3 items-center">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/uin.png') }}" class="w-8 h-8 sm:w-10 sm:h-10 object-contain" alt="Logo">
                <div class="hidden sm:block">
                    <span class="block font-black text-emerald-900 leading-none uppercase tracking-tighter text-sm">Tracer Study</span>
                    <span class="text-[9px] font-bold text-emerald-600 uppercase tracking-widest">UIN Raden Mas Said</span>
                </div>
            </div>

            <div class="hidden lg:grid relative place-items-center text-[11px] font-black uppercase tracking-widest text-slate-700">
                <div class="grid grid-flow-col gap-8 items-center bg-emerald-50 border border-emerald-100 px-6 py-2 rounded-full">
                    <div class="flex flex-col items-center group">
                        <a href="#beranda" class="text-slate-700 hover:text-emerald-700 transition-all">Beranda</a>
                        <span class="block mt-2 h-0.5 w-0 bg-emerald-600 rounded-full opacity-0 group-hover:opacity-100 group-hover:w-full transition-all"></span>
                    </div>
                    <div class="flex flex-col items-center group">
                        <a href="#tentang" class="text-slate-700 hover:text-emerald-700 transition-all">Tentang</a>
                        <span class="block mt-2 h-0.5 w-0 bg-emerald-600 rounded-full opacity-0 group-hover:opacity-100 group-hover:w-full transition-all"></span>
                    </div>
                    <div class="flex flex-col items-center group">
                        <a href="#alur" class="text-slate-700 hover:text-emerald-700 transition-all">Alur</a>
                        <span class="block mt-2 h-0.5 w-0 bg-emerald-600 rounded-full opacity-0 group-hover:opacity-100 group-hover:w-full transition-all"></span>
                    </div>
                    <div class="flex flex-col items-center group">
                        <a href="#faq" class="text-slate-700 hover:text-emerald-700 transition-all">Informasi</a>
                        <span class="block mt-2 h-0.5 w-0 bg-emerald-600 rounded-full opacity-0 group-hover:opacity-100 group-hover:w-full transition-all"></span>
                    </div>
                </div>
                <!-- subtle divider under center links -->
                <div class="absolute left-1/2 transform -translate-x-1/2 bottom-0 w-1/3 h-[1px] bg-emerald-200"></div>
            </div>

            <div class="flex items-center justify-end gap-4">
                <!-- mobile toggle kept on the right for easy reach -->
                <button id="mobileMenuButton" aria-label="Open menu" aria-expanded="false" aria-controls="mobileMenu" class="lg:hidden p-3 rounded-md text-slate-600 hover:bg-emerald-50 transition z-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <a href="{{ route('login') }}" class="hidden lg:inline-flex text-emerald-700 border border-emerald-100 bg-white/0 hover:bg-emerald-50 text-[11px] font-black uppercase tracking-[0.2em] px-5 py-2.5 rounded-xl shadow-sm">Masuk</a>
                <a href="{{ route('register') }}" class="hidden lg:inline-flex btn-emerald-deep text-white text-[11px] font-black uppercase tracking-[0.2em] px-7 py-3 rounded-2xl shadow-lg">Daftar</a>
            </div>
        </div>
    </nav>

    <!-- Mobile menu (hidden by default) -->
    <div id="mobileMenu" class="lg:hidden hidden bg-white/95 backdrop-blur-sm border-b border-emerald-50 z-50" role="dialog" aria-modal="false">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex flex-col gap-3">
                <a href="#beranda" class="text-slate-700 font-bold uppercase">Beranda</a>
                <a href="#tentang" class="text-slate-700 font-bold uppercase">Tentang</a>
                <a href="#alur" class="text-slate-700 font-bold uppercase">Alur</a>
                <a href="#faq" class="text-slate-700 font-bold uppercase">Informasi</a>
                <div class="mt-3 flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="w-full text-center py-2 rounded-xl border border-emerald-100 font-black uppercase text-emerald-900">Masuk</a>
                    <a href="{{ route('register') }}" class="w-full text-center py-2 rounded-xl bg-emerald-900 text-white font-black uppercase">Daftar</a>
                </div>
            </div>
        </div>
    </div>

    <div id="beranda" class="hero-section min-h-screen flex items-center pt-8 lg:pt-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <div class="relative z-20 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-[0.2em] mb-8 border border-emerald-100">
                    <i data-lucide="award" class="w-4 h-4"></i> Portal Resmi Alumni
                </div>

                <h1 class="text-4xl md:text-6xl font-black text-slate-900 leading-tight tracking-tighter mb-8">
                    Satu Langkah <br>
                    Untuk <span class="text-emerald-700">Almamater</span> <br>
                    Masa Depan.
                </h1>

                <p class="text-slate-500 text-lg leading-relaxed max-w-lg mx-auto lg:mx-0 mb-12 font-medium opacity-80">
                    Partisipasi Anda dalam mengisi kuesioner Tracer Study sangat krusial bagi peningkatan kualitas kurikulum dan akreditasi internasional kampus kita.
                </p>

                <div class="flex justify-center lg:justify-start mb-16">
                    <a href="{{ route('register') }}" class="btn-emerald-deep text-white px-10 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] flex items-center gap-3 shadow-xl">
                        Mulai Pengisian <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>

                <div class="grid grid-cols-3 gap-8 border-t border-slate-200 pt-10 max-w-md mx-auto lg:mx-0">
                    <div>
                        <p class="text-3xl font-black text-emerald-900">5K+</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Alumni</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-emerald-900">85%</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Bekerja</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-emerald-900">A+</p>
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

    <section id="tentang" class="max-w-7xl mx-auto px-6 py-24">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-emerald-950 p-10 md:p-14 rounded-[3rem] text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full -mr-16 -mt-16"></div>
                <h3 class="text-[10px] font-black uppercase tracking-[0.4em] mb-6 text-emerald-400">Visi Kami</h3>
                <p class="text-xl md:text-2xl font-bold leading-relaxed opacity-90">
                    "Menjadi rujukan pangkalan data alumni yang akurat dan terintegrasi untuk mendukung UIN Raden Mas Said Surakarta sebagai pusat keunggulan pendidikan islam internasional."
                </p>
            </div>
            <div class="bg-white p-10 md:p-14 rounded-[3rem] border border-slate-200 shadow-sm">
                <h3 class="text-[10px] font-black uppercase tracking-[0.4em] mb-6 text-emerald-600">Misi Kami</h3>
                <ul class="space-y-4 text-sm font-medium text-slate-500">
                    <li class="flex items-start gap-4">
                        <span class="w-6 h-6 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-[10px] shrink-0">01</span>
                        <span>Membangun komunikasi berkelanjutan antara almamater dan alumni di berbagai sektor industri.</span>
                    </li>
                    <li class="flex items-start gap-4">
                        <span class="w-6 h-6 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-[10px] shrink-0">02</span>
                        <span>Menyajikan analisis karir yang relevan untuk evaluasi dan perbaikan kurikulum setiap program studi.</span>
                    </li>
                    <li class="flex items-start gap-4">
                        <span class="w-6 h-6 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-[10px] shrink-0">03</span>
                        <span>Memberikan layanan informasi karir dan networking yang profesional bagi seluruh lulusan.</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <section id="alur" class="py-24 bg-white border-y border-emerald-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Alur Tracer Alumni</h2>
                <div class="w-16 h-1 bg-emerald-600 mx-auto mt-4 rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center group">
                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-all shadow-sm">
                        <i data-lucide="user-plus" class="w-8 h-8"></i>
                    </div>
                    <h4 class="font-black text-xs uppercase tracking-widest mb-2">1. Registrasi Akun</h4>
                    <p class="text-xs text-slate-400 font-medium leading-relaxed">Daftarkan akun menggunakan nama sesuai ijazah.</p>
                </div>
                <div class="text-center group">
                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-all shadow-sm">
                        <i data-lucide="shield-check" class="w-8 h-8"></i>
                    </div>
                    <h4 class="font-black text-xs uppercase tracking-widest mb-2">2. Lengkapi Profil</h4>
                    <p class="text-xs text-slate-400 font-medium leading-relaxed">Isi identitas diri dan riwayat pekerjaan saat ini.</p>
                </div>
                <div class="text-center group">
                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-all shadow-sm">
                        <i data-lucide="clipboard-list" class="w-8 h-8"></i>
                    </div>
                    <h4 class="font-black text-xs uppercase tracking-widest mb-2">3. Isi Kuesioner</h4>
                    <p class="text-xs text-slate-400 font-medium leading-relaxed">Berikan respon pada butir kuesioner yang tersedia.</p>
                </div>
                <div class="text-center group">
                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-all shadow-sm">
                        <i data-lucide="check-circle" class="w-8 h-8"></i>
                    </div>
                    <h4 class="font-black text-xs uppercase tracking-widest mb-2">4. Selesai</h4>
                    <p class="text-xs text-slate-400 font-medium leading-relaxed">Data Anda akan otomatis masuk ke laporan universitas.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="max-w-7xl mx-auto px-6 py-24">
        <div class="text-center mb-16">
            <span class="text-emerald-600 text-[10px] font-black uppercase tracking-[0.4em]">Benefits & FAQ</span>
            <h2 class="text-3xl font-black text-slate-900 mt-4 tracking-tighter uppercase">Informasi Layanan</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="glass-card-premium p-10 rounded-[2.5rem] shadow-sm">
                <i data-lucide="database" class="w-10 h-10 text-emerald-600 mb-6"></i>
                <h3 class="text-lg font-black text-slate-900 mb-4 uppercase tracking-tight leading-none">Keamanan Data <br> Terjamin</h3>
                <p class="text-slate-500 text-xs leading-relaxed font-medium">Data Anda dijamin kerahasiaannya dan hanya digunakan untuk pelaporan statistik pendidikan nasional.</p>
            </div>
            <div class="glass-card-premium p-10 rounded-[2.5rem] shadow-sm">
                <i data-lucide="users" class="w-10 h-10 text-blue-600 mb-6"></i>
                <h3 class="text-lg font-black text-slate-900 mb-4 uppercase tracking-tight leading-none">Jejaring Alumni <br> Terpusat</h3>
                <p class="text-slate-500 text-xs leading-relaxed font-medium">Membangun koneksi antara lulusan dengan universitas guna memfasilitasi program bantuan karir.</p>
            </div>
            <div class="glass-card-premium p-10 rounded-[2.5rem] shadow-sm border-t-8 border-t-emerald-600">
                <i data-lucide="award" class="w-10 h-10 text-amber-600 mb-6"></i>
                <h3 class="text-lg font-black text-slate-900 mb-4 uppercase tracking-tight leading-none">Validasi <br> Akreditasi</h3>
                <p class="text-slate-500 text-xs leading-relaxed font-medium">Respon Anda membantu program studi meraih peringkat 'Unggul' melalui data serapan kerja.</p>
            </div>
        </div>
    </section>

    <footer class="bg-gradient-to-r from-green-950 to-emerald-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 gap-8 md:grid-cols-3 md:gap-12 pb-8 border-b border-white/10">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('img/uin.png') }}" class="w-9 h-9 sm:w-10 sm:h-10 object-contain bg-white rounded-lg p-1" alt="">
                    <span class="font-black text-white tracking-tighter md:uppercase text-lg">UIN RMS Surakarta</span>
                </div>
                <p class="text-green-200 text-sm leading-relaxed max-w-full md:max-w-xs opacity-80">
                    Jl. Pandawa, Pucangan, Kartasura, Sukoharjo, Jawa Tengah 57168.
                </p>
                <div class="flex gap-3 mt-1">
                    <a href="#" class="p-2 bg-white/10 hover:bg-white/20 rounded-lg transition"><i data-lucide="instagram" class="w-4 h-4"></i></a>
                    <a href="#" class="p-2 bg-white/10 hover:bg-white/20 rounded-lg transition"><i data-lucide="facebook" class="w-4 h-4"></i></a>
                </div>
            </div>

            <div class="col-span-1 md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-[12px] font-black md:uppercase md:tracking-[0.3em] text-green-300 mb-4">Navigasi</h4>
                    <ul class="space-y-3 text-[13px] font-medium text-green-100 leading-snug">
                        <li><a href="#beranda" class="hover:text-white transition-all flex items-center gap-2"><i data-lucide="chevron-right" class="w-4 h-4 text-green-400"></i> Beranda</a></li>
                        <li><a href="#tentang" class="hover:text-white transition-all flex items-center gap-2"><i data-lucide="chevron-right" class="w-4 h-4 text-green-400"></i> Tentang Kami</a></li>
                        <li><a href="#faq" class="hover:text-white transition-all flex items-center gap-2"><i data-lucide="chevron-right" class="w-4 h-4 text-green-400"></i> Informasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-[12px] font-black md:uppercase md:tracking-[0.3em] text-green-300 mb-4">Bantuan</h4>
                    <ul class="space-y-3 text-[13px] font-medium text-green-100 leading-snug">
                        <li class="flex items-center gap-3"><i data-lucide="mail" class="w-4 h-4 text-green-400"></i> <a href="mailto:tracer@uinsaid.ac.id" class="hover:text-white">tracer@uinsaid.ac.id</a></li>
                        <li class="flex items-center gap-3"><i data-lucide="phone" class="w-4 h-4 text-green-400"></i> <a href="tel:+62271678901" class="hover:text-white">(0271) 678901</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 pt-6 flex flex-col md:flex-row justify-between items-center gap-4 text-center">
            <p class="text-[12px] font-medium text-green-200 opacity-80 md:text-left">
                &copy; {{ date('Y') }} Tracer Alumnus Team — UIN Raden Mas Said Surakarta.
            </p>
            <div class="flex items-center gap-2 px-3 py-1 bg-white/5 rounded-full border border-white/10">
                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                <span class="text-[12px] font-medium text-green-200">System Online</span>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        (function(){
            const btn = document.getElementById('mobileMenuButton');
            const menu = document.getElementById('mobileMenu');
            if(btn && menu){
                btn.addEventListener('click', function(e){
                    e.stopPropagation();
                    const expanded = btn.getAttribute('aria-expanded') === 'true';
                    btn.setAttribute('aria-expanded', String(!expanded));
                    menu.classList.toggle('hidden');
                });

                // close menu when clicking outside
                document.addEventListener('click', function(e){
                    if(!menu.classList.contains('hidden')){
                        const target = e.target;
                        if(!menu.contains(target) && !btn.contains(target)){
                            menu.classList.add('hidden');
                            btn.setAttribute('aria-expanded', 'false');
                        }
                    }
                });
            }
        })();

        lucide.createIcons();
    </script>
</body>
</html>
