<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Manajemen Galeri - UIN Raden Mas Said</title>
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

        /* Style for Image Card Hover */
        .image-card:hover .overlay {
            opacity: 1;
        }
        .image-card .overlay {
            transition: opacity 0.3s ease;
            opacity: 0;
        }

        /* Footer Link Hover Effect - More Prominent Pop */
        .footer-link-smooth:hover {
            color: #ffffff;
            transform: translateX(8px) scale(1.05);
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.5);
        }
        .footer-link-smooth {
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        /* --- New Image Zoom Styles --- */
        .image-zoom-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            display: none; /* Hidden by default */
            place-items: center;
        }

        .image-zoom-preview {
            max-width: 90%;
            max-height: 90%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            border-radius: 12px;
            object-fit: contain;
            transition: transform 0.3s ease-out;
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
        <div id="sidebar-overlay" class="md:hidden"></div>

        {{-- Main Content Container (Flex-1 ensures it pushes the footer down if content is short) --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8 flex flex-col">
            {{-- Top Bar for Mobile/Tablet --}}
            <div class="flex justify-between items-center mb-6 md:hidden w-full">
                <button id="sidebarToggle"
                    class="text-white bg-green-700 p-2.5 rounded-md shadow-md hover:bg-green-800 transition-colors focus:outline-none focus:ring-2 focus:ring-green-600">
                    <iconify-icon icon="mdi:menu" class="w-5 h-5"></iconify-icon>
                </button>
                <div class="flex items-center gap-3">
                    <span class="text-base font-semibold text-green-900">Halo, Admin!</span>
                    <img src="https://via.placeholder.com/36/065f46/ffffff?text=AD" alt="Admin Avatar" class="w-9 h-9 rounded-full border-2 border-green-700 shadow-md">
                </div>
            </div>

            {{-- New: Dynamic Header with Greeting & Time --}}
            <header class="mb-8 p-4 bg-white rounded-xl shadow-md flex items-center justify-between animate-slide-in-left">
                <div>
                    <h1 class="text-3xl lg:text-4xl font-extrabold text-green-800 tracking-tight font-['Poppins']">
                        Manajemen Galeri
                    </h1>
                    <p class="text-green-700 text-lg mt-1" id="currentDateTime"></p>
                </div>

            </header>

            {{-- Notifikasi (Success/Error) --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md animate-fade-in" role="alert">
                    <div class="flex items-center">
                        <i data-lucide="check-circle" class="w-6 h-6 mr-3"></i>
                        <p class="font-bold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md animate-fade-in" role="alert">
                    <div class="flex items-center">
                        <i data-lucide="alert-triangle" class="w-6 h-6 mr-3"></i>
                        <div>
                            <p class="font-bold">Gagal mengunggah foto:</p>
                            @foreach ($errors->all() as $error)
                                <p class="text-sm mt-1">- {{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif


            <section class="bg-white shadow-xl rounded-2xl p-6 lg:p-8 w-full border border-green-200 flex-1">

                {{-- Tombol Tambah Foto --}}
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Daftar Foto ({{ $galleries->count() ?? 0 }} Item)</h3>
                    <button onclick="openModal('add-photo-modal')"
                        class="flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition transform hover:-translate-y-0.5 text-sm">
                        <i data-lucide="image-plus" class="w-4 h-4 mr-2"></i> Tambah Foto
                    </button>
                </div>

                {{-- Daftar Foto DARI DATABASE --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                    @forelse($galleries as $gallery)
                    <div class="image-card bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden relative transform hover:shadow-xl transition duration-300">

                        {{-- Image Display (Menggunakan Storage::url dan data-attribute untuk zoom) --}}
                        <div class="relative w-full h-48 cursor-pointer"
                             onclick="openImageZoom('{{ \Illuminate\Support\Facades\Storage::url($gallery->image_path) }}')">
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($gallery->image_path) }}"
                                 alt="{{ $gallery->title }}"
                                 onerror="this.onerror=null;this.src='https://placehold.co/400x200/9ca3af/ffffff?text=IMAGE+ERROR';"
                                 class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">

                            {{-- Overlay & Tombol Aksi (Tarik ke kanan atas) --}}
                            <div class="overlay absolute inset-0 bg-black bg-opacity-40 flex items-start justify-end opacity-0 transition duration-300 p-2">
                                <div class="flex flex-col space-y-2">

                                    {{-- Tombol Edit --}}
                                    <button type="button"
                                            onclick="event.stopPropagation(); openEditModal({{ $gallery->id }}, '{{ addslashes($gallery->title) }}', '{{ addslashes($gallery->description) }}')"
                                            title="Edit Foto"
                                            class="text-white hover:text-yellow-300 bg-gray-800 bg-opacity-70 hover:bg-opacity-100 transition p-2 rounded-full shadow-lg transform hover:scale-110">
                                        <i data-lucide="square-pen" class="w-5 h-5"></i>
                                    </button>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST" onsubmit="event.stopPropagation(); return confirm('Apakah Anda yakin ingin menghapus foto {{ $gallery->title }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Foto" class="text-white hover:text-red-400 bg-red-600 bg-opacity-70 hover:bg-opacity-100 transition p-2 rounded-full shadow-lg transform hover:scale-110">
                                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Metadata --}}
                        <div class="p-4">
                            <p class="font-bold text-gray-800 text-base leading-tight line-clamp-2">{{ $gallery->title }}</p>
                            <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $gallery->description ?? '— Tidak ada deskripsi —' }}</p>
                            <p class="text-xs text-gray-400 mt-3">Diunggah {{ $gallery->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="lg:col-span-4 text-center py-16 bg-gray-50 rounded-xl shadow-inner animate-fade-in">
                        <i data-lucide="image-off" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                        <p class="text-xl text-gray-500 italic font-semibold">Belum ada foto dalam galeri.</p>
                        <p class="text-sm text-gray-400 mt-2">Gunakan tombol "Tambah Foto" di atas untuk memulai.</p>
                    </div>
                    @endforelse
                </div>
            </section>

            {{-- Modal Tambah Foto --}}
            <div id="add-photo-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center p-4 transition-opacity duration-300">
                <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg transform scale-95 transition-transform duration-300">
                    <div class="p-6 border-b flex justify-between items-center">
                        <h3 class="text-xl font-bold text-green-800">Unggah Foto Baru</h3>
                        <button onclick="closeModal('add-photo-modal')" class="text-gray-400 hover:text-gray-700">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Foto <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" placeholder="Contoh: Kegiatan UKM Seni 2024" required
                                class="w-full border border-gray-300 rounded-lg p-2.5 focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (Opsional)</label>
                            <textarea name="description" id="description" rows="3" placeholder="Deskripsi singkat tentang foto ini..."
                                class="w-full border border-gray-300 rounded-lg p-2.5 focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50"></textarea>
                        </div>
                        <div class="mb-6">
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Pilih Foto <span class="text-red-500">*</span></label>
                            <input type="file" name="image" id="image" accept="image/jpeg, image/png, image/jpg" required
                                class="w-full text-gray-700 border border-gray-300 rounded-lg p-2.5 bg-gray-50 focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB.</p>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" onclick="closeModal('add-photo-modal')"
                                class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-5 py-2 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 transition">
                                Unggah
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Modal Edit Foto --}}
            <div id="edit-photo-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center p-4 transition-opacity duration-300">
                <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg transform scale-95 transition-transform duration-300">
                    <div class="p-6 border-b flex justify-between items-center">
                        <h3 class="text-xl font-bold text-yellow-800">Edit Foto Galeri</h3>
                        <button onclick="closeModal('edit-photo-modal')" class="text-gray-400 hover:text-gray-700">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                    {{-- Form ini akan diisi secara dinamis oleh JavaScript --}}
                    <form id="edit-gallery-form" action="" method="POST" enctype="multipart/form-data" class="p-6">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="title_edit" class="block text-sm font-medium text-gray-700 mb-2">Judul Foto <span class="text-red-500">*</span></label>
                            <input type="text" name="title_edit" id="title_edit" required
                                class="w-full border border-gray-300 rounded-lg p-2.5 focus:border-yellow-500 focus:ring focus:ring-yellow-500 focus:ring-opacity-50">
                        </div>
                        <div class="mb-4">
                            <label for="description_edit" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (Opsional)</label>
                            <textarea name="description_edit" id="description_edit" rows="3"
                                class="w-full border border-gray-300 rounded-lg p-2.5 focus:border-yellow-500 focus:ring focus:ring-yellow-500 focus:ring-opacity-50"></textarea>
                        </div>
                        <div class="mb-6">
                            <label for="image_edit" class="block text-sm font-medium text-gray-700 mb-2">Ganti Foto (Opsional)</label>
                            <input type="file" name="image_edit" id="image_edit" accept="image/jpeg, image/png, image/jpg"
                                class="w-full text-gray-700 border border-gray-300 rounded-lg p-2.5 bg-gray-50 focus:border-yellow-500 focus:ring focus:ring-yellow-500 focus:ring-opacity-50">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin diganti.</p>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" onclick="closeModal('edit-photo-modal')"
                                class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-5 py-2 bg-yellow-600 text-white rounded-lg shadow-md hover:bg-yellow-700 transition">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Footer --}}
            <footer class="mt-16 pt-16 pb-8 bg-gradient-to-r from-green-900 to-emerald-800 shadow-inner">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 text-sm">
                    <div class="md:col-span-1">
                        <h2 class="text-xl font-bold mb-4 font-['Poppins'] text-white">Tracer Alumni UIN RMS</h2>
                        <p class="text-green-200 leading-relaxed text-sm max-w-xs">
                            Sistem Tracer Alumni ini dirancang untuk menghimpun data alumni, mendukung peningkatan mutu pendidikan, dan akreditasi kampus.
                            Partisipasi Anda sangat berarti!
                        </p>
                    </div>

                    <div class="md:col-span-1">
                        <h2 class="text-xl font-bold mb-4 flex items-center gap-2 font-['Poppins'] text-white" aria-label="Navigasi Cepat">
                            <i data-lucide="compass" class="w-5 h-5 text-green-300"></i> Navigasi Cepat
                        </h2>
                        <ul class="space-y-3 text-green-200">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-green-200 hover:text-white transition duration-300 ease-in-out footer-link-smooth">
                                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.alumni') }}" class="flex items-center gap-2 text-green-200 hover:text-white transition duration-300 ease-in-out footer-link-smooth">
                                    <i data-lucide="users" class="w-4 h-4"></i> Data Alumni
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.kuisioner') }}" class="flex items-center gap-2 text-green-200 hover:text-white transition duration-300 ease-in-out footer-link-smooth">
                                    <i data-lucide="clipboard-check" class="w-4 h-4"></i> Data Kuesioner
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="md:col-span-1">
                        <h2 class="text-xl font-bold mb-4 font-['Poppins'] text-white">Tautan Terkait</h2>
                        <ul class="space-y-3 text-green-200">
                            <li>
                                <a href="https://uinsaid.ac.id" target="_blank" rel="noopener noreferrer" class="hover:underline flex items-center gap-2 footer-link-smooth">
                                    <i data-lucide="globe" class="w-4 h-4"></i> Website Resmi UIN RMS
                                </a>
                            </li>
                            <li>
                                <a href="https://pmb.uinsaid.ac.id" target="_blank" rel="noopener noreferrer" class="hover:underline flex items-center gap-2 footer-link-smooth">
                                    <i data-lucide="graduation-cap" class="w-4 h-4"></i> PMB UIN RMS
                                </a>
                            </li>
                            <li>
                                <a href="https://e-journal.uinsaid.ac.id/" target="_blank" rel="noopener noreferrer" class="hover:underline flex items-center gap-2 footer-link-smooth">
                                    <i data-lucide="book-text" class="w-4 h-4"></i> E-Journal UIN RMS
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="md:col-span-1">
                        <h2 class="text-xl font-bold mb-4 font-['Poppins'] text-white">Kontak Kami</h2>
                        <ul class="text-green-200 space-y-3">
                            <li class="flex items-start gap-2">
                                <i data-lucide="mail" class="w-4 h-4 text-green-300 flex-shrink-0 mt-1"></i>
                                <a href="mailto:tracer@uinsaid.ac.id" class="hover:underline footer-link-smooth" target="_blank">tracer@uinsaid.ac.id</a>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="phone" class="w-4 h-4 text-green-300 flex-shrink-0 mt-1"></i> (0271) 678901
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="instagram" class="w-4 h-4 text-green-300 flex-shrink-0 mt-1"></i>
                                <a href="#" class="hover:underline footer-link-smooth" target="_blank">@traceruinrms</a>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="map-pin" class="w-4 h-4 text-green-300 flex-shrink-0 mt-1"></i>
                                Jl. Pandawa, Pucangan, Kartasura, Sukoharjo, Jawa Tengah 57168
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="text-center text-green-300 text-xs border-t border-green-800 py-6 mt-12">
                    &copy; {{ date('Y') }} UIN Raden Mas Said Surakarta. Hak Cipta Dilindungi Undang-Undang.

                </div>
            </footer>
        </main>
    </div>

    <div id="image-zoom-modal" class="image-zoom-container hidden fixed inset-0 bg-black bg-opacity-70 z-[9999] place-items-center">
        <img id="image-zoom-preview" src="" alt="Image Preview" class="image-zoom-preview" onclick="this.parentNode.classList.add('hidden')">
    </div>

    <button id="scrollTop" aria-label="Scroll to top"
        class="fixed bottom-6 right-6 z-50 hidden bg-green-700 hover:bg-green-800 text-white p-3 rounded-full shadow-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-500">
        <iconify-icon icon="mdi:arrow-up-bold" class="w-6 h-6"></iconify-icon>
    </button>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.style.overflow = '';
        }

        function openImageZoom(imageUrl) {
            const zoomModal = document.getElementById('image-zoom-modal');
            const zoomPreviewImg = document.getElementById('image-zoom-preview');
            zoomPreviewImg.src = imageUrl;
            zoomModal.style.display = 'grid';
            document.body.style.overflow = 'hidden';
        }
        function openEditModal(id, title, description) {
            const form = document.getElementById('edit-gallery-form');
            const url = '{{ route('admin.gallery.update', ['id' => ':id']) }}';

            form.action = url.replace(':id', id);
            document.getElementById('title_edit').value = title;
            document.getElementById('description_edit').value = description;
            openModal('edit-photo-modal');
        }
        document.addEventListener('DOMContentLoaded', function() {

            const currentDateTimeSpan = document.getElementById('currentDateTime');

            function updateDateTime() {
                const now = new Date();
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
                currentDateTimeSpan.textContent = now.toLocaleDateString('id-ID', options);
            }

            updateDateTime();
            setInterval(updateDateTime, 1000);

            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            if (sidebarToggle && sidebar && sidebarOverlay) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('open');
                    if (sidebar.classList.contains('open')) {
                        sidebarOverlay.style.display = 'block';
                        document.body.style.overflow = 'hidden';
                    } else {
                        sidebarOverlay.style.display = 'none';
                        document.body.style.overflow = '';
                    }
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
            } else {
                console.error("One or more sidebar elements not found!");
            }
            const zoomModal = document.getElementById('image-zoom-modal');
            if (zoomModal) {
                 zoomModal.addEventListener('click', (e) => {
                    if (e.target.id === 'image-zoom-modal') {
                        closeModal('image-zoom-modal');
                    }
                });
            }

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
            } else {
                console.log("Scroll to top button not found.");
            }
            lucide.createIcons();
        });
    </script>
</body>

</html>
