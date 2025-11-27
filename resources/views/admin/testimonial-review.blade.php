<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Manajemen Testimoni - Admin UIN Raden Mas Said</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" type="image/png" href="{{ asset('img/uin.png') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* Global Styles */
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4 { font-family: 'Poppins', sans-serif; }
        .sidebar-link { transition: background-color 0.2s; }

        /* Sidebar specific styles */
        #sidebar {
            position: fixed; top: 0; left: 0; width: 100%; max-width: 256px; height: 100vh;
            transform: translateX(-100%); transition: transform 0.3s ease-in-out; z-index: 50;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            display: flex; flex-direction: column;
        }
        #sidebar.open { transform: translateX(0); }
        @media (min-width: 768px) {
            #sidebar { position: sticky; transform: translateX(0); flex-shrink: 0; width: 256px; height: 100vh; z-index: 30; }
        }
        #sidebar-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.5); z-index: 40; display: none;
        }

        /* Modal specific styles */
        .modal-container { display: none; position: fixed; inset: 0; background-color: rgba(0, 0, 0, 0.7); z-index: 9999; place-items: center; }
        .modal-container.active { display: grid; }
        .img-preview { max-width: 90vw; max-height: 90vh; border-radius: 0.75rem; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5); }
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
                    {{-- Parent link: Hapus border-red-600 yang lama --}}
                    <a href="javascript:void(0)" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-semibold text-sm bg-white bg-opacity-10 shadow-sm group active-parent">
                        <iconify-icon icon="mdi:message-badge-outline" class="w-5 h-5 text-red-300"></iconify-icon>
                        <span>Manajemen Testimoni</span>
                    </a>
                    <div class="pl-6 space-y-1 border-l ml-3 border-red-500">
                        {{-- Link 1: Review (ACTIVE) --}}
                        <a href="{{ route('admin.testimonials.review') }}"
                            class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-white font-normal text-xs {{ Request::routeIs('admin.testimonials.review') ? 'bg-white bg-opacity-20 shadow-md font-semibold border border-red-600' : 'hover:bg-white/10' }}">
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
        <main class="flex-1 p-4 sm:p-6 lg:p-8 flex flex-col">
            {{-- Top Bar for Mobile/Tablet --}}
            <div class="flex justify-between items-center mb-6 md:hidden w-full">
                <button id="sidebarToggle" class="text-white bg-green-700 p-2.5 rounded-md shadow-md hover:bg-green-800 transition-colors focus:outline-none focus:ring-2 focus:ring-green-600">
                    <iconify-icon icon="mdi:menu" class="w-5 h-5"></iconify-icon>
                </button>
                <div class="flex items-center gap-3">
                    <span class="text-base font-semibold text-green-900">Halo, Admin!</span>
                    <img src="https://via.placeholder.com/36/065f46/ffffff?text=AD" alt="Admin Avatar" class="w-9 h-9 rounded-full border-2 border-green-700 shadow-md">
                </div>
            </div>

            {{-- Header/Title Section --}}
            <header class="mb-8 p-4 bg-white rounded-xl shadow-md flex items-center justify-between">
                <div>
                    <h1 class="text-3xl lg:text-4xl font-extrabold text-red-700 tracking-tight font-['Poppins']">
                        Review Testimoni Alumni
                    </h1>
                    <p class="text-gray-600 text-lg mt-1">Daftar testimoni yang menunggu persetujuan untuk ditampilkan di dashboard.</p>
                </div>
            </header>

            <div class="container mx-auto bg-white rounded-2xl shadow-2xl border border-gray-200 flex-1">

                {{-- Alerts --}}
                @if(session('success'))
                    <div class="px-6 pt-6">
                        <div class="flex items-center gap-3 bg-green-100 border border-green-300 text-green-800 px-5 py-4 rounded-xl shadow-sm justify-between" role="alert">
                            <p class="font-medium flex items-center gap-2"><i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('success') }}</p>
                        </div>
                    </div>
                @endif
                @if(session('error'))
                    <div class="px-6 pt-6">
                        <div class="flex items-center gap-3 bg-red-100 border border-red-300 text-red-800 px-5 py-4 rounded-xl shadow-sm justify-between" role="alert">
                            <p class="font-medium flex items-center gap-2"><i data-lucide="x-circle" class="w-5 h-5"></i> {{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                {{-- Admin Actions and Stats --}}
                <div class="p-6 pb-4 border-b border-gray-200 bg-red-50 rounded-t-2xl flex justify-between items-center">
                    <h3 class="text-lg font-bold text-red-700">Testimoni Belum Disetujui ({{ $testimonialsToReview->total() ?? 0 }})</h3>

                </div>

                {{-- Testimonials List --}}
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse ($testimonialsToReview as $alumni)
                        <div class="bg-white p-5 rounded-xl shadow-lg border border-red-200">

                            <p class="text-2xl font-bold text-red-700 mb-3 flex items-center gap-2">
                                <i data-lucide="quote" class="w-6 h-6"></i> Testimoni Baru
                            </p>

                            <blockquote class="text-lg italic text-gray-700 border-l-4 border-red-400 pl-4 mb-4">
                                "{{ $alumni->testimonial_quote }}"
                            </blockquote>

                            <p class="text-sm font-semibold text-gray-800">
                                Oleh: {{ $alumni->nama }} (ID: {{ $alumni->user_id }})
                            </p>
                            <p class="text-xs text-gray-500">
                                Lulus: {{ $alumni->tahun_keluar ?? '-' }} | {{ $alumni->tempat_bekerja ?? 'Belum Bekerja' }}
                            </p>

                            <div class="mt-5 pt-4 border-t border-gray-100 flex justify-between items-center">

                                {{-- Tombol Setujui --}}
                                <form action="{{ route('admin.testimonials.approve', $alumni->user_id) }}" method="POST" onsubmit="return confirm('Setujui testimoni ini?');">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-full shadow-md text-sm transition transform hover:-translate-y-0.5">
                                        <i data-lucide="check-circle" class="w-4 h-4"></i> Setujui & Publikasi
                                    </button>
                                </form>

                                {{-- Tombol Tolak/Hapus --}}
                                <form action="{{ route('admin.testimonials.reject', $alumni->user_id) }}" method="POST" onsubmit="return confirm('Tolak dan pindahkan testimoni ini ke daftar ditolak?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-full shadow-md text-sm transition transform hover:-translate-y-0.5">
                                        <i data-lucide="x-circle" class="w-4 h-4"></i> Tolak
                                    </button>
                                </form>

                            </div>
                        </div>
                        @empty
                        <div class="md:col-span-2 text-center py-10 bg-gray-50 rounded-xl">
                            <i data-lucide="thumbs-up" class="w-12 h-12 text-gray-400 mx-auto mb-3"></i>
                            <p class="text-lg text-gray-500 font-semibold">Tidak ada testimoni yang menunggu persetujuan saat ini.</p>
                            <p class="text-sm text-gray-400 mt-1">Semua sudah ditinjau!</p>
                        </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if ($testimonialsToReview->lastPage() > 1)
                    <div class="mt-8">
                        {{ $testimonialsToReview->links('pagination::tailwind') }}
                    </div>
                    @endif
                </div>

            </div>
        </main>
    </div>

    {{-- Footer --}}
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
                        <a href="{{ route('admin.dashboard') }}#beranda" class="flex items-center gap-2 hover:text-white transition duration-300 ease-in-out">
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
                        <span>Jl. Pandawa, Pucangan, Kartasura, Sukoharjo, Jawa Tengah 57168</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="text-center text-green-300 text-xs border-t border-green-800 py-6 mt-12">
            &copy; {{ date('Y') }} UIN Raden Mas Said Surakarta. Hak Cipta Dilindungi Undang-Undang.

        </div>
    </footer>

    <button id="scrollTop" aria-label="Scroll to top"
        class="fixed bottom-6 right-6 z-50 hidden bg-green-700 hover:bg-green-800 text-white p-3 rounded-full shadow-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-500">
        <iconify-icon icon="mdi:arrow-up-bold" class="w-6 h-6"></iconify-icon>
    </button>

    <script>
        // Scripts
        function openPhotoModal(imageUrl, alumniName) {
            const modal = document.getElementById('photo-modal');
            const photoElement = document.getElementById('modal-photo');

            photoElement.src = imageUrl;
            photoElement.alt = 'Foto Profil ' + alumniName;

            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closePhotoModal() {
            const modal = document.getElementById('photo-modal');
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar logic
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

            // Accordion functionality for FAQ
            document.querySelectorAll('.accordion-toggle').forEach(button => {
                button.addEventListener('click', () => {
                    const content = button.nextElementSibling;
                    const icon = button.querySelector('i[data-lucide="chevron-down"]');

                    document.querySelectorAll('.accordion-content.active').forEach(openContent => {
                        if (openContent !== content) {
                            openContent.classList.remove('active');
                            openContent.previousElementSibling.querySelector('i[data-lucide="chevron-down"]').classList.remove('rotate-180');
                        }
                    });

                    content.classList.toggle('active');
                    icon.classList.toggle('rotate-180');
                });
            });

            // Initialize Lucide icons
            lucide.createIcons();
        });
    </script>
</body>

</html>
