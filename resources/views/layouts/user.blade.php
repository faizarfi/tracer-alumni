<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Tracer Alumni | UIN Raden Mas Said')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" type="image/png" href="{{ asset('img/uin.png') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-heading { font-family: 'Montserrat', sans-serif; }

        /* Custom Scrollbar Modern */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #059669; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #047857; }

        /* Glassmorphism Effect */
        .glass-nav {
            background: rgba(6, 78, 59, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Modern Hover Animation */
        .nav-link {
            position: relative;
            transition: all 0.3s;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #34d399;
            transition: width 0.3s ease-in-out;
        }
        .nav-link:hover::after { width: 100%; }

        /* Card & Section Styles */
        .footer-gradient {
            background: linear-gradient(135deg, #064e3b 0%, #065f46 100%);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 flex flex-col min-h-screen">

    {{-- Navigation Bar --}}
    <nav class="glass-nav text-white sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4 group cursor-pointer">
                <div class="p-1 bg-white rounded-xl shadow-lg group-hover:rotate-12 transition-transform duration-300">
                    <img src="{{ asset('img/uin.png') }}" alt="Logo UIN" class="w-9 h-9 object-contain" />
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-extrabold tracking-tight leading-none uppercase">Tracer Alumni</span>
                    <span class="text-[10px] text-green-300 font-medium tracking-[0.2em] uppercase">UIN Raden Mas Said</span>
                </div>
            </div>

            {{-- Desktop Menu --}}
            <ul class="hidden md:flex gap-8 items-center text-[13px] font-semibold uppercase tracking-wider">
                <li><a href="{{ route('user.dashboard') }}#beranda" class="nav-link hover:text-green-300">Beranda</a></li>
                <li><a href="{{ route('user.dashboard') }}#tentang" class="nav-link hover:text-green-300">Tentang</a></li>
                <li><a href="{{ route('user.dashboard') }}#galeri" class="nav-link hover:text-green-300">Galeri</a></li>
                <li><a href="{{ route('user.dashboard') }}#faq" class="nav-link hover:text-green-300">FAQ</a></li>
                <li class="pl-4 border-l border-green-700">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="flex items-center gap-2 bg-rose-500 hover:bg-rose-600 px-5 py-2.5 rounded-lg font-bold text-xs shadow-lg shadow-rose-900/20 transition-all active:scale-95">
                            LOGOUT <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                </li>
            </ul>

            {{-- Mobile Toggle --}}
            <button id="menuToggle" class="md:hidden p-2 hover:bg-white/10 rounded-lg transition">
                <i data-lucide="menu" id="menuIcon" class="w-6 h-6 text-white"></i>
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobileMenu" class="hidden md:hidden border-t border-white/10 bg-green-900/95 backdrop-blur-lg">
            <div class="px-6 py-6 flex flex-col gap-4 font-semibold uppercase text-xs tracking-widest">
                <a href="{{ route('user.dashboard') }}#beranda" class="py-2 hover:text-green-400">Beranda</a>
                <a href="{{ route('user.dashboard') }}#tentang" class="py-2 hover:text-green-400">Tentang</a>
                <a href="{{ route('user.dashboard') }}#galeri" class="py-2 hover:text-green-400">Galeri</a>
                <a href="{{ route('user.dashboard') }}#faq" class="py-2 hover:text-green-400">FAQ</a>
                <form action="{{ route('logout') }}" method="POST" class="pt-2">
                    @csrf
                    <button class="w-full flex justify-center items-center gap-2 bg-rose-600 py-3 rounded-xl font-bold">
                        LOGOUT <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer-gradient text-white pt-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <div class="space-y-6">
                    <h2 class="text-2xl font-bold tracking-tight">Tracer Alumni<br><span class="text-green-400">UIN RMS</span></h2>
                    <p class="text-green-100/70 leading-relaxed">
                        Membangun jembatan antara institusi dan alumni untuk masa depan pendidikan yang lebih inklusif dan berkualitas.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="p-2 bg-white/10 hover:bg-white/20 rounded-full transition"><i data-lucide="instagram" class="w-5 h-5"></i></a>
                        <a href="#" class="p-2 bg-white/10 hover:bg-white/20 rounded-full transition"><i data-lucide="facebook" class="w-5 h-5"></i></a>
                        <a href="#" class="p-2 bg-white/10 hover:bg-white/20 rounded-full transition"><i data-lucide="twitter" class="w-5 h-5"></i></a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-6 border-b border-white/10 pb-2 inline-block">Navigasi</h3>
                    <ul class="space-y-4 text-green-100/80 font-medium">
                        <li><a href="#" class="hover:text-white flex items-center gap-3 transition"><i data-lucide="chevron-right" class="w-4 h-4 text-green-400"></i> Beranda</a></li>
                        <li><a href="#" class="hover:text-white flex items-center gap-3 transition"><i data-lucide="chevron-right" class="w-4 h-4 text-green-400"></i> Cari Alumni</a></li>
                        <li><a href="#" class="hover:text-white flex items-center gap-3 transition"><i data-lucide="chevron-right" class="w-4 h-4 text-green-400"></i> Isi Kuesioner</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-6 border-b border-white/10 pb-2 inline-block">Layanan Kampus</h3>
                    <ul class="space-y-4 text-green-100/80 font-medium">
                        <li><a href="https://uinsaid.ac.id" target="_blank" class="hover:text-white flex items-center gap-3 transition"><i data-lucide="external-link" class="w-4 h-4 text-green-400"></i> Website UIN</a></li>
                        <li><a href="https://pmb.uinsaid.ac.id" target="_blank" class="hover:text-white flex items-center gap-3 transition"><i data-lucide="external-link" class="w-4 h-4 text-green-400"></i> PMB Online</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-6 border-b border-white/10 pb-2 inline-block">Kontak</h3>
                    <ul class="space-y-4 text-green-100/80">
                        <li class="flex items-start gap-3">
                            <i data-lucide="map-pin" class="w-5 h-5 text-green-400 shrink-0"></i>
                            <span>Jl. Pandawa, Pucangan, Kartasura, Sukoharjo</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i data-lucide="mail" class="w-5 h-5 text-green-400"></i>
                            <a href="mailto:tracer@uinsaid.ac.id" class="hover:text-white transition">tracer@uinsaid.ac.id</a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Maps Section --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
    <div class="w-full h-80 rounded-xl overflow-hidden shadow-2xl border-2 border-green-700/50">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.126348821033!2d110.7324527!3d-7.5588441!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a14c215cc8bbd%3A0x27ec268341f7725a!2sUniversitas%20Islam%20Negeri%20Raden%20Mas%20Said%20Surakarta!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
            width="100%"
            height="100%"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</div>
            <div class="py-10 mt-10 border-t border-white/5 text-center">
                <p class="text-xs text-green-400/60 font-medium tracking-widest">
                    &copy; {{ date('Y') }} UIN RADEN MAS SAID SURAKARTA. ALL RIGHTS RESERVED.
                </p>
            </div>
        </div>
    </footer>

    {{-- Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Icons
            lucide.createIcons();

            // Mobile Menu Animation
            const toggleBtn = document.getElementById('menuToggle');
            const mobileMenu = document.getElementById('mobileMenu');
            const menuIcon = document.getElementById('menuIcon');

            toggleBtn.addEventListener('click', () => {
                const isHidden = mobileMenu.classList.toggle('hidden');
                // Change icon manually if needed or let Lucide handle it
                if (!isHidden) {
                    toggleBtn.innerHTML = '<i data-lucide="x" class="w-6 h-6 text-white"></i>';
                } else {
                    toggleBtn.innerHTML = '<i data-lucide="menu" class="w-6 h-6 text-white"></i>';
                }
                lucide.createIcons();
            });

            // Navbar scroll effect
            window.addEventListener('scroll', () => {
                const nav = document.querySelector('nav');
                if (window.scrollY > 50) {
                    nav.classList.add('py-2', 'shadow-2xl');
                    nav.classList.remove('py-4');
                } else {
                    nav.classList.add('py-4');
                    nav.classList.remove('py-2', 'shadow-2xl');
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Global handler for forms that require confirmation using SweetAlert2
        document.addEventListener('submit', function(e){
            const form = e.target;
            if (form.classList && form.classList.contains('swal-confirm')) {
                e.preventDefault();
                const msg = form.dataset.confirm || 'Apakah Anda yakin?';
                Swal.fire({
                    title: 'Konfirmasi',
                    text: msg,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            }
        }, true);

        // Server-side flash messages -> SweetAlert2
        @if(session('success'))
            Swal.fire({icon:'success', title:'Berhasil', text: @json(session('success'))});
        @endif
        @if(session('error'))
            Swal.fire({icon:'error', title:'Gagal', text: @json(session('error'))});
        @endif
    </script>
</body>
</html>
