<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Dashboard Kaprodi') - UIN Raden Mas Said</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('img/uin.png') }}" />

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    {{-- Libraries --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --primary-green: #065f46;
            --secondary-green: #047857;
            --accent-green: #10b981;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1a202c;
            background-color: #f8fafc;
        }

        h1, h2, h3, h4 { font-family: 'Poppins', sans-serif; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: var(--primary-green); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--secondary-green); }

        /* Sidebar Styling */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            transform: translateX(-100%);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 50;
            background: linear-gradient(180deg, #064e3b 0%, #065f46 100%);
        }

        #sidebar.open { transform: translateX(0); }

        /* Collapsed sidebar for desktop */
        #sidebar.collapsed { width: 88px; }
        #sidebar.collapsed .px-4 span { display: none; }
        #sidebar.collapsed .px-4 { padding-left: 0.9rem; padding-right: 0.9rem; justify-content: center; }
        #sidebar.collapsed .w-16 { width: 40px; height: 40px; }
        #sidebar.collapsed .mt-auto { padding-left: 0; padding-right: 0; }

        @media (min-width: 768px) {
            #sidebar {
                position: sticky;
                transform: translateX(0);
                flex-shrink: 0;
            }
        }

        /* Sidebar Link Hover Effect */
        .sidebar-link {
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-left-color: var(--accent-green);
            padding-left: 1.5rem;
        }

        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.15);
            border-left-color: var(--accent-green);
            box-shadow: inset 0 0 10px rgba(0,0,0,0.1);
        }

        /* Content Area Glassmorphism */
        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }

        #sidebar-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 40;
            display: none;
        }

        .animate-fade-in { animation: fadeIn 0.6s ease-out forwards; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @yield('head_extras')
</head>

<body class="min-h-screen flex flex-col">

    <div class="flex flex-1 flex-col md:flex-row relative">

        {{-- Sidebar Kaprodi --}}
        <aside id="sidebar" class="text-white shadow-2xl flex flex-col">
            <div class="p-8 flex flex-col items-center border-b border-white/10 bg-black/10">
                <img src="{{ asset('img/uin.png') }}" class="w-16 h-16 mb-4 drop-shadow-lg" alt="Logo UIN">
                <h2 class="text-lg font-bold tracking-wider font-['Poppins']">Kaprodi Panel</h2>
                <p class="text-[10px] uppercase tracking-[0.2em] text-green-300 font-semibold">Tracer Study System</p>
            </div>

            <nav class="px-4 py-8 flex flex-col space-y-2 flex-1 overflow-y-auto custom-scrollbar">
                <p class="text-[10px] font-bold text-green-400/60 uppercase tracking-widest px-4 mb-2">Main Menu</p>

                <a href="{{ route('kaprodi.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-white font-medium text-sm {{ request()->routeIs('kaprodi.dashboard') ? 'active' : '' }}">
                    <iconify-icon icon="heroicons:squares-2x2-20-solid" class="text-xl"></iconify-icon>
                    <span>Dashboard Overview</span>
                </a>

                <a href="{{ route('kaprodi.kuisioner.report') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-white font-medium text-sm {{ request()->routeIs('kaprodi.kuisioner.report') ? 'active' : '' }}">
                    <iconify-icon icon="heroicons:chart-pie-20-solid" class="text-xl text-yellow-400"></iconify-icon>
                    <span>Laporan Kuesioner</span>
                </a>

                <a href="{{ route('kaprodi.alumni') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-white font-medium text-sm {{ request()->routeIs('kaprodi.alumni') ? 'active' : '' }}">
                    <iconify-icon icon="heroicons:user-group-20-solid" class="text-xl text-blue-400"></iconify-icon>
                    <span>Database Alumni</span>
                </a>

                <div class="pt-6">
                    <p class="text-[10px] font-bold text-green-400/60 uppercase tracking-widest px-4 mb-2">Support</p>
                    <a href="{{ route('kaprodi.help') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-white font-medium text-sm {{ request()->routeIs('kaprodi.help') ? 'active' : '' }}">
                        <iconify-icon icon="heroicons:information-circle-20-solid" class="text-xl text-slate-300"></iconify-icon>
                        <span>Pusat Bantuan</span>
                    </a>
                </div>

                <div class="mt-auto pt-10">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="group flex items-center gap-3 w-full px-4 py-3 rounded-xl bg-red-500/10 hover:bg-red-600 text-red-400 hover:text-white font-bold text-sm transition-all shadow-lg border border-red-500/20">
                            <iconify-icon icon="heroicons:arrow-left-on-rectangle-20-solid" class="text-xl"></iconify-icon>
                            <span>Keluar Sistem</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        {{-- Sidebar Overlay (Mobile) --}}
        <div id="sidebar-overlay"></div>

        {{-- Content Area --}}
        <main class="flex-1 flex flex-col min-w-0">

            {{-- Top Header (Glassmorphism) --}}
            <header class="glass-header sticky top-0 z-30 px-6 py-4">
                <div class="flex justify-between items-center max-w-full">
                    {{-- Toggle & Breadcrumb --}}
                    <div class="flex items-center gap-4">
                        <button id="sidebarToggle" class="md:hidden text-white bg-green-700 p-2.5 rounded-xl shadow-lg hover:bg-green-800 active:scale-95 transition-all">
                            <iconify-icon icon="heroicons:bars-3-bottom-left-20-solid" class="text-2xl"></iconify-icon>
                        </button>

                        <!-- Desktop collapse toggle -->
                        <button id="sidebarCollapse" title="Sembunyikan Sidebar" class="hidden md:inline-flex text-gray-700 bg-white/90 p-2 rounded-lg shadow-sm hover:bg-white active:scale-95 transition-all">
                            <iconify-icon icon="heroicons:chevron-double-left-20-solid" class="text-xl"></iconify-icon>
                        </button>
                        <div class="hidden sm:block">
                            <h2 class="text-sm font-bold text-gray-800">Selamat Datang, Kaprodi</h2>
                            <p class="text-[10px] text-gray-500 font-medium tracking-wide uppercase">Monitoring Lulusan & Alumni</p>
                        </div>
                    </div>

                    {{-- Right Controls --}}
                    <div class="flex items-center gap-4">
                        <div class="hidden lg:flex flex-col items-end border-r pr-4 border-slate-200">
                            <span id="currentDate" class="text-[11px] font-bold text-gray-700"></span>
                            <span id="currentTime" class="text-[10px] font-medium text-green-600"></span>
                        </div>
                        <div class="flex items-center gap-3 bg-slate-100 p-1.5 rounded-2xl border border-slate-200 shadow-inner">
                            <img src="https://ui-avatars.com/api/?name=Kaprodi&background=065f46&color=fff" class="w-8 h-8 rounded-xl border border-white shadow-sm" alt="Avatar">
                            <span class="text-xs font-bold text-slate-700 pr-2 hidden sm:inline">KAPRODI PANEL</span>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Main Content Injection --}}
            <div class="p-4 sm:p-6 lg:p-10 animate-fade-in">
                @yield('content')
            </div>

        </main>
    </div>

    {{-- Footer --}}
    <footer class="bg-white border-t border-slate-200 py-8">
        <div class="max-w-7xl mx-auto px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/uin.png') }}" class="w-8 h-8 grayscale opacity-50" alt="">
                <div>
                    <p class="text-xs text-slate-500 font-medium">&copy; {{ date('Y') }} <span class="text-slate-800 font-bold">UIN Raden Mas Said Surakarta</span></p>
                    <p class="text-[10px] text-slate-400 italic">Laboratorium Terintegrasi Tracer Study System</p>
                </div>
            </div>
            <div class="flex gap-6">
                <a href="#" class="text-[11px] font-bold text-slate-400 hover:text-green-600 tracking-widest uppercase transition-colors">Documentation</a>
                <a href="#" class="text-[11px] font-bold text-slate-400 hover:text-green-600 tracking-widest uppercase transition-colors">Support</a>
                <a href="#" class="text-[11px] font-bold text-slate-400 hover:text-green-600 tracking-widest uppercase transition-colors">Privacy Policy</a>
            </div>
        </div>
    </footer>

    {{-- Scroll to Top --}}
    <button id="scrollTop" class="fixed bottom-8 right-8 z-50 hidden bg-green-700 hover:bg-green-800 text-white p-4 rounded-2xl shadow-2xl transition-all hover:-translate-y-2 active:scale-90">
        <iconify-icon icon="heroicons:chevron-up-20-solid" class="text-2xl"></iconify-icon>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update Jam & Tanggal (Realtime)
            function updateClock() {
                const now = new Date();
                const dOpt = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

                document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', dOpt).toUpperCase();
                document.getElementById('currentTime').textContent = timeStr + ' WIB';
            }
            setInterval(updateClock, 1000);
            updateClock();

            // Inisialisasi Lucide
            lucide.createIcons();

            // Sidebar Logic
            const toggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const collapseBtn = document.getElementById('sidebarCollapse');

            // Apply persisted collapsed state
            if (sidebar && localStorage.getItem('sidebar-collapsed') === '1') {
                sidebar.classList.add('collapsed');
                if (collapseBtn) collapseBtn.setAttribute('title', 'Tampilkan Sidebar');
            }

            function toggleMenu() {
                sidebar.classList.toggle('open');
                if (sidebar.classList.contains('open')) {
                    overlay.style.display = 'block';
                    document.body.style.overflow = 'hidden';
                } else {
                    overlay.style.display = 'none';
                    document.body.style.overflow = '';
                }
            }

            // Desktop collapse/expand
            function toggleCollapse() {
                sidebar.classList.toggle('collapsed');
                const collapsed = sidebar.classList.contains('collapsed');
                try { localStorage.setItem('sidebar-collapsed', collapsed ? '1' : '0'); } catch(e) {}
                if (collapseBtn) collapseBtn.setAttribute('title', collapsed ? 'Tampilkan Sidebar' : 'Sembunyikan Sidebar');
            }

            if (collapseBtn) collapseBtn.addEventListener('click', toggleCollapse);

            if(toggle) toggle.addEventListener('click', toggleMenu);
            if(overlay) overlay.addEventListener('click', toggleMenu);

            // Scroll to Top logic
            const stp = document.getElementById('scrollTop');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 400) stp.classList.remove('hidden');
                else stp.classList.add('hidden');
            });
            stp.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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

        @if(session('success'))
            Swal.fire({icon:'success', title:'Berhasil', text: @json(session('success'))});
        @endif
        @if(session('error'))
            Swal.fire({icon:'error', title:'Gagal', text: @json(session('error'))});
        @endif
    </script>
    @yield('scripts')
</body>

</html>
