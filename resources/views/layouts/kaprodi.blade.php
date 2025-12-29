<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Dashboard Kaprodi') - UIN Raden Mas Said</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    {{-- Libraries --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; color: #2D3748; overflow-x: hidden; }
        h1, h2, h3, h4 { font-family: 'Poppins', sans-serif; }

        /* Scrollbar Warna Asli */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f0fdf4; }
        ::-webkit-scrollbar-thumb { background: #065f46; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #047857; }

        /* Sidebar Responsive Logic */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 256px;
            height: 100vh;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            z-index: 50;
        }

        #sidebar.open { transform: translateX(0); }

        @media (min-width: 768px) {
            #sidebar {
                position: sticky;
                transform: translateX(0);
                flex-shrink: 0;
                width: 256px;
            }
        }

        #sidebar-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            display: none;
        }

        .animate-fade-in { animation: fadeIn 0.5s ease-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @yield('head_extras')
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

    <div class="flex flex-1 flex-col md:flex-row relative">

        {{-- Sidebar Kaprodi (Warna Gradasi Asli) --}}
        <aside id="sidebar" class="bg-gradient-to-b from-green-900 via-green-800 to-green-700 text-white shadow-xl">
            <div class="p-5 border-b border-green-700 text-center select-none bg-green-950">
                <h2 class="text-xl font-extrabold tracking-wide font-['Poppins']">Kaprodi Panel</h2>
            </div>

            <nav class="px-4 py-6 flex flex-col space-y-3 flex-1 overflow-y-auto">
                <a href="{{ route('kaprodi.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group {{ request()->routeIs('kaprodi.dashboard') ? 'bg-white/20 shadow-md' : '' }}">
                    <iconify-icon icon="mdi:view-dashboard" class="w-5 h-5 text-green-300"></iconify-icon>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('kaprodi.kuisioner.report') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group {{ request()->routeIs('kaprodi.kuisioner.report') ? 'bg-white/20 shadow-md' : '' }}">
                    <iconify-icon icon="mdi:chart-bar" class="w-5 h-5 text-yellow-300"></iconify-icon>
                    <span>Laporan Kuesioner</span>
                </a>

                <a href="{{ route('kaprodi.alumni') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group {{ request()->routeIs('kaprodi.alumni') ? 'bg-white/20 shadow-md' : '' }}">
                    <iconify-icon icon="mdi:account-multiple-outline" class="w-5 h-5 text-blue-300"></iconify-icon>
                    <span>Data Alumni</span>
                </a>

                <a href="{{ route('kaprodi.help') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group {{ request()->routeIs('kaprodi.help') ? 'bg-white/20 shadow-md' : '' }}">
                    <i data-lucide="help-circle" class="w-5 h-5 text-gray-300 group-hover:text-white"></i>
                    <span>Panduan & Bantuan</span>
                </a>

                <form action="{{ route('logout') }}" method="POST" class="mt-auto pt-6">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold text-sm shadow-md transition duration-300 ease-in-out">
                        <iconify-icon icon="mdi:logout" class="w-5 h-5"></iconify-icon>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        {{-- Sidebar Overlay (Mobile) --}}
        <div id="sidebar-overlay"></div>

        {{-- Content Area --}}
        <main class="flex-1 flex flex-col min-w-0 p-4 sm:p-6 lg:p-8">

            {{-- Top Bar Mobile/Tablet --}}
            <div class="flex justify-between items-center mb-6 md:hidden w-full bg-white p-3 rounded-xl shadow-sm border border-gray-100">
                <button id="sidebarToggle" class="text-white bg-green-700 p-2 rounded-lg shadow hover:bg-green-800 transition-colors">
                    <iconify-icon icon="mdi:menu" class="w-6 h-6"></iconify-icon>
                </button>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-green-900 uppercase">Kaprodi Menu</span>
                    <img src="https://ui-avatars.com/api/?name=Kaprodi&background=065f46&color=fff" class="w-8 h-8 rounded-full border border-green-700">
                </div>
            </div>

            {{-- Header Info (Waktu & Tanggal) --}}
            <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-2 animate-fade-in">
                <div class="text-xs md:text-sm font-medium text-gray-500">
                    Sistem Tracer Study &bull; <span class="font-bold text-green-700">UIN Raden Mas Said</span>
                </div>
                <div class="flex items-center gap-2 text-[10px] md:text-xs bg-white px-3 py-1.5 rounded-full shadow-sm border border-gray-100 w-fit">
                    <i data-lucide="clock" class="w-3 h-3 text-green-600"></i>
                    <span id="currentDate" class="font-semibold text-gray-700"></span>
                    <span class="text-gray-300">|</span>
                    <span id="currentTime" class="font-bold text-green-700"></span>
                </div>
            </div>

            {{-- Content Injection --}}
            <div class="flex-1">
                @yield('content')
            </div>

        </main>
    </div>

    {{-- Footer (Warna Gradasi Asli) --}}
    <footer class="bg-gradient-to-r from-green-900 to-emerald-800 text-white py-6 shadow-inner">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4 text-[10px] md:text-xs">
            <p>&copy; 2025 <span class="font-bold">UIN Raden Mas Said Surakarta</span>. Tracer Study System.</p>
            <div class="flex gap-4 opacity-70">
                <a href="#" class="hover:underline">Panduan</a>
                <a href="#" class="hover:underline">Kontak</a>
                <a href="#" class="hover:underline">Privasi</a>
            </div>
        </div>
    </footer>

    {{-- Scroll to Top --}}
    <button id="scrollTop" class="fixed bottom-6 right-6 z-50 hidden bg-green-700 hover:bg-green-800 text-white p-3 rounded-full shadow-2xl transition hover:scale-110">
        <iconify-icon icon="mdi:arrow-up-bold" class="w-6 h-6"></iconify-icon>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update Jam & Tanggal
            function updateClock() {
                const now = new Date();
                const dOpt = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', dOpt);
                document.getElementById('currentTime').textContent = now.toLocaleTimeString('id-ID') + ' WIB';
            }
            setInterval(updateClock, 1000); updateClock();

            // Inisialisasi Lucide
            lucide.createIcons();

            // Toggle Sidebar
            const toggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            function toggleMenu() {
                sidebar.classList.toggle('open');
                overlay.style.display = sidebar.classList.contains('open') ? 'block' : 'none';
                document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
            }

            if(toggle) toggle.addEventListener('click', toggleMenu);
            if(overlay) overlay.addEventListener('click', toggleMenu);

            // Scroll to Top
            const stp = document.getElementById('scrollTop');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) stp.classList.remove('hidden');
                else stp.classList.add('hidden');
            });
            stp.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
        });
    </script>
    @yield('scripts')
</body>
</html>
