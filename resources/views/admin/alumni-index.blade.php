<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Manajemen Alumni - Admin UIN Raden Mas Said</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    {{-- Pastikan path asset ini benar --}}
    <link rel="icon" type="image/png" href="{{ asset('img/uin.png') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN, pastikan ini di-load dengan benar --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Iconify CDN --}}
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    {{-- Lucide Icons CDN --}}
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

        /* Modal specific styles */
        .modal-container {
            display: none;
            /* Hidden by default */
        }
        .modal-container.active {
            display: grid;
            place-items: center;
            opacity: 1;
        }

        .img-preview {
            max-width: 90vw;
            max-height: 90vh;
            object-fit: contain;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
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

        {{-- Main Content --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8 flex flex-col">
            {{-- Top Bar for Mobile/Tablet --}}
            <div class="flex justify-between items-center mb-6 md:hidden w-full">
                <button id="sidebarToggle"
                    class="text-white bg-green-700 p-2.5 rounded-md shadow-md hover:bg-green-800 transition-colors focus:outline-none focus:ring-2 focus:ring-green-600">
                    <iconify-icon icon="mdi:menu" class="w-5 h-5"></iconify-icon>
                </button>
                <div class="flex items-center gap-3">
                    <span class="text-base font-semibold text-green-900">Halo, Admin!</span>
                    {{-- User Avatar Placeholder --}}
                    <img src="https://via.placeholder.com/36/065f46/ffffff?text=AD" alt="Admin Avatar" class="w-9 h-9 rounded-full border-2 border-green-700 shadow-md">
                </div>
            </div>

            {{-- Header/Title Section --}}
            <header class="mb-8 p-4 bg-white rounded-xl shadow-md flex items-center justify-between animate-fade-in">
                <div>
                    <h1 class="text-3xl lg:text-4xl font-extrabold text-green-800 tracking-tight font-['Poppins']">
                        Manajemen Data Alumni
                    </h1>
                    <p class="text-green-700 text-lg mt-1">Total Alumni Terdata: {{ $alumnis->total() ?? 0 }}</p>
                </div>
                <div class="flex flex-col items-end">
                    <p class="text-sm font-semibold text-gray-700" id="currentDate"></p>
                    <p class="text-sm text-gray-600" id="currentTime"></p>
                </div>
            </header>

            <div class="container mx-auto bg-white rounded-2xl shadow-2xl border border-gray-200 flex-1">

                {{-- Success/Error Alerts --}}
                @if(session('success'))
                    <div class="px-6 pt-6">
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
                    <div class="px-6 pt-6">
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


                <div class="p-6 pb-4 border-b border-gray-200 bg-gray-50 rounded-t-2xl">
                    <div class="flex flex-wrap justify-between items-center mb-4 gap-3">
                         <h2 class="text-xl font-bold text-gray-800">Filter Data</h2>
                         <a href="{{ route('admin.alumni.exportCsv') }}"
                            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 transition text-white font-semibold py-2 px-4 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transform hover:scale-[1.03] text-sm">
                            <span class="iconify" data-icon="mdi:file-export" style="font-size: 20px;"></span>
                            Ekspor Data CSV
                        </a>
                    </div>

                    {{-- Filter and Search Form --}}
                    <form action="{{ route('admin.alumni') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-4">

                        <div class="relative w-full sm:flex-grow">
                            <input type="text" name="cari" placeholder="Cari nama / NIM / jurusan / fakultas..."
                                    value="{{ request('cari') }}"
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-900 placeholder-gray-500 transition text-sm shadow-sm" />
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 iconify" data-icon="mdi:magnify"></span>
                        </div>

                        @php
                            $currentSort = request()->input('sort');
                            $currentDir = request()->input('direction', 'asc');
                            $currentStatus = request()->input('status_kerja');
                        @endphp

                        {{-- New: Status Kerja Filter Dropdown --}}
                        <select name="status_kerja" onchange="this.form.submit()"
                                class="w-full sm:w-auto px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm shadow-sm">
                            <option value="">Status Kerja: Semua</option>
                            <option value="1" {{ $currentStatus === '1' ? 'selected' : '' }}>Sudah Bekerja</option>
                            <option value="0" {{ $currentStatus === '0' ? 'selected' : '' }}>Belum Bekerja</option>
                        </select>

                        <select name="sort" onchange="this.form.submit()"
                                class="w-full sm:w-auto px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm shadow-sm">
                            <option value="nama" {{ $currentSort == 'nama' ? 'selected' : '' }}>Sort by: Nama</option>
                            <option value="nim" {{ $currentSort == 'nim' ? 'selected' : '' }}>Sort by: NIM</option>
                            <option value="fakultas" {{ $currentSort == 'fakultas' ? 'selected' : '' }}>Sort by: Fakultas</option>
                            <option value="tahun_masuk" {{ $currentSort == 'tahun_masuk' ? 'selected' : '' }}>Sort by: Tahun Masuk</option>
                            <option value="tahun_keluar" {{ $currentSort == 'tahun_keluar' ? 'selected' : '' }}>Sort by: Tahun Lulus</option>
                        </select>

                        <select name="direction" onchange="this.form.submit()"
                                class="w-full sm:w-auto px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition text-sm shadow-sm">
                            <option value="asc" {{ $currentDir == 'asc' ? 'selected' : '' }}>Urutan: Ascending (A-Z)</option>
                            <option value="desc" {{ $currentDir == 'desc' ? 'selected' : '' }}>Urutan: Descending (Z-A)</option>
                        </select>

                        <button type="submit"
                                class="flex items-center justify-center gap-2 bg-green-700 hover:bg-green-800 text-white font-semibold py-2.5 px-6 rounded-lg shadow-md transition transform hover:-translate-y-0.5 w-full sm:w-auto">
                            <span class="iconify" data-icon="mdi:filter-variant" style="font-size: 18px;"></span>
                            Terapkan
                        </button>
                    </form>
                </div>

                {{-- Data Table --}}
                <div class="overflow-x-auto p-6 pt-0">
                    <table class="min-w-full divide-y divide-gray-200 text-gray-800 text-sm">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider rounded-tl-lg text-green-800 font-bold">Foto</th>
                                <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Nama / ID</th>
                                <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">NIM</th>
                                <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Tgl Lahir / Asal</th>
                                <th class="px-5 py-4 text-center whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Masuk</th>
                                <th class="px-5 py-4 text-center whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Lulus</th>
                                <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Akademik</th>
                                <th class="px-5 py-4 text-center whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Status Kerja</th>
                                <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Tempat Bekerja</th>
                                <th class="px-5 py-4 text-center whitespace-nowrap text-xs uppercase tracking-wider rounded-tr-lg text-green-800 font-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($alumnis as $alumni)
                                <tr class="odd:bg-white even:bg-green-50 hover:bg-green-100 transition duration-150 ease-in-out">
                                    {{-- Kolom Foto --}}
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        @if($alumni->foto_path)
                                            <button onclick="openPhotoModal('{{ Storage::url($alumni->foto_path) }}', '{{ $alumni->nama }}')" class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0 border border-gray-300 shadow-sm transition transform hover:scale-110">
                                                <img src="{{ Storage::url($alumni->foto_path) }}"
                                                    alt="Foto {{ $alumni->nama }}"
                                                    onerror="this.onerror=null;this.src='https://placehold.co/40x40/ccc/fff?text=No';"
                                                    class="w-full h-full object-cover">
                                            </button>
                                        @else
                                            <span class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">N/A</span>
                                        @endif
                                    </td>
                                    {{-- Kolom Nama / User ID --}}
                                    <td class="px-5 py-3.5 whitespace-nowrap font-semibold text-gray-800">
                                        {{ $alumni->nama }}<br>
                                        <span class="text-xs text-gray-500 font-normal">ID: {{ $alumni->user_id }}</span>
                                    </td>
                                    {{-- Kolom NIM --}}
                                    <td class="px-5 py-3.5 whitespace-nowrap text-gray-600">{{ $alumni->nim }}</td>
                                    {{-- Kolom Tgl Lahir / Asal --}}
                                    <td class="px-5 py-3.5 whitespace-nowrap text-gray-600">
                                        {{ \Carbon\Carbon::parse($alumni->tanggal_lahir)->format('d M Y') }}<br>
                                        <span class="text-xs text-gray-500">({{ $alumni->asal }})</span>
                                    </td>
                                    {{-- Kolom Tahun Masuk --}}
                                    <td class="px-5 py-3.5 whitespace-nowrap text-center font-bold text-blue-600">{{ $alumni->tahun_masuk ?? '-' }}</td>
                                    {{-- Kolom Tahun Keluar --}}
                                    <td class="px-5 py-3.5 whitespace-nowrap text-center font-bold text-green-600">{{ $alumni->tahun_keluar ?? '-' }}</td>
                                    {{-- Kolom Akademik (Jurusan/Fakultas) --}}
                                    <td class="px-5 py-3.5 whitespace-nowrap text-gray-600">
                                        <span class="font-medium">{{ $alumni->jurusan }}</span><br>
                                        <span class="text-xs text-gray-500">{{ $alumni->fakultas }}</span>
                                    </td>
                                    {{-- Kolom Status Kerja --}}
                                    <td class="px-5 py-3.5 whitespace-nowrap text-center">
                                        @if($alumni->sudah_bekerja)
                                            <span class="inline-flex items-center gap-1 px-3 py-1 text-green-700 bg-green-100 rounded-full font-semibold text-xs border border-green-200">
                                                <i data-lucide="check" class="w-3 h-3"></i> Bekerja
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-3 py-1 text-red-700 bg-red-100 rounded-full font-semibold text-xs border border-red-200">
                                                <i data-lucide="x" class="w-3 h-3"></i> Belum Bekerja
                                            </span>
                                        @endif
                                    </td>
                                    {{-- Kolom Tempat Bekerja --}}
                                    <td class="px-5 py-3.5 whitespace-nowrap max-w-xs truncate text-gray-600" title="{{ $alumni->tempat_bekerja ?: '-' }}">
                                        {{ $alumni->sudah_bekerja && $alumni->tempat_bekerja ? $alumni->tempat_bekerja : '-' }}
                                    </td>
                                    {{-- Kolom Aksi (Dengan Teks Jelas) --}}
                                    <td class="px-5 py-3.5 whitespace-nowrap text-center flex justify-center gap-2 items-center">
                                        <a href="{{ route('admin.alumni.edit', $alumni->user_id) }}"
                                           class="text-white bg-blue-600 hover:bg-blue-700 p-2 text-xs rounded-lg shadow-md transition transform hover:scale-105 flex items-center justify-center gap-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           title="Edit Data">
                                            <span class="iconify" data-icon="mdi:pencil" style="font-size: 14px;"></span>
                                            <span class="hidden sm:inline">Edit</span>
                                        </a>
                                        <form action="{{ route('admin.alumni.destroy', $alumni->user_id) }}" method="POST"
                                              onsubmit="return confirm('Anda yakin menghapus data {{ $alumni->nama }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-white bg-red-600 hover:bg-red-700 p-2 text-xs rounded-lg shadow-md transition transform hover:scale-105 flex items-center justify-center gap-1 focus:outline-none focus:ring-2 focus:ring-red-500"
                                                    title="Hapus Data">
                                                <span class="iconify" data-icon="mdi:delete" style="font-size: 14px;"></span>
                                                <span class="hidden sm:inline">Hapus</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-12 text-gray-500 italic bg-gray-50 rounded-b-lg">
                                        <img src="https://www.svgrepo.com/show/472628/no-data.svg" alt="No Data" class="w-36 h-36 mx-auto mb-5 opacity-60">
                                        <p class="text-lg font-medium">Data Alumni Tidak Ditemukan</p>
                                        <p class="text-sm mt-1">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links --}}
                <div class="mt-4 p-6 flex justify-center border-t border-gray-100">
                    <nav class="bg-white p-4 rounded-lg shadow-lg border border-gray-100">
                        {{ $alumnis->appends(request()->all())->links('pagination::tailwind') }}
                    </nav>
                </div>

            </div>
        </main>
    </div>

    {{-- Photo Preview Modal --}}
    <div id="photo-modal" class="modal-container fixed inset-0 bg-black bg-opacity-70 z-[9999] opacity-0 transition-opacity duration-300">
        <div class="relative p-4 max-w-full max-h-full">
             <img id="modal-photo" src="" alt="Foto Alumni" class="img-preview rounded-xl">
             <button onclick="closePhotoModal()" class="absolute top-2 right-2 text-white bg-red-600/70 hover:bg-red-700 p-2 rounded-full transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
             </button>
        </div>
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
        function openPhotoModal(imageUrl, alumniName) {
            const modal = document.getElementById('photo-modal');
            const photoElement = document.getElementById('modal-photo');

            photoElement.src = imageUrl;
            photoElement.alt = 'Foto Profil ' + alumniName;

            modal.classList.add('active');
            document.body.style.overflow = 'hidden'; // Kunci scroll body
        }

        function closePhotoModal() {
            const modal = document.getElementById('photo-modal');
            modal.classList.remove('active');
            document.body.style.overflow = ''; // Buka kunci scroll body
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar logic
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const currentDateElement = document.getElementById('currentDate');
            const currentTimeElement = document.getElementById('currentTime');

            function updateTime() {
                const now = new Date();
                const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const formattedDate = now.toLocaleDateString('id-ID', optionsDate);
                const formattedTime = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

                currentDateElement.textContent = formattedDate;
                currentTimeElement.textContent = formattedTime + ' WIB';
            }

            updateTime();
            setInterval(updateTime, 1000);

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
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            // Initialize Lucide icons
            lucide.createIcons();
        });
    </script>
</body>

</html>
