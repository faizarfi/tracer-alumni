<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Tambah Kaprodi - UIN Raden Mas Said</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* CSS dari dashboard_admin.html */
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; color: #2D3748; }
        h1, h2, h3, h4 { font-family: 'Poppins', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f0fdf4; }
        ::-webkit-scrollbar-thumb { background: #065f46; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #047857; }

        /* Sidebar specific styles */
        #sidebar {
            position: fixed; top: 0; left: 0; width: 100%; max-width: 220px;
            height: 100vh; transform: translateX(-100%); transition: transform 0.3s ease-in-out;
            z-index: 50; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            display: flex; flex-direction: column;
        }
        #sidebar.open { transform: translateX(0); }
        @media (min-width: 768px) {
            #sidebar {
                position: sticky; transform: translateX(0); flex-shrink: 0;
                width: 220px; height: 100vh; z-index: 30;
            }
        }
        #sidebar-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.5); z-index: 40; display: none;
        }
        /* Animasi sederhana untuk notifikasi */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
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
            <nav class="px-4 py-4 flex flex-col space-y-3 flex-1">
                <a href="/admin/dashboard" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group">
                    <iconify-icon icon="mdi:view-dashboard" class="w-5 h-5 text-green-300"></iconify-icon>
                    <span>Dashboard</span>
                </a>
                <a href="/admin/kuisioner" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group">
                    <iconify-icon icon="mdi:clipboard-text-outline" class="w-5 h-5 text-yellow-300"></iconify-icon>
                    <span>Manajemen Kuesioner</span>
                </a>

                <a href="/admin/testimonials/approved" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group">
                     <iconify-icon icon="mdi:message-badge-outline" class="w-5 h-5 text-red-300"></iconify-icon>
                    <span>Manajemen Testimoni</span>
                </a>

                <a href="/admin/alumni" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group">
                    <iconify-icon icon="mdi:account-multiple-outline" class="w-5 h-5 text-blue-300"></iconify-icon>
                    <span>Manajemen Alumni</span>
                </a>
                <a href="/admin/gallery" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm hover:bg-white/10 group">
                    <iconify-icon icon="mdi:image-multiple-outline" class="w-5 h-5 text-purple-300"></iconify-icon>
                    <span>Manajemen Gallery</span>
                </a>

                {{-- LINK KAPRODI (ACTIVE) --}}
                <a href="/admin/kaprodi" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg font-semibold text-sm bg-white bg-opacity-20 shadow-md">
                    <iconify-icon icon="mdi:account-tie" class="w-5 h-5 text-pink-300"></iconify-icon>
                    <span>Manajemen Kaprodi</span>
                </a>

                {{-- Logout Button --}}
                <form action="/logout" method="POST" class="mt-auto pt-6">
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
    <main class="flex-1 p-4 sm:p-4 lg:p-6 flex flex-col">

            {{-- Header/Title Section --}}
            <header class="mb-6 p-3 bg-white rounded-xl shadow-md flex items-center justify-between animate-fade-in">
                {{-- TOMBOL TOGGLE SIDEBAR (Diperlukan untuk Mobile) --}}
                <button id="sidebarToggle" class="mr-3 text-green-700 md:hidden p-2 rounded hover:bg-green-100 transition duration-150" aria-label="Toggle Menu">
                    <i data-lucide="menu" class="w-4 h-4"></i>
                </button>
                <div class="flex-grow">
                    <h1 class="text-lg lg:text-xl font-extrabold text-green-800 tracking-tight font-['Poppins']">
                        Tambah Data Ketua Program Studi (Kaprodi)
                    </h1>
                    <p class="text-green-700 text-xs mt-1">Isi formulir di bawah untuk mendaftarkan Kaprodi baru.</p>
                </div>
                <div class="flex flex-col items-end flex-shrink-0 ml-4">
                    <p class="text-sm font-semibold text-gray-700" id="currentDate"></p>
                    <p class="text-sm text-gray-600" id="currentTime"></p>
                </div>
            </header>

            <div class="container mx-auto bg-white rounded-xl shadow-md border border-gray-200 p-4 flex-1">

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 animate-fade-in" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 animate-fade-in" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">Formulir Pendaftaran</h2>

                {{-- Formulir Tambah Kaprodi (ACTION POST) --}}
                <form action="{{ route('admin.kaprodi.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kaprodi <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition shadow-sm text-gray-900 hover:border-green-400"
                            placeholder="Nama Lengkap Kaprodi"/>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email (Digunakan untuk Login) <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition shadow-sm text-gray-900 hover:border-green-400"
                            placeholder="email@uinsaid.ac.id"/>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="prodi" class="block text-sm font-medium text-gray-700 mb-1">Program Studi yang Diampu <span class="text-red-500">*</span></label>
                        <input type="text" name="prodi" id="prodi" value="{{ old('prodi') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition shadow-sm text-gray-900 hover:border-green-400"
                            placeholder="Contoh: Manajemen Pendidikan Islam"/>
                        @error('prodi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-1">Fakultas <span class="text-red-500">*</span></label>
                        <select name="fakultas" id="fakultas" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition shadow-sm text-gray-900 hover:border-green-400">
                            <option value="" disabled {{ old('fakultas') ? '' : 'selected' }}>Pilih Fakultas</option>
                            {{-- Options populated by JavaScript --}}
                        </select>
                        @error('fakultas')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <h3 class="text-lg font-semibold text-gray-800 pt-4 border-t mt-6">Data Akun (Wajib Diisi)</h3>

                    <div class="relative">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" id="password" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 transition shadow-sm text-gray-900 pr-10"
                            placeholder="Minimal 8 karakter"/>
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 top-6 pt-1.5 flex items-center pr-3 text-gray-500 hover:text-yellow-600 transition" aria-label="Show password">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 transition shadow-sm text-gray-900 pr-10"
                            placeholder="Ulangi password"/>
                        <button type="button" id="togglePasswordConfirmation" class="absolute inset-y-0 right-0 top-6 pt-1.5 flex items-center pr-3 text-gray-500 hover:text-yellow-600 transition" aria-label="Show password confirmation">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </div>

                    <div class="flex justify-between pt-6">
                        <a href="{{ route('admin.kaprodi') }}"
                            class="inline-flex items-center gap-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-3 rounded-lg shadow-sm transition duration-150">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
                        </a>

                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-3 rounded-lg shadow-sm transition duration-150 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-50">
                            <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Kaprodi
                        </button>
                    </div>

                </form>
            </div>
        </main>
    </div>

    {{-- Footer (Dihilangkan untuk brevity, Anda bisa menambahkannya kembali dari kode sebelumnya) --}}
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
                    <li><a href="/user/dashboard#beranda" class="flex items-center gap-2 hover:text-white transition duration-300 ease-in-out"><i data-lucide="info" class="w-4 h-4"></i> Beranda (User)</a></li>
                    <li><a href="/user/dashboard#tentang" class="flex items-center gap-2 hover:text-white transition duration-300 ease-in-out"><i data-lucide="info" class="w-4 h-4"></i> Tentang Tracer</a></li>
                    <li><a href="/user/kuisioner" class="flex items-center gap-2 hover:text-white transition duration-300 ease-in-out"><i data-lucide="clipboard-check" class="w-4 h-4"></i> Isi Kuesioner</a></li>
                    <li><a href="/user/cari-alumni" class="flex items-center gap-2 hover:text-white transition duration-300 ease-in-out"><i data-lucide="search" class="w-4 h-4"></i> Cari Alumni</a></li>
                </ul>
            </div>
            <div>
                <h2 class="text-xl font-bold mb-4 font-['Poppins']">Tautan Terkait</h2>
                <ul class="space-y-3 text-green-200">
                    <li><a href="https://uinsaid.ac.id" target="_blank" rel="noopener noreferrer" class="hover:underline flex items-center gap-2"><i data-lucide="globe" class="w-4 h-4"></i> Website Resmi UIN RMS</a></li>
                    <li><a href="https://pmb.uinsaid.ac.id" target="_blank" rel="noopener noreferrer" class="hover:underline flex items-center gap-2"><i data-lucide="graduation-cap" class="w-4 h-4"></i> PMB UIN RMS</a></li>
                    <li><a href="https://e-journal.uinsaid.ac.id/" target="_blank" rel="noopener noreferrer" class="hover:underline flex items-center gap-2"><i data-lucide="book-text" class="w-4 h-4"></i> E-Journal UIN RMS</a></li>
                </ul>
            </div>
            <div>
                <h2 class="text-xl font-bold mb-4 font-['Poppins']">Kontak Kami</h2>
                <ul class="text-green-200 space-y-3">
                    <li><i data-lucide="mail" class="inline-block w-4 h-4 mr-2"></i> <a href="mailto:tracer@uinsaid.ac.id" class="hover:underline" target="_blank">tracer@uinsaid.ac.id</a></li>
                    <li><i data-lucide="phone" class="inline-block w-4 h-4 mr-2"></i> (0271) 678901</li>
                    <li><i data-lucide="instagram" class="inline-block w-4 h-4 mr-2"></i> <a href="#" class="hover:underline" target="_blank">@traceruinrms</a></li>
                    <li><i data-lucide="map-pin" class="inline-block w-4 h-4 mr-2"></i> Jl. Pandawa, Pucangan, Kartasura, Sukoharjo, Jawa Tengah 57168</li>
                </ul>
            </div>
        </div>
        <div class="text-center text-green-300 text-xs border-t border-green-800 py-6 mt-12">
            &copy; 2025 UIN Raden Mas Said Surakarta. Hak Cipta Dilindungi Undang-Undang.
        </div>
    </footer>

    {{-- Scroll to Top Button --}}
    <button id="scrollTop" aria-label="Scroll to top"
        class="fixed bottom-6 right-6 z-50 hidden bg-green-700 hover:bg-green-800 text-white p-3 rounded-full shadow-xl transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-green-400">
        <iconify-icon icon="mdi:arrow-up-bold" class="w-6 h-6"></iconify-icon>
    </button>

    {{-- Scripts --}}
    <script>
        // Data Fakultas untuk dropdown Fakultas
        const FAKULTAS_LIST = [
            "Fakultas Adab dan Bahasa",
            "Fakultas Ekonomi Dan Bisnis Islam",
            "Fakultas Ilmu Tarbiyah",
            "Fakultas Ushuluddin dan Dakwah",
            "Fakultas Syariah"
        ];

        // Preserve server-side old value (if any)
        const SELECTED_FAKULTAS = "{{ old('fakultas') ?? '' }}";

        function populateFakultas() {
            const fakultasSelect = document.getElementById('fakultas');
            if (!fakultasSelect) return;
            // Remove existing dynamic options (keep placeholder)
            // (Assumes first option is placeholder)
            while (fakultasSelect.options.length > 1) {
                fakultasSelect.remove(1);
            }
            FAKULTAS_LIST.forEach(fakultasName => {
                const option = document.createElement('option');
                option.value = fakultasName;
                option.textContent = fakultasName;
                if (SELECTED_FAKULTAS && SELECTED_FAKULTAS === fakultasName) {
                    option.selected = true;
                }
                fakultasSelect.appendChild(option);
            });
        }

        function updateTime() {
            const currentDateElement = document.getElementById('currentDate');
            const currentTimeElement = document.getElementById('currentTime');
            const now = new Date();
            const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const formattedDate = now.toLocaleDateString('id-ID', optionsDate);
            const formattedTime = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

            if (currentDateElement && currentTimeElement) {
                currentDateElement.textContent = formattedDate;
                currentTimeElement.textContent = formattedTime + ' WIB';
            }
        }

        function setupPasswordToggle(toggleId, inputId) {
            const toggleButton = document.getElementById(toggleId);
            const inputField = document.getElementById(inputId);
            if (toggleButton && inputField) {
                const icon = toggleButton.querySelector('i');
                toggleButton.addEventListener('click', () => {
                    const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
                    inputField.setAttribute('type', type);

                    if (type === 'text') {
                        icon.setAttribute('data-lucide', 'eye-off');
                    } else {
                        icon.setAttribute('data-lucide', 'eye');
                    }
                    lucide.createIcons();
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateTime();
            setInterval(updateTime, 1000);

            lucide.createIcons();

            // Populate fakultas dropdown
            populateFakultas();

            // Setup Password Toggle untuk kedua field password
            setupPasswordToggle('togglePassword', 'password');
            setupPasswordToggle('togglePasswordConfirmation', 'password_confirmation');


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
        });
    </script>
</body>

</html>
