<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Manajemen Kaprodi - UIN Raden Mas Said</title>
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
            position: fixed; top: 0; left: 0; width: 100%; max-width: 256px;
            height: 100vh; transform: translateX(-100%); transition: transform 0.3s ease-in-out;
            z-index: 50; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            display: flex; flex-direction: column;
        }
        #sidebar.open { transform: translateX(0); }
        @media (min-width: 768px) {
            #sidebar {
                position: sticky; transform: translateX(0); flex-shrink: 0;
                width: 256px; height: 100vh; z-index: 30;
            }
        }
        #sidebar-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.5); z-index: 40; display: none;
        }
    </style>
</head>

<body class="bg-green-50 min-h-screen flex flex-col">

    {{-- Main wrapper for sidebar and content --}}
    <div class="flex flex-1 flex-col md:flex-row">

        {{-- Sidebar (Diambil dari dashboard_admin.html) --}}
        <aside id="sidebar" class="bg-gradient-to-b from-green-900 via-green-800 to-green-700 text-white">
            <div class="p-5 border-b border-green-700 text-center select-none bg-green-950">
                <h2 class="text-xl font-extrabold tracking-wide font-['Poppins']">Admin Panel</h2>
            </div>
            <nav class="px-4 py-6 flex flex-col space-y-3 flex-1">
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

            {{-- Header/Title Section --}}
            <header class="mb-8 p-4 bg-white rounded-xl shadow-md flex items-center justify-between animate-fade-in">
                <div>
                    <h1 class="text-3xl lg:text-4xl font-extrabold text-green-800 tracking-tight font-['Poppins']">
                        Manajemen Ketua Program Studi (Kaprodi)
                    </h1>
                    <p class="text-green-700 text-lg mt-1">Kelola data Kaprodi yang bertanggung jawab atas program studi.</p>
                </div>
                <div class="flex flex-col items-end">
                    <p class="text-sm font-semibold text-gray-700" id="currentDate"></p>
                    <p class="text-sm text-gray-600" id="currentTime"></p>
                </div>
            </header>

            <div class="container mx-auto bg-white rounded-2xl shadow-2xl border border-gray-200 flex-1">

                {{-- Mock Success/Error Alerts (Placeholder) --}}
                <!--
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">Simulasi Error: KaprodiController berhasil dimuat.</span>
                </div>
                -->

                <div class="p-6 pb-4 border-b border-gray-200 bg-gray-50 rounded-t-2xl">
                    <div class="flex flex-wrap justify-between items-center mb-4 gap-3">
                         <h2 class="text-xl font-bold text-gray-800">Daftar Kaprodi</h2>
                         <a href="/admin/kaprodi/create"
                            class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 transition text-white font-semibold py-2 px-4 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-green-500 transform hover:scale-[1.03] text-sm">
                             <i data-lucide="user-plus" class="w-5 h-5"></i>
                             Tambah Kaprodi Baru
                         </a>
                    </div>

                    {{-- Search Form (Placeholder) --}}
                    <form action="/admin/kaprodi" method="GET" class="flex flex-col sm:flex-row items-center gap-4">
                        <div class="relative w-full sm:flex-grow">
                            <input type="text" name="cari" placeholder="Cari nama / email / prodi..."
                                        value="{{ request('cari') }}"
                                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-gray-900 placeholder-gray-500 transition text-sm shadow-sm" />
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 iconify" data-icon="mdi:magnify"></span>
                        </div>
                        <button type="submit"
                                class="flex items-center justify-center gap-2 bg-green-700 hover:bg-green-800 text-white font-semibold py-2.5 px-6 rounded-lg shadow-md transition transform hover:-translate-y-0.5 w-full sm:w-auto">
                            <span class="iconify" data-icon="mdi:filter-variant" style="font-size: 18px;"></span>
                            Filter
                        </button>
                    </form>
                </div>

                {{-- Data Table --}}
                <div class="overflow-x-auto p-6 pt-0">
                    <table class="min-w-full divide-y divide-gray-200 text-gray-800 text-sm">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider rounded-tl-lg text-green-800 font-bold">Nama</th>
                                <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Email</th>
                                <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Program Studi</th>
                                <th class="px-5 py-4 text-left whitespace-nowrap text-xs uppercase tracking-wider text-green-800 font-bold">Fakultas</th>
                                <th class="px-5 py-4 text-center whitespace-nowrap text-xs uppercase tracking-wider rounded-tr-lg text-green-800 font-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($kaprodiList as $kaprodi)
                                <tr class="odd:bg-white even:bg-green-50 hover:bg-green-100 transition duration-150 ease-in-out">
                                    <td class="px-5 py-3.5 whitespace-nowrap font-semibold text-gray-800">{{ $kaprodi->name }}</td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-gray-600">{{ $kaprodi->email }}</td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-gray-600">{{ $kaprodi->prodi ?? '-' }}</td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-gray-600">{{ $kaprodi->fakultas ?? '-' }}</td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-center flex justify-center gap-2 items-center">
                                        <a href="{{ route('admin.kaprodi.edit', $kaprodi->id) }}"
                                           class="text-white bg-blue-600 hover:bg-blue-700 p-2 text-xs rounded-lg shadow-md transition transform hover:scale-105 flex items-center justify-center gap-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           title="Edit Data">
                                            <span class="iconify" data-icon="mdi:pencil" style="font-size: 14px;"></span>
                                            <span class="hidden sm:inline">Edit</span>
                                        </a>
                                        <form action="{{ route('admin.kaprodi.destroy', $kaprodi->id) }}" method="POST" onsubmit="return confirm('Anda yakin menghapus Kaprodi?');">
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
                                    <td colspan="5" class="text-center py-12 text-gray-500 italic bg-gray-50 rounded-b-lg">
                                        <img src="https://www.svgrepo.com/show/472628/no-data.svg" alt="No Data" class="w-36 h-36 mx-auto mb-5 opacity-60">
                                        <p class="text-lg font-medium">Data Kaprodi Tidak Ditemukan</p>
                                        <p class="text-sm mt-1">Tidak ada pengguna dengan peran 'kaprodi' di database.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                 {{-- Pagination Links --}}
                 <div class="mt-4 p-6 flex justify-center border-t border-gray-100">
                     @if(isset($kaprodiList) && method_exists($kaprodiList, 'links'))
                        {{ $kaprodiList->links() }}
                     @endif
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
                        <a href="/user/dashboard#beranda" class="flex items-center gap-2 hover:text-white transition duration-300 ease-in-out">
                            <i data-lucide="info" class="w-4 h-4"></i> Beranda (User)
                        </a>
                    </li>
                    <li>
                        <a href="/user/dashboard#tentang" class="flex items-center gap-2 hover:text-white transition duration-300 ease-in-out">
                            <i data-lucide="info" class="w-4 h-4"></i> Tentang Tracer
                        </a>
                    </li>
                    <li>
                        <a href="/user/kuisioner" class="flex items-center gap-2 hover:text-white transition duration-300 ease-in-out">
                            <i data-lucide="clipboard-check" class="w-4 h-4"></i> Isi Kuesioner
                        </a>
                    </li>
                    <li>
                        <a href="/user/cari-alumni" class="flex items-center gap-2 hover:text-white transition duration-300 ease-in-out">
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
            &copy; 2025 UIN Raden Mas Said Surakarta. Hak Cipta Dilindungi Undang-Undang.

        </div>
    </footer>

    {{-- Scroll to Top Button --}}
    <button id="scrollTop" aria-label="Scroll to top"
        class="fixed bottom-6 right-6 z-50 hidden bg-green-700 hover:bg-green-800 text-white p-3 rounded-full shadow-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-500">
        <iconify-icon icon="mdi:arrow-up-bold" class="w-6 h-6"></iconify-icon>
    </button>

    {{-- Scripts --}}
    <script>
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

        document.addEventListener('DOMContentLoaded', function() {
            updateTime();
            setInterval(updateTime, 1000);

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
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }
        });
    </script>
</body>

</html>
