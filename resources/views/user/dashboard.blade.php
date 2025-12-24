@extends('layouts.user')

@section('title', 'Dashboard Alumni Premium - UIN Raden Mas Said')

@section('content')
<div class="flex-1">

    {{-- 1. BERANDA / HERO SECTION --}}
    <section id="beranda" class="relative overflow-hidden text-center py-28 bg-white flex-shrink-0 shadow-inner">
        <div class="absolute inset-0 bg-cover bg-center opacity-15 animate-pulse-bg hero-bg-parallax"
            style="background-image: url('https://uinsaid.ac.id/files/post/cover/profil-universitas-1708058171.jpeg');"></div>
        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1
                class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-green-900 leading-tight drop-shadow-md tracking-tight select-none font-['Poppins']">
                Selamat Datang, <span class="text-gradient-green">{{ auth()->user()->name }}</span>!
            </h1>
            <p class="text-lg md:text-xl text-green-700 font-medium mt-4 max-w-2xl mx-auto leading-relaxed">
                Bergabunglah dengan jejaring alumni UIN Raden Mas Said Surakarta. Mari berbagi kisah, pengalaman, dan inspirasi untuk generasi selanjutnya.
            </p>
            <div class="mt-12 flex justify-center">
                <a href="{{ route('user.profil') }}"
                    class="group inline-flex items-center space-x-4 px-10 py-4 bg-green-700 text-white text-lg font-semibold rounded-full shadow-2xl hover:bg-green-800 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
                    <span class="iconify w-7 h-7" data-icon="mdi:account-edit-outline"></span>
                    <span>Perbarui Profil Anda</span>
                </a>
            </div>
        </div>
    </section>

    {{-- 2. QUICK ACCESS & STATS --}}
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-green-50 flex-shrink-0 section-animate">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-center mb-14 text-green-900 font-['Poppins'] section-animate">Akses Cepat Fitur Utama</h2>

            {{-- Quick Access Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center">
                <a href="{{ route('user.profil') }}" class="bg-white p-10 rounded-3xl shadow-xl border border-green-200 hover:bg-green-700 hover:text-white transition-all duration-300 hover-scale-card group section-animate" style="animation-delay: 0.1s;">
                    <span class="iconify w-14 h-14 mx-auto mb-4 text-green-700 group-hover:text-white transition-colors" data-icon="mdi:account-circle-outline"></span>
                    <div class="text-2xl font-semibold group-hover:text-white text-green-900 transition-colors">Profil Alumni</div>
                    <p class="mt-2 text-sm text-gray-600 group-hover:text-green-100 transition-colors">Kelola data pribadi dan informasi kelulusan Anda.</p>
                </a>
                <a href="{{ route('user.kuisioner') }}" class="bg-white p-10 rounded-3xl shadow-xl border border-green-200 hover:bg-green-700 hover:text-white transition-all duration-300 hover-scale-card group section-animate" style="animation-delay: 0.2s;">
                    <span class="iconify w-14 h-14 mx-auto mb-4 text-green-700 group-hover:text-white transition-colors" data-icon="mdi:clipboard-text-outline"></span>
                    <div class="text-2xl font-semibold group-hover:text-white text-green-900 transition-colors">Isi Kuesioner</div>
                    <p class="mt-2 text-sm text-gray-600 group-hover:text-green-100 transition-colors">Bantu kami meningkatkan kualitas pendidikan dengan mengisi kuesioner.</p>
                </a>
                <a href="{{ route('user.cari-alumni') }}" class="bg-white p-10 rounded-3xl shadow-xl border border-green-200 hover:bg-green-700 hover:text-white transition-all duration-300 hover-scale-card group section-animate" style="animation-delay: 0.3s;">
                    <span class="iconify w-14 h-14 mx-auto mb-4 text-green-700 group-hover:text-white transition-colors" data-icon="mdi:magnify"></span>
                    <div class="text-2xl font-semibold group-hover:text-white text-green-900 transition-colors">Cari Alumni</div>
                    <p class="mt-2 text-sm text-gray-600 group-hover:text-green-100 transition-colors">Temukan dan terhubung dengan alumni lain dari UIN Raden Mas Said.</p>
                </a>
            </div>

            {{-- Statistics --}}
            <div class="max-w-4xl mx-auto text-center space-y-12 mt-16">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-green-900 tracking-wide font-['Poppins'] section-animate">Statistik Alumni Terkini</h2>
                <div class="flex flex-wrap justify-center gap-10 mt-10">
                    <div class="bg-white p-8 rounded-3xl shadow-lg border border-green-300 flex flex-col items-center justify-center w-full sm:w-60 md:w-72">
                        <span class="iconify w-16 h-16 text-green-800 mb-3" data-icon="mdi:briefcase-check-outline"></span>
                        <div class="text-xl font-semibold text-green-900">Alumni Sudah Bekerja</div>
                        <div class="text-6xl font-extrabold mt-2 text-green-700">{{ $bekerja ?? 0 }}</div>
                    </div>
                    <div class="bg-white p-8 rounded-3xl shadow-lg border border-green-300 flex flex-col items-center justify-center w-full sm:w-60 md:w-72">
                        <span class="iconify w-16 h-16 text-green-800 mb-3" data-icon="mdi:clipboard-list-outline"></span>
                        <div class="text-xl font-semibold text-green-900">Total Kuesioner Terisi</div>
                        <div class="text-6xl font-extrabold mt-2 text-green-700">{{ $isiKuisioner ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. TENTANG KAMPUS --}}
    <section id="tentang" class="bg-white py-20 px-4 sm:px-6 lg:px-8 shadow-inner">
        <div class="max-w-7xl mx-auto space-y-16">
            <div class="text-center max-w-4xl mx-auto section-animate">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-green-900 tracking-wide font-['Poppins']">Mengapa UIN Raden Mas Said Surakarta?</h2>
                <p class="text-lg text-green-800 mt-5 leading-relaxed">
                    Universitas Islam Negeri Raden Mas Said Surakarta adalah perguruan tinggi Islam negeri terakreditasi unggul yang mengedepankan integrasi ilmu dan nilai-nilai keislaman. Kami berkomitmen mencetak generasi unggul untuk kemajuan bangsa dan dunia.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 text-center">
                @php
                    // Memastikan 13 Fitur ada di sini, sesuai permintaan dari history.
                    $features = [
                        ['icon' => 'mdi:school-outline', 'title' => 'Fasilitas Lengkap', 'desc' => 'Lingkungan kampus modern, asri, dan nyaman.'],
                        ['icon' => 'mdi:book-open-page-variant-outline', 'title' => 'Kurikulum Terkini', 'desc' => 'Sesuai perkembangan ilmu dan kebutuhan dunia kerja.'],
                        ['icon' => 'mdi:account-group-outline', 'title' => 'Jaringan Alumni Kuat', 'desc' => 'Alumni tersebar luas di berbagai sektor strategis.'],
                        ['icon' => 'mdi:earth', 'title' => 'Wawasan Global', 'desc' => 'Kolaborasi internasional dan program pertukaran.'],
                        ['icon' => 'mdi:medal-outline', 'title' => 'Prestasi Unggul', 'desc' => 'Mahasiswa berprestasi di tingkat nasional dan internasional.'],
                        ['icon' => 'mdi:handshake-outline', 'title' => 'Kemitraan Strategis', 'desc' => 'Kerja sama dengan industri, kampus, dan NGO global.'],
                        ['icon' => 'mdi:lightbulb-outline', 'title' => 'Inovasi & Riset', 'desc' => 'Penelitian unggulan yang aplikatif dan solutif.'],
                        ['icon' => 'mdi:rocket-outline', 'title' => 'Startup & Technopreneur', 'desc' => 'Dukungan inkubasi startup dan teknologi digital.'],
                        ['icon' => 'mdi:city', 'title' => 'Lokasi Strategis', 'desc' => 'Terletak di jantung kota pendidikan Surakarta.'],
                        ['icon' => 'mdi:heart-outline', 'title' => 'Kampus Ramah', 'desc' => 'Kampus inklusif yang ramah bagi semua kalangan.'],
                        ['icon' => 'mdi:security', 'title' => 'Keamanan Terjamin', 'desc' => 'Keamanan dan ketertiban kampus selalu terjaga.'],
                        ['icon' => 'mdi:book-multiple-outline', 'title' => 'Buku Digital', 'desc' => 'Akses ke ribuan koleksi e-book terbaru.'], // Total 12 items
                        ['icon' => 'mdi:currency-usd', 'title' => 'Biaya Kompetitif', 'desc' => 'Biaya kuliah terjangkau dengan kualitas premium.'], // Total 13 items
                    ];
                @endphp

                @foreach ($features as $feature)
                    <div class="bg-green-50 p-6 rounded-2xl shadow-md border border-green-200 hover-scale-card group flex flex-col items-center section-animate" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                        <span class="iconify w-10 h-10 mx-auto mb-3 text-green-700 group-hover:text-green-900 transition-colors" data-icon="{{ $feature['icon'] }}"></span>
                        <div class="text-base font-semibold text-green-900 transition-colors">{{ $feature['title'] }}</div>
                        <p class="mt-1 text-xs text-gray-600 group-hover:text-gray-700 transition-colors">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 4. GALERI (DATA DARI CONTROLLER) --}}
    <section id="galeri" class="bg-green-50 py-20 px-4 sm:px-6 lg:px-8 section-animate">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-center mb-14 text-green-900 font-['Poppins'] section-animate">Galeri Kegiatan Kampus</h2>
            <p class="text-center text-lg text-gray-700 mb-10 max-w-3xl mx-auto section-animate">
                Jelajahi momen-momen terbaik dan fasilitas unggulan UIN Raden Mas Said Surakarta yang abadi dalam foto.
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

                @forelse($galleries as $gallery)
                <div class="relative overflow-hidden rounded-xl shadow-xl group hover-scale-card section-animate" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                    <img src="{{ Storage::url($gallery->image_path) }}"
                            alt="{{ $gallery->title }}"
                            onerror="this.onerror=null;this.src='https://placehold.co/400x200/9ca3af/ffffff?text=Image+Missing';"
                            class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                        <h3 class="text-white text-lg font-semibold">{{ $gallery->title }}</h3>
                        <p class="text-green-200 text-sm mt-1 line-clamp-2">{{ $gallery->description ?? 'Tidak ada deskripsi.' }}</p>
                        <span class="text-xs text-green-300 mt-1">{{ $gallery->created_at->format('d M Y') }}</span>
                    </div>
                </div>
                @empty
                <div class="lg:col-span-4 text-center py-10 bg-white rounded-xl shadow-md border border-gray-200 section-animate">
                    <i data-lucide="image-off" class="w-12 h-12 text-gray-400 mx-auto mb-3"></i>
                    <p class="text-lg text-gray-500 italic">Galeri belum tersedia. Admin sedang menyiapkan foto-foto terbaik!</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- 5. TESTIMONIALS (CAROUSEL) - DINAMIS --}}
    <section class="bg-white py-20 px-4 sm:px-6 lg:px-8 shadow-inner section-animate">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-green-900 mb-14 font-['Poppins'] section-animate">Apa Kata Alumni Kami?</h2>
            <div class="relative section-animate">
                <div id="testimonial-carousel" class="overflow-hidden">
                    <div class="flex" id="testimonial-container">

                        @php
                            // Mengambil hanya testimoni yang sudah disetujui (seharusnya sudah difilter di Controller)
                            $approvedTestimonials = $testimonials ?? collect();

                            // Duplikasi data untuk loop carousel (membuat 2 set data)
                            $carouselTestimonials = $approvedTestimonials->isNotEmpty() ? $approvedTestimonials->merge($approvedTestimonials) : collect();
                            $actualItems = $approvedTestimonials->count();
                            $totalSlides = $carouselTestimonials->count();
                        @endphp

                        @forelse($carouselTestimonials as $testimonial)
                        <div class="testimonial-item w-full flex-shrink-0 flex justify-center px-4">
                            <div class="bg-green-50 p-8 rounded-2xl shadow-xl border border-green-200 flex flex-col items-center max-w-lg hover-scale-card">
                                {{-- Foto Profil - Menggunakan foto_path dari Model Alumni --}}
                                <img src="{{ $testimonial->foto_path ? Storage::url($testimonial->foto_path) : 'https://placehold.co/150x150/d1d5db/6b7280?text=A' }}"
                                    alt="Alumni Photo"
                                    onerror="this.onerror=null;this.src='https://placehold.co/150x150/d1d5db/6b7280?text=A';"
                                    class="w-24 h-24 rounded-full mb-4 object-cover border-4 border-green-400 shadow-md transition-transform duration-300">

                                <p class="text-gray-700 italic mb-4 text-center text-base line-clamp-4">"{{ $testimonial->testimonial_quote }}"</p>

                                <p class="font-semibold text-green-800 text-lg">- {{ $testimonial->nama ?? 'Alumni UIN' }}, Angkatan {{ $testimonial->tahun_keluar ?? 'N/A' }}</p>

                                <p class="text-sm text-gray-500">{{ $testimonial->tempat_bekerja ?? 'Tidak Dicantumkan' }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="testimonial-item w-full flex-shrink-0 flex justify-center px-4">
                            <div class="bg-gray-50 p-8 rounded-2xl shadow-md border border-gray-200 flex flex-col items-center max-w-lg">
                                <i data-lucide="message-square-off" class="w-12 h-12 text-gray-500 mb-4"></i>
                                <p class="text-gray-700 italic mb-4 text-center text-base">"Belum ada testimoni yang disetujui oleh Admin."</p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>

                <div class="mt-8 flex justify-center space-x-3">
                    <button id="prevTestimonial" class="p-2 rounded-full bg-green-200 text-green-700 hover:bg-green-300 transition-all duration-200 transform hover:scale-110 focus:outline-none focus:ring-2 focus:ring-green-400">
                        <i data-lucide="chevron-left" class="w-6 h-6"></i>
                    </button>
                    <button id="nextTestimonial" class="p-2 rounded-full bg-green-200 text-green-700 hover:bg-green-300 transition-all duration-200 transform hover:scale-110 focus:outline-none focus:ring-2 focus:ring-green-400">
                        <i data-lucide="chevron-right" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- 6. FAQ (ACCORDION) --}}
    <section id="faq" class="bg-green-50 py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-center mb-14 font-['Poppins'] section-animate">Pertanyaan yang Sering Diajukan (FAQ)</h2>

            <div class="space-y-4" id="faq-wrapper">
                <div class="border border-green-200 rounded-xl shadow-md bg-white overflow-hidden section-animate">
                    <button class="flex justify-between items-center w-full p-5 text-left font-semibold text-green-800 bg-green-50 hover:bg-green-100 transition duration-200 accordion-toggle">
                        <span class="flex items-center gap-3"><i data-lucide="help-circle" class="w-5 h-5"></i>Apa itu Tracer Study Alumni?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 transition-transform duration-300 transform"></i>
                    </button>
                    <div class="accordion-content">
                        <div class="p-5 border-t border-green-100 text-gray-700">
                            Tracer Study adalah studi penelusuran lulusan/alumni yang bertujuan untuk mendapatkan informasi terkait pekerjaan, relevansi pendidikan, dan umpan balik untuk peningkatan kualitas kampus. Informasi ini sangat vital untuk akreditasi dan pengembangan mutu pendidikan di UIN Raden Mas Said Surakarta.
                        </div>
                    </div>
                </div>

                <div class="border border-green-200 rounded-xl shadow-md bg-white overflow-hidden section-animate" style="animation-delay: 0.1s;">
                    <button class="flex justify-between items-center w-full p-5 text-left font-semibold text-green-800 bg-green-50 hover:bg-green-100 transition duration-200 accordion-toggle">
                        <span class="flex items-center gap-3"><i data-lucide="clipboard-check" class="w-5 h-5"></i>Mengapa saya harus mengisi kuesioner tracer study?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 transition-transform duration-300 transform"></i>
                    </button>
                    <div class="accordion-content">
                        <div class="p-5 border-t border-green-100 text-gray-700">
                            Partisipasi Anda sangat penting untuk akreditasi program studi dan institusi, serta membantu kami mengevaluasi dan meningkatkan kurikulum agar lebih relevan dengan kebutuhan dunia kerja. Setiap masukan dari alumni sangat berharga untuk kemajuan UIN Raden Mas Said.
                        </div>
                    </div>
                </div>

                <div class="border border-green-200 rounded-lg shadow-sm bg-white overflow-hidden section-animate" style="animation-delay: 0.2s;">
                    <button class="flex justify-between items-center w-full p-5 text-left font-semibold text-green-800 bg-green-50 hover:bg-green-100 transition duration-200 accordion-toggle">
                        <span class="flex items-center gap-3"><i data-lucide="lock" class="w-5 h-5"></i>Apakah data yang saya berikan aman dan rahasia?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 transition-transform duration-300 transform"></i>
                    </button>
                    <div class="accordion-content">
                        <div class="p-5 border-t border-green-100 text-gray-700">
                            Ya, semua data yang Anda berikan akan dijaga kerahasiaannya dengan sangat ketat dan hanya digunakan untuk keperluan statistik dan pengembangan program studi. Kami berkomitmen untuk melindungi privasi Anda.
                        </div>
                    </div>
                </div>

                <div class="border border-green-200 rounded-lg shadow-sm bg-white overflow-hidden section-animate">
                    <button class="flex justify-between items-center w-full p-5 text-left font-semibold text-green-800 bg-green-50 hover:bg-green-100 transition duration-200 accordion-toggle">
                        <span class="flex items-center gap-3"><i data-lucide="user-cog" class="w-5 h-5"></i>Bagaimana cara memperbarui profil alumni?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 transition-transform duration-300 transform"></i>
                    </button>
                    <div class="accordion-content">
                        <div class="p-5 border-t border-green-100 text-gray-700">
                            Anda bisa memperbarui profil Anda dengan mudah. Cukup klik tombol "Perbarui Profil Anda" di bagian atas halaman ini atau navigasi melalui menu "Profil Alumni". Pastikan semua informasi terbaru sudah dimasukkan untuk data yang akurat.
                        </div>
                    </div>
                </div>

                <div class="border border-green-200 rounded-lg shadow-sm bg-white overflow-hidden section-animate">
                    <button class="flex justify-between items-center w-full p-5 text-left font-semibold text-green-800 bg-green-50 hover:bg-green-100 transition duration-200 accordion-toggle">
                        <span class="flex items-center gap-3"><i data-lucide="mail" class="w-5 h-5"></i>Siapa yang bisa saya hubungi jika ada pertanyaan?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 transition-transform duration-300 transform"></i>
                    </button>
                    <div class="accordion-content">
                        <div class="p-5 border-t border-green-100 text-gray-700">
                            Jangan ragu untuk menghubungi tim Tracer Study kami jika Anda memiliki pertanyaan lebih lanjut. Anda bisa mengirimkan email ke <a href="mailto:tracer@uinsaid.ac.id" class="underline text-green-700 hover:text-green-900">tracer@uinsaid.ac.id</a> atau menghubungi kami melalui nomor telepon yang tertera di bagian bawah halaman (footer).
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<style>
    /* CSS untuk Accordion: Menggunakan max-height untuk transisi smooth */
    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }
    .accordion-content.active {
        /* Set ke nilai yang besar agar konten selalu terlihat penuh */
        max-height: 500px;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Initialization ---
        lucide.createIcons();

        // --- Testimonial Carousel Logic (Fixed Infinite Loop) ---
        const actualItems = {{ $actualItems ?? 0 }}; // Jumlah item asli
        const totalSlides = {{ $totalSlides ?? 0 }}; // Jumlah item total (asli + duplikasi)

        if (actualItems > 0 && totalSlides >= actualItems * 2) {
            const carouselContainer = document.getElementById('testimonial-container');
            const prevBtn = document.getElementById('prevTestimonial');
            const nextBtn = document.getElementById('nextTestimonial');

            let currentIndex = actualItems; // Mulai dari set duplikasi kedua (visual index 0)
            let itemWidth = 0;

            const setTransition = (enabled) => {
                carouselContainer.style.transition = enabled ? 'transform 0.5s ease-in-out' : 'none';
            };

            const updateCarouselWidth = () => {
                const carouselWrapper = document.getElementById('testimonial-carousel');
                if (carouselWrapper) {
                    itemWidth = carouselWrapper.clientWidth;
                }
            };

            const updateCarousel = (smooth = true) => {
                updateCarouselWidth();
                setTransition(smooth);
                carouselContainer.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
            };

            const checkBoundary = () => {
                // Jika indeks melewati set duplikasi pertama, langsung lompat ke set kedua tanpa transisi
                if (currentIndex >= actualItems * 2) {
                    currentIndex = actualItems;
                    updateCarousel(false);
                }
                // Jika indeks mundur ke sebelum set duplikasi pertama, lompat ke set terakhir tanpa transisi
                else if (currentIndex < actualItems) {
                    currentIndex = actualItems * 2 - 1;
                    updateCarousel(false);
                }
            };

            // Set posisi awal ke set duplikasi kedua (index `actualItems`)
            updateCarouselWidth();
            updateCarousel(false);

            // Navigasi
            prevBtn.addEventListener('click', () => {
                currentIndex--;
                updateCarousel();
                // Tunggu transisi selesai sebelum cek batas
                if (currentIndex < actualItems) {
                    setTimeout(checkBoundary, 500);
                }
            });

            nextBtn.addEventListener('click', () => {
                currentIndex++;
                updateCarousel();
                // Tunggu transisi selesai sebelum cek batas
                if (currentIndex >= actualItems * 2) {
                    setTimeout(checkBoundary, 500);
                }
            });

            window.addEventListener('resize', () => {
                currentIndex = actualItems; // Reset ke posisi awal set duplikasi
                updateCarousel(false);
            });

            // Auto-advance
            // setInterval(() => {
            //     nextBtn.click();
            // }, 5000);
        }

        // --- FAQ Accordion Functionality (Improved Max-Height Handling) ---
        document.querySelectorAll('.accordion-toggle').forEach(button => {
            const content = button.nextElementSibling;

            // Atur agar konten tertutup secara default
            content.style.maxHeight = '0';

            button.addEventListener('click', () => {
                const icon = button.querySelector('i[data-lucide="chevron-down"]');
                const isOpen = content.classList.contains('active');

                // Tutup semua yang terbuka kecuali yang sedang diklik
                document.querySelectorAll('#faq-wrapper .accordion-content.active').forEach(openContent => {
                    if (openContent !== content) {
                        openContent.classList.remove('active');
                        openContent.style.maxHeight = '0';
                        openContent.previousElementSibling.querySelector('i[data-lucide="chevron-down"]').classList.remove('rotate-180');
                    }
                });

                // Toggle current accordion
                if (!isOpen) {
                    content.classList.add('active');
                    // Setting max-height ke scrollHeight untuk transisi yang akurat
                    content.style.maxHeight = content.scrollHeight + "px";
                    icon.classList.add('rotate-180');
                } else {
                    content.classList.remove('active');
                    content.style.maxHeight = '0';
                    icon.classList.remove('rotate-180');
                }
            });
        });
    });
</script>
@endsection
