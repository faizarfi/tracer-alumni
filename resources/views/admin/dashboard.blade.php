<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Dashboard Admin - UIN Raden Mas Said</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" type="image/png" href="{{ asset('img/uin.png') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script> {{-- For labels on donut slices --}}


    <style>
        /* Global Styles for smooth scroll and font consistency */
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: #2D3748; /* text-gray-800 */
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


        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
        }
        .animate-fade-in-down {
            animation: fadeInDown 0.6s ease forwards;
        }
        .animate-slide-in-left {
            animation: slideInLeft 0.7s ease-out forwards;
        }


        /* Sidebar specific styles - UNIFIED AND CORRECTED */
        #sidebar {
            /* Default state for mobile: hidden off-screen */
            position: fixed; /* Fixed position to overlay content */
            top: 0;
            left: 0;
            width: 100%; /* Take full width on small screens initially */
            max-width: 256px; /* md:w-64 equivalent */
            height: 100vh;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            z-index: 50; /* Ensure it's above other content and overlay */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* shadow-lg */
            display: flex; /* Ensure flexbox for content inside sidebar */
            flex-direction: column; /* Stack items vertically */
        }

        #sidebar.open {
            transform: translateX(0); /* When 'open' class is added, slide in */
        }

        /* Desktop view: sidebar is sticky and visible */
        @media (min-width: 768px) { /* md breakpoint */
            #sidebar {
                position: sticky; /* Back to sticky for normal flow on desktop */
                transform: translateX(0); /* Always visible */
                flex-shrink: 0; /* Prevent it from shrinking */
                width: 256px; /* md:w-64 */
                height: 100vh; /* Full viewport height */
                z-index: 30; /* Can be lower as it's part of the main flow */
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
            z-index: 40; /* Between sidebar and main content */
            display: none; /* Hidden by default, controlled by JS */
        }

        /* Custom scrollbar for activity list */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f0fdf4; /* green-50 */
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #a7f3d0; /* green-200 */
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #6ee7b7; /* green-300 */
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

        {{-- NEW LINK: Manajemen Kaprodi --}}
        <a href="{{ route('admin.kaprodi') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group">
            <iconify-icon icon="mdi:account-tie" class="w-5 h-5 text-pink-300"></iconify-icon>
            <span>Manajemen Kaprodi</span>
        </a>
        {{-- END NEW LINK --}}

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
        {{-- Hidden by default, controlled by JS --}}
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
                    {{-- User Profile/Settings if needed --}}
                    <img src="https://via.placeholder.com/36/065f46/ffffff?text=AD" alt="Admin Avatar" class="w-9 h-9 rounded-full border-2 border-green-700 shadow-md">
                </div>
            </div>

            {{-- New: Dynamic Header with Greeting & Time --}}
            <header class="mb-8 p-4 bg-white rounded-xl shadow-md flex items-center justify-between animate-slide-in-left">
                <div>
                    <h1 class="text-3xl lg:text-4xl font-extrabold text-green-800 tracking-tight font-['Poppins']">
                        Halo, <span id="adminName">Admin</span>!
                    </h1>
                    <p class="text-green-700 text-lg mt-1" id="currentDateTime"></p>
                </div>

            </header>

            {{-- Statistik Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                @php
                    // Pastikan variabel ada, gunakan 0 sebagai default jika tidak ada
                    $totalAlumni = $totalAlumni ?? 0;
                    $bekerja = $bekerja ?? 0;
                    $belumBekerja = $belumBekerja ?? 0;
                    $isiKuisioner = $isiKuisioner ?? 0;

                    $stats = [
                        ['label' => 'Total Alumni', 'value' => $totalAlumni, 'color_from' => 'from-green-400', 'color_to' => 'to-green-600', 'icon' => 'mdi:account-group-outline'],
                        ['label' => 'Sudah Bekerja', 'value' => $bekerja, 'color_from' => 'from-blue-400', 'color_to' => 'to-blue-600', 'icon' => 'mdi:briefcase-check-outline'],
                        ['label' => 'Belum Bekerja', 'value' => $belumBekerja, 'color_from' => 'from-red-400', 'color_to' => 'to-red-600', 'icon' => 'mdi:account-off-outline'],
                        ['label' => 'Kuesioner Terisi', 'value' => $isiKuisioner, 'color_from' => 'from-yellow-400', 'color_to' => 'to-yellow-600', 'icon' => 'mdi:clipboard-list-outline'],
                    ];
                @endphp

                @foreach($stats as $stat)
                    <div
                        class="bg-gradient-to-br {{ $stat['color_from'] }} {{ $stat['color_to'] }} text-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300 ease-in-out flex justify-between items-center cursor-pointer transform hover:scale-105 select-none animate-fade-in-up"
                        style="animation-delay: {{ $loop->index * 0.15 }}s;"
                        title="{{ $stat['label'] }}">
                        <div>
                            <p class="text-sm font-semibold tracking-wide uppercase drop-shadow-md">{{ $stat['label'] }}</p>
                            <p class="text-4xl font-extrabold mt-1 drop-shadow-md font-['Poppins']">{{ $stat['value'] }}</p>
                        </div>
                        <iconify-icon icon="{{ $stat['icon'] }}" width="48" height="48" class="opacity-90 drop-shadow-md"></iconify-icon>
                    </div>
                @endforeach
            </div>

            {{-- Data Visualization Grid (Chart & New Info Card) --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
                <section
                    class="bg-white rounded-2xl shadow-xl p-6 lg:p-8 w-full animate-fade-in-down border border-green-200">
                    <h2 class="text-2xl font-semibold text-green-800 mb-6 text-center select-none drop-shadow-md font-['Poppins']">Statistik Utama Alumni</h2>
                    <div class="w-full flex justify-center items-center" style="height: 320px;">
                        <canvas id="statusChart" class="!w-full !h-full rounded-lg"></canvas>
                    </div>
                </section>

                {{-- NEW FEATURE: Kuesioner and Employment Rate Summary --}}
                <section class="bg-white rounded-2xl shadow-xl p-6 lg:p-8 w-full animate-fade-in-up border border-indigo-200">
                    <h2 class="text-2xl font-semibold text-indigo-800 mb-6 font-['Poppins'] text-center">Ringkasan Persentase Data</h2>
                    <div class="space-y-6">
                        @php
                            $employmentRate = ($totalAlumni > 0) ? round(($bekerja / $totalAlumni) * 100, 1) : 0;
                            $unemploymentRate = ($totalAlumni > 0) ? round(($belumBekerja / $totalAlumni) * 100, 1) : 0;
                            $questionnaireCompletionRate = ($totalAlumni > 0) ? round(($isiKuisioner / $totalAlumni) * 100, 1) : 0;
                        @endphp

                        <div class="flex items-center gap-4 p-4 bg-indigo-50 rounded-xl border border-indigo-100 transition-all duration-300 hover:bg-indigo-100 cursor-pointer">
                            <div class="bg-indigo-200 p-3 rounded-full flex-shrink-0">
                                <i data-lucide="award" class="w-7 h-7 text-indigo-700"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-indigo-800 text-lg">Persentase Alumni Bekerja</p>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $employmentRate }}%"></div>
                                </div>
                                <p class="text-sm text-gray-700 mt-1"><span class="font-bold text-indigo-700">{{ $bekerja }}</span> dari <span class="font-bold text-indigo-700">{{ $totalAlumni }}</span> alumni ({{ $employmentRate }}%)</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 p-4 bg-red-50 rounded-xl border border-red-100 transition-all duration-300 hover:bg-red-100 cursor-pointer">
                            <div class="bg-red-200 p-3 rounded-full flex-shrink-0">
                                <i data-lucide="frown" class="w-7 h-7 text-red-700"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-red-800 text-lg">Persentase Alumni Belum Bekerja</p>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                    <div class="bg-red-600 h-2.5 rounded-full" style="width: {{ $unemploymentRate }}%"></div>
                                </div>
                                <p class="text-sm text-gray-700 mt-1"><span class="font-bold text-red-700">{{ $belumBekerja }}</span> dari <span class="font-bold text-red-700">{{ $totalAlumni }}</span> alumni ({{ $unemploymentRate }}%)</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 p-4 bg-emerald-50 rounded-xl border border-emerald-100 transition-all duration-300 hover:bg-emerald-100 cursor-pointer">
                            <div class="bg-emerald-200 p-3 rounded-full flex-shrink-0">
                                <i data-lucide="check-square" class="w-7 h-7 text-emerald-700"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-emerald-800 text-lg">Tingkat Pengisian Kuesioner</p>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                    <div class="bg-emerald-600 h-2.5 rounded-full" style="width: {{ $questionnaireCompletionRate }}%"></div>
                                </div>
                                <p class="text-sm text-gray-700 mt-1"><span class="font-bold text-emerald-700">{{ $isiKuisioner }}</span> dari <span class="font-bold text-emerald-700">{{ $totalAlumni }}</span> alumni ({{ $questionnaireCompletionRate }}%)</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>


            {{-- Alumni Terbaru Table (Optional: You might consider moving this to the "Manajemen Alumni" page if it gets too long, or limit the display to top 5/10) --}}
            <section
                class="bg-white shadow-xl rounded-2xl p-6 lg:p-8 overflow-x-auto w-full animate-fade-in-up border border-green-200">
                <h2 class="text-2xl font-semibold text-green-800 mb-6 text-center select-none drop-shadow-md font-['Poppins']">Alumni Terbaru</h2>
                @if(($latestAlumni ?? collect())->isEmpty())
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <img src="https://www.svgrepo.com/show/472628/no-data.svg" alt="No Data" class="w-32 h-32 mx-auto mb-4 opacity-60">
                        <p class="text-lg text-gray-500 italic">Belum ada data alumni terbaru yang tersedia.</p>
                    </div>
                @else
                    <div class="rounded-lg overflow-hidden border border-gray-200"> {{-- Added wrapper for rounded table --}}
                        <table class="w-full text-sm">
                            <thead class="bg-green-100 text-green-800 uppercase tracking-wide text-left select-none border-b border-green-200">
                                <tr>
                                    <th class="py-3 px-5">Nama</th>
                                    <th class="py-3 px-5 text-center">NIM</th>
                                    <th class="py-3 px-5 text-center">Jurusan</th>
                                    <th class="py-3 px-5 text-center">Fakultas</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-900 divide-y divide-gray-100"> {{-- Added divide-y --}}
                                @foreach($latestAlumni as $alumni)
                                    <tr
                                        class="hover:bg-green-50 transition-colors duration-200 cursor-pointer select-text">
                                        <td class="py-3 px-5 font-medium">{{ $alumni->nama }}</td>
                                        <td class="py-3 px-5 text-center">{{ $alumni->nim }}</td>
                                        <td class="py-3 px-5 text-center">{{ $alumni->jurusan }}</td>
                                        <td class="py-3 px-5 text-center">{{ $alumni->fakultas }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>

            {{-- Optional: Additional Insights/CTA Card --}}
            <section class="bg-gradient-to-br from-blue-100 to-blue-200 text-blue-900 rounded-2xl shadow-xl p-8 mt-10 flex flex-col md:flex-row items-center gap-6 animate-fade-in border border-blue-300">
                <div class="md:w-2/3">
                    <h2 class="text-3xl font-extrabold mb-3 font-['Poppins']">Perlu Data Lebih Detail?</h2>
                    <p class="text-lg leading-relaxed">
                        Jelajahi halaman Manajemen Alumni untuk melihat daftar lengkap, filter, dan unduh data secara spesifik.
                    </p>
                    <a href="{{ route('admin.alumni') }}" class="mt-5 inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition transform hover:-translate-y-1">
                        <i data-lucide="external-link" class="w-5 h-5 mr-2"></i> Kunjungi Manajemen Alumni
                    </a>
                </div>
                <div class="md:w-1/3 flex justify-center items-center">
                    <iconify-icon icon="mdi:database-search" class="text-blue-700 opacity-70" width="120" height="120"></iconify-icon>
                </div>
            </section>


            {{-- Banner Kampus (Moved to bottom or consider removing for admin context as it's not data-driven) --}}
            <section
                class="bg-gradient-to-r from-green-100 via-green-50 to-green-100 shadow-xl rounded-2xl overflow-hidden w-full flex flex-col md:flex-row items-center select-none border border-green-200 mt-10">
                <img src="https://fokuskampus.com/wp-content/uploads/2023/04/se.410-Foto-kampus-dan-Biaya-Kuliah-2023-di-Universitas-Islam-Negeri-Raden-Mas-Said-Surakarta.jpg"
                    alt="UIN Raden Mas Said Surakarta"
                    class="w-full md:w-1/2 h-56 md:h-auto object-cover rounded-t-2xl md:rounded-l-2xl md:rounded-tr-none shadow-lg">
                <div class="p-6 lg:p-8 text-green-900 max-w-xl">
                    <h2 class="text-2xl lg:text-3xl font-extrabold mb-3 drop-shadow-md font-['Poppins']">UIN Raden Mas Said Surakarta</h2>
                    <p class="text-sm leading-relaxed font-medium tracking-wide">
                        UIN Raden Mas Said Surakarta adalah kampus Islam unggulan yang terakreditasi nasional. Memadukan ilmu pengetahuan dan nilai-nilai spiritual, UIN membekali mahasiswa untuk siap berdaya saing secara global dengan tetap menjunjung tinggi nilai keislaman dan integritas.
                    </p>
                </div>
            </section>

        </main>
    </div>

    {{-- Footer (Integrated from User Dashboard - kept same) --}}
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
        // Pastikan DOM sudah siap sebelum menjalankan script
        document.addEventListener('DOMContentLoaded', function() {
            // New: Dynamic Header
            const adminNameSpan = document.getElementById('adminName');
            const currentDateTimeSpan = document.getElementById('currentDateTime');

            // Anda harus memastikan variabel $totalAlumni, $bekerja, $belumBekerja, $isiKuisioner terdefinisi
            // di Controller Anda dan diteruskan ke view ini. Karena kita tidak bisa mengakses Controller,
            // kita menggunakan nilai default 0 atau placeholder.
            const totalAlumni = parseInt("{{ $totalAlumni ?? 0 }}");
            const bekerja = parseInt("{{ $bekerja ?? 0 }}");
            const belumBekerja = parseInt("{{ $belumBekerja ?? 0 }}");
            const isiKuisioner = parseInt("{{ $isiKuisioner ?? 0 }}");


            // You might fetch the actual admin name from a Laravel variable if available
            // For now, let's keep it static or assign from a placeholder
            // Example: adminNameSpan.textContent = "{{ Auth::user()->name ?? 'Admin' }}";

            function updateDateTime() {
                const now = new Date();
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
                currentDateTimeSpan.textContent = now.toLocaleDateString('id-ID', options);
            }

            updateDateTime();
            setInterval(updateDateTime, 1000); // Update every second


            // Sidebar toggle for mobile
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            // Handler untuk tombol toggle
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

                // Handler untuk overlay (klik di luar sidebar)
                sidebarOverlay.addEventListener('click', () => {
                    sidebar.classList.remove('open');
                    sidebarOverlay.style.display = 'none'; // Hide overlay
                    document.body.style.overflow = ''; // Restore body scroll
                });

                // Close sidebar and hide overlay if window is resized to desktop from mobile
                window.addEventListener('resize', () => {
                    // Cek apakah lebar layar lebih besar atau sama dengan breakpoint 'md' (768px)
                    if (window.innerWidth >= 768) {
                        sidebar.classList.remove('open');
                        sidebarOverlay.style.display = 'none';
                        document.body.style.overflow = ''; // Ensure scroll is restored
                    }
                });
            } else {
                console.error("One or more sidebar elements not found!");
            }


            // Register Chart.js DataLabels plugin
            Chart.register(ChartDataLabels);

            // Chart.js doughnut chart
            const ctx = document.getElementById('statusChart');
            if (ctx) { // Pastikan elemen canvas ditemukan
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Total Alumni', 'Sudah Bekerja', 'Belum Bekerja', 'Kuesioner Terisi'],
                        datasets: [{
                            // Menggunakan variabel JS yang sudah di-parse dari Blade
                            data: [totalAlumni, bekerja, belumBekerja, isiKuisioner],
                            backgroundColor: [
                                '#10B981', // green-500 for Total Alumni (consistent with card color)
                                '#3B82F6', // blue-500 for Sudah Bekerja
                                '#EF4444', // red-500 for Belum Bekerja
                                '#F59E0B'  // amber-500 for Kuesioner Terisi
                            ],
                            borderColor: '#ffffff', // White border for slices
                            borderWidth: 2,
                            hoverOffset: 12
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#065f46', // green-900
                                    font: { size: 13, weight: '600', family: 'Inter' },
                                    padding: 20,
                                }
                            },
                            tooltip: {
                                bodyFont: { family: 'Inter', size: 13 },
                                titleFont: { family: 'Inter', weight: 'bold', size: 14 },
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        label += context.raw; // The raw data value
                                        let totalForPercentage = 0;
                                        // Calculate percentage relative to Total Alumni for relevant slices
                                        if (context.label === 'Sudah Bekerja' || context.label === 'Belum Bekerja') {
                                            totalForPercentage = context.dataset.data[0]; // Total Alumni is the first data point
                                        } else if (context.label === 'Kuesioner Terisi') {
                                            totalForPercentage = context.dataset.data[0];
                                        } else if (context.label === 'Total Alumni') {
                                            return label + ' alumni';
                                        }

                                        if (totalForPercentage > 0) {
                                            const percentage = ((context.raw / totalForPercentage) * 100).toFixed(1) + '%';
                                            return label + ' alumni (' + percentage + ')';
                                        }
                                        return label + ' alumni';
                                    }
                                }
                            },
                            datalabels: { // Configure the datalabels plugin
                                color: '#fff', // Label color
                                font: {
                                    weight: 'bold',
                                    size: 14,
                                    family: 'Inter'
                                },
                                formatter: (value, context) => {
                                    // Only show label for slices that have non-zero value
                                    if (value === 0) return ''; // Hide 0 values
                                    if (context.label === 'Sudah Bekerja' || context.label === 'Belum Bekerja') {
                                        const totalAlumniValue = context.dataset.data[0];
                                        if (totalAlumniValue > 0) {
                                            const percentage = ((value / totalAlumniValue) * 100).toFixed(0); // Round to whole number
                                            return percentage + '%';
                                        }
                                    }
                                    // For Total Alumni and Kuesioner Terisi, just show the count
                                    return value;
                                },
                                textShadowColor: 'rgba(0, 0, 0, 0.5)', // Stronger shadow for better readability
                                textShadowBlur: 6
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: { duration: 900 }
                    }
                });
            } else {
                console.error("Chart canvas element not found!");
            }


            // Scroll to top button show/hide & click
            const scrollTopBtn = document.getElementById('scrollTop');
            if (scrollTopBtn) { // Pastikan tombol ditemukan
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
            } else {
                console.log("Scroll to top button not found.");
            }

            // Initialize Lucide icons for footer (Iconify for sidebar icons handled by custom element)
            lucide.createIcons();
        });
    </script>
</body>

</html>
