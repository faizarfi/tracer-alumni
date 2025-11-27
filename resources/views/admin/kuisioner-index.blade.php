<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Manajemen Kuesioner - Admin UIN Raden Mas Said</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" type="image/png" href="{{ asset('img/uin.png') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* Global Styles for smooth scroll and font consistency */
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            @apply text-gray-800; /* Apply default text color */
        }

        h1, h2, h3, h4 {
            font-family: 'Poppins', sans-serif;
        }

        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f0fdf4; /* green-50 */
        }

        ::-webkit-scrollbar-thumb {
            background: #065f46; /* green-900 */
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #047857; /* green-700 */
        }

        /* Animations */
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        /* Sidebar specific styles */
        #sidebar {
            /* Default state for mobile: hidden off-screen */
            position: fixed;
            /* Fixed position to overlay content */
            top: 0;
            left: 0;
            width: 100%;
            /* Take full width on small screens initially */
            max-width: 256px;
            /* md:w-64 equivalent */
            height: 100vh;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            z-index: 50;
            /* Ensure it's above other content and overlay */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            /* shadow-lg */
            display: flex;
            /* Ensure flexbox for content inside sidebar */
            flex-direction: column;
            /* Stack items vertically */
        }

        #sidebar.open {
            transform: translateX(0);
            /* When 'open' class is added, slide in */
        }

        /* Desktop view: sidebar is sticky and visible */
        @media (min-width: 768px) {
            /* md breakpoint */
            #sidebar {
                position: sticky;
                /* Back to sticky for normal flow on desktop */
                transform: translateX(0);
                /* Always visible */
                flex-shrink: 0;
                /* Prevent it from shrinking */
                width: 256px;
                /* md:w-64 */
                height: 100vh;
                /* Full viewport height */
                z-index: 30;
                /* Can be lower as it's part of the main flow */
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
            /* Between sidebar and main content */
            display: none;
            /* Hidden by default, controlled by JS */
        }
    </style>
</head>

