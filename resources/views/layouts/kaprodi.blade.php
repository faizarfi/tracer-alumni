<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Dashboard Kaprodi') - UIN Raden Mas Said</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <style>
        /* Gaya dasar dan scrollbar */
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

        /* Sidebar specific styles */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            max-width: 220px;
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

        @media (min-width: 768px) {
            #sidebar {
                position: sticky;
                transform: translateX(0);
                flex-shrink: 0;
                width: 220px;
                height: 100vh;
                z-index: 30;
            }
        }

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

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    @yield('head_extras')
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

    {{-- Main wrapper for sidebar and content --}}
    <div class="flex flex-1 flex-col md:flex-row">

        {{-- Sidebar Kaprodi --}}
        <aside id="sidebar" class="bg-gradient-to-b from-green-900 via-green-800 to-green-700 text-white">
            <div class="p-5 border-b border-green-700 text-center select-none bg-green-950">
                <h2 class="text-xl font-extrabold tracking-wide font-['Poppins']">Kaprodi Panel</h2>
            </div>
            <nav class="px-4 py-6 flex flex-col space-y-3 flex-1">
                {{-- LINK DASHBOARD (Tambahkan logika active class jika diperlukan) --}}
                <a href="{{ route('kaprodi.dashboard') ?? '#' }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group @if(request()->routeIs('kaprodi.dashboard')) bg-white/20 shadow-md @endif">
                    <iconify-icon icon="mdi:view-dashboard" class="w-5 h-5 text-green-300"></iconify-icon>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('kaprodi.kuisioner.report') ?? '#' }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group @if(request()->routeIs('kaprodi.kuisioner.report')) bg-white/20 shadow-md @endif">
                    <iconify-icon icon="mdi:chart-bar" class="w-5 h-5 text-yellow-300"></iconify-icon>
                    <span>Laporan Kuesioner</span>
                </a>
                <a href="{{ route('kaprodi.alumni') ?? '#' }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group @if(request()->routeIs('kaprodi.alumni')) bg-white/20 shadow-md @endif">
                    <iconify-icon icon="mdi:account-multiple-outline" class="w-5 h-5 text-blue-300"></iconify-icon>
                    <span>Data Alumni</span>
                </a>
                {{-- LINK BANTUAN (Active class) --}}
                <a href="{{ route('kaprodi.help') ?? '#' }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group @if(request()->routeIs('kaprodi.help')) bg-white/20 shadow-md @endif">
                    <i data-lucide="help-circle" class="w-5 h-5 text-gray-300 group-hover:text-white"></i>
                    <span>Panduan & Bantuan</span>
                </a>
                <form action="{{ route('logout') ?? '#' }}" method="POST" class="mt-auto pt-6">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold text-sm shadow-md transition duration-300 ease-in-out group">
                        <iconify-icon icon="mdi:logout" class="w-5 h-5"></iconify-icon>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        {{-- Sidebar Overlay for Mobile --}}
        <div id="sidebar-overlay" class="md:hidden"></div>

        {{-- Main Content will be injected here --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8 flex flex-col">
            @yield('content')
        </main>
    </div>

    {{-- Footer --}}
    <footer class="bg-gradient-to-r from-green-900 to-emerald-800 text-white py-4 shadow-inner">
        <div class="max-w-7xl mx-auto px-4 text-center text-xs">
            &copy; 2025 UIN Raden Mas Said Surakarta. Tracer Study System.
        </div>
    </footer>

    {{-- Scroll to Top Button --}}
    <button id="scrollTop" aria-label="Scroll to top" class="fixed bottom-6 right-6 z-50 hidden bg-green-700 hover:bg-green-800 text-white p-3 rounded-full shadow-xl transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-green-400">
        <iconify-icon icon="mdi:arrow-up-bold" class="w-6 h-6"></iconify-icon>
    </button>

    {{-- Scripts dan Inisialisasi --}}
    <script>
        function updateTime() {
            const currentDateElement = document.getElementById('currentDate');
            const currentTimeElement = document.getElementById('currentTime');
            const now = new Date();
            const optionsDate = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const formattedDate = now.toLocaleDateString('id-ID', optionsDate);
            const formattedTime = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });

            if (currentDateElement && currentTimeElement) {
                currentDateElement.textContent = formattedDate;
                currentTimeElement.textContent = formattedTime + ' WIB';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateTime();
            setInterval(updateTime, 1000);

            // Inisialisasi Lucide Icons
            lucide.createIcons();

            // Logika Sidebar Toggle untuk mobile
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            if (sidebarToggle && sidebar && sidebarOverlay) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('open');
                    sidebarOverlay.style.display = sidebar.classList.contains('open') ? 'block' : 'none';
                    document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
                });
                sidebarOverlay.addEventListener('click', () => {
                    sidebar.classList.remove('open');
                    sidebarOverlay.style.display = 'none';
                    document.body.style.overflow = '';
                });
                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 768) {
                        sidebar.classList.remove('open');
                        sidebarOverlay.style.display = 'none';
                        document.body.style.overflow = '';
                    }
                });
            }

            // Scroll to top button logic
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
        });
    </script>
    @yield('scripts')
</body>

</html>
