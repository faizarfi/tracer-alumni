@extends('layouts.kaprodi') {{-- Menggunakan template utama Anda --}}

@section('title', 'Panduan & Bantuan')

@section('head_extras')
<style>
    /* FAQ Animation & Accordion Logic */
    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out, padding 0.3s ease;
    }
    .faq-item.active .faq-answer {
        max-height: 1000px; /* Nilai besar agar konten panjang tidak terpotong */
        padding: 1.25rem;
        border-top: 1px solid #d1fae5;
    }
    .faq-item.active .faq-icon {
        transform: rotate(180deg);
    }
    .faq-item.active .faq-question {
        background-color: #ecfdf5; /* emerald-50 */
    }

    /* Smooth Scroll Padding */
    html { scroll-padding-top: 100px; }
</style>
@endsection

@section('content')

    {{-- Header Section Responsif --}}
    <header class="mb-6 p-4 bg-white rounded-xl shadow-md flex flex-col md:flex-row md:items-center justify-between gap-4 animate-fade-in">
        <div class="flex items-center">
            {{-- Tombol Menu untuk HP --}}
            <button id="sidebarToggle" class="mr-3 text-green-700 md:hidden p-2 rounded-lg hover:bg-green-100 transition duration-150">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button>
            <div>
                <h1 class="text-xl lg:text-2xl font-extrabold text-green-800 tracking-tight font-['Poppins']">
                    Pusat Bantuan Kaprodi
                </h1>
                <p class="text-gray-600 text-xs md:text-sm mt-1 uppercase font-bold tracking-wider opacity-70">Sistem Tracer Study UIN RMS</p>
            </div>
        </div>
        <div class="flex items-center gap-2 bg-green-50 px-4 py-2 rounded-full border border-green-100 w-fit self-center">
            <i data-lucide="help-circle" class="w-4 h-4 text-green-600"></i>
            <span class="text-[10px] font-bold text-green-700 uppercase">Dokumentasi Sistem</span>
        </div>
    </header>

    {{-- Navigasi Cepat (Tombol-Tombol Shortcut) --}}
    <section class="mb-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <a href="#faq-section" class="group flex flex-col p-5 bg-white rounded-2xl shadow-sm border-l-4 border-indigo-500 hover:shadow-md transition-all">
            <span class="text-[10px] font-bold text-indigo-600 uppercase mb-1">Butuh Jawaban?</span>
            <span class="text-base font-bold text-gray-700 flex items-center justify-between">
                Tanya Jawab (FAQ) <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-all"></i>
            </span>
        </a>
        <a href="#interpretasi-section" class="group flex flex-col p-5 bg-white rounded-2xl shadow-sm border-l-4 border-yellow-500 hover:shadow-md transition-all">
            <span class="text-[10px] font-bold text-yellow-600 uppercase mb-1">Pahami Grafik</span>
            <span class="text-base font-bold text-gray-700 flex items-center justify-between">
                Cara Baca Data <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-all"></i>
            </span>
        </a>
        <a href="{{ route('kaprodi.alumni') }}" class="group flex flex-col p-5 bg-white rounded-2xl shadow-sm border-l-4 border-emerald-500 hover:shadow-md transition-all">
            <span class="text-[10px] font-bold text-emerald-600 uppercase mb-1">Lihat Profil</span>
            <span class="text-base font-bold text-gray-700 flex items-center justify-between">
                Manajemen Alumni <i data-lucide="arrow-right" class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-all"></i>
            </span>
        </a>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Kolom Utama: Dokumentasi & FAQ --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- Bagian FAQ --}}
            <section id="faq-section" class="bg-white p-6 md:p-8 rounded-3xl shadow-xl border border-gray-100 animate-fade-in">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                    <i data-lucide="messages-square" class="w-6 h-6 text-indigo-600"></i> Pertanyaan Umum (FAQ)
                </h2>

                <div class="space-y-4">
                    {{-- Item 1 --}}
                    <div class="faq-item border border-gray-100 rounded-2xl overflow-hidden transition-all duration-300">
                        <div class="faq-question flex items-center justify-between p-5 bg-gray-50/50 cursor-pointer hover:bg-green-50/50 transition-colors">
                            <span class="text-sm font-bold text-gray-700 leading-tight">Apa perbedaan antara 'Total Alumni' dan 'Total Responden'?</span>
                            <i data-lucide="chevron-down" class="faq-icon w-4 h-4 text-gray-400 transition-transform"></i>
                        </div>
                        <div class="faq-answer bg-white">
                            <p class="text-sm text-gray-600 leading-relaxed">
                                <b class="text-green-700 font-extrabold">Total Alumni</b> adalah seluruh jumlah lulusan yang terdaftar di database sistem prodi Anda. <br><br>
                                <b class="text-green-700 font-extrabold">Total Responden</b> adalah jumlah alumni yang sudah **mengisi Kuesioner**. Grafik statistik hanya akan muncul berdasarkan data dari Responden ini.
                            </p>
                        </div>
                    </div>

                    {{-- Item 2 --}}
                    <div class="faq-item border border-gray-100 rounded-2xl overflow-hidden transition-all duration-300">
                        <div class="faq-question flex items-center justify-between p-5 bg-gray-50/50 cursor-pointer hover:bg-green-50/50 transition-colors">
                            <span class="text-sm font-bold text-gray-700 leading-tight">Mengapa grafik saya terlihat kosong atau data tidak muncul?</span>
                            <i data-lucide="chevron-down" class="faq-icon w-4 h-4 text-gray-400 transition-transform"></i>
                        </div>
                        <div class="faq-answer bg-white">
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Hal ini biasanya terjadi jika **belum ada alumni** di program studi Anda yang mengisi kuesioner. Sistem membutuhkan minimal 1 data kuesioner untuk mulai membangun visualisasi grafik.
                            </p>
                        </div>
                    </div>

                    {{-- Item 3 --}}
                    <div class="faq-item border border-gray-100 rounded-2xl overflow-hidden transition-all duration-300">
                        <div class="faq-question flex items-center justify-between p-5 bg-gray-50/50 cursor-pointer hover:bg-green-50/50 transition-colors">
                            <span class="text-sm font-bold text-gray-700 leading-tight">Bagaimana cara mengunduh laporan kuesioner prodi saya?</span>
                            <i data-lucide="chevron-down" class="faq-icon w-4 h-4 text-gray-400 transition-transform"></i>
                        </div>
                        <div class="faq-answer bg-white">
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Anda dapat mengklik tombol <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded font-bold text-[10px]">EXPORT CSV</span> yang ada di header halaman Laporan Kuesioner. File tersebut dapat dibuka menggunakan Microsoft Excel.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Bagian Interpretasi Data --}}
            <section id="interpretasi-section" class="bg-white p-6 md:p-8 rounded-3xl shadow-xl border border-gray-100 animate-fade-in">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                    <i data-lucide="trending-up" class="w-6 h-6 text-yellow-600"></i> Cara Membaca Grafik (Literasi Data)
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-5 bg-blue-50 rounded-2xl border border-blue-100">
                        <h3 class="text-xs font-black text-blue-700 uppercase tracking-widest mb-2">Relevansi Kerja (P1)</h3>
                        <p class="text-xs text-gray-600 leading-relaxed">
                            Mengukur tingkat keselarasan antara ilmu yang dipelajari di prodi dengan pekerjaan alumni saat ini.
                            <span class="block mt-2 font-bold text-blue-800 italic">Target Akreditasi: > 70% Relevan.</span>
                        </p>
                    </div>

                    <div class="p-5 bg-emerald-50 rounded-2xl border border-emerald-100">
                        <h3 class="text-xs font-black text-emerald-700 uppercase tracking-widest mb-2">Employability Rate</h3>
                        <p class="text-xs text-gray-600 leading-relaxed">
                            Persentase alumni yang bekerja atau melanjutkan studi. Semakin cepat waktu tunggu kerja, semakin baik kualitas lulusan.
                        </p>
                    </div>
                </div>
            </section>
        </div>

        {{-- Kolom Kanan: Support & Navigasi --}}
        <aside class="space-y-6">
            <div class="bg-gray-900 rounded-3xl p-8 text-white shadow-2xl relative overflow-hidden group">
                {{-- Dekorasi Latar --}}
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-green-500/20 rounded-full blur-3xl group-hover:bg-green-500/40 transition-all duration-500"></div>

                <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <i data-lucide="life-buoy" class="w-5 h-5 text-green-400"></i> Bantuan Teknis
                </h2>
                <p class="text-xs text-gray-400 leading-relaxed mb-6">
                    Jika Anda menemukan kendala akses data atau kesalahan pada nama Program Studi, silakan hubungi administrator pusat.
                </p>
                <div class="space-y-3">
                    <a href="mailto:it-tracer@uinsaid.ac.id" class="flex items-center gap-3 p-3 bg-white/5 rounded-xl hover:bg-white/10 transition border border-white/10">
                        <i data-lucide="mail" class="w-4 h-4 text-green-400"></i>
                        <span class="text-xs font-medium">it-tracer@uinsaid.ac.id</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 bg-white/5 rounded-xl hover:bg-white/10 transition border border-white/10">
                        <i data-lucide="phone" class="w-4 h-4 text-green-400"></i>
                        <span class="text-xs font-medium">(0271) 781-XXX</span>
                    </a>
                </div>
            </div>

            {{-- Card Info Status --}}
            <div class="bg-white p-6 rounded-3xl shadow-lg border border-gray-100">
                <h2 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-widest opacity-50">Status Sistem</h2>
                <div class="flex items-center gap-3 p-3 bg-green-50 rounded-2xl border border-green-100">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    <span class="text-xs font-bold text-green-800 uppercase">Server Online</span>
                </div>
            </div>
        </aside>
    </div>

    <footer class="text-center text-gray-400 text-[10px] mt-12 mb-8 uppercase tracking-widest">
        &copy; {{ date('Y') }} UIN Raden Mas Said Surakarta &bull; Tracer Study Support
    </footer>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');

                question.addEventListener('click', () => {
                    const isActive = item.classList.contains('active');

                    // Tutup FAQ yang sedang terbuka lainnya (Mode Accordion)
                    faqItems.forEach(i => i.classList.remove('active'));

                    // Buka yang baru saja diklik jika sebelumnya tidak aktif
                    if (!isActive) {
                        item.classList.add('active');
                    }
                });
            });

            // Inisialisasi Ikon Lucide
            lucide.createIcons();
        });
    </script>
@endsection
