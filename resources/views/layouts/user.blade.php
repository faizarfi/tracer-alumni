<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Tracer Alumni UIN RMS')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" type="image/png" href="{{ asset('img/uin.png') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* Global Styles for smooth scroll and font consistency */
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; @apply text-gray-800; }
        h1, h2, h3, h4 { font-family: 'Poppins', sans-serif; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f0fdf4; }
        ::-webkit-scrollbar-thumb { background: #065f46; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #047857; }

        /* Fade in animation */
        @keyframes fade-in { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fade-in 0.8s ease-out forwards; }

        /* Profile image styling */
        .profile-img-container {
            width: 150px; height: 150px; border-radius: 50%; overflow: hidden;
            border: 4px solid #10b981; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }
        .profile-img-container:hover { transform: scale(1.05); }

        /* Input focus glow effect */
        input:focus, select:focus, textarea:focus {
            --tw-ring-color: #34d399 !important;
            border-color: #10b981 !important;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-green-100 via-white to-white min-h-screen flex flex-col">

    {{-- Navigation Bar (Header) --}}
    <nav class="bg-gradient-to-r from-green-900 to-emerald-800 text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/uin.png') }}" alt="Logo UIN" class="w-10 h-10 rounded-full bg-white p-0.5 shadow-md" />
                <span class="text-xl font-extrabold tracking-wide select-none font-['Poppins']">Tracer Alumni</span>
            </div>
            <ul class="hidden md:flex gap-6 items-center text-sm font-semibold tracking-wide">
                <li><a href="{{ route('user.dashboard') }}#beranda" class="relative group py-2 hover:text-green-200 transition duration-300">Beranda<span class="absolute left-0 bottom-0 w-full h-0.5 bg-white scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span></a></li>
                <li><a href="{{ route('user.dashboard') }}#tentang" class="relative group py-2 hover:text-green-200 transition duration-300">Tentang<span class="absolute left-0 bottom-0 w-full h-0.5 bg-white scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span></a></li>
                <li><a href="{{ route('user.dashboard') }}#galeri" class="relative group py-2 hover:text-green-200 transition duration-300">Galeri<span class="absolute left-0 bottom-0 w-full h-0.5 bg-white scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span></a></li>
                <li><a href="{{ route('user.dashboard') }}#faq" class="relative group py-2 hover:text-green-200 transition duration-300">FAQ<span class="absolute left-0 bottom-0 w-full h-0.5 bg-white scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span></a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button
                            class="bg-red-600 hover:bg-red-700 focus:ring-2 focus:ring-red-400 focus:ring-offset-1 focus:ring-offset-green-900 text-white py-2 px-5 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                            Logout <i data-lucide="log-out" class="inline-block w-4 h-4 ml-1"></i>
                        </button>
                    </form>
                </li>
            </ul>
            <button id="menuToggle" class="md:hidden focus:outline-none text-white p-2 rounded-md hover:bg-green-700 transition">
                <span class="iconify" data-icon="mdi:menu" style="font-size: 28px;"></span>
            </button>
        </div>
        <div id="mobileMenu" class="hidden md:hidden bg-green-800 text-white px-5 pb-4 transition-all duration-300 ease-in-out">
            <ul class="flex flex-col gap-3 pt-2 text-base font-semibold">
                <li><a href="{{ route('user.dashboard') }}#beranda" class="block py-2 px-3 rounded-md hover:bg-green-700 transition duration-200">Beranda</a></li>
                <li><a href="{{ route('user.dashboard') }}#tentang" class="block py-2 px-3 rounded-md hover:bg-green-700 transition duration-200">Tentang</a></li>
                <li><a href="{{ route('user.dashboard') }}#galeri" class="block py-2 px-3 rounded-md hover:bg-green-700 transition duration-200">Galeri</a></li>
                <li><a href="{{ route('user.dashboard') }}#faq" class="block py-2 px-3 rounded-md hover:bg-green-700 transition duration-200">FAQ</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button
                            class="w-full bg-red-600 hover:bg-red-700 py-2 rounded-md shadow-md transition duration-300 mt-2">
                            Logout <i data-lucide="log-out" class="inline-block w-4 h-4 ml-1"></i>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    {{-- Main Content Section --}}
    <div class="flex-grow">
        @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="bg-gradient-to-r from-green-900 to-emerald-800 text-white mt-16 pt-16 pb-8 shadow-inner">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 text-sm">
            <div>
                <h2 class="text-xl font-bold mb-4 font-['Poppins']">Tracer Alumni UIN RMS</h2>
                <p class="text-green-200 leading-relaxed text-sm">
                    Sistem Tracer Alumni ini dirancang untuk menghimpun data alumni, mendukung peningkatan mutu pendidikan, dan akreditasi kampus.
                    Partisipasi Anda sangat berarti!
                </p>
            </div>

            <div>
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2 font-['Poppins']" aria-label="Navigasi Cepat">
                    <i data-lucide="compass" class="w-5 h-5 text-green-300"></i> Navigasi Cepat
                </h2>
                <ul class="space-y-3 text-green-200">
                    <li>
                        <a href="{{ route('user.dashboard') }}#beranda" class="flex items-center gap-2 hover:text-white transition duration-300 ease-in-out">
                            <i data-lucide="info" class="w-4 h-4"></i> Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.dashboard') }}#tentang" class="flex items-center gap-2 hover:text-white transition duration-300 ease-in-out">
                            <i data-lucide="info" class="w-4 h-4"></i> Tentang Tracer
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.kuisioner') }}" class="flex items-center gap-2 hover:text-white transition duration-300 ease-in-out">
                            <i data-lucide="clipboard-check" class="w-4 h-4"></i> Isi Kuesioner
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.cari-alumni') }}" class="flex items-center gap-2 hover:text-white transition duration-300 ease-in-out">
                            <i data-lucide="search" class="w-4 h-4"></i> Cari Alumni
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.dashboard') }}#galeri" class="flex items-center gap-2 hover:text-white transition duration-300 ease-in-out">
                            <i data-lucide="image" class="w-4 h-4"></i> Galeri
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.dashboard') }}#faq" class="flex items-center gap-2 hover:text-white transition duration-300 ease-in-out">
                            <i data-lucide="help-circle" class="w-4 h-4"></i> FAQ
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h2 class="text-xl font-bold mb-4 font-['Poppins']">Tautan Terkait</h2>
                <ul class="space-y-3 text-green-200">
                    <li>
                        <a href="https://uinsaid.ac.id" target="_blank" rel="noopener noreferrer" class="hover:underline flex items-center gap-2">
                            <i data-lucide="globe" class="w-4 h-4"></i> Website Resmi UIN RMS
                        </a>
                    </li>
                    <li>
                        <a href="https://pmb.uinsaid.ac.id" target="_blank" rel="noopener noreferrer" class="hover:underline flex items-center gap-2">
                            <i data-lucide="graduation-cap" class="w-4 h-4"></i> PMB UIN RMS
                        </a>
                    </li>
                    <li>
                        <a href="https://e-journal.uinsaid.ac.id/" target="_blank" rel="noopener noreferrer" class="hover:underline flex items-center gap-2">
                            <i data-lucide="book-text" class="w-4 h-4"></i> E-Journal UIN RMS
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h2 class="text-xl font-bold mb-4 font-['Poppins']">Kontak Kami</h2>
                <ul class="text-green-200 space-y-3">
                    <li>
                        <i data-lucide="mail" class="inline-block w-4 h-4 mr-2"></i>
                        <a href="mailto:tracer@uinsaid.ac.id" class="hover:underline" target="_blank">tracer@uinsaid.ac.id</a>
                    </li>
                    <li>
                        <i data-lucide="phone" class="inline-block w-4 h-4 mr-2"></i> (0271) 678901
                    </li>
                    <li>
                        <i data-lucide="instagram" class="inline-block w-4 h-4 mr-2"></i>
                        <a href="#" class="hover:underline" target="_blank">@traceruinrms</a>
                    </li>
                    <li>
                        <i data-lucide="map-pin" class="inline-block w-4 h-4 mr-2"></i>
                        Jl. Pandawa, Pucangan, Kartasura, Sukoharjo, Jawa Tengah 57168
                    </li>
                </ul>
            </div>
        </div>

        <div class="text-center text-green-300 text-xs border-t border-green-800 py-6 mt-12">
            &copy; {{ date('Y') }} UIN Raden Mas Said Surakarta. Hak Cipta Dilindungi Undang-Undang.
        </div>
    </footer>

    {{-- Mobile Menu Toggle Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('menuToggle');
            const mobileMenu = document.getElementById('mobileMenu');
            if (toggleBtn && mobileMenu) {
                toggleBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }
            lucide.createIcons();
        });
    </script>
</body>

</html>
