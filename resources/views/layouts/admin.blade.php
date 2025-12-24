<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Dashboard Admin') - UIN Raden Mas Said</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" type="image/png" href="{{ asset('img/uin.png') }}" />

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Iconify & Lucide Icons --}}
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- Chart.js and DataLabels Plugin (for Dashboard only, but placed here for simplicity or can be moved to stack) --}}
    @stack('chart-libs')

    <style>
        /* Your original CSS styles go here */
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: #2D3748;
        }

        h1, h2, h3, h4 {
            font-family: 'Poppins', sans-serif;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f0fdf4;
        }

        ::-webkit-scrollbar-thumb {
            background: #065f46;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #047857;
        }

        /* Animations */
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInDown {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        @keyframes slideInLeft {
            0% { opacity: 0; transform: translateX(-50px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease forwards; }
        .animate-fade-in-down { animation: fadeInDown 0.6s ease forwards; }
        .animate-slide-in-left { animation: slideInLeft 0.7s ease-out forwards; }


        /* Sidebar specific styles */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            max-width: 256px;
            height: 100vh;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            z-index: 50;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
        }

        #sidebar.open {
            transform: translateX(0);
        }

        /* Desktop view: sidebar is sticky and visible */
        @media (min-width: 768px) {
            #sidebar {
                position: sticky;
                transform: translateX(0);
                flex-shrink: 0;
                width: 256px;
                height: 100vh;
                z-index: 30;
            }
        }

        /* Sidebar overlay for mobile */
        #sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            display: none;
        }
    </style>
</head>

