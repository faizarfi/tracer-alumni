<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Dashboard Admin') - UIN Raden Mas Said</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" type="image/png" href="{{ asset('img/uin.png') }}" />

    {{-- Fonts: Plus Jakarta Sans & Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Icons --}}
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    @stack('chart-libs')

    <style>
        :root {
            --primary-green: #064e3b;
            --secondary-green: #065f46;
            --accent-green: #10b981;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            background-color: #f8fafc;
        }

        h1, h2, h3, h4 { font-family: 'Poppins', sans-serif; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: var(--primary-green); border-radius: 10px; }

        /* Sidebar Glassmorphism */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            transform: translateX(-100%);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 50;
            background: linear-gradient(180deg, #052e16 0%, #064e3b 100%);
            box-shadow: 10px 0 30px rgba(0, 0, 0, 0.1);
        }

        #sidebar.open { transform: translateX(0); }

        @media (min-width: 768px) {
            #sidebar {
                position: sticky;
                transform: translateX(0);
                flex-shrink: 0;
            }
        }

        /* Desktop collapsed state (icon-only) */
        #sidebar.collapsed {
            width: 72px;
        }
        #sidebar.collapsed .p-8 {
            padding-left: 12px;
            padding-right: 12px;
        }
        #sidebar.collapsed img { width: 40px; height: 40px; }
        #sidebar.collapsed nav { align-items: center; }
        #sidebar.collapsed .sidebar-link { justify-content: center; padding-left: 0.75rem; }
        #sidebar.collapsed .sidebar-link span { display: none; }
        #sidebar.collapsed .sidebar-link .w-5 { margin-right: 0; }
        #sidebar.collapsed .mt-auto { padding-bottom: 1rem; }
        #sidebar.collapsed h2, #sidebar.collapsed p { display: none; }

        /* Sidebar Nav Styling */
        .sidebar-link {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.08);
            border-left-color: var(--accent-green);
            padding-left: 1.5rem;
        }

        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.12);
            border-left-color: var(--accent-green);
            box-shadow: inset 0 0 15px rgba(0,0,0,0.2);
            font-weight: 700;
        }

        /* Glass Header */
        .glass-header {
            background: rgba(255, 255, 255, 0.85);
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
    </style>
</head>

<body class="min-h-screen flex flex-col">

    <div class="flex flex-1 flex-col md:flex-row">

        {{-- Sidebar --}}
        <aside id="sidebar" class="text-white flex flex-col">
            <div class="p-8 border-b border-white/5 bg-black/10 text-center relative">
                <button id="sidebarClose" class="md:hidden absolute top-4 right-4 p-2.5 rounded-lg bg-white/5 text-white hover:bg-white/10">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
                <img src="{{ asset('img/uin.png') }}" class="w-16 h-16 mx-auto mb-4 drop-shadow-xl brightness-0 invert" alt="Logo UIN">
                <h2 class="text-lg font-black tracking-widest font-['Poppins'] uppercase">Admin Panel</h2>
                <p class="text-[10px] text-emerald-400 font-bold tracking-[0.2em] uppercase">Super Control Center</p>
            </div>

            <nav class="px-4 py-8 flex flex-col space-y-2 flex-1 overflow-y-auto">
                <p class="text-[10px] font-black text-white/30 uppercase tracking-[0.3em] px-4 mb-2">Main Controls</p>

                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 font-medium text-sm {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 text-emerald-400"></i>
                    <span>Dashboard Stats</span>
                </a>

                <a href="{{ route('admin.kuisioner') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 font-medium text-sm {{ Request::routeIs('admin.kuisioner') ? 'active' : '' }}">
                    <i data-lucide="file-text" class="w-5 h-5 text-yellow-400"></i>
                    <span>Manajemen Kuesioner</span>
                </a>

                {{-- Manajemen Testimoni Dropdown Simulation --}}
                <div class="pt-4 pb-2">
                    <p class="text-[10px] font-black text-white/30 uppercase tracking-[0.3em] px-4 mb-2">Social & Content</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.testimonials.review') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs {{ Request::routeIs('admin.testimonials.review') ? 'active text-white' : 'text-white/60' }}">
                            <i data-lucide="clock" class="w-4 h-4 text-rose-400"></i>
                            <span>Menunggu Review</span>
                        </a>
                        <a href="{{ route('admin.testimonials.approved') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs {{ Request::routeIs('admin.testimonials.approved') ? 'active text-white' : 'text-white/60' }}">
                            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i>
                            <span>Testimoni Disetujui</span>
                        </a>
                        <a href="{{ route('admin.testimonials.rejected') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs {{ Request::routeIs('admin.testimonials.rejected') ? 'active text-white' : 'text-white/60' }}">
                            <i data-lucide="x-circle" class="w-4 h-4 text-amber-400"></i>
                            <span>Testimoni Ditolak</span>
                        </a>
                    </div>
                </div>

                <a href="{{ route('admin.alumni') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 font-medium text-sm {{ Request::routeIs('admin.alumni') ? 'active' : '' }}">
                    <i data-lucide="users" class="w-5 h-5 text-blue-400"></i>
                    <span>Database Alumni</span>
                </a>

                <a href="{{ route('admin.gallery') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 font-medium text-sm {{ Request::routeIs('admin.gallery') ? 'active' : '' }}">
                    <i data-lucide="image" class="w-5 h-5 text-purple-400"></i>
                    <span>Manajemen Gallery</span>
                </a>

                <a href="{{ route('admin.kaprodi') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 font-medium text-sm {{ Request::routeIs('admin.kaprodi') ? 'active' : '' }}">
                    <i data-lucide="user-check" class="w-5 h-5 text-pink-400"></i>
                    <span>Manajemen Kaprodi</span>
                </a>

                <a href="{{ route('admin.faculties.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 font-medium text-sm {{ Request::routeIs('admin.faculties.*') ? 'active' : '' }}">
                    <i data-lucide="building-2" class="w-5 h-5 text-amber-400"></i>
                    <span>Manajemen Fakultas</span>
                </a>

                <a href="{{ route('admin.programs.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 font-medium text-sm {{ Request::routeIs('admin.programs.*') ? 'active' : '' }}">
                    <i data-lucide="book" class="w-5 h-5 text-cyan-400"></i>
                    <span>Manajemen Program Studi</span>
                </a>

                {{-- Logout --}}
                <div class="mt-auto pt-10">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="group flex items-center gap-3 w-full px-5 py-3.5 rounded-2xl bg-rose-600/10 hover:bg-rose-600 text-rose-500 hover:text-white font-black text-xs uppercase tracking-widest transition-all shadow-lg border border-rose-500/20 active:scale-95">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                            <span>Logout System</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        {{-- Overlay for Mobile --}}
        <div id="sidebar-overlay"></div>

        {{-- Main Content Wrapper --}}
        <main class="flex-1 flex flex-col min-w-0">

            {{-- Top Header (Premium Glass) --}}
            <header class="glass-header sticky top-0 z-30 px-6 py-4">
                <div class="flex justify-between items-center max-w-full">
                    <div class="flex items-center gap-6">
                        <button id="sidebarToggle" class="md:hidden text-white bg-emerald-900 p-2.5 rounded-xl shadow-lg hover:bg-emerald-800 transition-all active:scale-95">
                            <i data-lucide="menu" class="w-6 h-6"></i>
                        </button>
                        <!-- Desktop collapse control -->
                        <button id="sidebarCollapse" class="hidden md:inline-flex text-emerald-900 bg-white/5 p-2.5 rounded-xl shadow-sm hover:bg-white/10 transition-all items-center justify-center">
                            <i data-lucide="chevrons-left" class="w-5 h-5"></i>
                        </button>
                        <div class="hidden sm:block">
                            <h2 class="text-sm font-black text-slate-800 uppercase tracking-tight">System Administrator</h2>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <p id="currentDateTime" class="text-[10px] text-slate-500 font-bold uppercase tracking-widest"></p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-3 bg-slate-100 p-1.5 rounded-2xl border border-slate-200 shadow-inner">
                            <img src="https://ui-avatars.com/api/?name=Admin&background=064e3b&color=fff" class="w-8 h-8 rounded-xl border border-white shadow-sm" alt="Avatar">
                            <span class="text-[11px] font-black text-slate-700 pr-3 uppercase tracking-wider hidden sm:inline">Admin Mode</span>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Content Yield --}}
            <div class="p-6 lg:p-10 animate-fade-in-up">
                @yield('content')
            </div>

        </main>
    </div>

    {{-- Footer Section --}}
    <footer class="relative bg-[#044e3a] text-white mt-auto overflow-hidden">
        {{-- Soft Glow Decoration --}}
        <div class="absolute top-0 right-0 -translate-y-12 translate-x-12 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 translate-y-12 -translate-x-12 w-64 h-64 bg-green-500/10 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-8 pt-16 pb-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 text-sm">
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('img/uin.png') }}" alt="Logo UIN" class="w-12 h-12 brightness-0 invert">
                        <div>
                            <h2 class="text-xl font-bold tracking-tight leading-tight">Admin Portal</h2>
                            <p class="text-emerald-400 font-bold text-[10px] uppercase tracking-[0.2em]">Tracer Alumni Center</p>
                        </div>
                    </div>
                    <p class="text-emerald-100/50 leading-relaxed text-xs italic">
                        Manajemen data terpadu untuk membangun masa depan UIN Raden Mas Said Surakarta.
                    </p>
                </div>

                <div>
                    <h3 class="text-xs font-black mb-6 uppercase tracking-[0.3em] text-emerald-400">Quick Links</h3>
                    <ul class="space-y-4 text-emerald-100/80 font-bold text-[11px] uppercase">
                        <li><a href="https://uinsaid.ac.id" target="_blank" class="hover:text-white flex items-center gap-3 transition-all"><i data-lucide="globe" class="w-4 h-4"></i> Website UIN</a></li>
                        <li><a href="https://pmb.uinsaid.ac.id" target="_blank" class="hover:text-white flex items-center gap-3 transition-all"><i data-lucide="external-link" class="w-4 h-4"></i> Portal PMB</a></li>
                    </ul>
                </div>

                <div class="lg:col-span-2">
                    <h3 class="text-xs font-black mb-6 uppercase tracking-[0.3em] text-emerald-400">System Support</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 rounded-2xl bg-white/5 border border-white/10 flex items-center gap-4">
                            <i data-lucide="mail" class="w-5 h-5 text-emerald-400"></i>
                            <span class="text-xs font-bold tracking-tight">it-admin@uinsaid.ac.id</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-white/5 border border-white/10 flex items-center gap-4">
                            <i data-lucide="shield" class="w-5 h-5 text-emerald-400"></i>
                            <span class="text-xs font-bold tracking-tight">V2.8 Production Ready</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-16 pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4 text-[9px] font-black text-emerald-100/30 uppercase tracking-[0.3em]">
                <p>&copy; {{ date('Y') }} UIN RADEN MAS SAID. LABORATORY MANAGEMENT SYSTEM.</p>
                <div class="flex gap-6 italic">
                    <span>Secured Database Control</span>
                </div>
            </div>
        </div>
    </footer>

    {{-- Scroll to Top --}}
    <button id="scrollTop" aria-label="Scroll to top"
        class="fixed bottom-8 right-8 z-50 hidden bg-emerald-600 hover:bg-emerald-500 text-white p-4 rounded-2xl shadow-2xl transition-all duration-300 hover:-translate-y-2 active:scale-90">
        <i data-lucide="chevron-up" class="w-6 h-6"></i>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();

            // Real-time Clock
            function updateClock() {
                const now = new Date();
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
                document.getElementById('currentDateTime').textContent = now.toLocaleDateString('id-ID', options);
            }
            setInterval(updateClock, 1000); updateClock();

            // Sidebar Logic
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const sidebarCollapse = document.getElementById('sidebarCollapse');

            if (sidebarToggle) {
                const toggle = () => {
                    const isOpen = sidebar.classList.toggle('open');
                    sidebarOverlay.style.display = isOpen ? 'block' : 'none';
                    document.body.style.overflow = isOpen ? 'hidden' : '';
                };
                sidebarToggle.addEventListener('click', toggle);
                sidebarOverlay.addEventListener('click', toggle);
                // Close button inside sidebar (mobile) and Escape key handler
                const sidebarClose = document.getElementById('sidebarClose');
                sidebarClose && sidebarClose.addEventListener('click', function(){
                    if(sidebar.classList.contains('open')) toggle();
                });
                document.addEventListener('keydown', function(e){ if(e.key === 'Escape' && sidebar.classList.contains('open')) toggle(); });
            }

            // Desktop collapse toggle: icon-only sidebar
            if(sidebarCollapse){
                // apply persisted state
                const saved = localStorage.getItem('sidebarCollapsed') === 'true';
                if(saved) sidebar.classList.add('collapsed');

                sidebarCollapse.setAttribute('aria-expanded', sidebar.classList.contains('collapsed'));
                sidebarCollapse.addEventListener('click', function(){
                    const now = sidebar.classList.toggle('collapsed');
                    // toggle icon direction (update lucide attribute and refresh icons)
                    const icon = sidebarCollapse.querySelector('i');
                    if(icon) icon.setAttribute('data-lucide', now ? 'chevrons-right' : 'chevrons-left');
                    sidebarCollapse.setAttribute('aria-expanded', String(now));
                    localStorage.setItem('sidebarCollapsed', now);
                    try{ lucide.createIcons(); }catch(e){}
                });
            }

            // Scroll Top
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

    @stack('scripts')
</body>
</html>
