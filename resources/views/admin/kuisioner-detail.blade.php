<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Detail Kuesioner - Admin UIN Raden Mas Said</title>
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
            color: #2D3748;
            /* text-gray-800 */
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: 'Poppins', sans-serif;
        }

        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f0fdf4;
            /* green-50 */
        }

        ::-webkit-scrollbar-thumb {
            background: #065f46;
            /* green-900 */
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #047857;
            /* green-700 */
        }

        /* Animations */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
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

    {{-- Main wrapper for sidebar and content --}}
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

            {{-- Hero Section --}}
            <div class="bg-gradient-to-r from-emerald-500 to-green-600 text-white p-6 rounded-xl shadow-lg mb-8 flex flex-col md:flex-row items-center justify-between animate-fade-in transform hover:scale-[1.005] transition-transform duration-300">
                <div class="text-center md:text-left mb-4 md:mb-0">
                    <h3 class="text-2xl font-bold font-['Poppins']">Halo, Admin! 👋</h3>
                    <p class="text-green-100 mt-1">Anda sedang melihat detail kuesioner alumni.</p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-sm font-semibold" id="currentDate"></p>
                    <p class="text-sm" id="currentTime"></p>
                </div>
            </div>

            <div class="container mx-auto max-w-5xl px-0 py-0 bg-white shadow-xl border border-gray-200 rounded-2xl animate-fade-in">

                <div class="p-8 pb-4 border-b border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between">
                    <h2 class="text-3xl font-extrabold text-green-800 mb-4 sm:mb-0 font-['Poppins'] flex items-center gap-3">
                        <iconify-icon icon="mdi:file-document-outline" class="text-4xl text-green-600"></iconify-icon>
                        Detail Kuesioner
                    </h2>
                    <a href="{{ route('admin.kuisioner') }}"
                       class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg shadow-md transition-all duration-200 transform hover:-translate-y-0.5">
                        <iconify-icon icon="mdi:arrow-left" class="mr-2"></iconify-icon>
                        Kembali ke Daftar Kuesioner
                    </a>
                </div>

                <div class="p-8 pt-6 grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8 border-b border-gray-200">
                    <div>
                        <p class="text-sm font-medium text-green-600">User ID</p>
                        <p class="text-lg font-semibold text-gray-800 mt-1">{{ $kuisioner->user_id }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-green-600">Nama Alumni</p>
                        <p class="text-lg font-semibold text-gray-800 mt-1">{{ $kuisioner->user->name ?? 'Tidak Ditemukan' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-green-600">Tanggal Mengisi</p>
                        <p class="text-lg font-semibold text-gray-800 mt-1">{{ $kuisioner->created_at ? $kuisioner->created_at->isoFormat('D MMMM YYYY, H:mm') . ' WIB' : '-' }}</p>
                    </div>
                </div>

                {{-- Section: Data Pendidikan --}}
                <div class="p-8 border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-green-700 mb-4 font-['Poppins'] flex items-center gap-2">
                        <iconify-icon icon="mdi:school-outline" class="text-2xl"></iconify-icon> Data Pendidikan
                    </h3>
                    @php $pendidikan = $kuisioner->pendidikan; @endphp
                    @if(is_array($pendidikan) && !empty($pendidikan))
                        <div class="bg-green-50 border border-green-200 rounded-lg p-5 space-y-3 text-gray-900 shadow-sm">
                            @foreach($pendidikan as $key => $value)
                                <div class="flex items-start text-base">
                                    <span class="text-green-700 mr-2 flex-shrink-0 mt-1">&bullet;</span>
                                    <div>
                                        <strong class="font-medium text-gray-700 capitalize">{{ str_replace('_', ' ', $key) }}:</strong>
                                        <span class="ml-1">{{ $value ?? '-' }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 border border-gray-200 text-gray-600 p-5 rounded-lg text-center italic shadow-sm">
                            <i data-lucide="info" class="w-5 h-5 inline-block mr-2 text-gray-500"></i> Data pendidikan tidak tersedia atau tidak dalam format yang benar.
                        </div>
                    @endif
                </div>

                {{-- Section: Data Fasilitas --}}
                <div class="p-8 border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-green-700 mb-4 font-['Poppins'] flex items-center gap-2">
                        <iconify-icon icon="mdi:tools" class="text-2xl"></iconify-icon> Data Fasilitas
                    </h3>
                    @php $fasilitas = $kuisioner->fasilitas; @endphp
                    @if(is_array($fasilitas) && !empty($fasilitas))
                        <div class="bg-green-50 border border-green-200 rounded-lg p-5 space-y-3 text-gray-900 shadow-sm">
                            @foreach($fasilitas as $key => $value)
                                <div class="flex items-start text-base">
                                    <span class="text-green-700 mr-2 flex-shrink-0 mt-1">&bullet;</span>
                                    <div>
                                        <strong class="font-medium text-gray-700 capitalize">{{ str_replace('_', ' ', $key) }}:</strong>
                                        <span class="ml-1">{{ $value ?? '-' }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 border border-gray-200 text-gray-600 p-5 rounded-lg text-center italic shadow-sm">
                            <i data-lucide="info" class="w-5 h-5 inline-block mr-2 text-gray-500"></i> Data fasilitas tidak tersedia atau tidak dalam format yang benar.
                        </div>
                    @endif
                </div>

                {{-- Section: Informasi Pekerjaan --}}
                <div class="p-8 border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-green-700 mb-4 font-['Poppins'] flex items-center gap-2">
                        <iconify-icon icon="mdi:briefcase-outline" class="text-2xl"></iconify-icon> Informasi Pekerjaan
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-8 text-gray-800 bg-green-50 border border-green-200 rounded-lg p-5 shadow-sm">
                        @php
                            $jobInfoFields = [
                                'cari_kerja' => 'Kapan Mulai Cari Kerja',
                                'status_pekerjaan' => 'Status Pekerjaan Saat Ini',
                                'waktu_tunggu' => 'Waktu Tunggu (Bulan)',
                                'jumlah_lamaran' => 'Jumlah Lamaran Dikirim',
                                'jumlah_respon' => 'Jumlah Tanggapan Perusahaan',
                                'jumlah_wawancara' => 'Jumlah Wawancara',
                                'jenis_perusahaan' => 'Jenis Tempat Kerja',
                                'nama_perusahaan' => 'Nama Perusahaan',
                                'jenis_pekerjaan' => 'Jenis Pekerjaan',
                                'alamat_perusahaan' => 'Alamat Perusahaan',
                            ];
                        @endphp

                        @foreach($jobInfoFields as $field => $label)
                        <div>
                            <p class="text-sm font-medium text-green-600">{{ $label }}</p>
                            <p class="mt-1 text-base font-semibold">{{ $kuisioner->$field ?? '-' }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Section: Kritik & Saran --}}
                <div class="p-8">
                    <h3 class="text-xl font-semibold text-green-700 mb-4 font-['Poppins'] flex items-center gap-2">
                        <iconify-icon icon="mdi:comment-text-outline" class="text-2xl"></iconify-icon>
                        Kritik & Saran
                    </h3>
                    <div class="bg-green-50 border border-green-200 p-5 rounded-lg text-gray-900 whitespace-pre-line leading-relaxed shadow-sm">
                        {{ $kuisioner->jawaban ?? 'Tidak ada kritik atau saran yang diberikan.' }}
                    </div>
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
        // Sidebar toggle for mobile
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

                // Close sidebar if window is resized to desktop from mobile
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