<body class="bg-green-50 min-h-screen flex flex-col">

    {{-- Sidebar & Main Content Wrapper --}}
    <div class="flex flex-1 flex-col md:flex-row">

        {{-- Sidebar --}}
        {{-- Sidebar --}}
        <aside id="sidebar" class="bg-gradient-to-b from-green-900 via-green-800 to-green-700 text-white">
            <div class="p-5 border-b border-green-700 text-center select-none bg-green-950">
                <h2 class="text-xl font-extrabold tracking-wide font-['Poppins']">Admin Panel</h2>
            </div>
            <nav class="px-4 py-6 flex flex-col space-y-3 flex-1">
                {{-- Navigation Links (Mock Data) --}}
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group">
                    <iconify-icon icon="mdi:view-dashboard" class="w-5 h-5 text-green-300"></iconify-icon>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.kuisioner') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group">
                    <iconify-icon icon="mdi:clipboard-text-outline" class="w-5 h-5 text-yellow-300"></iconify-icon>
                    <span>Manajemen Kuesioner</span>
                </a>

                {{-- **ACTIVE LINK: Manajemen Testimoni (Dynamic Sub-Menu)** --}}
                <div class="space-y-1">
                    <a href="javascript:void(0)" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group active-parent">
                        <iconify-icon icon="mdi:message-badge-outline" class="w-5 h-5 text-red-300"></iconify-icon>
                        <span>Manajemen Testimoni</span>
                    </a>
                    <div class="pl-6 space-y-1 border-l ml-3 border-red-500">
                        {{-- Link 1: Review --}}
                        <a href="{{ route('admin.testimonials.review') }}"
                            class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-normal text-xs hover:bg-white/10
                            {{ Request::routeIs('admin.testimonials.review') ? 'bg-white bg-opacity-20 shadow-md font-semibold' : '' }}">
                            <i data-lucide="bell" class="w-4 h-4 text-red-400"></i>
                            <span>Menunggu Review</span>
                        </a>
                        {{-- Link 2: Disetujui (ACTIVE) --}}
                        <a href="{{ route('admin.testimonials.approved') }}"
                            class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-normal text-xs bg-white bg-opacity-20 shadow-md font-semibold">
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
                {{-- **AKHIR ACTIVE LINK** --}}

                <a href="{{ route('admin.alumni') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group">
                    <iconify-icon icon="mdi:account-multiple-outline" class="w-5 h-5 text-blue-300"></iconify-icon>
                    <span>Manajemen Alumni</span>
                </a>
                <a href="{{ route('admin.gallery') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group">
                    <iconify-icon icon="mdi:image-multiple-outline" class="w-5 h-5 text-purple-300"></iconify-icon>
                    <span>Manajemen Gallery</span>
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

        {{-- Main Content --}}
        <main class="flex-1 p-6 lg:p-8 flex flex-col">
            {{-- Top Bar for Mobile/Tablet --}}
            <div class="flex justify-between items-center mb-6 md:hidden w-full">
                <button id="sidebarToggle"
                    class="text-white bg-green-700 p-2.5 rounded-md shadow-md hover:bg-green-800 transition-colors focus:outline-none focus:ring-2 focus:ring-green-600">
                    <iconify-icon icon="mdi:menu" class="w-5 h-5"></iconify-icon>
                </button>
                <div class="flex items-center gap-3">
                    <span class="text-base font-semibold text-green-900">Halo, Admin!</span>
                    {{-- User Avatar --}}
                    <img src="https://via.placeholder.com/36/065f46/ffffff?text=AD" alt="Admin Avatar" class="w-9 h-9 rounded-full border-2 border-green-700 shadow-md">
                </div>
            </div>

            {{-- Hero Section (New addition/enhancement) --}}
            <div class="bg-gradient-to-r from-emerald-500 to-green-600 text-white p-6 rounded-xl shadow-lg mb-8 flex flex-col md:flex-row items-center justify-between animate-fade-in transform hover:scale-[1.005] transition-transform duration-300">
                <div class="text-center md:text-left mb-4 md:mb-0">
                    <h3 class="text-2xl font-bold font-['Poppins']">Halo, Admin! 👋</h3>
                    <p class="text-green-100 mt-1">Selamat datang di Panel Manajemen Kuesioner Alumni UIN Raden Mas Said.</p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-sm font-semibold" id="currentDate"></p>
                    <p class="text-sm" id="currentTime"></p>
                </div>
            </div>

            <div class="container mx-auto px-0 py-0 max-w-6xl bg-white rounded-2xl shadow-xl border border-gray-200 animate-fade-in">

                <div class="p-8 pb-4 border-b border-gray-200">
                    <h1 class="text-3xl font-extrabold text-green-800 mb-2 font-['Poppins'] flex items-center gap-3">
                        <iconify-icon icon="mdi:clipboard-text-multiple-outline" class="w-8 h-8 text-green-600"></iconify-icon>
                        Manajemen Kuesioner Alumni
                    </h1>
                    <p class="text-gray-600 text-base">Kelola dan lihat detail kuesioner yang telah diisi oleh alumni.</p>
                </div>

                @if(session('success'))
                    <div class="px-8 pt-6">
                        <div class="flex items-center gap-3 bg-green-100 border border-green-300 text-green-800 px-5 py-4 rounded-xl shadow-sm justify-between" role="alert">
                            <p class="font-medium flex items-center gap-2">
                                <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                                {{ session('success') }}
                            </p>
                            <button type="button" class="text-green-700 hover:text-green-900 focus:outline-none" onclick="this.parentElement.style.display='none'">
                                <i data-lucide="x" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="px-8 pt-6">
                        <div class="flex items-center gap-3 bg-red-100 border border-red-300 text-red-800 px-5 py-4 rounded-xl shadow-sm justify-between" role="alert">
                            <p class="font-medium flex items-center gap-2">
                                <i data-lucide="x-circle" class="w-5 h-5 text-red-600"></i>
                                {{ session('error') }}
                            </p>
                            <button type="button" class="text-red-700 hover:text-red-900 focus:outline-none" onclick="this.parentElement.style.display='none'">
                                <i data-lucide="x" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.kuisioner') }}" method="GET"
                      class="p-8 flex flex-col sm:flex-row gap-4 items-center border-b border-gray-200 bg-gray-50 rounded-b-lg sm:rounded-b-none">

                    <div class="relative w-full sm:flex-grow">
                        <input type="text" name="search" placeholder="Cari nama alumni..."
                            value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-900 placeholder-gray-500 transition text-sm shadow-sm" />
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 iconify" data-icon="mdi:magnify"></span>
                    </div>

                    <select name="sort" onchange="this.form.submit()"
                            class="w-full sm:w-auto px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm shadow-sm">
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Nama Z-A</option>
                    </select>

                    <button type="submit"
                            class="flex items-center justify-center gap-2 bg-green-700 hover:bg-green-800 text-white font-semibold py-2.5 px-6 rounded-lg shadow-md transition transform hover:-translate-y-0.5 w-full sm:w-auto">
                        <span class="iconify" data-icon="mdi:filter-variant" style="font-size: 18px;"></span>
                        Terapkan
                    </button>
                </form>

                <div class="overflow-x-auto p-6 pt-0">
                    <table class="min-w-full divide-y divide-gray-200 text-gray-800 text-sm">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider rounded-tl-lg text-green-800 font-bold">User ID</th>
                                <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Nama Alumni</th>
                                <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Tanggal Mengisi</th>
                                <th class="px-5 py-4 text-center whitespace-nowrap text-xs uppercase tracking-wider rounded-tr-lg text-green-800 font-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($kuisioners as $kuisioner)
                                <tr class="odd:bg-white even:bg-green-50 hover:bg-green-100 transition duration-150 ease-in-out">
                                    <td class="px-5 py-3.5 whitespace-nowrap font-medium text-gray-700">{{ $kuisioner->user_id }}</td>
                                    <td class="px-5 py-3.5 whitespace-nowrap font-semibold text-gray-800">{{ $kuisioner->user->name ?? 'Pengguna Tidak Ditemukan' }}</td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-gray-600">{{ $kuisioner->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-center flex justify-center gap-2 items-center">
                                        <a href="{{ route('admin.kuisioner.detail', $kuisioner->id) }}"
                                           class="text-white bg-blue-600 hover:bg-blue-700 p-2 rounded-lg shadow-md transition transform hover:scale-105 flex items-center justify-center gap-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           title="Lihat Detail">
                                            <span class="iconify" data-icon="mdi:eye-outline" style="font-size: 18px;"></span>
                                            <span>Detail</span>
                                        </a>
                                        <form action="{{ route('admin.kuisioner.destroy', $kuisioner->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kuesioner ini? Tindakan ini tidak dapat dibatalkan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-white bg-red-600 hover:bg-red-700 p-2 rounded-lg shadow-md transition transform hover:scale-105 flex items-center justify-center gap-1 focus:outline-none focus:ring-2 focus:ring-red-500"
                                                    title="Hapus Kuesioner">
                                                <span class="iconify" data-icon="mdi:delete" style="font-size: 18px;"></span>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-12 text-gray-500 italic bg-gray-50 rounded-b-lg">
                                        <img src="https://www.svgrepo.com/show/472628/no-data.svg" alt="No Data" class="w-36 h-36 mx-auto mb-5 opacity-60">
                                        <p class="text-lg font-medium">Belum ada data kuesioner yang masuk.</p>
                                        <p class="text-sm mt-1">Sistem akan menampilkan data di sini setelah alumni mengisi kuesioner.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 p-6 flex justify-center border-t border-gray-100">
                    <nav class="bg-white p-4 rounded-lg shadow-lg border border-gray-100">
                        {{ $kuisioners->links('pagination::tailwind') }}
                    </nav>
                </div>

            </div>
        </main>
    </div>

    {{-- Footer (Integrated from Admin Dashboard) --}}
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

    {{-- Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            if (sidebarToggle && sidebar && sidebarOverlay) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('open');
                    if (sidebar.classList.contains('open')) {
                        sidebarOverlay.style.display = 'block'; // Show overlay
                        document.body.style.overflow = 'hidden'; // Prevent body scroll when sidebar is open
                    } else {
                        sidebarOverlay.style.display = 'none'; // Hide overlay
                        document.body.style.overflow = ''; // Restore body scroll
                    }
                });

                sidebarOverlay.addEventListener('click', () => {
                    sidebar.classList.remove('open');
                    sidebarOverlay.style.display = 'none'; // Hide overlay
                    document.body.style.overflow = ''; // Restore body scroll
                });

                // Close sidebar and hide overlay if window is resized to desktop from mobile
                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 768) { // md breakpoint
                        sidebar.classList.remove('open');
                        sidebarOverlay.style.display = 'none';
                        document.body.style.overflow = ''; // Ensure scroll is restored
                    }
                });
            } else {
                console.error("One or more sidebar elements not found!");
            }

            // Scroll to top button show/hide & click
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
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            // Update current time every second
            function updateTime() {
                const now = new Date();
                const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const formattedDate = now.toLocaleDateString('id-ID', optionsDate);
                const formattedTime = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

                const currentDateElement = document.getElementById('currentDate');
                const currentTimeElement = document.getElementById('currentTime');

                if (currentDateElement) currentDateElement.textContent = formattedDate;
                if (currentTimeElement) currentTimeElement.textContent = formattedTime + ' WIB';
            }

            // Initial call to display time immediately
            updateTime();
            // Update time every second
            setInterval(updateTime, 1000);

            // Initialize Lucide icons
            lucide.createIcons();
        });
    </script>
</body>

</html>