<body class="bg-green-50 min-h-screen flex flex-col">

    {{-- Main wrapper for sidebar and content --}}
    <div class="flex flex-1 flex-col md:flex-row">

        {{-- Sidebar --}}
        <aside id="sidebar" class="bg-gradient-to-b from-green-900 via-green-800 to-green-700 text-white">
            <div class="p-5 border-b border-green-700 text-center select-none bg-green-950">
                <h2 class="text-xl font-extrabold tracking-wide font-['Poppins']">Admin Panel</h2>
            </div>
            <nav class="px-4 py-6 flex flex-col space-y-3 flex-1">
                {{-- Navigation Links --}}
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group
                    {{ Request::routeIs('admin.dashboard') ? 'bg-white bg-opacity-20 shadow-md font-extrabold' : '' }}">
                    <iconify-icon icon="mdi:view-dashboard" class="w-5 h-5 text-green-300"></iconify-icon>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.kuisioner') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group
                    {{ Request::routeIs('admin.kuisioner') ? 'bg-white bg-opacity-20 shadow-md font-extrabold' : '' }}">
                    <iconify-icon icon="mdi:clipboard-text-outline" class="w-5 h-5 text-yellow-300"></iconify-icon>
                    <span>Manajemen Kuesioner</span>
                </a>

                {{-- Manajemen Testimoni (Dynamic Sub-Menu) --}}
                @php
                    $isTestimoniActive = Request::routeIs('admin.testimonials.*');
                @endphp
                <div class="space-y-1">
                    <a href="javascript:void(0)" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group {{ $isTestimoniActive ? 'bg-white/10' : '' }}">
                        <iconify-icon icon="mdi:message-badge-outline" class="w-5 h-5 text-red-300"></iconify-icon>
                        <span>Manajemen Testimoni</span>
                    </a>
                    <div class="pl-6 space-y-1 border-l ml-3 {{ $isTestimoniActive ? 'border-red-500' : 'border-red-800/50' }}">
                        {{-- Link 1: Review --}}
                        <a href="{{ route('admin.testimonials.review') }}"
                            class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-normal text-xs hover:bg-white/10
                            {{ Request::routeIs('admin.testimonials.review') ? 'bg-white bg-opacity-20 shadow-md font-semibold' : '' }}">
                            <i data-lucide="bell" class="w-4 h-4 text-red-400"></i>
                            <span>Menunggu Review</span>
                        </a>
                        {{-- Link 2: Disetujui --}}
                        <a href="{{ route('admin.testimonials.approved') }}"
                            class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-normal text-xs hover:bg-white/10
                            {{ Request::routeIs('admin.testimonials.approved') ? 'bg-white bg-opacity-20 shadow-md font-semibold' : '' }}">
                            <i data-lucide="check-circle" class="w-4 h-4 text-green-300"></i>
                            <span>Testimoni Disetujui</span>
                        </a>
                        {{-- Link 3: Ditolak --}}
                        <a href="{{ route('admin.testimonials.rejected') }}"
                            class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-normal text-xs hover:bg-white/10
                            {{ Request::routeIs('admin.testimonials.rejected') ? 'bg-white bg-opacity-20 shadow-md font-semibold' : '' }}">
                            <i data-lucide="x-circle" class="w-4 h-4 text-yellow-300"></i>
                            <span>Testimoni Ditolak</span>
                        </a>
                    </div>
                </div>

                <a href="{{ route('admin.alumni') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group
                    {{ Request::routeIs('admin.alumni') ? 'bg-white bg-opacity-20 shadow-md font-extrabold' : '' }}">
                    <iconify-icon icon="mdi:account-multiple-outline" class="w-5 h-5 text-blue-300"></iconify-icon>
                    <span>Manajemen Alumni</span>
                </a>
                <a href="{{ route('admin.gallery') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group
                    {{ Request::routeIs('admin.gallery') ? 'bg-white bg-opacity-20 shadow-md font-extrabold' : '' }}">
                    <iconify-icon icon="mdi:image-multiple-outline" class="w-5 h-5 text-purple-300"></iconify-icon>
                    <span>Manajemen Gallery</span>
                </a>

                <a href="{{ route('admin.kaprodi') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group
                    {{ Request::routeIs('admin.kaprodi') ? 'bg-white bg-opacity-20 shadow-md font-extrabold' : '' }}">
                    <iconify-icon icon="mdi:account-tie" class="w-5 h-5 text-pink-300"></iconify-icon>
                    <span>Manajemen Kaprodi</span>
                </a>

                {{-- Logout Button --}}
                <form action="{{ route('logout') }}" method="POST" class="mt-auto pt-6">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 w-full px-4 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold text-sm shadow-md transition duration-300 ease-in-out group">
                        <iconify-icon icon="mdi:logout" class="w-5 h-5"></iconify-icon>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        {{-- Sidebar Overlay for Mobile --}}
        <div id="sidebar-overlay" class="md:hidden"></div>

        {{-- Main Content Wrapper --}}
        <main class="flex-1 p-6 lg:p-8 flex flex-col">

            {{-- Top Bar for Mobile/Tablet --}}
            <div class="flex justify-between items-center mb-6 md:hidden w-full">
                <button id="sidebarToggle"
                    class="text-white bg-green-700 p-2.5 rounded-md shadow-md hover:bg-green-800 transition-colors focus:outline-none focus:ring-2 focus:ring-green-600">
                    <iconify-icon icon="mdi:menu" class="w-5 h-5"></iconify-icon>
                </button>
                <div class="flex items-center gap-3">
                    <span class="text-base font-semibold text-green-900">Halo, Admin!</span>
                    {{-- Ganti dengan avatar asli jika ada, ini placeholder --}}
                    <img src="https://via.placeholder.com/36/065f46/ffffff?text=AD" alt="Admin Avatar" class="w-9 h-9 rounded-full border-2 border-green-700 shadow-md">
                </div>
            </div>

            {{-- Main Content Yield --}}
            @yield('content')



        </main>
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
                            <i data-lucide="info" class="w-4 h-4"></i> Beranda (User)
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

    {{-- Scroll to Top Button --}}
    <button id="scrollTop" aria-label="Scroll to top"
        class="fixed bottom-6 right-6 z-50 hidden bg-green-700 hover:bg-green-800 text-white p-3 rounded-full shadow-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-500">
        <iconify-icon icon="mdi:arrow-up-bold" class="w-6 h-6"></iconify-icon>
    </button>

    {{-- Universal Scripts (Sidebar Toggle, Lucide Init, Scroll Top) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Date & Time Update ---
            const currentDateTimeSpan = document.getElementById('currentDateTime');

            function updateDateTime() {
                const now = new Date();
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                };
                if (currentDateTimeSpan) {
                    currentDateTimeSpan.textContent = now.toLocaleDateString('id-ID', options);
                }
            }

            updateDateTime();
            setInterval(updateDateTime, 1000); // Update every second


            // --- Sidebar Toggle for Mobile ---
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            if (sidebarToggle && sidebar && sidebarOverlay) {
                const toggleSidebar = () => {
                    const isOpen = sidebar.classList.toggle('open');
                    sidebarOverlay.style.display = isOpen ? 'block' : 'none';
                    document.body.style.overflow = isOpen ? 'hidden' : '';
                };

                sidebarToggle.addEventListener('click', toggleSidebar);
                sidebarOverlay.addEventListener('click', toggleSidebar);

                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 768) {
                        sidebar.classList.remove('open');
                        sidebarOverlay.style.display = 'none';
                        document.body.style.overflow = '';
                    }
                });
            }

            // --- Scroll to Top Button Logic ---
            const scrollTopBtn = document.getElementById('scrollTop');
            if (scrollTopBtn) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 250) {
                        scrollTopBtn.classList.remove('hidden');
                    } else {
                        scrollTopBtn.classList.add('hidden');
                    }
                });
                scrollTopBtn.addEventListener('click', () => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }

            // --- Initialize Lucide icons ---
            lucide.createIcons();
        });
    </script>

    {{-- Stack for page-specific scripts like Chart.js initialization --}}
    @stack('scripts')
</body>

</html>
